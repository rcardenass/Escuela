<?php
	function n1dependentDropdown($v) {
		global $KT_n1dddSW, $KT_relPath, $KT_dd;
		if (!isset($KT_n1dddSW)) {
			$KT_n1dddSW = true;
		}
		$ret = "";

		if ($KT_n1dddSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/n1dependentDropdown.js\"></script>\n";
			$KT_n1dddSW = false;
		}

		
		$KT_dd ++;
		$ret .= '<input type="text" readonly="yes" id="'.$v['name'].'" ';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
				case "triggerrs":
				case "tpkey":
				case "tfkey":
				case "pkey":
				case "display":
				case "recordset":
				case "boundto":
				case "id":
				case "selected":
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '></input>';
		
		$ret .= '
	<script>
		ddfks_'.$v['name'].' = new Array();
		ddnames_'.$v['name'].' = new Array();
		dddefval_'.$v['name'].' = "'.@$v['selected'].'";
		';
		global ${$v['triggerrs']};
		$rs = ${$v['triggerrs']};
		$row_rs = mysql_data_seek($rs, 0);
		do {
			$ret .= 'ddfks_'.$v['name'].'["'.$row_rs[$v['tpkey']].'"]="'.$row_rs[$v['tfkey']].'";
			';
		} while($row_rs = mysql_fetch_assoc($rs));

		global ${$v['recordset']};
		$rs = &${$v['recordset']};
		$row_rs = mysql_data_seek($rs, 0);
		do {
			$value = $row_rs[$v['display']];
			$value = str_replace("\\", "\\\\", $value);
			$value = str_replace("\"", "\\\"", $value);

			$ret .= 'ddnames_'.$v['name'].'["'.$row_rs[$v['pkey']].'"]="'.$value.'";
			';
		}while ($row_rs = mysql_fetch_assoc($rs));
		$ret .= '
		registerN1Menu("'.$v['name'].'", "'.$v['boundto'].'");	
	</script>';
		return $ret;
	}
?>
