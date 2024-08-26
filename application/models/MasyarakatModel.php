<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasyarakatModel extends CI_Model {

    private $table = 'pengguna';
    private $primary_key = 'id_pengguna';

    function get()
    {
        return $this->db->where('level', 'User')->get('pengguna');
    }

    public function is_user_data_complete($user_id) {
        $this->db->where('id_pengguna', $user_id);
        $user = $this->db->get('pengguna')->row();
        
        // Periksa apakah data pengguna lengkap
        return !empty($user->email) && !empty($user->nm_lengkap) && !empty($user->nik) && !empty($user->jns_kelamin) && !empty($user->tgl_lahir) && !empty($user->no_hp) && !empty($user->ktp);
    }

    function insert($data = array())
    {
        		$this->db->insert('pengguna', $data);
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
		$this->db->update('pengguna', $data);
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
        $this->db->delete('pengguna');
        $info = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Sukses!</h4> Data Sukses dihapus </div>';
        $this->session->set_flashdata('info', $info);
    }
}