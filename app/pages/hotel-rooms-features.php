<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
$room_id = g('id');

// Use prepared statements to fetch room details
$stmt = $con->prepare("SELECT * FROM the_hotel_room WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$roomDetail = $stmt->get_result()->fetch_object();
$stmt->close();

$hotel_id = $roomDetail->hotel_id;

// Fetch hotel details securely
$stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = ?");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$hotelDetail = $stmt->get_result()->fetch_object();
$stmt->close();
?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <h1 class="page-title"> Odaya Special hinzufügen </h1>
            </h1>
            <div class="page-options d-flex ">
                <div class="page-subtitle ">
                    <strong><?= htmlspecialchars($roomDetail->name ?? '', ENT_QUOTES, 'UTF-8'); ?> </strong> isimli oda
                    özellik ekliyorsunuz..
                    <a href="hotel-rooms?hotel_id=<?= htmlspecialchars($hotel_id, ENT_QUOTES, 'UTF-8'); ?>"
                        class="btn btn-sm btn-orange mr-4">
                        <i class="fa fa-long-arrow-left"></i> Zurück zu den Zimmern
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="row">
                                <input type="hidden"
                                    name="<?= htmlspecialchars($roomDetail->name ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                                <?php
                                // Fetch feature groups
                                $stmt = $con->prepare("SELECT * FROM the_hotel_room_features_group ORDER BY rank ASC");
                                $stmt->execute();
                                $groupLists = $stmt->get_result();
                                while ($groupList = $groupLists->fetch_object()) {
                                    ?>

                                    <div class="col-4 mb-4">
                                        <h6 class="mb-3 lead">
                                            <?= htmlspecialchars($groupList->name, ENT_QUOTES, 'UTF-8'); ?></h6>
                                        <?php
                                        // Fetch features for each group
                                        $stmt2 = $con->prepare("SELECT * FROM the_hotel_room_features WHERE feature_group_id = ? ORDER BY rank ASC");
                                        $stmt2->bind_param("i", $groupList->features_gid);
                                        $stmt2->execute();
                                        $featuresLists = $stmt2->get_result();
                                        while ($featuresList = $featuresLists->fetch_object()) {
                                            // Check if feature is active
                                            $stmt3 = $con->prepare("SELECT * FROM the_hotel_room_features_relationship WHERE room_id = ? AND features_id = ?");
                                            $stmt3->bind_param("ii", $room_id, $featuresList->features_id);
                                            $stmt3->execute();
                                            $aktif = $stmt3->get_result()->fetch_object();
                                            $stmt3->close();
                                            ?>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="hidden"
                                                            name="features[<?= htmlspecialchars($featuresList->features_id, ENT_QUOTES, 'UTF-8'); ?>]"
                                                            value="0">
                                                        <input type="checkbox"
                                                            name="features[<?= htmlspecialchars($featuresList->features_id, ENT_QUOTES, 'UTF-8'); ?>]"
                                                            value="1" <?= !empty($aktif) ? 'checked' : ''; ?>>
                                                        <?= htmlspecialchars($featuresList->name, ENT_QUOTES, 'UTF-8'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php }
                                        $stmt2->close();
                                        ?>

                                    </div>
                                <?php }
                                $stmt->close();
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <button type="submit"
                                    onclick="kobySubmit('?do=hotel-room&q=features-add&id=<?= htmlspecialchars($roomDetail->room_id, ENT_QUOTES, 'UTF-8'); ?>','hotel-rooms-features?id=<?= htmlspecialchars($roomDetail->room_id, ENT_QUOTES, 'UTF-8'); ?>')"
                                    class="btn btn-block btn-success btn-lg">
                                    Speichern und Schließen <i class="fe fe-save"></i>
                                </button>
                            </fieldset>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>