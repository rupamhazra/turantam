<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Servicemodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
    public function saveServiceCategoryData($data){
    	$location_id = $data['location_id'];
    	unset($data['location_id']);
		$result = $this->db->insert('service_category',$data);	
		$last_insert_id = $this->db->insert_id();
		if($result){
			$this->db->where('service_category_id',$last_insert_id);
			$this->db->delete('service_category_locality_map');
			$data_a = [];
			//pre($location_id,1);
			if(!empty($location_id)){
				foreach ($location_id as $key => $value) {
					$data_a[$key]['location_id'] = $value;
					$data_a[$key]['service_category_id'] = $last_insert_id;
					$data_a[$key]['service_cat_slug'] = $data['slug'];
				}
				$result = $this->db->insert_batch('service_category_locality_map',$data_a);
			}
		}
	}
	public function updateServiceCategoryData($id,$data){
		$location_id = $data['location_id'];
    	unset($data['location_id']);
		$this->db->where('id',$id);
		$result = $this->db->update('service_category',$data);
		if($result){
			$this->db->where('service_category_id',$id);
			$this->db->delete('service_category_locality_map');
			$data_a = [];
			if(!empty($location_id)){
				foreach ($location_id as $key => $value) {
					$data_a[$key]['location_id'] = $value;
					$data_a[$key]['service_category_id'] = $id;
					$data_a[$key]['service_cat_slug'] = $data['slug'];
				}
				$result = $this->db->insert_batch('service_category_locality_map',$data_a);
			}
		}
	}
	public function change_serviceCategory_status($id){
		$data['is_active'] = $this->input->post('is_active');
		$this->db->where('id',$id);
		$result = $this->db->update('service_category',$data);
		if($result){
			$this->db->where('category_id',$id);
			$result = $this->db->update('services',$data);
			if($result){
				$this->db->select('id');
				$this->db->from('services');
				$this->db->where('is_active',$data['is_active']);
				$this->db->where('category_id',$id);
				$res1 = $this->db->get();

				if($res1->num_rows()>0){
					foreach ($res1->result_array() as $key1 => $value1) {
						$this->db->where('service_id',$value1['id']);
						$result = $this->db->update('packages',$data);

						$this->db->select('id');
						$this->db->from('packages');
						$this->db->where('is_active',$data['is_active']);
						$this->db->where('service_id',$value1['id']);
						$res2 = $this->db->get();

						if($res2->num_rows()>0){
							foreach ($res2->result_array() as $key2 => $value2) {
								$this->db->where('package_id',$value2['id']);
								$this->db->update('package_entity',$data);

								$this->db->select('id');
								$this->db->from('package_entity');
								$this->db->where('is_active',$data['is_active']);
								$this->db->where('package_id',$value2['id']);
								$res3 = $this->db->get();
								if($res3->num_rows()>0){
									foreach ($res3->result_array() as $key3 => $value3) {
										$this->db->where('package_entity_id',$value3['id']);
										$this->db->update('package_entity_value',$data);
									}
								}
								
							}
						}
					}
				}
			}
		}
		return $result;
	}
	public function deleteServiceCategory($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$result = $this->db->update('service_category',$data);
		if($result){
			$this->db->where('category_id',$id);
			$result = $this->db->update('services',$data);
			if($result){
				$this->db->select('id');
				$this->db->from('services');
				$this->db->where('is_deleted','1');
				$this->db->where('category_id',$id);
				$res1 = $this->db->get();

				if($res1->num_rows()>0){
					foreach ($res1->result_array() as $key1 => $value1) {
						$this->db->where('service_id',$value1['id']);
						$result = $this->db->update('packages',$data);

						$this->db->select('id');
						$this->db->from('packages');
						$this->db->where('is_deleted','1');
						$this->db->where('service_id',$value1['id']);
						$res2 = $this->db->get();

						if($res2->num_rows()>0){
							foreach ($res2->result_array() as $key2 => $value2) {
								$this->db->where('package_id',$value2['id']);
								$this->db->update('package_entity',$data);

								$this->db->select('id');
								$this->db->from('package_entity');
								$this->db->where('is_deleted','1');
								$this->db->where('package_id',$value2['id']);
								$res3 = $this->db->get();
								if($res3->num_rows()>0){
									foreach ($res3->result_array() as $key3 => $value3) {
										$this->db->where('package_entity_id',$value3['id']);
										$this->db->update('package_entity_value',$data);
									}
								}
								
							}
						}
					}
				}
			}
		}
		return $result;
	}
	public function getServiceListCount(){
		$this->db->select('*');
		$this->db->from('blog_post');
		$this->db->where('blog_post.is_deleted','0');
		$this->db->order_by('blog_post.id', 'desc');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->num_rows();
	}
	public function getServiceList($search_key='',$start='', $limit=''){
		$data = [];
		$this->db->select('services.*,
			service_category.id AS category_id,
			service_category.name AS category_name,
			service_category.slug AS category_slug,
			parent_category.id AS parent_category_id,
			parent_category.name AS parent_category_name,
			parent_category.slug AS parent_category_slug
			');
		$this->db->from('services');
		$this->db->join('service_category','services.category_id=service_category.id','left');
		$this->db->join('service_category AS parent_category', 'service_category.parent_id = parent_category.id','left');
		if(!empty($search_key)) {
			if(!empty($search_key['cat_id'])){
				$this->db->like('service_category.id',$search_key['cat_id']);
			}
			if(!empty($search_key['service_name'])){
				$this->db->like('services.name',$search_key['service_name']);
			}
		}
		$this->db->where('services.is_deleted','0');
		$this->db->order_by('services.id', 'DESC');
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
				$data[$key]['image_small'] = $value['image_small'];
				$data[$key]['image_large'] = $value['image_large'];
				$data[$key]['date_created'] = $value['date_created'];

				$data[$key]['service_category_id'] = $value['category_id'];
				$data[$key]['category_name'] = $value['category_name'];
				$data[$key]['category_slug'] = $value['category_slug'];

				$data[$key]['parent_category_id'] = $value['parent_category_id'];
				$data[$key]['parent_category_name'] = $value['parent_category_name'];
				$data[$key]['parent_category_slug'] = $value['parent_category_slug'];
			}
		}
		//pre($data,1);
		return $data;
	}
	public function saveService($data){
		return $this->db->insert('services',$data);
	}
	public function change_service_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('services',$data);
		if($result){
			$this->db->where('service_id',$id);
			$result = $this->db->update('packages',$data);

			$this->db->select('id');
			$this->db->from('packages');
			$this->db->where('is_active',$data['is_active']);
			$this->db->where('service_id',$id);
			$res2 = $this->db->get();

			if($res2->num_rows()>0){
				foreach ($res2->result_array() as $key2 => $value2) {
					$this->db->where('package_id',$value2['id']);
					$this->db->update('package_entity',$data);

					$this->db->select('id');
					$this->db->from('package_entity');
					$this->db->where('is_active',$data['is_active']);
					$this->db->where('package_id',$value2['id']);
					$res3 = $this->db->get();
					if($res3->num_rows()>0){
						foreach ($res3->result_array() as $key3 => $value3) {
							$this->db->where('package_entity_id',$value3['id']);
							$this->db->update('package_entity_value',$data);
						}
					}
					
				}
			}	
		}
		return $result;
	}
	public function deleteService($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$result = $this->db->update('services',$data);
		if($result){
			$this->db->where('service_id',$id);
			$result = $this->db->update('packages',$data);

			$this->db->select('id');
			$this->db->from('packages');
			$this->db->where('is_deleted','1');
			$this->db->where('service_id',$id);
			$res2 = $this->db->get();

			if($res2->num_rows()>0){
				foreach ($res2->result_array() as $key2 => $value2) {
					$this->db->where('package_id',$value2['id']);
					$this->db->update('package_entity',$data);

					$this->db->select('id');
					$this->db->from('package_entity');
					$this->db->where('is_deleted','1');
					$this->db->where('package_id',$value2['id']);
					$res3 = $this->db->get();
					if($res3->num_rows()>0){
						foreach ($res3->result_array() as $key3 => $value3) {
							$this->db->where('package_entity_id',$value3['id']);
							$this->db->update('package_entity_value',$data);
						}
					}
					
				}
			}	
		}
		return $result;
	}
	public function getServiceById($id,$api_call=''){
		$data = [];
		if($api_call == 'yes'){
			$this->db->select('name');
			$this->db->from('services');
			$this->db->where('services.id',$id);
			$this->db->or_where('services.slug',$id);
			$this->db->where('services.is_deleted','0');
			$res=$this->db->get();
			return $res->row_array();
		}
		else
		{
			$this->db->select('services.*,
				service_category.id AS category_id,
				service_category.name AS category_name,
				service_category.slug AS category_slug,
				parent_category.id AS parent_category_id,
				parent_category.name AS parent_category_name,
				parent_category.slug AS parent_category_slug
				');
			$this->db->from('services');
			$this->db->join('service_category','services.category_id=service_category.id','left');
			$this->db->join('service_category AS parent_category', 'service_category.parent_id = parent_category.id','left');
			$this->db->where('services.id',$id);
			$this->db->where('services.is_deleted','0');
			$res=$this->db->get();
			//pre($this->db->last_query(),1);
			if($res->result_array()){
				foreach ($res->result_array() as $key => $value) {
					$data['id'] = $value['id'];
					$data['name'] = $value['name'];
					$data['is_active'] = $value['is_active'];
					$data['description'] = $value['description'];
					$data['slug'] = $value['slug'];
					$data['image_small'] = $value['image_small'];
					$data['image_large'] = $value['image_large'];
					$data['date_created'] = $value['date_created'];

					$data['category_id'] = $value['category_id'];
					$data['category_name'] = $value['category_name'];
					$data['category_slug'] = $value['category_slug'];

					$data['parent_category_id'] = $value['parent_category_id'];
					$data['parent_category_name'] = $value['parent_category_name'];
					$data['parent_category_slug'] = $value['parent_category_slug'];
				}
			}
			//pre($data,1);
			return $data;
		}
	}
	public function updateService($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('services',$data);
	}
	public function getBlogListCountByCatId($id){
		$this->db->select('blog_post.*,
			users.name as name,
			service_category.id AS category_id,
			service_category.category_name AS category_name,
			service_category.category_url AS category_slug,
			service_category.template_view AS template_view,
			');
		$this->db->from('blog_post');
		//$this->db->join('comments', 'comments.post_id = blog_post.id','left');
		$this->db->join('users', 'users.id = blog_post.user_id');
		$this->db->join('service_category','blog_post.service_category_id=service_category.id','left');
		$this->db->join('service_category AS parent_category', 'service_category.parent_id = parent_category.id','left');
		
		$this->db->where('blog_post.is_deleted','0');
		$this->db->where('blog_post.service_category_id',$id);
		//$this->db->group_by('comments.post_id');
		$this->db->order_by('blog_post.id', 'desc');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->num_rows();
	}
	public function getBlogListByCategory($id,$start='', $limit=''){
		$data = [];
		$this->db->select('blog_post.*,
			users.name as name,
			service_category.id AS category_id,
			service_category.category_name AS category_name,
			service_category.description AS category_description,
			service_category.category_url AS category_slug,
			service_category.template_view AS template_view,
			');
		$this->db->from('blog_post');
		$this->db->join('users', 'users.id = blog_post.user_id','left');
		$this->db->join('service_category','blog_post.service_category_id=service_category.id','left');
		$this->db->join('service_category AS parent_category', 'service_category.parent_id = parent_category.id','left');
		
		$this->db->where('blog_post.is_deleted','0');
		$this->db->where('blog_post.service_category_id',$id);
		$this->db->order_by('blog_post.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['user_id'] = $value['user_id'];
				$data[$key]['blog_title'] = $value['blog_title'];
				$data[$key]['is_active'] = $value['is_active'];
				$data[$key]['blog_excerpt'] = $value['blog_excerpt'];
				$data[$key]['blog_url'] = $value['blog_url'];
				$data[$key]['blog_content'] = $value['blog_content'];
				$data[$key]['blog_large_image'] = $value['blog_large_image'];
				$data[$key]['blog_small_image'] = $value['blog_small_image'];
				$data[$key]['blog_image_alt'] = $value['blog_image_alt'];
				$data[$key]['date_created'] = $value['date_created'];
				$data[$key]['service_category_id'] = $value['service_category_id'];
				$data[$key]['category_name'] = $value['category_name'];
				$data[$key]['category_description'] = $value['category_description'];
				$data[$key]['category_slug'] = $value['category_slug'];
				$data[$key]['apply_button'] = $value['apply_button'];
				$data[$key]['deals_start_datetime'] = $value['deals_start_datetime'];
				$data[$key]['deals_end_datetime'] = $value['deals_end_datetime'];
				//$this->db->select('*');
				$this->db->select(
					'COUNT(CASE WHEN is_approved = "0" THEN 0 END) AS reject,
					COUNT(CASE WHEN is_approved = "1" THEN 1 END) AS approved,
					COUNT(CASE WHEN is_approved = "2" THEN 2 END) AS new
					');
				$this->db->from('comments');
				$this->db->where('post_id',$value['id']);
				$this->db->group_by('post_id');
				$res = $this->db->get();
				$data[$key]['comments'] = $res->row_array();
			}
		}
		
		return $data;
	}
	public function get_blog_by_url($url){
		$this->db->where('blog_url',$url);
		$res=$this->db->get('blog_post');
		return $res->row_array();
	}
	public function getServiceCategoryById($id){
		$result = [];
		$this->db->select('*');
		$this->db->from('service_category');
		$this->db->where('slug',$id);
		$this->db->or_where('id',$id);
		$res=$this->db->get();
		if($res->row_array()){
			$result['id'] = $res->row_array()['id'];
			$result['name'] = $res->row_array()['name'];
			$result['description'] = $res->row_array()['description'];
			$result['image_small'] = $res->row_array()['image_small'];
			$result['image_large'] = $res->row_array()['image_large'];
			$result['slug'] = $res->row_array()['slug'];
			$result['parent_id'] = $res->row_array()['parent_id'];
			$result['parent_slug'] = $res->row_array()['parent_slug'];
			$this->db->select('*');
			$this->db->from('service_category_locality_map');
			$this->db->where('service_category_id',$id);
			$res=$this->db->get();
			//$result['location_id'] = $res->result_array();
			if(!empty($res->result_array())){
				foreach ($res->result_array() as $key => $value) {
					$result['location_id'][$key] = $value['location_id'];
				}
			}else{
				$result['location_id'] = [];
			}
			
		}
		//pre($result,1);
		return $result;
	}
	public function getBlogSubCategoryById($id){
		$this->db->where('id',$id);
		$res=$this->db->get('blog_sub_category');
		return $res->row_array();
	}
	public function get_all_service_category(){
		$this->db->select('service_category.*');
		$this->db->from('service_category');
		$this->db->where('service_category.is_deleted','0');
		$this->db->where('service_category.parent_id','0');
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function get_all_service_sub_category(){
		$this->db->select('service_category.*');
		$this->db->from('service_category');
		$this->db->where('service_category.is_deleted','0');
		$this->db->where('service_category.parent_id!=','0');
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function get_all_service_category_add($id=''){
		$data = [];
		$this->db->select('service_category.*');
		$this->db->from('service_category');
		$this->db->where('service_category.is_deleted','0');
		
		if($id) $this->db->where('service_category.parent_id',$id);
		else $this->db->where('service_category.parent_id','0');
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array())
		{
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['name'] = $value['name'];
				$data[$key]['slug'] = $value['slug'];
				$data[$key]['image_small'] = $value['image_small'];
				$data[$key]['image_large'] = $value['image_large'];
				// $this->db->select('service_category.*');
				// $this->db->from('service_category');
				// $this->db->where('service_category.is_deleted','0');
				// //$this->db->where('service_category.parent_id','0');
				// $this->db->where('service_category.parent_id',$value['id']);
				// $this->db->order_by('service_category.id','DESC');
				// $res=$this->db->get();
				// if($res->result_array()){
				// 	//$data[$key]['sub_category_details'] = $res->result_array();
				// 	foreach ($res->result_array() as $key_s => $value_s) {
				// 		$data[$key]['sub_category_details'][$key_s]['id'] = $value_s['id'];
				// 		$data[$key]['sub_category_details'][$key_s]['name'] = $value_s['name'];
				// 		$data[$key]['sub_category_details'][$key_s]['slug'] = $value_s['slug'];
				// 		$data[$key]['sub_category_details'][$key_s]['image_small'] = $value_s['image_small'];
				// 		$data[$key]['sub_category_details'][$key_s]['image_large'] = $value_s['image_large'];
				// 	}
					
				// }
				
			}
		}
		//pre($data,1);
		return $data;
	}
	public function get_all_service_category_api(){
		$data = [];
		$this->db->select('service_category.*');
		$this->db->from('service_category');
		$this->db->where('service_category.is_deleted','0');
		$this->db->where('service_category.parent_id','0');
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array())
		{
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['category_name'] = $value['category_name'];
				$data[$key]['category_slug'] = $value['category_url'];
				$this->db->select('service_category.*');
				$this->db->from('service_category');
				$this->db->where('service_category.is_deleted','0');
				$this->db->where('service_category.parent_id',$value['id']);
				$this->db->order_by('service_category.id','DESC');
				$res=$this->db->get();
				if($res->result_array()){

					foreach ($res->result_array() as $key_s => $value_s) {
						$data[$key]['sub_category_details'][$key_s]['id'] = $value_s['id'];
						$data[$key]['sub_category_details'][$key_s]['category_name'] = $value_s['category_name'];
						$data[$key]['sub_category_details'][$key_s]['category_slug'] = $value_s['category_url'];

						$this->db->select('service_category.id,service_category.category_name,service_category.category_url AS category_slug,service_category.tags_ids');
						$this->db->from('service_category');
						$this->db->where('service_category.is_deleted','0');
						//$this->db->where('service_category.parent_id','0');
						$this->db->where('service_category.parent_id',$value_s['id']);
						$this->db->order_by('service_category.id','DESC');
						$res=$this->db->get();
						if($res->result_array()){
							$data[$key]['sub_category_details'][$key_s]['sub_sub_category_details'] = $res->result_array();
							foreach ($res->result_array() as $key_s_s => $value_s_s) {
								if($data[$key]['sub_category_details'][$key_s]['sub_sub_category_details'][$key_s_s]['tags_ids']!="")
								{
								$tags_ids = json_decode($value_s_s['tags_ids']);
								unset($data[$key]['sub_category_details'][$key_s]['sub_sub_category_details'][$key_s_s]['tags_ids']);
								//if(in_array(,$tags_ids))
								$this->db->select('*');
								$this->db->from('master_tags');
								$this->db->where_in('master_tags.id',$tags_ids);
								$this->db->where('master_tags.is_deleted','0');
								$res=$this->db->get();
								$data[$key]['sub_category_details'][$key_s]['sub_sub_category_details'][$key_s_s]['tags']=$res->result_array();
								}
								else{
									unset($data[$key]['sub_category_details'][$key_s]['sub_sub_category_details'][$key_s_s]['tags_ids']);
								}
							}
							
						}

					}
				}
				
			}
		}
		//pre($data,1);
		return $data;
	}
	public function get_all_service_parent_id_category(){
		$id = $this->input->post('id');
		$this->db->select('service_category.*');
		$this->db->from('service_category');
		$this->db->where('service_category.is_deleted','0');
		$this->db->where('service_category.parent_id',$id);
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function get_all_blog_parent_category_test(){
		$data = $data1 = [];
		$sub_category_details = $parent_details = [];
		$category_details = [];
		$this->db->select('service_category.*
			');
		$this->db->from('service_category');
		//$this->db->join('service_category AS parent_category', 'service_category.parent_id = parent_category.id','left');
		$this->db->where('service_category.is_deleted','0');
		//$this->db->where('service_category.parent_id !=',0);
		//$this->db->group_by('service_category.parent_id');
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query());
		//pre($res->result_array(),1);
		$key_s ='';
		foreach ($res->result_array() as $key => $value) {
			$data[$key]['id'] = $value['id'];
			$data[$key]['category_name'] = $value['category_name'];
			$data[$key]['category_slug'] = $value['category_url'];
			$data[$key]['status'] = $value['is_active'];
			$data[$key]['image'] = $value['image'];
			$data[$key]['template_view'] = $value['template_view'];
			
			if($value['parent_id']!=0){
				$this->db->select('service_category.*');
				$this->db->from('service_category');
				$this->db->where('service_category.id',$value['parent_id']);
				$res=$this->db->get();
				//pre($this->db->last_query());
				//pre($res->result_array(),1);
				$data[$key]['parent_cat_details'] = $res->result_array();
				foreach ($res->result_array() as $key_p => $value_p) {
					if($value_p['parent_id']!=0){
						unset($data[$key]['parent_cat_details']);
						$data[$key]['sub_category_details'][$key_p]['id'] =$value_p['id'];
						$data[$key]['sub_category_details'][$key_p]['category_name'] =$value_p['category_name'];
						$data[$key]['sub_category_details'][$key_p]['category_slug'] =$value_p['category_url'];
						$data[$key]['sub_category_details'][$key_p]['status'] =$value_p['is_active'];
						$data[$key]['sub_category_details'][$key_p]['image'] =$value_p['image'];
						$data[$key]['sub_category_details'][$key_p]['template_view'] =$value_p['template_view'];

						$this->db->select('service_category.*');
						$this->db->from('service_category');
						$this->db->where('service_category.id',$value_p['parent_id']);
						$res=$this->db->get();
						$data[$key]['sub_category_details'][$key_p]['parent_cat_details'] = $res->result_array();
					}
				}
				

			}
		}

		//pre($data);
		//pre("===================================");
		foreach ($data as $key => $value) {

			if(!empty($value['parent_cat_details'])){
				foreach ($value['parent_cat_details'] as $key_p => $value_p) {
					$data1[$key]['id'] = $value_p['id'];
					$data1[$key]['category_name'] = $value_p['category_name'];
					$data1[$key]['category_slug'] = $value_p['category_url'];
					$data1[$key]['image'] = $value_p['image'];
					$data1[$key]['status'] = $value_p['is_active'];
					$data1[$key]['template_view'] = $value_p['template_view'];


					$data1[$key]['sub_category_details'][$key_p]['id'] = $value['id'];
					$data1[$key]['sub_category_details'][$key_p]['category_name'] = $value['category_name'];
					$data1[$key]['sub_category_details'][$key_p]['category_slug'] = $value['category_slug'];
					$data1[$key]['sub_category_details'][$key_p]['image'] = $value['image'];
					$data1[$key]['sub_category_details'][$key_p]['status'] = $value['status'];
					$data1[$key]['sub_category_details'][$key_p]['template_view'] = $value['template_view'];

				}
			}
			else if(!empty($value['sub_category_details'])){

				foreach ($value['sub_category_details'] as $key_p => $value_p) {

					foreach ($value_p['parent_cat_details'] as $key_p_s => $value_p_s) {
						/** Category **/
						$data1[$key]['id'] = $value_p_s['id'];
						$data1[$key]['category_name'] = $value_p_s['category_name'];
						$data1[$key]['category_slug'] = $value_p_s['category_url'];
						$data1[$key]['image'] = $value_p_s['image'];
						$data1[$key]['status'] = $value_p_s['is_active'];
						$data1[$key]['template_view'] = $value_p_s['template_view'];
					}

					/** Sub Category **/
					$data1[$key]['sub_category_details'][$key_p]['id'] = $value_p['id'];
					$data1[$key]['sub_category_details'][$key_p]['category_name'] = $value_p['category_name'];
					$data1[$key]['sub_category_details'][$key_p]['category_slug'] = $value_p['category_slug'];
					$data1[$key]['sub_category_details'][$key_p]['image'] = $value_p['image'];
					$data1[$key]['sub_category_details'][$key_p]['status'] = $value_p['status'];
					$data1[$key]['sub_category_details'][$key_p]['template_view'] = $value_p['template_view'];


					/** Parent Category **/
					$data1[$key]['sub_category_details'][$key_p]['sub_sub_category_details'][$key_p]['id'] = $value['id'];
					$data1[$key]['sub_category_details'][$key_p]['sub_sub_category_details'][$key_p]['category_name'] = $value['category_name'];
					$data1[$key]['sub_category_details'][$key_p]['sub_sub_category_details'][$key_p]['category_slug'] = $value['category_slug'];
					$data1[$key]['sub_category_details'][$key_p]['sub_sub_category_details'][$key_p]['status'] = $value['status'];
					$data1[$key]['sub_category_details'][$key_p]['sub_sub_category_details'][$key_p]['template_view'] = $value['template_view'];
					$data1[$key]['sub_category_details'][$key_p]['sub_sub_category_details'][$key_p]['template_view'] = $value['template_view'];


				}

			}
			else{
				$data1[$key]['id'] = $value['id'];
				$data1[$key]['category_name'] = $value['category_name'];
				$data1[$key]['category_slug'] = $value['category_slug'];
				$data1[$key]['image'] = $value['image'];
				$data1[$key]['status'] = $value['status'];
				$data1[$key]['template_view'] = $value['template_view'];
			}
			
			# code...
		}
		//pre($data1,1);
		return $data1;
	}
	public function get_all_blog_parent_category(){
		$data = [];
		$sub_category_details = [];
		$category_details = [];
		$this->db->select('service_category.parent_id AS parent_cat_id,
			parent_category.category_name AS parent_cat_name,
			parent_category.category_url AS parent_cat_slug,
			parent_category.is_active AS parent_cat_status,
			parent_category.image AS parent_cat_image,
			parent_category.template_view AS parent_cat_template_view,
			');
		$this->db->from('service_category');
		$this->db->join('service_category AS parent_category', 'service_category.parent_id = parent_category.id','left');
		$this->db->where('parent_category.is_deleted','0');
		$this->db->where('service_category.parent_id !=',0);
		$this->db->group_by('service_category.parent_id');
		$this->db->order_by('service_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		foreach ($res->result_array() as $key => $value) {
			$data[$key]['parent_cat_id'] = $value['parent_cat_id'];
			$data[$key]['parent_cat_name'] = $value['parent_cat_name'];
			$data[$key]['parent_cat_slug'] = $value['parent_cat_slug'];
			$data[$key]['parent_cat_status'] = $value['parent_cat_status'];
			$data[$key]['parent_cat_image'] = $value['parent_cat_image'];
			$data[$key]['parent_cat_template_view'] = $value['parent_cat_template_view'];
			$this->db->select('
				service_category.sub_parent_id AS sub_parent_id,
				sub_parent_category.category_name AS sub_parent_cat_name,
				sub_parent_category.category_url AS sub_category_slug,
				sub_parent_category.is_active AS sub_parent_cat_status,
				sub_parent_category.image AS sub_parent_cat_image,
				sub_parent_category.template_view AS sub_category_template_view,
				');
			$this->db->from('service_category');
			$this->db->join('service_category AS sub_parent_category', 'service_category.sub_parent_id = sub_parent_category.id','left');
			$this->db->where('service_category.parent_id',$value['parent_cat_id']);
			$this->db->where('service_category.sub_parent_id !=',0);
			$this->db->where('sub_parent_category.is_deleted','0');
			$this->db->group_by('service_category.sub_parent_id');
			$this->db->order_by('service_category.id','DESC');
			$res = $this->db->get();
			$data[$key]['sub_category_details'] = $res->result_array();
			if(!empty($data[$key]['sub_category_details']))
			{
				foreach ($data[$key]['sub_category_details'] as $key_s => $value_s) 
				{
					$this->db->select('
						service_category.id AS category_id,
						service_category.category_name AS category_name,
						service_category.category_url AS category_slug,
						service_category.is_active AS category_status,
						service_category.image AS category_image,
						service_category.template_view AS category_template_view,
						');
					$this->db->from('service_category');
					$this->db->where('service_category.sub_parent_id',$value_s['sub_parent_id']);
					$this->db->where('service_category.is_deleted','0');
					$this->db->order_by('service_category.id','DESC');
					$res = $this->db->get();
					$data[$key]['sub_category_details'][$key_s]['category_details'] = $res->result_array();
				}
			}
			else
			{
				unset($data[$key]['sub_category_details']);
				$this->db->select('
						service_category.id AS category_id,
						service_category.category_name AS category_name,
						service_category.category_url AS category_slug,
						service_category.is_active AS category_status,
						service_category.image AS category_image,
						service_category.template_view AS category_template_view,
						');
					$this->db->from('service_category');
					$this->db->where('service_category.parent_id',$value['parent_cat_id']);
					$this->db->where('service_category.is_deleted','0');
					$this->db->order_by('service_category.id','DESC');
					$res = $this->db->get();
					$data[$key]['category_details'] = $res->result_array();
			}
			
		}
		//pre($data,1);
		return $data;
	}

	public function addOtherImage($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('blog_post',$data);
	}
	public function addVideoLinks($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('blog_post',$data);
	}
	public function get_all_blog_sub_category($limit='',$start=''){
		$this->db->select('blog_sub_category.*,service_category.category_name as parent_category_name');
		$this->db->from('blog_sub_category');
		$this->db->join('service_category', 'blog_sub_category.cat_id = service_category.id');
		$this->db->where('blog_sub_category.is_deleted','0');
		$this->db->order_by('blog_sub_category.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
		
	}
	public function checkSlug($slug){
		$data = [];
		$this->db->select('id,blog_url AS slug,blog_title AS title');
		$this->db->from('blog_post');
		$this->db->where('blog_post.blog_url',$slug);
		$this->db->where('blog_post.is_active','active');
		$this->db->where('blog_post.is_deleted','0');
		$res = $this->db->get();
		if($res->num_rows()>0){
			foreach ( $res->result_array() as $key => $value) {
					$data['id'] = $value['id'];
					$data['title'] = $value['id'];
					$data['slug'] = $value['slug'];
					$data['type'] = 'post';
				}
		}else{
			$this->db->select('id,category_url AS slug,category_name AS title,service_category.parent_id');
			$this->db->from('service_category');
			$this->db->where('service_category.category_url',$slug);
			$this->db->where('service_category.is_active','active');
			$this->db->where('service_category.is_deleted','0');
			$res = $this->db->get();
			//pre( $this->db->last_query(),1);
			if($res->num_rows()>0){
				foreach ( $res->result_array() as $key => $value) {
					$data['id'] = $value['id'];
					$data['title'] = $value['title'];
					$data['slug'] = $value['slug'];
					$data['type'] = 'category';
					$data['parent_id'] = $value['parent_id'];
					if($value['parent_id']!=''){
						$this->db->select('id,category_url AS slug,category_name AS title,service_category.parent_id');
						$this->db->from('service_category');
						//$this->db->where('service_category.category_url',$slug);
						$this->db->where('service_category.id',$value['parent_id']);
						$this->db->where('service_category.is_active','active');
						$this->db->where('service_category.is_deleted','0');
						$res = $this->db->get();
						if($res->num_rows()>0){
							//$data['parent'] = $res->result_array();

							foreach ( $res->result_array() as $key_p => $value_p) {
								$data['parent'][$key_p]['id'] = $value_p['id'];
								$data['parent'][$key_p]['title'] = $value_p['title'];
								$data['parent'][$key_p]['slug'] = $value_p['slug'];
								$data['parent'][$key_p]['parent_id'] = $value_p['parent_id'];

									if($value_p['parent_id']!=0){
										$this->db->select('id,category_url AS slug,category_name AS title,service_category.parent_id');
										$this->db->from('service_category');
										//$this->db->where('service_category.category_url',$slug);
										$this->db->where('service_category.id',$value_p['parent_id']);
										$this->db->where('service_category.is_active','active');
										$this->db->where('service_category.is_deleted','0');
										$res = $this->db->get();
										$data['parent'][$key_p]['grand_parent'] = $res->result_array();

									}
								
								}

							}
						}
				}
				
			}
		}

		return $data;
	}
}