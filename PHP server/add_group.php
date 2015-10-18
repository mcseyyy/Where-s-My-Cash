<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/db_functions.php';
	
	$db = new DB_CONNECT();
	$conn = $db->connect();
	$success = 0;
	if(insertWithPost("groups", "s", "name") == 1){
		$_POST['status'] = 1;
		$_POST['ID_G'] = $conn->insert_id;
		$_POST['invited_by'] = $_POST['ID_U'];
		$db = new DB_CONNECT();
		$conn = $db->connect();
		if(insertWithPost("people_in_groups", "iiii", 'ID_G', 'ID_U', 'status', 'invited_by') == 1){
			$success = 1;
		}
	}
	$result = array(
		'result' => $success,
		'id' => $_POST['ID_G']
	);
	echo json_encode($result);
?>
 
