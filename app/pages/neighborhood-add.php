<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <h1 class="page-title"> Gegend hinzufügen</h1>
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Stadt viertel name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <div class="form-group">
                                    <label class="form-label">Stadt auswählen</label>
                                    <select class="form-control" name="il_id" id="il" style="width: 100%;">
                                        <option value="0"> Stadt auswählen </option>
                                        <?php
                                        // Fetch cities (il) securely using prepared statements
                                        if ($stmt = $con->prepare("SELECT id, il_adi FROM il")) {
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($il = $result->fetch_object()) {
                                                ?>
                                                <option value="<?php echo htmlspecialchars($il->id); ?>">
                                                    <?php echo htmlspecialchars($il->il_adi); ?>
                                                </option>
                                                <?php
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Region auswählen</label>
                                    <select class="form-control" name="ilce_id" id="ilce" style="width: 100%;">
                                        <option value="0"> Stadt auswählen </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"> Semt Seçiniz</label>
                                    <select class="form-control" name="semt_id" id="semt" style="width: 100%;">
                                        <option value="0"> Stadt auswählen </option>
                                    </select>
                                </div>

                                <script src="assets/js/selectchained.js" type="text/javascript"></script>
                                <script>
                                    $("#ilce").remoteChained("#il", "req/ajax.php?do=il-ilce&q=secim&ilce=83");
                                    $("#semt").remoteChained("#ilce", "req/ajax.php?do=il-ilce&q=secim&semt=440");
                                    $("#mahalle").remoteChained("#semt", "req/ajax.php?do=il-ilce&q=secim&mahalle=4833");
                                </script>

                                <div class="form-group">
                                    <label class="form-label"> Anzeigen?</label>
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

                                <button type="submit" onclick="kobySubmit('?do=neighborhood&q=add','neighborhood-list')"
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