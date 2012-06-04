<?php
class WebService {
	var $serviceId = null;
	
	var $objInstanceName = null;
	var $methodName = null;  
	
	var $parameters = array();
	var $responseType = '';
	var $responseElement = '';

	function WebService($serviceId) {
		$this->serviceId = $serviceId;
	}
	
	function callFunction($methodName) {
		$this->methodName = $methodName;
	}
		
	function callMethod($objInstanceName, $methodName) {
		$this->objInstanceName = $objInstanceName;
		$this->methodName = $methodName;
	}

	function setParameter($element, $type) {
		array_push($this->parameters, array(
			'element' => $element, 
			'type' => $type,
			'name' => $this->serviceId . '_' .str_replace('.', '_', $element)
		));
	}

	function setResponseElement($responseElement, $responseType) {
		$this->responseElement = $responseElement;
		$this->responseType = $responseType;
	}


	function setActionElement($var1, $var2) {
		// required by DW
	}


	function renderServiceCall() {
		$stub_call = $this->methodName;
		if ($this->objInstanceName) {
			$stub_call = $this->objInstanceName . '_' . $this->methodName;
		}
        $service_call = $this->serviceId . '_' . $stub_call;
	
		$str = '
			<script type="text/javascript">' . "\n";
        $str .= '<!-- 
			function do_'.$service_call.'() {
				wsAttachLI(); 
				wsLI_visible = true; 
				if(typeof wsLI !="undefined"){ wsLI.start() };
				'. $this->renderParametersInit() . '
				'.$stub_call.'('.$this->renderParametersArgs().', '.$service_call.'_callback);
			}

			function '.$service_call.'_callback(eType, fireArgs) { 
				wsLI_visible = false;
				if(typeof wsLI !="undefined"){ wsLI.stop() }; '; 
			if (isset($this->responseType) && $this->responseType != '') {
				$str .= '
				var providerObj = fireArgs[0];
				if(providerObj.error){
					alert("Error no: " + providerObj.error.code + " has occured: " +
						providerObj.error.message + " while executing query to URL: " +
						providerObj.URL + ".");
				} else if(providerObj.content.error){
						alert("Error: " + providerObj.content.error.message);
				} else {
					var ret = providerObj.content;
					' . $this->renderResponseType(). '		
				}';
			} else {
				$str .= '
				 // do nothing with the response ' . "\n";
			}
		$str .= '
		}
        //-->
		</script>';
		return $str;
	}

	function renderParametersInit() {
		$strParams = '';
		$arrForms = array();
		foreach ($this->parameters as $k => $param) {
			switch(strtolower($param['type'])) {
				case 'form-value': 
					if (strpos($param['element'], '.') === false) {
						$elname = $param['name'] . '_el';
						$pname = $param['name'];
						$strParams .= <<<EOD

						var $elname = document.getElementById("${param['element']}");
						var $pname = ($elname.tagName.toLowerCase() == 'select' ? $elname.options[$elname.selectedIndex].value  : $elname.value );
EOD;
					} else {
						$form = substr ($param['element'], 0, strpos($param['element'], '.'));
						$element = substr ($param['element'], strpos($param['element'], '.')+1);
						
						$form_variable = $this->serviceId . '_' . $form;
						if(!array_key_exists($form, $arrForms)) {
							$arrForms[$form] = '
						var ' . $form_variable . ' = '. 'document.forms["' . $form . '"] || document.getElementById("' . $form . '");
						';
						}
						$elname = $param['name'] . '_el';
						$pname = $param['name'];
						$strParams .= <<<EOD

						var $elname = $form_variable.elements["$element"];
						var $pname = ($elname.tagName.toLowerCase() == 'select' ? $elname.options[$elname.selectedIndex].value  : $elname.value );
EOD;
					}
					break;
			case 'innerhtml':
				$strParams .=  '
						var ' . $param['name'] . ' = document.getElementById("'.$param['element'].'").innerHTML;
				';
				break;
			case 'entered-value':
				$this->parameters[$k]['name'] = "'" . KT_escapeJs($param['element']) . "'";
				break;
			case 'js-variable':
				$this->parameters[$k]['name'] = $param['element'];
				break;
			default:
				$param['name'] = '';
				// do something
			}
		}
		return implode("\n", $arrForms) . $strParams;
	}


	function renderParametersArgs() {
		$arr = array();
		foreach ($this->parameters as $k => $param) {
			array_push($arr, $param['name']);
		}
		return implode(', ', $arr);
	}

	function renderResponseType() {
		$toret = "\n";
		
		switch($this->responseType) {
			case 'set-form-value': 
				if (strpos($this->responseElement, '.') === false) {	
					$toret .='document.getElementById("'.$this->responseElement.'").value = ret;' . "\r\n";
				} else {
					$form = substr ($this->responseElement, 0, strpos($this->responseElement, '.'));
					$element = substr ($this->responseElement, strpos($this->responseElement, '.')+1);
					
					$form_variable = $this->serviceId . '_' . $form;
						$toret .= '
					var ' . $form_variable . ' = '. 'document.forms["' . $form . '"] || document.getElementById("' . $form . '");
					';
					$toret .= $form_variable . '.'. $element.'.value = ret;' . "\r\n";
				}
				break;
			case 'set-innerhtml': 
				$toret .= 'document.getElementById("'.$this->responseElement.'").innerHTML = ret;' . "\r\n";
				break;
			case 'callback-function': 
				$toret .= $this->responseElement . '(ret);' . "\r\n";
				break;
		}
		return $toret;
	}
}

?>
