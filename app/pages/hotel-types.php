<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Hotel Typen </h1>
            <div class="page-options d-flex">
                <a href="hotel-list" class="btn btn-sm btn-orange">
                    <i class="fa fa-long-arrow-left"></i> Zurück zu den Hotels
                </a>
            </div>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="hotel-types-add" class="btn btn-success">
                        <i class="fe fe-plus"></i> Hotel Typ
                    </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">#ID</th>
                                <th>Zimmer Name</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Prepare and execute the query to fetch hotel types
                            $stmt = $con->prepare("SELECT * FROM the_hotel_type ORDER BY type_id DESC");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($view = $result->fetch_object()) {
                                ?>
                                <tr>
                                    <th>#<?php echo htmlspecialchars($view->type_id); ?></th>
                                    <th>
                                        <strong><?php echo htmlspecialchars($view->name); ?></strong>
                                    </th>
                                    <th class="text-center">
                                        <a href="hotel-types-edit?id=<?php echo htmlspecialchars($view->type_id); ?>"
                                            class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="kobySingle('<?php echo htmlspecialchars($view->type_id); ?>', '?do=hotel-types&q=delete', 'hotel-types')"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen">
                                            <i class="fe fe-trash"></i>
                                        </a>
                                    </th>
                                </tr>
                            <?php
                            }
                            $stmt->close();
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>