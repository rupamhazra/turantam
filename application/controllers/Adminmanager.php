<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adminmanager extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Adminmodel','adminmodel');
		$this->load->model('Usermodel','usermodel');
		$this->load->model('Servicemodel','servicemodel');
		$this->load->model('Productmodel','productmodel');
		$this->load->model('Ordermodel','ordermodel');
	}
	public function index(){
		if(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)
			redirect(base_url('admin-dashboard'));
		else
			$this->load->view('admin/login');
	}
	public function doLogin(){
		$email=$this->input->post('inputEmail');
		$pass=md5($this->input->post('inputPassword'));
		$res=$this->adminmodel->checkLogin($email,$pass);
		if($res){
			redirect(base_url('admin-dashboard'));
		}
		else{
			$this->session->set_flashdata("login_error","Login failed! Provide actual login credentials.");
			redirect(base_url('admin'));
		}
	}
	public function logout(){
		session_destroy();
		redirect(base_url('admin'));
	}
	public function dashboard()
	{
		$data=array();
		$data['services'] = $this->servicemodel->getServiceList();
		$data['users'] = $this->usermodel->getUserList('customer');
		$data['packages'] = $this->productmodel->getPackageList();
		$data['orders'] = $this->ordermodel->getOrderList();
		$data['service_categories'] = $this->productmodel->listCategory('');
		$data['recentOrders'] = $this->ordermodel->getOrderList('','',0,5);
		//pre($data['service_categories'],1);
		//$data['parentList']=$this->adminmodel->getParentListAll();
		if($_SESSION['adminLogin']==true)
			$this->template->load('adminTemplate','admin/dashboard',$data);
		else
			redirect(base_url('admin'));
	}
	
	/******************* U S E R S *****************/

	public function userList(){
		$data = $search = array();
		$search_key['user_or_email'] = $this->input->get('user_or_email');
		$data['userList']=$this->usermodel->getUserList('customer',$search_key);
		$this->template->load('adminTemplate','admin/user/list',$data);
	}
	public function addUser(){
		$data=array();
		if($this->input->post('userAdd') && $this->input->post('userAdd')==1){
			//echo "hhh";
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['email']=$this->input->post('inputEmail');
			$dataSave['contact']=$this->input->post('inputPhone');
			$dataSave['password']= md5($this->input->post('inputPassword'));
			//$dataSave['is_admin']= !(empty($this->input->post('is_admin')))?$this->input->post('is_admin'):'0';
			$lPicture = '';
			if(!empty($_FILES['inputProfileImage']['name']))
			{
	            $config['upload_path'] = 'uploads/profile_images';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['inputProfileImage']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('inputProfileImage')){
	                $uploadData = $this->upload->data();
	                $lPicture = 'profile_images/'.$config['file_name'];
	            }
				else{
					 $error = array('error' => $this->upload->display_errors());
	                 $lPicture = '';
	            }
	        }
			else
			{
	            $lPicture = '';
	        }
	        $dataSave['profile_image'] = $lPicture;
			//$dataSave['user_id']=$this->input->post('user_id');
			//$dataSave['is_active']='active';
			//pre($dataSave,1);
			$this->usermodel->userRegister($dataSave);
			redirect(base_url('admin/list-user'));
		}
		else{
			$this->template->load('adminTemplate','admin/user/add',$data);
		}
	}
	public function updateUser($id){
		$data=array();
		$data['user']=$this->usermodel->getUserById($id);
		if($this->input->post('userEdit')){
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['email']=$this->input->post('inputEmail');
			$dataSave['contact']=$this->input->post('inputPhone');
			$dataSave['password']= md5($this->input->post('inputPassword'));
			//$dataSave['is_admin']= !(empty($this->input->post('is_admin')))?$this->input->post('is_admin'):'0';
			if(!empty($_FILES['inputProfileImage']['name']))
			{
	            $config['upload_path'] = 'uploads/profile_images';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['inputProfileImage']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('inputProfileImage')){
	                $uploadData = $this->upload->data();
	                $lPicture = 'profile_images/'.$config['file_name'];
	            }
				else{
					 $error = array('error' => $this->upload->display_errors());
	                 $lPicture = '';
	            }
	            $dataSave['profile_image'] = $lPicture;
	        }
			$this->usermodel->update_user($id,$dataSave);
			redirect(base_url('admin/list-user'));
		}
		else{
			$this->template->load('adminTemplate','admin/user/edit',$data);
		}
	}
	public function changeUserStatus($id=''){
		$data['is_active'] = $this->input->post('is_active');
		$result = $this->usermodel->change_user_status($id,$data);
		if($result) echo true;
	}
	public function delete_or_ac_inac_multi_user(){
		//pre($this->input->post(),1);
		$result = false;
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$result = $this->usermodel->deleteUser($id);

			}
			
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='1';
				$result = $this->usermodel->change_user_status($id,$data);
			}
			
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='0';
				$result = $this->usermodel->change_user_status($id,$data);
			}
			
		}
		if($result) echo true;
	}
	public function deleteUser($id){
		$result = $this->usermodel->deleteUser($id);
		if($result){
			$this->session->set_flashdata('msg','User deleted successfully !!');
			redirect(base_url('admin/list-user'));
		}
	}
	public function userChangePassword()
	{
		$result = $this->usermodel->change_password();
		if($result) echo true;
	}
}
