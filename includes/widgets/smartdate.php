<?php
	function smartdate($v) {
		global $KT_smartdateSW, $KT_relPath;
		if (!isset($KT_smartdateSW)) {
			$KT_smartdateSW = true;
		}
		$ret = "";

		if ($KT_smartdateSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/smartdate.js\"></script>\n";
			$KT_smartdateSW = false;
		}

		$ret .= '<input autocomplete="off" type="text" onblur="editDateBlur(this, \''.$v['mask'].'\')" onkeydown="return editDatePre(this, \''.$v['mask'].'\', event)" onkeyup="return editDate(this, \''.$v['mask'].'\', event);"';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
				case "mask":
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= '>';
		//$ret .= ' '.$v['mask'].'';
		
		return $ret;
	}
?>
