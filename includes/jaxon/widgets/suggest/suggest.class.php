<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

$GLOBALS['Widgets.Suggest.default_options'] = array(
	'lazyChoices' => true, 
	'numberOfSuggestions' => 4
);

class Suggest {
	var $exportedMethods = array('getSuggested');
	var $config = array();
    var $connection = null;
    var $table = null;
    var $id = null;
	
	function Suggest($id) {
		$this->id = $id;
		$this->options = $GLOBALS['Widgets.Suggest.default_options'];
	}

	function setSuggestInput($input) {
		$this->config['input'] = $input;	
	}
	
	function setRecordset($rs) {
		$this->config['recordset'] = $rs;
	}

	function setNumberOfSuggestions($num) {
		$this->options['numberOfSuggestions'] = $num;
	}

	function setSuggestField($fieldName) {
		$this->config['suggestField'] = $fieldName;
	}

	function renderSuggestions($input=null) {
        if (isset($input)) {
            $this->config['input'] = $input;
        }
		$content = '
		<div id="'.$this->config['input'].'_choices" class="suggest_choices"></div>
		<script type="text/javascript">
            <!--
			var '.$this->id .' = new Widgets.Suggest("'.$this->id.'", "'.$this->config['input'].'");
            //-->
		</script>';
		return $content;
	}

	function getSuggestedEntries() {
		if (!defined('_ADODB_LAYER')) {
			$rs = new KT_Recordset($GLOBALS[$this->config['recordset']]);
		} else {
			$rs = & $GLOBALS[$this->config['recordset']];
		}
		$index = 0;
		$arr = array();
		while (!$rs->EOF && $index < $this->options['numberOfSuggestions']) {
			$arr[] = $rs->Fields($this->config['suggestField']);
			$index++;
			$rs->MoveNext();
		}
		return array('choices' => $arr);
	}
}
?>