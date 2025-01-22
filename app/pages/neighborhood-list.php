<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Stadt viertel </h1>
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
                                <th>Stadt viertel name</th>
                                <th>Zugeordnet zur Stadt</th>
                                <th>Zugeordnet zur Landkreis</th>
                                <th>Zugeordnet zur Gegend</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($stmt = $con->prepare("SELECT * FROM mahalle ORDER BY mahalle_adi ASC")) {
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($view = $result->fetch_object()) {
                                    // Get associated city
                                    if ($stmtCity = $con->prepare("SELECT * FROM il WHERE id = ?")) {
                                        $stmtCity->bind_param("i", $view->il_id);
                                        $stmtCity->execute();
                                        $cityResult = $stmtCity->get_result();
                                        $hotelCategory = $cityResult->fetch_object();
                                        $stmtCity->close();
                                    }

                                    // Get associated district
                                    if ($stmtDistrict = $con->prepare("SELECT * FROM ilce WHERE id = ?")) {
                                        $stmtDistrict->bind_param("i", $view->ilce_id);
                                        $stmtDistrict->execute();
                                        $districtResult = $stmtDistrict->get_result();
                                        $hotelCategoryDistrict = $districtResult->fetch_object();
                                        $stmtDistrict->close();
                                    }

                                    // Get associated neighborhood
                                    if ($stmtNeighborhood = $con->prepare("SELECT * FROM semt WHERE id = ?")) {
                                        $stmtNeighborhood->bind_param("i", $view->semt_id);
                                        $stmtNeighborhood->execute();
                                        $neighborhoodResult = $stmtNeighborhood->get_result();
                                        $hotelCategoryNeighborhood = $neighborhoodResult->fetch_object();
                                        $stmtNeighborhood->close();
                                    }
                                    ?>
                                    <tr>
                                        <th>#<?= htmlspecialchars($view->id) ?></th>
                                        <th>
                                            <strong><?= htmlspecialchars($view->mahalle_adi) ?></strong>
                                        </th>
                                        <th>
                                            <strong><?= htmlspecialchars($hotelCategory->il_adi) ?></strong>
                                        </th>
                                        <th>
                                            <strong><?= htmlspecialchars($hotelCategoryDistrict->ilce_adi) ?></strong>
                                        </th>
                                        <th>
                                            <strong><?= htmlspecialchars($hotelCategoryNeighborhood->semt_adi) ?></strong>
                                        </th>
                                        <th class="text-center">
                                            <a href="neighborhood-edit?id=<?= htmlspecialchars($view->id) ?>"
                                                class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten"><i
                                                    class="fe fe-edit"></i> </a>
                                            <a href="javascript:void(0)"
                                                onclick="kobySingle('<?= htmlspecialchars($view->id) ?>','?do=neighborhood&q=delete','neighborhood-list')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                    class="fe fe-trash"></i> </a>
                                        </th>
                                    </tr>
                                    <?php
                                }
                                $stmt->close();
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>