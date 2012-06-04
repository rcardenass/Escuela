<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_EditInPlace_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_EditInPlace_uploadFileList = array(
		'../../services/service.php',
		'../../utils/json.php',
		'../../../common/KT_common.php',
		'../../../common/lib/db/KT_Db.php',
        'editinplace.class.php');

	for ($KT_EditInPlace_i=0;$KT_EditInPlace_i<sizeof($KT_EditInPlace_uploadFileList);$KT_EditInPlace_i++) {
		$KT_EditInPlace_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_EditInPlace_uploadFileList[$KT_EditInPlace_i];
		if (file_exists($KT_EditInPlace_uploadFileName)) {
			require_once($KT_EditInPlace_uploadFileName);
		} else {
			die(sprintf($KT_EditInPlace_uploadErrorMsg,$KT_EditInPlace_uploadFileList[$KT_EditInPlace_i]));
		}
	}
    
?>