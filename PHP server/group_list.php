
<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/exchange.php';
    
    
    function balance($user_id, $group_id, $user_currency)
    {
        //return 22;
        $bal = 0;
        $db = new DB_CONNECT();
		$conn = $db->connect();
        $sql = "SELECT amount, currency FROM debt WHERE to_id=".$user_id." AND ID_G=".$group_id;
        $result = $conn->query($sql);
        
        if ($result->num_rows>0)
            while ($row = $result->fetch_assoc())
            {
                $bal += exchange($row['currency'] ,$user_currency, $row['amount']);
            }
        
        $db = new DB_CONNECT();
		$conn = $db->connect();
        $sql = "SELECT amount, currency FROM debt WHERE from_id=".$user_id." AND ID_G=".$group_id;
        $result = $conn->query($sql);
        if ($result->num_rows>0)
            while ($row = $result->fetch_assoc())
            {
                $bal -= exchange($row['currency'] ,$user_currency, $row['amount']);
            }
        return $bal;
    }
    
    if (isset($_POST['ID_U']))
    {
        $id_u = $_POST['ID_U'];
        $groups = array();
        $sql = NULL;
        $sql = "SELECT people_in_groups.ID_G, people_in_groups.status, users.name, groups.name
                FROM people_in_groups, groups, users
                WHERE people_in_groups.ID_U = ?
                    AND people_in_groups.ID_G=groups.ID_G
                    AND users.ID_U = people_in_groups.ID_U";
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        if ($stmt == false)
            trigger_error('Wrong SQL: ' . $sql . '<br>Error: ' . $conn->error, E_USER_ERROR);
        $stmt->bind_param('i', $id_u);
        $stmt->execute();
        $stmt->bind_result($id_g, $status, $invited_by, $name);
        while ($stmt->fetch())
        {
            $group["ID_G"] = $id_g;
            $group["status"] = $status;
            $group["invited_by"] = $invited_by;
            $group["name"] = $name;
            array_push($groups, $group);
        }
        //var_dump( $groups);
        
        $sql = "SELECT currency from users WHERE ID_U = ".$id_u;
        $db = new DB_CONNECT();
		$conn = $db->connect();
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $user_currency = $row['currency'];
        $results = NULL;
        foreach($groups as $group)
        {
            $group['balance'] = balance($id_u, $group["ID_G"],$user_currency);
			$results[$group["ID_G"]] = $group;
            //$group['balance'] = 22;
        }
        echo json_encode($results);
    }
    



?>