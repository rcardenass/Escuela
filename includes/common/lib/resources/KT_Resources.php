<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	$KT_RES_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_RES_uploadFileList = array('KT_ResourcesFunctions.inc.php', '../../KT_common.php');

	for ($KT_RES_i=0;$KT_RES_i<sizeof($KT_RES_uploadFileList);$KT_RES_i++) {
		$KT_RES_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_RES_uploadFileList[$KT_RES_i];
		if (file_exists($KT_RES_uploadFileName)) {
			require_once($KT_RES_uploadFileName);
		} else {
			die(sprintf($KT_RES_uploadErrorMsg,$KT_RES_uploadFileList[$KT_RES_i]));
		}
	}

?>
