<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usermodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	public function userRegister($data,$api_call=''){
		$message = [];
		//pre($data,1);
		if(!empty($data['otp_verified'])){
			unset($data['otp_verified']);
			$password = $data['password'];
			$data['password'] = md5($data['password']);
			$this->db->insert('users',$data);
			$last_insert_id = $this->db->insert_id();
			$message['status'] = TRUE;
			$this->db->select('id,email,contact,name,profile_image,user_type');
			$this->db->from('users');
			$this->db->where('id',$last_insert_id);
			$this->db->where('is_active','1');
			$this->db->where('is_deleted','0');
			$res=$this->db->get();
			//pre($res->row_array(),1);
			$message['message'] = $res->row_array();
			$mail_data['name'] =  $data['name'];
			$mail_data['email'] =  $data['email'];
			$mail_data['password'] =  $password;
			send_mail($mail_data);
		}
		else
		{
			$this->db->select('id');
			$this->db->from('users');
			$this->db->where('email',$data['email']);
			$this->db->or_where('contact',$data['contact']);
			$res=$this->db->get();
			if($res->num_rows()>0){
				$message['status'] = FALSE;
			    $message['message'] = 'Duplicate entry '.$data['email'].' or '.$data['contact'].' !! Please try another';
			}
			else
			{
				// $db_debug = $this->db->db_debug; //save setting
				// $this->db->db_debug = FALSE; //disable debugging for queries
				// $this->db->insert('users',$data); 
				// //pre($this->db->last_query(),1);
				// $last_insert_id = $this->db->insert_id();
				// $this->db->db_debug = $db_debug; //restore setting
				// $msg = $this->db->conn_id->error_list;
			 //    //pre($msg,1);
			 //    if(!empty($msg)){
				//     if(!empty($msg[0]['error'])){
				//     	$message['status'] = FALSE;
				//     	$message['message'] = $msg[0]['error'];
				// 	}
				// }else{
				$otp = rand(100000,999999);
				$data['message'] = 'Check your OTP '.$otp;
				$sent = sms($data);
				$sent = (array)json_decode($sent);
				if($sent['return']){
					$message['status'] = TRUE;
					$message['message']['otp'] = base64_encode($otp);
				}
			}
		}
		
		
		return $message;
	}
	public function userLogin($data){
		$message = [];
		$this->db->select('id,email,contact,name,profile_image,user_type');
		$this->db->from('users');
		$this->db->where('email',$data['email']);
		$this->db->where('password',md5($data['password']));
		$this->db->where('is_active','1');
		$this->db->where('is_deleted','0');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
	    if($res->num_rows()<1){
	    	$message['status'] = FALSE;
	    	$message['message'] = '!Sorry, Please enter valid login creadentials';
		}else{
			$message['status'] = TRUE;
			$message['message'] = $res->row_array();
		}
		return $message;
	}
	public function getUserList($user_type='',$search_key='',$start='', $limit=''){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('is_deleted','0');
		if($user_type == 'customer') $this->db->where('user_type','3');
		else{
			$this->db->where('user_type','2');
		}
		if(!empty($search_key)) {
			if(!empty($search_key['user_or_email'])){
				$this->db->like('users.name',$search_key['user_or_email']);
				$this->db->or_like('users.email',$search_key['user_or_email']);
			}

		}
		$this->db->order_by('users.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function getUserById($id){
		$this->db->select('id,email,contact,name,profile_image,user_type');
		$this->db->from('users');
		$this->db->where('users.is_deleted','0');
		$this->db->where('users.id',$id);
		$res=$this->db->get();
		return $res->row_array();
	}	
	public function change_user_status($id,$data){
		//$data['is_active'] = $this->input->post('is_active');
		$this->db->where('id',$id);
		$result = $this->db->update('users',$data);
		//pre($this->db->last_query(),1);
		return $result;
	}
	public function saveUser($data){
		$this->db->insert('users',$data);
	}
	public function update_user($id,$data,$api_call=''){
		$message = [];
		$this->db->where('id',$id);
		$result = $this->db->update('users',$data);
		if($result){
			if($api_call == 'yes')
			{
				$message['status'] = TRUE;
				$this->db->select('id,email,contact,name,profile_image,user_type');
				$this->db->from('users');
				$this->db->where('id',$id);
				$this->db->where('is_active','1');
				$this->db->where('is_deleted','0');
				$res=$this->db->get();
				//pre($res->row_array(),1);
				$message['message'] = $res->row_array();
				return $message;
			}else{
				return result;
			}
		}
		
			
	}
	public function deleteUser($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('users',$data);
	}
	public function change_password()
	{
		$data = ['password' => md5($this->input->post('password'))];
		$this->db->where('id',$this->input->post('id'));
		//pre($this->db->last_query(),1);
		return $this->db->update('users',$data);
	}

	public function userForgetPasswordOtp($data){
		$message = [];
		$this->db->select('id,email,password');
		$this->db->from('users');
		$this->db->where('contact',$data['contact']);
		$this->db->where('is_active','1');
		$this->db->where('is_deleted','0');
		$res=$this->db->get();
		if($res->num_rows()>0){
			$otp = rand(100000,999999);
			$data['message'] = 'Plaese confirm your OTP '.$otp.' to validate';
			$sent = sms($data);
			$sent = (array)json_decode($sent);
			if($sent['return']){
				$message['status'] = TRUE;
				$message['message']['otp'] = base64_encode($otp);
			}
			
		}else{
			$message['status'] = FALSE;
			$message['message'] = 'Please check your contact!!';
		}
		return $message;
	}

	public function userForgetPasswordUpdate($data){
		$message = [];
		$idata = ['password' => md5($data['password'])];
		$this->db->where('contact',$data['contact']);
		//pre($this->db->last_query(),1);
		$result = $this->db->update('users',$idata);
		if($result){
			$message['status'] = TRUE;
			$message['message'] = 'Password changed successfully.';
			$data['message'] = 'Password has been changed successfully !!';
			$sent = sms($data);
		}
		return $message;
	}

}