<?php
require_once 'req/start.php';
require_once 'db.php'; // Include the db.php file to use the database connection
?>

<title><?= htmlspecialchars($general['site_title']->value ?? 'Default Title'); ?></title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<main>
    <section class="hero_in tours">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span> Bölge Adı</h1>
            </div>
        </div>
    </section>
    <!--/hero_in-->

    <div class="filters_listing sticky_horizontal">
        <div class="container">
            <ul class="clearfix">
                <li>
                    <div class="switch-field">
                        <input type="radio" id="all" name="listing_filter" value="all" checked data-filter="*" class="selected">
                        <label for="all">Hepsi</label>
                        <input type="radio" id="popular" name="listing_filter" value="popular" data-filter=".popular">
                        <label for="popular">Popüler</label>
                        <input type="radio" id="latest" name="listing_filter" value="latest" data-filter=".latest">
                        <label for="latest">Son Eklenen</label>
                    </div>
                </li>
                <li>
                    <div class="layout_view">
                        <a href="turlar.php" class="active"><i class="icon-th"></i></a>
                        <a href="turlar-liste.php"><i class="icon-th-list"></i></a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /filters -->

    <div class="container margin_60_35">
        <div class="row">
            <aside class="col-lg-3">
                <?php require_once 'inc/turlar.side.php'; ?>
            </aside>
            <!-- /aside -->

            <div class="col-lg-9">
                <div class="isotope-wrapper">
                    <div class="row">
                        <?php
                        // Query to fetch tour details from the database
                        $sql = "SELECT * FROM tours"; // Adjust the table name and column names based on your database
                        $result = $con->query($sql);

                        // Check if there are any results
                        if ($result->num_rows > 0) {
                            // Loop through each tour record
                            while ($row = $result->fetch_assoc()) {
                                $img = $row['image'];  // Column 'image' contains the image URL
                                $name = $row['name'];  // Column 'name' contains the tour name
                                $price = $row['price']; // Column 'price' contains the price
                                $category = $row['category']; // Column 'category' contains the tour category
                                $duration = $row['duration']; // Column 'duration' contains the tour duration
                                $reviews = $row['reviews']; // Column 'reviews' contains the reviews count
                                $score = $row['score']; // Column 'score' contains the score

                                // Output tour details in HTML
                                ?>
                                <div class="col-md-6 isotope-item <?= htmlspecialchars($category); ?>">
                                    <div class="box_grid">
                                        <figure>
                                            <a href="tur-detay.php"><img src="<?= htmlspecialchars($img); ?>" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
                                            <small><?= htmlspecialchars($category); ?></small>
                                        </figure>
                                        <div class="wrapper">
                                            <h3><a href="tur-detay.php"><?= htmlspecialchars($name); ?></a></h3>
                                            <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                                            <span class="price">From <strong><?= htmlspecialchars($price); ?></strong> /per person</span>
                                        </div>
                                        <ul>
                                            <li><i class="icon_clock_alt"></i> <?= htmlspecialchars($duration); ?></li>
                                            <li><div class="score"><span>Superb<em><?= htmlspecialchars($reviews); ?></em></span><strong><?= htmlspecialchars($score); ?></strong></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "No tours found.";
                        }
                        ?>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /isotope-wrapper -->

                <p class="text-center"><a href="#0" class="btn_1 rounded add_top_30">Load more</a></p>
            </div>
            <!-- /col -->
        </div>
    </div>
    <!-- /container -->
    <?php require_once 'inc/turlar.bottom.php'; ?>

</main>
<!--/main-->

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>

<?php
// Close the database connection
$con->close();
?>
