<?php
require_once 'req/start.php';
require_once 'req/head_start.php';

// Ensure the database connection is established using MySQLi
$link = filter_input(INPUT_GET, 'link', FILTER_SANITIZE_STRING);

// Fetch category details using prepared statements
$query = "SELECT * FROM the_tour_category WHERE slug = ?";
$stmt = $con->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $con->error);
}
$stmt->bind_param('s', $link);
$stmt->execute();
$result = $stmt->get_result();
$kategoriBul = $result->fetch_object();

if (!$kategoriBul) {
    die("No category found for the provided link.");
}

// Fetch the count of tours in the category
$queryCount = "SELECT COUNT(*) FROM the_tour WHERE tour_category_id = ? AND status = 1";
$stmtCount = $con->prepare($queryCount);
if (!$stmtCount) {
    die("Prepare failed: " . $con->error);
}
$stmtCount->bind_param('i', $kategoriBul->category_id);
$stmtCount->execute();
$stmtCount->bind_result($sorgu);
$stmtCount->fetch();
$stmtCount->close();
?>

<title><?= htmlspecialchars($kategoriBul->name) ?> </title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="canonical" href="">

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<main>
    <section class="hero_in tours">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span> <?= htmlspecialchars($kategoriBul->name) ?> </h1>
            </div>
        </div>
    </section>

    <div class="container margin_60_35">
        <div class="row">
            <aside class="col-lg-3">
                <?php require_once 'inc/turlar.side.php'; ?>
            </aside>

            <div class="col-lg-9">
                <?php if ($sorgu > 0) { ?>
                    <div class="isotope-wrapper">
                        <div class="row">

                            <?php
                            // Pagination handling
                            $sayfa = filter_input(INPUT_GET, "sayfa", FILTER_VALIDATE_INT);
                            $sayfa = $sayfa ? $sayfa : 1;
                            $kacar = 1;
                            $ksayisi = $sorgu;
                            $ssayisi = ceil($ksayisi / $kacar);
                            $nereden = ($sayfa * $kacar) - $kacar;

                            // Fetch the tours for this category
                            $queryTours = "SELECT * FROM the_tour WHERE tour_category_id = ? LIMIT ?, ?";
                            $stmtTours = $con->prepare($queryTours);
                            if (!$stmtTours) {
                                die("Prepare failed: " . $con->error);
                            }
                            $stmtTours->bind_param('iii', $kategoriBul->category_id, $nereden, $kacar);
                            $stmtTours->execute();
                            $resultTours = $stmtTours->get_result();
                            $turlar = $resultTours->fetch_all(MYSQLI_ASSOC);

                            foreach ($turlar as $tur) {
                                $min_cover = $tur['picture'];

                                // Fetch the lowest price for this tour
                                $queryPrice = "SELECT * FROM the_tour_date WHERE tour_id = ? ORDER BY person_price ASC LIMIT 1";
                                $stmtPrice = $con->prepare($queryPrice);
                                if (!$stmtPrice) {
                                    die("Prepare failed: " . $con->error);
                                }
                                $stmtPrice->bind_param('i', $tur['tour_id']);
                                $stmtPrice->execute();
                                $resultPrice = $stmtPrice->get_result();
                                $enkucukFiyat = $resultPrice->fetch_object();
                                ?>
                                <div class="col-md-6 isotope-item popular">
                                    <div class="box_grid">
                                        <figure>
                                            <a href="tur/<?= htmlspecialchars($tur['slug'] . '/' . $tur['tour_id']) ?>">
                                                <img src="data/tour/<?= htmlspecialchars($min_cover) ?>" class="img-fluid"
                                                    alt="" width="800" height="533">
                                                <div class="read_more"><span>Mehr Erfahren</span></div>
                                            </a>
                                            <small>... </small>
                                        </figure>
                                        <div class="wrapper">
                                            <h3><a href="tur/<?= htmlspecialchars($tur['slug'] . '/' . $tur['tour_id']) ?>"><?= htmlspecialchars($tur['name']) ?>
                                                </a></h3>
                                            <p>.... </p>
                                            <span class="price">Preis: <strong>
                                                    <?= htmlspecialchars($enkucukFiyat->person_price) ?> € </strong> /kişi
                                                başı</span>
                                        </div>
                                        <ul>
                                            <li><i class="icon_clock_alt"></i> 3 Gün </li>
                                            <li>
                                                <div class="score"><span>Punkte<em>350 Görüş</em></span><strong>8.9</strong>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="category-pagination-sign text-center">Gesamt <strong><?= $sorgu ?></strong>
                                <strong><?= htmlspecialchars($kategoriBul->name) ?></strong> tur mevcuttur.</p>
                        </div>

                        <?php if ($ssayisi > 1) { ?>
                            <div class="gap gap-small"></div>
                            <div class="col-md-12">
                                <nav class="text-center">
                                    <ul class="pagination category-pagination">
                                        <?php
                                        for ($s = 1; $s <= $ssayisi; $s++) {
                                            echo $sayfa == $s
                                                ? '<li class="page-item active"><a class="page-link" href="turlar/' . htmlspecialchars($kategoriBul->slug . '/' . $kategoriBul->category_id . '/sayfa/' . $s . '#start') . '">' . $s . '</a></li>'
                                                : '<li class="page-item"><a class="page-link" href="turlar/' . htmlspecialchars($kategoriBul->slug . '/' . $kategoriBul->category_id . '/sayfa/' . $s . '#start') . '">' . $s . '</a></li>';
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
</main>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>