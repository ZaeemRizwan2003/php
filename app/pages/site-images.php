<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$site_images = $con->query("SELECT * FROM site_settings WHERE id = 1")->fetch_object();
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Site Görselleri ve Ayarları
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" role="form" method="POST" onsubmit="return false" action=""
                enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($site_images->id) ?>">

                    <div class="alert alert-info">
                        Sitenizdeki logolar ile alakalı tüm alanları buradan güncelleyebilirsiniz.
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label">
                                    Logonuz
                                    (<?= htmlspecialchars($site_images->site_logo_width) ?>x<?= htmlspecialchars($site_images->site_logo_height) ?>
                                    ölçülerinde, jpg veya png formatında yüklemelisiniz.)
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="site_logo">
                                    <label class="custom-file-label">Resim Seçiniz</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 text-center">
                            <?php if ($site_images->site_logo) { ?>
                                <img src="../data/genel/<?= htmlspecialchars($site_images->site_logo) ?>"
                                    class="img-fluid img-thumbnail img-gallery"> <br>
                                <button type="submit" onclick="kobySingle('site-logo','?do=site-logo','index/site-images')"
                                    class="btn btn-danger btn-sm">
                                    <i class="fe fe-trash"></i> Logoyu Sil
                                </button>
                            <?php } ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-label">
                                    Footer Logonuz
                                    (<?= htmlspecialchars($site_images->site_flogo_width) ?>x<?= htmlspecialchars($site_images->site_flogo_height) ?>
                                    ölçülerinde, jpg veya png formatında yüklemelisiniz.)
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="site_footer_logo">
                                    <label class="custom-file-label">Resim Seçiniz</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 text-center">
                            <?php if ($site_images->site_footer_logo) { ?>
                                <img src="../data/genel/<?= htmlspecialchars($site_images->site_footer_logo) ?>"
                                    class="img-fluid img-thumbnail img-gallery"> <br>
                                <button type="submit"
                                    onclick="kobySingle('site-footer-logo','?do=site-footer-logo','index/site-images')"
                                    class="btn btn-danger btn-sm">
                                    <i class="fe fe-trash"></i> Logoyu Sil
                                </button>
                            <?php } ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Watermark kullanmak istiyor musunuz?</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="site_watermatik_active"
                                            onchange="watermarkStatus(this)" value="1" class="selectgroup-input"
                                            <?= $site_images->site_watermatik_active == 1 ? 'checked' : '' ?>>
                                        <span class="selectgroup-button">Aktif</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="site_watermatik_active"
                                            onchange="watermarkStatus(this)" value="0" class="selectgroup-input"
                                            <?= $site_images->site_watermatik_active == 0 ? 'checked' : '' ?>>
                                        <span class="selectgroup-button">Pasif</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-label">
                                    Resimlerin üzerine gözükecek logonuz (600x600 ölçülerinde png formatında tranparan
                                    olarak yüklemelisiniz.)
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="site_watermatik_logo">
                                    <label class="custom-file-label">Resim Seçiniz</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 text-center">
                            <?php if ($site_images->site_watermatik_logo) { ?>
                                <img src="../data/genel/<?= htmlspecialchars($site_images->site_watermatik_logo) ?>"
                                    class="img-fluid img-thumbnail img-gallery"> <br>
                                <button type="submit"
                                    onclick="kobySingle('site-watermark-logo','?do=site-watermark-logo','index/site-images')"
                                    class="btn btn-danger btn-sm">
                                    <i class="fe fe-trash"></i> Logoyu Sil
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-left">
                    <button type="submit" onclick="kobySubmit('?do=site-images','index/site-images')"
                        class="btn btn-success btn-lg">
                        <i class="fe fe-check"></i> Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>