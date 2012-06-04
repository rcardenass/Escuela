<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

class DragNDrop {
    var $connectionName = null;
    var $tableName = null;
    var $relPath = null;
	var $primaryKey = null;
	var $foreignKey = null;
	var $orderFieldName = null;
	var $orderFieldType = "NUMERIC_TYPE";
	
	var $items = array();
	var $dropZones = array();
	
		
	function DragNDrop($id) {
		$this->id = $id;
	}

	function setConnection($connectionName) {
		$this->connectionName = $connectionName;
	}

	function setTable($tableName) {
		$this->tableName = $tableName;
	}

	function setPrimaryKey($primaryKey) {
		$this->primaryKey = $primaryKey;
	}

	function setForeignKey($foreignKey) {
		$this->foreignKey = $foreignKey;
	}

	function setSortableList($orderFieldName) {
		$this->orderFieldName = $orderFieldName;
	}

	function renderDNDItem($itemID, $dropZoneID) {
		if (!isset($dropZoneID) || is_null($dropZoneID)) {
			$dropZoneID = "";
		}		
		$itemProps = array("pk" => $itemID, "fk" => $dropZoneID);
		$itemUniqueID =  $this->id . "_item_" . $itemID;
		$this->items[$itemUniqueID] = $itemProps;
		return $itemUniqueID;
	}

	function renderDNDDropZone($dropZoneID) {
		if (!isset($dropZoneID) || is_null($dropZoneID)) {
			$dropZoneID = "";
		}
		$dropZoneProps = array("pk" => $dropZoneID);
		$dropZoneIDUniqueID = $this->id . "_dropzone_" . $dropZoneID;
		$this->dropZones[$dropZoneIDUniqueID] = $dropZoneProps;
		return $dropZoneIDUniqueID;
	}
	
	function renderDNDDropList($dropZoneID) {
		if (!isset($dropZoneID) || is_null($dropZoneID)) {
			$dropZoneID = "";
		}
		return $this->id . "_dropzone_" . $dropZoneID . "_droplist";
	}

