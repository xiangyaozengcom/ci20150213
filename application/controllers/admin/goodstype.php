<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
��Ʒ���Ϳ�����

*/
class Goodstype extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('goods_type_model');
		$this->load->library('pagination');
	}
	public function index(){
		#���÷�ҳ��Ϣ
		$config['base_url']=site_url('admin/goodstype/index');
		$config['total_rows']='';
		$config['per_page']=2;

		#��ʼ������ҳ
		$this->pagination->initialize($config);

		#���ɷ�ҳ��Ϣ
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

	#�����Ʒ����
	public function insert(){
		#������֤����
		$this->form_validation->set_rules('type_name','��Ʒ��������','trim | required');

		if ($this->form_validation->run()==false) {
			# δͨ����֤
			$data['message']=validation_errors();
			$data['wait']=3;
			$data['url']=site_url('admin/goodstype/add');
			$this->load->view('message.html',$data);
		}
		else {
			$data['type_name']=$this->input->post('type_name',true);
			if($this->goods_type_model->add_goodstype($data)){
				# �ɹ�
				$data['message']='�����Ʒ���ͳɹ�';
				$data['wait']=2;
				$data['url']=site_url('admin/goodstype/index');
				$this->load->view('message.html',$data);
			}else{
				# ʧ��
				$data['message']='�����Ʒ����ʧ��';
				$data['wait']=3;
				$data['url']=site_url('admin/goodstype/add');
				$this->load->view('message.html',$data);
			}
		
		}
	}

}