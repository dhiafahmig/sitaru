<?php
$id_hotspot = "";
$id_kecamatan = "";
$lokasi = "";
$keterangan = "";
$lat = "";
$lng = "";
$polygon = "";
$tanggapan = "";
$status = "";
$id_kategori_hotspot = "";
$tanggal = date('Y-m-d');
if ($parameter == 'ubahtanggapan' && $id != '') {
    $this->db->where('id_hotspot', $id);
    $row = $this->Model->get()->row_array();
    extract($row);
}
?>

<?= content_open('Form Hotspot') ?>

<form method="post" action="<?= site_url($url . '/simpan') ?>" enctype="multipart/form-data">
	<?= input_hidden('id_hotspot', $id_hotspot) ?>
	<?= input_hidden('parameter', $parameter) ?>
	<?= input_hidden('lokasi', $lokasi) ?>
	<?= input_hidden('keterangan', $keterangan) ?>
	<?= input_hidden('bukti', $bukti) ?>
	<?= input_hidden('lng', $lng) ?>
	<?= input_hidden('lat', $lat) ?>
	<?= input_hidden('polygon', $polygon) ?>
	<?= input_hidden('id_kategori_hotspot', $id_kategori_hotspot) ?>
	<?= input_hidden('tanggal', $tanggal) ?>
    
    <div class="row">
    <div class="col-md-6">
			<div class="form-group">
				<label>Status</label>
				<div class="row">
					<div class="col-md-10">
						<?php
						$op = null;
						$op[''] = 'Pilih Status';
						$get = $this->KategorihotspotModel->get();
						foreach ($get->result() as $row) {
							$op[$row->id_kategori_hotspot] = $row->nm_kategori_hotspot;
						}
						?>
						<?= select('id_kategori_hotspot', $op, $id_kategori_hotspot) ?>
					</div>
				</div>
			</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggapan</label>
            <textarea class="form-control" name="tanggapan"><?= htmlspecialchars($tanggapan) ?></textarea>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
    <a href="<?= site_url($url) ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
</div>


</form>
<?= content_close() ?>