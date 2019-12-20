<?php
	
	class DTable{
		var $_code = '';
		var $_data = '';
		var $_name = false;
		var $_head = '';
		var $_end = '';

		private function cc(){
			$this->_code = '';
		}

		function name($name){
			$this->_name = $name;
		}

		function head($data = array()){
			$this->cc();
			foreach($data as $key => $td)
				$this->_code .= (is_array($td) ? "<th width='".$td[1]."%'>".$td[0]."</th>" : "<th>".$td."</th>");
			$this->_head = $this->tr($this->_code, 1);
		}

		function line($data = array()){
			$this->cc();
			foreach($data as $key => $td){
				// $this->_code .= (is_array($td) ? (is_array($td[0] ? "<td data-".$td[0][0]."='".$td[0][1]."'>".$td[1]."</td>" : "<td data-".$td[0].">".$td[1]."</td>") : "<td>".$td."</td>");
				if(is_array($td)){
					if(is_array($td[0])){
						$this->_code .= "<td data-".$td[0][0]."='".$td[0][1]."'>".$td[1]."</td>";
					}else{
						$this->_code .= "<td data-".$td[0].">".$td[1]."</td>";
					}
				}else{
					$this->_code .= "<td>".$td."</td>";
				}
			}

			$this->_data .= $this->tr($this->_code);
		}

		private function tr($code, $head = 0){
			return ($head ? '<tr class="head">'.$code.'</tr>' :'<tr>'.$code.'</tr>');
		}

		function end(){
			$this->cc();
			$this->_code = ($this->_name ? "<table id='D' name='".$this->_name."'>" : "<table id='D'>");
			$this->_code .= $this->_head;
			$this->_code .= $this->_data;
			$this->_code .= "</table>";
			$this->_head = '';
			$this->_data = '';
			return $this->_code;
		}
	}
?>