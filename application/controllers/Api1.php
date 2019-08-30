<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Adminmodel','adminmodel');
		$this->load->model('Usermodel','usermodel');
		$this->load->model('Productmodel','productmodel');
		$this->load->model('Locationmodel','locationmodel');
		$this->load->library('pagination');
		//$this->load->model('Settingsmodel','settingsmodel');
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
	}

	/************ U S E R S ***************/
	public function userList_get(){
		$result = $this->usermodel->getUserList();
		//pre($result,1);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_NOT_FOUND,FALSE,'Users could not be found');
        }
	}
	public function userRegister_post(){
		$data = [];
		$data['name'] = $this->post('name');
		$data['email'] = $this->post('email');
		$data['password'] = md5($this->post('password'));
		$data['user_type'] = !empty($this->post('user_type'))? $this->post('user_type'):'2';
		$lPicture = '';
			if(!empty($_FILES['profile_image']['name']))
			{
	            $config['upload_path'] = 'uploads/profile_images';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['profile_image']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('profile_image')){
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
	    $data['profile_image'] = $lPicture;
		$data['contact'] = $this->post('contact');
		$result = $this->usermodel->userRegister($data);
		//pre($result,1);
		if ($result['status'])
        {
        	$this->setResponse(REST_Controller::HTTP_CREATED,TRUE, $result['message'],'create'); // OK (200) being the HTTP response code
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_INTERNAL_SERVER_ERROR,$result['status'],$result['message']);
        }
	}
	public function userLogin_post(){
		$data = [];
		$data['email'] = $this->post('email');
		$data['password'] = $this->post('password');
		$result = $this->usermodel->userLogin($data);
		//pre($result,1);

		if ($result['status'])
        {
        	$this->setResponse(REST_Controller::HTTP_CREATED,TRUE, $result['message'],'create'); // OK (200) being the HTTP response code
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_INTERNAL_SERVER_ERROR,$result['status'],$result['message']);
        }
	}
	public function userForget_post(){
		$data = [];
		$data['email'] = $this->post('email');
		$data['password'] = $this->post('password');
		$result = $this->usermodel->userLogin($data);
		//pre($result,1);

		if ($result['status'])
        {
        	$this->setResponse(REST_Controller::HTTP_CREATED,TRUE, $result['message'],'create'); // OK (200) being the HTTP response code
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_INTERNAL_SERVER_ERROR,$result['status'],$result['message']);
        }
	}
	
	/************* C A T E G O R Y *****************************/
	public function categoryList_get(){
		$result = $this->productmodel->listCategory('yes');
		//pre($result,1);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function subcategoryList_get($cat_id,$location){
		$data 					= [];
		$data['parent_id'] 		= $cat_id;
		$data['location_id'] 	= $location;		
		$result = $this->productmodel->listSubCategory($data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}

	/************* S E R V I C E *****************************/
	public function servicesListByCatId_get($cat_id){
		$result = $this->productmodel->getServicesByCategory($cat_id,'yes');
		//pre($result,1);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function servicesListBySubCatId_get($sub_category_id){
		$data['sub_category_id'] 		= $sub_category_id;
		$result 					= $this->productmodel->listServicesBySubCatId($data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function recentServicesList_get(){
		$result = $this->productmodel->listServices(0,6);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	
	/************* P A C K A G E S *****************************/
	public function packagesListByServiceId_get($service_id){
		$data['service_id'] 		= $service_id;
		$result 					= $this->productmodel->listPackagesByServiceId($data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function packagesDetails_get($package_id){
		$data['package_id'] 		= $package_id;
		$result 					= $this->productmodel->PackagesDetails($data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	
	/************* L O C A T I O N S *****************************/
	public function locationList_get(){
		$result = $this->locationmodel->getLocationList('yes');
		//pre($result,1);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}

	/************** R E S P O N S E ***************/
	public function setResponse($http_tag='',$status='',$message='',$response_type='')
	{
		switch ($response_type) {
			case 'list':
				$this->set_response([
                'status' => $status,
                'result' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				break;
			case 'create':
				$this->set_response([
                'status' => $status,
                'result' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				break;
			case 'update':
				$this->set_response([
                'status' => $status,
                'message' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				break;
			case 'delete':
				$this->set_response([
                'status' => $status,
                'message' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				break;
			default:
				$this->set_response([
                'status' => $status,
                'message' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				break;
		}
	}
}