<?php
require_once(realpath(dirname(__FILE__)) . '/JSON.class.php');

function KT_json(& $var) {
	if (!isset($GLOBALS['json'])) {
		$GLOBALS['json'] = new Services_JSON();
	}
	return $GLOBALS['json']->encode($var);
}

function json_serialize(& $var) {
	if (!isset($GLOBALS['json'])) {
		$GLOBALS['json'] = new Services_JSON();
	}
	return $GLOBALS['json']->encode($var);
}

function json_deserialize($str) {
	if (!isset($GLOBALS['json'])) {
		$GLOBALS['json'] = new Services_JSON();
	}
	return $GLOBALS['json']->decode($str);
}

function array_merge_replace( $array, $newValues ) {
   foreach ( $newValues as $key => $value ) {
       if ( is_array( $value ) ) {
               if ( !isset( $array[ $key ] ) ) {
               $array[ $key ] = array();
           }
           $array[ $key ] = array_merge_replace( $array[ $key ], $value );
       } else {
           if ( isset( $array[ $key ] ) && is_array( $array[ $key ] ) ) {
               $array[ $key ][ 0 ] = $value;
           } else {
               if ( isset( $array ) && !is_array( $array ) ) {
                   $temp = $array;
                   $array = array();
                   $array[0] = $temp;
               }
               $array[ $key ] = $value;
           }
       }
   }
   return $array;
}

function getOrdering($rsName, $defaultField, $defaultOrder) {
	$toret = '';
	$paramName = 'KT_dyntable_order__'.$rsName;
	$paramName2 = 'KT_dyntable_order_value__'.$rsName;
	# set it in the session, if it exists
	$p = $GLOBALS['me']->getParam($paramName);
	if ($p) {
		# the default ordering
		$ordering = 'ASC';
		# get ordering : ASC or DESC, providing that a previous one existed in the user session 
		if (isset($_SESSION[$paramName])) { //the key: 'id_prd' etc
			if ($_SESSION[$paramName] == $GLOBALS['me']->getParam($paramName)) { 
				# we had id_prd, we passed id_prd, we have to switch
				switch($_SESSION[$paramName2]) {
					case 'ASC': $ordering = 'DESC'; break;
					case 'DESC': $ordering = 'ASC'; break;
				}
			} else {
				# we had a previous, does not matter what it is. 
			}
		} else {
			# we had nothing previous in the user session, set it with the default.
		}
		$_SESSION[$paramName] = $GLOBALS['me']->getParam($paramName);
		$_SESSION[$paramName2] = $ordering;
	}
	//die(var_dump($_SESSION));
	$toret = '';
	if (isset($_SESSION[$paramName])) {
		$toret = sprintf(' %s %s', $_SESSION[$paramName], $_SESSION[$paramName2]);
	} else {
		$toret = sprintf(' %s %s', $defaultField, $defaultOrder);
	}
	return $toret;
}

function getFiltering($rsName, $fields) {
	$toret = '1=1';
	$paramName = 'KT_dyntable_search__'.$rsName;
	$p = $GLOBALS['me']->getParam($paramName);
	if (isset($p)) {
		$tmp = $GLOBALS['me']->getParam($paramName);
		$postfix = " like '%".$tmp."%'";
		
		$arr = array();
		foreach ($fields as $k=>$v) {
			array_push($arr, $v . $postfix);
		}
		
		$toret = "(" . implode(" OR ", $arr) . ")";
	}
	return $toret;
}

?>