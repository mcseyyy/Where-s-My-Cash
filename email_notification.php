<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';

	function emailNotification($id_u, $subject, $message){
		$db = new DB_CONNECT();
		$conn = $db->connect();
		$sql = 'SELECT `name`, `email`, `email_notifications` FROM `users` WHERE `ID_U` = ?';
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param('i',$id_u);
		$stmt->execute();
		$stmt->bind_result($name, $email, $enabled);
		$stmt->fetch();
		if($enabled == 1){
			$fMessage = str_replace("%name%", $name, $message);
			$fSubject = "Where's My Cash: ".$subject;
			$headers = 'From: server@wheresmycash.tk' . "\r\n" .
				'Reply-To: server@wheresmycash.tk' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			return mail($email, $fSubject, $fMessage, $headers);
		}
		return FALSE;
	}
?>