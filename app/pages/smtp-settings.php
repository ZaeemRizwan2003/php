<?php echo !defined("ADMIN") ? die("Hacking?") : null; ?>
<?php
$smtp = $con->query("SELECT * FROM smtp_settings WHERE id = 1")->fetch_object();
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                SMTP Ayarları
            </h1>
        </div>

        <div class="card">
            <form id="koby_form" role="form" class="form-horizontal" method="POST" onsubmit="return false" action=""
                enctype="multipart/form-data">
                <div class="card-body">
                    <div class="">

                        <div class="alert alert-info">
                            Sitenizdeki mail gönderimi ile ilgili tüm formların çalışması için aşağıdaki bilgileri doğru
                            olarak doldurmak zorundasınız. Aşağıdaki bilgilerin nasıl doldurulacağını bilmiyorsanız
                            lütfen sitenizi satın aldığınız firmadan yardım talep ediniz. Aksi taktirde insanlar size
                            ulaşamayacaktır.
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="smtp_title" class="col-sm-3 control-label">Gönderen Başlığı:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="smtp_title" name="smtp_title"
                                        placeholder="Firma Adınız" value="<?= htmlspecialchars($smtp->smtp_title) ?>"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="smtp_server" class="col-sm-3 control-label">SMTP Server:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="smtp_server" name="smtp_server"
                                        placeholder="Örn: mail.alanadiniz.com"
                                        value="<?= htmlspecialchars($smtp->smtp_server) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="smtp_port" class="col-sm-3 control-label">SMTP Port:</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="smtp_port" name="smtp_port"
                                        placeholder="Genel port numarası 587 'dir"
                                        value="<?= htmlspecialchars($smtp->smtp_port) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="smtp_protocol" class="col-sm-3 control-label">SMTP Protokol: </label>
                                <div class="col-sm-9">
                                    <select name="smtp_protocol" id="smtp_protocol" class="form-control" required>
                                        <option value="">Yok</option>
                                        <option value="tls" <?= $smtp->smtp_protocol == 'tls' ? 'selected' : '' ?>>TLS
                                        </option>
                                        <option value="ssl" <?= $smtp->smtp_protocol == 'ssl' ? 'selected' : '' ?>>SSL
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="smtp_username" class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="smtp_username" name="smtp_username"
                                        placeholder="Örn: info@alanadiniz.com"
                                        value="<?= htmlspecialchars($smtp->smtp_username) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="smtp_password" class="col-sm-3 control-label">E-Posta Şifre:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="smtp_password" name="smtp_password"
                                        value="<?= htmlspecialchars($smtp->smtp_password) ?>" required>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-left">
                    <button type="submit" onclick="kobySubmit('?do=smtp','index/smtp-settings')"
                        class="btn btn-success btn-lg">
                        <i class="fe fe-check"></i> Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>