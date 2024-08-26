<?php
$id_hotspot = "";
$id_kecamatan = "";
$lokasi = "";
$keterangan = "";
$lat = "";
$lng = "";
$polygon = "";
$id_kategori_hotspot = "";
$tanggal = date('Y-m-d');
if ($parameter == 'lihat' && $id != '') {
    $this->db->where('id_hotspot', $id);
    $row = $this->Model->get()->row_array();
    extract($row);
}
?>

<?= content_open('Form Hotspot') ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label>Lokasi</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($lokasi) ?>" readonly>
        </div>
        <div class="form-group mb-4">
            <label><b>Bukti</b></label>
            <div class="col-md-10">
              <?php
        if ($bukti != '') {
            // Menampilkan gambar jika bukti berupa gambar
            echo '<img src="' . assets('unggah/bukti/' . $bukti) . '" class="img-thumbnail" alt="Bukti">';
        } else {
            // Menampilkan teks jika bukti tidak ada
            echo '<p>Tidak ada bukti.</p>';
        }
        ?>
            </div>
        </div>
        <div class="form-group mb-3">
            <textarea class="form-control" readonly><?= htmlspecialchars($keterangan) ?></textarea>
        </div>
        <div class="form-group mb-3">
            <label>Titik Koordinat</label>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?= htmlspecialchars($lat) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="<?= htmlspecialchars($lng) ?>" readonly>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label>Tanggal</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($tanggal) ?>" readonly>
        </div>
  <div class="form-group mb-3">
            <label>Status</label>
            <select class="form-control" disabled>
                <?php
                // Mendapatkan data kategori
                $op = null;
                $op[''] = 'Pilih Kategori';
                $get = $this->KategorihotspotModel->get();
                foreach ($get->result() as $row) {
                    $op[$row->id_kategori_hotspot] = $row->nm_kategori_hotspot;
                }
                foreach ($op as $key => $value) {
                    $selected = ($key == $id_kategori_hotspot) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($key) . '" ' . $selected . ' disabled>' . htmlspecialchars($value) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Tanggapan</label>
            <textarea class="form-control" readonly><?= htmlspecialchars($tanggapan) ?></textarea>
        </div>
    </div>
</div>

<?= content_close() ?>
