<?= content_open($title) ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="<?= site_url($url . '/form/tambah') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
    <div>
        <?= $this->session->flashdata('info') ?>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered dt">
        <thead>
            <tr>
                <th width="50px" class="text-center">No</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Tanggapan</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th width="200px">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<?= content_close() ?>