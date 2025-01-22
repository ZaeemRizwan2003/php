<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <h1 class="page-title"> Stadt hinzufügen</h1>
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Stadt Name</label>
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

                                <button type="submit" onclick="kobySubmit('?do=province&q=add','province-list')"
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
// If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $status = isset($_POST['status']) ? (int) $_POST['status'] : 0;

    // Validate inputs
    if (!empty($name)) {
        // Prepare statement to insert data
        $query = "INSERT INTO il (il_adi, status) VALUES (?, ?)";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("si", $name, $status);  // 's' for string, 'i' for integer
            if ($stmt->execute()) {
                // Redirect after successful insertion
                header("Location: ?q=province");
                exit();
            } else {
                echo "Error: Could not execute query.";
            }
            $stmt->close();
        } else {
            echo "Error: Could not prepare query.";
        }
    } else {
        echo "Error: Stadt Name is required.";
    }
}
?>