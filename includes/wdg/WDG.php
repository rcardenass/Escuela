<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	$KT_WDG_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.<strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_WDG_uploadFileList = array('../common/KT_common.php', '../common/lib/db/KT_Db.php', 'WDG_JsRecordset.class.php', 'WDG_functions.inc.php');

	for ($KT_WDG_i=0;$KT_WDG_i<sizeof($KT_WDG_uploadFileList);$KT_WDG_i++) {
		$KT_WDG_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_WDG_uploadFileList[$KT_WDG_i];
		if (file_exists($KT_WDG_uploadFileName)) {
			require_once($KT_WDG_uploadFileName);
		} else {
			die(sprintf($KT_WDG_uploadErrorMsg,$KT_WDG_uploadFileList[$KT_WDG_i]));
		}
	}
KT_session_start();
?>