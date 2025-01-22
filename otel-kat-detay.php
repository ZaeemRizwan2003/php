<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>
<?php
$link = g('link');
$stmt = $con->prepare("SELECT * FROM the_hotel_category WHERE slug = ?");
$stmt->execute([$link]);
$kategoriBul = $stmt->fetch();
$stmt = $con->prepare("SELECT COUNT(*) FROM the_hotel WHERE hotel_category_id = ? AND status = 1");
$stmt->execute([$kategoriBul->category_id]);
$sorgu = $stmt->fetchColumn();
?>

<title><?= htmlspecialchars($kategoriBul->name) ?> </title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="canonical" href="">

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<section class="hero_in hotels">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span> <?= htmlspecialchars($kategoriBul->name) ?> </h1>
        </div>
    </div>
</section>

<div class="container margin_60_35">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($sorgu) { ?>
                <div class="isotope-wrapper">
                    <div class="row">
                        <?php
                        $sayfa = isset($_GET["sayfa"]) && is_numeric($_GET["sayfa"]) ? $_GET["sayfa"] : 1;
                        $kacar = 10;
                        $ksayisi = $sorgu;
                        $ssayisi = ceil($ksayisi / $kacar);
                        $nereden = ($sayfa * $kacar) - $kacar;
                        $stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_category_id = ? LIMIT ? OFFSET ?");
                        $stmt->execute([$kategoriBul->category_id, $kacar, $nereden]);
                        $oteller = $stmt->fetchAll(PDO::FETCH_OBJ);
                        
                        foreach ($oteller as $otel) {
                            $min_cover = $otel->picture ? 'data/hotel/' . $otel->picture : 'data/no_hotel_pic.png';
                            $province = $otel->province;
                            $stmt = $con->prepare("SELECT * FROM il WHERE id = ?");
                            $stmt->execute([$province]);
                            $proSrc = $stmt->fetch();
                            
                            $stmt = $con->prepare("SELECT * FROM ilce WHERE id = ?");
                            $stmt->execute([$state]);
                            $staSrc = $stmt->fetch();
                            
                        ?>

                        <div class="col-md-4 isotope-item popular">
                            <div class="box_grid pb-1">
                                <figure>
                                    <a href="otel/<?= htmlspecialchars($otel->slug) ?>/<?= $otel->hotel_id ?>">
                                        <img src="<?= htmlspecialchars($min_cover) ?>" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Lesen Sie mehr</span></div>
                                    </a>
                                    <small><?= htmlspecialchars($proSrc->il_adi) ?> - <?= htmlspecialchars($staSrc->ilce_adi) ?></small>
                                </figure>
                                <div class="wrapper">
                                    <div class="cat_star"><?= hotelhomeStars($otel->stars) ?></div>
                                    <h3 style="font-size: 16px"><a href="otel/<?= htmlspecialchars($otel->slug) ?>/<?= $otel->hotel_id ?>"><?= htmlspecialchars($otel->name) ?></a></h3>
                                </div>
                                <ul>
                                    <li><i class="ti-eye"></i> <?= htmlspecialchars($otel->stars) ?> Ansicht</li>
                                </ul>
                            </div>
                        </div>

                        <?php } ?>

                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="category-pagination-sign text-center">Gesamt <strong><?= $sorgu ?></strong>  <strong><?= htmlspecialchars($kategoriBul->name) ?></strong> Hotel ist vorhanden.</p>
                    </div>
                    <?php if ($ssayisi > 1) { ?>
                        <div class="gap gap-small"></div>
                        <div class="col-md-12">
                            <nav class="text-center">
                                <ul class="pagination category-pagination">
                                    <?php
                                    if ($sayfa > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="hotels/'.$kategoriBul->slug.'/'.$kategoriBul->category_id.'">Zuerst</a></li>';
                                    }

                                    for ($i = $sayfa - 3; $i < $sayfa + 4; $i++) {
                                        if ($i > 0 && $i <= $ssayisi) {
                                            echo '<li class="page-item ' . ($i == $sayfa ? 'active' : '') . '"><a class="page-link" href="hotels/'.$kategoriBul->slug.'/'.$kategoriBul->category_id.'/'.$i.'">'.$i.'</a></li>';
                                        }
                                    }

                                    if ($sayfa != $ssayisi) {
                                        echo '<li class="page-item"><a class="page-link" href="hotels/'.$kategoriBul->slug.'/'.$kategoriBul->category_id.'/'.($ssayisi).'">Letzte Seite</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="alert alert-success">
                    Bu kategoriye ait tur bulunmamaktadır.
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php require_once 'inc/turlar.bottom.php'; ?>
<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>
