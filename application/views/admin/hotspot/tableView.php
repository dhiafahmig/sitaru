<?= content_open($title) ?>
<a href="<?= site_url($url . '/form/tambah') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
<?= $this->session->flashdata('info') ?>

<table class="table table-responsive table-bordered dt">
	<thead>
		<tr>
			<th width="50px" class="text-center">No</th>
			<th>Tanggal</th>
			<th>Lokasi</th>
			<th>Pelapor</th>
			<th>No HP</th>
			<th>KTP</th>
			<th>Keterangan</th>
			<th>Status</th>
			<th>Tanggapan</th>
			<th width="200px">Aksi</th>
		</tr>
	</thead>
</table>
<?= content_close() ?>