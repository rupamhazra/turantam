<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settingsmanager extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Settingsmodel','settingsmodel');
	}
	function galleryList(){
		$data = [];
		$data['galleryImageList'] = $this->settingsmodel->getGallery();
		$this->template->load('adminTemplate','admin/gallery/list',$data);
	}
	function addGallery(){
		$data = [];
		if($this->input->post('add')){
			$dataSave['name'] = $this->input->post('inputName');
			$lPicture = '';
			$sPicture='';
			if(!empty($_FILES['inputImage']['name'])){
                $config['upload_path'] = 'uploads/gallery_images/image_large';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = "large".time().$_FILES['inputImage']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
    
                if($this->upload->do_upload('inputImage')){
                    $uploadData = $this->upload->data();
                    $lPicture = 'gallery_images/image_large/'.$config['file_name'];
					$r=$this->_create_thumbnail($uploadData['file_name'],'gallery');
					if($r){
						$smPicture=$uploadData['raw_name'];
                		$file=$uploadData['file_ext'];
                		$sPicture = 'gallery_images/image_small/'.$smPicture.'_thumb'.$file;
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
	        $this->settingsmodel->saveGallery($dataSave);
	        redirect(base_url('admin/list-gallery'));
		}
		else{
			$this->template->load('adminTemplate','admin/gallery/add',$data);
		}
	}
	function updateGallery($id){
		$data = [];
		$data['gallery']=$this->settingsmodel->getGalleryById($id);
		if($this->input->post('edit')){
			$dataSave['name'] = $this->input->post('inputName');
			if(!empty($_FILES['inputImage']['name'])){
	            $config['upload_path'] = 'uploads/gallery_images/image_large';
	            $config['allowed_types'] = 'jpg|jpeg|png|gif';
	            $config['file_name'] = time().$_FILES['inputImage']['name'];
	            //Load upload library and initialize configuration
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('inputImage')){
	                $uploadData = $this->upload->data();
	                $lPicture = 'gallery_images/image_large/'.$config['file_name'];
	                $r=$this->_create_thumbnail($uploadData['file_name'],'gallery');
					if($r)
					{
						$smPicture=$uploadData['raw_name'];
	            		$file=$uploadData['file_ext'];
	            		$sPicture = 'gallery_images/image_small/'.$smPicture.'_thumb'.$file;
					}
	            }
				else{
					 $error = array('error' => $this->upload->display_errors());
	                 $lPicture = '';
	            }
	            $dataSave['image_large']=$lPicture;
	            $dataSave['image_small']= $sPicture;
	            //$this->_delete_image('category',$id);
        	}
	        $result = $this->settingsmodel->updateGallery($id,$dataSave);
	        if($result){
			$this->session->set_flashdata('msg','Gallery Image Updated successfully !!');
			redirect(base_url('admin/list-gallery'));
		} 
		}
		else{
			$this->template->load('adminTemplate','admin/gallery/edit',$data);
		}
	}
	public function change_gallery_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->settingsmodel->change_gallery_status($id,$data);
		echo '1';
	}
	public function deleteGallery($id){
		$result = $this->settingsmodel->deleteGallery($id);
		if($result){
			$this->session->set_flashdata('msg','Gallery Image deleted successfully !!');
			redirect(base_url('admin/list-gallery'));
		}
	}
	public function delete_or_ac_inac_multi_gallery(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->settingsmodel->deleteGallery($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->settingsmodel->getGalleryById($id);
				$data['is_active']='1';
				$result = $this->settingsmodel->change_gallery_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->settingsmodel->getGalleryById($id);
				$data['is_active']='0';
				$result = $this->settingsmodel->change_gallery_status($id,$data);
			}
			
		}
		if($result) echo true;
	}

	/********************* C O M M O N *************************/
	function _create_thumbnail($filename,$type){
        $config['image_library'] = 'gd2';
        $uploadrootfolder = 'uploads/';
        if($type == 'gallery'){
        	$config['source_image'] = $uploadrootfolder.'gallery_images/image_large/'.$filename;
        	$config['width'] = 120;
        	$config['height'] = 120;
        	$config['new_image']=$uploadrootfolder.'gallery_images/image_small/';
        }
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->load->library('image_lib', $config);
        if($this->image_lib->resize()) return true;
	}

	/********************* M A I L *************************/
	public function mail()
	{
		$data=array();
		$data['config']=$this->settingsmodel->get_or_update_mail_config();
		//pre($data['config'],1);
		$this->template->load('adminTemplate','admin/mail/mailconfig',$data);
	}

	/***************** M A I L  T E M P L A T E S ***************/
	public function templatesList(){
		$data=array();
		$data['templates_list']=$this->settingsmodel->getTemplate();
		$this->template->load('adminTemplate','admin/mail-templates/list',$data);
	}
	public function addTemplate(){
		$data=array();
		if(!empty($this->input->post())){
			$result = $this->settingsmodel->saveTemplate();
			if($result) redirect('admin/list-template');
		}
		else{
		$this->template->load('adminTemplate','admin/mail-templates/add');
		}
	}
	public function updateTemplate($id){
		$data=array();
		$data['template_details']=$this->settingsmodel->getTemplateById($id);
		if(!empty($this->input->post())){
			$result = $this->settingsmodel->saveTemplate($id);
			if($result)
				redirect('admin/list-template');
		}
		else{
			//pre($data,1);
			$this->template->load('adminTemplate','admin/mail-templates/edit',$data);
		}
	}
	public function deleteTemplate($id){
		$result = $this->settingsmodel->deleteTemplate($id);
		if($result){
			$this->session->set_flashdata('msg','Template deleted successfully !!');
			redirect(base_url('admin/list-template'));
		}
	}
	public function changeTemplateStatus($id){
		$data['is_active'] = $this->input->post('is_active');
		$return = $this->settingsmodel->change_template_status($id,$data);
		echo '1';
	}
	public function delete_or_ac_inac_multi_template(){
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				//$this->_delete_image('service',$id);
				$result = $this->settingsmodel->deleteTemplate($id);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->settingsmodel->getTemplateById($id);
				$data['is_active']='1';
				$result = $this->settingsmodel->change_template_status($id,$data);
			}
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->settingsmodel->getTemplateById($id);
				$data['is_active']='0';
				$result = $this->settingsmodel->change_template_status($id,$data);
			}
		}
		if($result) echo true;
	}
}