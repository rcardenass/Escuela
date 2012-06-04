<?php
	$ret_str = ob_get_contents();
	ob_end_clean();
	$arrInputs = preg_split("#(<input[^>]*subtype[^>]*>)#", $ret_str, -1, PREG_SPLIT_DELIM_CAPTURE);
	for ($i=0;$i<sizeof($arrInputs);$i++) {
		if (preg_match("#^<input[^>]*subtype[^>]*>$#", $arrInputs[$i])) {
			preg_match_all("#\s([^=]*)=\"(.*?)\"#", $arrInputs[$i], $tmp1);
			$tmp = array();
			for ($j=0;$j<sizeof($tmp1[1]);$j++) {
				$val = $tmp1[2][$j];
				$val = str_replace("\\", "\\\\", $val);
				$val = str_replace("'", "\\'", $val);
				$tmp[$tmp1[1][$j]]=$val;
			}
			echo showWidget($tmp);
		} else {
			// split html source by <select * subtype * /> (widget select)
			$arrSelects =preg_split("#(<select[^>]*subtype[^>]*>.*?)</select>#s", $arrInputs[$i], -1, PREG_SPLIT_DELIM_CAPTURE);
			for ($k=0;$k<sizeof($arrSelects);$k++) {
				if (preg_match("#^(<select[^>]*subtype[^>]*>)(.*)$#s", $arrSelects[$k], $arrSelOp)) {
					// for each widget select get all attributes (for later processing)
					preg_match_all("#\s([^=]*)=\"(.*?)\"#", $arrSelOp[1], $tmp1);
					$tmp = array();
					for ($j=0;$j<sizeof($tmp1[1]);$j++) {
						$val = $tmp1[2][$j];
						$val = str_replace("\\", "\\\\", $val);
						$val = str_replace("'", "\\'", $val);
						$tmp[$tmp1[1][$j]]=$val;
					}
					// get all options to be kept as defaults
					$kdef = array();
					preg_match_all("#<option[^>]*value=\"(.*?)\"[^>]*>(.*?)</option>#s", $arrSelOp[2], $tmp1);
					for ($j=0;$j<sizeof($tmp1[1]);$j++) {
						$kdef[] = $tmp1[1][$j];
						$kdef[] = $tmp1[2][$j];
					}
					preg_match_all("#<option>(.*?)</option>#s", $arrSelOp[2], $tmp1);
					for ($j=0;$j<sizeof($tmp1[1]);$j++) {
						$kdef[] = $tmp1[1][$j];
						$kdef[] = $tmp1[1][$j];
					}
					$tmp['kdefault'] = $kdef;
					echo showWidget($tmp);
				} else {
					echo $arrSelects[$k];
				}
			}
		}
	}
?>
