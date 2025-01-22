<?php 
require_once 'req/start.php'; 
require_once 'req/head_start.php'; 

// Fetch the hotel slug from the URL parameter
$link = isset($_GET['link']) ? $_GET['link'] : '';

try {
    // Prepare and fetch hotel details
    $stmt = $con->prepare("SELECT * FROM the_hotel WHERE slug = :slug");
    $stmt->execute(['slug' => $link]);
    $detail = $stmt->fetch();

    if (!$detail) {
        die("Hotel not found.");
    }

    // Update view count
    $update = $con->prepare("UPDATE the_hotel SET hit = hit + 1 WHERE slug = :slug");
    $update->execute(['slug' => $link]);

    // Fetch province details
    $stmtProvince = $con->prepare("SELECT * FROM il WHERE id = :province");
    $stmtProvince->execute(['province' => $detail->province]);
    $proSrc = $stmtProvince->fetch();

    // Fetch state details
    $stmtState = $con->prepare("SELECT * FROM ilce WHERE id = :state");
    $stmtState->execute(['state' => $detail->state]);
    $staSrc = $stmtState->fetch();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<title><?=$detail->name?></title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>


<main>
    <style>
        .hero_in.hotels_detail:before{
            background-image: url('data/hotel/<?=$detail->picture?>');
        }
    </style>
    <section class="hero_in hotels_detail">
        <div class="wrapper">
            <div class="container">
                <div style="color: yellow; font-size: 32px;"><?=hotelhomeStars($detail->stars)?></div>
                <h1 class="fadeInUp" style="margin-top: 20px;"><span></span><?=$detail->name?></h1>
                <small><?=$proSrc->il_adi?> - <?=$staSrc->ilce_adi?></small>
            </div>
            <span class="magnific-gallery">
                <?php
               $stmtPictures = $con->prepare("SELECT * FROM the_hotel_picture WHERE hotel_id = :hotel_id");
               $stmtPictures->execute(['hotel_id' => $detail->hotel_id]);
               $pictures = $stmtPictures->fetchAll(PDO::FETCH_OBJ);
               $picturesRows = count($pictures);
               $i = '0';
                foreach ($pictures as $picture) {
                    $i++;
                    $content = $picture->content;
                    if(!$content){
                        $content = $detail->name;
                    }

                    ?>
                    <a href="data/hotel/pictures/<?=$picture->big_picture?>" <?php if($i== 1){ echo 'class="btn_photos"';} ?>  title="<?=$content?>" data-effect="mfp-zoom-in"> <?php if($i== 1){ echo '<i class="icon-camera"></i>  Bilder ('.$picturesRows.')';} ?></a>
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
                        <h2>Über das <strong><?=$detail->name?></strong> </h2>
                        <h3>Bilder</h3>
                        <div class="grid">
                            <ul class="magnific-gallery">
                                <?php
$stmt = $con->prepare("SELECT * FROM the_hotel_picture WHERE hotel_id = :hotel_id");
$stmt->execute(['hotel_id' => $detail->hotel_id]);
$pictures = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmtCount = $con->prepare("SELECT COUNT(*) FROM the_hotel_picture WHERE hotel_id = :hotel_id");
$stmtCount->execute(['hotel_id' => $detail->hotel_id]);
$picturesRows = $stmtCount->fetchColumn();

                                    foreach ($pictures as $picture) {
                                        $content = $picture->content;
                                        if(!$content){
                                            $content = $detail->name;
                                        }
                                ?>
                                    <li>
                                        <figure>
                                            <img src="data/hotel/pictures/<?=$picture->mini_picture?>" alt="<?=$content?>">
                                            <figcaption>
                                                <div class="caption-content">
                                                    <a href="data/hotel/pictures/<?=$picture->big_picture?>" title="<?=$content?>" data-effect="mfp-zoom-in">
                                                        <i class="pe-7s-albums"></i>
                                                        <p><?=$content?></p>
                                                    </a>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                        <!-- /grid gallery -->

                        <?=$detail->content?>
                        <hr>
                        <div id="rooms" class="clearfix">

                            <h3>Zimmer</h3>

                        </div>
                        <?php if($detail->address){ ?>
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
$stmt = $con->prepare("SELECT COUNT(*) FROM the_hotel_comment WHERE hotel_id = :hotel_id AND status = 1");
$stmt->execute(['hotel_id' => $detail->hotel_id]);
$commentsRows = $stmt->fetchColumn();
                                if($commentsRows > 0){
                            ?>


                        <div class="reviews-container">

                            <?php 
$stmt = $con->prepare("SELECT * FROM the_hotel_comment WHERE hotel_id = :hotel_id AND status = 1");
$stmt->execute(['hotel_id' => $detail->hotel_id]);
$hotelComments = $stmt->fetchAll(PDO::FETCH_OBJ);
                                foreach($hotelComments as $hotelComment){
                            ?>
                            <div class="review-box clearfix" style="padding-left:0;">
                                <div class="rev-content">
                                    <div class="rating">
                                        <?php  echo commentStars($hotelComment->rating_review); ?>
                                    </div>
                                    <div class="rev-info">
                                        <?=$hotelComment->name?> – <?=$hotelComment->created_at?>:
                                    </div>
                                    <div class="rev-text">
                                        <p>
                                            <?=$hotelComment->content?>
                                        </p>
                                    </div>
                                </div>
                            </div> 
                            <?php } ?>



                            
                        </div>
                    </section>

                    <?php }else{  ?>
                    <div class="alert alert-info">
                        Es gibt noch keine Kommentare für das Hotel.
                    </div>
                    <?php } ?>

                    <hr>

                    <div class="add-review">
                        <h5>Kommentar hinterlassen</h5>
                        <form id="hotelYorum" action="" onsubmit="return false" method="POST" >
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Vor- und Nachname *</label>
                                    <input type="text" name="name_review" id="name_review" placeholder="" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email *</label>
                                    <input type="hidden" name="hotel_id" id="hotel_id" value="<?=$detail->hotel_id?>" />
                                    <input type="email" name="email_review" id="email_review" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Bewertung </label>
                                    <div class="custom-select-form">
                                        <select name="rating_review" id="rating_review" class="wide">
                                            <option value="1">1 (lowest)</option>
                                            <option value="2">2</option>
                                            <option value="3">3 (medium)</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5 (höchste) </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Ihre persönliche Bewertung</label>
                                    <textarea name="content" id="content" class="form-control" style="height:130px;"></textarea>
                                </div>
                                <div class="form-group col-md-12 add_top_20">
                                    <button type="submit" class="btn_1" id="submit-review" onclick="$.otelYorum()"> Senden </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="col-lg-4" id="sidebar">
                    <div class="box_detail booking">

                        <?php
$stmt = $con->prepare("SELECT * FROM the_hotel_room WHERE hotel_id = :hotel_id ORDER BY person_price DESC LIMIT 1");
$stmt->execute(['hotel_id' => $detail->hotel_id]);
$enkucukFiyat = $stmt->fetch();
                        ?>

                        <div class="price">
                            <span>ab <?=$enkucukFiyat->person_price?>€ <small> pro person</small></span>
                        </div>
                        <form  id="rez_one"  method="POST" onsubmit="return false" action="" class="user-form payment">
                            <input type="hidden" name="rez_type" value="hotel">
                            <input type="hidden" name="hotel_id" value="<?=$detail->hotel_id?>">
                            <div class="form-group">
                                <input class="form-control" type="text" name="dates" id="dates" placeholder="Wann" autocomplete="off">
                                <label for="dates"><i class="icon_calendar"></i></label>
                            </div>
                            <div class="panel-dropdown">
                                <a href="#">Anzahl Personen <span class="qtyTotal">1</span></a>
                                <div class="panel-dropdown-content right">
                                    <div class="qtyButtons">
                                        <label>Erwachsene</label>
                                        <input type="text" name="person_size" class="qtyInput" value="2">
                                    </div>
                                    <div class="qtyButtons">
                                        <label>Anzahl Kinder</label>
                                        <input type="text" name="child_size" class="qtyInput" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">

                                <div class="custom-select-form">
                                    <select class="wide" name="room_id">
                                        <?php
                                      $stmt = $con->prepare("SELECT COUNT(*) FROM the_hotel_room WHERE hotel_id = :hotel_id AND status = 1");
                                      $stmt->execute(['hotel_id' => $detail->hotel_id]);
                                      $roomSearch = $stmt->fetchColumn();
                                      
                                      if ($roomSearch) {
                                        // Fetch the list of available rooms
                                        $stmtRooms = $con->prepare("SELECT * FROM the_hotel_room WHERE hotel_id = :hotel_id AND status = 1");
                                        $stmtRooms->execute(['hotel_id' => $detail->hotel_id]);
                                        $roomList = $stmtRooms->fetchAll(PDO::FETCH_OBJ);
                                    
                                        foreach ($roomList as $room) {
                                    ?>
                                            <option value="<?= htmlspecialchars($room->room_id) ?>">
                                                <?= htmlspecialchars(kisalt($room->name, 30)) ?> - ab <?= htmlspecialchars($room->person_price) ?> € p.P.
                                            </option>
                                    <?php 
                                         } ?>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <button class="btn_1 full-width purchase" type="submit"  onclick="$.rezervasyonForm(<?=$detail->tour_id?>)"> Reservieren </button>
                        </form>
                        <div class="text-center"><small> Kinder ab 12 Jahren zahlen den vollen Preis.</small></div>
                    </div>

                    <hr>

                    <div class="alert alert-warning" style="padding: 15px;"> <strong>All Inclusive!  </strong> <br><p style="padding: 0; margin:0;">Flug, Reise und Transfer im Preis enthalten.</p></div>
                    <hr>
                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c61e51d87057590"></script>

                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                    <div class="addthis_inline_share_toolbox_pyg7"></div>


                </aside>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_color_1 -->
    <?php require_once 'inc/turlar.bottom.php'; ?>

</main>
<!--/main-->


<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>


<script src="lib/js/input_qty.js"></script>
<script src="lib/js/infobox.js"></script>
<script>

$('.src-form').on('submit', function () {
    if ($(this).data("changed")) {
        alert("Something changed!");
        // Reset variable
        $(this).data("changed", false);
    } else {
        alert("Nothing changed!");
    }
    // Do whatever you want here
    // You don't have to prevent submission
    return false;
});

    $.rezervasyonForm = function(){
        var deger = $("form#rez_one").serialize();
        $.ajax({
            type: "POST",
            url: "data/ajax/rezervasyonForm.php",
            data: deger,
            success: function(response){
                if(response){
                    $('#add_booking').html(response).fadeIn();
                }else{
                    alert("Hata!");
                }
            }
        });
    };
</script>

</body>
</html>
