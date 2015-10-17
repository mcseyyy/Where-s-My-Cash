<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	
	$success = 0;
	if (isset($_POST['ID_G'], $_POST['ID_U']) == TRUE)
	{
		$db = new DB_CONNECT();
		$conn = $db->connect();
		$id_g = $_POST["ID_G"];
		$id_u = $_POST["ID_U"];
		$sql = 
			'DELETE FROM `appathon`.`people_in_groups` '.
			'WHERE `ID_G` = ? AND `ID_U` = ?';
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param('ii',$id_g,$id_u);
		if( $stmt->execute() == TRUE ) {
			$success = 1;
		}
    }
	$result = array(
		'result' => $success
	);
	echo json_encode($result);
?>
 