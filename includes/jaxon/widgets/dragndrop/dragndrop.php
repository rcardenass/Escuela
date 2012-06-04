<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_DragnDrop_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_DragnDrop_uploadFileList = array(
		'../../services/service.php',
		'../../utils/json.php',
		'../../../common/KT_common.php',
		'../../../common/lib/db/KT_Db.php',
        'dragndrop.class.php');

	for ($KT_DragnDrop_i=0;$KT_DragnDrop_i<sizeof($KT_DragnDrop_uploadFileList);$KT_DragnDrop_i++) {
		$KT_DragnDrop_uploadFileName = dirname(realpath(__FILE__)). '/'. $KT_DragnDrop_uploadFileList[$KT_DragnDrop_i];
		if (file_exists($KT_DragnDrop_uploadFileName)) {
			require_once($KT_DragnDrop_uploadFileName);
		} else {
			die(sprintf($KT_DragnDrop_uploadErrorMsg,$KT_DragnDrop_uploadFileList[$KT_DragnDrop_i]));
		}
	}
    
?>