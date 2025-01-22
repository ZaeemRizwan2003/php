<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>

<?php
    $link = g('link');
    // Use prepared statements to avoid SQL injection
    $stmt = $con->prepare("SELECT * FROM the_tour WHERE slug = ?");
    $stmt->execute([$link]);
    $detail = $stmt->fetch();
?>

<meta name="author" content="Ansonika">
<title><?= htmlspecialchars($detail->name) ?></title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<main>
    <style>
        .hero_in.tours_detail:before {
            background-image: url('data/tour/<?= htmlspecialchars($detail->picture) ?>');
        }
    </style>
    <section class="hero_in tours_detail">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span> <?= htmlspecialchars($detail->name) ?> </h1>
            </div>
            <span class="magnific-gallery">
                <?php 
                    $i = 0;
                    // Securely get the tour pictures using a prepared statement
                    $stmt = $con->prepare("SELECT * FROM the_tour_picture WHERE tour_id = ?");
                    $stmt->execute([$detail->tour_id]);
                    $pictures = $stmt->fetchAll();
                    $picturesRows = count($pictures);
                    foreach ($pictures as $picture) {
                        $i++;
                        $content = $picture->content ?: $detail->name;
                ?>
                    <a href="data/tour/pictures/<?= htmlspecialchars($picture->big_picture) ?>" <?php if ($i == 1) { echo 'class="btn_photos"';} ?> title="<?= htmlspecialchars($content) ?>" data-effect="mfp-zoom-in">
                        <?php if ($i == 1) { echo 'Tur Resimleri (' . $picturesRows . ' Adet)';} ?>
                    </a>
                <?php } ?>
            </span>
        </div>
    </section>

    <div class="bg_color_1">
        <nav class="secondary_nav sticky_horizontal">
            <div class="container">
                <ul class="clearfix">
                    <li><a href="#description" class="active">Tour Details</a></li>
                    <li><a href="#reviews">Bewertungen</a></li>
                    <li><a href="#sidebar">Rezervasyon</a></li>
                </ul>
            </div>
        </nav>

        <div class="container margin_60_35">
            <div class="row">
                <div class="col-lg-8">
                    <section id="description">
                        <h2>Tour Details</h2>
                        <?= htmlspecialchars($detail->content) ?>
                    </section>

                    <section id="reviews">
                        <!-- Review section, can be added later -->
                    </section>

                    <hr>
                </div>

                <aside class="col-lg-4" id="sidebar">
                    <div class="box_detail booking">
                        <div class="price">
                            <?php 
                                // Get the lowest price securely
                                $stmt = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ? ORDER BY person_price ASC LIMIT 1");
                                $stmt->execute([$detail->tour_id]);
                                $enkucukFiyat = $stmt->fetch();
                            ?>
                            <span><?= htmlspecialchars($enkucukFiyat->person_price) ?> €</span>
                        </div>

                        <form id="rez_one" method="POST" onsubmit="return false" action="" class="user-form payment">
                            <input type="hidden" name="rez_type" value="tour">
                            <input type="hidden" name="tour_id" value="<?= htmlspecialchars($detail->tour_id) ?>">
                            <div class="form-group clearfix">
                                <div class="custom-select-form">
                                    <select class="wide" name="tour_dates">
                                        <option value="0">Datum auswählen</option>
                                        <?php 
                                            // Get all tour dates
                                            $stmt = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ?");
                                            $stmt->execute([$detail->tour_id]);
                                            $dates = $stmt->fetchAll();
                                            foreach ($dates as $date) {
                                        ?>
                                            <option value="<?= htmlspecialchars($date->date_id) ?>"><?= timeTR($date->tour_start_date) ?> - <?= timeTR($date->tour_finish_date) ?> (<?= htmlspecialchars($date->tour_limit) ?>)</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="panel-dropdown">
                                <a href="#">Anzahl Personen <span class="qtyTotal">1</span></a>
                                <div class="panel-dropdown-content right">
                                    <div class="qtyButtons">
                                        <label>Erwachsene</label>
                                        <input type="text" name="person_size" class="qtyInput" value="2">
                                    </div>
                                    <div class="qtyButtons">
                                        <label>Anzahl Kinder</label>
                                        <input type="text" name="child_size" class="qtyInput" value="0">
                                    </div>
                                </div>
                            </div>
                            <button class="btn_1 full-width purchase" type="submit" onclick="$.rezervasyonForm(<?= $detail->tour_id ?>)"> Reservieren </button>
                        </form>
                        <div class="text-center"><small> Kinder ab 12 Jahren zahlen den vollen Preis.</small></div>
                    </div>

                    <ul class="share-buttons">
                        <li><a class="fb-share" href="#0"><i class="social_facebook"></i> Share</a></li>
                        <li><a class="twitter-share" href="#0"><i class="social_twitter"></i> Tweet</a></li>
                        <li><a class="gplus-share" href="#0"><i class="social_googleplus"></i> Share</a></li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>

    <?php require_once 'inc/turlar.bottom.php'; ?>
</main>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>

<script src="lib/js/infobox.js"></script>
<script>
    $.rezervasyonForm = function() {
        const deger = $("form#rez_one").serialize();
        $.ajax({
            url: "rezervasyonOne",
            type: "post",
            data: deger,
            dataType: "json",
            success: function(cevap) {
                if (cevap.hata) {
                    alert(cevap.hata);
                } else {
                    window.location.href = "reservierung";
                }
            }
        });
    }
</script>

<script src="lib/js/moment.min.js"></script>
<script src="lib/js/daterangepicker.js"></script>
<script>
    $(function() {
        $('input[name="dates"]').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                cancelLabel: 'Clear'
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
        $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' > ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>

<script src="lib/js/input_qty.js"></script>

<?php require_once 'req/body_end.php'; ?> 
