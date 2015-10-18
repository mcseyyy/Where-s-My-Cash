<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
    
    if (isset($_POST["ID_G"]))
    {
        $id_g = $_POST["ID_G"];
        $sql = "SELECT users.ID_U, users.name, users.email FROM users, people_in_groups WHERE people_in_groups.ID_U = users.ID_U AND people_in_groups.status=1 AND people_in_groups.ID_G = ".$id_g;
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $result = $conn->query("$sql");
        if ($result->num_rows==0)
        {
            echo "{}";
            return;
        }
        $users = NULL;
        while ($row = $result->fetch_assoc())
        {
            $users[$row['ID_U']] = $row;
        }
        
        echo json_encode($users);
        
    }
?>