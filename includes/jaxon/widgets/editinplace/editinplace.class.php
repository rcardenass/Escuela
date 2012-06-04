<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

$GLOBALS['Widgets.EditInPlace.default_options'] = array(
	'save' => 'Save', 
	'cancel' => 'Cancel',
	'empty' => '[<i>empty</i>]',
	'click' => 'Click on text to edit it'
);

class EditInPlace {
	var $exportedMethods = array('updateValue');
	var $config = array();
    var $relPath = null;
    
    var $connectionName = null;
    var $primaryKey = null;
    var $editField = null;
    var $editFieldType = "STRING_TYPE";
    var $tableName = null;
    var $isEnabled = false;
    var $isEnabledCondition = '';
	
	function EditInPlace($id) {
		$this->id = $id;
		$this->options = $GLOBALS['Widgets.EditInPlace.default_options'];
	}

	function setConnection($connectionName) {
		$this->connectionName = $connectionName;
	}

	function setTable($tableName) {
		$this->tableName = $tableName;
	}

	function setPrimaryKey($primaryKey) {
		$this->primaryKey = $primaryKey;
	}

	function setEditField($editField, $editFieldType) {
		$this->editField = $editField;
		$this->editFieldType = $editFieldType;
	}
	
	function setRelPath($relPath) {
		$this->relPath = $relPath;
	}
	function setEnabledCondition($expr='') {
		if ($expr=='') {
			$expr = '1==1';
		}		
		$this->isEnabledCondition = $expr;
		$run = KT_DynamicData($expr, '', 'expression');
		$runTrigger = false;
		$ok = false;
		eval('$runTrigger = ('.$run.');$ok = true;');
		if ($ok !== true) {
			die('Internal Error.Invalid boolean expression: '.$run);
		}
		if ($runTrigger) {
			$this->isEnabled = true;
		} else {
			$this->isEnabled = false;
		}
	}
	function editForId($pkvalue, $fieldvalue) {
    	$pkvalue = KT_DynamicData($pkvalue, null, '');
    	if (is_null($fieldvalue) || $fieldvalue == '') {
    		if ($this->isEnabled) {
    			$fieldvalue = $GLOBALS['Widgets.EditInPlace.default_options']['empty'];
    		}
    	}
		$content = '' .
		'<div class="editinplace" id="editinplace_'.$this->id . '_' . $pkvalue.'">'.$fieldvalue.'</div>';
		if ($this->isEnabled) {
			$content .= '<script  type="text/javascript">' .
			'var editinplace_'.$this->id . '_'. $pkvalue.' =' .
					' new Widgets.EditInPlace("'.addslashes($this->id).'", ' .
					'"'.addslashes($pkvalue).'", '.
					KT_json($this->options).');' .
			'</script>';
		}
		return $content; 
	}

	function updateValue($pkvalue, $fieldvalue) {		
		if (!$this->isEnabled) {
			return array('error' => array('code' => 'Update Error', 'message' => 'You don\'t have permission to use the edit inplace!'));
		}
		require_once(realpath(dirname(__FILE__) . '/' . '/../../../../Connections/' .$this->connectionName.'.php'));
		$hostname = 'MM_' . $this->connectionName . '_HOSTNAME';
        
        $connWrap = null;
		if (empty($GLOBALS[$hostname])) {
			// we are on mysql
			// Make unified connection variable
			$database = 'database_' . $this->connectionName;
			$connWrap = new KT_Connection($GLOBALS[$this->connectionName], $GLOBALS[$database]);
		} else {
			$connWrap = $GLOBALS[$this->connectionName];
		}
		$rs = $connWrap->Execute('UPDATE '. $this->tableName . 
				' SET '. KT_escapeFieldName($this->editField) .' = '. KT_escapeForSql($fieldvalue, $this->editFieldType) .
				' WHERE '. KT_escapeFieldName($this->primaryKey) .' = '. KT_escapeForSql($pkvalue, "NUMERIC_TYPE"));
		if ($rs !== false){
            return "OK";
            /*
			$rs = $connWrap->Execute('SELECT '. KT_escapeFieldName($this->editField) . 
				' FROM '.  $this->tableName .
				' WHERE '. KT_escapeFieldName($this->primaryKey) .' = '. KT_escapeForSql($pkvalue, "NUMERIC_TYPE"));
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'Field selection error: '.$connWrap->ErrorMsg()));
				}
				if (!$rs->EOF) {
					return $rs->Fields($this->editField);
				}
				return "";
            */    
		}else{
			return array('error' => array('code' => 'SQL Error', 'message' => 'Update failed: '.$connWrap->ErrorMsg()));
		}
	}
}
?>