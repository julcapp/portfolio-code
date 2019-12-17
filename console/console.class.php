<?php

	class console{
		var $data = array();
		var $debug_backtrace = array();
		var $console = '';
		var $show = true;

		function __construct(){
			// unset($_SESSION['console-hide']);
			// unset($_SESSION['console-width']);
			if(!isset($_SESSION['console-hide']))
				$_SESSION['console-hide'] = 'hide';
			if(!isset($_SESSION['console-width']))
				$_SESSION['console-width'] = '550px';

			if(isset($_POST['console-hide']))
				$_SESSION['console-hide'] = $_POST['console-hide'];
			if(isset($_POST['console-width']))
				$_SESSION['console-width'] = $_POST['console-width'];
		}

		function show($data){
			$this->debug_backtrace = debug_backtrace();
			$this->data[] = array(
				'result' => $data,
				'file' => str_replace(str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']), '', $this->debug_backtrace[0]['file']),
				'line' => $this->debug_backtrace[0]['line']
			);
		}

		function pre($var){
			echo "<pre>";
			print_r($var);
			echo "</pre>";
		}

		function buffer($var){
			ob_start();
			$this->pre($var);
			return ob_get_clean();
		}

		function notShow(){
			$this->show = false;
		}

		function __destruct(){
			if($this->show){
				$TPL = new theme('template');
				$count = count($this->data);
				foreach($this->data as $key => $data){
					$TPL->set('line', $data['line']);
					$TPL->set('file', $data['file']);
					$TPL->set('result', $this->buffer($data['result']));

					$this->console .= $TPL->compile('console/line');
				}

				if(isset($_SESSION['console-hide']) && $_SESSION['console-hide'] == 'hide')
					$TPL->set('visible', 'class="hide"');
				else
					$TPL->set('visible', '');

				if(isset($_SESSION['console-width']) && $_SESSION['console-width'] == true)
					$TPL->set('width', "style='width:".$_SESSION['console-width'].";'");
				else
					$TPL->set('width', '');


				$TPL->set('count', $count);
				$TPL->set('console', $this->console);
				if(($_SERVER['REMOTE_ADDR'] == '46.161.154.161' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1')){
					// functions::admin() && 
					echo $TPL->compile('console/console');
				}
			}
		}
	}

?>