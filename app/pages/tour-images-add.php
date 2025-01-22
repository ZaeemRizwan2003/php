<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$id = g('id');
$stmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$view = $stmt->get_result()->fetch_object();
?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <strong><?= htmlspecialchars($view->name) ?></strong> isimli Tur'a Resim Ekle
            </h1>
        </div>

        <div class="card">

            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">

                            <input type="hidden" name="tour_id" value="<?= htmlspecialchars($view->name) ?>" >
                            <div class="form-group">
                                <label for="picture"> <i class="fa fa-picture-o"></i>  Resimleri Seç </label>
                                <input type="file" class="form-control" multiple id="picture" name="pictures[]">
                            </div>

                        </div>
                        <div class="col-md-4 col-lg-4">

                            <div class="form-group">
                                <label class="form-label">  Anzeigen?</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="1" class="selectgroup-input" checked>
                                        <span class="selectgroup-button">Ja, anzeigen.</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">Nein, nur abspeichern</span>
                                    </label>
                                </div>
                            </div>

                            <fieldset class="form-fieldset">
                                <button type="submit" onclick="kobySubmit('?do=tour&q=pic-add&id=<?= htmlspecialchars($id) ?>','tour-images-list?id=<?= htmlspecialchars($id) ?>')" class="btn btn-block btn-success btn-lg"> Kaydet ve Düzenle <i class="fe fe-save"></i>  </button>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
