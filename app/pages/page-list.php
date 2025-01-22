<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Seiten
            </h1>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="page-add" class="btn btn-success"> <i class="fe fe-plus"></i> Seiten adden </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">#ID</th>
                                <th>Seiten Name</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Secure query to fetch pages from the database using prepared statements
                            if ($stmt = $con->prepare("SELECT * FROM the_page ORDER BY page_id DESC")) {
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($view = $result->fetch_object()) {
                                    ?>

                                    <tr>
                                        <th>#<?= htmlspecialchars($view->page_id) ?></th>
                                        <th>
                                            <strong><?= htmlspecialchars($view->name) ?></strong>
                                        </th>
                                        <th class="text-center">
                                            <a href="page-edit?id=<?= htmlspecialchars($view->page_id) ?>"
                                                class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten"><i
                                                    class="fe fe-edit"></i> </a>
                                            <a href="javascript:void(0)"
                                                onclick="kobySingle('<?= htmlspecialchars($view->page_id) ?>','?do=page&q=delete','page-list')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                    class="fe fe-trash"></i> </a>
                                        </th>
                                    </tr>
                                    <?php
                                }
                                $stmt->close();
                            } else {
                                echo "Error: Could not prepare query.";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>