<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>
<?php
    if ($_GET) {
        $q = $_GET["q"];
        if ($q === 'sepeti_bosalt') {
            unset($_SESSION["sepet"]);
            go('sepetim');
        }
    }
?>
<title><?= htmlspecialchars($general['site_title']->value, ENT_QUOTES, 'UTF-8'); ?></title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<?php 
    $sepetim__urunler = isset($_SESSION['sepet']['rezervasyon']) ? $_SESSION['sepet']['rezervasyon'] : [];
    foreach ($sepetim__urunler as $sepetim__urun) {
        $rez_type = $sepetim__urun['rez_type'];

        if ($rez_type === 'tour') {
            $tour_id = $sepetim__urun['tour_id'];
            $tour_dates = $sepetim__urun['tour_dates'];
            $person_size = $sepetim__urun['person_size'];
            $child_size = $sepetim__urun['child_size'];
            $start_date = $sepetim__urun['start_date'];
            $end_date = $sepetim__urun['end_date'];

            $stmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
            $stmt->execute([$tour_id]);
            $paketbul = $stmt->fetch();

            $stmt = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ? AND date_id = ?");
            $stmt->execute([$tour_id, $tour_dates]);
            $tarihbul = $stmt->fetch();

            $yetiskinFiyat = $tarihbul->person_price * $person_size;
            $CocukFiyat = $tarihbul->child_price * $child_size;
            $fiyat = $yetiskinFiyat + $CocukFiyat;
        } else {
            $hotel_id = $sepetim__urun['hotel_id'];
            $room_id = $sepetim__urun['room_id'];
            $dates = $sepetim__urun['dates'];
            $person_size = $sepetim__urun['person_size'];
            $child_size = $sepetim__urun['child_size'];
            $start_date = $sepetim__urun['start_date'];
            $end_date = $sepetim__urun['end_date'];

            $stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = ?");
            $stmt->execute([$hotel_id]);
            $paketbul = $stmt->fetch();

            $stmt = $con->prepare("SELECT * FROM the_hotel_room WHERE room_id = ?");
            $stmt->execute([$room_id]);
            $odaBul = $stmt->fetch();

            $yetiskinFiyat = $odaBul->person_price * $person_size;
            $CocukFiyat = $odaBul->child_price * $child_size;
            $fiyat = $yetiskinFiyat + $CocukFiyat;
        }

        $tarih1 = strtotime($start_date);
        $tarih2 = strtotime($end_date);
        $gunSayisi = ($tarih2 - $tarih1) / (60 * 60 * 24);
        $fiyat = $fiyat * $gunSayisi;
    }
?>

<?php if (empty($_SESSION["sepet"])) { ?>
    <?php go('/') ?>
<?php } else { ?>
    <div class="hero_in cart_section">
        <div class="wrapper">
            <div class="container">
                <div class="bs-wizard clearfix">
                    <div class="bs-wizard-step active">
                        <div class="text-center bs-wizard-stepnum">Reservationsdetails</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="reservierung" class="bs-wizard-dot"></a>
                    </div>

                    <div class="bs-wizard-step disabled">
                        <div class="text-center bs-wizard-stepnum">Rechnungsdetails</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="reservierung/2/<?=$reservierungNo?>" class="bs-wizard-dot"></a>
                    </div>

                    <div class="bs-wizard-step disabled">
                        <div class="text-center bs-wizard-stepnum">Zahlung & Bestätigung</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="reservierung/3/<?=$rezervasyonNo?>" class="bs-wizard-dot"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg_color_1">
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-lg-8">
                    <div class="box_cart">
                        <table class="table table-striped cart-list">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Preis</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if ($hotel_id) { ?>
                                        <span class="item_cart">
                                            <h4><?=$paketbul->name?></h4><br>
                                        </span>
                                        <?php } else { ?>
                                        <span class="item_cart">
                                            <h4><?=$paketbul->name?></h4><br>
                                            <?= dateTR($tarihbul->tour_start_date) ?> - <?= dateTR($tarihbul->tour_finish_date) ?>
                                        </span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <strong><?=$fiyat?> € </strong>
                                    </td>
                                    <td class="options" style="width:5%; text-align:center;"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-options clearfix">
                            <div class="float-left">
                                <!-- Option to apply coupon (if needed) -->
                            </div>
                            <div class="float-right fix_mobile">
                                <a href="reservierung?q=sepeti_bosalt" class="btn_1 outline">Warenkorb leeren</a>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4" id="sidebar">
                    <div class="box_detail">
                        <div id="total_cart">
                            Total <span class="float-right"><?=$fiyat?> € </span>
                        </div>
                        <ul class="cart_details">
                            <?php if ($hotel_id) { ?>
                            <li>Datum: <span><?=$dates?></span></li>
                            <?php } else { ?>
                            <li>Başlangıç Tarihi: <span><?= dateTR($tarihbul->tour_start_date) ?></span></li>
                            <li>Enddatum: <span><?= dateTR($tarihbul->tour_finish_date) ?></span></li>
                            <?php } ?>
                            <li>Erwachsene: <span><?=$person_size?></span></li>
                            <li>Anzahl Kinder: <span><?=$child_size?></span></li>
                        </ul>
                        <button onclick="$.siparisiTamamla('<?=$rezervasyonNo?>')" class="btn_1 full-width purchase">Buchung bestätigen</button>
                        <div class="text-center"><small>Kinder ab 12 Jahren zahlen den vollen Preis.</small></div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
<?php } ?>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>

<?php
    if ($hotel_id) {
        $link = 'oreservierungTwo';
    } else {
        $link = 'reservierungTwo';
    }
?>

<script type="text/javascript">
    $(document).ready(function() {
        $.siparisiTamamla = function(value) {
            $.ajax({
                url: '<?=$link?>',
                type: "post",
                data: {id: value},
                dataType: "json",
                success: function(cevap) {
                    if (cevap.hata) {
                        Swal.fire({
                            type: 'error',
                            title: 'Error!',
                            text: cevap.hata
                        })
                    } else if (cevap.bos) {
                        Swal.fire({
                            type: 'error',
                            title: 'Error!',
                            text: cevap.bos
                        })
                    } else {
                        window.location.href = "reservierung/2/" + value;
                    }
                }
            });
        }
    });
</script>

<?php require_once 'req/body_end.php'; ?>
