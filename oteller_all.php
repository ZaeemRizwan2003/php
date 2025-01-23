<?php 
require_once 'req/start.php'; 
require_once 'req/head_start.php'; 

// Retrieve the count of hotels
$sorgu = $con->query("SELECT COUNT(*) as count FROM the_hotel WHERE status = 1");
$row = $sorgu->fetch_assoc();
$sorgu = $row['count'];
?>

<title>Hotel - <?=$general['site_title']->value;?></title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<main>
    <section class="hero_in hotels">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span> Hotels </h1>
            </div>
        </div>
    </section>

    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-12">
                <div class="isotope-wrapper">
                    <div class="row">
                        <?php
                        @$sayfa = $_GET["sayfa"];
                        if (empty($sayfa) || !is_numeric($sayfa)) {
                            $sayfa = 1;
                        }
                        $kacar = 6; // Hotels per page
                        $ksayisi = $sorgu; // Total hotels
                        $ssayisi = ceil($ksayisi / $kacar); // Total pages
                        $nereden = ($sayfa * $kacar) - $kacar;

                        // Retrieve paginated hotels
                        $stmt = $con->prepare("SELECT * FROM the_hotel LIMIT ? OFFSET ?");
                        $stmt->bind_param("ii", $kacar, $nereden);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($otel = $result->fetch_assoc()) {
                            $min_cover = $otel['picture'] 
                                ? 'data/hotel/' . $otel['picture'] 
                                : 'data/no_hotel_pic.png';

                            // Get province name
                            $province = $otel['province'];
                            $proStmt = $con->prepare("SELECT il_adi FROM il WHERE id = ?");
                            $proStmt->bind_param("i", $province);
                            $proStmt->execute();
                            $proResult = $proStmt->get_result();
                            $proSrc = $proResult->fetch_assoc();

                            // Get state name
                            $state = $otel['state'];
                            $staStmt = $con->prepare("SELECT ilce_adi FROM ilce WHERE id = ?");
                            $staStmt->bind_param("i", $state);
                            $staStmt->execute();
                            $staResult = $staStmt->get_result();
                            $staSrc = $staResult->fetch_assoc();
                        ?>

                        <div class="col-md-4 isotope-item popular">
                            <div class="box_grid pb-1">
                                <figure>
                                    <a href="otel/<?=$otel['slug']?>/<?=$otel['hotel_id']?>">
                                        <img src="<?=$min_cover?>" class="img-fluid" alt="" width="800" height="533">
                                        <div class="read_more"><span>Lesen Sie mehr</span></div>
                                    </a>
                                    <small><?=$proSrc['il_adi']?> - <?=$staSrc['ilce_adi']?></small>
                                </figure>
                                <div class="wrapper">
                                    <div class="cat_star"><?=hotelhomeStars($otel['stars'])?></div>
                                    <h5 style="font-size: 16px">
                                        <a href="otel/<?=$otel['slug']?>/<?=$otel['hotel_id']?>">
                                            <?=kisalt($otel['name'],30)?>
                                        </a>
                                    </h5>
                                </div>
                                <ul class="">
                                    <li><i class="ti-eye"></i> <?=$otel['hit']?> View</li>
                                </ul>
                            </div>
                        </div>

                        <?php 
                            $proStmt->close();
                            $staStmt->close();
                        } 
                        $stmt->close();
                        ?>

                    </div>
                    <!-- Pagination -->
                    <?php if($ssayisi > 1){ ?>
                        <div class="gap gap-small"></div>
                        <div class="col-md-12">
                            <nav class="text-center">
                                <ul class="pagination category-pagination">
                                    <?php
                                    if ($sayfa > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="hotels">Zuerst</a></li>';
                                    }

                                    for ($i = $sayfa - 3; $i < $sayfa + 4; $i++) {
                                        if ($i > 0 && $i <= $ssayisi) {
                                            echo '<li class="page-item '.($i == $sayfa ? 'active' : '').'"><a class="page-link" href="hotels/'.$i.'">'.$i.'</a></li>';
                                        }
                                    }

                                    if ($sayfa != $ssayisi) {
                                        echo '<li class="page-item"><a class="page-link" href="hotels/'.($ssayisi).'">Letzte Seite</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    <?php } ?>
                </div>
                <!-- /isotope-wrapper -->
            </div>
        </div>
    </div>
    <!-- /container -->

<?php 
require_once 'inc/turlar.bottom.php'; 
require_once 'req/footer.php'; 
require_once 'req/script.php'; 
require_once 'req/body_end.php'; 
?>
