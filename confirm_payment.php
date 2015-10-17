<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
    
    if (isset($_POST['to'], $_POST['from'], $_POST['value'], $_POST['currency'], $_POST["ID_G"]))
    {
        $db = new DB_CONNECT();
        $conn = $db->connect();
        
        $to = $_POST['to'];
        $from = $_POST['from'];
        $val = $_POST['value'];
        $currency = $_POST['currency'];
        $id_g = $_POST["ID_G"];
        if (isset($_POST['description'])
            $description = $_POST['description'];
        else
            $description = "-";
        
        $sql = "INSERT INTO owe (to, from, amount, currency, description, ID_G) ";
        $sql = $sql."VALUES(".$to.",".$from.",".$amount.",".$currency.",".$id_g.")";
        if ($conn->querry(&sql) == TRUE)
        {
            $response["result"] = 1;
            echo json_encode($response);
            return;
        }
        $response["result"] = 0;
        echo json_encode($response);
        return;        
    }
    $response["result"] = -1;
    echo json_encode($response);
    return;
        
?>