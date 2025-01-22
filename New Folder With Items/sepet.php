<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>
<?php
    $rezervasyonNo = $_SESSION["sepet"]["rezervasyonNumarasi"] ?? '';
	if($_GET){
		$q = $_GET["q"] ?? '';
		if($q === 'sepeti_bosalt'){
			unset($_SESSION["sepet"]);
			header('Location: sepetim');
			exit;
		}
	}
?>
<meta name="author" content="Ansonika">
<title>Panagea | Premium site template for travel agencies, hotels and restaurant listing.</title>

<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<?php 
    $sepetim__urunler = $_SESSION['sepet']['rezervasyon'] ?? [];
    foreach ($sepetim__urunler as $sepetim__urun) {
        $rez_type = $sepetim__urun['rez_type'];

        if($rez_type === 'tour'){
            $tour_id = $sepetim__urun['tour_id'];
            $tour_dates = $sepetim__urun['tour_dates'];
            $person_size = $sepetim__urun['person_size'];
            $child_size = $sepetim__urun['child_size'];

          // Get the tour data
$stmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = :tour_id");
$stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
$stmt->execute();
$paketbul = $stmt->fetch();

// Get the tour date data
$stmt2 = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = :tour_id AND date_id = :date_id");
$stmt2->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
$stmt2->bindParam(':date_id', $tour_dates, PDO::PARAM_INT);
$stmt2->execute();
$tarihbul = $stmt2->fetch();


            $yetiskinFiyat = $tarihbul->person_price * $person_size;
            $CocukFiyat = $tarihbul->child_price * $child_size;
            $fiyat = $yetiskinFiyat + $CocukFiyat;
        }else{
            $hotel_id = $sepetim__urun['hotel_id'];
            $room_id = $sepetim__urun['room_id'];
            $dates = $sepetim__urun['dates'];
            $person_size = $sepetim__urun['person_size'];
            $child_size = $sepetim__urun['child_size'];

         // Get the hotel data
$stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = :hotel_id");
$stmt->bindParam(':hotel_id', $hotel_id, PDO::PARAM_INT);
$stmt->execute();
$paketbul = $stmt->fetch();

// Get the room data
$stmt2 = $con->prepare("SELECT * FROM the_hotel_room WHERE room_id = :room_id");
$stmt2->bindParam(':room_id', $room_id, PDO::PARAM_INT);
$stmt2->execute();
$odaBul = $stmt2->fetch();


            $yetiskinFiyat = $odaBul->person_price * $person_size;
            $CocukFiyat = $odaBul->child_price * $child_size;
            $fiyat = $yetiskinFiyat + $CocukFiyat;
        }
    }
?>

<?php if (empty($_SESSION["sepet"])) { ?>
    <div class="hero_in cart_section last">
        <div class="wrapper">
            <div class="container">
                <div id="confirm">
                    <h4> Boş </h4>
                    <p> Sepet Boş </p>
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="hero_in cart_section">
        <div class="wrapper">
            <div class="container">
                <div class="bs-wizard clearfix">
                    <div class="bs-wizard-step active">
                        <div class="text-center bs-wizard-stepnum"> Rezervasyon Detayları </div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="rezervasyon" class="bs-wizard-dot"></a>
                    </div>

                    <div class="bs-wizard-step disabled">
                        <div class="text-center bs-wizard-stepnum">Fatura Detayları</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="rezervasyon/2/<?=$rezervasyonNo?>" class="bs-wizard-dot"></a>
                    </div>

                    <div class="bs-wizard-step disabled">
                        <div class="text-center bs-wizard-stepnum">Ödeme ve Onay</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="rezervasyon/3/<?=$rezervasyonNo?>" class="bs-wizard-dot"></a>
                    </div>
                </div>
                <!-- End bs-wizard -->
            </div>
        </div>
    </div>
    <!--/hero_in-->
    <div class="bg_color_1">
        <div class="container margin_60_35">
            <div class="row">
                <div class="col-lg-8">
                    <div class="box_cart">
                        <table class="table table-striped cart-list">
                            <thead>
                            <tr>
                                <th>
                                    Ürün Adı
                                </th>
                                <th>
                                    Fiyat
                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>
                                    <?php if($hotel_id){ ?>
                                    <span class="item_cart">
                                        <h4><?=$paketbul->name?></h4> <br>
                                    </span>
                                    <?php }else{ ?>
                                    <span class="item_cart">
                                        <h4><?=$paketbul->name?></h4> <br>
                                            <?php ?>
                                            <?=dateTR($tarihbul->tour_start_date)?> - <?=dateTR($tarihbul->tour_finish_date)?>
                                    </span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <strong><?=$fiyat?> € </strong>
                                </td>
                                <td class="options" style="width:5%; text-align:center;">
                                    <!--<a href="#"><i class="icon-trash"></i></a> !-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="cart-options clearfix">
                            <div class="float-left">
                                <!--
                                <div class="apply-coupon">
                                    <div class="form-group">
                                        <input type="text" name="coupon-code" value="" placeholder="Your Coupon Code" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn_1 outline">Apply Coupon</button>
                                    </div>
                                </div>
                                !-->
                            </div>
                            <div class="float-right fix_mobile">
                                <a href="rezervasyon?q=sepeti_bosalt" class="btn_1 outline"> Sepeti Boşalt</a>
                            </div>
                        </div>
                        <!-- /cart-options -->
                    </div>
                </div>
                <!-- /col -->

                <aside class="col-lg-4" id="sidebar">
                    <div class="box_detail">
                        <div id="total_cart">
                            Total <span class="float-right"><?=$fiyat?> € </span>
                        </div>
                        <ul class="cart_details">
                            <?php if($hotel_id){ ?>
                            <li>Tarih: <span><?=$dates?></span></li>
                            <?php }else{ ?>
                            <li>Başlangıç Tarihi: <span><?=dateTR($tarihbul->tour_start_date)?></span></li>
                            <li>Bitiş Tarihi: <span><?=dateTR($tarihbul->tour_finish_date)?></span></li>
                            <?php } ?>
                            <li>Erwachsene: <span><?=$person_size?></span></li>
                            <li>Anzahl Kinder: <span><?=$child_size?></span></li>
                        </ul>
                        <button onclick="$.siparisiTamamla('<?=$rezervasyonNo?>')"  class="btn_1 full-width purchase">Rezervasyonu Tamamla</button>
                        <div class="text-center"><small>Kinder ab 12 Jahren zahlen den vollen Preis.</small></div>
                    </div>
                </aside>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_color_1 -->
    <?php } ?>
  
<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>

<?php
$link = isset($hotel_id) ? 'orezervasyonTwo' : 'rezervasyonTwo';
?>
<script type="text/javascript">
$(document).ready(function(){
    $.siparisiTamamla = function(value){
        $.ajax({
            url: '<?=$link?>',
            type: "post",
            data: {id: value},
            dataType: "json",
            success: function(cevap){
                if(cevap.hata){
                    alert(cevap.hata);
                } else if(cevap.bos){
                    alert(cevap.bos);
                } else {
                    window.location.href = "rezervasyon/2/" + value;
                }
            }
        });
    }
});
</script>

<?php require_once 'req/body_end.php'; ?>
