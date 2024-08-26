<?= content_open($title) ?>
<a href="<?= site_url($url . '/form/tambah') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
<hr>
<?= $this->session->flashdata('info') ?>
<div class="table-responsive" style="width: 100%;">
    <table class="table table-bordered dt" style="width: 100%;">
        ...
	<thead>
		<tr>
			<th class="text-center" width="50px">No</th>
			<th>Nama Masyarakat</th>
			<th>NIK</th>
			<th>Foto KTP</th>
			<th>Jenis Kelamin</th>
			<th>Tanggal Lahir</th>
			<th width="200px">Aksi</th>
		</tr>
	</thead>
</table>
</div>
<?= content_close() ?>