	function renderDNDJsBindings() {
		$toRet = '<script  type="text/javascript">
            <!--
			Widgets.makeDraggables("' . $this->id . '", {';
		$firstItem = true;		
		foreach ($this->items as $itemUniqueID => $props) {
			if (!$firstItem) {
				$toRet .= ', '; 
			}
			$firstItem = false;
			$toRet .= '"' . $itemUniqueID . '": {"pk":"' . $props["pk"]  . '", "fk":"' . $props["fk"] . '"}';
		} 	
		$toRet .= '}, {';
		$comma = '';
		if (isset($this->foreignKey)) {	
			$toRet .= 'onCategoryUpdate: ' . $this->id . '_setCategory';
			$comma = ',';
		}
		if (isset($this->orderFieldName)) {
			$toRet .= $comma . 'onSort: '. $this->id . '_sortList';
		}
		$toRet .= '});'. "\n";
		
		$toRet .= '
			Widgets.makeDropZones("' . $this->id . '", {';
		$firstItem = true;
		foreach ($this->dropZones as $dropZoneUniqueID => $props) {
			if (!$firstItem) {
				$toRet .= ', '; 
			}
			$firstItem = false;
			$toRet .= '"' . $dropZoneUniqueID . '" : {"pk": "' . $props["pk"] . '"}';
		} 	
		$toRet .= '});'. "\n";
        $toRet .= '//-->' . "\n";
		$toRet .= '</script>';
		return $toRet;		
	}

	function setCategory($primaryKeyValue, $foreignKeyValue) {
		if (!isset($this->foreignKey)) {
			return array('error' => array('code' => 'Settings error', 'message' => 'You cannot call setCategory if no foreign key was specified'));
		}
		require_once(realpath(dirname(__FILE__) . '/' . '/../../../../Connections/' .$this->connectionName.'.php'));
		$hostname = 'MM_' . $this->connectionName . '_HOSTNAME';
        
        $connWrap = null;
		if (empty($GLOBALS[$hostname])) {
			// we are on mysql
			// Make unified connection variable
			$database = 'database_' . $this->connectionName;
			$connWrap = new KT_Connection($GLOBALS[$this->connectionName], $GLOBALS[$database]);
		} else {
			$connWrap = $GLOBALS[$this->connectionName];
		}		
		$rs = $connWrap->Execute('UPDATE '. $this->tableName . 
				' SET '. KT_escapeFieldName($this->foreignKey) .' = '. KT_escapeForSql($foreignKeyValue, "NUMERIC_TYPE") .
				' WHERE '. KT_escapeFieldName($this->primaryKey) .' = '. KT_escapeForSql($primaryKeyValue, "NUMERIC_TYPE"));
		if ($rs !== false){
			return "OK";
		}else{
			return array('error' => array('code' => 'SQL Error', 'message' => 'Update category failed: '.$connWrap->ErrorMsg()));
		}
	}

	function sortList($primaryKeyValue, $foreignKeyValue, $over_primaryKeyValue, $insert_position) {
		if ($insert_position != "before" && $insert_position != "after") {
			$insert_position = "before";
		}
		
		require_once(realpath(dirname(__FILE__) . '/' . '/../../../../Connections/' .$this->connectionName.'.php'));
		$hostname = 'MM_' . $this->connectionName . '_HOSTNAME';
        $connWrap = null;
		if (empty($GLOBALS[$hostname])) {
			// we are on mysql
			// Make unified connection variable
			$database = 'database_' . $this->connectionName;
			$connWrap = new KT_Connection($GLOBALS[$this->connectionName], $GLOBALS[$database]);
		} else {
			$connWrap = $GLOBALS[$this->connectionName];
		}
		
		// GET CURRENT ORDER VALUE
		$sql = 'SELECT '. KT_escapeFieldName($this->orderFieldName) .
			' FROM ' . $this->tableName . 
			' WHERE '. KT_escapeFieldName($this->primaryKey) . ' = ' . KT_escapeForSql($primaryKeyValue, "NUMERIC_TYPE");
		$rs = $connWrap->Execute($sql);
		if ($rs === false) {
			return array('error' => array('code' => 'SQL Error', 'message' => 'select current order failed: '.$connWrap->ErrorMsg()));
		}
		
		// UPDATE ORDER VALUE IF CURRENT IS NULL
		if (is_null($rs->Fields($this->orderFieldName))) {
			// update order to the max + 1 value
			$sql = 'SELECT MAX(' . KT_escapeFieldName($this->orderFieldName) . ')+1 as max_order' .
				' FROM ' . $this->tableName;
			$rs = $connWrap->Execute($sql);
			if ($rs === false) {
				return array('error' => array('code' => 'SQL Error', 'message' => 'select max order failed: '.$connWrap->ErrorMsg()) );
			}
			$max_order = (int)$rs->Fields("max_order");
			$sql = 'UPDATE '.  $this->tableName . 
			' SET ' . KT_escapeFieldName($this->orderFieldName) . ' = ' . KT_escapeForSql($max_order, "NUMERIC_TYPE") .
			' WHERE ' . KT_escapeFieldName($this->primaryKey) . ' = ' . KT_escapeForSql($primaryKeyValue, "NUMERIC_TYPE");
			$rs = $connWrap->Execute($sql);
			if ($rs === false) {
				return array('error' => array('code' => 'SQL Error', 'message' => 'update order value failed: '.$connWrap->ErrorMsg()));
			}
			return "OK";
		}
		$currentOrderValue = (int)$rs->Fields($this->orderFieldName);
		
		// GET TARGET POSITION
		$insert_as_min = false;
		$insert_as_max = false;
		if (!isset($over_primaryKeyValue) || ($over_primaryKeyValue == "")) {
			if ($insert_position == "before") {
				$sql = 'SELECT MIN(' . KT_escapeFieldName($this->orderFieldName) . ') as target_order';
				$insert_as_min = true;
			} else {
				$sql = 'SELECT MAX(' . KT_escapeFieldName($this->orderFieldName) . ') as target_order';
				$insert_as_max = true;
			}
			$sql .= ' FROM ' . $this->tableName .
			        ' WHERE '.KT_escapeFieldName($this->primaryKey) . ' != ' . KT_escapeForSql($primaryKeyValue, "NUMERIC_TYPE");
			if (isset($this->foreignKey)) { 
				if 	(isset($foreignKeyValue) && $foreignKeyValue!= "") {
					$sql .=	' AND ' . KT_escapeFieldName($this->foreignKey) . ' = ' . KT_escapeForSql($foreignKeyValue, "NUMERIC_TYPE");
				} else {
					$sql .=	' AND ' . KT_escapeFieldName($this->foreignKey) . ' is null OR '. KT_escapeFieldName($this->foreignKey) . '=0';
				}
			}
			$rs = $connWrap->Execute($sql);
			if ($rs === false) {
				return array('error' => array('code' => 'SQL Error', 'message' => 'select target order failed: '.$connWrap->ErrorMsg()) );
			}
			if ($rs->EOF) {
				// keep the current value for order, as there are no other items in the category
				return 'OK';
			}
			$targetOrderValue = (int)$rs->Fields("target_order");
		}
		else {
			$sql = 'SELECT '. KT_escapeFieldName($this->orderFieldName) .
				' FROM ' . $this->tableName . 
				' WHERE '. KT_escapeFieldName($this->primaryKey) . ' = ' . KT_escapeForSql($over_primaryKeyValue, "NUMERIC_TYPE");
			$rs = $connWrap->Execute($sql);	
			if ($rs === false) {
				return array('error' => array('code' => 'SQL Error', 'message' => 'select targeted order failed: '.$connWrap->ErrorMsg()));
			}
			$targetOrderValue = (int)$rs->Fields($this->orderFieldName);
			if ($insert_position == "after") {
				if ($currentOrderValue > $targetOrderValue) {		
					$sql = 'SELECT '. KT_escapeFieldName($this->orderFieldName) .
					' FROM ' . $this->tableName . 
					' WHERE '. KT_escapeFieldName($this->orderFieldName) . ' > ' . KT_escapeForSql($targetOrderValue, "NUMERIC_TYPE") .
					' ORDER BY ' . KT_escapeFieldName($this->orderFieldName) . ' ASC';
					$rs = $connWrap->Execute($sql);	
					if ($rs === false) {
						return array('error' => array('code' => 'SQL Error', 'message' => 'select targeted order value failed: '.$connWrap->ErrorMsg()));
					}
					if (!$rs->EOF) {
						$targetOrderValue = (int)$rs->Fields($this->orderFieldName);
					}
				}
			} else {
				if 	($currentOrderValue < $targetOrderValue) {
					$sql = 'SELECT '. KT_escapeFieldName($this->orderFieldName) .
					' FROM ' . $this->tableName . 
					' WHERE '. KT_escapeFieldName($this->orderFieldName) . ' < ' . KT_escapeForSql($targetOrderValue, "NUMERIC_TYPE") .
					' ORDER BY ' . KT_escapeFieldName($this->orderFieldName) . ' DESC';
					
					$rs = $connWrap->Execute($sql);	
					if ($rs === false) {
						return array('error' => array('code' => 'SQL Error', 'message' => 'select targeted order value failed: '.$connWrap->ErrorMsg()));
					}
					if (!$rs->EOF) {
						$targetOrderValue = (int)$rs->Fields($this->orderFieldName);
					}
				}
			}
		}
		
		if ($currentOrderValue < $targetOrderValue) {
			if (!$insert_as_min) {
                // if the order field has unique key set on it, must assure thare are no duplicates in order field
                
                // get the max + 1 value 
                $sql = 'SELECT MAX(' . KT_escapeFieldName($this->orderFieldName) . ')+1 as max_order' .
                    ' FROM ' . $this->tableName;
                $rs = $connWrap->Execute($sql);
                if ($rs === false) {
                    return array('error' => array('code' => 'SQL Error', 'message' => 'assure unique order: select max order failed: '.$connWrap->ErrorMsg()) );
                }
                $max_order = (int)$rs->Fields("max_order");
                
                // add max+1 value to all the items that need to be shift
				$sql = 'UPDATE '.  $this->tableName . 
				' SET ' . KT_escapeFieldName($this->orderFieldName) . '=' . KT_escapeFieldName($this->orderFieldName) . '+ ' . $max_order .
				' WHERE '. KT_escapeFieldName($this->orderFieldName) . ' <= ' . $targetOrderValue .
				' AND '	. KT_escapeFieldName($this->orderFieldName) . ' > ' . $currentOrderValue;
                
				$rs = $connWrap->Execute($sql);
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'shift order values: '.$connWrap->ErrorMsg()));
				}
                // place current item to its final position
				$sql = 'UPDATE '.  $this->tableName . 
				' SET ' . KT_escapeFieldName($this->orderFieldName) . '=' . $targetOrderValue . 
				' WHERE '. KT_escapeFieldName($this->primaryKey) . ' = ' . KT_escapeForSql($primaryKeyValue, "NUMERIC_TYPE");
                
				$rs = $connWrap->Execute($sql);
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'update item position: '.$connWrap->ErrorMsg()));
				}
                
                // substract (max+2) from all the items that were previously shift
				$sql = 'UPDATE '.  $this->tableName . 
				' SET ' . KT_escapeFieldName($this->orderFieldName) . '=' . KT_escapeFieldName($this->orderFieldName) . ' - ' . ($max_order+1) .
				' WHERE '. KT_escapeFieldName($this->orderFieldName) . ' >= ' . $max_order;

				$rs = $connWrap->Execute($sql);
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'shift back order values: '.$connWrap->ErrorMsg()));
				}                
			}
		}
		if ($currentOrderValue > $targetOrderValue) {
			if(!$insert_as_max) {
                // if the order field has unique key set on it, must assure thare are no duplicates in order field
                
                // get the max + 1 value 
                $sql = 'SELECT MAX(' . KT_escapeFieldName($this->orderFieldName) . ')+1 as max_order' .
                    ' FROM ' . $this->tableName;
                $rs = $connWrap->Execute($sql);
                if ($rs === false) {
                    return array('error' => array('code' => 'SQL Error', 'message' => 'assure unique order: select max order failed: '.$connWrap->ErrorMsg()) );
                }
                $max_order = (int)$rs->Fields("max_order");
                
                // add max+1 value to all the items that need to be shift
				$sql = 'UPDATE '.  $this->tableName . 
				' SET ' . KT_escapeFieldName($this->orderFieldName) . '=' . KT_escapeFieldName($this->orderFieldName) . '+ ' . $max_order .
				' WHERE '. KT_escapeFieldName($this->orderFieldName) . ' >= ' . $targetOrderValue .
				' AND '	. KT_escapeFieldName($this->orderFieldName) . ' < ' . $currentOrderValue;
				$rs = $connWrap->Execute($sql);
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'shift order values: '.$connWrap->ErrorMsg()));
				}
                // place current item to its final position
				$sql = 'UPDATE '.  $this->tableName . 
				' SET ' . KT_escapeFieldName($this->orderFieldName) . '=' . $targetOrderValue . 
				' WHERE '. KT_escapeFieldName($this->primaryKey) . ' = ' . KT_escapeForSql($primaryKeyValue, "NUMERIC_TYPE");
				$rs = $connWrap->Execute($sql);
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'update item position: '.$connWrap->ErrorMsg()));
				}
                
                // substract (max+2) from all the items that were previously shift
				$sql = 'UPDATE '.  $this->tableName . 
				' SET ' . KT_escapeFieldName($this->orderFieldName) . '=' . KT_escapeFieldName($this->orderFieldName) . ' - ' . ($max_order-1) .
				' WHERE '. KT_escapeFieldName($this->orderFieldName) . ' >= ' . $max_order;
				$rs = $connWrap->Execute($sql);
				if ($rs === false) {
					return array('error' => array('code' => 'SQL Error', 'message' => 'shift back order values: '.$connWrap->ErrorMsg()));
				}
			}
		}
		
		return "OK";
	}
}
?>