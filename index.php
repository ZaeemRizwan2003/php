<?php
// Start output buffering
ob_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure there is no output before headers are sent
require_once 'req/start.php';
require_once 'req/head_start.php';
?>

<title><?= $general['site_title']->value; ?></title>

<?php
require_once 'req/head.php';
require_once 'req/body_start.php';
require_once 'req/header.php';
?>

<main>
    <section class="hero_single version_2">
        <div class="wrapper">
            <div class="container">
                <h3>Sungate24</h3>
                <p> Ihr Experte für exklusive Reisen zu besten Preisen!</p>
                <form role="form" action="arama-sonuc" method="GET">
                    <div class="row no-gutters custom-search-input-2">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input class="form-control" type="text" name="kelime"
                                    placeholder="Suchen Sie nach Stadt oder Hotel Namen">
                                <i class="icon_search"></i>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" class="btn_search" value="Suchen">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div class="container-fluid margin_30_95 pl-lg-5 pr-lg-5">
        <section class="add_bottom_45">
            <div class="main_title_3">
                <span><em></em></span>
                <h2> Unsere beliebtesten Hotels</h2>
            </div>
            <div class="row">
                <?php
                // Fetching the first 12 hotels
                $oteller = $con->prepare("SELECT * FROM the_hotel ORDER BY name DESC LIMIT 12");
                $oteller->execute();
                $hotels = $oteller->fetchAll(PDO::FETCH_OBJ); // Fetch all hotels
                
                foreach ($hotels as $otel) {
                    if ($otel->picture) {
                        $min_cover = 'data/hotel/' . $otel->picture;
                    } else {
                        $min_cover = 'data/no_hotel_pic.png';
                    }

                    // Fetch province data
                    $province = $otel->province;
                    $proQuery = $con->prepare("SELECT * FROM ilce WHERE id = :province");
                    $proQuery->execute(['province' => $province]);
                    $proSrc = $proQuery->fetch();

                    // Fetch state data
                    $state = $otel->state;
                    $staQuery = $con->prepare("SELECT * FROM ilce WHERE id = :state");
                    $staQuery->execute(['state' => $state]);
                    $staSrc = $staQuery->fetch();
                    ?>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <a href="otel/<?= $otel->slug ?>/<?= $otel->hotel_id ?>" class="grid_item">
                            <figure>
                                <img src="<?= $min_cover ?>" class="img-fluid" alt="">
                                <div class="info">
                                    <div class="cat_star"><?= hotelhomeStars($otel->stars) ?></div>
                                    <h3><?= $otel->name ?></h3>
                                </div>
                                <small><?= $proSrc->$il_adi ?> - <?= $staSrc->$ilce_adi ?></small>
                            </figure>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center"><a href="hotels"><strong> Alle Hotels <i
                            class="arrow_carrot-right"></i></strong></a></div>
        </section>
    </div>

    <div class="bg_color_1">
        <div class="container margin_80_55">
            <div class="main_title_2">
                <span><em></em></span>
                <h3> Inspirationen</h3>
                <p> Die beliebtesten Inspiration Tipps</p>
            </div>
            <div class="row">
                <?php
                // Fetch the last 4 blog posts
                $lastBlog = $con->prepare("SELECT * FROM the_blog ORDER BY blog_id DESC LIMIT 4");
                $lastBlog->execute();
                $blogs = $lastBlog->fetchAll(PDO::FETCH_OBJ); // Fetch all blog posts
                
                foreach ($blogs as $blog) {
                    ?>
                    <div class="col-lg-6">
                        <a class="box_news" href="text/<?= $blog->slug ?>/<?= $blog->blog_id ?>">
                            <figure>
                                <?php if ($blog->picture) { ?>
                                    <img src="data/blog/<?= $blog->picture ?>" alt="" />
                                <?php } else { ?>
                                    <img src="lib/img/blog-1.jpg" alt="" />
                                <?php } ?>
                            </figure>
                            <ul>
                                <li><?= timeTR($blog->created_at) ?></li>
                            </ul>
                            <h4><?= $blog->name ?></h4>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <p class="btn_home_align"><a href="blog" class="btn_1 rounded">Alle Anzeigen</a></p>
        </div>
    </div>

    <div class="call_section"
        style="background-image: url(https://www.rd.com/wp-content/uploads/2017/07/01-birth-month-If-You-Were-Born-In-Summer-This-Is-What-We-Know-About-You_644740429-icemanphotos.jpg)">
        <div class="container clearfix">
            <div class="col-lg-5 col-md-6 float-right wow" data-wow-offset="250">
                <div class="block-reveal">
                    <div class="block-vertical"></div>
                    <div class="box_1">
                        <h3> Unser Support freut sich auf Sie!</h3>
                        <p> Sie haben Fragen? Kontaktieren Sie uns jetzt! </p>
                        <a href="tel: 0800 711 82 17 " class="btn_1 rounded"> Tel: <i class="fa fa-phone"></i> 0800 711
                            82 17 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Including footer and scripts
require_once 'req/footer.php';
require_once 'req/script.php';
require_once 'req/body_end.php';

// End output buffering and flush it
ob_end_flush();
?>