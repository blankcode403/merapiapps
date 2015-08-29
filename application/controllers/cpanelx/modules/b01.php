<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class B01 extends RAR_Backend {
public $id_module = 'b01';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/b01_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->b01_model->ReadB01();
	}
	
	function readModuleUsage()
	{
		$result =$this->b01_model->readB01usage('1','0');
	}
	
	function readModuleUsagez()
	{
		$result =$this->b01_model->readB01usagez('1','0');
	}
	
}
?>