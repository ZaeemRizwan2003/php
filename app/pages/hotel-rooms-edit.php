<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
$room_id = g('id');

// Use prepared statements to fetch room details securely
$stmt = $con->prepare("SELECT * FROM the_hotel_room WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$roomDetail = $stmt->get_result()->fetch_object();
$stmt->close();

$hotel_id = $roomDetail->hotel_id ?? null;

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
            <h1 class="page-title"> Oda Düzenle </h1>
            <div class="page-options d-flex ">
                <div class="page-subtitle">
                    <?php if ($hotel_id) { ?>
                        <strong><?= htmlspecialchars($hotelDetail->name ?? '', ENT_QUOTES, 'UTF-8'); ?> </strong> isimli
                        otele oda ekliyorsunuz..
                        <a href="hotel-rooms?hotel_id=<?= htmlspecialchars($hotel_id, ENT_QUOTES, 'UTF-8'); ?>"
                            class="btn btn-sm btn-orange mr-4">
                            <i class="fa fa-long-arrow-left"></i> Zurück zu den Zimmern
                        </a>
                    <?php } else { ?>
                        <a href="hotel-room-list" class="btn btn-sm btn-orange mr-4">
                            <i class="fa fa-long-arrow-left"></i> Zurück zu den Zimmern
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="card">
            <form id="koby_form" method="POST" onsubmit="return false" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">
                            <div class="form-group">
                                <label class="form-label">Zimmer Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?= htmlspecialchars($roomDetail->name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <?php if ($hotel_id) { ?>
                                    <input type="hidden" name="hotel_id"
                                        value="<?= htmlspecialchars($hotel_id, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Zimmer Info</label>
                                <textarea class="form-control" id="editor"
                                    name="content"><?= htmlspecialchars($roomDetail->content ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Preis Erwachsene</label>
                                        <input type="text" class="form-control" name="person_price"
                                            placeholder="Örnek: 10.00"
                                            value="<?= htmlspecialchars($roomDetail->person_price ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Preis Kind</label>
                                        <input type="text" class="form-control" name="child_price"
                                            placeholder="Örnek: 10.00"
                                            value="<?= htmlspecialchars($roomDetail->child_price ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Zimmergröße (qm)</label>
                                        <input type="text" class="form-control" name="room_size"
                                            placeholder="Örnek: 120"
                                            value="<?= htmlspecialchars($roomDetail->room_size ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Bett Anzahl</label>
                                        <input type="text" class="form-control" name="beds_number"
                                            placeholder="Örnek: 2"
                                            value="<?= htmlspecialchars($roomDetail->beds_number ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <fieldset class="form-fieldset">
                                <div class="form-group">
                                    <label class="form-label">Zugeordnet zum Hotel</label>
                                    <select name="hotel_id" id="hotel_id" class="form-control custom-select">
                                        <option value="0">Otel Seçiniz</option>
                                        <?php
                                        $hotelLists = $con->query("SELECT * FROM the_hotel ORDER BY hotel_id DESC");
                                        while ($hotelLis = $hotelLists->fetch_object()) {
                                            ?>
                                            <option
                                                value="<?= htmlspecialchars($hotelLis->hotel_id, ENT_QUOTES, 'UTF-8'); ?>"
                                                <?= ($hotel_id == $hotelLis->hotel_id) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($hotelLis->name, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">Wallpaper Bild</div>
                                    <?php if (!empty($roomDetail->picture)) { ?>
                                        <div>
                                            <img src="../data/hotel/room/<?= htmlspecialchars($roomDetail->picture, ENT_QUOTES, 'UTF-8'); ?>"
                                                class="img-thumbnail img-responsive" alt="">
                                        </div>
                                        <div class="help-block">Resimi değiştirmeyecekseniz lütfen herhangi bir resim seçimi
                                            yapmayınız.</div>
                                        <br>
                                    <?php } ?>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" name="picture">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Anzeigen?</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input"
                                                <?= ($roomDetail->status == '1') ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">Ja, anzeigen.</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input"
                                                <?= ($roomDetail->status == '0') ? 'checked' : ''; ?>>
                                            <span class="selectgroup-button">Nein, nur abspeichern</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit"
                                    onclick="kobySubmit('?do=hotel-room&q=edit&id=<?= htmlspecialchars($roomDetail->room_id, ENT_QUOTES, 'UTF-8'); ?>','hotel-rooms?hotel_id=<?= htmlspecialchars($roomDetail->hotel_id, ENT_QUOTES, 'UTF-8'); ?>')"
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