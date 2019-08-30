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
		$this->load->model('Settingsmodel','settingsmodel');
		$this->load->model('Servicemodel','servicemodel');
		$this->load->library('pagination');
		$this->load->model('Ordermodel','ordermodel');
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
		$data['password'] = $this->post('password');
		$data['user_type'] = !empty($this->post('user_type'))? $this->post('user_type'):'2';
		$data['otp_verified'] = $this->post('otp_verified');
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
	public function userForgetPasswordOtp_post(){
		$data = [];
		$data['contact'] = $this->post('contact');
		//$data['password'] = $this->post('password');
		$result = $this->usermodel->userForgetPasswordOtp($data);
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
	public function userForgetPasswordUpdate_post(){
		$data = [];
		$data['contact'] = $this->post('contact');
		$data['otp_verified'] = $this->post('otp_verified');
		$data['password'] = $this->post('password');
		$result = $this->usermodel->userForgetPasswordUpdate($data);
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
	public function userProfile_get($user_id){
		$result = $this->usermodel->getUserById($user_id);
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
	public function userProfileUpdate_post($user_id){
		$data = [];
		$data['name'] = $this->post('name');
		$data['email'] = $this->post('email');
		$data['contact'] = $this->post('contact');
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
            $data['profile_image'] = $lPicture;
        }
		$result = $this->usermodel->update_user($user_id,$data,'yes');
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

	public function recentCategoryList_get(){
		$result = $this->productmodel->listCategory('yes',0,3);
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
	public function categoryList_get(){
		$category_name = $this->get('cat_name');
		$result = $this->productmodel->listCategory('yes','','',$category_name);
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
	public function categoryId_get($cat_name){
		$result = $this->productmodel->getCategoryIdByName($cat_name);
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
		$data 					= $extra_data = [];
		$data['parent_id'] 		= $cat_id;
		$data['location_id'] 	= $location;
		$extra_data['key'] = 'category_name';
		$extra_data['value'] = $this->servicemodel->getServiceCategoryById($cat_id);
		$result = $this->productmodel->listSubCategory('yes',$data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list',$extra_data);
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list',$extra_data);
        }
	}

	/************* S E R V I C E *****************************/
	public function servicesListByCatId_get($cat_id_or_slug){
		$result = $this->productmodel->getServicesByCategory($cat_id_or_slug,'yes');
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
		$extra_data = [];
		$data['sub_category_id'] 		= $sub_category_id;
		$extra_data['key'] = 'subcategory_name';
		$extra_data['value'] = $this->servicemodel->getServiceCategoryById($sub_category_id);
		$result 					= $this->productmodel->listServicesBySubCatId($data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list',$extra_data);
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list',$extra_data);
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
	public function packagesListByServiceId_get($service_id_or_slug){
		$extra_data = [];
		$extra_data['key'] = 'service_name';
		$extra_data['value'] = $this->servicemodel->getServiceById($service_id_or_slug,'yes');
		$data['service_id_or_slug'] 		= $service_id_or_slug;
		$result 					= $this->productmodel->listPackagesByServiceId($data);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list',$extra_data);
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list',$extra_data);
        }
	}
	public function packagesDetails_get($package_id_or_slug){
		$data['package_id_or_slug'] 		= $package_id_or_slug;
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

	public function locationId_get($loc_name){
		$result = $this->locationmodel->getLocationIdByName($loc_name);
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

	/************* S T A T E S *****************************/
	public function stateList_get(){
		$result = $this->locationmodel->getStateList('yes');
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

	/************* C U S T O M E R S *************************/
	public function customerAddressListByCusId_get($customer_id){
		$result = $this->ordermodel->getAddressListByCustomerId('yes',$customer_id);
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
	public function addCustomerAddress_post(){
		$data = [];
		$data['address'] = $this->post('address');
		$data['pincode'] = $this->post('pincode');
		$data['state_id'] = $this->post('state_id');
		$data['customer_id'] = $this->post('customer_id');
		$data['type'] = $this->post('type');
		$result = $this->ordermodel->saveCustomerAddress('yes',$data);
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

	/************* O R D E R S *************************/
	
	public function orderListByCustomerId_get($customer_id){
		$result = $this->ordermodel->getOrderList('yes','','','',$customer_id);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function orderDetailsByID_get($order_id){
		$result = $this->ordermodel->getOrderById($order_id);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function orderConfig_get(){
		$type= $this->get('type');
		$customer_email=$this->get('customer_email');
		$price=$this->get('price');
		$result = getOrderConfigDetails($type,$customer_email,$price);
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}
	public function addOrder_post(){
		$data = [];
		$data['total_price'] = $this->post('order_total_price');
		$data['address_id'] = $this->post('address_id');
		$data['customer_id'] = $this->post('customer_id');
		$data['payment_type'] = $this->post('payment_type');
		$data['customer_email'] = $this->post('customer_email');
		$data['order_details'] = $this->post('order_details');
		$result = $this->ordermodel->saveOrder('yes',$data);
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
	


	/************* G A L L E R Y *************************/

	public function galleryImageList_get(){
		$result = $this->settingsmodel->getGallery();
		if (!empty($result))
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
        else
        {
        	$this->setResponse(REST_Controller::HTTP_OK,TRUE,$result,'list');
        }
	}

	public function contactUsMail_post(){
		$data = [];
		$data['name'] = $this->post('name');
		$data['email'] = $this->post('email');
		$data['phone'] = $this->post('phone');
		$data['message'] = $this->post('message');
		$result1 = send_mail($data,'contact-us');
		if($result1){
			$result['status'] = TRUE;
			$result['message'] = 'Your query has been submitted successfully.';
		}
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

	/****************** P A C K A G E  R A T I N G *************************/
	public function addPackageRating_post(){
		$data = [];
		$data['user_id'] = $this->post('user_id');
		$data['order_id'] = $this->post('order_id');
		$data['package_id'] = $this->post('package_id');
		$data['rating'] = $this->post('rating');
		$result = $this->productmodel->addPackageRating($data);
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

	/************** R E S P O N S E ***************/

	public function setResponse($http_tag='',$status='',$message='',$response_type='',$extra_data='')
	{
		switch ($response_type) {
			case 'list':
				if(!empty($extra_data)){
					$this->set_response([
                'status' => $status,
                $extra_data['key'] => $extra_data['value']['name'],
                'result' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				}else{
					$this->set_response([
                'status' => $status,
                'result' => $message
            ], $http_tag); // NOT_FOUND (404) being the HTTP response code
				}
				
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