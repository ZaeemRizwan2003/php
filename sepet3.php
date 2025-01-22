<?php 
require_once 'req/start.php'; 
require_once 'req/head_start.php'; 

$title = htmlspecialchars($general['site_title']->value, ENT_QUOTES, 'UTF-8'); 
?>

<title><?=$title;?></title>

<?php 
require_once 'req/head.php'; 
require_once 'req/body_start.php'; 
require_once 'req/header.php'; 

// Ensure session is started and the required session data exists
session_start(); 

$rezervasyonNo = $_SESSION['sepet']['rezervasyonNumarasi'] ?? '';
if ($rezervasyonNo) {
    $stmt = $con->prepare("SELECT * FROM reservations WHERE rezervation_number = ?");
    $stmt->bind_param("s", $rezervasyonNo);
    $stmt->execute();
    $rezDetail = $stmt->get_result()->fetch_object();
    
    $stmt2 = $con->prepare("SELECT * FROM users WHERE id = ?");
    $stmt2->bind_param("i", $rezDetail->user_id);
    $stmt2->execute();
    $userDetail = $stmt2->get_result()->fetch_object();

    $sepetim__urunler = $_SESSION['sepet']['rezervasyon'] ?? [];
    
    foreach ($sepetim__urunler as $sepetim__urun) {
        $rez_type = $sepetim__urun['rez_type'];
        $tour_id = $sepetim__urun['tour_id'];
        $tour_dates = $sepetim__urun['tour_dates'];
        $person_size = $sepetim__urun['person_size'];
        $child_size = $sepetim__urun['child_size'];

        $stmt3 = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
        $stmt3->bind_param("i", $tour_id);
        $stmt3->execute();
        $paketbul = $stmt3->get_result()->fetch_object();

        $stmt4 = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ? AND date_id = ?");
        $stmt4->bind_param("ii", $tour_id, $tour_dates);
        $stmt4->execute();
        $tarihbul = $stmt4->get_result()->fetch_object();

        $yetiskinFiyat = $tarihbul->person_price * $person_size;
        $CocukFiyat = $tarihbul->child_price * $child_size;
        $fiyat = $yetiskinFiyat + $CocukFiyat;
    }
}
?>
<div class="hero_in cart_section last">
    <div class="wrapper">
        <div class="container">
            <div class="bs-wizard clearfix">
                <div class="bs-wizard-step">
                    <div class="text-center bs-wizard-stepnum">Reservationsdetails</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="reservierung" class="bs-wizard-dot"></a>
                </div>

                <div class="bs-wizard-step">
                    <div class="text-center bs-wizard-stepnum">Rechnungsdetails</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="reservierung/2/<?=$rezervasyonNo?>" class="bs-wizard-dot"></a>
                </div>

                <div class="bs-wizard-step">
                    <div class="text-center bs-wizard-stepnum">Zahlung & Bestätigung</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="reservierung/3/<?=$rezervasyonNo?>" class="bs-wizard-dot"></a>
                </div>
            </div>
            <!-- End bs-wizard -->
            <div id="confirm">
                <h4>Sie erhalten in kürze eine E-Mail.</h4>
                <p>Bitte kontrollieren Sie ebenfalls ihren Spam-Ordner. <br> Bitte Überweisen Sie den Betrag an unser Konto Sparkasse Prignitz <br> Konto Inhaber: Magnus Ferdinand Karlsson <br> IBAN: DE 35 1605 0101 1010 0135 87 <br>BIC: WELADED1PRP Buchungsnummer: <?=$rezervasyonNo?></p>
            </div>
        </div>
    </div>
</div>
<!--/hero_in-->

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/script.php'; ?>
<?php require_once 'req/body_end.php'; ?>
