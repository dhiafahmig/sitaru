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
if ($parameter == 'ubah' && isset($user)) {
    extract($user);
}

// value ketika validasi
if ($this->session->flashdata('error_value')) {
    extract($this->session->flashdata('error_value'));
}
?>
<?= content_open('Ubah Profile') ?>
<?php
// menampilkan error validasi
if ($this->session->flashdata('error_validation')) {
    foreach ($this->session->flashdata('error_validation') as $key => $value) {
        echo '<div class="alert alert-danger">' . $value . '</div>';
    }
}
?>
<form method="post" action="<?= site_url('user/user/simpan') ?>" enctype="multipart/form-data">
    <?= input_hidden('parameter', $parameter) ?>
    <?= input_hidden('id_pengguna', $id_pengguna) ?>
    <div class="form-group">
        <label>Nama</label>
        <div class="row">
            <div class="col-md-6">
                <?= input_text('nm_lengkap', $nm_lengkap) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Email</label>
        <div class="row">
            <div class="col-md-6">
                <?= input_text('email', $email) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>NIK</label>
        <div class="row">
            <div class="col-md-6">
                <?= input_text('nik', $nik) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
		<label>Tanggal Lahir</label>
		<div class="row">
			<div class="col-md-6">
				<?= input_date('tgl_lahir', $tgl_lahir) ?>
			</div>
		</div>
	</div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <div class="row">
            <div class="col-md-6">
                <select name="jns_kelamin" class="form-control">
                    <option value="Laki-laki" <?= ($jns_kelamin == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($jns_kelamin == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Password</label>
        <div class="row">
            <div class="col-md-6">
                <input type="password" name="kt_sandi" class="form-control" placeholder="Masukkan password baru (kosongkan jika tidak diubah)">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="no_hp">Nomor HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= isset($user['no_hp']) ? $user['no_hp'] : '' ?>">
    </div>
    <div class="form-group">
        <label>KTP</label>
        <div class="row">
            <div class="col-md-10">
                <?= input_file('ktp', '') ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" name="simpan" value="true" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
        <a href="<?= site_url('user/user/profile/lihat/'.  $this->session->id_pengguna) ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
    </div>
</form>
<?= content_close() ?>