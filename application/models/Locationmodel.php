<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locationmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	/******************* L O C A T I O N ************/

	public function getLocationList($api_call='',$start='', $limit=''){
		$this->db->select('master_location.*,');
		$this->db->from('master_location');
		if($api_call == 'yes') $this->db->where('master_location.is_active','1');
		$this->db->where('master_location.is_deleted','0');
		$this->db->order_by('master_location.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function getLocationById($id){
		$this->db->select('*');
		$this->db->from('master_location');
		$this->db->where('master_location.is_deleted','0');
		$this->db->where('master_location.id',$id);
		$res=$this->db->get();
		return $res->row_array();
	}	
	public function getLocationIdByName($loc_name){
		$this->db->select('*');
		$this->db->from('master_location');
		$this->db->where('master_location.is_deleted','0');
		$this->db->where('master_location.name',$loc_name);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function change_location_status($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('master_location',$data);
	}
	public function saveLocation($data){
		return $this->db->insert('master_location',$data);
	}
	public function updateLocation($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('master_location',$data);
	}
	public function deleteLocation($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('master_location',$data);
	}

	/******************* M A S T E R   C O U N T R Y ************/

	public function getCountryList($start='', $limit=''){
		$data = [];
		$this->db->select('master_country.*');
		$this->db->from('master_country');
		$this->db->where('master_country.is_deleted','0');
		$this->db->order_by('master_country.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function getCountryById($id){
		$data = [];
		$this->db->select('master_country.*');
		$this->db->from('master_country');
		$this->db->where('master_country.is_deleted','0');
		$this->db->where('master_country.id', $id);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function saveCountry($data){
		return $this->db->insert('master_country',$data);
	}
	public function updateCountry($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('master_country',$data);
	}
	public function change_country_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('master_country',$data);
		return $result;
	}
	public function deleteCountry($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('master_country',$data);
	}

	/******************* M A S T E R   S T A T E ************/

	public function getStateList($start='', $limit=''){
		$data = [];
		$this->db->select('master_state.*,master_country.country_name AS country_name');
		$this->db->from('master_state');
		$this->db->join('master_country','master_state.country_id=master_country.id','left');
		$this->db->where('master_state.is_deleted','0');
		$this->db->order_by('master_state.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function getStateById($id){
		$data = [];
		$this->db->select('master_state.*');
		$this->db->from('master_state');
		$this->db->where('master_state.is_deleted','0');
		$this->db->where('master_state.id', $id);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function saveState($data){
		return $this->db->insert('master_state',$data);
	}
	public function updateState($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('master_state',$data);
	}
	public function change_state_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('master_state',$data);
		return $result;
	}
	public function deleteState($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('master_state',$data);
	}
}