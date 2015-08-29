<?php
class RAR_Loader extends CI_Loader {
	function __construct() {
		parent::__construct();
	
		$CI =& get_instance();
		$CI->load = $this;
	}
	
	public function data_view($data){
		$dataType = !isset($_GET['dataType'])?'':$_GET['dataType'];
		if($dataType == 'json'){
			$this->view('cpanelx/library/json',$data);
		}
		elseif($dataType == 'xml'){
			$this->view('cpanelx/inc/xml');
		}
	}
	
	public function module_view($module){
		if(file_exists(APPPATH.'/views/cpanelx/modules/'.$module.'_view.php')){
			$this->view('cpanelx/modules/'.$module.'_view');
		}
		else{
			echo 'not found';
		}
	}
}