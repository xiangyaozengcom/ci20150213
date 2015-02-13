<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('brand_model');
		$this->load->library('upload');
	}

	#显示品牌列表信息
	public function index(){
		#获取品牌信息
		$data['brands']=$this->brand_model->list_brand();
		$this->load->view('brand_list.html',$data);
	}

	#添加品牌信息页面
	public function add(){
		$this->load->view('brand_add.html');
	}

	#编辑品牌信息
	public function edit(){
		$this->load->view('brand_edit.html');
	}

	#添加品牌
	public function insert(){
		#设置验证规则
		$this->form_validation->set_rules('brand_name','品牌名称','required');

		if ($this->form_validation->run()==false) {
			# 未通过验证
			$data['message']=validation_errors();
			$data['wait']=3;
			$data['url']=site_url('admin/brand/add');
			$this->load->view('message.html',$data);
		} else {
			# 通过验证，处理图片上传
			#配置上传的相关参数
			// $config['upload_path']='./public/uploads';//上传路径
			// $config['allowed_types']='gif|png|jpg';//允许上传的文件类型
			// $config['max_size']=2048;//允许上传的文件最大大小，单位k
			//$this->load->library('upload',$config);

			if ($this->upload->do_upload('logo')) {
				#上传成功,获取文件名
				$fileinfo=$this->upload->data();
				$data['logo']=$fileinfo['file_name'];

				# 通过验证，对输入的参数使用XSS过滤，post方法中第二个参数为true
				#获取表单提交数据
				$data['brand_name']=$this->input->post('brand_name',true);
				$data['url']=$this->input->post('url',true);
				$data['sort_order']=$this->input->post('sort_order',true);
				$data['brand_desc']=$this->input->post('brand_desc',true);
				$data['is_show']=$this->input->post('is_show');

				#调用品牌模型完成茶放入动作
				if ($this->brand_model->add_brand($data)) {
					# 插入OK
					$data['message']='添加品牌成功';
					$data['wait']=2;
					$data['url']=site_url('admin/brand/index');
					$this->load->view('message.html',$data);
				} else {
					# 插入失败
					$data['message']='添加品牌失败';
					$data['wait']=3;
					$data['url']=site_url('admin/brand/add');
					$this->load->view('message.html',$data);
				}
			} else {
				#上传失败
				$data['message']=$this->upload->display_errors();
				$data['wait']=3;
				$data['url']=site_url('admin/brand/add');
				$this->load->view('message.html',$data);
			}
		}
		
	}


}