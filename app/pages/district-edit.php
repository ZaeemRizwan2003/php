<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
// Fetch the ID from the request
$id = g('id');

// Use a prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM semt WHERE id = ?");
$stmt->bind_param("i", $id); // Bind the id as an integer
$stmt->execute();
$view = $stmt->get_result()->fetch_object();
$stmt->close();
?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Gegend Name</h1>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Semt Adı</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($view->semt_adi, ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <div class="form-group">
                                    <label class="form-label">Bağlantılı Olduğu İl</label>
                                    <select name="il_id" id="il_id" class="form-control custom-select">
                                        <option value="0">İl Seçiniz</option>
                                        <?php
                                        // Use prepared statement for fetching provinces
                                        $stmt_il = $con->prepare("SELECT * FROM il ORDER BY il_adi ASC");
                                        $stmt_il->execute();
                                        $result_il = $stmt_il->get_result();
                                        while ($hotelLis = $result_il->fetch_object()) {
                                            ?>
                                            <option value="<?= $hotelLis->id ?>" <?php if ($view->il_id == $hotelLis->id) {
                                                  echo 'selected';
                                              } ?>>
                                                <?= htmlspecialchars($hotelLis->il_adi, ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php }
                                        $stmt_il->close();
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Region auswählen</label>
                                    <select class="form-control" name="ilce_id" id="ilce" style="width: 100%;">
                                        <option value="0">Stadt auswählen</option>
                                        <?php
                                        // Use prepared statement for fetching districts
                                        $stmt_ilce = $con->prepare("SELECT * FROM ilce ORDER BY ilce_adi ASC");
                                        $stmt_ilce->execute();
                                        $result_ilce = $stmt_ilce->get_result();
                                        while ($hotelLis = $result_ilce->fetch_object()) {
                                            ?>
                                            <option value="<?= $hotelLis->id ?>" <?php if ($view->ilce_id == $hotelLis->id) {
                                                  echo 'selected';
                                              } ?>>
                                                <?= htmlspecialchars($hotelLis->ilce_adi, ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php }
                                        $stmt_ilce->close();
                                        ?>
                                    </select>
                                </div>

                                <script src="assets/js/selectchained.js" type="text/javascript"></script>
                                <script>
                                    $("#ilce").remoteChained("#il", "req/ajax.php?do=il-ilce&q=secim&ilce=83");
                                </script>

                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
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

                                <button type="submit"
                                    onclick="kobySubmit('?do=district&q=edit&id=<?= $view->id ?>','district-list')"
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