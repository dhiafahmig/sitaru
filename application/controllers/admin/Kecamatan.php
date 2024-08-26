<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kecamatan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->logged !== true) {
			redirect('admin/auth');
		}
	if (!in_array($this->session->level, ['Admin', 'Petugas'])) {
			redirect('admin/beranda');
		}
		$this->load->model('KecamatanModel', 'Model');
	}

	public function index()
	{
		$datacontent['url'] = 'admin/kecamatan';
		$datacontent['title'] = 'Halaman Pola Ruang';
		$datacontent['datatable'] = $this->Model->get();
		$data['content'] = $this->load->view('admin/kecamatan/tableView', $datacontent, TRUE);
		$data['js'] = $this->load->view('admin/kecamatan/js/tableJs', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function form($parameter = '', $id = '')
	{
		$datacontent['url'] = 'admin/kecamatan';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Pola Ruang';
		$data['content'] = $this->load->view('admin/kecamatan/formView', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function simpan()
	{
		if ($this->input->post()) {

			// cek validasi
			$validation = null;

			if (count($validation) > 0) {
				$this->session->set_flashdata('error_validation', $validation);
				$this->session->set_flashdata('error_value', $_POST);
				redirect($_SERVER['HTTP_REFERER']);
				return false;
			}
			// cek validasi




			$data = [
				'nm_kecamatan' => $this->input->post('nm_kecamatan'),
				'warna_kecamatan' => $this->input->post('warna_kecamatan'),
			];
			// upload
			if ($_FILES['geojson_kecamatan']['name'] != '') {
				$upload = upload('geojson_kecamatan', 'geojson', 'geojson');
				if ($upload['info'] == true) {
					$data['geojson_kecamatan'] = $upload['upload_data']['file_name'];
				} elseif ($upload['info'] == false) {
					$info = '<div class="alert alert-danger alert-dismissible">
	            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            		<h4><i class="icon fa fa-ban"></i> Error!</h4> ' . $upload['message'] . ' </div>';
					$this->session->set_flashdata('info', $info);
					redirect('admin/kecamatan');
					exit();
				}
			}
			// upload

			if ($_POST['parameter'] == "tambah") {
				$this->Model->insert($data);
			} else {
				$this->Model->update($data, ['id_kecamatan' => $this->input->post('id_kecamatan')]);
			}
		}

		redirect('admin/kecamatan');
	}

	public function hapus($id = '')
	{
		// hapus file di dalam folder
		$this->db->where('id_kecamatan', $id);
		$get = $this->Model->get()->row();
		$geojson_kecamatan = $get->geojson_kecamatan;
		unlink('assets/unggah/geojson/' . $geojson_kecamatan);
		// end hapus file di dalam folder
		$this->Model->delete(["id_kecamatan" => $id]);
		redirect('admin/kecamatan');
	}

}
