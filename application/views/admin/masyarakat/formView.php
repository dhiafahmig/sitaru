<?php
$id_pengguna = "";
$email = "";
$nm_lengkap = "";
$nik = "";
$jns_kelamin = "";
$tgl_lahir = "";
$password = "";
if ($parameter == 'ubah' && $id != '') {
	$this->db->where('id_pengguna', $id);
	$row = $this->Model->get()->row_array();
	extract($row);
}

// value ketika validasi
if ($this->session->flashdata('error_value')) {
	extract($this->session->flashdata('error_value'));
}

?>
<?= content_open('Form Masyarakat') ?>
<?php
// menampilkan error validasi
if ($this->session->flashdata('error_validation')) {
	foreach ($this->session->flashdata('error_validation') as $key => $value) {
		echo '<div class="alert alert-danger">' . $value . '</div>';
	}
}
?>
<form method="post" action="<?= site_url($url . '/simpan') ?>" enctype="multipart/form-data">
	<?= input_hidden('parameter', $parameter) ?>
	<?= input_hidden('id_pengguna', $id_pengguna) ?>
	<div class="form-group">
		<label>Nama Masyarakat</label>
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
		<button type="submit" name="simpan" value="true" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
		<a href="<?= site_url($url) ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
	</div>
</form>
<?= content_close() ?>
