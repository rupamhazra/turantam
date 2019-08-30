<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blogmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
    public function saveBlogCategoryData($data){
		$result = $this->db->insert('blog_category',$data);
		if($result)
		{
			$last_insert_id = $this->db->insert_id();
			$data = [];
			$tags_ids = !empty($this->input->post('selected_tags'))? $this->input->post('selected_tags'):'';
			//pre($tags_ids,1);
			foreach ($tags_ids as $key => $value) {
				$data[$key]['post_or_category_id'] = $last_insert_id;
				$data[$key]['tag_id'] = $value;
				$data[$key]['type'] = 'category';
			}
			//pre($data,1);
			$this->db->insert_batch('mapping_post_or_cat_tags',$data);
		}
		
	}
	public function updateblogCategoryData($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('blog_category',$data);
		if($result){
			$this->db->where('post_or_category_id',$id);
			$this->db->where('type','category');
			$this->db->delete('mapping_post_or_cat_tags');
			$data = [];
			//pre($tags_ids,1);
			if(!empty($this->input->post('selected_tags'))){
				$tags_ids = $this->input->post('selected_tags');
				foreach ($tags_ids as $key => $value) {
					$data[$key]['post_or_category_id'] = $id;
					$data[$key]['tag_id'] = $value;
					$data[$key]['type'] = 'category';
				}
				//pre($data,1);
				$this->db->insert_batch('mapping_post_or_cat_tags',$data);
			}
		}
	}
	public function saveBlogSubCategoryData($data){
		$this->db->insert('blog_sub_category',$data);
		
	}
	public function saveBlog($data){
		$this->db->insert('blog_post',$data);
		$lastId=$this->db->insert_id();
		$blogMeta['blog_id']=$lastId;
		$this->db->insert('blog_meta',$blogMeta);
		/* $dataId['page_id']=$lastId;
		$dataId['ip_address']=getenv('REMOTE_ADDR');
		$this->db->insert('page_content',$dataId);
		$this->db->insert('page_meta',$dataId);
		$this->db->insert('page_banner',$dataId); */
		
	}
	public function getParentCategoryList(){
		$this->db->where('is_active','active');
		$res=$this->db->get('blog_category');
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	// public function getParentList(){
	// 	$this->db->where('is_deleted','0');
	// 	$res=$this->db->get('blog_category');
	// 	return $res->result_array();
	// }
	public function getSubParentList(){
		$this->db->where('is_deleted','0');
		$res=$this->db->get('blog_category');
		return $res->result_array();
	}
	public function getParentList(){
		$this->db->select('blog_category.*,
			blog_category.template_view AS template_view'
		);
		$this->db->from('blog_category');
		$this->db->where('blog_category.is_deleted','0');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function getParentListAll(){
		$res=$this->db->get('pages');
		return $res->result_array();
	}
	public function getBlogListCount(){
		$this->db->select('*');
		$this->db->from('blog_post');
		$this->db->where('blog_post.is_deleted','0');
		$this->db->order_by('blog_post.id', 'desc');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->num_rows();
		
	}
	public function getBlogList($start='', $limit=''){
		$data = [];
		$this->db->select('blog_post.*,
			users.name as name,
			blog_category.id AS category_id,
			blog_category.category_name AS category_name,
			blog_category.category_url AS category_slug,
			blog_category.template_view AS template_view,
			');
		$this->db->from('blog_post');
		//$this->db->join('comments', 'comments.post_id = blog_post.id','left');
		$this->db->join('users', 'users.id = blog_post.user_id');
		$this->db->join('blog_category','blog_post.blog_category_id=blog_category.id','left');
		$this->db->join('blog_category AS parent_category', 'blog_category.parent_id = parent_category.id','left');
		
		$this->db->where('blog_post.is_deleted','0');
		//$this->db->group_by('comments.post_id');
		$this->db->order_by('blog_post.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['user_id'] = $value['user_id'];
				$data[$key]['name'] = $value['name'];
				$data[$key]['blog_title'] = $value['blog_title'];
				$data[$key]['is_active'] = $value['is_active'];
				$data[$key]['blog_excerpt'] = $value['blog_excerpt'];
				$data[$key]['blog_url'] = $value['blog_url'];
				$data[$key]['blog_content'] = $value['blog_content'];
				$data[$key]['blog_large_image'] = $value['blog_large_image'];
				$data[$key]['blog_small_image'] = $value['blog_small_image'];
				$data[$key]['blog_image_alt'] = $value['blog_image_alt'];
				$data[$key]['date_created'] = $value['date_created'];
				$data[$key]['blog_category_id'] = $value['blog_category_id'];
				$data[$key]['category_name'] = $value['category_name'];
				$data[$key]['category_slug'] = $value['category_slug'];
				$data[$key]['apply_button'] = $value['apply_button'];
				//$data[$key]['deals_start_datetime'] = $value['deals_start_datetime'];
				//$data[$key]['deals_end_datetime'] = $value['deals_end_datetime'];
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
		//pre($data,1);
		return $data;
	}
	public function getBlogListCountByCatId($id){
		$this->db->select('blog_post.*,
			users.name as name,
			blog_category.id AS category_id,
			blog_category.category_name AS category_name,
			blog_category.category_url AS category_slug,
			blog_category.template_view AS template_view,
			');
		$this->db->from('blog_post');
		//$this->db->join('comments', 'comments.post_id = blog_post.id','left');
		$this->db->join('users', 'users.id = blog_post.user_id');
		$this->db->join('blog_category','blog_post.blog_category_id=blog_category.id','left');
		$this->db->join('blog_category AS parent_category', 'blog_category.parent_id = parent_category.id','left');
		
		$this->db->where('blog_post.is_deleted','0');
		$this->db->where('blog_post.blog_category_id',$id);
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
			blog_category.id AS category_id,
			blog_category.category_name AS category_name,
			blog_category.description AS category_description,
			blog_category.category_url AS category_slug,
			blog_category.template_view AS template_view,
			');
		$this->db->from('blog_post');
		$this->db->join('users', 'users.id = blog_post.user_id','left');
		$this->db->join('blog_category','blog_post.blog_category_id=blog_category.id','left');
		$this->db->join('blog_category AS parent_category', 'blog_category.parent_id = parent_category.id','left');
		
		$this->db->where('blog_post.is_deleted','0');
		$this->db->where('blog_post.blog_category_id',$id);
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
				$data[$key]['blog_category_id'] = $value['blog_category_id'];
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
	public function getFeaturedPost(){
		$this->db->where('is_featured','1');
		$this->db->order_by('id', 'desc');
		$this->db->limit(3);
		$res=$this->db->get('blog_post');
		return $res->result_array();
		
	}
	public function get_blog_by_url($url){
		$this->db->where('blog_url',$url);
		$res=$this->db->get('blog_post');
		return $res->row_array();
	}
	public function change_blog_category_status($id,$data){
		$this->db->where('id',$id);
		$this->db->update('blog_category',$data);
	}
	public function change_blog_sub_category_status($id,$data){
		$this->db->where('id',$id);
		$this->db->update('blog_sub_category',$data);
	}
	public function getBlogCategoryById($id){
		$this->db->where('id',$id);
		$res=$this->db->get('blog_category');
		return $res->row_array();
	}
	public function getBlogSubCategoryById($id){
		$this->db->where('id',$id);
		$res=$this->db->get('blog_sub_category');
		return $res->row_array();
	}
	public function get_all_blog_category(){
		$this->db->select('blog_category.*');
		$this->db->from('blog_category');
		$this->db->where('blog_category.is_deleted','0');
		$this->db->where('blog_category.parent_id','0');
		$this->db->order_by('blog_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function get_all_blog_category_add($id=''){
		$data = [];
		$this->db->select('blog_category.*');
		$this->db->from('blog_category');
		$this->db->where('blog_category.is_deleted','0');
		
		if($id) $this->db->where('blog_category.parent_id',$id);
		else $this->db->where('blog_category.parent_id','0');
		$this->db->order_by('blog_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array())
		{
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['category_name'] = $value['category_name'];
				$data[$key]['category_slug'] = $value['category_url'];
				//$data[$key]['category_name'] = $value['category_name'];
				//$data[$key]['category_name'] = $value['category_name'];
				$this->db->select('blog_category.*');
				$this->db->from('blog_category');
				$this->db->where('blog_category.is_deleted','0');
				//$this->db->where('blog_category.parent_id','0');
				$this->db->where('blog_category.parent_id',$value['id']);
				$this->db->order_by('blog_category.id','DESC');
				$res=$this->db->get();
				if($res->result_array()){
					//$data[$key]['sub_category_details'] = $res->result_array();
					foreach ($res->result_array() as $key_s => $value_s) {
						$data[$key]['sub_category_details'][$key_s]['id'] = $value_s['id'];
						$data[$key]['sub_category_details'][$key_s]['category_name'] = $value_s['category_name'];
						$data[$key]['sub_category_details'][$key_s]['category_slug'] = $value_s['category_url'];
					}
					
				}
				
			}
		}
		//pre($data,1);
		return $data;
	}
	public function get_all_blog_category_api(){
		$data = [];
		$this->db->select('blog_category.*');
		$this->db->from('blog_category');
		$this->db->where('blog_category.is_deleted','0');
		$this->db->where('blog_category.parent_id','0');
		$this->db->order_by('blog_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array())
		{
			foreach ($res->result_array() as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['category_name'] = $value['category_name'];
				$data[$key]['category_slug'] = $value['category_url'];
				$this->db->select('blog_category.*');
				$this->db->from('blog_category');
				$this->db->where('blog_category.is_deleted','0');
				$this->db->where('blog_category.parent_id',$value['id']);
				$this->db->order_by('blog_category.id','DESC');
				$res=$this->db->get();
				if($res->result_array()){

					foreach ($res->result_array() as $key_s => $value_s) {
						$data[$key]['sub_category_details'][$key_s]['id'] = $value_s['id'];
						$data[$key]['sub_category_details'][$key_s]['category_name'] = $value_s['category_name'];
						$data[$key]['sub_category_details'][$key_s]['category_slug'] = $value_s['category_url'];

						$this->db->select('blog_category.id,blog_category.category_name,blog_category.category_url AS category_slug,blog_category.tags_ids');
						$this->db->from('blog_category');
						$this->db->where('blog_category.is_deleted','0');
						//$this->db->where('blog_category.parent_id','0');
						$this->db->where('blog_category.parent_id',$value_s['id']);
						$this->db->order_by('blog_category.id','DESC');
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
	public function get_all_blog_parent_id_category(){
		$id = $this->input->post('id');
		$this->db->select('blog_category.*');
		$this->db->from('blog_category');
		$this->db->where('blog_category.is_deleted','0');
		$this->db->where('blog_category.parent_id',$id);
		$this->db->order_by('blog_category.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function get_all_blog_parent_category_test(){
		$data = $data1 = [];
		$sub_category_details = $parent_details = [];
		$category_details = [];
		$this->db->select('blog_category.*
			');
		$this->db->from('blog_category');
		//$this->db->join('blog_category AS parent_category', 'blog_category.parent_id = parent_category.id','left');
		$this->db->where('blog_category.is_deleted','0');
		//$this->db->where('blog_category.parent_id !=',0);
		//$this->db->group_by('blog_category.parent_id');
		$this->db->order_by('blog_category.id','DESC');
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
				$this->db->select('blog_category.*');
				$this->db->from('blog_category');
				$this->db->where('blog_category.id',$value['parent_id']);
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

						$this->db->select('blog_category.*');
						$this->db->from('blog_category');
						$this->db->where('blog_category.id',$value_p['parent_id']);
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
		$this->db->select('blog_category.parent_id AS parent_cat_id,
			parent_category.category_name AS parent_cat_name,
			parent_category.category_url AS parent_cat_slug,
			parent_category.is_active AS parent_cat_status,
			parent_category.image AS parent_cat_image,
			parent_category.template_view AS parent_cat_template_view,
			');
		$this->db->from('blog_category');
		$this->db->join('blog_category AS parent_category', 'blog_category.parent_id = parent_category.id','left');
		$this->db->where('parent_category.is_deleted','0');
		$this->db->where('blog_category.parent_id !=',0);
		$this->db->group_by('blog_category.parent_id');
		$this->db->order_by('blog_category.id','DESC');
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
				blog_category.sub_parent_id AS sub_parent_id,
				sub_parent_category.category_name AS sub_parent_cat_name,
				sub_parent_category.category_url AS sub_category_slug,
				sub_parent_category.is_active AS sub_parent_cat_status,
				sub_parent_category.image AS sub_parent_cat_image,
				sub_parent_category.template_view AS sub_category_template_view,
				');
			$this->db->from('blog_category');
			$this->db->join('blog_category AS sub_parent_category', 'blog_category.sub_parent_id = sub_parent_category.id','left');
			$this->db->where('blog_category.parent_id',$value['parent_cat_id']);
			$this->db->where('blog_category.sub_parent_id !=',0);
			$this->db->where('sub_parent_category.is_deleted','0');
			$this->db->group_by('blog_category.sub_parent_id');
			$this->db->order_by('blog_category.id','DESC');
			$res = $this->db->get();
			$data[$key]['sub_category_details'] = $res->result_array();
			if(!empty($data[$key]['sub_category_details']))
			{
				foreach ($data[$key]['sub_category_details'] as $key_s => $value_s) 
				{
					$this->db->select('
						blog_category.id AS category_id,
						blog_category.category_name AS category_name,
						blog_category.category_url AS category_slug,
						blog_category.is_active AS category_status,
						blog_category.image AS category_image,
						blog_category.template_view AS category_template_view,
						');
					$this->db->from('blog_category');
					$this->db->where('blog_category.sub_parent_id',$value_s['sub_parent_id']);
					$this->db->where('blog_category.is_deleted','0');
					$this->db->order_by('blog_category.id','DESC');
					$res = $this->db->get();
					$data[$key]['sub_category_details'][$key_s]['category_details'] = $res->result_array();
				}
			}
			else
			{
				unset($data[$key]['sub_category_details']);
				$this->db->select('
						blog_category.id AS category_id,
						blog_category.category_name AS category_name,
						blog_category.category_url AS category_slug,
						blog_category.is_active AS category_status,
						blog_category.image AS category_image,
						blog_category.template_view AS category_template_view,
						');
					$this->db->from('blog_category');
					$this->db->where('blog_category.parent_id',$value['parent_cat_id']);
					$this->db->where('blog_category.is_deleted','0');
					$this->db->order_by('blog_category.id','DESC');
					$res = $this->db->get();
					$data[$key]['category_details'] = $res->result_array();
			}
			
		}
		//pre($data,1);
		return $data;
	}
	public function getBlogById($id){
		$data = [];
		$this->db->select('blog_post.*,
			users.name as name,
			blog_category.id AS category_id,
			blog_category.category_name AS category_name,
			blog_category.category_url AS category_slug,
			blog_category.template_view AS template_view'
		);
		$this->db->from('blog_post');
		$this->db->join('users', 'users.id = blog_post.user_id');
		$this->db->join('blog_category','blog_post.blog_category_id=blog_category.id','left');
		$this->db->where('blog_post.is_deleted','0');
		$this->db->where('blog_post.id',$id);
		$res=$this->db->get();
		foreach ($res->result_array() as $key => $value) {
			$data['id'] = $value['id'];
			$data['user_id'] = $value['user_id'];
			$data['name'] = $value['name'];
			$data['blog_title'] = $value['blog_title'];
			$data['blog_excerpt'] = $value['blog_excerpt'];
			$data['blog_url'] = $value['blog_url'];
			$data['blog_content'] = $value['blog_content'];
			$data['blog_large_image'] = $value['blog_large_image'];
			$data['blog_small_image'] = $value['blog_small_image'];
			$data['blog_image_alt'] = $value['blog_image_alt'];
			$data['is_active'] = $value['is_active'];
			$data['date_created'] = $value['date_created'];
			$data['blog_category_id'] = $value['blog_category_id'];
			$data['category_name'] = $value['category_name'];
			$data['category_slug'] = $value['category_slug'];
			$data['apply_button'] = $value['apply_button'];
			$data['apply_button_link'] = $value['apply_button_link'];
			$data['is_active'] = $value['is_active'];
			$data['template_view'] = $value['template_view'];
			/** for approve comments **/
			$this->db->select(
					'COUNT(CASE WHEN is_approved = "0" THEN 0 END) AS reject,
					COUNT(CASE WHEN is_approved = "1" THEN 1 END) AS approved,
					COUNT(CASE WHEN is_approved = "2" THEN 2 END) AS new
					');
			$this->db->from('comments');
			$this->db->where('post_id',$value['id']);
			$this->db->group_by('post_id');
			$res1 = $this->db->get();
			$comments_results = $res1->row_array();
			$data['comments_new'] = $comments_results['new'];
			$data['comments_reject'] = $comments_results['reject'];
			$data['comments_approved'] = $comments_results['approved'];
			
			/** for root comments **/
			$this->db->select('comments.*,users.name AS user');
			$this->db->from('comments');
			$this->db->join('users', 'users.id = comments.user_id');
			$this->db->where('comments.post_id',$value['id']);
			$this->db->where('comments.is_deleted','0');
			$this->db->where('comments.comment_parent','0');
			$res = $this->db->get();
			if($res->num_rows() < 1){
				$data['comments'] = $res->result_array();
			}
			else
			{
				/** for root comments **/
				foreach ($res->result_array() as $key_c => $value_c) {
					$data['comments'][$key_c]['id'] = $value_c['id'];
					$data['comments'][$key_c]['title'] = $value_c['title'];
					$data['comments'][$key_c]['user_id'] = $value_c['user_id'];
					$data['comments'][$key_c]['user'] = $value_c['user'];
					$data['comments'][$key_c]['comment_parent'] = $value_c['comment_parent'];
					$data['comments'][$key_c]['is_approved'] = $value_c['is_approved'];
					$data['comments'][$key_c]['date_created'] = $value_c['date_created'];
					/** for reply comments **/
					$data['comments'][$key_c]['reply'] = $this->replyComment($id,$value_c['id']);
					
					// $this->db->select('comments.*,users.name AS user');
					// $this->db->from('comments');
					// $this->db->join('users', 'users.id = comments.user_id');
					// $this->db->where('comments.post_id',$value['id']);
					// $this->db->where('comments.is_deleted','0');
					// $this->db->where('comments.comment_parent', $value_c['id']);
					// $res = $this->db->get();
					// if($res->result_array())
					// {

					// 	// foreach ($res->result_array() as $key_r => $value_r) {
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['id'] = $value_r['id'];
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['title'] = $value_r['title'];
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['user_id'] = $value_r['user_id'];
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['user'] = $value_r['user'];
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['comment_parent'] = $value_r['comment_parent'];
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['is_approved'] = $value_r['is_approved'];
					// 	// 	$data['comments'][$key_c]['reply'][$key_r]['date_created'] = $value_r['date_created'];
					// 	}
						
					// }
				}

			}
		}
		return $data;
	}
	public function replyComment($post_id='',$parent_id=''){
		$data = [];
		$this->db->select('comments.*,users.name AS user');
		$this->db->from('comments');
		$this->db->join('users', 'users.id = comments.user_id');
		$this->db->where('comments.post_id',$post_id);
		$this->db->where('comments.is_deleted','0');
		$this->db->where('comments.comment_parent', $parent_id);
		$res = $this->db->get();
		//pre($this->db->last_query(),1);
		foreach ($res->result_array() as $key => $value) {
			$value['reply'] = $this->replyComment($post_id,$value['id']);
        	$data[] = $value;
		}
		return $data;
	}
	/**************** C O M M E N T **************************/
	public function addComment($data){
		$message = [];
		$db_debug = $this->db->db_debug; //save setting
		$this->db->db_debug = FALSE; //disable debugging for queries
		$this->db->insert('comments',$data);
		$this->db->db_debug = $db_debug; //restore setting
		$msg = $this->db->conn_id->error_list;
		if(!empty($msg)){
		    if(!empty($msg[0]['error'])){
		    	$message['status'] = FALSE;
		    	$message['message'] = $msg[0]['error'];
			}
		}else{
			$message['status'] = TRUE;
			$message['message'] = 'Comment has been submitted';
		}
		return $message;
	}



	public function delete_blog($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$this->db->update('blog_post',$data);
	}
	public function change_blog_status($id,$data){
		$this->db->where('id',$id);
		$this->db->update('blog_post',$data);
	}
	public function get_active_blog_category(){
		$this->db->where('is_active','active');
		$res=$this->db->get('blog_category');
		return $res->result_array();
	}
	public function get_all_blogs(){
		$res=$this->db->get('blog_post');
		return $res->result_array();
	}
	public function get_fabulus_article(){
		$this->db->where('fabulus','1');
		$res=$this->db->get('blog_post');
		return $res->row_array();
	}
	public function delete_blog_category($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$this->db->update('blog_category',$data);
		
	}
	public function delete_blog_sub_category($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$this->db->update('blog_sub_category',$data);
		
	}
	
	public function updateblogSubCategoryData($id,$data){
		$this->db->where('id',$id);
		$this->db->update('blog_sub_category',$data);
	}
	public function update_content($id,$data){
		$this->db->where('page_id',$id);
		$this->db->update('page_content',$data);
	}
	public function update_blog($id,$data){
		$this->db->where('id',$id);
		$this->db->update('blog_post',$data);
	}
	public function get_page_content($id){
		$this->db->where('page_id',$id);
		$res=$this->db->get('page_content');
		return $res->row_array();
	}
	public function update_banner($id,$data){
		$this->db->where('page_id',$id);
		$this->db->update('page_banner',$data);
	}
	public function get_page_banner($id){
		$this->db->where('page_id',$id);
		$res=$this->db->get('page_banner');
		return $res->row_array();
	}
	public function remove_banner($id){
		$data['banner_path']=NULL;
		$this->db->where('page_id',$id);
		$this->db->update('page_banner',$data);
	}
	public function get_meta_by_id($id){
		$this->db->where('blog_id',$id);
		$res=$this->db->get('blog_meta');
		return $res->row_array();
	}
	
	public function update_blog_meta($id,$data){
		$this->db->where('blog_id',$id);
		$this->db->update('blog_meta',$data);
	}

	/** Rupam **/
	public function addOtherImage($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('blog_post',$data);
	}
	public function addVideoLinks($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('blog_post',$data);
	}
	public function get_all_blog_sub_category($limit='',$start=''){
		$this->db->select('blog_sub_category.*,blog_category.category_name as parent_category_name');
		$this->db->from('blog_sub_category');
		$this->db->join('blog_category', 'blog_sub_category.cat_id = blog_category.id');
		$this->db->where('blog_sub_category.is_deleted','0');
		$this->db->order_by('blog_sub_category.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
		
	}
	public function getTagList(){
		$this->db->select('master_tags.*');
		$this->db->from('master_tags');
		$this->db->where('master_tags.is_deleted','0');
		$this->db->order_by('master_tags.id','DESC');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}

	public function addTags(){
		//pre($this->input->post());
		$data = [];
		$post_array = explode(',', $this->input->post('tag_name'));
		$count = count($post_array);
		for($i=0;$i<$count;$i++){
			$data[$i]['name'] = $post_array[$i];
		}
		//pre($this->db->insert_batch('master_tags',$data),1);
		$this->db->insert_batch('master_tags',$data);
		$last_insert_id = $this->db->insert_id();
		
		unset($data);
		for($i=0;$i<$count;$i++){
			if($i==0) $data[$i]['id'] = $last_insert_id;
			else 
			{
				$last_insert_id ++;
				$data[$i]['id'] = $last_insert_id;

			}	
			$data[$i]['name'] = $post_array[$i];
		}
		//pre($data,1);
		return $data;
	}
	public function delete_tag($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('master_tags',$data);
	}
	public function editTags($id){
		$data = ['name' => $this->input->post('tag_name')];
		$this->db->where('id',$id);
		return $this->db->update('master_tags',$data);
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
			$this->db->select('id,category_url AS slug,category_name AS title,blog_category.parent_id');
			$this->db->from('blog_category');
			$this->db->where('blog_category.category_url',$slug);
			$this->db->where('blog_category.is_active','active');
			$this->db->where('blog_category.is_deleted','0');
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
						$this->db->select('id,category_url AS slug,category_name AS title,blog_category.parent_id');
						$this->db->from('blog_category');
						//$this->db->where('blog_category.category_url',$slug);
						$this->db->where('blog_category.id',$value['parent_id']);
						$this->db->where('blog_category.is_active','active');
						$this->db->where('blog_category.is_deleted','0');
						$res = $this->db->get();
						if($res->num_rows()>0){
							//$data['parent'] = $res->result_array();

							foreach ( $res->result_array() as $key_p => $value_p) {
								$data['parent'][$key_p]['id'] = $value_p['id'];
								$data['parent'][$key_p]['title'] = $value_p['title'];
								$data['parent'][$key_p]['slug'] = $value_p['slug'];
								$data['parent'][$key_p]['parent_id'] = $value_p['parent_id'];

									if($value_p['parent_id']!=0){
										$this->db->select('id,category_url AS slug,category_name AS title,blog_category.parent_id');
										$this->db->from('blog_category');
										//$this->db->where('blog_category.category_url',$slug);
										$this->db->where('blog_category.id',$value_p['parent_id']);
										$this->db->where('blog_category.is_active','active');
										$this->db->where('blog_category.is_deleted','0');
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
	public function getCommentList($start='', $limit=''){
		$this->db->select('comments.*,
			users.name as user_name,
			users.profile_image as user_profile_image,
			blog_post.id AS blog_id,
			blog_post.blog_title AS blog_title,
			');
		$this->db->from('comments');
		$this->db->join('users', 'users.id = comments.user_id');
		$this->db->join('blog_post','blog_post.id=comments.post_id','left');
		$this->db->where('comments.is_deleted','0');
		$this->db->order_by('comments.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->result_array();
	}
	public function getCommentById($id){
		$this->db->select('comments.*,
			users.name as user_name,
			users.profile_image as user_profile_image,
			blog_post.id AS blog_id,
			blog_post.blog_title AS blog_title,
			');
		$this->db->from('comments');
		$this->db->join('users', 'users.id = comments.user_id');
		$this->db->join('blog_post','blog_post.id=comments.post_id','left');
		$this->db->where('comments.is_deleted','0');
		$this->db->where('comments.id',$id);
		$this->db->order_by('comments.id', 'desc');
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		return $res->row_array();
	}
	public function updateComment($data,$id){
		$this->db->where('id',$id);
		return $this->db->update('comments',$data);
	}
	public function deleteComment($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('comments',$data);
	}
	public function change_comment_status($id='',$data=''){
		if(!$id) {
			$data = ['is_approved'=> $this->input->post('is_approved')];
			$this->db->where('id',$this->input->post('id'));
		}else{
			$this->db->where('id',$id);
		}
		return $this->db->update('comments',$data);
	}
	public function get_all_tags_by_cat_id($id){
		$this->db->select('master_tags.*');
		$this->db->from('master_tags');
		$this->db->join('mapping_post_or_cat_tags','mapping_post_or_cat_tags.tag_id=master_tags.id');
		$this->db->where('master_tags.is_deleted','0');
		$this->db->where('mapping_post_or_cat_tags.post_or_category_id',$id);
		$this->db->where('mapping_post_or_cat_tags.type','category');
		$res = $this->db->get();
		return $res->result_array();
		//pre($this->db->last_query(),1);
		//pre($res->result_array(),1);
	}
	public function get_all_tags_by_post_id($id){
		$this->db->select('master_tags.*');
		$this->db->from('master_tags');
		$this->db->join('mapping_post_or_cat_tags','mapping_post_or_cat_tags.tag_id=master_tags.id');
		$this->db->where('master_tags.is_deleted','0');
		$this->db->where('mapping_post_or_cat_tags.post_or_category_id',$id);
		$this->db->where('mapping_post_or_cat_tags.type','post');
		$res = $this->db->get();
		return $res->result_array();
		//pre($this->db->last_query(),1);
		//pre($res->result_array(),1);
	}
}