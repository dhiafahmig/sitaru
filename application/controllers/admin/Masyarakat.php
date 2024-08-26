<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masyarakat extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('admin/auth');
		}
		if ($this->session->level !== 'Admin') {
			redirect('admin/beranda');
		}
		$this->load->model('MasyarakatModel', 'Model');
	}

	public function index()
	{
		$datacontent['url'] = 'admin/masyarakat';
		$datacontent['title'] = 'Halaman Masyarakat';
		$datacontent['datatable'] = $this->Model->get();
		$data['content'] = $this->load->view('admin/masyarakat/tableView', $datacontent, TRUE);
		$data['js'] = $this->load->view('admin/masyarakat/js/tableJs', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}

	
	public function form($parameter = '', $id = '')
	{
		$datacontent['url'] = 'admin/masyarakat';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Masyarakat';
		$data['content'] = $this->load->view('admin/masyarakat/formView', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function simpan()
	{
		if ($this->input->post()) {
        $data = array(
            'email' => $this->input->post('email'),
            'kt_sandi' => password_hash($this->input->post('kt_sandi'), PASSWORD_DEFAULT),
            'level' => 'User', // Atur level pengguna, bisa disesuaikan
            'nik' => $this->input->post('nik'),
            'nm_lengkap' => $this->input->post('nm_lengkap'),
			  'jns_kelamin' => htmlspecialchars($this->input->post('jns_kelamin', true)),
            'tgl_lahir' => $this->input->post('tgl_lahir'), // Ubah sesuai dengan nama input pada formulir
            
            // Tambahkan kolom lain sesuai kebutuhan
        );

  
        // Lakukan validasi atau filterisasi data yang diterima sesuai kebutuhan
        
        // Masukkan data ke dalam database
       	if ($_POST['parameter'] == "tambah") {
				$this->Model->insert($data);
			} else if ($_POST['parameter'] == "ubah") {
				$this->Model->update($data, ['id_pengguna' => $this->input->post('id_pengguna')]);
			}
		}
		redirect('admin/masyarakat');
	}

	public function hapus($id_pengguna) {
    // Mulai transaksi
    $this->db->trans_start();
    
    // Hapus baris terkait di t_hotspot
    $this->db->where('id_pengguna', $id_pengguna);
    $this->db->delete('t_hotspot');
    
    // Hapus pengguna
    $this->db->where('id_pengguna', $id_pengguna);
    $this->db->delete('pengguna');
    
    // Selesaikan transaksi
    $this->db->trans_complete();
    
    if ($this->db->trans_status() === FALSE) {
        // Transaksi gagal, rollback
        $this->session->set_flashdata('error', 'Gagal menghapus pengguna.');
    } else {
        // Transaksi sukses
        $this->session->set_flashdata('success', 'Pengguna berhasil dihapus.');
    }
    
    redirect('admin/masyarakat');
}


	public function datatable()
{
    header('Content-Type: application/json');
	$url = 'admin/masyarakat';
    $kolom = ['id_pengguna', 'nm_lengkap', 'nik', 'jns_kelamin']; // Sesuaikan kolom yang akan ditampilkan

		if ($this->input->get('sSearch')) {
			$this->db->group_start();
			for ($i = 0; $i < count($kolom); $i++) {
				$this->db->or_like($kolom[$i], $this->input->get('sSearch', TRUE));
			}
			$this->db->group_end();
		}
		//order
		if ($this->input->get('iSortCol_0')) {
			for ($i = 0; $i < intval($this->input->get('iSortingCols', TRUE)); $i++) {
				if ($this->input->get('bSortable_' . intval($_GET['iSortCol_' . $i]), TRUE) == "true") {
					$this->db->order_by($kolom[intval($this->input->get('iSortCol_' . $i, TRUE))], $this->input->get('sSortDir_' . $i, TRUE));
				}
			}
		}

		if ($this->input->get('iDisplayLength', TRUE) != "-1") {
			$this->db->limit($this->input->get('iDisplayLength', TRUE), $this->input->get('iDisplayStart'));
		}

		$dataTable = $this->Model->get();
		$iTotalDisplayRecords = $this->Model->get()->num_rows();
		$iTotalRecords = $dataTable->num_rows();
		$output = [
			"sEcho" => intval($this->input->get('sEcho')),
			"iTotalRecords" => $iTotalRecords,
			"iTotalDisplayRecords" => $iTotalDisplayRecords,
			"aaData" => array()
    ];
	
	$no = 1;
		foreach ($dataTable->result() as $row) {
			$r = null;
			$r[] = $no++;
			$r[] = $row->nm_lengkap;
			$r[] = $row->nik;
			$r[] = $row->ktp ? 
                '<button class="btn btn-sm btn-primary" onclick="viewKTP(\'' . assets('unggah/ktp/' . $row->ktp) . '\')">Lihat Foto</button>' : 
                '';
			$r[] = $row->jns_kelamin;
			$r[] = $row->tgl_lahir;
			$r[] = '<div class="btn-group">
						<a href="' . site_url($url . '/form/ubah/' . $row->id_pengguna) . '" class="btn btn-sm btn-info" style="margin-left: 5px;"><i class="fa fa-edit"></i> Ubah</a>
						<a href="' . site_url($url . '/hapus/' . $row->id_pengguna) . '" class="btn btn-sm btn-danger" style="margin-left: 5px;" onclick="return confirm(\'Hapus data?\')"><i class="fa fa-trash"></i> Hapus</a>
					</div>';
			$output['aaData'][] = $r;
		}
		echo json_encode($output, JSON_PRETTY_PRINT);
}
}