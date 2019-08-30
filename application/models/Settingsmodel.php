<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settingsmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	public function getGallery(){
		$this->db->where('is_deleted','0');
		$this->db->order_by('date_created','DESC');
		$res = $this->db->get('gallery_settings');
		return $res->result_array();
	}
	public function getGalleryById($id){
		$this->db->select('*');
		$this->db->from('gallery_settings');
		$this->db->where('gallery_settings.is_deleted','0');
		$this->db->where('gallery_settings.id',$id);
		$res=$this->db->get();
		return $res->row_array();
	}	
	public function saveGallery($data){
		return $this->db->insert('gallery_settings',$data);
	}
	public function updateGallery($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('gallery_settings',$data);
	}
	public function change_gallery_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('gallery_settings',$data);
		return $result;
	}
	public function deleteGallery($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('gallery_settings',$data);
	}


	/******************** M A I L   C O N F I G  ********************/

	public function get_or_update_mail_config(){
    	
    	$data = [
    		'settings_k' => 'mail',
    		'settings_v' => json_encode($this->input->post()),
    	];
    	//pre($data,1);
    	if(!empty($this->input->post()))
    	{
    		$this->db->where('settings_k','mail');
    		$result = $this->db->get('settings');
    		if($result->num_rows() > 0) {
    			$this->db->update('settings',$data);
    			$result = $this->db->get('settings');
    		}
    		else 
    		{
    			$this->db->insert('settings',$data);
    			$result = $this->db->get('settings');
    		}
    		return $result->row_array();

    	}
    	else
    	{
    		$this->db->where('settings_k','mail');
    		$result = $this->db->get('settings');
    		return $result->row_array();
    	}	
	}
	public function get_mail_config(){
        $this->db->where('settings_k','mail');
        $result = $this->db->get('settings');
        return $result->row_array();
    }
    public function getTemplate(){
        $this->db->where('is_deleted','0');
        $sql = $this->db->get('mail_templates');
        return $sql->result_array();
    }
    public function saveTemplate($id=''){
        if($id!=''){
            $this->db->where('id',$id);
            return $this->db->update('mail_templates',$this->input->post());
        }
        else
            return $this->db->insert('mail_templates',$this->input->post());
    }
    public function getTemplateById($id){
        $this->db->where('is_deleted','0');
        $this->db->where('id',$id);
        $sql = $this->db->get('mail_templates');
        return $sql->row_array();
    }
    public function get_templates_by_code($code){
        $this->db->where('is_deleted','0');
        $this->db->where('is_active','1');
        $this->db->where('template_code',$code);
        $sql = $this->db->get('mail_templates');
        return $sql->row_array();
    }
    public function change_template_status($id,$data){
        $this->db->where('id',$id);
		$result = $this->db->update('mail_templates',$data);
		return $result;
    }
    public function deleteTemplate($id){
        $data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('mail_templates',$data);
    }
}