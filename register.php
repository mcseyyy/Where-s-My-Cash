<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/db_functions.php';

	$db = new DB_CONNECT();
	$conn = $db->connect();
	$_POST['password'] = password_hash($_POST['password_plain'], PASSWORD_DEFAULT);
	$success = insertWithPost("users", "sssiss",
		'email', 'password', 'name', 'email_notifications', 'password_plain', 'currency');
	$id = 0;
	$name = "";
	$currency = "";
	if($success == 1){
		$id = $conn->insert_id;
		$sql = 'SELECT `name`, `currency` FROM `users` WHERE `ID_U` = ?';
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param('i',$id);
		if($stmt->execute() == 1){
			$stmt->bind_result($name, $currency);
			$stmt->fetch();
		}
		else{
			$id = -1;
		}
	}
	$result = array(
		'result' => $success,
		'ID_U' => $id,
		'name' => $name,
		'currency' => $currency
	);
	echo json_encode($result);
?>