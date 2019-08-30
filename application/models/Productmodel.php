<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Productmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	public function getServicesByCategory($cat_id_or_slug='',$api_call='',$start='',$limit=''){
		$data = [];
		$this->db->select('service_category.*');
		$this->db->from('service_category');
		$this->db->where('service_category.is_deleted','0');

		if($cat_id_or_slug) {
			$this->db->where('service_category.parent_id',$cat_id_or_slug);
			$this->db->or_where('service_category.parent_slug',$cat_id_or_slug);
		}
		else $this->db->where('service_category.parent_id','0');
		if($api_call == 'yes') $this->db->where('service_category.is_active','1');
		else $this->db->where('service_category.is_active','0');

		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array())
		{
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['name'] = $value['name'];
				$data[$key]['slug'] = $value['slug'];
				$data[$key]['description'] = $value['description'];
				$data[$key]['image_small'] = $value['image_small'];
				$data[$key]['image_large'] = $value['image_large'];

				$this->db->select('services.*');
				$this->db->from('services');
				$this->db->where('services.is_deleted','0');

				if($api_call == 'yes') $this->db->where('services.is_active','1');
				else $this->db->where('services.is_active','0');
				
				$this->db->where('services.category_id',$value['id']);
				$this->db->order_by('services.id','DESC');
				$res=$this->db->get();
				$data[$key]['services'] = $res->result_array();
			}
		}
		//pre($data,1);
		return $data;
	}
	public function listCategory($api_call='',$start='',$limit='',$category_name=''){
		$this->db->select('id,name,description,image_small,image_large,slug');
		$this->db->from('service_category');
		if($category_name!='') {
			$this->db->like('name',$category_name);
		}
		else{
			$this->db->where('parent_id','0');
		}
		if($api_call == 'yes') $this->db->where('is_active','1');
		$this->db->where('is_deleted','0');
		$this->db->limit($limit, $start);
		$this->db->order_by('date_created','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		//pre($res->result_array(),1);
		return $res->result_array();
	}
	public function getCategoryIdByName($cat_name){
		$this->db->select('id,name,description,image_small,image_large,slug');
		$this->db->from('service_category');
		$this->db->where('name',urldecode($cat_name));
		$this->db->where('is_active','1');
		$this->db->where('is_deleted','0');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->row_array();
	}
	public function listSubCategory($api_call='',$rdata)
	{
		$data = [];
		
		if($api_call =='yes'){
			$qry="SELECT `id`, `name`,`slug`, `description`, `image_small`,`image_large`
			FROM `service_category`
			WHERE `slug` 
			IN(SELECT `service_cat_slug` 
			FROM `service_category_locality_map` 
			WHERE `location_id`='".$rdata['location_id']."')
			AND `parent_id` = '".$rdata['parent_id']."'";
		}else{
			$qry="SELECT `id`, `name`,`slug`, `description`, `image_small`,`image_large`
			FROM `service_category`
			WHERE `slug` 
			IN(SELECT `service_cat_slug` 
			FROM `service_category_locality_map` 
			WHERE `location_id`='".$rdata['location_id']."')
			AND `parent_slug` = '".$rdata['parent_id']."'";
		}
		//pre($qry,1);
		$res=$this->db->query($qry);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['name'] = $value['name'];
				$data[$key]['slug'] = $value['slug'];
				$data[$key]['description'] = $value['description'];
				$data[$key]['image_small'] = $value['image_small'];
				$data[$key]['image_large'] = $value['image_large'];

				$this->db->select('services.*');
				$this->db->from('services');
				$this->db->where('services.is_deleted','0');

				if($api_call == 'yes') $this->db->where('services.is_active','1');
				else $this->db->where('services.is_active','0');
				
				$this->db->where('services.category_id',$value['id']);
				$this->db->order_by('services.id','DESC');
				$res1=$this->db->get();
				//echo $this->db->last_query();
				$data[$key]['services'] = $res1->result_array();
			}
			
			//die('123');
		}
	   	return $data;
	}

	public function listServices($start='', $limit='')
	{
		$this->db->select('
			services.id,
			services.name,
			services.slug,
			services.image_small,
			services.image_large,
			services.description,
			service_category.id AS category_id,
			service_category.name AS category_name,
			service_category.slug AS category_slug
		');
		$this->db->from('services');
		$this->db->join('service_category','service_category.id=services.category_id','left');
		$this->db->where('services.is_active','1');
		$this->db->where('services.is_deleted','0');
		$this->db->limit($limit, $start);
		$this->db->order_by('services.date_created','DESC');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function listServicesBySubCatId($data)
	{
		$result = [];
		$this->db->select('services.id,services.name,services.slug,services.image_small,services.image_large,services.description');
		$this->db->from('services');
		$this->db->where('services.category_id',$data['sub_category_id']);
		$this->db->or_where('services.category_slug',$data['sub_category_id']);
		$this->db->where('services.is_active','1');
		$this->db->where('services.is_deleted','0');
		$res=$this->db->get();
		if($res->num_rows()>0){
			foreach ($res->result_array() as $key => $value) {
				$result[$key]['id']= $value['id'];
				$result[$key]['name']= $value['name'];
				$result[$key]['description']= $value['description'];
				$result[$key]['slug']= $value['slug'];
				$result[$key]['image_small']= $value['image_small'];
				$result[$key]['image_large']= $value['image_large'];
				$this->db->select('AVG(package_rating.rating) AS avg_rating');
		   			$this->db->from('package_rating');
		   			$this->db->where('package_rating.service_id',$value['id']);
	   			$res4=$this->db->get();
	   			$result[$key]['avg_rating'] =  round($res4->row_array()['avg_rating']);
			}
		}
		return $result;

	}
	public function listPackagesByServiceId($data)
	{
		$result = [];
		$this->db->select('id,name,slug,image_small,image_large,price,discounted_price');
		$this->db->from('packages');
		$this->db->where('service_id',$data['service_id_or_slug']);
		$this->db->or_where('service_slug',$data['service_id_or_slug']);
		$this->db->where('is_active','1');
		$this->db->where('is_deleted','0');
		$res=$this->db->get();
		#return $res->result_array();
		if($res->num_rows()>0){
			foreach ($res->result_array() as $key => $value) {
				$result[$key]['id'] =  $value['id'];
	   			$result[$key]['name'] =  $value['name'];
	   			$result[$key]['slug'] =  $value['slug'];
	   			$result[$key]['price'] =  $value['price'];
	   			$result[$key]['discounted_price'] =  $value['discounted_price'];
	   			$result[$key]['image_small'] =  $value['image_small'];
	   			$result[$key]['image_large'] =  $value['image_large'];

	   			$this->db->select('AVG(package_rating.rating) AS avg_rating');
	   			$this->db->from('package_rating');
	   			$this->db->where('package_rating.package_id',$value['id']);
	   			$res4=$this->db->get();
	   			$result[$key]['avg_rating'] =  round($res4->row_array()['avg_rating']);
	   			//$result[$key]['date_created'] =  $value['date_created'];
	   			$this->db->select('package_entity.*');
	   			$this->db->from('package_entity');
	   			$this->db->where('package_entity.package_id',$value['id']);
	   			$this->db->where('package_entity.type','short');
	   			$this->db->where('package_entity.is_active','1');
				$this->db->where('package_entity.is_deleted','0');
				$this->db->order_by('package_entity.id', 'desc');
				$res1=$this->db->get();
				if($res1->num_rows()>0){
				foreach ($res1->result_array() as $key_e => $value_e) {
					$result[$key]['package_entity'][$key_e]['id'] = $value_e['id'];
					$result[$key]['package_entity'][$key_e]['name'] = $value_e['name'];
					$result[$key]['package_entity'][$key_e]['type'] = $value_e['type'];
					$result[$key]['package_entity'][$key_e]['date_created'] = $value_e['date_created'];
					$this->db->select('package_entity_value.*');
		   			$this->db->from('package_entity_value');
		   			$this->db->where('package_entity_value.package_entity_id',$value_e['id']);
		   			$this->db->where('package_entity_value.is_active','1');
					$this->db->where('package_entity_value.is_deleted','0');
					$this->db->order_by('package_entity_value.id', 'desc');
					$res2=$this->db->get();
					$result[$key]['package_entity'][$key_e]['package_entity_value'] = $res2->result_array();
				}
			}
			else{
				$result[$key]['package_entity'] = [];
			}

   			}
		}
		return $result;
	}
	public function PackagesDetails($data)
	{
		$result=[];
		$this->db->select('packages.*,s.name AS service_name,sc.name AS service_category_name');
		$this->db->from('packages');
		$this->db->join('services AS s', 's.id = packages.service_id');
		$this->db->join('service_category AS sc', 'sc.id = s.category_id');
		$this->db->where('packages.id',$data['package_id_or_slug']);
		$this->db->or_where('packages.slug',$data['package_id_or_slug']);
		$this->db->where('packages.is_active','1');
		$this->db->where('packages.is_deleted','0');
		$this->db->order_by('packages.id', 'desc');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
   		if($res->row_array()){
   			$pacakge_d = $res->row_array();
   			$result['id'] =  $pacakge_d['id'];
   			$result['name'] =  $pacakge_d['name'];
   			$result['description'] =  $pacakge_d['description'];
   			$result['slug'] =  $pacakge_d['slug'];
   			$result['service_id'] =  $pacakge_d['service_id'];
   			$result['service_name'] =  $pacakge_d['service_name'];
   			$result['service_category_name'] =  $pacakge_d['service_category_name'];
   			$result['price'] =  $pacakge_d['price'];
   			$result['discounted_price'] =  $pacakge_d['discounted_price'];
   			$result['image_small'] =  $pacakge_d['image_small'];
   			$result['image_large'] =  $pacakge_d['image_large'];
   			$result['date_created'] =  $pacakge_d['date_created'];

   			$this->db->select('AVG(package_rating.rating) AS avg_rating');
   			$this->db->from('package_rating');
   			$this->db->where('package_rating.package_id',$pacakge_d['id']);
   			$res4=$this->db->get();
   			$result['avg_rating'] =  round($res4->row_array()['avg_rating']);

   			$this->db->select('package_entity.*');
   			$this->db->from('package_entity');
   			$this->db->where('package_entity.package_id',$pacakge_d['id']);
   			$this->db->where('package_entity.is_active','1');
			$this->db->where('package_entity.is_deleted','0');
			$this->db->order_by('package_entity.id', 'desc');
			$res=$this->db->get();
			//$result['package_entity'] = $res->result_array();
			if($res->result_array()){
				foreach ($res->result_array() as $key_e => $value_e) {
					$result['package_entity'][$key_e]['id'] = $value_e['id'];
					$result['package_entity'][$key_e]['name'] = $value_e['name'];
					$result['package_entity'][$key_e]['type'] = $value_e['type'];
					$result['package_entity'][$key_e]['date_created'] = $value_e['date_created'];
					$this->db->select('package_entity_value.*');
		   			$this->db->from('package_entity_value');
		   			$this->db->where('package_entity_value.package_entity_id',$value_e['id']);
		   			$this->db->where('package_entity_value.is_active','1');
					$this->db->where('package_entity_value.is_deleted','0');
					$this->db->order_by('package_entity_value.id', 'desc');
					$res=$this->db->get();
					$result['package_entity'][$key_e]['package_entity_value'] = $res->result_array();
				}
			}
			else{
				$result['package_entity'] = [];
			}

   		}
		//pre($result);
		return $result;
	}

	/******************* P A C K A G E *****************/

	public function getPackageList($search_key='',$start='', $limit=''){
		$data = [];
		$this->db->select('packages.*,
			services.id AS service_id,
			services.name AS service_name,
			services.slug AS service_slug,
			');
		$this->db->from('packages');
		$this->db->join('services','packages.service_id=services.id');
		if(!empty($search_key)) {
			if(!empty($search_key['service_id'])){
				$this->db->like('services.id',$search_key['service_id']);
			}
			if(!empty($search_key['package_name'])){
				$this->db->like('packages.name',$search_key['package_name']);
			}
		}
		$this->db->where('packages.is_deleted','0');
		$this->db->order_by('packages.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['name'] = $value['name'];
				$data[$key]['is_active'] = $value['is_active'];
				$data[$key]['description'] = $value['description'];
				$data[$key]['slug'] = $value['slug'];
				$data[$key]['price'] = $value['price'];
				$data[$key]['discounted_price'] = $value['discounted_price'];
				$data[$key]['image_small'] = $value['image_small'];
				$data[$key]['image_large'] = $value['image_large'];
				$data[$key]['date_created'] = $value['date_created'];

				$data[$key]['service_id'] = $value['service_id'];
				$data[$key]['service_name'] = $value['service_name'];
				$data[$key]['service_slug'] = $value['service_slug'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function getPackageById($id){
		$data = [];
		$this->db->select('packages.*,
			services.id AS service_id,
			services.name AS service_name,
			services.slug AS service_slug,
			');
		$this->db->from('packages');
		$this->db->join('services','packages.service_id=services.id');
		$this->db->where('packages.is_deleted','0');
		$this->db->where('packages.id', $id);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		//pre($res->row_array(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data['id'] = $value['id'];
				$data['name'] = $value['name'];
				$data['is_active'] = $value['is_active'];
				$data['description'] = $value['description'];
				$data['slug'] = $value['slug'];
				$data['price'] = $value['price'];
				$data['discounted_price'] = $value['discounted_price'];
				$data['image_small'] = $value['image_small'];
				$data['image_large'] = $value['image_large'];
				$data['date_created'] = $value['date_created'];

				$data['service_id'] = $value['service_id'];
				$data['service_name'] = $value['service_name'];
				$data['service_slug'] = $value['service_slug'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function savePackage($data){
		return $this->db->insert('packages',$data);
	}
	public function updatePackage($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('packages',$data);
	}
	public function change_package_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('packages',$data);
		if($result){
			$this->db->where('package_id',$id);
			$this->db->update('package_entity',$data);

			$this->db->select('id');
			$this->db->from('package_entity');
			$this->db->where('is_active',$data['is_active']);
			$this->db->where('package_id',$id);
			$res3 = $this->db->get();
			if($res3->num_rows()>0){
				foreach ($res3->result_array() as $key3 => $value3) {
					$this->db->where('package_entity_id',$value3['id']);
					$this->db->update('package_entity_value',$data);
				}
			}
		}
		return $result;
	}
	public function deletePackage($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$result = $this->db->update('packages',$data);
		if($result){
			$this->db->where('package_id',$id);
			$this->db->update('package_entity',$data);

			$this->db->select('id');
			$this->db->from('package_entity');
			$this->db->where('is_deleted','1');
			$this->db->where('package_id',$id);
			$res3 = $this->db->get();
			if($res3->num_rows()>0){
				foreach ($res3->result_array() as $key3 => $value3) {
					$this->db->where('package_entity_id',$value3['id']);
					$this->db->update('package_entity_value',$data);
				}
			}
		}
		return $result;
	}

	/************* P A C K A G E  E N T I T Y *************/

	public function getPackageEntityList($search_key='',$start='', $limit=''){
		$data = [];
		$this->db->select('package_entity.*,
			packages.id AS package_id,
			packages.name AS package_name,
			packages.slug AS package_slug,
			');
		$this->db->from('package_entity');
		$this->db->join('packages','package_entity.package_id=packages.id');
		if(!empty($search_key)) {
			if(!empty($search_key['package_id'])){
				$this->db->like('packages.id',$search_key['package_id']);
			}
			if(!empty($search_key['package_entity_name'])){
				$this->db->like('package_entity.name',$search_key['package_entity_name']);
			}
		}
		$this->db->where('package_entity.is_deleted','0');
		$this->db->order_by('package_entity.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['name'] = $value['name'];
				$data[$key]['is_active'] = $value['is_active'];
				$data[$key]['type'] = $value['type'];
				$data[$key]['date_created'] = $value['date_created'];
				$data[$key]['package_id'] = $value['package_id'];
				$data[$key]['package_name'] = $value['package_name'];
				$data[$key]['package_slug'] = $value['package_slug'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function getPackageEntityById($id){
		$data = [];
		$this->db->select('package_entity.*,
			packages.id AS package_id,
			packages.name AS package_name,
			packages.slug AS package_slug,
			');
		$this->db->from('package_entity');
		$this->db->join('packages','package_entity.package_id=packages.id');
		$this->db->where('package_entity.is_deleted','0');
		$this->db->where('package_entity.id', $id);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		//pre($res->row_array(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data['id'] = $value['id'];
				$data['name'] = $value['name'];
				$data['is_active'] = $value['is_active'];
				$data['type'] = $value['type'];
				$data['date_created'] = $value['date_created'];
				$data['package_id'] = $value['package_id'];
				$data['package_name'] = $value['package_name'];
				$data['package_slug'] = $value['package_slug'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function savePackageEntity($data){
		return $this->db->insert('package_entity',$data);
	}
	public function updatePackageEntity($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('package_entity',$data);
	}
	public function change_package_entity_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('package_entity',$data);
		if($result){
			$this->db->where('package_entity_id',$id);
			$result = $this->db->update('package_entity_value',$data);
		}
		return $result;
	}
	public function deletePackageEntity($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$result = $this->db->update('package_entity',$data);
		if($result){
			$this->db->where('package_entity_id',$id);
			$result = $this->db->update('package_entity_value',$data);
		}
		return result;
	}

	/******** P A C K A G E   E N T I T Y    V A L U E *******/

	public function getPackageEntityValueList($search_key='',$start='', $limit=''){
		$data = [];
		$this->db->select('package_entity_value.*,
			package_entity.id AS package_entity_id,
			package_entity.name AS package_entity_name,
			package_entity.type AS package_entity_type,
			');
		$this->db->from('package_entity_value');
		$this->db->join('package_entity','package_entity_value.package_entity_id=package_entity.id');
		if(!empty($search_key)) {
			if(!empty($search_key['package_entity_id'])){
				$this->db->like('package_entity.id',$search_key['package_entity_id']);
			}
		}
		$this->db->where('package_entity_value.is_deleted','0');
		$this->db->order_by('package_entity_value.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['value'] = $value['value'];
				$data[$key]['is_active'] = $value['is_active'];
				$data[$key]['date_created'] = $value['date_created'];
				$data[$key]['package_entity_id'] = $value['package_entity_id'];
				$data[$key]['package_entity_name'] = $value['package_entity_name'];
				$data[$key]['package_entity_type'] = $value['package_entity_type'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function getPackageEntityValueById($id){
		$data = [];
		$this->db->select('package_entity_value.*,
			package_entity.id AS package_entity_id,
			package_entity.name AS package_entity_name,
			package_entity.type AS package_entity_type,
			');
		$this->db->from('package_entity_value');
		$this->db->join('package_entity','package_entity_value.package_entity_id=package_entity.id');
		$this->db->where('package_entity_value.is_deleted','0');
		$this->db->where('package_entity_value.id', $id);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		//pre($res->row_array(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data['id'] = $value['id'];
				$data['value'] = $value['value'];
				$data['is_active'] = $value['is_active'];
				$data['date_created'] = $value['date_created'];
				$data['package_entity_id'] = $value['package_entity_id'];
				$data['package_entity_name'] = $value['package_entity_name'];
				$data['package_entity_type'] = $value['package_entity_type'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function savePackageEntityValue($data){
		return $this->db->insert('package_entity_value',$data);
	}
	public function updatePackageEntityValue($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('package_entity_value',$data);
	}
	public function change_package_entity_value_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('package_entity_value',$data);
		return $result;
	}
	public function deletePackageEntityValue($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('package_entity_value',$data);
	}

	public function addPackageRating($data){
		$message = [];
		$this->db->select('service_id');
		$this->db->from('packages');
		$this->db->where('packages.is_deleted','0');
		$this->db->where('packages.id', $data['package_id']);
		$res=$this->db->get();
		$data['service_id'] = $res->row_array()['service_id'];
		$result = $this->db->insert('package_rating',$data);
		$last_insert_id = $this->db->insert_id();
		if($result)
		{
			$this->db->select('
				packages.name AS package_name,
				order.order_no AS order_no,
				services.name AS service_name,
				users.name AS user,
				package_rating.rating AS rating
				');

			$this->db->from('package_rating');
			$this->db->join('packages','packages.id='.$data['package_id']);
			$this->db->join('order','order.id='.$data['order_id']);
			$this->db->join('services','services.id='.$data['service_id']);
			$this->db->join('users','users.id='.$data['user_id']);
			$this->db->where('package_rating.id', $last_insert_id);
			$res=$this->db->get();
			$message['status'] = TRUE;
			$message['message'] = $res->row_array();
			return $message;
		}
	}
}