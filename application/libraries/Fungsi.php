<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fungsi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->check_access();
    }

    protected function check_access() {
        // Mengecek apakah pengguna sudah login dan memiliki level admin atau petugas
        $level = $this->session->userdata('level');
        if (!$this->session->userdata('logged') || !in_array($level, ['Admin', 'Petugas'])) {
            // Redirect ke halaman login atau halaman yang diinginkan
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Anda tidak memiliki akses ke halaman ini
                </div>');
            redirect('admin/auth'); // Sesuaikan dengan halaman yang diinginkan
            exit();
        }
    }
}
