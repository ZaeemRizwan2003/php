<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$id = g('id');
$stmt = $con->prepare("SELECT * FROM the_tour WHERE tour_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$view = $stmt->get_result()->fetch_object();

$stmt2 = $con->prepare("SELECT * FROM the_tour_picture WHERE tour_id = ?");
$stmt2->bind_param('i', $id);
$stmt2->execute();
$rows = $stmt2->get_result()->num_rows;
?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <strong> <?= htmlspecialchars($view->name) ?> </strong> İsimli Tur'a Ait Resimler
            </h1>
        </div>
        <form action="tour-images-list?id=<?= htmlspecialchars($id) ?>" method="POST">
            <div class="card">
                <div class="card-header" style="display: block;">
                    <div>
                        <?php
                            if ($_POST) {
                                if (isset($_POST['tumresimler'])) {
                                    $resimler = $_POST['tumresimler'];
                                    foreach ($resimler as $resim) {
                                        $stmt3 = $con->prepare("SELECT * FROM the_tour_picture WHERE picture_id = ?");
                                        $stmt3->bind_param('i', $resim);
                                        $stmt3->execute();
                                        $bul = $stmt3->get_result()->fetch_object();
                                        unlink('../data/tour/pictures/' . $bul->mini_picture);
                                        unlink('../data/tour/pictures/' . $bul->big_picture);
                                        $stmt4 = $con->prepare("DELETE FROM the_tour_picture WHERE picture_id = ?");
                                        $stmt4->bind_param('i', $resim);
                                        $stmt4->execute();
                                    }
                                    if ($stmt4->affected_rows > 0) {
                                        echo '<div class="alert alert-success">Tüm resimler temizlendi.</div>';
                                    } else {
                                        echo '<div class="alert alert-danger">Resimler silinemedi.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger">Herhangi bir resim seçmediniz.</div>';
                                }
                            }
                        ?>
                    </div>
                    <a href="tour-images-add?id=<?= htmlspecialchars($id) ?>" class="btn btn-success"> <i class="fe fe-plus"></i>  Resim Ekle </a>
                    <?php if ($rows) { ?>
                    <button type="submit" class="btn btn-danger pull-right mr-4"> <i class="fe fe-trash"></i>  Seçilen Resimleri Sil</button>
                    <label class="custom-control custom-checkbox pull-right mr-4 mt-2">
                        <input onclick="toggle(this);" type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" >
                        <span class="custom-control-label">Hepsini Seç</span>
                    </label>
                    <?php } ?>
                </div>
                <script>
                    function toggle(source) {
                        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                        for (var i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i] != source)
                                checkboxes[i].checked = source.checked;
                        }
                    }
                </script>

                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">Seç</th>
                                <th class="nosort">#Sıra</th>
                                <th>Resim </th>
                                <th>Info zur Tour</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        // Prepare and execute statement for images
                        $stmt5 = $con->prepare("SELECT * FROM the_tour_picture WHERE tour_id = ? ORDER BY rank ASC");
                        $stmt5->bind_param('i', $id);
                        $stmt5->execute();
                        $result = $stmt5->get_result();
                        
                        while ($view = $result->fetch_object()) {
                            ?>

                            <tr>
                                <td><input type="checkbox" name="tumresimler[]" value="<?= htmlspecialchars($view->picture_id) ?>"/></td>
                                <td id="<?= htmlspecialchars($view->sira) ?>">
                                    <div class="none"><?= htmlspecialchars($view->sira) ?></div>
                                    <input type="number" class="form-control" style="width: 70px" onchange="rankChange(this,'?do=tour&q=pic-rank')" value="<?= htmlspecialchars($view->rank) ?>" name="rank" id="<?= htmlspecialchars($view->picture_id) ?>" >
                                </td>
                                <th>
                                    <div class="none"><?= htmlspecialchars($view->mini_picture) ?></div>
                                    <a href="#">
                                        <img src="../data/tour/pictures/<?= htmlspecialchars($view->mini_picture) ?>" class="img-fluid img-thumbnail" width="100" >
                                    </a>
                                </th>

                                <th>
                                    <div class="none"><?= htmlspecialchars($view->content) ?></div>
                                    <h6>Info zur Tour</h6>
                                    <textarea name="content" class="form-control" onchange="contentChange(this,'?do=tour&q=pic-content')" id="<?= htmlspecialchars($view->picture_id) ?>" cols="30" rows="3"><?= htmlspecialchars($view->content) ?></textarea>
                                </th>
                                <th class="text-center">
                                    <a href="javascript:void(0)" onclick="kobySingle('<?= htmlspecialchars($view->tour_id) ?>','?do=tour&q=pic-delete&id=<?= htmlspecialchars($view->picture_id) ?>','tour-images-list?id=<?= htmlspecialchars($id) ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i class="fe fe-trash"></i> </a>
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
