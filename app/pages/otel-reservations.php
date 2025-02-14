<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Hotel Reservations
            </h1>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">Rez. No</th>
                                <th class="nosort">Rez. Type</th>
                                <th>Vorname, Name</th>
                                <th>Betrag</th>
                                <th class="text-center">Datum</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Secure query to fetch reservations from the database
                            if ($stmt = $con->prepare("SELECT * FROM reservations WHERE rezervation_type = 'hotel' ORDER BY id DESC")) {
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_object()) {
                                    // Fetch user details securely
                                    if ($userStmt = $con->prepare("SELECT * FROM users WHERE id = ?")) {
                                        $userStmt->bind_param("i", $row->user_id);
                                        $userStmt->execute();
                                        $userDetail = $userStmt->get_result()->fetch_object();
                                        $userStmt->close();
                                    }

                                    // Fetch tour details securely, if applicable
                                    if ($row->tour_id) {
                                        if ($tourStmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?")) {
                                            $tourStmt->bind_param("i", $row->tour_id);
                                            $tourStmt->execute();
                                            $tourDetail = $tourStmt->get_result()->fetch_object();
                                            $tourStmt->close();
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th> <span
                                                class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_number) ?></span>
                                        </th>
                                        <th>
                                            <div><?= htmlspecialchars($tourDetail->name ?? '') ?></div>
                                            <span
                                                class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_type) ?></span>
                                        </th>
                                        <th> <strong><?= htmlspecialchars($userDetail->firstname) ?>
                                                <?= htmlspecialchars($userDetail->lastname) ?></strong></th>
                                        <th> <?= htmlspecialchars($row->total_price) ?> € </th>
                                        <th class="text-center">
                                            <div class="tag tag-gray"><?= timeTR($row->created_at) ?></div>
                                        </th>
                                        <th class="text-center">
                                            <a href="otel-reservation-info?id=<?= $row->id ?>" class="btn btn-orange btn-sm"
                                                data-toggle="tooltip" title="Detaylar"><i class="fe fe-search"></i> </a>
                                            <a href="javascript:void(0)"
                                                onclick="kobySingle('<?= $row->id ?>','?do=otel-rezervasyon&q=delete','otel-reservations')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                    class="fe fe-trash"></i> </a>
                                        </th>
                                    </tr>
                                <?php }
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