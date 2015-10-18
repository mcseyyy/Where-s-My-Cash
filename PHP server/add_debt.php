<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/db_functions.php';
	
    if (isset($_POST['from_id']))
    if ($_POST['from_id'] >= 0)
    {
        $db = new DB_CONNECT();
        $conn = $db->connect();
        
        $result = array(
            'result' =>
                insertWithPost("debt", "iidssi", 'to_id', 'from_id', 'amount', 'currency', 'description', 'ID_G')
        );
        echo json_encode($result);
        return;
    }
    $db = new DB_CONNECT();
    $conn = $db->connect();
    
    $id_g = $_POST['ID_G'];
    $to_id = $_POST['to_id'];
    $currency = $_POST['currency'];
    $description = $_POST['description'];
    
    $sql = "SELECT ID_U FROM people_in_groups WHERE status=1 AND ID_G = ".$id_g." AND ID_U != ".$to_id;
    $result = $conn->query($sql);
	//echo $sql;
	$count = $result->num_rows+1;
    $amount = $_POST['amount'];
	$amount = $amount/$count;
    while ($row = $result->fetch_assoc())
    {
        $from_id = $row['ID_U'];
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $sql = "INSERT INTO debt ( to_id, from_id, amount, currency,description, ID_G)";
        $sql = $sql."VALUES (".$to_id.",".$from_id.",".$amount.",'".$currency."','".$description."',".$id_g.")";
		echo $sql;
        $res = $conn->query($sql);
        echo json_encode($res);
    }
    
    
    
    
    
?>
 