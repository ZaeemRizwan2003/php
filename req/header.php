<header class="header menu_fixed">
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div><!-- /Preload -->
    <div id="logo">
        <a href="./">
            <img src="lib/img/logo.png" width="150" data-retina="true" alt="" class="logo_normal">
            <img src="lib/img/logo_sticky.png" width="100" data-retina="true" alt="" class="logo_sticky">
        </a>

        <a href="tel:08007118217">
            <img src="data/logo2_phone.png" width="200" class="img-fluid" alt="">
        </a>
    </div>
    <ul id="top_menu">
        <?php if (!empty($_SESSION['uye'])) { ?>
            <li><a href="account" class="login" title="Account"> Mein Konto</a></li>
        <?php } else { ?>
            <li><a href="login" id="sign-in" class="login" title="Sign In"> Anmeldung</a></li>
        <?php } ?>
    </ul>
    <!-- /top_menu -->
    <a href="#menu" class="btn_mobile">
        <div class="hamburger hamburger--spin" id="hamburger">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
    </a>
    <nav id="menu" class="main-menu">
        <ul>
            <li><span><a href="./"> Home </a></span></li>
            <li><span><a href="javascript:void(0)"> Tours </a></span>
                <ul>
                    <?php
                    $stmt = $con->prepare("SELECT * FROM the_tour_category");
                    $stmt->execute();
                    $result = $stmt->get_result();  // Use get_result() to fetch data
                    while ($turKategori = $result->fetch_object()) {
                        ?>
                        <li><a
                                href="tours/<?= htmlspecialchars($turKategori->slug) ?>/<?= htmlspecialchars($turKategori->category_id) ?>"><?= htmlspecialchars($turKategori->name) ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li><span><a href="hotels">Hotels</a></span>
                <ul>
                    <?php
                    $stmt = $con->prepare("SELECT * FROM the_hotel_category");
                    $stmt->execute();
                    $result = $stmt->get_result();  // Use get_result() to fetch data
                    while ($otelKategori = $result->fetch_object()) {
                        ?>
                        <li><a
                                href="hotels/<?= htmlspecialchars($otelKategori->slug) ?>/<?= htmlspecialchars($otelKategori->category_id) ?>"><?= htmlspecialchars($otelKategori->name) ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <li><span><a href="blog"> Blog</a></span></li>
            <li><span><a href="faq">FAQ</a></span></li>
            <li><span><a href="contact"> Kontakt </a></span></li>
            <?php if (!empty($_SESSION['uye'])) {
                $userEmail = $_SESSION['uye']['hzu_eposta'] ?? '';
                $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param('s', $userEmail);
                $stmt->execute();
                $result = $stmt->get_result();  // Use get_result() to fetch data
                $loginUserDetail = $result->fetch_object();  // Fetch the user object
                ?>
                <li><span><a href="javascript:void(0)">Mein Konto</a></span>
                    <ul>
                        <li><a href="mein-konto"><i class="fa fa-user-o"></i> Mein Konto</a></li>
                        <li><a href="abrechnungs-informationen"><i class="fa fa-briefcase"></i> Meine
                                Rechnungsinformationen</a></li>
                        <li><a href="meinebuchung"><i class="fa fa-shopping-basket"></i> Meine Buchung</a></li>
                        <li><a href="cikis-yap"><i class="fa fa-power-off"></i> Abmelden</a></li>
                    </ul>
                </li>
            <?php } else { ?>
                <li><span><a href="login"> Einloggen</a></span></li>
            <?php } ?>
        </ul>
    </nav>
</header>
<!-- /header -->