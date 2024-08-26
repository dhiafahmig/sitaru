<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hotspot extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('HotspotModel', 'Model');
		$this->load->model('KecamatanModel');
		$this->load->model('KategorihotspotModel');
		 $this->check_admin();
	}

	
  protected function check_admin() {
        // Pengecekan apakah pengguna sudah login dan levelnya adalah Admin atau Petugas
        $user_level = $this->session->userdata('level');
        if (!$this->session->userdata('logged') || !in_array($user_level, ['Admin', 'Petugas'])) {
            redirect('user/beranda');
            exit();
        }
    }

	public function index()
	{
		$datacontent['url'] = 'admin/hotspot';
		$datacontent['title'] = 'Halaman Hotpost';
		$datacontent['datatable'] = $this->Model->get();
		$data['content'] = $this->load->view('admin/hotspot/tableView', $datacontent, TRUE);
		$data['js'] = $this->load->view('admin/hotspot/js/tableJs', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function form($action = 'tambah', $parameter = '', $id = '')
	{
		$datacontent['url'] = 'admin/hotspot';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Hotpost';
		$data['content'] = $this->load->view('admin/hotspot/formView', $datacontent, TRUE);
		$data['js'] = $this->load->view('admin/hotspot/js/formJs', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
	public function simpan()
	{
		if ($this->input->post()) {
			$data = [
				'id_kategori_hotspot' => $this->input->post('id_kategori_hotspot'),
				'keterangan' => $this->input->post('keterangan'),
				'lokasi' => $this->input->post('lokasi'),
				'lat' => $this->input->post('lat'),
				'lng' => $this->input->post('lng'),
				'tanggal' => $this->input->post('tanggal'),
			];
			// upload
			if ($_FILES['bukti']['name'] != '') {
				$allowed_types = ['image/jpeg', 'image/png'];
				$file_type = mime_content_type($_FILES['bukti']['tmp_name']);
				
				if (in_array($file_type, $allowed_types)) {
					$upload = upload('bukti', 'bukti', 'image');
					if ($upload['info'] == true) {
						$data['bukti'] = $upload['upload_data']['file_name'];
					} elseif ($upload['info'] == false) {
						$info = '<div class="alert alert-danger alert-dismissible">
		            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		            		<h4><i class="icon fa fa-ban"></i> Error!</h4> ' . $upload['message'] . ' </div>';
						$this->session->set_flashdata('info', $info);
						redirect('admin/hotspot');
						exit();
					}
				} else {
					$info = '<div class="alert alert-danger alert-dismissible">
	            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            		<h4><i class="icon fa fa-ban"></i> Error!</h4> File type not allowed. Only JPG and PNG are accepted. </div>';
					$this->session->set_flashdata('info', $info);
					redirect('admin/hotspot');
					exit();
				}
			}

			if ($_POST['parameter'] == "tambah") {
				$this->Model->insert($data);
			} else if ($_POST['parameter'] == "ubah") {
				$this->Model->update($data, ['id_hotspot' => $this->input->post('id_hotspot')]);
			} else if ($_POST['parameter'] == "ubahtanggapan") {
				$data['id_kategori_hotspot'] = $this->input->post('id_kategori_hotspot');
				$data['tanggapan'] = $this->input->post('tanggapan');
				$this->Model->update($data, ['id_hotspot' => $this->input->post('id_hotspot')]);
			}
		}
		redirect('admin/hotspot');
	}


	
// Fungsi controller untuk menangani tanggapan dan perubahan status
	public function tanggapan($parameter = '', $id = '')
	{
		$datacontent['url'] = 'admin/hotspot';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Hotpost';
		$data['content'] = $this->load->view('admin/hotspot/tanggapanView', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}


	public function hapus($id = '')
	{
		// hapus file di dalam folder
		$this->db->where('id_hotspot', $id);
		$get = $this->Model->get()->row();
		$geojson_hotspot = $get->geojson_hotspot;
		unlink('assets/unggah/geojson/' . $geojson_hotspot);
		// end hapus file di dalam folder
		$this->Model->delete(["id_hotspot" => $id]);
		redirect('admin/hotspot');
	}

	public function detail($parameter = '', $id = '')
	{
		$datacontent['url'] = 'admin/hotspot';
		$datacontent['parameter'] = $parameter;
		$datacontent['id'] = $id;
		$datacontent['title'] = 'Form Hotpost';
		$data['content'] = $this->load->view('admin/hotspot/detailView', $datacontent, TRUE);
		$data['js'] = $this->load->view('admin/hotspot/js/formJs', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}


	public function datatable()
	{
		header('Content-Type: application/json');
		$url = 'admin/hotspot';
		$kolom = ['id_hotspot', 'tanggal','nm_lengkap','lokasi', 'nm_kecamatan', 'keterangan', 'nm_kategori_hotspot'];

    // Filter berdasarkan tanggal jika parameter disediakan
    if ($this->input->get('startDate') && $this->input->get('endDate')) {
        $startDate = $this->input->get('startDate', TRUE);
        $endDate = $this->input->get('endDate', TRUE);
        $this->db->where('tanggal >=', $startDate);
			$this->db->where('tanggal <=', $endDate);
		}

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
			$r[] = $row->tanggal;
			$r[] = $row->lokasi;
			$r[] = $row->nm_lengkap;
			$r[] = $row->no_hp;
			$r[] = '<button class="btn btn-sm btn-primary" onclick="viewKTP(\'' . assets('unggah/ktp/' . $row->ktp) . '\')">Lihat Foto</button>';
			$r[] = $row->keterangan;
			$r[] = $row->nm_kategori_hotspot ;
			$r[] = '<div class="btn-group">
								<a href="' . site_url($url . '/tanggapan/ubahtanggapan/' . $row->id_hotspot) . '" class="btn btn-success" style="margin-left: 5px;"><i class="fa fa-plus"></i> Tanggapan</a>
							</div>';
			$r[] = '<div class="btn-group">
								<a href="' . site_url($url . '/detail/lihat/' . $row->id_hotspot) . '" class="btn btn-primary" style="margin-left: 5px;"><i class="fa fa-eye"></i> Detail</a>
								<a href="' . site_url($url . '/hapus/' . $row->id_hotspot) . '" class="btn btn-danger" style="margin-left: 5px;" onclick="return confirm(\'Hapus data?\')"><i class="fa fa-trash"></i> Hapus</a>
							</div>';
			$output['aaData'][] = $r;

		}
		echo json_encode($output, JSON_PRETTY_PRINT);
	}



}

	/**
	<tbody>
		<?php
			$no=1;
			foreach ($datatable->result() as $row) {
				?>
					<tr>
						<td class="text-center"><?=$no?></td>
						<td><?=$row->lokasi?></td>
						<td><?=$row->nm_kecamatan?></td>
						<td><?=$row->keterangan?></td>
						<td><?=$row->lat?></td>
						<td><?=$row->lng?></td>
						<td><?=$row->tanggal?></td>
						<td><?=$row->nm_kategori_hotspot?></td>
						<td class="text-center">
							<div class="btn-group">
								<a href="<?=site_url($url.'/form/ubah/'.$row->id_hotspot)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
								<a href="<?=site_url($url.'/hapus/'.$row->id_hotspot)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
							</div>
						</td>
					</tr>
				<?php
				$no++;
			}

		?>
	</tbody>
	 **/