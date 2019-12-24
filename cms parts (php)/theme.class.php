<?php

	class theme{

		private $template_dir;
		private $template_url;
		private $replaces = array();
		private $tpl_name;
		private $tpl_data;
		private $blocks = array();
		private $_admin = false;
		private $_logged = false;

		function __construct($dir = 'template'){
			$this->template_dir = ROOT.'/'.$dir.'/';
			$this->template_url = '/'.$dir;
		}

		public function userdata($logged, $admin){
			$this->_logged = $logged;
			$this->_admin = $admin;
		}

		private function set_tpl($tpl_name){
			$this->tpl_name = $tpl_name;
		}

		private function load_tpl(){
			$tpl_path = $this->template_dir.$this->tpl_name.'.tpl';
			if(!file_exists($tpl_path)){
				die('Файл '.$this->tpl_name.'.tpl не найден');
			}
			$this->tpl_data = file_get_contents($tpl_path);
			$this->set('microtime', functions::getmicrotime());
			$this->set('THEME', $this->template_url);
		}

		private function load_file($filename){
			$filename = (!strpos('.tpl', $filename) ? $filename : $filename.'.tpl');
			if(file_exists($this->template_dir.$filename)){
				return file_get_contents($this->template_dir.$filename);
			}else{
				return 'Файл '.$filename.' не найден.';
			}
		}

		public function set($block, $data){
			$block = str_replace(array('{','}'), '', $block);
			$this->replaces[$block] = $data;
		}

		public function setBlock($block, $data){
			$this->blocks[$block] = $data;
		}

		private function replaceBlockE($block, $condition){
			if(strpos($this->tpl_data, "[".$block."]") !== false){
				// preg_match_all("#\\[".$block."\\](.*?)\\[/".$block."\\]#is", $this->tpl_data, $output_admin, PREG_SET_ORDER);
				// $condition = eval($condition);
				if($condition){
					$this->tpl_data = preg_replace(array("#\\[".$block."\\]#is","#\\[/".$block."\\]#is"), array('',''), $this->tpl_data);
				}else{
					$this->tpl_data = preg_replace("#\\[".$block."\\](.*?)\\[/".$block."\\]#is", '', $this->tpl_data);
				}
			}
		}

		private function spoilers(){
			if(strpos($this->tpl_data, "[spoiler=") !== false){
				
				preg_match_all("#\\[spoiler=(.*?)\\](.*?)\\[/spoiler\\]#is", $this->tpl_data, $spoilers, PREG_SET_ORDER);

				for($i=0; $i < count($spoilers); $i++){
					$id = functions::getmicrotime();

					if(strlen($spoilers[$i][1]) == 0){
						$this->tpl_data = preg_replace("#\\[spoiler={$spoilers[$i][1]}\\]#is","<div class='spoiler' id='{$id}'><b>Спойлер</b><div>", $this->tpl_data);
					}else{
						$this->tpl_data = preg_replace("#\\[spoiler={$spoilers[$i][1]}\\]#is","<div class='spoiler' id='{$id}'><b>{$spoilers[$i][1]}</b><div>", $this->tpl_data);
					}
				}
				
				$this->tpl_data = preg_replace("#\\[/spoiler\\]#is","</div></div>", $this->tpl_data);
			}
		}

		public function getCSSversion($file){
			return filemtime($this->template_dir.$file);
		}

		private function include_file(){
			if(strpos($this->tpl_data, "{file=") !== false){
				preg_match_all("#{file=(.*?)}#is", $this->tpl_data, $include_file, PREG_SET_ORDER);
				foreach ($include_file as $key => $value)
					$this->tpl_data = str_replace($value[0], $this->load_file(str_replace(['"',"'"], '', $value[1])), $this->tpl_data);
			}
		}

		private function setGlobalBlock(){
			if(strpos($this->tpl_data, "[act=") !== false){
				preg_match_all("#\\[act=(.*?)\\](.*?)\\[/act\\]#is", $this->tpl_data, $global_blocks, PREG_SET_ORDER);
				foreach ($global_blocks as $key => $block){
					if($_GET['act'] == $block[str_replace(['"',"'"], '', $value[1])])
						$this->tpl_data = str_replace($block[0], $block[2], $this->tpl_data);
					else
						$this->tpl_data = str_replace($block[0], '', $this->tpl_data);
				}
			}
			
			if(strpos($this->tpl_data, "[view=") !== false){
				preg_match_all("#\\[view=(.*?)\\](.*?)\\[/view\\]#is", $this->tpl_data, $global_blocks, PREG_SET_ORDER);
				foreach ($global_blocks as $key => $block){
					if($_GET['page'] == $block[1])
						$this->tpl_data = str_replace($block[0], $block[2], $this->tpl_data);
					else
						$this->tpl_data = str_replace($block[0], '', $this->tpl_data);
				}
			}
			if(strpos($this->tpl_data, "[not-view=") !== false){
				preg_match_all("#\\[not-view=(.*?)\\](.*?)\\[/not-view\\]#is", $this->tpl_data, $global_blocks, PREG_SET_ORDER);
				foreach ($global_blocks as $key => $block){
					if($_GET['page'] !== $block[1])
						$this->tpl_data = str_replace($block[0], $block[2], $this->tpl_data);
					else
						$this->tpl_data = str_replace($block[0], '', $this->tpl_data);
				}
			}
			if(strpos($this->tpl_data, "[static=") !== false){
				preg_match_all("#\\[static=(.*?)\\](.*?)\\[/static\\]#is", $this->tpl_data, $global_blocks, PREG_SET_ORDER);
				foreach ($global_blocks as $key => $block){
					if($_GET['page'] == 'static' && $_GET['altname'] == $block[1])
						$this->tpl_data = str_replace($block[0], $block[2], $this->tpl_data);
					else
						$this->tpl_data = str_replace($block[0], '', $this->tpl_data);
				}
			}
			if(strpos($this->tpl_data, "[not-static=") !== false){
				preg_match_all("#\\[not-static=(.*?)\\](.*?)\\[/not-static\\]#is", $this->tpl_data, $global_blocks, PREG_SET_ORDER);
				foreach ($global_blocks as $key => $block){
					if($_GET['page'] == 'static' && $_GET['altname'] !== $block[1])
						$this->tpl_data = str_replace($block[0], '', $this->tpl_data);
					else
						$this->tpl_data = str_replace($block[0], $block[2], $this->tpl_data);
				}
			}
		}
		
		private function blocks(){
			$this->setBlock('admin', $this->_admin);
			$this->setBlock('not-admin', !$this->_admin);
			$this->setBlock('login', $this->_logged);
			$this->setBlock('not-login', !$this->_logged);
			$this->spoilers();
			
			foreach($this->blocks as $key => $value){
				$this->replaceBlockE($key, $value);
			}
		}

		private function replaces(){
			foreach($this->replaces as $key => $value) {
				$this->tpl_data = str_replace("{".$key."}", $value, $this->tpl_data);
			}
			$this->replaces = array();
		}

		public function compile($tpl_name){
			$this->set_tpl($tpl_name);
			$this->load_tpl();
			$this->include_file();
			$this->replaces();
			$this->blocks();
			$this->setGlobalBlock();
			return $this->tpl_data;
		}

	}

?>