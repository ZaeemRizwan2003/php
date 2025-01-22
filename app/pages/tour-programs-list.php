<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Otel Zimmerı </h1>
            <div class="page-options d-flex ">
                <a href="hotel-list"  class="btn btn-sm btn-orange "> <i class="fa fa-long-arrow-left"></i> Zurück zu den Hotels</a>
            </div>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="hotel-rooms-add" class="btn btn-success"> <i class="fe fe-plus"></i>  Hotel Zimmer</a>
                    <a href="hotel-features" class="btn btn-warning"> <i class="fe fe-plus"></i> Zimmer specials </a>
                </div>
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                        <tr>
                            <th class="nosort">#ID</th>
                            <th>Zimmer Name</th>
                            <th>Hotel Name</th>
                            <th class="nosort text-center">Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        // Prepared statement to fetch hotel rooms
                        $stmt = $con->prepare("SELECT * FROM the_hotel_room ORDER BY room_id DESC");
                        $stmt->execute();
                        $list = $stmt->get_result();

                        while ($view = $list->fetch_object()) {
                            ?>

                            <tr>
                                <th>#<?= htmlspecialchars($view->room_id) ?></th>
                                <th>
                                    <strong><?= htmlspecialchars($view->name) ?></strong>
                                </th>
                                <th>
                                    <?php
                                    // Prepared statement to fetch hotel name
                                    $hotelStmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = ?");
                                    $hotelStmt->bind_param('i', $view->hotel_id);
                                    $hotelStmt->execute();
                                    $hotel = $hotelStmt->get_result()->fetch_object();
                                    echo htmlspecialchars($hotel->name);
                                    ?>
                                </th>
                                <th class="text-center">
                                    <a href="hotel-rooms-features?id=<?= htmlspecialchars($view->room_id) ?>" class="btn btn-pink btn-sm" data-toggle="tooltip" title="Special hinzufügen"><i class="fe fe-git-merge"></i> </a>
                                    <a href="hotel-rooms-images-add?id=<?= htmlspecialchars($view->room_id) ?>" class="btn btn-azure btn-sm" data-toggle="tooltip" title="Bild hinzufügen"><i class="fe fe-camera"></i> </a>
                                    <a href="hotel-rooms-images-list?id=<?= htmlspecialchars($view->room_id) ?>" class="btn btn-teal btn-sm" data-toggle="tooltip" title="Bilder"><i class="fe fe-image"></i> </a>
                                    <a href="hotel-rooms-edit?id=<?= htmlspecialchars($view->room_id) ?>" class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten"><i class="fe fe-edit"></i> </a>
                                    <a href="javascript:void(0)" onclick="kobySingle('<?= htmlspecialchars($view->room_id) ?>','?do=hotel-room&q=delete','hotel-room-list')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i class="fe fe-trash"></i> </a>
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
