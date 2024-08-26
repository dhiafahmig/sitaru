<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HotspotModel extends CI_Model
{
	function profile($id) {
		return $this->db->get_where('pengguna', array('id_pengguna' => $id));
	}	

	function get()
	{
		$data = $this->db->select('*')
			->from('t_hotspot a')
			->join('pengguna d', 'a.id_pengguna=d.id_pengguna', 'LEFT')
			->join('m_kecamatan b', 'a.id_kecamatan=b.id_kecamatan', 'LEFT')
			->join('m_kategori_hotspot c', 'a.id_kategori_hotspot=c.id_kategori_hotspot', 'LEFT')
			->get();
		return $data;
	}

	function get_data()
	{
		$id =  $this->session->id_pengguna;

		$data = $this->db->select('*')
			->from('t_hotspot a')
			->join('m_kecamatan b', 'a.id_kecamatan=b.id_kecamatan', 'LEFT')
			->join('m_kategori_hotspot c', 'a.id_kategori_hotspot=c.id_kategori_hotspot', 'LEFT')
			->where('id_pengguna', $id)
			->get();
		return $data;
	}
	    // Metode untuk memeriksa apakah pengguna adalah pelapor
    public function is_reporter($id_hotspot, $id_pengguna)
    {
        $this->db->where('id_hotspot', $id_hotspot);
        $this->db->where('id_pengguna', $id_pengguna);
        $query = $this->db->get('t_hotspot');
        return $query->num_rows() > 0;
    }

	function insert($data = array())
	{
		$this->db->insert('t_hotspot', $data);
		$info = '<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		$this->session->set_flashdata('info', $info);
	}
	function insert_batch($data = array())
	{
		$this->db->insert_batch('t_hotspot', $data);
		$info = '<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		$this->session->set_flashdata('info', $info);
	}
	function update($data = array(), $where = array())
	{
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->update('t_hotspot', $data);
		$info = '<div class="alert alert-success alert-dismissible">
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses diubah </div>';
		$this->session->set_flashdata('info', $info);
	}
	function delete($where = array())
	{
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->delete('t_hotspot');
		$info = '<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses dihapus </div>';
		$this->session->set_flashdata('info', $info);
	}
}
