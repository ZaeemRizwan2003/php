`<?php require_once 'req/start.php'; ?>
<?php require_once 'req/head_start.php'; ?>

<title><?= htmlspecialchars($general['site_title']->value, ENT_QUOTES, 'UTF-8'); ?></title>
<?php require_once 'req/head.php'; ?>
<?php require_once 'req/body_start.php'; ?>
<?php require_once 'req/header.php'; ?>

<?php
$rezervasyonNo = $_SESSION['sepet']['rezervasyonNumarasi'] ?? null;
$sepetim__urunler = $_SESSION['sepet']['rezervasyon'] ?? [];

foreach ($sepetim__urunler as $sepetim__urun) {
    $rez_type = $sepetim__urun['rez_type'];

    if ($rez_type === 'tour') {
        $tour_id = $sepetim__urun['tour_id'];
        $tour_dates = $sepetim__urun['tour_dates'];
        $person_size = $sepetim__urun['person_size'];
        $child_size = $sepetim__urun['child_size'];
        $start_date = $sepetim__urun['start_date'];
        $end_date = $sepetim__urun['end_date'];

        $stmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
        $stmt->bind_param("i", $tour_id);
        $stmt->execute();
        $paketbul = $stmt->get_result()->fetch_object();

        $stmt = $con->prepare("SELECT * FROM the_tour_date WHERE tour_id = ? AND date_id = ?");
        $stmt->bind_param("ii", $tour_id, $tour_dates);
        $stmt->execute();
        $tarihbul = $stmt->get_result()->fetch_object();

        $yetiskinFiyat = $tarihbul->person_price * $person_size;
        $CocukFiyat = $tarihbul->child_price * $child_size;
        $fiyat = $yetiskinFiyat + $CocukFiyat;
    } else {
        $hotel_id = $sepetim__urun['hotel_id'];
        $room_id = $sepetim__urun['room_id'];
        $dates = $sepetim__urun['dates'];
        $person_size = $sepetim__urun['person_size'];
        $child_size = $sepetim__urun['child_size'];
        $start_date = $sepetim__urun['start_date'];
        $end_date = $sepetim__urun['end_date'];

        $stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = ?");
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $paketbul = $stmt->get_result()->fetch_object();

        $stmt = $con->prepare("SELECT * FROM the_hotel_room WHERE room_id = ?");
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $odaBul = $stmt->get_result()->fetch_object();

        $yetiskinFiyat = $odaBul->person_price * $person_size;
        $CocukFiyat = $odaBul->child_price * $child_size;
        $fiyat = $yetiskinFiyat + $CocukFiyat;
    }

    $tarih1 = strtotime($start_date);
    $tarih2 = strtotime($end_date);
    $gunSayisi = ($tarih2 - $tarih1) / (60 * 60 * 24);
    $fiyat *= $gunSayisi;
}
?>

<div class="hero_in cart_section">
    <div class="wrapper">
        <div class="container">
            <div class="bs-wizard clearfix">
                <div class="bs-wizard-step ">
                    <div class="text-center bs-wizard-stepnum">Reservierungsdetails</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="reservierung" class="bs-wizard-dot"></a>
                </div>

                <div class="bs-wizard-step ">
                    <div class="text-center bs-wizard-stepnum">Rechnungsdetails</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="reservierung/2/<?= htmlspecialchars($rezervasyonNo, ENT_QUOTES, 'UTF-8') ?>" class="bs-wizard-dot"></a>
                </div>

                <div class="bs-wizard-step disabled">
                    <div class="text-center bs-wizard-stepnum">Zahlung & Bestätigung</div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                    <a href="reservierung/3/<?= htmlspecialchars($rezervasyonNo, ENT_QUOTES, 'UTF-8') ?>" class="bs-wizard-dot"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="reservierungEnd" action="" onsubmit="return false" method="POST">

<div class="bg_color_1">
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-lg-8">
                <div class="box_cart">
                    <div class="message">
                        <p>Haben Sie ein Benutzerkonto? <a href="login">Anmelden</a></p>
                    </div>
                    <div class="alert alert-info">
                        <strong>Füllen Sie alle Felder aus</strong>
                    </div>
                    <div class="form_title">
                        <h3><strong>1</strong>Details zum Reisenden</h3>
                        <p>Bitte geben Sie Ihre Daten fehlerfrei an</p>
                    </div>
                    <div class="step">
                        <?php 
                        $sayi = $person_size;
                        for ($kisi = 1; $kisi <= $sayi; $kisi++) :
                        ?>
                        <div style="border: 2px solid #ddd; border-radius: 10px; padding: 15px;">
                            <div><strong><?= htmlspecialchars($kisi, ENT_QUOTES, 'UTF-8') ?>. Passagierinformationen</strong></div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Geschlecht</label>
                                        <div>
                                            <select class="form-control wide add_bottom_15" name="gender[]">
                                                <option value="0">Wählen Sie ihr Geschlecht aus</option>
                                                <option value="1">Frau</option>
                                                <option value="2">Mann</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Ihr Name</label>
                                        <input type="text" class="form-control" name="firstname[]">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Ihr Nachname</label>
                                        <input type="text" class="form-control" name="lastname[]">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Geburtsdatum</label>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tag</label>
                                                    <div>
                                                        <select class="form-control wide add_bottom_15" name="day[]">
                                                            <option value="0">TT</option>
                                                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                                                                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Monat</label>
                                                    <div>
                                                        <select class="form-control wide add_bottom_15" name="month[]">
                                                            <option value="0">MM</option>
                                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $onikiyilOncesine = date('Y-m-d', strtotime('-12 years')); ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Jahr</label>
                                                    <div>
                                                        <select class="form-control wide add_bottom_15" name="year[]">
                                                            <option value="0">YYYY</option>
                                                            <?php for ($i = 1940; $i <= $onikiyilOncesine; $i++) : ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php endfor; ?>
                    </div>
                    <hr>

                    <div class="form_title">
                        <h3><strong>3</strong>Details zum Flug</h3>
                        <p>Bitte wählen Sie Ihren Abflughafen aus</p>
                    </div>
                    <div class="step">
                        <div class="form-group">
                            <label>Flughafen</label>
                            <select class="js-example-basic-single form-control" name="havalimani" id="havalimani">
                                <?php
                                $stmt = $con->prepare("SELECT * FROM airportss ORDER BY countryName ASC");
                                $stmt->execute();
                                $airports = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                foreach ($airports as $airport) :
                                ?>
                                <option value="<?= htmlspecialchars($airport['name'] . ' ' . $airport['code'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($airport['name'] . ' (' . $airport['code'] . ')', ENT_QUOTES, 'UTF-8') ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>

                    <div class="form_title">
                        <h3><strong>4</strong>Rechnungsinformationen</h3>
                        <p>Mussum ipsum cacilds, vidis litro abertis.</p>
                    </div>
                    <div class="step">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ihr Name</label>
                                    <input type="text" class="form-control" name="owner_firstname" value="<?= htmlspecialchars($loginUserDetail->firstname, ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ihr Nachname</label>
                                    <input type="text" class="form-control" name="owner_lastname" value="<?= htmlspecialchars($loginUserDetail->lastname, ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>E-Mail Adresse</label>
                                    <input type="text" class="form-control" name="owner_email" value="<?= htmlspecialchars($loginUserDetail->email, ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefonnummer</label>
                                    <input type="text" class="form-control" name="owner_phone" value="<?= htmlspecialchars($loginUserDetail->phone, ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn_1">Zur Kasse gehen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php require_once 'req/footer.php'; ?>
<?php require_once 'req/body_end.php'; ?>
`