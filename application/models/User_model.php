<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model {

    // Metode untuk memeriksa apakah email sudah ada
    public function is_email_unique($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('pengguna'); // Asumsi tabel pengguna bernama 'pengguna'
        return $query->num_rows() === 0;
    }

    // Metode untuk menambahkan pengguna baru
    public function register_user($data) {
        return $this->db->insert('pengguna', $data);
    }
}
