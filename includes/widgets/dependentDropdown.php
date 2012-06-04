<?php
	function dependentDropdown($v) {
		global $KT_dddSW, $KT_relPath, $KT_dd;
		if (!isset($KT_dddSW)) {
			$KT_dddSW = true;
		}
		$ret = "";

		if ($KT_dddSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/dependentDropdown.js\"></script>\n";
			$KT_dddSW = false;
		}

		
		$KT_dd ++;
		$ret .= '<select id="'.$v['name'].'" ';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case 'type':
				case 'subtype':
				case 'pkey':
				case 'fkey':
				case 'display':
				case 'recordset':
				case 'boundto':
				case 'id':
				case 'selected':
				case 'kdefault':
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '></select>';
		
		$ret .= '
	<script>
		dddefaults_'.$v['name'].' = new Array();
		ddfks_'.$v['name'].' = new Array();
		ddnames_'.$v['name'].' = new Array();
		dddefval_'.$v['name'].' = "'.@$v['selected'].'";
		';
		$tok = $v['kdefault'];
		for($i=0;$i<sizeof($tok);$i+=2) {
			$ret .= 'dddefaults_'.$v['name'].'["'.$tok[$i].'"]="'.$tok[$i+1].'";
			';
		}

		global ${$v['recordset']};
		$rs = &${$v['recordset']};
		$row_rs = mysql_data_seek($rs, 0);
		//$rs->MoveFirst();
		do {
			$ret .= 'ddfks_'.$v['name'].'["'.$row_rs[$v['pkey']].'"]="'.$row_rs[$v['fkey']].'";
		';

			$value = $row_rs[$v['display']];
			$value = str_replace("\\", "\\\\", $value);
			$value = str_replace("\"", "\\\"", $value);

			$ret .= 'ddnames_'.$v['name'].'["'.$row_rs[$v['pkey']].'"]="'.$value.'";
		';
			
		} while ($row_rs = mysql_fetch_assoc($rs));
		$ret .= '
		initMenu("'.$v['name'].'", "'.$v['boundto'].'");
	</script>';
		return $ret;
	}
?>
