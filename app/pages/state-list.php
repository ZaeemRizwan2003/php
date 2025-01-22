<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Region </h1>
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
                                <th>Region Name</th>
                                <th>Zugeordnet zur Stadt</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $query = $con->query("SELECT * FROM ilce ORDER BY ilce_adi ASC");

                            if ($query && $query->num_rows > 0) {
                                while ($view = $query->fetch_object()) {
                                    ?>
                                    <tr>
                                        <th>#<?= htmlspecialchars($view->id) ?></th>
                                        <th>
                                            <strong><?= htmlspecialchars($view->ilce_adi) ?></strong>
                                        </th>
                                        <th>
                                            <?php
                                            $stmt = $con->prepare("SELECT * FROM il WHERE id = ?");
                                            $stmt->bind_param("i", $view->il_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $hotelCategory = $result->fetch_object();
                                            $stmt->close();
                                            ?>
                                            <strong><?= htmlspecialchars($hotelCategory->il_adi) ?></strong>
                                        </th>
                                        <th class="text-center">
                                            <a href="state-edit?id=<?= htmlspecialchars($view->id) ?>"
                                                class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="kobySingle('<?= htmlspecialchars($view->id) ?>','?do=state&q=delete','state-list')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen">
                                                <i class="fe fe-trash"></i>
                                            </a>
                                        </th>
                                    </tr>
                                <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Keine Daten gefunden</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>