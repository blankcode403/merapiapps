<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ST02 extends RAR_Backend {
public $id_module = 'st02';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/st02_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->st02_model->ReadST02();
	}
	
	function insertModule()
	{
		$result =$this->st02_model->InsertST02();
	}
	
	function updateModule()
	{
		$result =$this->st02_model->UpdateST02();
	}
	
	function delModule()
	{
		$result =$this->st02_model->DelST02();
	}
	
	function readTipeModule()
	{
		$result =$this->st02_model->ReadTipeST02();
	}

	
}
?>