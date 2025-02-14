<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <h1 class="page-title"> Tour Kategorie hinzufügen</h1>
            </h1>
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
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">

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

                                <button type="submit"
                                    onclick="kobySubmit('?do=tour-categories&q=add','tour-categories')"
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

<?php
// Handle form submission and save category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

    // Check if fields are not empty
    if (!empty($name)) {
        // Prepare the SQL query to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO the_tour_category (name, status) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $status); // "si" means string and integer
        $stmt->execute();

        // Redirect or give feedback after insert
        if ($stmt->affected_rows > 0) {
            // Redirect or display success message
            header("Location: tour-categories");
            exit;
        } else {
            echo "Fehler beim Hinzufügen der Kategorie.";
        }
    } else {
        echo "Bitte geben Sie einen Namen für die Kategorie ein.";
    }
}
?>