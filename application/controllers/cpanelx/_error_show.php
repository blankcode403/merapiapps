<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class _error_show extends RAR_Backend {
	/* public $module_id = false; */
	public $secure = false;
	public function index() {
		$result ['data'] = $this->session->flashdata ( 'error' );
		$result ['data'] ['success'] = false;
		$dataType = $this->input->get ( 'dataType' );
		$this->error->error = $result ['data'];
		if ($dataType == 'json') {
			$this->load->view ( 'cpanelx/library/json', $result );
		} else {
			if (!$this->error->isError ()) {
				$this->error->error ['date'] = nama_hari('Y-m-d').', '. tgl_indo('Y-m-d').date(' h:i');
				$this->error->set(anchor( base_url (), $this->error_lang ['back']));
			}
			show_error ( $this->error->get_html() );
		}
	}
}