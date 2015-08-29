<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ST01 extends RAR_Backend {
public $id_module = 'st01';
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper( array('html','url') );
		$this->load->model('cpanelx/st01_model','',TRUE);
	}
	
	function index(){
		$this->load->module_view($this->id_module);
	}
	
	function readModule()
	{
		$result =$this->st01_model->ReadST01();
	}
	
	function insertModule()
	{
		$result =$this->st01_model->InsertST01();
	}
	
	function updateModule()
	{
		$result =$this->st01_model->UpdateST01();
	}
	
	function delModule()
	{
		$result =$this->st01_model->DelST01();
	}
	
	function readTipeModule()
	{
		$result =$this->st01_model->ReadTipeST01();
	}

	
}
?>