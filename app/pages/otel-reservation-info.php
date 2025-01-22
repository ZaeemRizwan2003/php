<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<?php
$id = g('id');
if ($stmt = $con->prepare("SELECT * FROM reservations WHERE id = ?")) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $view = $result->fetch_object();
    $stmt->close();
}
?>

<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title">
                Hotel Reservations Info #<?= htmlspecialchars($view->rezervation_number) ?>
            </h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice" id="invoice">
                            <?php
                            $userID = $view->user_id;
                            if ($stmt = $con->prepare("SELECT * FROM users WHERE id = ?")) {
                                $stmt->bind_param("i", $userID);
                                $stmt->execute();
                                $userResult = $stmt->get_result();
                                $userSearch = $userResult->fetch_object();
                                $stmt->close();
                            }
                            ?>
                            <div class="row invoice-header">
                                <div class="col-sm-6 col-xs-12">
                                    <span class="invoice-id">#<?= htmlspecialchars($view->rezervation_number) ?></span>
                                    <span class="invoice-date"><?= timeTR($view->created_at) ?></span>
                                    <small><?= htmlspecialchars($view->havalimani) ?></small>
                                </div>
                                <div class="col-sm-6 col-xs-12 text-right">
                                    <span class="name"><?= htmlspecialchars($userSearch->name) ?></span> <br>
                                    <span><?= htmlspecialchars($userSearch->firstname) ?>
                                        <?= htmlspecialchars($userSearch->lastname) ?></span> <br>
                                    <span><?= htmlspecialchars($userSearch->telephone) ?></span> <br>
                                    <span><?= htmlspecialchars($userSearch->email) ?></span> <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="invoice-details">
                                        <tbody>
                                            <tr>
                                                <th style="width:40%">Notes</th>
                                                <th style="width:20%">
                                                    <center>Datum hinzufügen</center>
                                                </th>
                                                <th style="width:17%" class="hours"></th>
                                                <th style="width:15%" class="amount">Betrag</th>
                                            </tr>
                                            <?php
                                            $tourID = $view->hotel_id;
                                            $tourDate = $view->hotel_dates;
                                            if ($stmt = $con->prepare("SELECT * FROM the_hotel WHERE hotel_id = ?")) {
                                                $stmt->bind_param("i", $tourID);
                                                $stmt->execute();
                                                $tourResult = $stmt->get_result();
                                                $tourSearch = $tourResult->fetch_object();
                                                $stmt->close();
                                            }
                                            ?>
                                            <tr>
                                                <td class="description"><?= htmlspecialchars($tourSearch->name) ?></td>
                                                <td class="hours center">
                                                    <center> <?= htmlspecialchars($tourDate) ?></center>
                                                </td>
                                                <td class="hours"><?= htmlspecialchars($view->person_size) ?> Erwachsene
                                                    - <?= htmlspecialchars($view->child_size) ?> Kind</td>
                                                <td class="amount"><?= htmlspecialchars($view->total_price) ?> €</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="summary">Total</td>
                                                <td class="amount"><?= htmlspecialchars($view->total_price) ?> €</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="summary total">Gesamt</td>
                                                <td class="amount total-value">
                                                    <?= htmlspecialchars($view->total_price) ?> €</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 invoice-message">
                                    <center><span class="title">Bilgilendirme amaçlı olup mali değeri yoktur</span>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>