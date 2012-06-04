<?php
	function wcalendar($v) {
		global $KT_calendarSW, $KT_relPath, $KT_cid;
		
		if (!isset($KT_cid)) {
			$KT_cid = 0;
		}
		if (!isset($KT_calendarSW)) {
			$KT_calendarSW = true;
		}
		$ret = "";

		if ($KT_calendarSW) {
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/calendar.js\"></script>\n";
			$ret .= "<script language=\"JavaScript\" src=\"".$KT_relPath."includes/widgets/wcalendar.js\"></script>\n";
			$KT_calendarSW = false;
		}

		$ret .= '<input type="text"';
		$Id = "";
		$format = "";
		$label = "...";
		$lang = "en";
		$skin = "system";
		$mondayFirst = "false";
		while (list($key,$value) = each($v)) {
			switch ($key) {
				case "type":
				case "subtype":
				case "skin":
					$skin = $value;
					break;
				case "language":
					$lang = $value;
					break;
				case "label":
					$label = $value;
					break;
				case "format":
					$format = $value;
					break;
				case "mondayfirst":
					$mondayFirst = $value;
					break;
				case "id":
					$Id = $value;
				default:
					$ret .= " " . $key . '="' . $value . '"';
			}
		}
		if($Id === "") {
			$Id = 'wcal_'.$KT_cid;
			$KT_cid++;
			$ret .= ' id="' . $Id . '"';
		}
	$ret .= '>'."\n";
		#add language
		$ret .= '<script language="JavaScript" src="'.$KT_relPath.'includes/widgets/lang/calendar-'.$lang.'.js"></script>'."\n";
		#add style
		$ret .= '<link rel="stylesheet" type="text/css" media="all" href="'.$KT_relPath.'includes/widgets/calendar-'.$skin.'.css" title="'.$skin.'"/>'."\n";
		#add button
		$ret .= '<input type="button" value=" '.$label.' " onclick="return showCalendar(\''.$Id.'\', \''.$format.'\', \''.$mondayFirst.'\');">';
		return $ret;
	}
?>
