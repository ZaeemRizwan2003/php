<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Hotel Kategorie </h1>
            <div class="page-options d-flex ">
                <a href="hotel-list" class="btn btn-sm btn-orange "> <i class="fa fa-long-arrow-left"></i> Zurück zu den
                    Hotels</a>
            </div>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="hotel-categories-add" class="btn btn-success"> <i class="fe fe-plus"></i> Kategorie
                        hinzufügen </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">#ID</th>
                                <th>Kategorie Name</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Check if $con is a valid PDO object
                            if ($con instanceof PDO) {
                                // Prepare and execute the query to get hotel categories
                                $stmt = $con->prepare("SELECT * FROM the_hotel_category ORDER BY category_id DESC");
                                $stmt->execute();
                                $list = $stmt->fetchAll(PDO::FETCH_OBJ);

                                // Loop through categories and display each one
                                foreach ($list as $view) {
                                    ?>
                                    <tr>
                                        <th>#<?= $view->category_id ?></th>
                                        <th>
                                            <strong><?= $view->name ?></strong>
                                        </th>
                                        <th class="text-center">
                                            <a href="hotel-categories-edit?id=<?= $view->category_id ?>"
                                                class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten"><i
                                                    class="fe fe-edit"></i> </a>
                                            <a href="javascript:void(0)"
                                                onclick="kobySingle('<?= $view->category_id ?>','?do=hotel-categories&q=delete','hotel-categories')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                    class="fe fe-trash"></i> </a>
                                        </th>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "Database connection error.";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>