<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Panggil fungsi check_admin di awal
        $this->check_admin();
    }

    protected function check_admin() {
        // Pengecekan apakah pengguna sudah login dan levelnya adalah Admin atau Petugas
        if (!$this->session->userdata('logged') || !in_array($this->session->userdata('level'), ['Admin', 'Petugas'])) {
            redirect('user/beranda');
            exit();
        }
    }

    public function index() {
        $this->load->model('M_Statistik');

        // Ambil data dari model M_Statistik
        $data_kategori = $this->M_Statistik->get_data_kategori();
        $data_jumlah_user = $this->M_Statistik->get_jumlah_pengguna_user();
        $data_jumlah_petugas = $this->M_Statistik->get_jumlah_pengguna_petugas();
        $data_laporan_selesai = $this->M_Statistik->get_laporan_selesai();
        $data_laporan_ditolak = $this->M_Statistik->get_laporan_ditolak();
        $data_laporan_diterima = $this->M_Statistik->get_laporan_diterima();
        $data_laporan_diproses = $this->M_Statistik->get_laporan_diproses();
        $data_total_laporan = $this->M_Statistik->get_total_laporan();
        $total_masyarakat = $this->M_Statistik->get_total_masyarakat();
        $total_masyarakat_data_lengkap = $this->M_Statistik->get_total_masyarakat_data_lengkap();
        $total_masyarakat_data_tidak_lengkap = $this->M_Statistik->get_total_masyarakat_data_tidak_lengkap();

        // Siapkan data untuk chart berdasarkan status laporan
        $labels = ['Selesai', 'Ditolak', 'Diterima', 'Diproses'];
        $data = [
            $data_laporan_selesai,
            $data_laporan_ditolak,
            $data_laporan_diterima,
            $data_laporan_diproses
        ];

        // Data untuk dikirim ke view
        $datacontent['title'] = 'Halaman Statistik';
        $datacontent['chart_labels'] = $labels;
        $datacontent['chart_data'] = json_encode($data); // Ensure data is in JSON format for the chart
        $datacontent['laporan_selesai'] = $data_laporan_selesai;
        $datacontent['laporan_ditolak'] = $data_laporan_ditolak;
        $datacontent['laporan_diproses'] = $data_laporan_diproses;
        $datacontent['laporan_diterima'] = $data_laporan_diterima;
        $datacontent['total_laporan'] = $data_total_laporan;
        $datacontent['jumlah_user'] = $data_jumlah_user;
        $datacontent['jumlah_petugas'] = $data_jumlah_petugas;
        $datacontent['total_masyarakat'] = $total_masyarakat;
        $datacontent['total_masyarakat_data_lengkap'] = $total_masyarakat_data_lengkap;
        $datacontent['total_masyarakat_data_tidak_lengkap'] = $this->M_Statistik->get_total_masyarakat_data_tidak_lengkap();

        $data['content'] = $this->load->view('admin/berandaView', $datacontent, TRUE);
        $data['title'] = 'Selamat Datang di Beranda';
        $this->load->view('admin/layouts/html', $data);
    }
}
?>