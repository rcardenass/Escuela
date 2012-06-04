<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Rating_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Rating_uploadFileList = array(
		'../../services/service.php',
		'../../utils/json.php',
		'../../../common/KT_common.php',
		'../../../common/lib/db/KT_Db.php',
        'rating.class.php');

	for ($KT_Rating_i=0;$KT_Rating_i<sizeof($KT_Rating_uploadFileList);$KT_Rating_i++) {
		$KT_Rating_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Rating_uploadFileList[$KT_Rating_i];
		if (file_exists($KT_Rating_uploadFileName)) {
			require_once($KT_Rating_uploadFileName);
		} else {
			die(sprintf($KT_Rating_uploadErrorMsg,$KT_Rating_uploadFileList[$KT_Rating_i]));
		}
	}
    
?>