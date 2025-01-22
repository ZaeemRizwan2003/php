<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Gegend </h1>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="province-add" class="btn btn-cyan"> <i class="fe fe-plus"></i> Stadt hinzufügen </a>
                    <a href="state-add" class="btn btn-success"> <i class="fe fe-plus"></i> Landkreis </a>
                    <a href="district-add" class="btn btn-pink"> <i class="fe fe-plus"></i> Gegend </a>
                    <a href="neighborhood-add" class="btn btn-primary"> <i class="fe fe-plus"></i> Gegend hinzufügen
                    </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">#ID</th>
                                <th>Semt Adı</th>
                                <th>Zugeordnet zur Landkreis</th>
                                <th>Zugeordnet zur Stadt</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Use prepared statements to prevent SQL injection
                            $stmt = $con->prepare("SELECT * FROM semt ORDER BY semt_adi ASC");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($view = $result->fetch_object()) {
                                // Fetch city details
                                $stmt_il = $con->prepare("SELECT * FROM il WHERE id = ?");
                                $stmt_il->bind_param("i", $view->il_id);
                                $stmt_il->execute();
                                $hotelCategory_il = $stmt_il->get_result()->fetch_object();

                                // Fetch district details
                                $stmt_ilce = $con->prepare("SELECT * FROM ilce WHERE id = ?");
                                $stmt_ilce->bind_param("i", $view->ilce_id);
                                $stmt_ilce->execute();
                                $hotelCategory_ilce = $stmt_ilce->get_result()->fetch_object();
                                ?>
                                <tr>
                                    <th>#<?= $view->id ?></th>
                                    <th>
                                        <strong><?= $view->semt_adi ?></strong>
                                    </th>
                                    <th>
                                        <strong><?= $hotelCategory_il->il_adi ?></strong>
                                    </th>
                                    <th>
                                        <strong><?= $hotelCategory_ilce->ilce_adi ?></strong>
                                    </th>
                                    <th class="text-center">
                                        <a href="district-edit?id=<?= $view->id ?>" class="btn btn-blue btn-sm"
                                            data-toggle="tooltip" title="Bearbeiten"><i class="fe fe-edit"></i> </a>
                                        <a href="javascript:void(0)"
                                            onclick="kobySingle('<?= $view->id ?>','?do=district&q=delete','district-list')"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                class="fe fe-trash"></i> </a>
                                    </th>
                                </tr>
                            <?php
                            }

                            // Close the prepared statement for the semt query
                            $stmt->close();
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>