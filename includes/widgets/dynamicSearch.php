<?php
	function dynamicSearch($v) {
		global $KT_dynamicInputSW, $KT_relPath, $HTTP_SESSION_VARS;
		if (!isset($KT_dynamicInputSW)) {
			global $sessInsTest;
			$sessInsTest = array();
			session_register('sessInsTest');
			$KT_dynamicInputSW = true;
		}
		$rsName = $v['datasource'];
		if (!isset($v['id'])) {
			$v['id'] = $v['name'];
		}
		$v['id'] = preg_replace("/[\[\]]/", "_", $v['id']);
		
		$wgName = $v['name'];
		$wgId = $v['id'];
		
		$v['style'] = isset($v['style'])?$v['style']:"width:150px";
		global $$rsName;
		global ${'query_' . $rsName};
		//${"row_".$rsName} = mysql_data_seek($$rsName, 0);
		$sqlTable =  ${'query_' . $rsName};
		preg_match("/\sfrom\s([^\s]+)?\s*/i", $sqlTable, $sqlTable);
		$sqlTable = $sqlTable[1];

		$sessInsTest = &$HTTP_SESSION_VARS['sessInsTest'];
		$sessInsTest[] = array('conn' => $v['connection'], 'table' => $sqlTable, 'field' => $v['field']);
		session_register('sessInsTest');
		if (!isset($v['norec']) || (int)$v['norec'] == "0") {
			$v['norec'] = 100000;
		}

		$ret = "
<script>
	var ${wgId}_restrict = 'No';
	var ${wgId}_norec = '".$v['norec']."';
	var ${wgId}_style = '".$v['style']."';
	var ${wgId}_edittype = 'S';
	var ${wgId}_el = new Array(\"\"";
	$dvvalue = $v['value'];
	$row_rs = mysql_data_seek($$rsName, 0);
	while ($row_rs = mysql_fetch_assoc($$rsName)) {
		$value = $row_rs[$v['field']];
		$value = str_replace("\\", "\\\\", $value);
		$value = str_replace("\"", "\\\"", $value);
		$ret .= ",\"\", \"" . $value . "\"";
	} 
	$ret .= ");
</script>\n";
	if ($KT_dynamicInputSW) {
		$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/dynamicInput.js\"></script>\n";
		$KT_dynamicInputSW = false;
	}
		$ret .= '<input type="text" name="'.$wgId.'_edit" id="'.$wgId.'_edit"
			onblur="di_onBlur(this, event);" 
			onKeyDown="return di_inputKeyDown(this, event)"
			onKeyUp="autoComplete(this, event);"
			autocomplete="off"
			style="'.$v['style'].'"
			value="'.$dvvalue.'"
		';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
				case "datasource":
				case "norec":
				case "field":
				case "value":
				case "style":
				case "kdefault":
				case "connection":
				case "name":
				case "id":
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '>';
		$ret .= '<input type="button" name="'.$wgId.'_v" id="'.$wgId.'_v" tabIndex="-1" value="6"
				style="font-family: webdings; position:relative; left:-1px; top: -1px; height: 21px; width: 18px"
				onFocus="di_vFocused(\''.$wgId.'\')"
				onBlur="return clearTimeout(window.to)" 
				onClick="return di_buttonPressed(\''.$wgId.'\')">';

		$ret .= '<input type="button" id="'.$wgId.'_add" value="fake" disabled="true" style="display:none">';
		$ret .= '<iframe id="'.$wgId.'_iframe" style="display:none"></iframe>';
		$ret .= '<input name="'.$wgName.'" id="'.$wgId.'" type="hidden" value="'.$dvvalue.'">';
		$ret .= '<script>di_updateForm("'.$wgId.'_add")</script>';
		return $ret;
	}
?>


