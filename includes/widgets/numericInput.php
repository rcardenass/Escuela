<?php
	function numericInput($v) {
		global $KT_numericSW, $KT_relPath;
		if (!isset($KT_numericSW)) {
			$KT_numericSW = true;
		}
		$ret = "";

		if ($KT_numericSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/numericInput.js\"></script>\n";
			$KT_numericSW = false;
		}

		$ret .= '<input type="text" autocomplete="off"';
		$float = 'false';
		$negative = 'false';
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
					break;
				case "negative":
					$negative = $value;
					break;
				case "allowfloat":
					$float = $value;
					break;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		$ret .= 'onkeyup="return numericInput(this, event, \''.$negative.'\', \''.$float.'\');" onblur="return numericInput(this, event, \''.$negative.'\', \''.$float.'\');"';
		$ret .= '>';
		return $ret;
	}
?>
