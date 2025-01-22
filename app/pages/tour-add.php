<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Tour hinzufügen
            </h1>
        </div>

        <div class="card">

            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Tour Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Inhalt</label>
                                <textarea class="form-control" id="editor" name="content"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Stadt auswählen</label>
                                        <select class="form-control" name="province" id="il" style="width: 100%;">
                                            <option value="0">Stadt auswählen</option>
                                            <?php
                                            $iller = $con->query("SELECT * FROM il");
                                            while ($il = $iller->fetch_object()) {
                                                ?>
                                                <option value="<?php echo $il->id; ?>">
                                                    <?php echo htmlspecialchars($il->il_adi); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Region auswählen</label>
                                        <select class="form-control" name="state" id="ilce" style="width: 100%;">
                                            <option value="0">Region auswählen</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Semt Seçiniz</label>
                                        <select class="form-control" name="district" id="semt" style="width: 100%;">
                                            <option value="0">Semt seçiniz</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Bezirk</label>
                                        <select class="form-control" name="neighborhood" id="mahalle"
                                            style="width: 100%;">
                                            <option value="0">Bezirk seçiniz</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <script src="assets/js/selectchained.js" type="text/javascript"></script>
                            <script>
                                $("#ilce").remoteChained("#il", "req/ajax.php?do=il-ilce&q=secim&ilce=83");
                                $("#semt").remoteChained("#ilce", "req/ajax.php?do=il-ilce&q=secim&semt=440");
                                $("#mahalle").remoteChained("#semt", "req/ajax.php?do=il-ilce&q=secim&mahalle=4833");
                            </script>

                            <div class="form-group">
                                <label class="form-label">Adresse:</label>
                                <textarea name="adress" id="adress" cols="30" rows="5" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nach Adresse suchen:</label>
                                <input type="text" class="form-control" id="us3-address" placeholder="" />
                                <p class="help-block">Bitte wählen Sie möglichst genau Ihre Lage aus, da diese auf der
                                    Seite bei der Wegbeschreibung angezeigt wird.</p>
                            </div>

                            <div class="form-group">
                                <label for="name" class="form-label">Lage auswählen</label>
                                <div id="us3" style="height: 310px;"></div>
                                <p class="help-block">Bitte wählen Sie möglichst genau Ihre Lage aus, da diese auf der
                                    Seite bei der Wegbeschreibung angezeigt wird.</p>
                                <input type="hidden" name="location_latitude" id="us3-lat" />
                                <input type="hidden" name="location_longitude" id="us3-lon" />
                            </div>

                            <script>
                                $('#us3').locationpicker({
                                    location: { latitude: 40.178137, longitude: 29.067262 },
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
                                    <label class="form-label">Hotel zuordnen</label>
                                    <select name="hotel_id" id="hotel_id" class="form-control custom-select">
                                        <?php
                                        $hotels = $con->query("SELECT * FROM the_hotel ORDER BY name ASC");
                                        while ($hotel = $hotels->fetch_object()) {
                                            ?>
                                            <option value="<?= $hotel->category_id ?>"><?= $hotel->name ?></option>';
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">Wallpaper Bild</div>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" name="picture">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Kategorie</label>
                                    <select name="tour_category_id" id="tour_category_id"
                                        class="form-control custom-select">
                                        <?php
                                        $kategoriler = $con->query("SELECT * FROM the_tour_category ORDER BY name ASC");
                                        while ($kategori = $kategoriler->fetch_object()) {
                                            ?>
                                            <option value="<?= $kategori->category_id ?>"><?= $kategori->name ?></option>';
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input"
                                                checked="">
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input">
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" onclick="kobySubmit('?do=tour&q=add','tour-list')"
                                    class="btn btn-block btn-success btn-lg">Speichern und Schließen <i
                                        class="fe fe-save"></i></button>

                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Handle form submission and save tour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
    $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_NUMBER_INT);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_NUMBER_INT);
    $district = filter_input(INPUT_POST, 'district', FILTER_SANITIZE_NUMBER_INT);
    $neighborhood = filter_input(INPUT_POST, 'neighborhood', FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING);
    $latitude = filter_input(INPUT_POST, 'location_latitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_input(INPUT_POST, 'location_longitude', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $hotel_id = filter_input(INPUT_POST, 'hotel_id', FILTER_SANITIZE_NUMBER_INT);
    $tour_category_id = filter_input(INPUT_POST, 'tour_category_id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

    // Check if fields are not empty
    if (!empty($name) && !empty($content)) {
        // Prepare the SQL query to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO the_tour (name, content, province, state, district, neighborhood, address, latitude, longitude, hotel_id, tour_category_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiisssdiis", $name, $content, $province, $state, $district, $neighborhood, $address, $latitude, $longitude, $hotel_id, $tour_category_id, $status);
        $stmt->execute();

        // Redirect or give feedback after insert
        if ($stmt->affected_rows > 0) {
            header("Location: tour-list");
            exit;
        } else {
            echo "Fehler beim Hinzufügen der Tour.";
        }
    } else {
        echo "Bitte füllen Sie alle erforderlichen Felder aus.";
    }
}
?>