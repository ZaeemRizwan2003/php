<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$id = g('id');
$view = $con->query("SELECT * FROM reservations WHERE id = '$id'")->fetch_object();
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title">
                Tour Reservations Info #<?=$view->rezervation_number?>
            </h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice" id="invoice">
                            <?php
                            $userID = $view->user_id;
                            $userSearch = $con->query("SELECT * FROM users WHERE id = '$userID'")->fetch_object();
                            ?>
                            <div class="row invoice-header">
                                <div class="col-sm-6 col-xs-12">
                                    <span class="invoice-id">#<?=$view->rezervation_number?></span>
                                    <span class="incoice-date"><?=timeTR($view->created_at)?></span>
                                </div>
                                <div class="col-sm-6 col-xs-12 text-right">
                                    <span class="name"><?=$userSearch->name?></span> <br>
                                    <span><?=$userSearch->firstname?> <?=$userSearch->lastname?></span> <br>
                                    <span><?=$userSearch->telephone?></span> <br>
                                    <span><?=$userSearch->email?></span> <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="invoice-details">
                                        <tbody>
                                        <tr>
                                            <th style="width:40%">Açıklama</th>
                                            <th style="width:20%"><center>Datum hinzufügen</center></th>
                                            <th style="width:17%" class="hours">Katılımcı</th>
                                            <th style="width:15%" class="amount">Betrag</th>
                                        </tr>
                                        <?php
                                        $tourID = $view->tour_id;
                                        $tourDateID = $view->tour_dates;
                                        $tourSearch = $con->query("SELECT * FROM the_tour WHERE tour_id = '$tourID'")->fetch_object();
                                        $dateSearch = $con->query("SELECT * FROM the_tour_date WHERE date_id = '$tourDateID'")->fetch_object();
                                        ?>
                                        <tr>
                                            <td class="description"><?=$tourSearch->name?></td>
                                            <td class="hours center"><center><?=$dateSearch->tour_start_date?> <br> <?=$dateSearch->tour_end_date?></center></td>
                                            <td class="hours"><?=$view->person_size?> Erwachsene - <?=$view->child_size?> Kind</td>
                                            <td class="amount"><?=$view->total_price?> €
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="summary">Total</td>
                                            <td class="amount"><?=$view->total_price?> €</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="summary total">Gesamt</td>
                                            <td class="amount total-value"><?=$view->total_price?> €</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 invoice-message"><center><span class="title">Bilgilendirme amaçlı olup mali değeri yoktur</span></center></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
