<?php
$id_hotspot = "";
$id_kecamatan = "";
$lokasi = "";
$keterangan = "";
$lat = "";
$lng = "";
$polygon = "";
$tanggal = date('Y-m-d');
if ($parameter == 'ubah' && $id != '') {
    $this->db->where('id_hotspot', $id);
    $row = $this->Model->get()->row_array();
    extract($row);
}
?>
<?= content_open('Form Hotspot') ?>
<form method="post" action="<?= site_url($url . '/simpan') ?>" enctype="multipart/form-data">
    <?= input_hidden('id_hotspot', $id_hotspot) ?>
    <?= input_hidden('parameter', $parameter) ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Lokasi</label>
                <div class="row">
                    <div class="col-md-8">
                        <?= input_text('lokasi', $lokasi) ?>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" id="getLocationBtn"><i class="fa fa-map-marker"></i> GPS</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Bukti</label>
                <div class="row">
                    <div class="col-md-10">
                        <?= input_file('bukti', '') ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <div class="row">
                    <div class="col-md-12">
                        <?= textarea('keterangan', $keterangan) ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Titik Koordinat</label>
                <div class="row">
                    <div class="col-md-6">
                        <?= input_text('lat', $lat, '', 'readonly') ?>
                    </div>
                    <div class="col-md-6">
                        <?= input_text('lng', $lng, '', 'readonly') ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <div class="row">
                    <div class="col-md-8">
                        <?= input_date('tanggal', $tanggal) ?>  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Pilih Titik</h3>
            <div id="map" style="height: 400px"></div>
            <?= textarea('polygon', $polygon, '', 'style="display:none"') ?>
        </div>
        <div class="col-md-12">
            <hr>
            <div class="form-group">
                <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= site_url($url) ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
            </div>
        </div>
    </div>
</form>
<?= content_close() ?>
