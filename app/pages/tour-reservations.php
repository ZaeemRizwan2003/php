<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Tour Reservations
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
                        // Prepared statement to fetch reservation details
                        $stmt = $con->prepare("SELECT * FROM reservations WHERE rezervation_type = 'tour' ORDER BY id DESC");
                        $stmt->execute();
                        $rows = $stmt->get_result();

                        while ($row = $rows->fetch_object()) {
                            // Fetch user details
                            $userStmt = $con->prepare("SELECT * FROM users WHERE id = ?");
                            $userStmt->bind_param('i', $row->user_id);
                            $userStmt->execute();
                            $userDetail = $userStmt->get_result()->fetch_object();

                            // Fetch tour details if tour_id is present
                            if ($row->tour_id) {
                                $tourStmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
                                $tourStmt->bind_param('i', $row->tour_id);
                                $tourStmt->execute();
                                $tourDetail = $tourStmt->get_result()->fetch_object();
                            }
                            ?>
                            <tr>
                                <th> <span class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_number) ?></span></th>
                                <th>
                                    <div><?= htmlspecialchars($tourDetail->name ?? 'No tour') ?></div>
                                    <span class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_type) ?></span>
                                </th>
                                <th> <strong><?= htmlspecialchars($userDetail->firstname) ?> <?= htmlspecialchars($userDetail->lastname) ?></strong></th>
                                <th> <?= htmlspecialchars($row->total_price) ?> € </th>
                                <th class="text-center">
                                    <div class="tag tag-gray"><?= timeTR($row->created_at) ?></div>
                                </th>
                                <th class="text-center">
                                    <a href="tour-reservation-info?id=<?= htmlspecialchars($row->id) ?>" class="btn btn-orange btn-sm" data-toggle="tooltip" title="Detaylar"><i class="fe fe-search"></i> </a>
                                    <a href="javascript:void(0)" onclick="kobySingle('<?= htmlspecialchars($row->id) ?>','?do=rezervasyon&q=delete','tour-rezervasyon')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i class="fe fe-trash"></i> </a>
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
