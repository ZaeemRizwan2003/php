<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Otel Temaları</h1>
            <div class="page-options d-flex">
                <a href="hotel-list" class="btn btn-sm btn-orange">
                    <i class="fa fa-long-arrow-left"></i> Zurück zu den Hotels
                </a>
            </div>
        </div>

        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="hotel-themes-add" class="btn btn-success">
                        <i class="fe fe-plus"></i> Themen hinzufügen
                    </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">#ID</th>
                                <th>Themen Name</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Secure query execution using prepared statements
                            $stmt = $con->prepare("SELECT * FROM the_hotel_theme ORDER BY theme_id DESC");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($view = $result->fetch_object()) {
                                ?>
                                <tr>
                                    <th>#<?= htmlspecialchars($view->theme_id, ENT_QUOTES, 'UTF-8'); ?></th>
                                    <th>
                                        <strong><?= htmlspecialchars($view->name, ENT_QUOTES, 'UTF-8'); ?></strong>
                                    </th>
                                    <th class="text-center">
                                        <a href="hotel-themes-edit?id=<?= htmlspecialchars($view->theme_id, ENT_QUOTES, 'UTF-8'); ?>"
                                            class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="kobySingle('<?= htmlspecialchars($view->theme_id, ENT_QUOTES, 'UTF-8'); ?>',
                                       '?do=hotel-themes&q=delete','hotel-themes')" class="btn btn-danger btn-sm"
                                            data-toggle="tooltip" title="Löschen">
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