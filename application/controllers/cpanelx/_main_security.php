<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class _main_security extends RAR_Backend {
	
	public function auth($token = null,$redirect = 'adminx/base/'){
		$data = array(
			'username' => $this->input->post('username'),
			'passwd' => $this->input->post('password')
		);
		
		$this->users_model->login($data);
		$cpsess = $this->session_model->generateCpsess();
		redirect($redirect.'?cpsess='.$cpsess['cpsess.key']);
		
		// checking if have error login
		if($this->error->isError()){
			$this->session->set_flashdata('error',$this->error->get_html());
			redirect('adminx/login');
			exit();
		}
		else{
			$this->users_model->ping($data['username']);
			$cpsess = $this->session_model->generateCpsess();
			redirect($redirect.'?cpsess='.$cpsess['cpsess.key']);
		}
	}
	/**
	 * Destroy session
	 * @return none
	 **/
	public function destroy(){
		$user = $this->users_model->getData($this->session->userdata('email'));
		$setting_delay = $this->config->item('user_delay_ping');
		if($user['connected']+$setting_delay >= time()){
			$this->db->where(array('email'=>$user['email']));
			$this->db->update($this->users_model->table['mst_users'],array('connected'=>$user['connected']-$setting_delay));
		}
		$this->session->set_userdata(array(
			'email'	=> null,
			'id_user'	=> null,
		));
		redirect('adminx/login','refresh');
	}
}
?>