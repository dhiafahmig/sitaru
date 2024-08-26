<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatushotspotModel extends CI_Model{
	function get(){
		$data=$this->db->get('m_status');
		return $data;
	}
	
}
