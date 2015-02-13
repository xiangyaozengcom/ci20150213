<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Brand_model extends CI_Model {
	const TBL_CATE ='brand';

	#添加商品品牌
	public function add_brand($data){
		return $this->db->insert(self::TBL_CATE,$data);
	}

	#查询商品品牌
	public function list_brand(){
		$query= $this->db->get(self::TBL_CATE);
		return $query->result_array();
	}


}


