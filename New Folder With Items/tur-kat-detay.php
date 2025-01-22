<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>
<?php
	$link = g('link');
    $stmt = $con->prepare("SELECT * FROM the_tour_category WHERE slug = ?");
    $stmt->execute([$link]);
    $kategoriBul = $stmt->fetch(); // Fetch single row as an object
    $stmt = $con->prepare("SELECT COUNT(*) FROM the_tour WHERE tour_category_id = ? AND status = 1");
    $stmt->execute([$kategoriBul->category_id]);
    $sorgu = $stmt->fetchColumn(); // Fetch single column value
    ?>

<title><?=$kategoriBul->name?> </title>
<meta name="keywords" content="" />
<meta name="description" content=""  />
<link rel="canonical" href="">

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<main>

    <section class="hero_in tours">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span> <?=$kategoriBul->name?> </h1>
            </div>
        </div>
    </section>

    <div class="container margin_60_35">
        <div class="row">
            <aside class="col-lg-3">
                <?php require_once  'inc/turlar.side.php'; ?>
            </aside>

            <div class="col-lg-9">
            <?php if ($sorgu) { ?>
                <div class="isotope-wrapper">
                    <div class="row">

                        <?php 
                            @$sayfa = $_GET["sayfa"] ?? 1;
                            if (!is_numeric($sayfa)){
                                $sayfa = 1;
                            }
                            $kacar = 1;
                            $ksayisi = $sorgu;
                            $ssayisi = ceil($ksayisi / $kacar);
                            $nereden = ($sayfa * $kacar) - $kacar;
                            $stmt = $con->prepare("SELECT * FROM the_tour WHERE tour_category_id = ? LIMIT ? OFFSET ?");
                            $stmt->execute([$kategoriBul->category_id, $kacar, $nereden]);
                            $turlar = $stmt->fetchAll(PDO::FETCH_OBJ); // Fetch all rows as an array of objects
                                                            foreach ($turlar as $tur){
                                    $min_cover = $tur->picture;
                                    $stmt = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ? ORDER BY person_price ASC LIMIT 1");
                                    $stmt->execute([$tur->tour_id]);
                                    $enkucukFiyat = $stmt->fetch(); // Fetch single row as an object
                                    
                        ?>
                            <div class="col-md-6 isotope-item popular">
                                <div class="box_grid">
                                    <figure>
                                        <a href="tur/<?=$tur->slug.'/'.$tur->tour_id?>"><img src="data/tour/<?=$min_cover?>" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Schauen</span></div></a>
                                    </figure>
                                    <div class="wrapper">
                                        <h3><a href="tur/<?=$tur->slug.'/'.$tur->tour_id?>"><?=$tur->name?> </a></h3>
                                        <span class="price">Fiyat: <strong> <?=$enkucukFiyat->person_price?> € </strong> /kişi başı</span>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            <?php } else{ ?>
            <div class="alert alert-success">
                Bu kategoriye ait tur bulunmamaktadır.
            </div>
            <?php } ?>
            </div>
        </div>
    </div>
    <?php require_once 'inc/turlar.bottom.php'; ?>
</main>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>
