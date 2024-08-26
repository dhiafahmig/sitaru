<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Statistik extends CI_Model {
    
    public function get_data_kategori() {
        $this->db->select('m_kategori_hotspot.nm_kategori_hotspot, COUNT(t_hotspot.id_kategori_hotspot) as total_laporan');
        $this->db->from('t_hotspot');
        $this->db->join('m_kategori_hotspot', 't_hotspot.id_kategori_hotspot = m_kategori_hotspot.id_kategori_hotspot');
        $this->db->group_by('m_kategori_hotspot.id_kategori_hotspot'); // Mengelompokkan berdasarkan 'id_kategori_hotspot' dari m_kategori_hotspot
        $query = $this->db->get();
        return $query->result();
    }
    public function get_jumlah_pengguna_user() {
        $this->db->from('pengguna');
        $this->db->where('level', 'User');
        return $this->db->count_all_results();
    }

	  public function get_jumlah_pengguna_petugas() {
        $this->db->from('pengguna');
        $this->db->where('level', 'Petugas');
        return $this->db->count_all_results();
    }

	 	 public function get_total_laporan() {
        $this->db->from('t_hotspot');
        return $this->db->count_all_results();
    }
	    public function get_laporan_selesai() {
        $this->db->from('t_hotspot');
        $this->db->where('id_kategori_hotspot', '3');
        return $this->db->count_all_results();
    }
	   public function get_laporan_ditolak() {
        $this->db->from('t_hotspot');
        $this->db->where('id_kategori_hotspot', '2');
        return $this->db->count_all_results();
    }

		 public function get_laporan_diproses() {
        $this->db->from('t_hotspot');
        $this->db->where('id_kategori_hotspot', '4');
        return $this->db->count_all_results();
    }

		public function get_laporan_diterima() {
        $this->db->from('t_hotspot');
        $this->db->where('id_kategori_hotspot', '1');
        return $this->db->count_all_results();
    }

	public function get_total_masyarakat() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('pengguna');
        $this->db->where('level !=', 'Admin');
        $this->db->where('level !=', 'Petugas');
        $query = $this->db->get();
        return $query->row()->total;
    }

	public function get_total_masyarakat_data_lengkap() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('pengguna');
        $this->db->where('level !=', 'Admin');
        $this->db->where('level !=', 'Petugas');
        $this->db->where('nm_lengkap IS NOT NULL');
        $this->db->where('ktp IS NOT NULL');
        $this->db->where('no_hp IS NOT NULL');
        $this->db->where('nm_lengkap !=', '');
        $this->db->where('ktp !=', '');
        $this->db->where('no_hp !=', '');
        $query = $this->db->get();
        return $query->row()->total;
    }

	public function get_total_masyarakat_data_tidak_lengkap() {
        $total = $this->get_total_masyarakat();
        $complete = $this->get_total_masyarakat_data_lengkap();
        return $total - $complete;
    }
}
?>