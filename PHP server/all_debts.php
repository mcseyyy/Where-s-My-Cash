<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/exchange.php';
	
	$debts = NULL;
	if (isset($_POST['ID_U'], $_POST['ID_G']) == TRUE)
	{
		$db = new DB_CONNECT();
		$conn = $db->connect();
		$id_u = $_POST["ID_U"];
		$id_g = $_POST["ID_G"];
		$sql = 'SELECT `currency` FROM `users` WHERE `ID_U` = ?';
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		}
		$stmt->bind_param('i',$id_u);
		if($stmt->execute() == 1){
			$stmt->bind_result($user_currency);
			$stmt->fetch();
			$db = new DB_CONNECT();
			$conn = $db->connect();
			$sql = 
				'SELECT `appathon`.`users`.`name`, `appathon`.`debt`.`to_id`, '.
					'`appathon`.`debt`.`from_id`, `appathon`.`debt`.`amount`, '.
					'`appathon`.`debt`.`currency`, `appathon`.`debt`.`ID_D`, '.
					'`appathon`.`debt`.`description` '.
				'FROM `appathon`.`debt`, `appathon`.`users` '.
				'WHERE `appathon`.`debt`.`ID_G` = ? '.
					' AND ((`appathon`.`debt`.`to_id` = ? '.
							'AND `appathon`.`debt`.`from_id` = `appathon`.`users`.`ID_U`) '.
						'OR (`appathon`.`debt`.`to_id` = `appathon`.`users`.`ID_U` '.
							'AND `appathon`.`debt`.`from_id` = ? )) ';
			$stmt = $conn->prepare($sql);
			if($stmt === false) {
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
			}
			$stmt->bind_param('iii',$id_g,$id_u,$id_u);
			$stmt->execute();
			$stmt->bind_result($name, $debtor, $debtee, $amount, $currency, $id_d, $description);
			$i = 0;
			while ($stmt->fetch()) {
				$debt_val = exchange($currency, $user_currency, $amount);
				if($debtor == $id_u){
					$other_id = $debtee;
				}
				else{
					$other_id = $debtee;
					$debt_val *= -1;
				}
				$debts[$id_d] = array(
					'id_u' => $other_id,
					'name' => $name,
					'amount' => $debt_val,
					'description' => $description
				);
			}
		}
    }
	echo json_encode($debts);
?>


 