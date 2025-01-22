<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$id = g('id');
$stmt = $con->prepare("SELECT * FROM ilce WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$view = $stmt->get_result()->fetch_object();
$stmt->close();
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Region Name </h1>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Region Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($view->ilce_adi) ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">

                                <div class="form-group">
                                    <label class="form-label">Bağlantılı Olduğu İl</label>
                                    <select name="il_id" id="il_id" class="form-control custom-select">
                                        <option value="0">İl Seçiniz</option>
                                        <?php
                                        $result = $con->query("SELECT * FROM il ORDER BY il_adi ASC");
                                        while ($hotelLis = $result->fetch_object()) {
                                            ?>
                                            <option value="<?= $hotelLis->id ?>" <?= ($view->il_id == $hotelLis->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($hotelLis->il_adi) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input"
                                                <?= ($view->status == '1') ? 'checked' : '' ?>>
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input"
                                                <?= ($view->status == '0') ? 'checked' : '' ?>>
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit"
                                    onclick="kobySubmit('?do=state&q=edit&id=<?= $view->id ?>','state-list')"
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