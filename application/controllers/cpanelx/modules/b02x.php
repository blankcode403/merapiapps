<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class B02 extends RAR_Backend {
public $id_module = 'b02';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/b02_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->b02_model->ReadB02();
	}
	
	function readModuleUsage()
	{
		$result =$this->b02_model->readB02usage('1','0');
	}
	
}
?>