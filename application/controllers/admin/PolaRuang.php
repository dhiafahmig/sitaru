<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PolaRuang extends CI_Controller
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
		$this->load->model('KecamatanModel', 'Model');
	}

	public function index()
	{
		$datacontent['url'] = 'admin/polaruang';
		$datacontent['title'] = 'Halaman Pola Ruang';
		$datacontent['datatable'] = $this->Model->get();
		$data['content'] = $this->load->view('admin/polaruang/tableView', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function form($parameter = '', $id = '')
	{
		$datacontent['url'] = 'admin/polaruang';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Pola Ruang';
		$data['content'] = $this->load->view('admin/polaruang/formView', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function simpan()
	{
		if ($this->input->post()) {

			// cek validasi
			$validation = null;
			// cek kode apakah sudah ada
			if ($this->input->post('id_polaruang') != "") {
				$this->db->where('id_polaruang !=' . $this->input->post('id_polaruang'));
			}
			//tidak boleh kosong
			if ($this->input->post('nm_polaruang') == '') {
				$validation[] = 'Nama polaruang Tidak Boleh Kosong';
			}

			if (count($validation) > 0) {
				$this->session->set_flashdata('error_validation', $validation);
				$this->session->set_flashdata('error_value', $_POST);
				redirect($_SERVER['HTTP_REFERER']);
				return false;
			}
			// cek validasi




			$data = [
				'nm_polaruang' => $this->input->post('nm_polaruang'),
				'warna_polaruang' => $this->input->post('warna_polaruang'),
			];
			// upload
			if ($_FILES['geojson_polaruang']['name'] != '') {
				$upload = upload('geojson_polaruang', 'geojson', 'geojson');
				if ($upload['info'] == true) {
					$data['geojson_polaruang'] = $upload['upload_data']['file_name'];
				} elseif ($upload['info'] == false) {
					$info = '<div class="alert alert-danger alert-dismissible">
	            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            		<h4><i class="icon fa fa-ban"></i> Error!</h4> ' . $upload['message'] . ' </div>';
					$this->session->set_flashdata('info', $info);
					redirect('admin/polaruang');
					exit();
				}
			}
			// upload

			if ($_POST['parameter'] == "tambah") {
				$this->Model->insert($data);
			} else {
				$this->Model->update($data, ['id_polaruang' => $this->input->post('id_polaruang')]);
			}
		}

		redirect('admin/polaruang');
	}

	public function hapus($id = '')
	{
		// hapus file di dalam folder
		$this->db->where('id_polaruang', $id);
		$get = $this->Model->get()->row();
		$geojson_polaruang = $get->geojson_polaruang;
		unlink('assets/unggah/geojson/' . $geojson_polaruang);
		// end hapus file di dalam folder
		$this->Model->delete(["id_polaruang" => $id]);
		redirect('admin/polaruang');
	}
}
