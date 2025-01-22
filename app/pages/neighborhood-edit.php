<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$id = g('id');

// Prepare and execute query to fetch neighborhood data
if ($stmt = $con->prepare("SELECT * FROM mahalle WHERE id = ?")) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $view = $result->fetch_object();
    $stmt->close();
}
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <h1 class="page-title"> Gegend hinzufügen Name </h1>
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label"> Stadt viertel name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($view->mahalle_adi) ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">

                                <!-- Select city (il) -->
                                <div class="form-group">
                                    <label class="form-label">Bağlantılı Olduğu İl</label>
                                    <select name="il_id" id="il_id" class="form-control custom-select">
                                        <option value="0"> İl Seçiniz</option>
                                        <?php
                                        // Prepare and execute query to fetch cities (il)
                                        if ($stmt = $con->prepare("SELECT * FROM il ORDER BY il_adi ASC")) {
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($hotelLis = $result->fetch_object()) {
                                                ?>
                                                <option value="<?= htmlspecialchars($hotelLis->id) ?>" <?php if ($view->il_id == $hotelLis->id) {
                                                      echo 'selected';
                                                  } ?>>
                                                    <?= htmlspecialchars($hotelLis->il_adi) ?></option>
                                                <?php
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Select district (ilce) -->
                                <div class="form-group">
                                    <label class="form-label">Region auswählen</label>
                                    <select class="form-control" name="ilce_id" id="ilce" style="width: 100%;">
                                        <option value="0"> Stadt auswählen </option>
                                        <?php
                                        // Prepare and execute query to fetch districts (ilce)
                                        if ($stmt = $con->prepare("SELECT * FROM ilce ORDER BY ilce_adi ASC")) {
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($hotelLis = $result->fetch_object()) {
                                                ?>
                                                <option value="<?= htmlspecialchars($hotelLis->id) ?>" <?php if ($view->ilce_id == $hotelLis->id) {
                                                      echo 'selected';
                                                  } ?>>
                                                    <?= htmlspecialchars($hotelLis->ilce_adi) ?></option>
                                                <?php
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Select neighborhood (semt) -->
                                <div class="form-group">
                                    <label class="form-label">Semt Seçiniz </label>
                                    <select class="form-control" name="semt_id" id="semt" style="width: 100%;">
                                        <option value="0"> Stadt auswählen </option>
                                        <?php
                                        // Prepare and execute query to fetch neighborhoods (semt)
                                        if ($stmt = $con->prepare("SELECT * FROM semt ORDER BY semt_adi ASC")) {
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($hotelLis = $result->fetch_object()) {
                                                ?>
                                                <option value="<?= htmlspecialchars($hotelLis->id) ?>" <?php if ($view->semt_id == $hotelLis->id) {
                                                      echo 'selected';
                                                  } ?>>
                                                    <?= htmlspecialchars($hotelLis->semt_adi) ?></option>
                                                <?php
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                    </select>
                                </div>

                                <script src="assets/js/selectchained.js" type="text/javascript"></script>
                                <script>
                                    $("#ilce").remoteChained("#il", "req/ajax.php?do=il-ilce&q=secim&ilce=83");
                                    $("#semt").remoteChained("#ilce", "req/ajax.php?do=il-ilce&q=secim&semt=440");
                                    $("#mahalle").remoteChained("#semt", "req/ajax.php?do=il-ilce&q=secim&mahalle=4833");
                                </script>

                                <!-- Display status options -->
                                <div class="form-group">
                                    <label class="form-label"> Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input" <?php if ($view->status == '1') {
                                                echo 'checked';
                                            } ?>>
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input" <?php if ($view->status == '0') {
                                                echo 'checked';
                                            } ?>>
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Save button -->
                                <button type="submit"
                                    onclick="kobySubmit('?do=neighborhood&q=edit&id=<?= htmlspecialchars($view->id) ?>','neighborhood-list')"
                                    class="btn btn-block btn-success btn-lg"> Speichern und Schließen <i
                                        class="fe fe-save"></i> </button>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>