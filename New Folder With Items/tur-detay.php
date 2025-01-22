<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>
<?php
$link = g('link');
$stmt = $con->prepare("SELECT * FROM the_tour WHERE slug = :slug");
$stmt->bindParam(':slug', $link, PDO::PARAM_STR);
$stmt->execute();
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
                    $stmt = $con->prepare("SELECT * FROM the_tour_picture WHERE tour_id = ?");
                    $stmt->bind_param("i", $detail->tour_id);
                    $stmt->execute();
                    $pictures = $stmt->get_result();
                    $picturesRows = $pictures->num_rows;
                    while ($picture = $pictures->fetch_object()) {
                        $i++;
                        $content = $picture->content ?: $detail->name;
                ?>
                <a href="data/tour/pictures/<?= htmlspecialchars($picture->big_picture) ?>" <?php if($i == 1) echo 'class="btn_photos"'; ?> title="<?= htmlspecialchars($content) ?>" data-effect="mfp-zoom-in">
                    <?php if($i == 1) echo 'Tur Resimleri (' . $picturesRows . ' Adet)'; ?>
                </a>
                <?php } ?>
            </span>
        </div>
    </section>
    <!--/hero_in-->

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
                </div>
                <aside class="col-lg-4" id="sidebar">
                    <div class="box_detail booking">
                        <div class="price">
                            <?php 
                                $stmt = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ? ORDER BY person_price ASC LIMIT 1");
                                $stmt->bind_param("i", $detail->tour_id);
                                $stmt->execute();
                                $enkucukFiyat = $stmt->get_result()->fetch_object();
                            ?>
                            <span><?= htmlspecialchars($enkucukFiyat->person_price) ?> € <small></small></span>
                        </div>
                        <form id="rez_one" method="POST" action="" class="user-form payment">
                            <input type="hidden" name="rez_type" value="tour">
                            <input type="hidden" name="tour_id" value="<?= htmlspecialchars($detail->tour_id) ?>">
                            <button class="btn_1 full-width purchase" type="submit" onclick="$.rezervasyonForm(<?= htmlspecialchars($detail->tour_id) ?>)">Reservieren</button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <?php require_once 'inc/turlar.bottom.php'; ?>
</main>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
