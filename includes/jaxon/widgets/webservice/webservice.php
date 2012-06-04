<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_WebserviceuploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_WebserviceuploadFileList = array(
		'../../services/service.php',
        'webservice.class.php');

	for ($KT_Webservicei=0;$KT_Webservicei<sizeof($KT_WebserviceuploadFileList);$KT_Webservicei++) {
		$KT_WebserviceuploadFileName = dirname(realpath(__FILE__)). '/' . $KT_WebserviceuploadFileList[$KT_Webservicei];
		if (file_exists($KT_WebserviceuploadFileName)) {
			require_once($KT_WebserviceuploadFileName);
		} else {
			die(sprintf($KT_WebserviceuploadErrorMsg,$KT_WebserviceuploadFileList[$KT_Webservicei]));
		}
	}
    
?>