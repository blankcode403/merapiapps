<?php
class _main_property extends RAR_Backend {	
	public $secure = true;
	
	public function menu(){
		$node = mysql_real_escape_string($this->input->get('node'));

		$id_group = $this->session->userdata('group_id');

		if($id_group == 1){
			$sql =  "SELECT id_module, nm_module , leaf FROM mst_modules WHERE parent_id = '$node'";
		}
		else{
			$sql =  "SELECT id_module, nm_module , leaf FROM mst_modules WHERE parent_id = '$node' AND is_bc = 1";
		} 
		$module = $this->db->query($sql);
		$modules =array();
		if($module->num_rows()>0){
			foreach ($module->result_array() as $row){
				$text = $this->config->item('show_module_code')?$row['nm_module']:$row['nm_module'];
				$modules[] = array(
					'id'	=> $row['id_module'],
					'text'  => $text,
					'leaf'	=> $row['leaf'],
				);
			}
		}
		$tree['data'] = array_merge($modules);
		$this->load->data_view($tree);
	}
	
}