<?php
require_once 'req/start.php';
require_once 'req/head_start.php';

// Fetch the hotel slug from the URL parameter
$link = isset($_GET['link']) ? $_GET['link'] : '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    // Prepare and fetch hotel details
    $stmt = $con->prepare("SELECT * FROM the_hotel WHERE slug = ?");
    $stmt->bind_param("s", $link); // Bind the parameter as string
    $stmt->execute();
    $result = $stmt->get_result();
    $detail = $result->fetch_object();

    if (!$detail) {
        die("Hotel not found.");
    }

    // Check if the necessary properties exist on the $detail object
    $hotel_name = isset($detail->name) ? $detail->name : 'Hotel Name';
    $tour_id = isset($detail->tour_id) ? $detail->tour_id : null;
    $slug = isset($detail->slug) ? $detail->slug : '';

    // Update view count
    $update = $con->prepare("UPDATE the_hotel SET hit = hit + 1 WHERE slug = ?");
    $update->bind_param("s", $link); // Bind the parameter as string
    $update->execute();

    // Fetch province details
    $stmtProvince = $con->prepare("SELECT * FROM il WHERE id = ?");
    $stmtProvince->bind_param("i", $detail->province); // Bind the parameter as integer
    $stmtProvince->execute();
    $resultProvince = $stmtProvince->get_result();
    $proSrc = $resultProvince->fetch_object();

    // Fetch state details
    $stmtState = $con->prepare("SELECT * FROM ilce WHERE id = ?");
    $stmtState->bind_param("i", $detail->state); // Bind the parameter as integer
    $stmtState->execute();
    $resultState = $stmtState->get_result();
    $staSrc = $resultState->fetch_object();

} catch (mysqli_sql_exception $e) {
    die("Database error: " . $e->getMessage());
}
?>

<title><?= htmlspecialchars($hotel_name) ?></title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>


