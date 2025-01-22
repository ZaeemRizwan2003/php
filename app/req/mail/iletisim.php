<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure to install PHPMailer using Composer

?>
<html>
<head>
    <meta http-equiv="Content-Language" content="tr">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Örnek iletişim formu</title>
</head>
<body>
<fieldset style="width:400px;">
    <h3><a href="iletisim.php">İletişim Formu</a></h3>
    <form method="post" action="iletisim.php?islem">
        <p><input type="text" name="isim" size="20" /> <label for="isim"> <b>Adınız</b> </label></p>

        <p><input type="text" name="eposta" size="20" /> <label for="eposta"> <b>Eposta Adresiniz</b> </label></p>

        <p><input type="text" name="konu" size="20" /> <label for="konu"> <b>Konu</b> </label></p>
        <p><textarea rows="6" name="mesaj" cols="30"></textarea> <label for="mesaj"> <b>Mesajınız</b> </label></p>

        <p><input type="reset" value="Sıfırla" /> <input type="submit" value="Gönder" /></p> 
        <?php
        if (isset($_GET['islem'])) {

            if (!empty($_POST['eposta']) && !empty($_POST['isim']) && !empty($_POST['konu']) && !empty($_POST['mesaj'])) {

                // Create PHPMailer instance
                $con = new PHPMailer(true); // Set to true for exceptions
                try {
                    $con->isSMTP();
                    $con->Host = 'mail.londoneducation.net';
                    $con->SMTPAuth = true;
                    $con->SMTPAutoTLS = true;
                    $con->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $con->Username = 'site@londoneducation.net';
                    $con->Password = 'oPrt$538';
                    $con->setFrom('erdinc@bongotravel.net', $_POST['isim']);
                    $con->addAddress('site@londoneducation.net', 'London Education');
                    $con->Subject = $_POST['konu'] . " " . $_POST['eposta'];
                    $con->Body = $_POST['mesaj'];

                    // Send email
                    $con->send();
                    echo '<font color="#41A317"><b>Mesaj başarıyla gönderildi.</b></font>';
                } catch (Exception $e) {
                    echo '<font color="#F62217"><b>Gönderim Hatası: ' . $con->ErrorInfo . '</b></font>';
                }

            } else {
                echo '<font color="#F62217"><b>Tüm alanlarınız doldurulması zorunludur.</b></font>';
            }
        }
        ?>
    </form>
</fieldset>
</body>
</html>
