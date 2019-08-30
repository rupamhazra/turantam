<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Servicemanager extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Adminmodel','adminmodel');
		$this->load->model('Servicemodel','servicemodel');
		$this->load->model('Productmodel','productmodel');
		$this->load->model('Usermodel','usermodel');
		$this->load->model('Locationmodel','locationmodel');
		$this->load->model('Ordermodel','ordermodel');
		$this->load->library('pagination');
	}
	/********************* C A T E G O R Y *************************/

	public function index(){
		$data=array();
		$data['parentList']=$this->servicemodel->get_all_service_category();
		$this->template->load('adminTemplate','admin/service/service-category/list',$data);
	}
	public function getParentCategoryIdList(){
		$data=array();
		$data['catList']=$this->servicemodel->get_all_service_parent_id_category();
		echo json_encode($data['catList']);
	}
	public function addServiceCategory(){
		$data=array();
		$data['locationList']=$this->locationmodel->getLocationList();
		$data['parentList']=$this->servicemodel->get_all_service_category_add();
		//pre($data['parentList'],1);
		$this->template->load('adminTemplate','admin/service/service-category/add',$data);
	}
	public function saveServiceCategory(){
		$data['name']=$this->input->post('inputName');
		$data['slug']=$this->input->post('inputUrl');
		$data['description']=$this->input->post('description');
		$data['parent_id']=$this->input->post('inputParent');
		$data['parent_slug']=$this->input->post('parent_slug');
		$data['location_id']=$this->input->post('inputLocation');
		//pre($data,1);
		$lPicture = $sPicture='';
		if(!empty($_FILES['inputImage']['name'])){
            $config['upload_path'] = 'uploads/service_cat_images/image_large';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time().$_FILES['inputImage']['name'];
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('inputImage')){
                $uploadData = $this->upload->data();
                $lPicture = 'service_cat_images/image_large/'.$config['file_name'];
                $r=$this->_create_thumbnail($uploadData['file_name'],'category');
					if($r){
						$smPicture=$uploadData['raw_name'];
                		$file=$uploadData['file_ext'];
                		$sPicture = 'service_cat_images/image_small/'.$smPicture.'_thumb'.$file;
					}
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
		$data['image_large']= $lPicture;
		$data['image_small']= $sPicture;
		//pre($data,1);
		$this->servicemodel->saveServiceCategoryData($data);
		redirect(base_url('admin/service-category'));
	}
	public function editServiceCategory($id){
		$data=array();
		$data['locationList']=$this->locationmodel->getLocationList();
		$data['parentList']=$this->servicemodel->get_all_service_category_add();
		$data['serviceCategory']=$this->servicemodel->getServiceCategoryById($id);
		//pre($data['blogCategory'],1);
		$this->template->load('adminTemplate','admin/service/service-category/edit',$data);
	}
	public function updateServiceCategory($id){
		//pre($this->input->post(),1);
		$data['name']=$this->input->post('inputName');
		$data['slug']=$this->input->post('inputUrl');
		$data['description']=$this->input->post('description');
		$data['parent_id']=$this->input->post('inputParent');
		$data['parent_slug']=$this->input->post('parent_slug');
		$data['location_id']=$this->input->post('inputLocation');
		//pre($data,1);
		if(!empty($_FILES['inputImage']['name'])){
			
			
	            $config['upload_path'] = 'uploads/service_cat_images/image_large';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['inputImage']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('inputImage')){
	                $uploadData = $this->upload->data();
	                $lPicture = 'service_cat_images/image_large/'.$config['file_name'];
	                $r=$this->_create_thumbnail($uploadData['file_name'],'category');
					if($r)
					{
						$smPicture=$uploadData['raw_name'];
	            		$file=$uploadData['file_ext'];
	            		$sPicture = 'service_cat_images/image_small/'.$smPicture.'_thumb'.$file;
					}
	            }
				else{
					 $error = array('error' => $this->upload->display_errors());
	                 $lPicture = '';
	            }
	            $data['image_large']=$lPicture;
	            $data['image_small']= $sPicture;
	            //$this->_delete_image('category',$id);
	        
        }
        //pre($data,1);
		$this->servicemodel->updateServiceCategoryData($id,$data);
		redirect(base_url('admin/service-category'));
	}
	public function changeServiceCategoryStatus($id){
		$return = $this->servicemodel->change_serviceCategory_status($id);
		echo '1';
	}
	public function deleteServiceCategory($id){
		$result = $this->servicemodel->deleteServiceCategory($id);
		if($result){
			$this->session->set_flashdata('msg','Service Category deleted successfully !!');
			redirect(base_url('admin/service-category'));
		} 
	}

	/********************* S E R V I C E *************************/

	public function serviceList(){
		$data = $search_key = array();
		$search_key['cat_id'] = $this->input->get('cat_id');
		$search_key['service_name'] = $this->input->get('service_name');
		$data['catList']=$this->servicemodel->get_all_service_sub_category();
		$data['serviceList']=$this->servicemodel->getServiceList($search_key);
		
		//pre($data,1);
		

		$this->template->load('adminTemplate','admin/service/list',$data);
	}
	public function addService($id=''){
		$data=array();
		$data['parentList']=$this->servicemodel->get_all_service_sub_category();
		//pre($data['blogCategoryList'],1);
		if($this->input->post('serviceAdd') && $this->input->post('serviceAdd')==1){
			//pre($this->input->post(),1);
			$dataSave['category_id']=$this->input->post('inputServiceCategory');
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['slug']=$this->input->post('inputSlug');
			$dataSave['description']=trim($this->input->post('inputDescription'));
			$dataSave['category_slug']=$this->input->post('category_slug');
			$lPicture = '';
			$sPicture='';
			if(!empty($_FILES['inputImage']['name'])){
                $config['upload_path'] = 'uploads/service_images/image_large';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = "large".time().$_FILES['inputImage']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
    
                if($this->upload->do_upload('inputImage')){
                    $uploadData = $this->upload->data();
                    $lPicture = 'service_images/image_large/'.$config['file_name'];
					$r=$this->_create_thumbnail($uploadData['file_name'],'service');
					if($r){
						$smPicture=$uploadData['raw_name'];
                		$file=$uploadData['file_ext'];
                		$sPicture = 'service_images/image_small/'.$smPicture.'_thumb'.$file;
					}
            		
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
			$dataSave['image_large']=$lPicture;
			$dataSave['image_small']=$sPicture;
			$result = $this->servicemodel->saveService($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Service added successfully !!');
				redirect(base_url('admin/list-service'));
			}
			
		}
		else{
			$this->template->load('adminTemplate','admin/service/add',$data);
		}
	}
	public function updateService($id){
		$data=array();
		$data['parentList']=$this->servicemodel->get_all_service_sub_category();
		$data['service']=$this->servicemodel->getServiceById($id);
		//pre($data['blog'],1);
		if($this->input->post('edit')){
			$dataSave['category_id']=$this->input->post('inputServiceCategory');
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['slug']=$this->input->post('inputSlug');
			$dataSave['description']= trim($this->input->post('inputDescription'));
			$dataSave['category_slug']=$this->input->post('category_slug');
			if(!empty($_FILES['inputImage']['name'])){
	            $config['upload_path'] = 'uploads/service_images/image_large';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['inputImage']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('inputImage')){
	                $uploadData = $this->upload->data();
	                $lPicture = 'service_images/image_large/'.$config['file_name'];
	                $r=$this->_create_thumbnail($uploadData['file_name'],'service');
					if($r)
					{
						$smPicture=$uploadData['raw_name'];
	            		$file=$uploadData['file_ext'];
	            		$sPicture = 'service_images/image_small/'.$smPicture.'_thumb'.$file;
					}
	            }
				else{
					 $error = array('error' => $this->upload->display_errors());
	                 $lPicture = '';
	            }
	            $dataSave['image_large']=$lPicture;
	            $dataSave['image_small']= $sPicture;
	            //$this->_delete_image('service',$id);
	        
        }
			
			$result = $this->servicemodel->updateService($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Service updated successfully !!');
				redirect(base_url('admin/list-service'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/service/edit',$data);
		}
	}
	public function change_service_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->servicemodel->change_service_status($id,$data);
		echo '1';
	}
	public function deleteService($id){
		$result = $this->servicemodel->deleteService($id);
		if($result){
			$this->session->set_flashdata('msg','Service deleted successfully !!');
			redirect(base_url('admin/list-service'));
		}
	}
	public function delete_or_ac_inac_multi_service(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->servicemodel->deleteService($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->servicemodel->getServiceById($id);
				$data['is_active']='1';
				$result = $this->servicemodel->change_service_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->servicemodel->getServiceById($id);
				$data['is_active']='0';
				$result = $this->servicemodel->change_service_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/******************* P A C K A G E *****************/

	public function packageList(){
		$data = $search_key = array();
		$search_key['service_id'] = $this->input->get('service_id');
		$search_key['package_name'] = $this->input->get('package_name');
		$data['serviceList']=$this->servicemodel->getServiceList();
		$data['packageList']=$this->productmodel->getPackageList($search_key);
		//pre($data,1);
		$this->template->load('adminTemplate','admin/package/list',$data);
	}
	public function addPackage($id=''){
		$data=array();
		$data['parentList']=$this->servicemodel->getServiceList();
		//pre($data['blogCategoryList'],1);
		if($this->input->post('add') && $this->input->post('add')==1){
			//pre($this->input->post(),1);
			$dataSave['service_id']=$this->input->post('inputService');
			$dataSave['service_slug']=$this->input->post('service_slug');
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['slug']=$this->input->post('inputSlug');
			$dataSave['description']=$this->input->post('inputDescription');
			$dataSave['price']=$this->input->post('inputPrice');
			$dataSave['discounted_price']=$this->input->post('inputDiscountedPrice');
			$lPicture = '';
			$sPicture='';
			if(!empty($_FILES['inputImage']['name'])){
                $config['upload_path'] = 'uploads/package_images/image_large';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = "large".time().$_FILES['inputImage']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
    
                if($this->upload->do_upload('inputImage')){
                    $uploadData = $this->upload->data();
                    $lPicture = 'package_images/image_large/'.$config['file_name'];
					$r=$this->_create_thumbnail($uploadData['file_name'],'package');
					if($r){
						$smPicture=$uploadData['raw_name'];
                		$file=$uploadData['file_ext'];
                		$sPicture = 'package_images/image_small/'.$smPicture.'_thumb'.$file;
					}
            		
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
			$dataSave['image_large']=$lPicture;
			$dataSave['image_small']=$sPicture;
			$result = $this->productmodel->savePackage($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Package added successfully !!');
				redirect(base_url('admin/list-package'));
			}
			
		}
		else{
			$this->template->load('adminTemplate','admin/package/add',$data);
		}
	}
	public function updatePackage($id){
		$data=array();
		$data['parentList']=$this->servicemodel->getServiceList();
		$data['package']=$this->productmodel->getPackageById($id);
		//pre($data['package'],1);
		if($this->input->post('edit')){
			$dataSave['service_id']=$this->input->post('inputService');
			$dataSave['service_slug']=$this->input->post('service_slug');
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['slug']=$this->input->post('inputSlug');
			$dataSave['description']=$this->input->post('inputDescription');
			$dataSave['price']=$this->input->post('inputPrice');
			$dataSave['discounted_price']=$this->input->post('inputDiscountedPrice');
			if(!empty($_FILES['inputImage']['name'])){
	            $config['upload_path'] = 'uploads/package_images/image_large';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['inputImage']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('inputImage')){
	                $uploadData = $this->upload->data();
	                $lPicture = 'package_images/image_large/'.$config['file_name'];
	                $r=$this->_create_thumbnail($uploadData['file_name'],'package');
					if($r)
					{
						$smPicture=$uploadData['raw_name'];
	            		$file=$uploadData['file_ext'];
	            		$sPicture = 'package_images/image_small/'.$smPicture.'_thumb'.$file;
					}
	            }
				else{
					 $error = array('error' => $this->upload->display_errors());
	                 $lPicture = '';
	            }
	            $dataSave['image_large']=$lPicture;
	            $dataSave['image_small']= $sPicture;
	            $this->_delete_image('package',$id);
	        
        }
			
			$result = $this->productmodel->updatePackage($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Package updated successfully !!');
				redirect(base_url('admin/list-package'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/package/edit',$data);
		}
	}
	public function change_package_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->productmodel->change_package_status($id,$data);
		echo '1';
	}
	public function deletePackage($id){
		$result = $this->productmodel->deletePackage($id);
		if($result){
			$this->session->set_flashdata('msg','Package deleted successfully !!');
			redirect(base_url('admin/list-package'));
		}
	}
	public function delete_or_ac_inac_multi_package(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->productmodel->deletePackage($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->productmodel->getPackageById($id);
				$data['is_active']='1';
				$result = $this->productmodel->change_package_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->productmodel->getPackageById($id);
				$data['is_active']='0';
				$result = $this->productmodel->change_package_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/************* P A C K A G E  E N T I T Y *************/

	public function packageEntityList(){
		$data= $search_key = array();
		$search_key['package_id'] = $this->input->get('package_id');
		$search_key['package_entity_name'] = $this->input->get('package_entity_name');
		$data['packageList']=$this->productmodel->getPackageList();
		$data['packageEntityList']=$this->productmodel->getPackageEntityList($search_key);
		//pre($data,1);
		$this->template->load('adminTemplate','admin/package/package-entity/list',$data);
	}
	public function addPackageEntity($id=''){
		$data=array();
		$data['parentList']=$this->productmodel->getPackageList();
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['package_id']=$this->input->post('inputPackage');
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['type']=$this->input->post('inputType');
			$result = $this->productmodel->savePackageEntity($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Package entity added successfully !!');
				redirect(base_url('admin/list-package-entity'));
			}
			
		}
		else{
			$this->template->load('adminTemplate','admin/package/package-entity/add',$data);
		}
	}
	public function updatePackageEntity($id){
		$data=array();
		$data['parentList']=$this->productmodel->getPackageList();
		$data['package_entity']=$this->productmodel->getPackageEntityById($id);
		//pre($data['package_entity'],1);
		if($this->input->post('edit')){
			$dataSave['package_id']=$this->input->post('inputPackage');
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['type']=$this->input->post('inputType');
			$result = $this->productmodel->updatePackageEntity($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Package entity updated successfully !!');
				redirect(base_url('admin/list-package-entity'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/package/package-entity/edit',$data);
		}
	}
	public function change_package_entity_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->productmodel->change_package_entity_status($id,$data);
		echo '1';
	}
	public function deletePackageEntity($id){
		$result = $this->productmodel->deletePackageEntity($id);
		if($result){
			$this->session->set_flashdata('msg','Package Entity deleted successfully !!');
			redirect(base_url('admin/list-package-entity'));
		}
	}
	public function delete_or_ac_inac_multi_package_entity(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->productmodel->deletePackageEntity($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->productmodel->getPackageEntityById($id);
				$data['is_active']='1';
				$result = $this->productmodel->change_package_entity_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->productmodel->getPackageEntityById($id);
				$data['is_active']='0';
				$result = $this->productmodel->change_package_entity_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/********** P A C K A G E   E N T I T Y   V A L U E *******/

	public function packageEntityValueList(){
		$data = $search_key = array();
		$search_key['package_entity_id'] = $this->input->get('package_entity_id');
		$data['packageEntityList']=$this->productmodel->getPackageEntityList();
		$data['packageEntityValueList']=$this->productmodel->getPackageEntityValueList($search_key);
		//pre($data,1);
		$this->template->load('adminTemplate','admin/package/package-entity-value/list',$data);
	}
	public function addPackageEntityValue($id=''){
		$data=array();
		$data['parentList']=$this->productmodel->getPackageEntityList();
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['package_entity_id']=$this->input->post('inputPackageEntity');
			$dataSave['value']=$this->input->post('inputValue');
			$result = $this->productmodel->savePackageEntityValue($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Package entity value added successfully !!');
				redirect(base_url('admin/list-package-entity-value'));
			}
			
		}
		else{
			$this->template->load('adminTemplate','admin/package/package-entity-value/add',$data);
		}
	}
	public function updatePackageEntityValue($id){
		$data=array();
		$data['parentList']=$this->productmodel->getPackageEntityList();
		$data['package_entity_value']=$this->productmodel->getPackageEntityValueById($id);
		//pre($data['package_entity'],1);
		if($this->input->post('edit')){
			$dataSave['package_entity_id']=$this->input->post('inputPackageEntity');
			$dataSave['value']=$this->input->post('inputValue');
			$result = $this->productmodel->updatePackageEntityValue($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Package entity value updated successfully !!');
				redirect(base_url('admin/list-package-entity-value'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/package/package-entity-value/edit',$data);
		}
	}
	public function change_package_entity_value_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->productmodel->change_package_entity_value_status($id,$data);
		echo '1';
	}
	public function deletePackageEntityValue($id){
		$result = $this->productmodel->deletePackageEntityValue($id);
		if($result){
			$this->session->set_flashdata('msg','Package Entity Value deleted successfully !!');
			redirect(base_url('admin/list-package-entity-value'));
		}
	}
	public function delete_or_ac_inac_multi_package_entity_value(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->productmodel->deletePackageEntity($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->productmodel->getPackageEntityById($id);
				$data['is_active']='1';
				$result = $this->productmodel->change_package_entity_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->productmodel->getPackageEntityById($id);
				$data['is_active']='0';
				$result = $this->productmodel->change_package_entity_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/******************* M A S T E R   C O U N T R Y ************/

	public function countryList(){
		$data=array();
		$data['countryList']=$this->locationmodel->getCountryList();
		//pre($data,1);
		$this->template->load('adminTemplate','admin/country/list',$data);
	}
	public function addCountry($id=''){
		$data=array();
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['country_code']=$this->input->post('inputCode');
			$dataSave['country_name']=$this->input->post('inputName');
			$result = $this->locationmodel->saveCountry($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Country added successfully !!');
				redirect(base_url('admin/list-country'));
			}
		}
		else{
			$this->template->load('adminTemplate','admin/country/add',$data);
		}
	}
	public function updateCountry($id){
		$data=array();
		$data['country']=$this->locationmodel->getCountryById($id);
		//pre($data['package'],1);
		if($this->input->post('edit')){
			$dataSave['country_code']=$this->input->post('inputCode');
			$dataSave['country_name']=$this->input->post('inputName');
			$result = $this->locationmodel->updateCountry($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Country updated successfully !!');
				redirect(base_url('admin/list-country'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/country/edit',$data);
		}
	}
	public function change_country_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->locationmodel->change_country_status($id,$data);
		echo '1';
	}
	public function deleteCountry($id){
		$result = $this->locationmodel->deleteCountry($id);
		if($result){
			$this->session->set_flashdata('msg','Country deleted successfully !!');
			redirect(base_url('admin/list-country'));
		}
	}
	public function delete_or_ac_inac_multi_country(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->locationmodel->deleteCountry($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->locationmodel->getCountryById($id);
				$data['is_active']='1';
				$result = $this->locationmodel->change_country_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->locationmodel->getCountryById($id);
				$data['is_active']='0';
				$result = $this->locationmodel->change_country_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/******************* M A S T E R   L O C A T I O N ************/

	public function locationList(){
		$data=array();
		$data['locationList']=$this->locationmodel->getLocationList();
		//pre($data,1);
		$this->template->load('adminTemplate','admin/location/list',$data);
	}
	public function addLocation($id=''){
		$data=array();
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['latitude']=$this->input->post('inputLatitude');
			$dataSave['longitude']=$this->input->post('inputLongitude');
			$result = $this->locationmodel->saveLocation($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Location added successfully !!');
				redirect(base_url('admin/list-location'));
			}
		}
		else{
			$this->template->load('adminTemplate','admin/location/add',$data);
		}
	}
	public function updateLocation($id){
		$data=array();
		$data['location']=$this->locationmodel->getLocationById($id);
		//pre($data['package'],1);
		if($this->input->post('edit')){
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['latitude']=$this->input->post('inputLatitude');
			$dataSave['longitude']=$this->input->post('inputLongitude');
			$result = $this->locationmodel->updateLocation($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Location updated successfully !!');
				redirect(base_url('admin/list-location'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/location/edit',$data);
		}
	}
	public function change_location_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->locationmodel->change_location_status($id,$data);
		echo '1';
	}
	public function deleteLocation($id){
		$result = $this->locationmodel->deleteLocation($id);
		if($result){
			$this->session->set_flashdata('msg','Location deleted successfully !!');
			redirect(base_url('admin/list-location'));
		}
	}
	public function delete_or_ac_inac_multi_location(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->locationmodel->deleteLocation($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->locationmodel->getLocationById($id);
				$data['is_active']='1';
				$result = $this->locationmodel->change_location_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->locationmodel->getLocationById($id);
				$data['is_active']='0';
				$result = $this->locationmodel->change_location_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/******************* M A S T E R   S T A T E ************/

	public function stateList(){
		$data=array();
		$data['stateList']=$this->locationmodel->getStateList();
		//pre($data,1);
		$this->template->load('adminTemplate','admin/state/list',$data);
	}
	public function addState($id=''){
		$data=array();
		$data['countryList']=$this->locationmodel->getCountryList();
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['state_name']=$this->input->post('inputName');
			$dataSave['state_code']=$this->input->post('inputCode');
			$dataSave['country_id']=$this->input->post('inputCountry');
			$result = $this->locationmodel->saveState($dataSave);
			if($result){
				$this->session->set_flashdata('msg','State added successfully !!');
				redirect(base_url('admin/list-state'));
			}
		}
		else{
			$this->template->load('adminTemplate','admin/state/add',$data);
		}
	}
	public function updateState($id){
		$data=array();
		$data['countryList']=$this->locationmodel->getCountryList();
		$data['state']=$this->locationmodel->getStateById($id);
		//pre($data['state'],1);
		if($this->input->post('edit')){
			$dataSave['state_name']=$this->input->post('inputName');
			$dataSave['state_code']=$this->input->post('inputCode');
			$dataSave['country_id']=$this->input->post('inputCountry');
			$result = $this->locationmodel->updateState($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','State updated successfully !!');
				redirect(base_url('admin/list-state'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/state/edit',$data);
		}
	}
	public function change_state_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->locationmodel->change_state_status($id,$data);
		echo '1';
	}
	public function deleteState($id){
		$result = $this->locationmodel->deleteState($id);
		if($result){
			$this->session->set_flashdata('msg','State deleted successfully !!');
			redirect(base_url('admin/list-state'));
		}
	}
	public function delete_or_ac_inac_multi_state(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->locationmodel->deleteState($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->locationmodel->getStateById($id);
				$data['is_active']='1';
				$result = $this->locationmodel->change_state_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->locationmodel->getStateById($id);
				$data['is_active']='0';
				$result = $this->locationmodel->change_state_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/********************* C O M M O N *************************/
	function _create_thumbnail($filename,$type){
        $config['image_library'] = 'gd2';
        $uploadrootfolder = 'uploads/';
        if($type == 'category'){
        	$config['source_image'] = $uploadrootfolder.'service_cat_images/image_large/'.$filename;
        	$config['width'] = 120;
        	$config['height'] = 120;
        	$config['new_image']=$uploadrootfolder.'service_cat_images/image_small/';
        }
        if($type == 'service'){
        	$config['source_image'] = $uploadrootfolder.'service_images/image_large/'.$filename;
        	$config['width'] = 120;
        	$config['height'] = 120;
        	$config['new_image']=$uploadrootfolder.'service_images/image_small/';
        }
        if($type == 'package'){
        	$config['source_image'] = $uploadrootfolder.'package_images/image_large/'.$filename;
        	$config['width'] = 120;
        	$config['height'] = 120;
        	$config['new_image']=$uploadrootfolder.'package_images/image_small/';
        }
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->load->library('image_lib', $config);
        if($this->image_lib->resize()) return true;
	}
	public function _delete_image($type,$id){
		//pre($type,1);
		$this->load->helper('file');
		$sImage = $lImage = '';
		if($type == 'category'){
			$serviceCategory=$this->servicemodel->getServiceCategoryById($id);
			//pre($post,1);
			if(!empty($serviceCategory['image_large'])){
				if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.24.208")
				{
					
					$sImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/uploads/'.$serviceCategory['image_small'];
					$lImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/uploads/'.$serviceCategory['image_large'];
				}
				else
				{
					$sImage=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$serviceCategory['image_small'];
					$lImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/'.$serviceCategory['image_large'];
				}
			}
		}
		if($type == 'service'){
			$service=$this->servicemodel->getServiceById($id);
			//pre($service,1);
			if(!empty($service['image_large'])){
				if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.24.208")
				{
					
					$sImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/uploads/'.$service['image_small'];
					$lImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/uploads/'.$service['image_large'];
				}
				else
				{
					$sImage=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$service['image_small'];
					$lImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/'.$service['image_large'];
				}
			}
		}
		if($type == 'package'){
			$package=$this->productmodel->getPackageById($id);
			//pre($service,1);
			if(!empty($package['image_large'])){
				if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.24.208")
				{
					
					$sImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/uploads/'.$package['image_small'];
					$lImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/uploads/'.$package['image_large'];
				}
				else
				{
					$sImage=$_SERVER['DOCUMENT_ROOT'].'/uploads/'.$package['image_small'];
					$lImage=$_SERVER['DOCUMENT_ROOT'].'/turantam/'.$package['image_large'];
				}
			}
		}
		unlink($lImage);
		unlink($sImage);
	}

	/******************* O R D E R S ************/

	public function orderList(){
		$data = $search_key = array();
		$search_key['customer_id'] = $this->input->get('customer_id');
		$search_key['order_status'] = $this->input->get('order_status');
		$search_key['payment_type'] = $this->input->get('payment_type');
		$search_key['order_no'] = $this->input->get('order_no');
		$search_key['txn_id'] = $this->input->get('txn_id');
		$search_key['paid_status'] = $this->input->get('paid_status');

		$data['customer']=$this->usermodel->getUserList('customer');
		$data['orderList']=$this->ordermodel->getOrderList('',$search_key);
		//pre($data,1);
		$this->template->load('adminTemplate','admin/order/list',$data);
	}
	// public function addState($id=''){
	// 	$data=array();
	// 	if($this->input->post('add') && $this->input->post('add')==1){
	// 		$dataSave['name']=$this->input->post('inputName');
	// 		$dataSave['latitude']=$this->input->post('inputLatitude');
	// 		$dataSave['longitude']=$this->input->post('inputLongitude');
	// 		$result = $this->locationmodel->saveLocation($dataSave);
	// 		if($result){
	// 			$this->session->set_flashdata('msg','Location added successfully !!');
	// 			redirect(base_url('admin/list-location'));
	// 		}
	// 	}
	// 	else{
	// 		$this->template->load('adminTemplate','admin/location/add',$data);
	// 	}
	// }
	public function updateOrder($id){
		$data=array();
		$data['order']=$this->ordermodel->getOrderById($id);
		$data['customer']=$this->usermodel->getUserList('customer');
		$data['customer_address']=$this->ordermodel->getAddressList();
		//pre($data['customer_address'],1);
		if($this->input->post('edit')){

			$dataSave['is_paid']=$this->input->post('inputIsPaid');
			$dataSave['date_created']=$this->input->post('inputOrderDate');
			$dataSave['txn_id']=$this->input->post('inputTxnId');
			$dataSave['total_price']=$this->input->post('inputTotalPrice');
			$dataSave['checksumhash']=$this->input->post('inputChecksumhash');
			$dataSave['address_id']=$this->input->post('inputAdddress');
			$dataSave['customer_id']=$this->input->post('inputCustomer');
			$dataSave['payment_type']=$this->input->post('inputPaymentType');
			$dataSave['bank_txn_id']=$this->input->post('inputBankTxnId');
			$dataSave['paytm_response']=$this->input->post('inputPaytmRes');
			$dataSave['txn_status']=$this->input->post('inputPaytmTxnStatus');
			$dataSave['status']=$this->input->post('inputOrderStatus');
			//pre($dataSave,1);
			$result = $this->ordermodel->updateOrder($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Order updated successfully !!');
				redirect(base_url('admin/list-order'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/order/edit',$data);
		}
	}
	// public function change_order_status($id){
	// 	$data['is_active'] = $this->input->post('is_active');
	// 	$return = $this->locationmodel->change_state_status($id,$data);
	// 	echo '1';
	// }
	public function deleteOrder($id){
		$result = $this->ordermodel->deleteOrder($id);
		if($result){
			$this->session->set_flashdata('msg','Order deleted successfully !!');
			redirect(base_url('admin/list-order'));
		}
	}
	public function delete_or_ac_inac_multi_order(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->ordermodel->deleteOrder($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="pending"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getOrderById($id);
				$data['status']='0';
				$result = $this->ordermodel->change_order_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="completed"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getOrderById($id);
				$data['status']='1';
				$result = $this->ordermodel->change_order_status($id,$data);
			}
			
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="cancelled"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getOrderById($id);
				$data['status']='2';
				$result = $this->ordermodel->change_order_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	public function updateOrderByPaytm(){
		$data = [];
		//pre($this->input->post(),1);
		if($this->input->post('STATUS') == 'TXN_SUCCESS')
		{
			$data['status'] = '1';
			$data['is_paid'] = '1';
		}else if($this->input->post('STATUS') == 'TXN_FAILURE'){
			$data['status'] = '2';
			$data['is_paid'] = '0';
		}else{
			$data['status'] = '0';
			$data['is_paid'] = '0';
		}
		$data['order_no'] = $this->input->post('ORDERID');
		$data['txn_id'] = $this->input->post('TXNID');
		$data['txn_status'] = $this->input->post('STATUS');
		$data['paytm_response'] = json_encode($this->input->post());
		$data['bank_txn_id'] = $this->input->post('BANKTXNID');
		//pre($result,1);
		$result = $this->ordermodel->updateOrderByOrderNo($data);
		if($result)
			redirect('/#/ordersuccess/'.$data['order_no']);
	}

	/******************* O R D E R    D E T A I L S ************/

	public function orderDetailsList(){
		$data=array();
		$search_key['package_id'] = $this->input->get('package_id');
		$search_key['order_no'] = $this->input->get('order_no');
		$data['packageList']=$this->productmodel->getPackageList();
		$data['orderDetailsList']=$this->ordermodel->getOrderDetailsList($search_key);
		//pre($data,1);
		$this->template->load('adminTemplate','admin/order-details/list',$data);
	}
	public function addOrderDetails($id=''){
		$data=array();
		$data['orderList']=$this->ordermodel->getOrderList();
		$data['packageList']=$this->productmodel->getPackageList();
		//pre($data['packageList'],1);
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['package_id']=$this->input->post('inputPackage');
			$dataSave['order_id']=$this->input->post('inputOrderNO');
			$dataSave['quantity']=$this->input->post('inputQuantity');
			$dataSave['unit_price']=$this->input->post('inputUnitPrice');
			$dataSave['IGST']=$this->input->post('inputIGST');
			$dataSave['CGST']=$this->input->post('inputCGST');
			$dataSave['GST']=$this->input->post('inputGST');
			$dataSave['total_cost']=($this->input->post('inputQuantity') * $this->input->post('inputUnitPrice'));
			$result = $this->ordermodel->saveOrderDetails($dataSave);
			if($result){
				$this->session->set_flashdata('msg','Order Details added successfully !!');
				redirect(base_url('admin/list-order-details'));
			}
		}
		else{
			$this->template->load('adminTemplate','admin/order-details/add',$data);
		}
	}
	public function updateOrderDetails($id){
		$data=array();
		$data['orderList']=$this->ordermodel->getOrderList();
		$data['packageList']=$this->productmodel->getPackageList();
		$data['order_details'] = $this->ordermodel->getOrderDetailsById($id);
		//pre($data['order_details'],1);
		if($this->input->post('edit')){
			$dataSave['package_id']=$this->input->post('inputPackage');
			$dataSave['order_id']=$this->input->post('inputOrderNO');
			$dataSave['quantity']=$this->input->post('inputQuantity');
			$dataSave['unit_price']=$this->input->post('inputUnitPrice');
			$dataSave['IGST']=$this->input->post('inputIGST');
			$dataSave['CGST']=$this->input->post('inputCGST');
			$dataSave['GST']=$this->input->post('inputGST');
			$dataSave['total_cost']=($this->input->post('inputQuantity') * $this->input->post('inputUnitPrice'));
			$result = $this->ordermodel->updateOrderDetails($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Order Details updated successfully !!');
				redirect(base_url('admin/list-order-details'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/order-details/edit',$data);
		}
	}
	public function change_orderdetails_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->ordermodel->change_orderdetails_status($id,$data);
		echo '1';
	}
	public function deleteOrderDetails($id){
		$result = $this->ordermodel->deleteOrderDetails($id);
		if($result){
			$this->session->set_flashdata('msg','Order details deleted successfully !!');
			redirect(base_url('admin/list-order-details'));
		}
	}
	public function delete_or_ac_inac_multi_orderdetails(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->ordermodel->deleteOrderDetails($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getOrderDetailsById($id);
				$data['is_active']='1';
				$result = $this->ordermodel->change_orderdetails_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getOrderDetailsById($id);
				$data['is_active']='0';
				$result = $this->ordermodel->change_orderdetails_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/************** C U S T O M E R  A D D R E S S ************/

	public function customerAddressList(){
		$data=array();
		$data['customerAddressList']=$this->ordermodel->getAddressList();
		//pre($data,1);
		$this->template->load('adminTemplate','admin/customer-address/list',$data);
	}
	public function addCustomerAddress($id=''){
		$data=array();
		$data['stateList']=$this->locationmodel->getStateList();
		$data['customerList']=$this->usermodel->getUserList('customer');
		//pre($data['packageList'],1);
		if($this->input->post('add') && $this->input->post('add')==1){
			$dataSave['state_id']=$this->input->post('inputState');
			$dataSave['customer_id']=$this->input->post('inputCustomer');
			$dataSave['address']=$this->input->post('inputAddress');
			$dataSave['pincode']=$this->input->post('inputPincode');
			$dataSave['type']=$this->input->post('inputType');
			$result = $this->ordermodel->saveCustomerAddress('',$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Customer address added successfully !!');
				redirect(base_url('admin/list-customer-address'));
			}
		}
		else{
			$this->template->load('adminTemplate','admin/customer-address/add',$data);
		}
	}
	public function updateCustomerAddress($id){
		$data=array();
		$data['stateList']=$this->locationmodel->getStateList();
		$data['customerList']=$this->usermodel->getUserList('customer');
		$data['customer_address'] = $this->ordermodel->getAddressByID($id);
		//pre($data['order_details'],1);
		if($this->input->post('edit')){
			$dataSave['state_id']=$this->input->post('inputState');
			$dataSave['customer_id']=$this->input->post('inputCustomer');
			$dataSave['address']=$this->input->post('inputAddress');
			$dataSave['pincode']=$this->input->post('inputPincode');
			$dataSave['type']=$this->input->post('inputType');
			$result = $this->ordermodel->updateCustomerAddress($id,$dataSave);
			if($result){
				$this->session->set_flashdata('msg','Customer Address updated successfully !!');
				redirect(base_url('admin/list-customer-address'));
			}
		}
		else{

			$this->template->load('adminTemplate','admin/customer-address/edit',$data);
		}
	}
	public function change_customeraddress_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->ordermodel->change_customeraddress_status($id,$data);
		echo '1';
	}
	public function deleteCustomerAddress($id){
		$result = $this->ordermodel->deleteOrderDetails($id);
		if($result){
			$this->session->set_flashdata('msg','Order details deleted successfully !!');
			redirect(base_url('admin/list-order-details'));
		}
	}
	public function delete_or_ac_inac_multi_customeraddress(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->ordermodel->deleteCustomerAddress($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getAddressByID($id);
				$data['is_active']='1';
				$result = $this->ordermodel->change_customeraddress_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->ordermodel->getAddressByID($id);
				$data['is_active']='0';
				$result = $this->ordermodel->change_customeraddress_status($id,$data);
			}
			
		}
		if($result) echo true;
	}
	
	function search()
    {
        // get search string
        $search = ($this->input->post("book_name"))? $this->input->post("book_name") : "NIL";

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("pagination/search/$search");
        $config['total_rows'] = $this->pagination_model->get_books_count($search);
        $config['per_page'] = "5";
        $config["uri_segment"] = 4;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        // get books list
        $data['booklist'] = $this->pagination_model->get_books($config['per_page'], $data['page'], $search);

        $data['pagination'] = $this->pagination->create_links();

        //Load view
        $this->load->view('pagination_view',$data);
    }
	
	
	
	public function addOtherImages($id)
	{
		 /** Images Upload **/
		$data = [];
		$data['post']=$this->blogmodel->getBlogById($id);
		//pre($data,1);
		if($this->input->post('addImages'))
		{
			// File upload configuration
			$config = [];
			$uploadPath = 'uploads/blog_images/other_images/';
			$config['upload_path'] = $uploadPath;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = '0';
			$config['overwrite']     = FALSE;
			$this->load->library('upload', $config);

			if(!empty($_FILES['other_images']['name']))
        	{
        		//pre($_FILES['other_images']['name'],1);
				$filesCount = count($_FILES['other_images']['name']);
				
				for($i = 0; $i < $filesCount; $i++)
				{
	                $_FILES['other_image']['name']     = time().$_FILES['other_images']['name'][$i];
	                $_FILES['other_image']['type']     = $_FILES['other_images']['type'][$i];
	                $_FILES['other_image']['tmp_name'] = $_FILES['other_images']['tmp_name'][$i];
	                $_FILES['other_image']['error']     = $_FILES['other_images']['error'][$i];
	                $_FILES['other_image']['size']     = $_FILES['other_images']['size'][$i];

	                // Load and initialize upload library
	                $this->upload->initialize($config);
	                // Upload file to server
	                if($this->upload->do_upload('other_image')){
	                    // Uploaded file data
	                    $fileData = $this->upload->data();
	                    $uploadData[] = $fileData['file_name'];
	        
	                }else{
	                	pre($this->upload->display_errors(),1);
	                }
	        	}
		            
		            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
		            $uploadData = json_encode($uploadData);
					//pre($uploadData,1);
					if(!empty($uploadData)){
						$datag['other_images'] = $uploadData;
						$result = $this->blogmodel->addOtherImage($id, $datag);
						if($result)
							redirect('admin/blog-list');
					}
				
				else{
					$this->session->set_flashdata('error','You have exceded the  number of gallery images');
					redirect('admin/add-post-other-images/'.$id);
				}
			}
			
		}
		else 
			$this->template->load('adminTemplate','admin/addpostotherimages',$data);
	}

	public function addVideoLinks($id)
	{

		$data = [];
		$data['post']=$this->blogmodel->getBlogById($id);
		//pre($this->input->post());
		if($this->input->post('addVideoLinks'))
		{
			//pre($this->input->post('field_name'),1);
			$links_data = [];
			
			
			$field_name_1 = (!empty($this->input->post('field_name'))? count($this->input->post('field_name')):'');
			//pre($field_name_1,1);
			
			for($i=0;$i<$field_name_1;$i++){
				if($this->input->post('field_name')[$i]!='')
					$links_data[] = trim($this->input->post('field_name')[$i]);
			}
			//pre($links_data,1);
			$pdata['video_links'] = json_encode($links_data);
			
			$result = $this->blogmodel->addVideoLinks($id,$pdata);
			if($result)
				redirect('admin/blog-list/');
		}
		else 
			$this->template->load('adminTemplate','admin/addpostvideolinks',$data);
	}
	// public function blogList(){
	// 	$data=array();

	// 	/* Pagination */
	// 	$config = array();
	// 	$limit_per_page = 5;
	// 	$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
	// 	$config["base_url"] = base_url().$this->uri->segment(1)."/".$this->uri->segment(2)."/";
	// 	$total_row =  $this->blogmodel->getBlogListCount();
	// 	$config["total_rows"] = $total_row;
	// 	$config["per_page"] =  $limit_per_page;
	// 	$config['use_page_numbers'] = TRUE;
	// 	$config['reuse_query_string'] = TRUE;
	// 	$config['num_links'] = $total_row;
	// 	$config['full_tag_open'] = '<div class="pagination">';
 //        $config['full_tag_close'] = '</div>';
         
 //        $config['first_link'] = 'First Page';
 //        $config['first_tag_open'] = '<span class="firstlink">';
 //        $config['first_tag_close'] = '</span>';
         
 //        $config['last_link'] = 'Last Page';
 //        $config['last_tag_open'] = '<span class="lastlink">';
 //        $config['last_tag_close'] = '</span>';
         
 //        $config['next_link'] = 'Next Page';
 //        $config['next_tag_open'] = '<span class="nextlink">';
 //        $config['next_tag_close'] = '</span>';

 //        $config['prev_link'] = 'Prev Page';
 //        $config['prev_tag_open'] = '<span class="prevlink">';
 //        $config['prev_tag_close'] = '</span>';

 //        $config['cur_tag_open'] = '<span class="curlink">';
 //        $config['cur_tag_close'] = '</span>';

 //        $config['num_tag_open'] = '<span class="numlink">';
 //        $config['num_tag_close'] = '</span>';
	// 	// To initialize "$config" array and set to pagination library.
	// 	$this->pagination->initialize($config);
	// 	// Create link.
	// 	//$str_links = $this->pagination->create_links();
	// 	$data["links"] = $this->pagination->create_links();
	// 	$data['blogList']=$this->blogmodel->getBlogList($page*$limit_per_page,$limit_per_page);
	// 	//pre($data,1);
	// 	$this->template->load('adminTemplate','admin/bloglist',$data);
	// }
}