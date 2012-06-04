<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	$KT_TOR_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_TOR_uploadFileList = array(
		'../common/KT_common.php',
		'../common/lib/db/KT_Db.php',
		'TOR_SetOrder.class.php');

	for ($KT_TOR_i=0;$KT_TOR_i<sizeof($KT_TOR_uploadFileList);$KT_TOR_i++) {
		$KT_TOR_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_TOR_uploadFileList[$KT_TOR_i];
		if (file_exists($KT_TOR_uploadFileName)) {
			require_once($KT_TOR_uploadFileName);
		} else {
			die(sprintf($KT_TOR_uploadErrorMsg,$KT_TOR_uploadFileList[$KT_TOR_i]));
		}
	}
	
	KT_setServerVariables();
	KT_session_start();
?>