<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leafletstandar extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('HotspotModel', 'Model');
		$this->load->model('KecamatanModel');
		$this->load->model('PolaRuangModel');
	}

	public function index()
	{
		$datacontent['url'] = 'admin/leafletstandar';
		$datacontent['title'] = 'Halaman Leaflet Pola Ruang';
		// $datacontent['datatable']=$this->Model->get();
		$data['content'] = $this->load->view('admin/leafletstandar/mapView', $datacontent, TRUE);
		$data['js'] = $this->load->view('admin/leafletstandar/js/mapJs', $datacontent, TRUE);
		$data['title'] = $datacontent['title'];
		$this->load->view('admin/layouts/html', $data);
	}
}
