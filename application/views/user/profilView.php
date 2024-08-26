<?php
$id_pengguna = "";
$email = "";
$nm_lengkap = "";
$nik = "";
$jns_kelamin = "";
$tgl_lahir = "";
$kt_sandi = "";
$no_hp = "";
$ktp = "";
if ($parameter == 'lihat' && $id != '') {
    $this->db->where('id_pengguna', $id);
    $row = $this->Model->get()->row_array();
    if ($row) {
        extract($row);
    }
}
// value ketika validasi
if ($this->session->flashdata('error_value')) {
    $error_value = $this->session->flashdata('error_value');
    if (is_array($error_value)) {
        extract($error_value);
    }
}
?>
<?= content_open('Lihat Profile') ?>
<?php
// menampilkan error validasi
if ($this->session->flashdata('error_validation')) {
    foreach ($this->session->flashdata('error_validation') as $key => $value) {
        echo '<div class="alert alert-danger">' . $value . '</div>';
    }
}
?>
<form>
    <?= input_hidden('parameter', $parameter) ?>
    <?= input_hidden('id_pengguna', $id_pengguna) ?>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label>Nama Pegawai</label>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form-control-static"><?= $nm_lengkap ?></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form-control-static"><?= $email ?></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>NIK</label>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form-control-static"><?= $nik ?></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form-control-static"><?= $jns_kelamin ?></p>
                    </div>
                </div>
            </div>
            <!--
            <div class="form-group">
                <label>Password</label>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form-control-static"><?= $kt_sandi ?></p>
                    </div>
                </div>
            </div>
            -->
            <div class="form-group">
                <label>Nomor HP</label>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form-control-static"><?= $no_hp ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-4">
                <label><b>KTP</b></label>
                <div class="col-md-12">
                    <?php
                    if ($ktp != '') {
                        // Menampilkan gambar jika bukti berupa gambar
                        echo '<img src="' . assets('unggah/ktp/' . $ktp) . '" class="img-thumbnail" alt="KTP">';
                    } else {
                        // Menampilkan teks jika bukti tidak ada
                        echo '<p>Tidak ada Foto.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <a href="<?= site_url($url . '/form/ubah/' .  $id_pengguna) ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
    </div>
</form>
<?= content_close() ?>