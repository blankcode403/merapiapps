<?php
class RAR_Backend extends CI_Controller {
	public $error_lang;
	public $secure = false;
	
	function __construct() {
		parent::__CONSTRUCT();
		$this->load->model('cpanelx/lang_model','language');
		$this->language->set($this->session->userdata('lang'));
		$this->language->load('error');
		$this->error_lang = $this->lang->line('error');
		if($this->secure){$this->secure();}
	}
	
	public function secure($cpsess=null){
		/* No cache header  */
		$this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	
		/* Validate token and user login */
		$cpsess_key = (!empty($cpsess) OR $cpsess != null)?$cpsess:$this->input->get('cpsess');
		$this->users_model->isLogin();
		$this->session_model->validateCpsess($cpsess_key);
	
		/* Check Access Permission */
		/* if($this->id_module AND $this->session->userdata('id_group') != 1){
			$this->load->model('hanzen/groups_permissions_model');
			$this->groups_permissions_model->isAccessible($this->id_module,$this->session->userdata('user_group'));
			$dir = APPPATH.'controllers/modules/'.$this->id_module.'.php';
		} */
		/* redirect if have error */
		$dataType = $this->input->get('dataType');
		if($this->error->isError()){
			$this->session->set_flashdata('error',$this->error->get());
			$get = !empty($dataType)?'?dataType='.$dataType:'';
			redirect('adminx/error'.$get);
			exit();
		}
		return true;
	}
}