<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
商品类型控制器

*/
class Goodstype extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('goods_type_model');
		$this->load->library('pagination');
	}
	public function index(){
		#配置分页信息
		$config['base_url']=site_url('admin/goodstype/index');
		$config['total_rows']='';
		$config['per_page']=2;

		#初始化分类页
		$this->pagination->initialize($config);

		#生成分页信息
		$data['pageinfo']=$this->pagination->create_links();

		$data['goodstype']=$this->goods_type_model->list_goodstype();
		$this->load->view('goods_type_list.html',$data);
	}
	public function add(){
		$this->load->view('goods_type_add.html');
	}
	public function edit(){
		$this->load->view('goods_type_edit.html');
	}

	#添加商品类型
	public function insert(){
		#设置验证规则
		$this->form_validation->set_rules('type_name','商品类型名称','trim | required');

		if ($this->form_validation->run()==false) {
			# 未通过验证
			$data['message']=validation_errors();
			$data['wait']=3;
			$data['url']=site_url('admin/goodstype/add');
			$this->load->view('message.html',$data);
		}
		else {
			$data['type_name']=$this->input->post('type_name',true);
			if($this->goods_type_model->add_goodstype($data)){
				# 成功
				$data['message']='添加商品类型成功';
				$data['wait']=2;
				$data['url']=site_url('admin/goodstype/index');
				$this->load->view('message.html',$data);
			}else{
				# 失败
				$data['message']='添加商品类型失败';
				$data['wait']=3;
				$data['url']=site_url('admin/goodstype/add');
				$this->load->view('message.html',$data);
			}
		
		}
	}

}