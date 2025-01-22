<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Sosyal Ağ Ekle
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" role="form" class="form-horizontal" method="POST" onsubmit="return false" action=""
                enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <label for="name" class="col-sm-3 control-label">Başlık</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="icon" class="col-sm-3 control-label">Icon</label>
                            <div class="col-sm-9">
                                <select name="icon" id="icon" class="form-control">
                                    <?php
                                    $icons = [
                                        'fa fa-facebook' => 'Facebook',
                                        'fa fa-twitter' => 'Twitter',
                                        'fa fa-instagram' => 'Instagram',
                                        'fa fa-whatsapp' => 'Whatsapp',
                                        'fa fa-tumblr' => 'Tumblr',
                                        'fa fa-google-plus' => 'Google Plus',
                                        'fa fa-skype' => 'Skype',
                                        'fa fa-pinterest' => 'Pinterest',
                                        'fa fa-linkedin' => 'Linkedin',
                                        'fa fa-foursquare' => 'Foursquare'
                                    ];

                                    foreach ($icons as $iconClass => $iconName) {
                                        echo "<option value='$iconClass'>$iconName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="link" class="col-sm-3 control-label">Link</label>
                            <div class="col-sm-9">
                                <input type="url" class="form-control" id="link" name="link" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="rank" class="col-sm-3 control-label">Sıra</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="rank" name="rank" value="1" min="1"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-left">
                    <button type="submit" onclick="$.kobySubmit('?do=social&q=add','?q=social_networks')"
                        class="btn btn-success btn-lg">
                        <i class="fe fe-plus"></i> Ekle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>