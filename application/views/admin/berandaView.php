<?php
$background_colors = [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
];

$border_colors = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
];

// Menyesuaikan jumlah warna dengan jumlah data
$background_colors = array_slice(array_pad($background_colors, 4, end($background_colors)), 0, 4);
$border_colors = array_slice(array_pad($border_colors, 4, end($border_colors)), 0, 4);
?>

<?=content_open('Status Counter')?>
<?=$this->session->flashdata('info')?>

<hr> <!-- This will add a horizontal rule as a divider -->

<div class="row">
    <div class="col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                <span class="count_top"><i class="fa fa-user"></i> Jumlah Pengguna</span>
                <div class="count"><?= $jumlah_user ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                <span class="count_top"><i class="fa fa-user"></i> Jumlah Petugas</span>
                <div class="count"><?= $jumlah_petugas ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                <span class="count_top"><i class="fa fa-book"></i> Total Laporan</span>
                <div class="count"><?= $total_laporan ?></div>
            </div>
        </div>
    </div>
</div>
<?=content_close()?>

<div class="row">
    <div class="col-md-6">
        <?=content_open('Total Laporan per Status')?>
        <canvas id="chartStatus" width="700" height="400"></canvas>
        <?=content_close()?>
    </div>
    <div class="col-md-6 text-center"> <!-- Center the pie chart -->
        <?=content_open('Total Masyarakat')?>
        <canvas id="chartMasyarakat" width="350" height="350"></canvas> <!-- Adjusted size -->
        <?=content_close()?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctxStatus = document.getElementById('chartStatus').getContext('2d');
    var chartStatus = new Chart(ctxStatus, {
        type: 'bar', // Tipe chart: bar, line, pie, dll.
        data: {
            labels: ['Selesai', 'Ditolak', 'Diterima', 'Diproses'],
            datasets: [{
                label: 'Jumlah Laporan per Status',
                data: [<?= $laporan_selesai ?>, <?= $laporan_ditolak ?>, <?= $laporan_diterima ?>, <?= $laporan_diproses ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) { return Number.isInteger(value) ? value : null; }
                    }
                }
            }
        }
    });

    var ctxMasyarakat = document.getElementById('chartMasyarakat').getContext('2d');
    var chartMasyarakat = new Chart(ctxMasyarakat, {
        type: 'pie', // Tipe chart: bar, line, pie, dll.
        data: {
            labels: ['Total Masyarakat', 'Data Lengkap', 'Data Tidak Lengkap'],
            datasets: [{
                label: 'Jumlah Masyarakat',
                data: [<?= $total_masyarakat ?>, <?= $total_masyarakat_data_lengkap ?>, <?= $total_masyarakat_data_tidak_lengkap ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Disable responsiveness to use fixed size
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>