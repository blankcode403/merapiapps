<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class B04 extends RAR_Backend {
public $id_module = 'b04';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/b04_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->b04_model->ReadB04();
	}
	
	function readModuleUsage()
	{
		$result =$this->b04_model->readB04usage('1','0');
	}
	
}
?>