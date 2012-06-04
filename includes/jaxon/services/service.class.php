<?php
class Service {
	var $o = null;
	var $mandatoryParams = array();

	function Service(&$o) {
		$this->o = &$o;
	}

	function setMandatoryParams($p) {
		$this->mandatoryParams = $p;
	}

	function getMethod() {
		$m = $_GET['ServiceMethod'];
		if (in_array($m, $this->o->exportedMethods)) {
			return $m;
		}
		return null;
	}

	function execute() {
		$m = $this->getMethod();

		$params = array();
		if (isset($_GET['params'])) {
			$params = array_values($_GET['params']);
		}
		if (!is_null($m)) {
			$toret = call_user_func_array(array(&$this->o, $m), $params);
			return KT_json($toret);
		}
	}
}

?>