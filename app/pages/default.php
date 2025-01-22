<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Neu
            </h1>
        </div>

        <div class="card">
            <div class="card-body p-3 text-center">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default panel-table">
                            <div class="panel-heading" style="">
                                <div class="title">Neue Hotel Reservierungen</div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="table card-table table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="nosort">Rez. No</th>
                                            <th>Vorname, Name</th>
                                            <th>Betrag</th>
                                            <th class="text-center">Datum</th>
                                            <th class="nosort text-center">Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        // Use prepared statement to fetch hotel reservations
                                        $stmt = $con->prepare("SELECT * FROM reservations WHERE rezervation_type = 'hotel' ORDER BY id DESC LIMIT 5");
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_object()) {
                                            // Fetch user details
                                            $userStmt = $con->prepare("SELECT * FROM users WHERE id = ?");
                                            $userStmt->bind_param("i", $row->user_id);
                                            $userStmt->execute();
                                            $userDetail = $userStmt->get_result()->fetch_object();
                                            $userStmt->close();

                                            // Check for tour details
                                            if ($row->tour_id) {
                                                $tourStmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
                                                $tourStmt->bind_param("i", $row->tour_id);
                                                $tourStmt->execute();
                                                $tourDetail = $tourStmt->get_result()->fetch_object();
                                                $tourStmt->close();
                                            }
                                            ?>
                                            <tr>
                                                <th> <span
                                                        class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_number) ?></span>
                                                </th>
                                                <th> <strong><?= htmlspecialchars($userDetail->firstname) ?>
                                                        <?= htmlspecialchars($userDetail->lastname) ?></strong></th>
                                                <th> <?= htmlspecialchars($row->total_price) ?> € </th>
                                                <th class="text-center">
                                                    <div class="tag tag-gray"><?= timeTR($row->created_at) ?></div>
                                                </th>
                                                <th class="text-center">
                                                    <a href="otel-reservation-info?id=<?= htmlspecialchars($row->id) ?>"
                                                        class="btn btn-orange btn-sm" data-toggle="tooltip"
                                                        title="Detaylar"><i class="fe fe-search"></i> </a>
                                                </th>
                                            </tr>
                                        <?php }
                                        $stmt->close();
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default panel-table">
                            <div class="panel-heading" style="">
                                <div class="title">Neue Tour Reservierungen</div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="table card-table table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="nosort">Rez. No</th>
                                            <th>Vorname, Name</th>
                                            <th>Betrag</th>
                                            <th class="text-center">Datum</th>
                                            <th class="nosort text-center">Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        // Use prepared statement to fetch tour reservations
                                        $stmt = $con->prepare("SELECT * FROM reservations WHERE rezervation_type = 'tour' ORDER BY id DESC LIMIT 5");
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_object()) {
                                            // Fetch user details
                                            $userStmt = $con->prepare("SELECT * FROM users WHERE id = ?");
                                            $userStmt->bind_param("i", $row->user_id);
                                            $userStmt->execute();
                                            $userDetail = $userStmt->get_result()->fetch_object();
                                            $userStmt->close();

                                            // Check for tour details
                                            if ($row->tour_id) {
                                                $tourStmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
                                                $tourStmt->bind_param("i", $row->tour_id);
                                                $tourStmt->execute();
                                                $tourDetail = $tourStmt->get_result()->fetch_object();
                                                $tourStmt->close();
                                            }
                                            ?>
                                            <tr>
                                                <th> <span
                                                        class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_number) ?></span>
                                                </th>
                                                <th> <strong><?= htmlspecialchars($userDetail->firstname) ?>
                                                        <?= htmlspecialchars($userDetail->lastname) ?></strong></th>
                                                <th> <?= htmlspecialchars($row->total_price) ?> € </th>
                                                <th class="text-center">
                                                    <div class="tag tag-gray"><?= timeTR($row->created_at) ?></div>
                                                </th>
                                                <th class="text-center">
                                                    <a href="otel-reservation-info?id=<?= htmlspecialchars($row->id) ?>"
                                                        class="btn btn-orange btn-sm" data-toggle="tooltip"
                                                        title="Detaylar"><i class="fe fe-search"></i> </a>
                                                </th>
                                            </tr>
                                        <?php }
                                        $stmt->close();
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>