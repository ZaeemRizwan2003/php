<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Otel Ekle
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Hotel Name</label>
                                <input type="text" class="form-control" name="name">
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
                                            $stmt = $con->query("SELECT * FROM il");
                                            while ($il = $stmt->fetch_assoc()): ?>
                                                <option value="<?= $il['id']; ?>"> <?= $il['il_adi']; ?> </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Region auswählen</label>
                                        <select class="form-control" name="state" id="ilce" style="width: 100%;">
                                            <option value="0">Stadt auswählen</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Semt Seçiniz</label>
                                        <select class="form-control" name="district" id="semt" style="width: 100%;">
                                            <option value="0">Stadt auswählen</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <label class="form-label">Bezirk</label>
                                        <select class="form-control" name="neighborhood" id="mahalle"
                                            style="width: 100%;">
                                            <option value="0">Stadt auswählen</option>
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
                                <p class="help-block">
                                    Bitte wählen Sie möglichst genau Ihre Lage aus, da diese auf der Seite bei der
                                    Wegbeschreibung angezeigt wird.
                                </p>
                            </div>

                            <div class="form-group">
                                <label for="name" class="form-label">Lage auswählen</label>
                                <div id="us3" style="height: 310px;"></div>
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
                                    enableAutocomplete: true
                                });
                            </script>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <div class="form-group">
                                    <label class="form-label">Hotel Sterne Kategorie</label>
                                    <select name="stars" id="stars" class="form-control custom-select">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i; ?>"><?= $i; ?> Stern</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Wallpaper Bild</label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" name="picture">
                                    </div>
                                </div>

                                <?php
                                $categories = $con->query("SELECT * FROM the_hotel_category ORDER BY name ASC");
                                ?>
                                <div class="form-group">
                                    <label class="form-label">Kategorie</label>
                                    <select name="hotel_category_id" id="hotel_category_id"
                                        class="form-control custom-select">
                                        <?php while ($category = $categories->fetch_assoc()): ?>
                                            <option value="<?= $category['category_id']; ?>"><?= $category['name']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input"
                                                checked>
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input">
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" onclick="kobySubmit('?do=hotel&q=add','hotel-list')"
                                    class="btn btn-block btn-success btn-lg">
                                    Speichern und Schließen <i class="fe fe-save"></i>
                                </button>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>