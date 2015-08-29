<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class _main_dashboard extends RAR_Backend {	
	public $secure = false;
	
	public function index() {
		if(true){
			redirect('adminx/login');
		}
	}
	
	/* Login Page */
	public function login(){
		if($this->session->userdata('email')){
			redirect('adminx/sec/destroy');
		}
		$this->language->load('base');
		$data = array(
			'cpsess'	=> $this->session_model->generateCpsess(),
			'error'	=> $this->session->flashdata('error'),
		);
		$this->load->view('cpanelx/_admin_login',$data);
	}
	
	public function base(){
		$this->secure();
		$data = array(
				'cpsess' => $this->input->get('cpsess'),
		);
		$this->output->set_status_header('200');
		$this->output->set_header("Date: ".gmdate(DATE_RFC822));
		$this->output->set_header("Content-Type: text/html charset=UTF-8");
		$this->load->view('cpanelx/_admin_dashboard',$data);
	}
	
	public function data(){
		$this->secure();
		$this->language->load('base');
		$cpsess_key = $this->session_model->generateCpsess();
		$session = $this->session->all_userdata();
		$data = array(
				'username' => $session['username'],
				'alias' => $session['name_alias'],
				'group_id' => $session['group_id'],
				'branch' => $session['branch'],				
				'status' => $session['status'],
				'base_url'	=> base_url(),
				'lang' => $this->lang->line('base'),
				'is_error'	=> $this->error->isError(),
				'error'	=> $this->error->get(),
				'cpsess'=> $cpsess_key['cpsess.key']
		);
		$this->output->set_content_type('application/json');
		$this->output->set_output('var d ='.json_encode($data));
	}
	
	public function about(){
		$this->load->view('cpanelx/about');
	}
}