<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	$KT_DTABLE_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_DTABLE_uploadFileList = array('../../../common/lib/db/KT_Db.php', "dtable.class.php");

	for ($KT_DTABLE_i=0;$KT_DTABLE_i<sizeof($KT_DTABLE_uploadFileList);$KT_DTABLE_i++) {
		$KT_DTABLE_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_DTABLE_uploadFileList[$KT_DTABLE_i];
		if (file_exists($KT_DTABLE_uploadFileName)) {
			require_once($KT_DTABLE_uploadFileName);
		} else {
			die(sprintf($KT_DTABLE_uploadErrorMsg,$KT_DTABLE_uploadFileList[$KT_DTABLE_i]));
		}
	}
?>