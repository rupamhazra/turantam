<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogmanager extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Adminmodel','adminmodel');
		$this->load->model('Blogmodel','blogmodel');
		$this->load->model('Companymodel','companymodel');
		$this->load->model('Usermodel','usermodel');
		$this->load->model('Couponmodel','couponmodel');
		$this->load->library('pagination');
	}
	public function index(){
		$data=array();
		$data['parentList']=$this->blogmodel->get_all_blog_category();
		//$data['rootparentList']=$this->blogmodel->get_all_blog_parent_category_test();
		//pre($data['parentList'],1);
		$this->template->load('adminTemplate','admin/blogcategorylist',$data);
	}
	public function getParentCategoryIdList(){
		$data=array();
		$data['catList']=$this->blogmodel->get_all_blog_parent_id_category();
		//pre($data['parentList'],1);
		echo json_encode($data['catList']);
	}
	public function subBlogCategoryList(){
		$data=array();
		$data['parentList']=$this->blogmodel->get_all_blog_sub_category();
		$this->template->load('adminTemplate','admin/blogsubcategorylist',$data);
	}
	public function addBlogCategory(){
		$data=array();
		$data['parentList']=$this->blogmodel->get_all_blog_category_add();
		//$data['subparentList']=$this->blogmodel->getSubParentList();
		$data['tagsList'] = $this->blogmodel->getTagList();
		//pre($data['parentList'],1);
		$this->template->load('adminTemplate','admin/addblogcategory',$data);
	}
	public function saveBlogCategory(){
		$data['category_name']=$this->input->post('inputName');
		$data['category_url']=$this->input->post('inputUrl');
		$data['description']=$this->input->post('description');
		$data['template_view'] = $this->input->post('inputTemplateView');
		$data['parent_id']=$this->input->post('inputParent');
		$data['tags_ids']= !empty($this->input->post('selected_tags'))? json_encode($this->input->post('selected_tags')):'';
		
		$lPicture = '';
		if(!empty($_FILES['inputImage']['name'])){
            $config['upload_path'] = 'uploads/blog_cat_images';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time().$_FILES['inputImage']['name'];
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('inputImage')){
                $uploadData = $this->upload->data();
                $lPicture = 'blog_cat_images/'.$config['file_name'];
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
		$data['image']= $lPicture;
		$data['is_active']='active';
		$data['ip_address']=getenv('REMOTE_ADDR');
		//pre($data,1);
		$this->blogmodel->saveBlogCategoryData($data);
		redirect(base_url('admin/blog-category'));
	}
	public function editBlogCategory($id){
		$data=array();
		$data['parentList']=$this->blogmodel->get_all_blog_category_add();
		$data['tagsList'] = $this->blogmodel->getTagList();
		$data['blogCategory']=$this->blogmodel->getBlogCategoryById($id);
		//pre($data['blogCategory'],1);
		$this->template->load('adminTemplate','admin/editblogcategory',$data);
	}
	public function updateBlogCategory($id)
	{
		//pre($this->input->post(),1);
		$data['category_name']= $this->input->post('inputName');
		$data['category_url']= $this->input->post('inputUrl');
		$data['parent_id']=$this->input->post('inputParent');
		$data['description']=$this->input->post('description');
		$data['template_view'] = $this->input->post('inputTemplateView');
		$data['tags_ids']= !empty($this->input->post('selected_tags'))? json_encode($this->input->post('selected_tags')):'';
		$data['ip_address']=getenv('REMOTE_ADDR');
		
		if(!empty($_FILES['inputImage']['name'])){
            $config['upload_path'] = 'uploads/blog_cat_images';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name'] = time().$_FILES['inputImage']['name'];
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('inputImage')){
                $uploadData = $this->upload->data();
                $lPicture = 'blog_cat_images/'.$config['file_name'];
            }
			else{
				 $error = array('error' => $this->upload->display_errors());
                 $lPicture = '';
            }
            $data['image']=$lPicture;
        }
        //pre($data,1);
		$this->blogmodel->updateblogCategoryData($id,$data);
		redirect(base_url('admin/blog-category'));
	}
	public function addBlog($id=''){
		//echo "test";
		//print_r($_POST);
		//exit;
		
		$data=array();
		//$data['blogCategoryList']=$this->blogmodel->getParentList();
		$data['parentList']=$this->blogmodel->get_all_blog_category_add();
		//pre($data['blogCategoryList'],1);
		if($this->input->post('blogAdd') && $this->input->post('blogAdd')==1){
			//pre($this->input->post(),1);
			$dataSave['blog_category_id']=$this->input->post('inputBlogCategory');
			$dataSave['blog_title']=$this->input->post('inputBlogTitle');
			$dataSave['blog_url']=$this->input->post('inputBlogUrl');
			$dataSave['blog_content'] = str_replace('../uploads', base_url('uploads'), $this->input->post('inputContent'));
			$dataSave['blog_excerpt']=$this->input->post('inputExcerpt');
			$dataSave['user_id']=$this->input->post('user_id');
			//pre($dataSave,1);
			// $dataSave['master_card_category'] = json_encode($this->input->post('inputCardCategory'));
			// $dataSave['master_card_issuer'] = json_encode($this->input->post('inputCardIssuer'));
			// $dataSave['master_card_range'] = json_encode($this->input->post('inputCardRange'));
			
			$lPicture = '';
			$sPicture='';
			if(!empty($_FILES['inputLargeImage']['name'])){
				
                $config['upload_path'] = 'uploads/blog_images';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = "large".time().$_FILES['inputLargeImage']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
               
				
                if($this->upload->do_upload('inputLargeImage')){
					
                    $uploadData = $this->upload->data();
                    $lPicture = $config['file_name'];
					$r=$this->_create_thumbnail($uploadData['file_name']);
					if($r){
						$smPicture=$uploadData['raw_name'];
						//$file['file_name']=$uploadData['raw_name'];
                		$file=$uploadData['file_ext'];
                		$sPicture = $smPicture.'_thumb'.$file;
                			/*$file['file_ext']=$file_info['file_ext'];
                			return $file;*/
					}
            		//$=$this->_create_thumbnail1($file_info['file_name']);
					
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
			
			//$sPicture = $lPicture;
			
			$dataSave['blog_large_image']='blog_images/'.$lPicture;
			$dataSave['blog_small_image']='blog_images/_thumb/'.$sPicture;
			$dataSave['blog_image_alt']=$this->input->post('inputImageAlt');
			$dataSave['date_created']=date('Y-m-d H:i:s');
			$dataSave['is_active']='active';
			$dataSave['is_featured']='1';
			//print_r($dataSave);die;
			//pre($dataSave,1);
			$this->blogmodel->saveBlog($dataSave);
			redirect(base_url('admin/blog-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/blogcontent',$data);
		}
	}
    function _create_thumbnail($filename){
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/blog_images/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['new_image']='uploads/blog_images/_thumb/';
        $config['width'] = 154;
        $config['height'] = 121;
        $this->load->library('image_lib', $config); 
        if($this->image_lib->resize()) return true;
	}
	public function updateBlog($id){
		$data=array();
		$data['parentList']=$this->blogmodel->get_all_blog_category_add();
		$data['blog']=$this->blogmodel->getBlogById($id);
		//pre($data['blog'],1);
		if($this->input->post('editBlog')){
			//pre($this->input->post(),1);
			$dataSave['blog_category_id']=$this->input->post('inputBlogCategory');
			$dataSave['blog_title']=$this->input->post('inputBlogTitle');
			$dataSave['blog_url']=$this->input->post('inputBlogUrl');
			//$blog_content=$this->input->post('inputContent');
			$dataSave['blog_excerpt']=$this->input->post('inputExcerpt');
			$dataSave['user_id']=$this->input->post('user_id');
			//$dataSave['blog_content'] = $this->input->post('inputContent');
			$dataSave['blog_content'] = str_replace('../../uploads', base_url('uploads'), $this->input->post('inputContent'));
			//pre($dataSave,1);
			//$dataSave1['deals_time'] = !empty($this->input->post('reservation-time'))? explode(' - ',$this->input->post('reservation-time')) :'';
			//$dataSave['deals_start_datetime'] = $dataSave1['deals_time'][0];
			//$dataSave['deals_end_datetime'] = $dataSave1['deals_time'][1];

			$dataSave['apply_button'] =$this->input->post('inputApplyNowButton');
			$dataSave['apply_button_link'] = !empty($this->input->post('inputApplyNowButtonLink'))? $this->input->post('inputApplyNowButtonLink'):'';
			if(!empty($_FILES['inputLargeImage']['name'])){
				
                $config['upload_path'] = 'uploads/blog_images';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = time().$_FILES['inputLargeImage']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('inputLargeImage')){
                    $uploadData = $this->upload->data();
                    $lPicture = $config['file_name'];
                    $r=$this->_create_thumbnail($uploadData['file_name']);
					if($r){
						$smPicture=$uploadData['raw_name'];
						//$file['file_name']=$uploadData['raw_name'];
                		$file=$uploadData['file_ext'];
                		$sPicture = $smPicture.'_thumb'.$file;
                			/*$file['file_ext']=$file_info['file_ext'];
                			return $file;*/
					}
                }else{
					 $error = array('error' => $this->upload->display_errors());
					 print_r($error);
					 die;
                    $lPicture = '';
                }
				$dataSave['blog_large_image']='blog_images/'.$lPicture;
				$dataSave['blog_small_image']='blog_images/_thumb/'.$sPicture;
			
            }
			$dataSave['blog_image_alt']=$this->input->post('inputImageAlt');
			//pre($dataSave,1);
			$this->blogmodel->update_blog($id,$dataSave);
			redirect(base_url('admin/blog-list'));
		}
		else{

			$this->template->load('adminTemplate','admin/editblogcontent',$data);
		}
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
	public function blogList(){
		$data=array();
		$data['blogList']=$this->blogmodel->getBlogList();
		//pre($data,1);
		$this->template->load('adminTemplate','admin/bloglist',$data);
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
	public function change_blog_status($id){
		$blog=$this->blogmodel->getBlogById($id);
		if($blog['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->blogmodel->change_blog_status($id,$data);
		redirect(base_url('admin/blog-list'));
	}
	public function delete_blog($id)
	{
		$this->load->helper('file');
		$blog=$this->blogmodel->getBlogById($id);
		/* $lImage='./uploads/blog_images/'.$blog['blog_large_image'];
		$sImage='./uploads/blog_images/'.$blog['blog_small_image']; */
		$lImage=base_url('uploads/blog_images').'/'.$blog['blog_large_image'];
		$sImage=base_url('uploads/blog_images').'/'.$blog['blog_small_image'];
		unlink($lImage);
		unlink($sImage); 
		$this->blogmodel->delete_blog($id);
		redirect(base_url('admin/blog-list'));
	}
	public function delete_or_ac_inac_multi_blog()
	{

		//pre($this->input->post(),1);
		
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->blogmodel->getBlogById($id);
				$lImage=base_url('uploads/blog_images').'/'.$blog['blog_large_image'];
				$sImage=base_url('uploads/blog_images').'/'.$blog['blog_small_image'];
				delete_files($lImage);
				delete_files($sImage);
				$this->blogmodel->delete_blog($id);
			}
			redirect(base_url('admin/blog-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->blogmodel->getBlogById($id);
				$data['is_active']='active';
				$this->blogmodel->change_blog_status($id,$data);
			}
			redirect(base_url('admin/blog-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$blog=$this->blogmodel->getBlogById($id);
				$data['is_active']='inactive';
				$this->blogmodel->change_blog_status($id,$data);
			}
			redirect(base_url('admin/blog-list'));
		}
		else
		{
			redirect(base_url('admin/blog-list'));		
		}

		// $this->load->helper('file');
		// $blog=$this->blogmodel->getBlogById($id);
		// /* $lImage='./uploads/blog_images/'.$blog['blog_large_image'];
		// $sImage='./uploads/blog_images/'.$blog['blog_small_image']; */
		// $lImage=base_url('uploads/blog_images').'/'.$blog['blog_large_image'];
		// $sImage=base_url('uploads/blog_images').'/'.$blog['blog_small_image'];
		// unlink($lImage);
		// unlink($sImage); 
		// $this->blogmodel->delete_blog($id);
		// redirect(base_url('admin/blog-list'));
	}
	public function delete_or_ac_inac_multi_sub_cat(){

		//pre($this->input->post(),1);
		
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->blogmodel->delete_blog_sub_category($id);
			}
			redirect(base_url('admin/blog-sub-category'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->blogmodel->change_blog_sub_category_status($id,$data);
			}
			redirect(base_url('admin/blog-sub-category'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->blogmodel->change_blog_sub_category_status($id,$data);
			}
			redirect(base_url('admin/blog-sub-category'));
		}
		else
		{
			redirect(base_url('admin/blog-sub-category'));		
		}
	}
	
	public function delete_or_ac_inac_multi_cat(){

		//pre($this->input->post(),1);
		
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->blogmodel->delete_blog_category($id);
			}
			redirect(base_url('admin/blog-category'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->blogmodel->change_blog_category_status($id,$data);
			}
			redirect(base_url('admin/blog-category'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->blogmodel->change_blog_category_status($id,$data);
			}
			redirect(base_url('admin/blog-category'));
		}
		else
		{
			redirect(base_url('admin/blog-sub-category'));		
		}
	}

	public function upload_image($fileName,$uploadPath){
		//Check whether user upload picture
		
            if(!empty($fileName)){
				
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = time().$fileName;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('inputImage')){
                    $uploadData = $this->upload->data();
                    $picture = $config['file_name'];
                }else{
					 $error = array('error' => $this->upload->display_errors());
					 print_r($error);
					 die;
                    $picture = '';
                }
            }else{
                $picture = '';
            }
			return $picture;
	}
	public function changeBlogCategoryStatus($id){
		$page=$this->blogmodel->getBlogCategoryById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->blogmodel->change_blog_category_status($id,$data);
		echo ucwords($data['is_active']);
		//redirect(base_url('admin/blog-category'));
	}
	public function changeBlogSubCategoryStatus($id){
		$page=$this->blogmodel->getBlogSubCategoryById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->blogmodel->change_blog_sub_category_status($id,$data);
		redirect(base_url('admin/blog-sub-category'));
	}
	public function deleteBlogCategory($id){
		$this->blogmodel->delete_blog_category($id);
		redirect(base_url('admin/blog-category'));
	}
	public function deleteBlogSubCategory($id){
		$this->blogmodel->delete_blog_sub_category($id);
		redirect(base_url('admin/blog-sub-category'));
	}
	
	public function editBlogSubCategory($id){
		$data=array();
		$data['blogCategoryList']=$this->blogmodel->getParentCategoryList();
		//pre($data['blogCategoryList'],1);
		$data['blogCategory']=$this->blogmodel->getBlogSubCategoryById($id);
		$this->template->load('adminTemplate','admin/editblogsubcategory',$data);
	}
	public function updateBlogSubCategory($id)
	{
		$data['category_name']=$this->input->post('inputName');
		$data['category_url']=$this->input->post('inputUrl');
		$data['cat_id']=$this->input->post('inputParent');
		$data['ip_address']=getenv('REMOTE_ADDR');
		$this->blogmodel->updateblogSubCategoryData($id,$data);
		redirect(base_url('admin/blog-sub-category'));
	}
	public function updateBlogMeta($id){
		$data=array();
		$data['blog']=$this->blogmodel->get_meta_by_id($id);
		$data['blogs']=$this->blogmodel->getblogById($id);
		if(($this->input->post('metaUpdateId')) && $this->input->post('metaUpdateId') > 0){
			$dataMeta['blog_title']=trim($this->input->post('inputTitle'));
			$dataMeta['meta_description']=trim($this->input->post('inputMetaDesc'));
			$dataMeta['meta_keyword']=trim($this->input->post('inputMetaKeyWord'));
			$dataMeta['meta_robot']=trim($this->input->post('inputMetaRobot'));
			$dataMeta['meta_revisit_after']=trim($this->input->post('inputRevisitAfter'));
			$dataMeta['canonical_link']=trim($this->input->post('inputCanonicalLink'));
			$dataMeta['og_locale']=trim($this->input->post('inputOglocale'));
			$dataMeta['og_type']=trim($this->input->post('inputOgType'));
			$dataMeta['og_image']=trim($this->input->post('inputOgImage'));
			$dataMeta['og_title']=trim($this->input->post('inputOgTitle'));
			$dataMeta['og_description']=trim($this->input->post('inputOgDescription'));
			$dataMeta['og_url']=trim($this->input->post('inputOgUrl'));
			$dataMeta['og_site_name']=trim($this->input->post('inputOgSiteName'));
			$dataMeta['extraheadcode']=trim($this->input->post('inputExtraHeadCode'));
			$this->blogmodel->update_blog_meta($id,$dataMeta);
			$this->session->set_flashdata('msg','Meta information updated successfully');
			redirect(base_url('admin/blog-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/blog_meta',$data);
		}
	}
	public function getMetaDetails($blogId=false) 
	{
		$metaString = "";
		$blogId = 10;
		 if($blogId){
		 		$metaVal =  $this->blogmodel->get_meta_by_id($blogId);

					if($metaVal['page_title'])
						 $metaString = $metaString."<title>".$metaVal['page_title']."</title>".PHP_EOL;

					if( $metaVal['meta_description'])
						$metaString = $metaString.'<meta name="description" content="'.$metaVal["meta_description"].'" />'.PHP_EOL;
						
					if( $metaVal['blog_title'])
						$metaString = $metaString.'<meta name="title" content="'.$metaVal["blog_title"].'" />'.PHP_EOL;

					if( $metaVal['meta_keyword'])
						$metaString = $metaString.'<meta name="keywords" content="'.$metaVal['meta_keyword'].'" />'.PHP_EOL;
					if( $metaVal['meta_robot'])
						$metaString = $metaString.'<meta name="robots" content="'.$metaVal['meta_robot'].'" />'.PHP_EOL;
					if( $metaVal['meta_revisit_after'])
						$metaString = $metaString.'<meta name="revisit-after" content="'.$metaVal['meta_revisit_after'].'" />'.PHP_EOL;
					if( $metaVal['canonical_link'])
						$metaString = $metaString.'<link rel="canonical" href="'.$metaVal['canonical_link'].'"/>'.PHP_EOL;
					if( $metaVal['og_locale'])
						$metaString = $metaString.'<meta property="og:locale" content="'.$metaVal['og_locale'].'" />'.PHP_EOL;
					if( $metaVal['og_type'])
						$metaString = $metaString.'<meta property="og:type" content="'.$metaVal['og_type'].'"/>'.PHP_EOL;
					if( $metaVal['og_image'])
						$metaString = $metaString.'<meta property="og:image" content="'.$metaVal['og_image'].'" />'.PHP_EOL;
					if( $metaVal['og_title'])
						$metaString = $metaString.'<meta property="og:title" content="'.$metaVal['og_title'].'"  />'.PHP_EOL;
					if( $metaVal['og_description'])
						$metaString = $metaString.'<meta property="og:description" content="'.$metaVal['og_description'].'" />'.PHP_EOL;
					if($metaVal['og_url'])
						$metaString = $metaString.'<meta property="og:url" content="'.$metaVal['og_url'].'"/>'.PHP_EOL;
					if( $metaVal['og_site_name'])
						$metaString = $metaString.'<meta property="og:site_name" content="'.$metaVal['og_site_name'].'" />'.PHP_EOL;

					if( $metaVal['msvalidate'])
						$metaString = $metaString.'<meta name="p:domain_verify" content="'.$metaVal['msvalidate'].'" />'.PHP_EOL;

					if( $metaVal['p_domain_verify'])
						$metaString = $metaString.'<meta name="p:domain_verify" content="'.$metaVal['p_domain_verify'].'"/>'.PHP_EOL;

					if( $metaVal['icbm'])
						$metaString = $metaString.'<meta name="ICBM" content="'.$metaVal['icbm'].'" />'.PHP_EOL;

					if( $metaVal['alexaverifyid'])
						$metaString = $metaString.'<meta name="alexaVerifyID" content="'.$metaVal['alexaverifyid'].'"/>'.PHP_EOL;

					if( $metaVal['dc_title'])
						$metaString = $metaString.'<meta name="DC.title" content="'.$metaVal['dc_title'].'" />'.PHP_EOL;

					if( $metaVal['geo_region'])
						$metaString = $metaString.'<meta name="geo.region" content="'.$metaVal['geo_region'].'" />'.PHP_EOL;

					if( $metaVal['geo_placename'])
						$metaString = $metaString.'<meta name="geo.placename" content="'.$metaVal['geo_placename'].'" />'.PHP_EOL;

					if( $metaVal['geo_position'])
						$metaString =$metaString. '<meta name="geo.position" content="'.$metaVal['geo_position'].'" />'.PHP_EOL;

					if( $metaVal['place_location_latitude'])
						$metaString =$metaString. '<meta property="place:location:latitude" content="'.$metaVal['place_location_latitude'].'" />'.PHP_EOL;

					if( $metaVal['place_location_longitude'])
						$metaString =$metaString. '<meta property="place:location:longitude" content="'.$metaVal['place_location_longitude'].'" />'.PHP_EOL;

					if( $metaVal['business_contact_street_address'])
						$metaString =$metaString. '<meta property="business:contact_data:street_address" content="'.$metaVal['business_contact_street_address'].'" />'.PHP_EOL;

					if( $metaVal['business_contact_locality'])
						$metaString =$metaString. '<meta property="business:contact_data:locality" content="'.$metaVal['business_contact_locality'].'" />'.PHP_EOL ;

					if( $metaVal['business_contact_postal_code'])
						$metaString =$metaString. '<meta property="business:contact_data:postal_code" content="'.$metaVal['business_contact_postal_code'].'" />'.PHP_EOL;

					if( $metaVal['business_contact_country_name'])
						$metaString =$metaString. '<meta property="business:contact_data:country_name" content="'.$metaVal['business_contact_country_name'].'" />'.PHP_EOL;

					if( $metaVal['business_contact_email'])
						$metaString =$metaString. '<meta property="business:contact_data:email" content="'.$metaVal['business_contact_email'].'" />'.PHP_EOL;

					if( $metaVal['business_contact_phone_number'])
						$metaString =$metaString. '<meta property="business:contact_data:phone_number" content="'.$metaVal['business_contact_phone_number'].'" />'.PHP_EOL;

					if( $metaVal['business_contact_website'])
						$metaString =$metaString. '<meta property="business:contact_data:website" content="'.$metaVal['business_contact_website'].'" />'.PHP_EOL;

					if( $metaVal['twitter_card'])
						$metaString =$metaString. '<meta name="twitter:card" content="'.$metaVal['twitter_card'].'" />'.PHP_EOL;

					if( $metaVal['twitter_description'])
						$metaString =$metaString. '<meta name="twitter:description" content="'.$metaVal['twitter_description'].'" />'.PHP_EOL;

					if( $metaVal['twitter_title'])
						$metaString =$metaString. '<meta name="twitter:title" content="'.$metaVal['twitter_title'].'" />'.PHP_EOL;

					if( $metaVal['twitter_site'])
						$metaString =$metaString. '<meta name="twitter:site" content="'.$metaVal['twitter_site'].'" />'.PHP_EOL;

					if( $metaVal['twitter_image'])
						$metaString =$metaString. '<meta name="twitter:image" content="'.$metaVal['twitter_image'].'" />'.PHP_EOL;

					if($metaVal['twitter_creator'])
						$metaString =$metaString. '<meta name="twitter:creator" content="'.$metaVal['twitter_creator'].'" />'.PHP_EOL;
 					if( $metaVal['extraheadcode'])
						$metaString = $metaString.$metaVal['extraheadcode'];
 				return stripslashes($metaString);
		 }else{
		 	return $metaString;
		 }
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
	

	/******************* C O M P A N Y *****************/

	public function companyList(){
		$data=array();
		$data['companyList']=$this->companymodel->getCompanyList();
		$this->template->load('adminTemplate','admin/companylist',$data);
	}
	public function addCompany(){
		$data=array();
		if($this->input->post('companyAdd') && $this->input->post('companyAdd')==1){
			//echo "hhh";
			$dataSave['name']=$this->input->post('inputCompanyTitle');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_active']='active';
			$this->companymodel->saveCompany($dataSave);
			redirect(base_url('admin/company-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/addcompany',$data);
		}
	}
	public function updateCompany($id){
		$data=array();
		$data['company']=$this->companymodel->getCompanyById($id);
		if($this->input->post('editCompany')){
			$dataSave['name']=$this->input->post('inputCompanyTitle');
			$this->companymodel->update_company($id,$dataSave);
			redirect(base_url('admin/company-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/editcompany',$data);
		}
	}
	public function changeCompanyStatus($id){
		$page=$this->companymodel->getCompanyById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->companymodel->change_company_status($id,$data);
		redirect(base_url('admin/company-list'));
	}
	public function delete_or_ac_inac_multi_company(){
		//pre($this->input->post(),1);
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->companymodel->delete_company($id);
			}
			redirect(base_url('admin/company-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->companymodel->change_company_status($id,$data);
			}
			redirect(base_url('admin/company-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->companymodel->change_company_status($id,$data);
			}
			redirect(base_url('admin/company-list'));
		}
		else
		{
			redirect(base_url('admin/company-list'));		
		}
	}
	public function deleteCompany($id){
		$this->companymodel->delete_company($id);
		redirect(base_url('admin/card-list'));
	}

	/******************* T A G S *****************/

	public function tags(){
		$data=array();
		$ajax = $this->input->post('ajax');
		if($ajax == "on")
		{
			$data['tagsList']=$this->blogmodel->getTagList();
			echo json_encode($data['tagsList']);
		}
		else
		{
			$data['tagsList']=$this->blogmodel->getTagList();
			$this->template->load('adminTemplate','admin/taglist',$data);
		}
	}
	public function addTags(){
		$ajax = $this->input->post('ajax');
		$data = [];
		if($ajax == "on") {
			$result['taglist'] = $this->blogmodel->addTags();
			echo json_encode($result['taglist']);
		}
		else 
		{
			$this->blogmodel->addTags(); 
			redirect('admin/tags');
		}
	}
	public function deleteTags($id){
		$ajax = $this->input->post('ajax');
		$result = $this->blogmodel->delete_tag($id);
		if($ajax == "on")
		{
			if($result) echo "true";
		}
		else
		{
			if($result) redirect(base_url('admin/tags'));
		}
		
	}
	public function editTags($id){
		$data = [];
		if($this->blogmodel->editTags($id)) echo true;
	}

	/******************* C O M M E N T S *****************/

	public function commentList(){
		$data=array();
		$data['commentList']=$this->blogmodel->getCommentList();
		//pre($data,1);
		$this->template->load('adminTemplate','admin/commentlist',$data);
	}
	public function updateComment($id=''){
		//echo "test";
		//print_r($_POST);
		//exit;
		
		$data=array();
		$data['userList']=$this->adminmodel->userList();
		$data['comment']=$this->blogmodel->getCommentById($id);
		//pre($data['blogCategoryList'],1);
		if($this->input->post('editComment') && $this->input->post('editComment')==1){
			//$dataSave['blog_category_id']=$this->input->post('inputBlogCategory');
			$dataSave['title']=$this->input->post('title');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_approved']= $this->input->post('is_approved');
			
			//print_r($dataSave);die;
			//pre($dataSave,1);
			$result = $this->blogmodel->updateComment($dataSave,$id);
			if($result) redirect(base_url('admin/comment-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/editcomment',$data);
		}
	}
	public function deleteComment($id){
		$this->blogmodel->deleteComment($id);
		redirect(base_url('admin/comment-list'));
	}
	public function changeCommentStatus(){
		$result = $this->blogmodel->change_comment_status();
		if($result) echo true;
	}
	public function delete_or_ac_inac_multi_comment(){
		//pre($this->input->post(),1);
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->blogmodel->deleteComment($id);
			}
			redirect(base_url('admin/comment-list'));
		}
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="pending"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_approved']='0';
				$this->blogmodel->change_comment_status($id,$data);
			}
			redirect(base_url('admin/comment-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="approve"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_approved']='1';
				$this->blogmodel->change_comment_status($id,$data);
			}
			redirect(base_url('admin/comment-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="unapprove"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_approved']='2';
				$this->blogmodel->change_comment_status($id,$data);
			}
			redirect(base_url('admin/comment-list'));
		}
		else
		{
			redirect(base_url('admin/comment-list'));		
		}
	}

	/******* M A S T E R   C A S H B A C K  P O R T A L ***********/

	public function masterCashBackPortalList(){
		$data=array();
		$data['masterCashBackPortalList']=$this->couponmodel->getmasterCashBackPortalList();
		$this->template->load('adminTemplate','admin/mastercashbackportallist',$data);
	}
	public function addmasterCashBackPortal(){
		$data=array();
		if($this->input->post('masterCashBackPortal') && $this->input->post('masterCashBackPortal')==1){
			//echo "hhh";
			$dataSave['name']=$this->input->post('inputmasterCashBackPortal');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_active']='active';
			$this->couponmodel->savemasterCashBackPortal($dataSave);
			redirect(base_url('admin/master-cashback-portal-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/addmastercashbackportal',$data);
		}
	}
	public function updatemasterCashBackPortal($id){
		$data=array();
		$data['masterCashBackPortal']=$this->couponmodel->getmasterCashBackPortalById($id);
		if($this->input->post('masterCashBackPortal')){
			$dataSave['name']=$this->input->post('inputmasterCashBackPortal');
			$this->couponmodel->update_masterCashBackPortal($id,$dataSave);
			redirect(base_url('admin/master-cashback-portal-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/editmastercashbackportal',$data);
		}
	}
	public function deletemasterCashBackPortal($id){
		$this->couponmodel->delete_masterCashBackPortal($id);
		redirect(base_url('admin/master-cashback-portal-list'));
	}
	public function changemasterCashBackPortalStatus($id){
		$page=$this->couponmodel->getmasterCashBackPortalById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->couponmodel->change_masterCashBackPortal_status($id,$data);
		redirect(base_url('admin/master-cashback-portal-list'));
	}
	public function delete_or_ac_inac_multi_masterCashBackPortal(){
		//pre($this->input->post(),1);
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->couponmodel->delete_masterCashBackPortal($id);
			}
			redirect(base_url('admin/master-cashback-portal-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->couponmodel->change_masterCashBackPortal_status($id,$data);
			}
			redirect(base_url('admin/master-cashback-portal-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->couponmodel->change_masterCashBackPortal_status($id,$data);
			}
			redirect(base_url('admin/master-cashback-portal-list'));
		}
		else
		{
			redirect(base_url('admin/master-cashback-portal-list'));
		}
	}

	/******* M A S T E R   C A S H B A C K  T Y P E ***********/

	public function masterCashBackTypeList(){
		$data=array();
		$data['masterCashBackTypeList']=$this->couponmodel->getmasterCashBackTypeList();
		$this->template->load('adminTemplate','admin/mastercashbacktypelist',$data);
	}
	public function addmasterCashBackType(){
		$data=array();
		if($this->input->post('masterCashBackType') && $this->input->post('masterCashBackType')==1){
			//echo "hhh";
			$dataSave['name']=$this->input->post('inputmasterCashBackType');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_active']='active';
			$this->couponmodel->savemasterCashBackType($dataSave);
			redirect(base_url('admin/master-cashback-type-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/addmastercashbacktype',$data);
		}
	}
	public function updatemasterCashBackType($id){
		$data=array();
		$data['masterCashBackType']=$this->couponmodel->getmasterCashBackTypeById($id);
		if($this->input->post('masterCashBackType')){
			$dataSave['name']=$this->input->post('inputmasterCashBackType');
			$this->couponmodel->update_masterCashBackType($id,$dataSave);
			redirect(base_url('admin/master-cashback-type-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/editmastercashbacktype',$data);
		}
	}
	public function deletemasterCashBackType($id){
		$this->couponmodel->delete_masterCashBackType($id);
		redirect(base_url('admin/master-cashback-type-list'));
	}
	public function changemasterCashBackTypeStatus($id){
		$page=$this->couponmodel->getmasterCashBackTypeById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->couponmodel->change_masterCashBackType_status($id,$data);
		redirect(base_url('admin/master-cashback-type-list'));
	}
	public function delete_or_ac_inac_multi_masterCashBackType(){
		//pre($this->input->post(),1);
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->couponmodel->delete_masterCashBackType($id);
			}
			redirect(base_url('admin/master-cashback-type-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->couponmodel->change_masterCashBackType_status($id,$data);
			}
			redirect(base_url('admin/master-cashback-type-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->couponmodel->change_masterCashBackType_status($id,$data);
			}
			redirect(base_url('admin/master-cashback-type-list'));
		}
		else
		{
			redirect(base_url('admin/master-cashback-type-list'));
		}
	}
	
	/*********** M A S T E R   S T O R E ******************/

	public function masterStoreList(){
		$data=array();
		$data['masterStoreList']=$this->couponmodel->getmasterStoreList();
		$this->template->load('adminTemplate','admin/masterstorelist',$data);
	}
	public function addmasterStore(){
		$data=array();
		if($this->input->post('masterStore') && $this->input->post('masterStore')==1){
			//echo "hhh";
			$dataSave['name']=$this->input->post('inputmasterStore');
			$dataSave['url']=$this->input->post('inputmasterStoreUrl');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_active']='active';
			$this->couponmodel->savemasterStore($dataSave);
			redirect(base_url('admin/master-store-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/addmasterstore',$data);
		}
	}
	public function updatemasterStore($id){
		$data=array();
		$data['masterStore']=$this->couponmodel->getmasterStoreById($id);
		if($this->input->post('masterStore')){
			$dataSave['name']=$this->input->post('inputmasterStore');
			$dataSave['url']=$this->input->post('inputmasterStoreUrl');
			$this->couponmodel->update_masterStore($id,$dataSave);
			redirect(base_url('admin/master-store-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/editmasterstore',$data);
		}
	}
	public function deletemasterStore($id){
		$this->couponmodel->delete_masterStore($id);
		redirect(base_url('admin/master-store-list'));
	}
	public function changemasterStoreStatus($id){
		$page=$this->couponmodel->getmasterStoreById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->couponmodel->change_masterStore_status($id,$data);
		redirect(base_url('admin/master-store-list'));
	}
	public function delete_or_ac_inac_multi_masterStore(){
		//pre($this->input->post(),1);
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->couponmodel->delete_masterStore($id);
			}
			redirect(base_url('admin/master-store-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->couponmodel->change_masterStore_status($id,$data);
			}
			redirect(base_url('admin/master-store-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->couponmodel->change_masterStore_status($id,$data);
			}
			redirect(base_url('admin/master-store-list'));
		}
		else
		{
			redirect(base_url('admin/master-store-list'));
		}
	}


	/*********** C A S H B A C K ******************/

	public function cashbackList(){
		$data=array();
		$data['cashbackList']=$this->couponmodel->getcashbackList();
		$this->template->load('adminTemplate','admin/cashbacklist',$data);
	}
	public function addcashback(){
		$data=array();
		$data['masterCashBackPortalList']=$this->couponmodel->getmasterCashBackPortalList();
		$data['masterCashBackTypeList']=$this->couponmodel->getmasterCashBackTypeList();
		$data['masterStoreList']=$this->couponmodel->getmasterStoreList();
		if($this->input->post('cashback') && $this->input->post('cashback')==1){
			//echo "hhh";
			$dataSave['portal_id']=$this->input->post('inputPortal');
			$dataSave['cashback_type_id']=$this->input->post('inputPortalType');
			$dataSave['store_id']=$this->input->post('inputStore');
			$dataSave['base_rate']=$this->input->post('inputBaseRate');
			$dataSave['bonus_rate']=$this->input->post('inputBonusRate');
			$dataSave['rate_type']=$this->input->post('inputRateType');
			$dataSave['description']=$this->input->post('description');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_active']='active';
			//pre($dataSave,1);
			$this->couponmodel->saveCashback($dataSave);
			redirect(base_url('admin/cashback-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/addcashback',$data);
		}
	}
	public function updateCashback($id){
		$data=array();
		$data['masterCashBackPortalList']=$this->couponmodel->getmasterCashBackPortalList();
		$data['masterCashBackTypeList']=$this->couponmodel->getmasterCashBackTypeList();
		$data['masterStoreList']=$this->couponmodel->getmasterStoreList();
		$data['cashback']=$this->couponmodel->getCashbackById($id);
		if($this->input->post('cashback')){
			$dataSave['portal_id']=$this->input->post('inputPortal');
			$dataSave['cashback_type_id']=$this->input->post('inputPortalType');
			$dataSave['store_id']=$this->input->post('inputStore');
			$dataSave['base_rate']=$this->input->post('inputBaseRate');
			$dataSave['bonus_rate']=$this->input->post('inputBonusRate');
			$dataSave['rate_type']=$this->input->post('inputRateType');
			$dataSave['description']=$this->input->post('description');
			$dataSave['user_id']=$this->input->post('user_id');
			$dataSave['is_active']='active';
			//pre($dataSave,1);
			$this->couponmodel->update_Cashback($id,$dataSave);
			redirect(base_url('admin/cashback-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/editcashback',$data);
		}
	}
	public function deleteCashback($id){
		$this->couponmodel->delete_Cashback($id);
		redirect(base_url('admin/cashback-list'));
	}
	public function changeCashbackStatus($id){
		$page=$this->couponmodel->getCashbackById($id);
		if($page['is_active']=='active')
			$data['is_active']='inactive';
		else
			$data['is_active']='active';
		$this->couponmodel->change_cashback_status($id,$data);
		redirect(base_url('admin/cashback-list'));
	}
	public function delete_or_ac_inac_multi_Cashback(){
		//pre($this->input->post(),1);
		if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="delete"))
		{
			$this->load->helper('file');
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$this->couponmodel->delete_Cashback($id);
			}
			redirect(base_url('admin/cashback-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$this->couponmodel->change_Cashback_status($id,$data);
			}
			redirect(base_url('admin/cashback-list'));
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$this->couponmodel->change_Cashback_status($id,$data);
			}
			redirect(base_url('admin/cashback-list'));
		}
		else
		{
			redirect(base_url('admin/cashback-list'));
		}
	}

	/******************* U S E R S *****************/

	public function userList(){
		$data=array();
		$data['userList']=$this->usermodel->getUserList();
		$this->template->load('adminTemplate','admin/userlist',$data);
	}
	public function addUser(){
		$data=array();
		if($this->input->post('userAdd') && $this->input->post('userAdd')==1){
			//echo "hhh";
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['email']=$this->input->post('inputEmail');
			$dataSave['phone']=$this->input->post('inputPhone');
			$dataSave['password']= md5($this->input->post('inputPassword'));
			$dataSave['is_admin']= $this->input->post('is_admin');
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
			$dataSave['is_active']='active';
			$this->usermodel->userRegister($dataSave);
			redirect(base_url('admin/user-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/adduser',$data);
		}
	}
	public function updateUser($id){
		$data=array();
		$data['user']=$this->usermodel->getUserById($id);
		if($this->input->post('userEdit')){
			$dataSave['name']=$this->input->post('inputName');
			$dataSave['email']=$this->input->post('inputEmail');
			$dataSave['phone']=$this->input->post('inputPhone');
			$dataSave['password']= md5($this->input->post('inputPassword'));
			$dataSave['is_admin']= $this->input->post('is_admin');
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
			$dataSave['is_active']='active';
			$this->usermodel->update_user($id,$dataSave);
			redirect(base_url('admin/user-list'));
		}
		else{
			$this->template->load('adminTemplate','admin/edituser',$data);
		}
	}
	public function changeUserStatus($id=''){
		$result = $this->usermodel->change_user_status();
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
				$result = $this->usermodel->delete_user($id);

			}
			
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="active"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='active';
				$result = $this->usermodel->change_user_status($id,$data);
			}
			
		}
		else if(!empty($this->input->post('mmursp_id')) && $this->input->post('mmursp_id')!="" && (!empty($this->input->post('mmursp_select_action_top')) && $this->input->post('mmursp_select_action_top')=="inactive"))
		{
			$id_array=explode(",",$this->input->post('mmursp_id'));
			foreach($id_array as $id)
			{
				$id = intval($id);
				$data['is_active']='inactive';
				$result = $this->usermodel->change_user_status($id,$data);
			}
			
		}
		if($result) echo true;
	}
	public function deleteUser($id){
		$result = $this->usermodel->delete_user($id);
		if($result) echo true;
	}
	public function userChangePassword()
	{
		$result = $this->usermodel->change_password();
		if($result) echo true;
	}
	
}