<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adminmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	public function checkLogin($email,$pass){
		$this->db->where("email",$email);
		$this->db->where("password",$pass);
		$sql=$this->db->get('users')->row_array();
		if($sql){
			$_SESSION['adminLogin']=true;
			$_SESSION['user_id']=$sql['id'];
			$_SESSION['user_type']=$sql['user_type'];
			$_SESSION['name']=$sql['name'];
			$_SESSION['profile_image']=$sql['profile_image'];
			$_SESSION['email']=$sql['password'];
			$_SESSION['contact']=$sql['contact'];
			return true;
		}
		else{
			return false;
		}
	}
}