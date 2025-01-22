<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
// Get the 'id' parameter securely
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Use a prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM the_hotel_accommodation WHERE accommodation_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$view = $result->fetch_assoc();
$stmt->close();
?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Otel Konaklama Tipi Düzenle </h1>
            <div class="page-options d-flex">
                <div class="page-subtitle">
                    <a href="hotel-accommodations" class="btn btn-sm btn-orange mr-4">
                        <i class="fa fa-long-arrow-left"></i> Zurück zu den Hotelunterkuft Typen
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Unterkunft Typ Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($view['name']) ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input"
                                                <?= $view['status'] == '1' ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input"
                                                <?= $view['status'] == '0' ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit"
                                    onclick="kobySubmit('?do=hotel-accommodations&q=edit&id=<?= htmlspecialchars($view['accommodation_id']) ?>', 'hotel-accommodations')"
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