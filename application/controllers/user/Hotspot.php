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
		$this->load->model('MasyarakatModel');
    }

    public function index()
    {
        $datacontent['url'] = 'user/hotspot';
        $datacontent['title'] = 'Halaman Hotpost';
        $datacontent['datatable'] = $this->Model->get();
        $data['content'] = $this->load->view('user/hotspot/tableView', $datacontent, TRUE);
        $data['js'] = $this->load->view('user/hotspot/js/tableJs', $datacontent, TRUE);
        $data['title'] = $datacontent['title'];
        $this->load->view('admin/layouts/html', $data);
    }

    public function form($parameter = '', $id = '')
    {

		 if (!$this->MasyarakatModel->is_user_data_complete($this->session->id_pengguna)) {
        $info = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4> Data pengguna Anda belum lengkap. Harap lengkapi profil Anda sebelum melanjutkan.
            </div>';
            $this->session->set_flashdata('info', $info);
            redirect('user/hotspot'); // Arahkan ke halaman profil untuk melengkapi data
            exit();
        }

        $datacontent['url'] = 'user/hotspot';
        $datacontent['parameter'] = $parameter;
        $datacontent['id'] = $id;
        $datacontent['title'] = 'Form Hotspot';

        if ($parameter == 'ubah') {
            if (!$this->Model->is_reporter($id, $this->session->id_pengguna)) {
                $info = '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4> You are not authorized to edit this report. </div>';
                $this->session->set_flashdata('info', $info);
                redirect('user/hotspot');
                exit();
            }
            $report = $this->Model->get(['id_hotspot' => $id])->row();
            $datacontent = array_merge($datacontent, (array)$report); // Merge report data into datacontent
        }

        $data['content'] = $this->load->view('user/hotspot/formView', $datacontent, TRUE);
        $data['js'] = $this->load->view('user/hotspot/js/formJs', $datacontent, TRUE);
        $data['title'] = $datacontent['title'];
        $this->load->view('admin/layouts/html', $data);
    }
    
    public function simpan()
    {
        $id_pengguna = $this->session->id_pengguna;
        if ($this->input->post()) {
            $data = [
                'lokasi' => $this->input->post('lokasi'),
                'keterangan' => $this->input->post('keterangan'),
                'lat' => $this->input->post('lat'),
                'lng' => $this->input->post('lng'),
                'tanggal' => $this->input->post('tanggal'),
                'id_kategori_hotspot' => 1, // Automatically set to 0
            ];
            // upload
            if ($_FILES['bukti']['name'] != '') {
                $upload = upload('bukti', 'bukti', 'image');
                if ($upload['info'] == true) {
                    $data['bukti'] = $upload['upload_data']['file_name'];
                } elseif ($upload['info'] == false) {
                    $info = '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4> ' . $upload['message'] . ' </div>';
                    $this->session->set_flashdata('info', $info);
                    redirect('user/hotspot');
                    exit();
                }
            }
            // upload

            if ($this->input->post('parameter') == "tambah") {
                $data['id_pengguna'] = $id_pengguna;
                $this->Model->insert($data);
            } else {
                // Check if the user is allowed to update the report
                $id_hotspot = $this->input->post('id_hotspot');
                if ($this->Model->is_reporter($id_hotspot, $id_pengguna)) {
                    $this->Model->update($data, ['id_hotspot' => $id_hotspot]);
                } else {
                    $info = '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4> You are not authorized to update this report. </div>';
                    $this->session->set_flashdata('info', $info);
                    redirect('user/hotspot');
                    exit();
                }
            }
        }
        redirect('user/hotspot');
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
        redirect('user/hotspot');
    }

    public function detail($parameter = '', $id = '')
    {
        $datacontent['url'] = 'user/hotspot';
        $datacontent['parameter'] = $parameter;
        $datacontent['id'] = $id;
        $datacontent['title'] = 'Form Hotpost';
        $data['content'] = $this->load->view('user/hotspot/detailView', $datacontent, TRUE);
        $data['js'] = $this->load->view('user/hotspot/js/formJs', $datacontent, TRUE);
        $data['title'] = $datacontent['title'];
        $this->load->view('admin/layouts/html', $data);
    }

    public function datatable()
    {
        header('Content-Type: application/json');
        $url = 'user/hotspot';
        $kolom = ['id_hotspot', 'tanggal', 'lokasi', 'nm_kecamatan', 'keterangan', 'lat', 'lng', 'nm_kategori_hotspot'];

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

        
        $dataTable = $this->Model->get_data();
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
            $r[] = $row->tanggapan;
            $r[] = $row->keterangan;
            $r[] = $row->nm_kategori_hotspot ;
            $r[] = '<div class="btn-group">
                                <a href="' . site_url($url . '/detail/lihat/' . $row->id_hotspot) . '" class="btn btn-primary" style="margin-left: 5px;"><i class="fa fa-eye"></i> Detail</a>
                                <a href="' . site_url($url . '/form/ubah/' . $row->id_hotspot) . '" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
                                <a href="' . site_url($url . '/hapus/' . $row->id_hotspot) . '" class="btn btn-danger" onclick="return confirm(\'Hapus data?\')"><i class="fa fa-trash"></i> Hapus</a>
                            </div>';
            $output['aaData'][] = $r;
        }
        echo json_encode($output, JSON_PRETTY_PRINT);
    }
}