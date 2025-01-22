<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
$hotel_id = g('hotel_id');

// Use prepared statements for security
$stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = ?");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$hotelDetail = $stmt->get_result()->fetch_object();
$stmt->close();

$stmt = $con->prepare("SELECT COUNT(*) FROM the_hotel_room WHERE hotel_id = ?");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$stmt->bind_result($hotelRoomRows);
$stmt->fetch();
$stmt->close();
?>

<div class="my-3 my-md-5">
    <div class="container">
        <?php if ($hotelRoomRows == 0) { ?>
            <div class="alert alert-info" role="alert">
                <h6><strong><?= htmlspecialchars($hotelDetail->name ?? '', ENT_QUOTES, 'UTF-8'); ?></strong> isimli otele
                    ait henüz bir oda eklenmemiş.</h6>
            </div>
        <?php } ?>
        <div class="page-header">
            <h1 class="page-title">
                <strong><?= htmlspecialchars($hotelDetail->name ?? '', ENT_QUOTES, 'UTF-8'); ?></strong> isimli otele
                ait odalar</h1>
            <div class="page-options d-flex">
                <a href="hotel-list" class="btn btn-sm btn-orange"><i class="fa fa-long-arrow-left"></i> Zurück zu den
                    Hotels</a>
            </div>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <a href="hotel-rooms-add?hotel_id=<?= htmlspecialchars($hotel_id, ENT_QUOTES, 'UTF-8'); ?>"
                        class="btn btn-success">
                        <i class="fe fe-plus"></i> Hotel Zimmer
                    </a>
                    <a href="hotel-features" class="btn btn-warning">
                        <i class="fe fe-plus"></i> Zimmer specials
                    </a>
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
                            $stmt = $con->prepare("SELECT * FROM the_hotel_room WHERE hotel_id = ? ORDER BY hotel_id DESC");
                            $stmt->bind_param("i", $hotel_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($view = $result->fetch_object()) {
                                ?>

                                <tr>
                                    <th>#<?= htmlspecialchars($view->room_id, ENT_QUOTES, 'UTF-8'); ?></th>
                                    <th><strong><?= htmlspecialchars($view->name, ENT_QUOTES, 'UTF-8'); ?></strong></th>
                                    <th>
                                        <?php
                                        $stmt2 = $con->prepare("SELECT name FROM the_hotel WHERE hotel_id = ?");
                                        $stmt2->bind_param("i", $view->hotel_id);
                                        $stmt2->execute();
                                        $stmt2->bind_result($hotelCategoryName);
                                        $stmt2->fetch();
                                        echo htmlspecialchars($hotelCategoryName, ENT_QUOTES, 'UTF-8');
                                        $stmt2->close();
                                        ?>
                                    </th>
                                    <th class="text-center">
                                        <a href="hotel-rooms-features?id=<?= htmlspecialchars($view->room_id, ENT_QUOTES, 'UTF-8'); ?>"
                                            class="btn btn-pink btn-sm" data-toggle="tooltip" title="Special hinzufügen"><i
                                                class="fe fe-git-merge"></i></a>
                                        <a href="hotel-rooms-images-add?id=<?= htmlspecialchars($view->room_id, ENT_QUOTES, 'UTF-8'); ?>"
                                            class="btn btn-azure btn-sm" data-toggle="tooltip" title="Bild hinzufügen"><i
                                                class="fe fe-camera"></i></a>
                                        <a href="hotel-rooms-images-list?id=<?= htmlspecialchars($view->room_id, ENT_QUOTES, 'UTF-8'); ?>"
                                            class="btn btn-teal btn-sm" data-toggle="tooltip" title="Bilder"><i
                                                class="fe fe-image"></i></a>
                                        <a href="hotel-rooms-edit?id=<?= htmlspecialchars($view->room_id, ENT_QUOTES, 'UTF-8'); ?>"
                                            class="btn btn-blue btn-sm" data-toggle="tooltip" title="Bearbeiten"><i
                                                class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)"
                                            onclick="kobySingle('<?= htmlspecialchars($view->room_id, ENT_QUOTES, 'UTF-8'); ?>','?do=hotel-rooms&q=delete','hotel-list')"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                class="fe fe-trash"></i></a>
                                    </th>
                                </tr>

                            <?php }
                            $stmt->close();
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>