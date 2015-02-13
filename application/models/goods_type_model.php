<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Goods_type_model extends CI_Model {
	const TBL_GT='goods_type';

	public function add_goodstype($data){
		return $this->db->insert(self::TBL_GT,$data);
	}

	public function list_goodstype(){
		$query=$this->db->get(self::TBL_GT);
		return $query->result_array();
	}

	#统计商品类型的总数
	public function count_goodstype(){
		return $this->db->count_all(self::TBL_GT);
	}
}