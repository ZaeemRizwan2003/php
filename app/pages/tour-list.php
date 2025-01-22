<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Tours
            </h1>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="tour-add" class="btn btn-success"> <i class="fe fe-plus"></i>  Tour hinzufügen </a>
                    <a href="tour-categories-add" class="btn btn-cyan"> <i class="fe fe-folder-plus"></i> Kategorie hinzufügen</a>
                    <a href="tour-date-add" class="btn btn-pink"> <i class="fa fa-calendar-plus-o"></i>  Datum hinzufügen </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                        <tr>
                            <th class="nosort">#ID</th>
                            <th>Tour Name</th>
                            <th>Tour Kategorie</th>
                            <th class="nosort text-center">Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        // Prepared statement to fetch tours
                        $stmt = $con->prepare("SELECT * FROM the_tour ORDER BY tour_id DESC");
                        $stmt->execute();
                        $list = $stmt->get_result();

                        while ($view = $list->fetch_object()) {
                            ?>

                            <tr>
                                <th>#<?= htmlspecialchars($view->tour_id) ?></th>
                                <th>
                                    <strong><?= htmlspecialchars($view->name) ?></strong>
                                </th>
                                <th>
                                    <?php
                                    // Prepared statement to fetch category
                                    $categoryStmt = $con->prepare("SELECT * FROM the_tour_category WHERE category_id = ?");
                                    $categoryStmt->bind_param('i', $view->tour_category_id);
                                    $categoryStmt->execute();
                                    $category = $categoryStmt->get_result()->fetch_object();
                                    echo htmlspecialchars($category->name);
                                    ?>
                                </th>
                                <th class="text-center">
                                    <div class="mb-2">
                                        <a href="tour-images-add?id=<?= htmlspecialchars($view->tour_id) ?>" class="btn btn-azure btn-sm" data-toggle="tooltip" title="Bild hinzufügen"><i class="fe fe-camera"></i> </a>
                                        <a href="tour-images-list?id=<?= htmlspecialchars($view->tour_id) ?>" class="btn btn-teal btn-sm" data-toggle="tooltip" title="Bilder"><i class="fe fe-image"></i> </a>
                                        <a href="tour-edit?id=<?= htmlspecialchars($view->tour_id) ?>" class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten"><i class="fe fe-edit"></i> </a>
                                    </div>

                                    <a href="tour-date-add?tour_id=<?= htmlspecialchars($view->tour_id) ?>" class="btn btn-pink btn-sm" data-toggle="tooltip" title="Datum hinzufügen "> <i class="fa fa-calendar-plus-o"></i>  </a>
                                    <a href="tour-dates-list?tour_id=<?= htmlspecialchars($view->tour_id) ?>" class="btn btn-orange btn-sm" data-toggle="tooltip" title="Datum hinzufügen"><i class="fe fe-calendar"></i> </a>
                                    <a href="tour-programs-list?tour_id=<?= htmlspecialchars($view->tour_id) ?>" class="btn btn-purple btn-sm" data-toggle="tooltip" title="Inhalte"><i class="fe fe-briefcase"></i> </a>
                                    <a href="javascript:void(0)" onclick="kobySingle('<?= htmlspecialchars($view->tour_id) ?>','?do=tour&q=delete','tour-list')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i class="fe fe-trash"></i> </a>
                                </th>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
