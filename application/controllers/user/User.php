<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MasyarakatModel', 'Model');
        $this->check_user();
    }

    protected function check_user() {
        if (!$this->session->userdata('logged') || 
            !in_array($this->session->userdata('level'), ['User', 'Admin'])) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Anda tidak memiliki akses ke halaman ini
                </div>');
            redirect('admin/auth');
            exit();
        }
    }

    public function beranda() {
        $datacontent['title'] = 'Halaman Beranda';
        $data['content'] = $this->load->view('admin/berandaView', $datacontent, TRUE);
        $data['title'] = 'Selamat Datang di Beranda';
        $this->load->view('admin/layouts/html', $data);
    }

    public function form($parameter = '', $id = '') {
        $datacontent['url'] = 'user/form';
        $datacontent['parameter'] = $parameter;
        $datacontent['id'] = $id;
        $datacontent['title'] = 'Ubah Profile';

        // Check if the logged-in user is trying to access the form of their own profile
        if ($parameter == 'ubah' && $id != '' && $this->session->userdata('id_pengguna') != $id) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Anda tidak memiliki akses ke halaman ini
                </div>');
            redirect('user/user/profile/lihat/' . $this->session->userdata('id_pengguna'));
            exit();
        }

        if ($parameter == 'ubah' && $id != '') {
            $this->db->where('id_pengguna', $id);
            $datacontent['user'] = $this->Model->get()->row_array();
        }

        $data['content'] = $this->load->view('user/formView', $datacontent, TRUE);
        $data['title'] = $datacontent['title'];
        $this->load->view('admin/layouts/html', $data);
    }

    public function profile($parameter = '', $id = '') {
        $datacontent['url'] = 'user/user';
        $datacontent['parameter'] = $parameter;
        $datacontent['id'] = $id;
        $datacontent['title'] = 'Profil';

        // Check if the logged-in user is trying to access their own profile
        if ($this->session->userdata('id_pengguna') != $id) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Anda tidak memiliki akses ke halaman ini
                </div>');
            redirect('user/user/profile/lihat/' . $this->session->userdata('id_pengguna'));
            exit();
        }

        $data['content'] = $this->load->view('user/profilView', $datacontent, TRUE);
        $data['title'] = $datacontent['title'];
        $this->load->view('admin/layouts/html', $data);
    }

    public function detail($parameter = '', $id = '')
    {
        $datacontent['url'] = 'user/hotspot';
        $datacontent['parameter'] = $parameter;
        $datacontent['id'] = $id;
        $datacontent['title'] = 'Form Hotpost';
        
        $data['content'] = $this->load->view('admin/hotspot/detailView', $datacontent, TRUE);
        $data['js'] = $this->load->view('admin/hotspot/js/formJs', $datacontent, TRUE);
        $data['title'] = $datacontent['title'];
        $this->load->view('admin/layouts/html', $data);
    }

    public function simpan() {
        $parameter = $this->input->post('parameter');
        $id_pengguna = $this->input->post('id_pengguna');
        $data = [
            'email' => $this->input->post('email'),
            'nm_lengkap' => $this->input->post('nm_lengkap'),
            'nik' => $this->input->post('nik'),
            'jns_kelamin' => $this->input->post('jns_kelamin'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'no_hp' => $this->input->post('no_hp')
        ];

        if ($this->input->post('kt_sandi')) {
            $password = $this->input->post('kt_sandi'); // Pastikan ini hanya digunakan untuk hashing
            $data['kt_sandi'] = password_hash($password, PASSWORD_BCRYPT); // Simpan password terenkripsi
        } else {
            // Jangan update password jika tidak ada input baru
            unset($data['kt_sandi']); 
        }

        // Handle KTP upload
        if ($_FILES['ktp']['name'] != '') {
            $upload = upload('ktp', 'ktp', 'image');
            if ($upload['info'] == true) {
                $data['ktp'] = $upload['upload_data']['file_name'];
            } else {
                $info = '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4> ' . $upload['message'] . ' </div>';
                $this->session->set_flashdata('info', $info);
                redirect('user/user/profile/lihat/' . $id_pengguna);
                exit();
            }
        }

        if ($parameter == "tambah") {
            $this->Model->insert($data);
        } else {
            $this->Model->update($data, ['id_pengguna' => $id_pengguna]);
        }

        redirect('user/user/profile/lihat/' . $id_pengguna);
    }
}
?>