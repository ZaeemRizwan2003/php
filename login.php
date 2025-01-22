<?php require_once 'req/start.php'; ?>

<?php require_once 'req/head_start.php'; ?>
<title>Anmeldung - <?=$general['site_title']->value;?></title>
<?php require_once 'req/head.php'; ?>
<?php require_once 'req/script.php'; ?>
<body id="register_bg">
    <nav id="menu" class="fake_menu"></nav>

    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <!-- End Preload -->

    <div id="login">
        <aside>
            <figure>
                <a href="./">
                    <img src="lib/img/logo_sticky.png" width="155" height="36" data-retina="true" alt="" class="logo_sticky">
                </a>
            </figure>
            <div class="">

                <?php
                @$q = g('q');
                if ($q == 'aktivasyon') {
                    @$eposta = g('email');
                    @$active_kod = g('kod');
                    if ($aktivasyon || $eposta || $active_kod) {
                        // Check if the user exists with the provided email and activation code
                        $sorgu = "SELECT count(id) FROM users WHERE email = :email AND active_kod = :active_kod";
                        $stmt = $con->prepare($sorgu);
                        $stmt->execute(['email' => $eposta, 'active_kod' => $active_kod]);
                        $userCount = $stmt->fetchColumn(); // Get the count of matching records

                        if ($userCount > 0) {
                            // Check if the user is inactive (status = 0)
                            $sorgu2 = "SELECT * FROM users WHERE email = :email AND active_kod = :active_kod AND durum = 0";
                            $stmt2 = $con->prepare($sorgu2);
                            $stmt2->execute(['email' => $eposta, 'active_kod' => $active_kod]);
                            $sonuc2 = $stmt2->fetch(); // Fetch the user record

                            if ($sonuc2) {
                                // User found, update the status
                                $userUpdate = $con->prepare("UPDATE users SET
                                    activation_date = :activation_date,
                                    activation_ip = :activation_ip,
                                    durum = 1
                                    WHERE email = :email AND active_kod = :active_kod");

                                $userUpdate->execute([
                                    'activation_date' => $simdikiZaman,
                                    'activation_ip' => $ipAdresi,
                                    'email' => $eposta,
                                    'active_kod' => $active_kod
                                ]);

                                if ($userUpdate) {
                                    echo bilgi('Erfolgreich', 'Erfolgreich aktiviert, Sie können sich jetzt anmelden.', 'success');
                                } else {
                                    echo bilgi('Error', 'Die Aktivierung konnte nicht abgeschlossen werden. Versuchen Sie es später erneut. Wenn das Problem weiterhin besteht, wenden Sie sich an uns.', 'danger');
                                }
                            } else {
                                echo bilgi('Information', 'Diese E-Mail-Adresse wurde bereits genehmigt. Bitte melden Sie sich an.', 'warning');
                            }
                        } else {
                            echo BILGI('Error', 'Auf unserer Website ist keine solche E-Mail-Adresse registriert..', 'danger');
                        }
                    }
                }
                ?>

            </div>
            <form id="userLogin" action="" onsubmit="return false" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                    <i class="icon_mail_alt"></i>
                </div>
                <div class="form-group">
                    <label>Passwort</label>
                    <input type="password" class="form-control" name="password" id="password" value="">
                    <i class="icon_lock_alt"></i>
                </div>
                <div class="clearfix add_bottom_30">
                    <div class="float-right mt-1"><a id="forgot" href="javascript:void(0);">Passwort vergessen?</a></div>
                </div>
                <button class="btn_1 rounded full-width" onclick="userLogin('<?=$rezervasyonNo?>');" type="submit"> Anmeldung </button>
                <div class="text-center add_top_10"><strong><a href="register">Anmelden!</a></strong></div>
            </form>

            <div class="text-center"><a class="btn btn-primary" href="/"> <i class="fa fa-home"></i> Home</a></div>
            <div class="copy">© <?=date('Y')?> Sungate24</div>
        </aside>
    </div>
    <!-- /login -->


<?php require_once 'req/body_end.php'; ?>

<script>
    function userLogin(reservationNo) {
        var email = $('#email').val();
        var password = $('#password').val();

        if (email == '' || password == '') {
            alert('Bitte füllen Sie alle Felder aus!');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'data/ajax/user_login.php',
            data: {
                email: email,
                password: password,
                rezervasyonNo: reservationNo
            },
            success: function(response) {
                if (response == 'success') {
                    window.location.href = 'dashboard.php'; // Redirect after successful login
                } else {
                    alert('Login fehlgeschlagen, bitte versuchen Sie es erneut.');
                }
            }
        });
    }
</script>

</body>
</html>
