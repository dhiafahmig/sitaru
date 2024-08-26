<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$datacontent['title']='Form Login';
		$this->load->view('admin/authView',$datacontent);
	}

public function registration()
{
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[pengguna.email]', [
        'is_unique' => 'Email ini sudah terdaftar',
        'required' => 'Email harus diisi'
    ]);
    $this->form_validation->set_rules('nm_lengkap', 'Name', 'required|trim', [
        'required' => 'Nama harus diisi'
    ]);
    $this->form_validation->set_rules('kt_sandi', 'Password', 'required|trim|min_length[3]', [
        'min_length' => 'Password terlalu pendek!',
        'required' => 'Password harus diisi'
    ]);
    $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[pengguna.nik]', [
        'is_unique' => 'NIK ini sudah terdaftar',
        'required' => 'NIK harus diisi'
    ]);
    $this->form_validation->set_rules('jns_kelamin', 'Jenis Kelamin', 'required', [
        'required' => 'Jenis Kelamin harus diisi'
    ]);

    // skema buat akun gagal
    if ($this->form_validation->run() == false) {
        $errors = validation_errors();
        if (!empty($errors)) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Gagal </h4> '.$errors.'
            </div>');
        }
        $datacontent['title'] = 'Form Registration';
        $this->load->view('admin/registration', $datacontent);
    } 
    // skema buat akun berhasil
    else {
        $level = 'User'; // Set level sebagai User

        $data = [
            'email' => htmlspecialchars($this->input->post('email', true)),
            'nm_lengkap' => htmlspecialchars($this->input->post('nm_lengkap', true)),
            'kt_sandi' => password_hash($this->input->post('kt_sandi'), PASSWORD_DEFAULT),
            'nik' => htmlspecialchars($this->input->post('nik', true)),
            'jns_kelamin' => htmlspecialchars($this->input->post('jns_kelamin', true)),
            'level' => $level, // Atur level pengguna
            'tgl_lahir' => $this->input->post('tgl_lahir'),
        ];
        $this->db->insert('pengguna', $data);

        $this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Sukses!</h4> Pendaftaran berhasil. Silakan login.
        </div>');
        redirect('admin/auth');
    }
}

public function check(){
    if($this->input->post()){
        $email = $this->input->post('email');
        $kt_sandi = $this->input->post('kt_sandi');
        $this->db->where("email", $email);
        $data = $this->db->get("pengguna");

        if($data->num_rows() > 0){
            $row = $data->row();
            $hash = $row->kt_sandi;

            if(password_verify($kt_sandi, $hash)){
                $this->session->set_userdata("logged", true);
                $this->session->set_userdata("email", $row->email);
                $this->session->set_userdata("nm_lengkap", $row->nm_lengkap);
                $this->session->set_userdata("id_pengguna", $row->id_pengguna);
                $this->session->set_userdata("level", $row->level);

                if ($row->level == "Admin" || $row->level == "Petugas") {
                    $this->session->set_flashdata("info", '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Selamat Datang <b>'.$row->nm_lengkap.'</b> di Halaman Utama Aplikasi
                        </div>');
                    redirect("admin/beranda");
                } else if ($row->level == "User") {
                    $this->session->set_flashdata("info", '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Selamat Datang <b>'.$row->nm_lengkap.'</b> di Halaman Utama Aplikasi
                        </div>');
                    redirect("user/beranda");
                }
            } else {
                $this->session->set_userdata("logged", false);
                $this->session->set_flashdata("info", '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4> Nama Pengguna atau Kata Sandi Salah
                    </div>');
                redirect("admin/auth");
            }
        } else {
            $this->session->set_userdata("logged", false);
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Nama Pengguna atau Kata Sandi Salah
                </div>');
            redirect("admin/auth");
        }
    } else {
        redirect("admin/auth");
    }
}


	
	public function out(){
		$this->session->sess_destroy();
		redirect("admin/auth");
	}

	
}
