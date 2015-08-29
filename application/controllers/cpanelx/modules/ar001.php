<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AR001 extends RAR_Backend {
public $id_module = 'ar001';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/ar001_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->ar001_model->Readar001();
	}
	
	function readParams()
	{
		$result =$this->ar001_model->Readar001params();
	}
	
	function getdataYear()
	{
		$result =$this->ar001_model->getdataYear();
	}

	function getdataMonth()
	{
		$result =$this->ar001_model->getdataMonth();
	}

	function getdataBrach()
	{
		$result =$this->ar001_model->getdataBrach();
	}
	
}
?>