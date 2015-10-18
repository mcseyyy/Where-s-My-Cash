<?php
	require_once __DIR__ . '/db_connect.php';
	
	function insertWithPost($table, $typeString, ...$params) {
		// Argument validation
		if(count($params) <= 0) {
			//echo 'Missing parameters.';
			return 0;
		}
		if(count($params) != strlen($typeString)) {
			//echo 'TypeString length does not match parameters.';
			return 0;
		}
		// Get and validate POST values
		$get_post = function($val) {
			return $_POST[$val];
		};
		$param_vals = array_map($get_post, $params);
		foreach ($param_vals as $param_val) {
			if (isset($param_val) == FALSE) {
				//echo 'POST parameters not set.';
				return 0;
			}
		}
		// Generate SQL query
		$sql = 'INSERT INTO `appathon`.`'.$table.'` ';
		$sql = $sql.'(`'.$params[0];
		for ($c = 1; $c < count($params); $c++) {
			$sql = $sql.'`, `'.$params[$c];
		}
		$sql = $sql . '`) VALUES (?';
		for ($c = 1; $c < count($params); $c++) {
			$sql = $sql.',?';
		}
		$sql = $sql . ')';
		global $conn;
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param($typeString,...$param_vals);
		if( $stmt->execute() == TRUE ) {
			return 1;
		}
		else {
			return 0;
		}
	}
	
	function fetchUserContact($id_u) {
		$result = NULL;
		global $conn;
		$sql = 'SELECT `name`, `email` FROM `appathon`.`users` WHERE `ID_U` = ?';
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param('i',$id_u);
		if($stmt->execute() == 1){
			$stmt->bind_result($result['name'], $result['email']);
			$stmt->fetch();
		}
		return $result;
	}
		
?>