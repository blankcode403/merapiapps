<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class B03 extends RAR_Backend {
public $id_module = 'b03';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/b03_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->b03_model->ReadB03();
	}
	
	function readModuleUsage()
	{
		$result =$this->b03_model->readB03usage('1','0');
	}
	
}
?>