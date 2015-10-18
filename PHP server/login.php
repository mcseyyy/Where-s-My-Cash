<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/exchange.php';
    
	if( $_POST["email"] && $_POST["password"] )
	{
		$db = new DB_CONNECT();
		$conn = $db->connect();
		$sql='SELECT name, ID_U, password, currency FROM users WHERE email = ?';
		$email = $_POST["email"];
		$password = $_POST["password"];
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
    
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
		$stmt->bind_param('s',$email);
		$stmt->execute();
		$stmt->bind_result($user_name, $id_u, $hashed_password,$user_currency);
    
		while ($stmt->fetch())
        {
            if (!password_verify($password, $hashed_password))
            {
                $response['result'] = -2;
                echo json_encode($response);
                return;
            }
            
			$response["result"] = 1;
            
            $response["ID_U"] = $id_u;
            $response["name"] = $user_name;
            $response["currency"] = $user_currency;
			echo json_encode($response);
			return;
		}
		$response["result"] = 0;
        $response['ID_U'] = -1;
		echo json_encode($response);
		exit();
	}
    $response["result"] = -1;
    echo json_encode($response);
    return;
?>