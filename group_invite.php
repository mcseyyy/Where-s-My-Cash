<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
    require_once __DIR__ . '/exchange.php';
    require_once __DIR__ . '/db_functions.php';
    require_once __DIR__ . '/email_notification.php';
	
    if (isset($_POST['ID_G'], $_POST['email'], $_POST['invited_by']))
    { //invited_by needs to be the ID_U 
		echo $_POST['email'] . " <br>";
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $sql = "SELECT ID_U FROM users WHERE email = '".$_POST['email']."'";
		echo $sql."   kk<br>";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        $id_u = $row['ID_U'];  
			echo $id_u." LOLOLO <br>";
        $id_g = $_POST['ID_G'];
        $invited_by = $_POST['invited_by'];
        
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $sql = "INSERT INTO people_in_groups ( ID_G, ID_U, status, invited_by) VALUES (".$id_g.",".$id_u.",0,".$invited_by.")";
		echo $sql;
        $result = $conn->query($sql);
		echo $sql;
        echo json_encode($result);
		$db = new DB_CONNECT();
		$conn = $db->connect();
		$sql = 'SELECT `name` FROM `groups` WHERE `ID_G` = ?';
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param('i',$id_g);
		$stmt->execute();
		$stmt->bind_result($name);
		$stmt->fetch();
		return; emailNotification($id_u, "Invited to group", sprintf(
			"Hi %%name%%,\nYou have been invited to join %s! Go to Where's My Cash to accept.",
			$name));
    }
    echo "{}";
    
    
	
?>
 