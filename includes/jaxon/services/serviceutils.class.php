<?php
class ServiceUtils {
	function showMissingParamsError($service_name, $params) {
        $toret = array('error' => array('code' => 'ServiceError', 'message' => 'Missing parameters for "'. service_name .'": '. $params));
		die(KT_json($toret));
	}
	function showMissingAjaxServiceParamsError($params) {
        $toret = array('error' => array('code' => 'ServiceError', 'message' => $params));
		die(KT_json($toret));
	}
}
?>