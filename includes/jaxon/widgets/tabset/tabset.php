<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Tabset_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Tabset_uploadFileList = array(
		'../../utils/json.php',
		'../../../common/KT_common.php',
        'tabset.class.php');

	for ($KT_Tabset_i=0;$KT_Tabset_i<sizeof($KT_Tabset_uploadFileList);$KT_Tabset_i++) {
		$KT_Tabset_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Tabset_uploadFileList[$KT_Tabset_i];
		if (file_exists($KT_Tabset_uploadFileName)) {
			require_once($KT_Tabset_uploadFileName);
		} else {
			die(sprintf($KT_Tabset_uploadErrorMsg,$KT_Tabset_uploadFileList[$KT_Tabset_i]));
		}
	}
    KT_session_start();
?>