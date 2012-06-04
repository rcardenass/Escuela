<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	$KT_CMN_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_CMN_uploadFileList = array('KT_config.inc.php', 'KT_functions.inc.php');

	for ($KT_CMN_i=0;$KT_CMN_i<sizeof($KT_CMN_uploadFileList);$KT_CMN_i++) {
		$KT_CMN_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_CMN_uploadFileList[$KT_CMN_i];
		if (file_exists($KT_CMN_uploadFileName)) {
			require_once($KT_CMN_uploadFileName);
		} else {
			die(sprintf($KT_CMN_uploadErrorMsg,$KT_CMN_uploadFileList[$KT_CMN_i]));
		}
	}
?>