<main>
    <style>
        .hero_in.hotels_detail:before {
            background-image: url('data/hotel/<?= htmlspecialchars($detail->picture) ?>');
        }
    </style>
    <section class="hero_in hotels_detail">
        <div class="wrapper">
            <div class="container">
                <div style="color: yellow; font-size: 32px;"><?= hotelhomeStars($detail->stars) ?></div>
                <h1 class="fadeInUp" style="margin-top: 20px;"><span></span><?= htmlspecialchars($hotel_name) ?></h1>
                <small><?= htmlspecialchars($proSrc->il_adi) ?> - <?= htmlspecialchars($staSrc->ilce_adi) ?></small>
            </div>
            <span class="magnific-gallery">
                <?php
                $stmtPictures = $con->prepare("SELECT * FROM the_hotel_picture WHERE hotel_id = ?");
                $stmtPictures->bind_param("i", $detail->hotel_id); // Bind as integer
                $stmtPictures->execute();
                $resultPictures = $stmtPictures->get_result();
                $pictures = $resultPictures->fetch_all(MYSQLI_ASSOC);
                $picturesRows = count($pictures);
                $i = 0;
                foreach ($pictures as $picture) {
                    $i++;
                    $content = $picture['content'] ?: $hotel_name;  // Fallback to hotel name
                    ?>
                    <a href="data/hotel/pictures/<?= htmlspecialchars($picture['big_picture']) ?>" 
                       <?php if ($i == 1) { echo 'class="btn_photos"'; } ?> title="<?= htmlspecialchars($content) ?>" 
                       data-effect="mfp-zoom-in">
                        <?php if ($i == 1) {
                            echo '<i class="icon-camera"></i>  Bilder (' . $picturesRows . ')';
                        } ?>
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
                    <li><a href="#description" class="active"> Über das Hotel</a></li>
                    <li><a href="#rooms">Zimmer</a></li>
                    <!--<li><a href="#reviews">Bewertungen</a></li> !-->
                    <li><a href="#sidebar">Booking</a></li>
                </ul>
            </div>
        </nav>
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-lg-8">
                    <section id="description">
                        <h2>Über das <strong><?= htmlspecialchars($hotel_name) ?></strong> </h2>
                        <h3>Bilder</h3>
                        <div class="grid">
                            <ul class="magnific-gallery">
                                <?php
                                $stmt = $con->prepare("SELECT * FROM the_hotel_picture WHERE hotel_id = ?");
                                $stmt->bind_param("i", $detail->hotel_id); // Bind as integer
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $pictures = $result->fetch_all(MYSQLI_ASSOC);

                                $stmtCount = $con->prepare("SELECT COUNT(*) FROM the_hotel_picture WHERE hotel_id = ?");
                                $stmtCount->bind_param("i", $detail->hotel_id); // Bind as integer
                                $stmtCount->execute();
                                $resultCount = $stmtCount->get_result();
                                $picturesRows = $resultCount->fetch_row()[0];

                                foreach ($pictures as $picture) {
                                    $content = $picture['content'] ?: $hotel_name; // Fallback to hotel name
                                    ?>
                                    <li>
                                        <figure>
                                            <img src="data/hotel/pictures/<?= htmlspecialchars($picture['mini_picture']) ?>"
                                                 alt="<?= htmlspecialchars($content) ?>">
                                            <figcaption>
                                                <div class="caption-content">
                                                    <a href="data/hotel/pictures/<?= htmlspecialchars($picture['big_picture']) ?>"
                                                       title="<?= htmlspecialchars($content) ?>" data-effect="mfp-zoom-in">
                                                        <i class="pe-7s-albums"></i>
                                                        <p><?= htmlspecialchars($content) ?></p>
                                                    </a>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                        <!-- /grid gallery -->

                        <?= htmlspecialchars($detail->content) ?>
                        <hr>
                        <div id="rooms" class="clearfix">
                            <h3>Zimmer</h3>
                        </div>

                        <?php if ($detail->address) { ?>
                            <hr>
                            <h3>Lage des Hotels</h3>
                            <div class="add_bottom_30">
                            </div>
                            <!-- End Map -->
                        <?php } ?>
                    </section>
                    <!-- /section -->

                    <section id="reviews">
                        <h2>Bewertungen</h2>
                        <?php
                        $stmt = $con->prepare("SELECT COUNT(*) FROM the_hotel_comment WHERE hotel_id = ? AND status = 1");
                        $stmt->bind_param("i", $detail->hotel_id); // Bind as integer
                        $stmt->execute();
                        $resultCount = $stmt->get_result();
                        $commentsRows = $resultCount->fetch_row()[0];

                        if ($commentsRows > 0) {
                            ?>
                            <div class="reviews-container">
                                <?php
                                $stmt = $con->prepare("SELECT * FROM the_hotel_comment WHERE hotel_id = ? AND status = 1");
                                $stmt->bind_param("i", $detail->hotel_id); // Bind as integer
                                $stmt->execute();
                                $resultComments = $stmt->get_result();
                                $hotelComments = $resultComments->fetch_all(MYSQLI_ASSOC);
                                foreach ($hotelComments as $hotelComment) {
                                    ?>
                                    <div class="review-box clearfix" style="padding-left:0;">
                                        <div class="rev-content">
                                            <div class="rating">
                                                <?= commentStars($hotelComment['rating_review']); ?>
                                            </div>
                                            <div class="rev-info">
                                                <?= htmlspecialchars($hotelComment['name']) ?> – <?= htmlspecialchars($hotelComment['created_at']) ?>:
                                            </div>
                                            <div class="rev-text">
                                                <p>
                                                    <?= htmlspecialchars($hotelComment['content']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </section>

                    <?php } else { ?>
                        <div class="alert alert-info">
                            Es gibt noch keine Kommentare für das Hotel.
                        </div>
                    <?php } ?>

                    <hr>

                    <div class="add-review">
                        <h5>Kommentar hinterlassen</h5>
                        <form id="hotelYorum" action="" onsubmit="return false" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Vor- und Nachname *</label>
                                    <input type="text" name="name_review" id="name_review" placeholder=""
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email *</label>
                                    <input type="hidden" name="hotel_id" id="hotel_id"
                                        value="<?= htmlspecialchars($detail->hotel_id) ?>" />
                                    <input type="email" name="email_review" id="email_review" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Bewertung </label>
                                    <div class="custom-select-form">
                                        <select name="rating_review" id="rating_review" class="wide">
                                            <option value="1">1 (lowest)</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5 (highest)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Kommentar </label>
                                    <textarea name="content_review" id="content_review" class="form-control" style="height:100px;"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn_1">Abschicken</button>
                        </form>
                    </div>
                    <!-- End add-review -->
                </div>
                <!-- /col -->
                <div class="col-lg-4" id="sidebar">
                    <?php require_once 'req/sidebar.php'; ?>
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

</main>
<!-- /main -->

<?php require_once 'req/footer.php'; ?>

<?php require_once 'req/end.php'; ?>
