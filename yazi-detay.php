<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>

<?php
$link = g('link') ?? ''; 
$textID = g('id') ?? ''; 

// Using MySQLi prepared statements to prevent SQL injection
$sql = "SELECT * FROM the_blog WHERE slug = ? AND blog_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('si', $link, $textID);  // 'si' means string and integer
$stmt->execute();
$result = $stmt->get_result();
$detail = $result->fetch_object();

if (!$detail) {
    die("Blog post not found.");
}
?>

<title><?= htmlspecialchars($detail->name ?? 'Blog Post') ?></title>
<?php require_once 'req/head.php'; ?>
<!-- SPECIFIC CSS -->
<link href="lib/css/blog.css" rel="stylesheet">

<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<main>
    <section class="hero_in general">
        <div class="wrapper">
            <div class="container">
                <h1 class="fadeInUp"><span></span> Blog</h1>
            </div>
        </div>
    </section>
    <!--/hero_in-->

    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-9">
                <div class="bloglist singlepost">
                    <?php if (!empty($detail->picture)) { ?>
                    <p><img alt="" class="img-fluid" src="data/blog/<?= htmlspecialchars($detail->picture) ?>"></p>
                    <?php } ?>
                    <h1><?= htmlspecialchars($detail->name) ?></h1>
                    <div class="postmeta">
                        <ul>
                            <?php 
                            $katSql = "SELECT * FROM the_blog_category WHERE category_id = ?";
                            $katStmt = $con->prepare($katSql);
                            $katStmt->bind_param('i', $detail->blog_category_id);
                            $katStmt->execute();
                            $katResult = $katStmt->get_result();
                            $katBuls = $katResult->fetch_object(); 
                            if ($katBuls): 
                            ?>
                                <li>
                                    <a href="blog/kategori/<?= htmlspecialchars($katBuls->slug) ?>/<?= htmlspecialchars($katBuls->category_id) ?>">
                                        <i class="icon_folder-alt"></i> <?= htmlspecialchars($katBuls->name) ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="#"><i class="icon_clock_alt"></i> <?= timeTR($detail->created_at) ?></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /post meta -->
                    <div class="post-content">
                        <div class="dropcaps">
                            <?= $detail->content ?? '' ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /post -->
                </div>
                <!-- /single-post -->

                <div id="comments">
                    <h5>Kommentare</h5>
                    <div><?php include 'inc/fb.comment.php'; ?></div>
                </div>
            </div>
            <!-- /col -->

            <aside class="col-lg-3">
                <?php include 'inc/blog.side.php'; ?>
            </aside>
            <!-- /aside -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</main>
<!--/main-->

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>
