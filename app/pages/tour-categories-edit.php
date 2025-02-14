<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
// Sanitize input using $_GET or similar function to ensure safety
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Prepare the query to fetch the row for the given category_id
$stmt = $con->prepare("SELECT * FROM the_tour_category WHERE category_id = ?");
$stmt->bind_param("i", $id); // "i" indicates that the id is an integer
$stmt->execute();
$result = $stmt->get_result();
$view = $result->fetch_object();
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Tour Kategorie hinzufügen</h1>
            <div class="page-options d-flex ">
                <div class="page-subtitle ">
                    <a href="tour-categories" class="btn btn-sm btn-orange mr-4"> <i class="fa fa-long-arrow-left"></i>
                        Zurück zu den Tour Kategorie </a>
                </div>
            </div>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Kategorie Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($view->name) ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">

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

                                <button type="submit"
                                    onclick="kobySubmit('?do=tour-categories&q=edit&id=<?= $view->category_id ?>','tour-categories')"
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