<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Hotel Comments
            </h1>
        </div>
        <form action="?q=social_networks" method="POST">
            <div class="card">
                <div class="card-body">
                    <table class="table card-table table-vcenter text-nowrap" id="koby_table">
                        <thead>
                            <tr>
                                <th class="nosort">#ID</th>
                                <th>Hotel Name</th>
                                <th>Puan</th>
                                <th>Adsoyad - Email </th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th class="nosort text-center">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Check if $con is a valid PDO object
                            if ($con instanceof PDO) {
                                // Prepare and execute the query to get hotel comments
                                $stmt = $con->prepare("SELECT * FROM the_hotel_comment ORDER BY status ASC, created_at DESC");
                                $stmt->execute();
                                $list = $stmt->fetchAll(PDO::FETCH_OBJ);

                                foreach ($list as $view) {
                                    // Prepare and execute the query to get hotel data
                                    $hotelStmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = :hotel_id");
                                    $hotelStmt->bindParam(':hotel_id', $view->hotel_id, PDO::PARAM_INT);
                                    $hotelStmt->execute();
                                    $hotelSrc = $hotelStmt->fetch(PDO::FETCH_OBJ);  // Use PDO::FETCH_OBJ to fetch as an object
                                    ?>

                                    <tr>
                                        <th>#<?= $view->id ?></th>
                                        <th><?= $hotelSrc->name ?></th> <!-- Fixed this line: $name -> $hotelSrc->name -->
                                        <th><?= commentStars($view->rating_review) ?></th>
                                        <th><strong><?= $view->name ?> - <?= $view->email ?></strong></th>
                                        <th><textarea name="content" class="form-control"
                                                onchange="contentChange(this,'?do=hotel_comment&q=comment-change')"
                                                id="<?= $view->id ?>" cols="30" rows="3"><?= $view->content ?></textarea></th>
                                        <th><?= $view->created_at ?></th>
                                        <th class="text-center">
                                            <label class="custom-switch">
                                                <input type="checkbox"
                                                    onchange="icerikdurum(this,'?do=hotel_comment&q=comment-status')"
                                                    id="<?= $view->id ?>" value="<?= $view->id ?>" name="status"
                                                    class="custom-switch-input" <?php if ($view->status == 1) {
                                                        echo 'checked';
                                                    } ?>>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                            <br>
                                            <a href="javascript:void(0)"
                                                onclick="kobySingle('<?= $view->id ?>','?do=hotel_comment&q=delete','hotel-comments')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip" title="Löschen"><i
                                                    class="fe fe-trash"></i> </a>
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

    <?php
                            } else {
                                echo "Database connection error.";
                            }
                            ?>