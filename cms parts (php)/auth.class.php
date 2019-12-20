<?php

	class auth{
		var $_id = false;
		var $_login = '';
		var $_vk = '';
		var $_foto = '';
		var $_auth = false;
		var $_admin = false;
		var $db = false;

		function __construct($DB){
			$this->db = $DB;
			$this->check_cookie();
			$this->check_auth();

			if($this->_auth){
				$this->_id = $_COOKIE['auth_id'];
				$this->_login = $_COOKIE['auth_login'];
				$this->_vk = $_COOKIE['auth_vk'];
				$this->check_user();
			}
		}

		private function check_cookie(){
			if(!isset($_COOKIE['auth'])){
				$this->set_cookie('auth', 'false', 365);
			}
		}

		private function check_auth(){
			if(!($_COOKIE['auth'] == 'false'))
				$this->_auth = true;
		}
		
		private function check_user(){
			$user = $this->db->qf_assoc("SELECT `id`, `foto` FROM `users` WHERE `id` = {$this->_id} AND `login` = '{$this->_login}' AND `vk` = '{$this->_vk}'", 1);
			if(isset($user['id'])){
				$this->check_admin_rules();
				$this->_foto = $user['foto'];
			}else
				$this->logout();
		}

		private function check_admin_rules(){
			if($this->_id != false){
				if($this->_id == $this->db->qf_assoc('SELECT `id` FROM `admins`', 1)['id'])
					$this->_admin = true;
			}
		}

		public function logout(){
			$this->set_cookie('auth', 'false', 365);
			$this->set_cookie('auth_id');
			$this->set_cookie('auth_login');
			$this->set_cookie('auth_vk');
		}

		public function vk($hash){
			$user = $this->db->qf_assoc("SELECT `id`, `login`, `vk` FROM `users` WHERE `hash` = '{$hash}'", 1);
			if(isset($user['id'])){
				$this->set_cookie('auth', true, 365);
				$this->set_cookie('auth_id', $user['id'], 365);
				$this->set_cookie('auth_login', $user['login'], 365);
				$this->set_cookie('auth_vk', $user['vk'], 365);
				return true;
			}else
				return false;
		}

		public function is_admin(){
			return $this->_admin;
		}

		public function is_logged(){
			return $this->_auth;
		}

		private function set_cookie($name, $value = '', $expires = false){
			$expires = ($expires ? time() + ($expires * 86400) : time() - 3600);
			setcookie($name, $value, $expires, "/");
		}
	}

?>