<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>
<?php
    $link = g('link');
    $kategoriBul = $con->query("SELECT * FROM the_hotel_category WHERE slug = '$link'")->fetch_object();
    $sorgu = $con->query("SELECT COUNT(*) FROM the_hotel WHERE hotel_category_id = '$kategoriBul->category_id' AND status = 1")->fetch_row()[0];
?>

<title><?=$kategoriBul->name?> </title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="canonical" href="">

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<section class="hero_in hotels">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span> <?=$kategoriBul->name?> </h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<div class="container margin_60_35">
    <div class="row">
        <aside class="col-lg-3">
            <?php require_once  'inc/oteller.side.php'; ?>
        </aside>
        <!-- /aside -->

        <div class="col-lg-9">
            <?php if ($sorgu) { ?>
            <div class="isotope-wrapper">
                <div class="row">

                    <?php
                    $sayfa = isset($_GET["sayfa"]) && is_numeric($_GET["sayfa"]) ? $_GET["sayfa"] : 1;
                    $kacar = 100;
                    $ksayisi = $sorgu;
                    $ssayisi = ceil($ksayisi / $kacar);
                    $nereden = ($sayfa * $kacar) - $kacar;
                    $oteller = $con->query("SELECT * FROM the_hotel WHERE hotel_category_id = '$kategoriBul->category_id' LIMIT $kacar OFFSET $nereden");

                    while ($otel = $oteller->fetch_object()){
                        $min_cover = $otel->picture;
                    ?>

                    <div class="col-md-6 isotope-item popular">
                        <div class="box_grid">
                            <figure>
                                <a href="otel/<?=$otel->slug?>/<?=$otel->hotel_id?>">
                                    <img src="data/hotel/<?=$min_cover?>" class="img-fluid" alt="" width="800" height="533">
                                    <div class="read_more"><span>Lesen Sie mehr</span></div>
                                </a>
                            </figure>
                            <div class="wrapper">
                                <div class="cat_star"><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i></div>
                                <h3><a href="otel/<?=$otel->slug?>/<?=$otel->hotel_id?>"><?=$otel->name?></a></h3>
                                <span class="price">From <strong>$54</strong> /per person</span>
                            </div>
                            <ul>
                                <li><i class="ti-eye"></i> 164 Ansicht</li>
                                <li><div class="score"><span>Punkte<em>350 Görüş</em></span><strong>8.9</strong></div></li>
                            </ul>
                        </div>
                    </div>

                    <?php } ?>

                </div>
                <!-- /row -->
            </div>
            <!-- /isotope-wrapper -->

            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <p class="category-pagination-sign text-center">Gesamt <strong><?=$sorgu?></strong>  <strong><?=$kategoriBul->name?></strong> otel mevcuttur.</p>
                </div>
                <?php if($ssayisi > 1){ ?>
                    <div class="gap gap-small"></div>
                    <div class="col-md-12">
                        <nav class="text-center">

                        </nav>
                    </div>
                <?php } ?>
            </div>
            <!-- Sayfalama End !-->
            <!--<p class="text-center"><a href="#0" class="btn_1 rounded add_top_30">Load more</a></p> !-->
            <?php } else{ ?>
                <div class="alert alert-success">
                    Bu kategoriye ait tur bulunmamaktadır.
                </div>
            <?php } ?>
        </div>
        <!-- /col -->
    </div>
</div>
<!-- /container -->
<?php require_once 'inc/turlar.bottom.php'; ?>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>
