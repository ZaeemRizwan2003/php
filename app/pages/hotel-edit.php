<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$id = g('id');
$view = $con->query("SELECT * FROM the_hotel WHERE hotel_id = '$id'")->fetch_object();
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Otel Düzenle
            </h1>
        </div>

        <div class="card">

            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Hotel Name</label>
                                <input type="text" class="form-control" name="name" value="<?= $view->name ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Inhalt </label>
                                <textarea class="form-control" id="editor" name="content"><?= $view->content ?></textarea>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Stadt auswählen</label>
                                        <select class="form-control" name="province" id="il" style="width: 100%;">
                                            <option value="0"> Stadt auswählen </option>
                                            <?php
                                            $iller = $con->query("SELECT * FROM il");
                                            while ($il = $iller->fetch_object()) {
                                                ?>
                                                <option value="<?php echo $il->id; ?>" <?php if ($il->id == $view->province) {
                                                       echo 'selected';
                                                   } ?>>
                                                    <?php echo $il->il_adi; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Region auswählen</label>
                                        <select class="form-control" name="state" id="ilce" style="width: 100%;">
                                            <option value="0"> Stadt auswählen </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Semt Seçiniz</label>
                                        <select class="form-control" name="district" id="semt" style="width: 100%;">
                                            <option value="0"> Stadt auswählen </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Bezirk</label>
                                        <select class="form-control" name="neighborhood" id="mahalle"
                                            style="width: 100%;">
                                            <option value="0"> Stadt auswählen </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <script src="assets/js/selectchained.js" type="text/javascript"></script>
                            <script>
                                $("#ilce").remoteChained("#il", "req/ajax.php?do=il-ilce&q=secim&ilce=<?= $view->state ?>");
                                $("#semt").remoteChained("#ilce", "req/ajax.php?do=il-ilce&q=secim&semt=<?= $view->district ?>");
                                $("#mahalle").remoteChained("#semt", "req/ajax.php?do=il-ilce&q=secim&mahalle=<?= $view->neighborhood ?>");
                            </script>

                            <div class="form-group">
                                <label class="form-label">Nach Adresse suchen::</label>
                                <input type="text" class="form-control" id="us3-address" placeholder="" />
                                <p class="help-block">Bitte wählen Sie möglichst genau Ihre Lage aus, da diese auf der
                                    Seite bei der Wegbeschreibung angezeigt wird.</p>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Lage auswählen</label>
                                <div id="us3" style="height: 310px;"></div>
                                <p class="help-block">Bitte wählen Sie möglichst genau Ihre Lage aus, da diese auf der
                                    Seite bei der Wegbeschreibung angezeigt wird.</p>
                                <input type="hidden" name="location_latitude" id="us3-lat"
                                    value="<?= $view->location_latitude ?>" />
                                <input type="hidden" name="location_longitude" id="us3-lon"
                                    value="<?= $view->location_longitude ?>" />
                            </div>
                            <script>
                                $('#us3').locationpicker({
                                    location: { latitude: <?= $view->location_latitude ?>, longitude: <?= $view->location_longitude ?> },
                                    radius: 0,
                                    inputBinding: {
                                        latitudeInput: $('#us3-lat'),
                                        longitudeInput: $('#us3-lon'),
                                        locationNameInput: $('#us3-address')
                                    },
                                    enableAutocomplete: true,
                                    onchanged: function (currentLocation, radius, isMarkerDropped) {
                                        // Uncomment line below to show alert on each Location Changed event
                                        //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
                                    }
                                });
                            </script>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">

                                <div class="form-group">
                                    <div class="form-label">Wallpaper Bild</div>
                                    <?php if ($view->picture) { ?>
                                        <div><img src="../data/hotel/<?= $view->picture ?>"
                                                class="img-thumbnail img-responsive" alt=""></div>
                                        <div class="help-block">Resimi değiştirmeyecekseniz lütfen herhangi bir resim seçimi
                                            yapmayınız.</div>
                                        <br>
                                    <?php } ?>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" name="picture">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Hotel Sterne Kategorie</label>
                                    <select name="stars" id="stars" class="form-control custom-select">
                                        <option value="1" <?php if ($view->stars == '1') {
                                            echo 'selected';
                                        } ?>>1 Stern
                                        </option>
                                        <option value="2" <?php if ($view->stars == '2') {
                                            echo 'selected';
                                        } ?>>2 Stern
                                        </option>
                                        <option value="3" <?php if ($view->stars == '3') {
                                            echo 'selected';
                                        } ?>>3 Stern
                                        </option>
                                        <option value="4" <?php if ($view->stars == '4') {
                                            echo 'selected';
                                        } ?>>4 Stern
                                        </option>
                                        <option value="5" <?php if ($view->stars == '5') {
                                            echo 'selected';
                                        } ?>>5 Stern
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Kategorie</label>
                                    <select name="hotel_category_id" id="hotel_category_id"
                                        class="form-control custom-select">
                                        <?php
                                        $kategoriler = $con->query("SELECT * FROM the_hotel_category ORDER BY name ASC");
                                        while ($kategori = $kategoriler->fetch_object()) {
                                            ?>
                                            <option value="<?= $kategori->category_id ?>" <?php if ($kategori->category_id == $view->hotel_category_id) {
                                                echo 'selected';
                                            } ?>>
                                                <?= $kategori->name ?></option>';
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Konaklama Tipi</label>
                                    <select name="accommodation_type_id" id="accommodation_type_id"
                                        class="form-control custom-select">
                                        <?php
                                        $konaklamaTipleri = $con->query("SELECT * FROM the_hotel_accommodation ORDER BY name ASC");
                                        while ($konaklamaTipi = $konaklamaTipleri->fetch_object()) {
                                            ?>
                                            <option value="<?= $konaklamaTipi->accommodation_id ?>" <?php if ($konaklamaTipi->accommodation_id == $view->accommodation_type_id) {
                                                echo 'selected';
                                            } ?>> <?= $konaklamaTipi->name ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Otel Tipi</label>
                                    <select name="hotel_type_id" id="hotel_type_id" class="form-control custom-select">
                                        <?php
                                        $otelTipleri = $con->query("SELECT * FROM the_hotel_type ORDER BY name ASC");
                                        while ($otelTipi = $otelTipleri->fetch_object()) {
                                            ?>
                                            <option value="<?= $otelTipi->type_id ?>" <?php if ($otelTipi->type_id == $view->hotel_type_id) {
                                                echo 'selected';
                                            } ?>>
                                                <?= $otelTipi->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Otel Tipi</label>
                                    <select name="hotel_theme_id" id="hotel_theme_id"
                                        class="form-control custom-select">
                                        <?php
                                        $otelTemalari = $con->query("SELECT * FROM the_hotel_theme ORDER BY name ASC");
                                        while ($otelTemasi = $otelTemalari->fetch_object()) {
                                            ?>
                                            <option value="<?= $otelTemasi->theme_id ?>" <?php if ($otelTemasi->theme_id == $view->hotel_theme_id) {
                                                echo 'selected';
                                            } ?>>
                                                <?= $otelTemasi->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Ürün Durumu</label>
                                    <select name="status" id="status" class="form-control custom-select">
                                        <option value="1" <?php if ($view->status == '1') {
                                            echo 'selected';
                                        } ?>>Aktif
                                        </option>
                                        <option value="0" <?php if ($view->status == '0') {
                                            echo 'selected';
                                        } ?>>Pasif
                                        </option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>