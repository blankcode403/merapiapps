<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Session_model extends RAR_Model{
public $cpsess;
	/**
	 * Generate with get token key and token time
	 * @ return array
	 **/
	public function generateCpsess(){
		$this->cpsess['cpsess.key'] = md5(rand(999999,000001));
		$this->cpsess['cpsess.time'] = time();
		$this->session->set_userdata($this->cpsess);
		return $this->cpsess;
	}
	/**
	 * validate token key
	 * @param $token_key string
	 * @return booelan
	 **/
	public function validateCpsess($cpsess_key = null){
		$time = FALSE;
		if($this->session->userdata('cpsess.time')+$this->config->item('cpsess_time') > time()){
			$time = TRUE;
		}
		else{
			$this->error->set($this->error_lang['expire_session']);
		}
		if($time AND $this->session->userdata('cpsess.key') == $cpsess_key AND $cpsess_key != null){
			return TRUE;
		}
		else{
			$this->error->set($this->error_lang['invalid_session']);
		}
	}
	/**
	 * Get token key
	 * @return string
	 **/
	public function getCpsess(){
		return $this->session->userdata('cpsess.key');
	}
	/**
	 * URL with token
	 * @param $target string/array, target page
	 * @return string
	 **/
	public function urlCpsess($target=''){
		return base_url($target).'?cpsess='.$this->cpsess['cpsess.key'];
	}
}