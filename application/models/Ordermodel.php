<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ordermodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	/******************* O R D E R S *********************/

	public function getOrderList($api_call='',$search_key='',$start='', $limit='',$customer_id=''){
		$this->db->select('order.*,users.name AS customer_name,customer_address.address AS customer_address');
		$this->db->from('order');
		$this->db->join('users','users.id=order.customer_id');
		$this->db->join('customer_address','customer_address.id=order.address_id');
		if(!empty($search_key)) {
			if(!empty($search_key['customer_id'])){
				$this->db->like('users.id',$search_key['customer_id']);
			}
			if(!empty($search_key['order_status'])){
				$this->db->like('order.status',$search_key['order_status']);
			}
			if(!empty($search_key['payment_type'])){
				$this->db->like('order.payment_type',$search_key['payment_type']);
			}
			if(!empty($search_key['order_no'])){
				$this->db->like('order.order_no',$search_key['order_no']);
			}
			if(!empty($search_key['txn_id'])){
				$this->db->like('order.txn_id',$search_key['txn_id']);
			}
			if(!empty($search_key['paid_status'])){
				$this->db->like('order.is_paid',$search_key['paid_status']);
			}
		}
		$this->db->where('users.user_type','3');
		$this->db->where('order.is_deleted','0');
		if($customer_id!='') $this->db->where('order.customer_id',$customer_id);
		$this->db->order_by('order.id', 'desc');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($this->db->last_query(),1);
		if($res->result_array()){
			foreach ($res->result_array() as $key => $value) {
				$result[$key]['id'] = $value['id'];
				$result[$key]['total_price'] = $value['total_price'];
				$result[$key]['is_paid'] = $value['is_paid'];
				$result[$key]['order_no'] = $value['order_no'];
				$result[$key]['txn_id'] = $value['txn_id'];
				$result[$key]['address_id'] = $value['address_id'];
				$result[$key]['customer_id'] = $value['customer_id'];
				$result[$key]['payment_type'] = $value['payment_type'];
				$result[$key]['date_created'] = $value['date_created'];
				$result[$key]['bank_txn_id'] = $value['bank_txn_id'];
				$result[$key]['status'] = $value['status'];
				$result[$key]['customer_name'] = $value['customer_name'];
				$result[$key]['bank_txn_id'] = $value['bank_txn_id'];
				$result[$key]['customer_address'] = $value['customer_address'];
				$this->db->select('order_details.*,packages.name AS package_name');
				$this->db->from('order_details');
				$this->db->join('packages','packages.id=order_details.package_id');
				$this->db->where('order_details.order_id',$value['id']);
				$this->db->order_by('order_details.id', 'desc');
				$res1=$this->db->get();
				//$result[$key]['order_details'] = $res->result_array();
				if($res1->num_rows()>0){
					foreach ($res1->result_array() as $key_o => $value_o) {
						$result[$key]['order_details'][$key_o]['id'] = $value_o['id'];
						$result[$key]['order_details'][$key_o]['package_id'] = $value_o['package_id'];
						$result[$key]['order_details'][$key_o]['quantity'] = $value_o['quantity'];
						$result[$key]['order_details'][$key_o]['unit_price'] = $value_o['unit_price'];
						$result[$key]['order_details'][$key_o]['IGST'] = $value_o['IGST'];
						$result[$key]['order_details'][$key_o]['CGST'] = $value_o['CGST'];
						$result[$key]['order_details'][$key_o]['GST'] = $value_o['GST'];
						$result[$key]['order_details'][$key_o]['total_cost'] = $value_o['total_cost'];
						$result[$key]['order_details'][$key_o]['package_name'] = $value_o['package_name'];
						$this->db->select('AVG(package_rating.rating) AS avg_rating');
			   			$this->db->from('package_rating');
			   			$this->db->where('package_rating.package_id',$value_o['package_id']);
			   			$res4=$this->db->get();
			   			$result[$key]['order_details'][$key_o]['avg_rating'] =  round($res4->row_array()['avg_rating']);
					}
				}
			}
		}else{
			$result = [];
		}
		//pre($this->db->last_query(),1);
		//pre($res->result_array(),1);
		return $result;
	}
	public function getOrderById($id){
		$this->db->select('order.*,
			users.name AS customer_name,
			CONCAT(ca.address," ,",ca.pincode,",",ms.state_name) AS customer_full_address,ca.address AS customer_address
			');
		$this->db->from('order');
		$this->db->join('users','users.id=order.customer_id');
		$this->db->join('customer_address AS ca','ca.id=order.address_id');
		$this->db->join('master_state AS ms','ms.id=ca.state_id');
		$this->db->where('users.user_type','3');
		$this->db->where('order.is_deleted','0');
		$this->db->where('order.id',$id);
		$res=$this->db->get();
		if($res->row_array())
		{
			$temp = $res->row_array();
			$result['id'] = $temp['id'];
			$result['total_price'] = $temp['total_price'];
			$result['is_paid'] = $temp['is_paid'];
			$result['order_no'] = $temp['order_no'];
			$result['txn_id'] = $temp['txn_id'];
			$result['address_id'] = $temp['address_id'];
			$result['customer_id'] = $temp['customer_id'];
			$result['payment_type'] = $temp['payment_type'];
			$result['date_created'] = $temp['date_created'];
			$result['bank_txn_id'] = $temp['bank_txn_id'];
			$result['checksumhash'] = $temp['checksumhash'];
			$result['status'] = $temp['status'];
			$result['customer_name'] = $temp['customer_name'];
			$result['bank_txn_id'] = $temp['bank_txn_id'];
			$result['txn_status'] = $temp['txn_status'];
			$result['paytm_response'] = $temp['paytm_response'];
			$result['customer_address'] = $temp['customer_address'];
			$this->db->select('order_details.*,packages.name AS package_name');
			$this->db->from('order_details');
			$this->db->join('packages','packages.id=order_details.package_id');
			$this->db->where('order_details.order_id',$temp['id']);
			$this->db->order_by('order_details.id', 'desc');
			$res1=$this->db->get();
			//$result['order_details'] = $res1->result_array();
			if($res1->num_rows()>0){
				foreach ($res1->result_array() as $key => $value) {
					$result['order_details'][$key]['id'] = $value['id'];
					$result['order_details'][$key]['package_id'] = $value['package_id'];
					$result['order_details'][$key]['quantity'] = $value['quantity'];
					$result['order_details'][$key]['unit_price'] = $value['unit_price'];
					$result['order_details'][$key]['IGST'] = $value['IGST'];
					$result['order_details'][$key]['CGST'] = $value['CGST'];
					$result['order_details'][$key]['GST'] = $value['GST'];
					$result['order_details'][$key]['total_cost'] = $value['total_cost'];
					$result['order_details'][$key]['package_name'] = $value['package_name'];
					$this->db->select('AVG(package_rating.rating) AS avg_rating');
		   			$this->db->from('package_rating');
		   			$this->db->where('package_rating.package_id',$value['package_id']);
		   			$res4=$this->db->get();
		   			$result['order_details'][$key]['avg_rating'] =  round($res4->row_array()['avg_rating']);
				}
			}
		}
		//pre($this->db->last_query(),1);
		//pre($res->result_array(),1);
		return $result;
	}	
	// public function getLocationIdByName($loc_name){
	// 	$this->db->select('*');
	// 	$this->db->from('order');
	// 	$this->db->where('order.is_deleted','0');
	// 	$this->db->where('order.name',$loc_name);
	// 	$res=$this->db->get();
	// 	return $res->row_array();
	// }
	public function change_order_status($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('order',$data);
	}
	public function saveOrder($api_call='',$data){
		$message = $order_data = $result_data = [];
		$order_config_details = getOrderConfigDetails('web',$data['customer_email'],$data['total_price']);
		//pre($order_config_details,1);
		//pre($data,1);
		
		$order_data['total_price'] = $data['total_price'];
		$order_data['address_id'] = $data['address_id'];
		$order_data['customer_id'] = $data['customer_id'];
		$order_data['payment_type'] = $data['payment_type'];
		$order_data['order_no'] = $order_config_details['ORDER_ID'];
		$order_data['checksumhash'] =  $order_config_details['CHEKSUMHASH'];

		$result = $this->db->insert('order',$order_data);
		$last_insert_id = $this->db->insert_id();

		if($result){
			if($api_call == 'yes'){
				$message['status'] = TRUE;
				if(!empty($data['order_details'])){
					foreach ($data['order_details'] as $key => $value) {
						$data['order_details'][$key]['order_id'] = $last_insert_id;
						$data['order_details'][$key]['total_cost'] = ($data['order_details'][$key]['unit_price'] * $data['order_details'][$key]['quantity']);
					}
				}
				//pre($data,1);
				$result = $this->db->insert_batch('order_details',$data['order_details']);

				if($result){
					$this->db->select('order.*,
						users.name AS customer_name,
						CONCAT(ca.address," ,",ca.pincode,",",ms.state_name) AS customer_full_address
						');
					$this->db->from('order');
					$this->db->join('users','users.id=order.customer_id');
					$this->db->join('customer_address AS ca','ca.id=order.address_id');
					$this->db->join('master_state AS ms','ms.id=ca.state_id');
					//$this->db->where('users.user_type','3');
					$this->db->where('order.is_deleted','0');
					$this->db->where('order.id',$last_insert_id);
					$res=$this->db->get();
					if($res->row_array()){
						$rest = $res->row_array();

						
						$result_data['id'] = $rest['id'];
						$result_data['total_price'] = $rest['total_price'];
						$result_data['is_paid'] = $rest['is_paid'];
						$result_data['order_no'] = $rest['order_no'];
						$result_data['txn_id'] = $rest['txn_id'];
						$result_data['checksumhash'] = $rest['checksumhash'];
						$result_data['address_id'] = $rest['address_id'];
						$result_data['customer_full_address'] = $rest['customer_full_address'];
						
						$result_data['customer_id'] = $rest['customer_id'];
						$result_data['customer_name'] = $rest['customer_name'];
						$result_data['payment_type'] = $rest['payment_type'];
						$result_data['date_created'] = $rest['date_created'];
						//pre($result_data);
						$this->db->select('*');
						$this->db->from('order_details');
						$this->db->where('order_details.order_id',$last_insert_id);
						$res=$this->db->get();
						$result_data['order_details'] = $res->result_array();
						$message['message'] = $result_data;
						return $message;
					}
					
				}
					
			}
			else{
				return $result;
			}
		}
	}
	public function updateOrder($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('order',$data);
	}
	public function deleteOrder($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		$result = $this->db->update('order',$data);
		if($result){
			$this->db->where('order_id',$id);
			$result = $this->db->update('order_details',$data);
		}
		return $result;
	}
	public function updateOrderByOrderNo($data){
		$this->db->where('order_no',$data['order_no']);
		return $this->db->update('order',$data);
	}

	/*********** C U S T O M E R S ************/

	public function getAddressList($start='', $limit=''){
		$data = [];
		$this->db->select('customer_address.*,
			CONCAT(customer_address.address," ,",customer_address.pincode,",",ms.state_name) AS customer_full_address,users.name AS customer_name,ms.state_name AS state_name');
		$this->db->from('customer_address');
		$this->db->join('master_state AS ms','ms.id=customer_address.state_id');
		$this->db->join('users','users.id=customer_address.customer_id');
		$this->db->where('customer_address.is_deleted','0');
		$this->db->order_by('customer_address.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function getAddressByID($id){
		$data = [];
		$this->db->select('customer_address.*,
			CONCAT(customer_address.address," ,",customer_address.pincode,",",ms.state_name) AS customer_full_address,users.name AS customer_name,ms.state_name AS state_name');
		$this->db->from('customer_address');
		$this->db->join('master_state AS ms','ms.id=customer_address.customer_id');
		$this->db->join('users','users.id=customer_address.customer_id');
		$this->db->where('customer_address.id',$id);
		$res=$this->db->get();
		return $res->row_array();
	}
	// public function getCountryById($id){
	// 	$data = [];
	// 	$this->db->select('master_country.*');
	// 	$this->db->from('master_country');
	// 	$this->db->where('master_country.is_deleted','0');
	// 	$this->db->where('master_country.id', $id);
	// 	$res=$this->db->get();
	// 	return $res->row_array();
	// }
	public function saveCustomerAddress($api_call,$data){
		$message = [];
		$result = $this->db->insert('customer_address',$data);
		$last_insert_id = $this->db->insert_id();
		if($result){
			if($api_call == 'yes'){
				$message['status'] = TRUE;
				$this->db->select('*');
				$this->db->from('customer_address');
				$this->db->where('id',$last_insert_id);
				$this->db->where('is_active','1');
				$this->db->where('is_deleted','0');
				$res=$this->db->get();
				//pre($res->row_array(),1);
				$message['message'] = $res->row_array();
				return $message;
			}
			else{
				return $result;
			}
		}
	}
	public function updateCustomerAddress($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('customer_address',$data);
	}
	public function change_customeraddress_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('customer_address',$data);
		return $result;
	}
	public function deleteCustomerAddress($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('customer_address',$data);
	}
	public function getAddressListByCustomerId($api_call,$customer_id,$start='', $limit=''){
		$data = [];
		$this->db->select('customer_address.*,master_state.state_name AS state_name');
		$this->db->from('customer_address');
		$this->db->join('master_state','master_state.id=customer_address.state_id','left');
		$this->db->where('customer_address.is_active','1');
		$this->db->where('customer_address.customer_id',$customer_id);
		$this->db->where('customer_address.is_deleted','0');
		$this->db->order_by('customer_address.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		return $res->result_array();
	}
	/******************* M A S T E R   S T A T E ************/

	public function getStateList($start='', $limit=''){
		$data = [];
		$this->db->select('master_state.*,master_country.country_name AS country_name');
		$this->db->from('master_state');
		$this->db->join('master_country','master_state.country_id=master_country.id','left');
		$this->db->where('master_state.is_deleted','0');
		$this->db->order_by('master_state.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function getStateById($id){
		$data = [];
		$this->db->select('master_state.*');
		$this->db->from('master_state');
		$this->db->where('master_state.is_deleted','0');
		$this->db->where('master_state.id', $id);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function saveState($data){
		return $this->db->insert('master_state',$data);
	}
	public function updateState($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('master_state',$data);
	}
	public function change_state_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('master_state',$data);
		return $result;
	}
	public function deleteState($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('master_state',$data);
	}
	
	/************** O R D E R    D E T A I L S ************/

	public function getOrderDetailsList($search_key='',$start='', $limit=''){
		$data = [];
		$this->db->select('
			order_details.*,
			order.order_no AS order_no,
			packages.name AS package_name
			');
		$this->db->from('order_details');
		$this->db->join('order','order_details.order_id=order.id','left');
		$this->db->join('packages','order_details.package_id=packages.id','left');
		if(!empty($search_key)) {
			if(!empty($search_key['package_id'])){
				$this->db->like('packages.id',$search_key['package_id']);
			}
			if(!empty($search_key['order_no'])){
				$this->db->like('order.order_no',$search_key['order_no']);
			}
		}
		$this->db->where('order_details.is_deleted','0');
		$this->db->order_by('order_details.id', 'DESC');
		$this->db->limit($limit, $start);
		$res=$this->db->get();
		//pre($res->result_array(),1);
		return $res->result_array();
	}
	public function getOrderDetailsById($id){
		$data = [];
		$this->db->select('
			order_details.*,
			order.order_no AS order_no,
			packages.name AS package_name
			');
		$this->db->from('order_details');
		$this->db->join('order','order_details.order_id=order.id','left');
		$this->db->join('packages','order_details.package_id=packages.id','left');
		$this->db->where('order_details.id',$id);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function saveOrderDetails($data){
		return $this->db->insert('order_details',$data);
	}
	public function updateOrderDetails($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('order_details',$data);
	}
	public function change_orderdetails_status($id,$data){
		$this->db->where('id',$id);
		$result = $this->db->update('order_details',$data);
		return $result;
	}
	public function deleteOrderDetails($id){
		$data = ['is_deleted' => '1'];
		$this->db->where('id',$id);
		return $this->db->update('order_details',$data);
	}
}