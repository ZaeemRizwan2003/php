<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Rezervasyonlar
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
                            $result = $con->query("SELECT * FROM reservations ORDER BY id DESC");
                            while ($row = $result->fetch_object()) {
                                $userDetail = $con->query("SELECT * FROM users WHERE id = '$row->user_id'")->fetch_object();
                                $tourDetail = null;
                                if ($row->tour_id) {
                                    $tourDetail = $con->query("SELECT * FROM the_tour WHERE tour_id = '$row->tour_id'")->fetch_object();
                                }
                                ?>
                                <tr>
                                    <th> <span
                                            class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_number) ?></span>
                                    </th>
                                    <th>
                                        <div><?= htmlspecialchars($tourDetail ? $tourDetail->name : 'N/A') ?></div>
                                        <span class="tag tag-gray-dark"><?= htmlspecialchars($row->rezervation_type) ?></span>
                                    </th>
                                    <th> <strong><?= htmlspecialchars($userDetail->firstname) ?>
                                            <?= htmlspecialchars($userDetail->lastname) ?></strong></th>
                                    <th> <?= htmlspecialchars($row->total_price) ?> € </th>
                                    <th class="text-center">
                                        <div class="tag tag-gray"><?= timeTR($row->created_at) ?></div>
                                    </th>
                                    <th class="text-center">
                                        <a href="javascript:void(0)"
                                            onclick="$.kobyDelete('<?= htmlspecialchars($row->id) ?>','?do=otel-rezervasyon&q=delete','otel-reservations')"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen">
                                            <i class="fe fe-trash"></i>
                                        </a>
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