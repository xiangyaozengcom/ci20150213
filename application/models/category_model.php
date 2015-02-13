<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model {
	const TBL_CATE ='category';

	/**
	*@access public
	*@param $pid 节点的id
	*@param array 返回该节点的所有后代节点
	*/
	public function list_cate($pid=0){
		#获取所有的记录
		$query=$this->db->get(self::TBL_CATE);
		$cates=$query->result_array();
		return $this->_tree($cates,$pid);
	}

	/**
	*@access private
	*@param $arr array，要遍历的数组
	*@param $pid，节点的pid，默认为0，表示从顶级节点开始
	*@param $level,int，表示层级，默认为0
	*@param array，排好序的所有后代节点
	*
	*/
	private function _tree($arr,$pid=0,$level=0){
		//使用静态数组，保存重组的结果
		static $tree=array();
		foreach ($arr as $v) {
			if ($v['parent_id'] == $pid) {
				//说明找到了以$pid为父节点的子节点，将其保存
				$v['level']=$level;
				$tree[]=$v;
				//然后以该节点为父节点，继续找其后代节点
				$this->_tree($arr,$v['cat_id'],$level+1);
			}
		}
		return $tree;
	}

	#添加分类信息
	public function add_category($data){
		return $this->db->insert(self::TBL_CATE,$data);
	}

	#获取单条信息
	public function get_cate($cat_id){
		$condition['cat_id']=$cat_id;
		$query=$this->db->where($condition)->get(self::TBL_CATE);

		#返回单条记录,手册中，row_array()
		return $query->row_array();

	}

	#更新分类
	public function update_cate($data,$cat_id){
		$condition['cat_id']=$cat_id;
		return $this->db->where($condition)->update(self::TBL_CATE,$data);
	}

	// #更新
	// public function update_cate($data,$cat_id){
	// 	$condition['cat_id'] = $cat_id;
	// 	return $this->db->where($condition)->update(self::TBL_CATE,$data);
	// }


}