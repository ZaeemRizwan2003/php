<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
$id = g('id');

// Use prepared statements for security
$stmt = $con->prepare("SELECT * FROM the_hotel_theme WHERE theme_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$view = $result->fetch_object();
$stmt->close();
?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Themen Hotel hinzufügen</h1>
            <div class="page-options d-flex">
                <div class="page-subtitle">
                    <a href="hotel-themes" class="btn btn-sm btn-orange mr-4">
                        <i class="fa fa-long-arrow-left"></i> Zurück zu den Hotel Thematiken
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
                                <label class="form-label">Themen Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($view->name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input"
                                                <?= isset($view->status) && $view->status == '1' ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input"
                                                <?= isset($view->status) && $view->status == '0' ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit"
                                    onclick="kobySubmit('?do=hotel-themes&q=edit&id=<?= htmlspecialchars($view->theme_id ?? '', ENT_QUOTES, 'UTF-8'); ?>','hotel-themes')"
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