<?php
	require_once __DIR__ . '/enable_errors.php';
	require_once __DIR__ . '/db_connect.php';
    require_once __DIR__ . '/exchange.php';
    require_once __DIR__ . '/db_functions.php';
    
    function sortCash($balance, $n)
    {
        for ($i = 1;$i<$n;$i++)
            for ($j = $i;$j>0;$j--)
            {
                if ($balance[$j]['amount'] < $balance[$j-1]['amount'])
                {
                    $temp = $balance[$j];
                    $balance[$j] = $balance[$j-1];
                    $balance[$j-1] = $temp;
                }
            }
        return $balance;
    }
    
    if (isset($_POST["ID_U"], $_POST["ID_G"]))
    {
        $id_u = $_POST["ID_U"];
        $id_g = $_POST["ID_G"];
        //$id_u = 1;
        //$id_g = 5;
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $sql = "SELECT currency FROM users WHERE ID_U = ".$id_u;
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $user_currency = $row['currency'];
        
        
        $db = new DB_CONNECT();
        $conn = $db->connect();
        $sql = "SELECT to_id, from_id, amount, currency FROM debt WHERE ID_G = ".$id_g;
        $result = $conn->query($sql);
        $debts = NULL;
        $i = 0;
        
        if ($result->num_rows==0)
        {
            echo "{}";
            return;
        }
        
        $bal = NULL;
        while ($row = $result->fetch_assoc())
        {
            $to = $row["to_id"];
            $from = $row["from_id"];
            $amount = exchange($row['currency'], $user_currency,$row['amount']);
            
            if (isset($bal[$to]))
                $bal[$to] += $amount;
            else
                $bal[$to] = $amount;
                
            if (isset($bal[$from]))
                $bal[$from] -= $amount;
            else
                $bal[$from] = -$amount;    
        }
        
        $balance = NULL;
        $i = 0;
        //move everything in an array
        foreach($bal as $id=>$amount)
        {
            if ($amount != 0)
            {
                $balance[$i] = array(
                        'id' => $id,
                        'amount' => $amount);
                $i+=1;
            }
        }
        $n = $i;
        $balance = sortCash($balance,$n); //sort by balance
        
        
		//remove matching balances
        
        //return;
        $finalTransaction = NULL;
        $count = 0;
        
        for ($i = 0; $i<$n; $i++)
        {
            if ($balance[$i]['amount']>0)
                break;
            for ($j = $n-1;$balance[$j]['amount']>=0 && $j>$i; $j--)
                if ($balance[$i]['amount'] == -$balance[$j]['amount'])
                {
                    $finalTransactions[$count]['to'] = $balance[$j]['id'];
                    $finalTransactions[$count]['from'] = $balance[$i]['id'];
                    $finalTransactions[$count]['amount'] = $balance[$j]['amount'];
                    $balance[$i]['amount'] = $balance[$j]['amount'] = 0;
                    $count++;
                }
        }
                
        //contract the finalTransactions array so it does not have people with 0 balance (after removing matching balances)
        $bal = NULL;
        $j = 0;
        for ($i = 0; $i < $n; $i++)
        {
            if ($balance[$i]['amount'] !=0)
            {
                $bal[$j] = $balance[$i];
                $j++;
            }
        }
        $n = $j;
        
        for ($i = 0; $i<$n; $i++)
        {
            $j = $n-1;
            while ($i<$j )
            {   
                if ($bal[$j]['amount']>0)
                {
                    $val = min (-$bal[$i]['amount'], $bal[$j]['amount']);
                    $finalTransactions[$count]['to'] = $bal[$j]['id'];
                    $finalTransactions[$count]['from'] = $bal[$i]['id'];
                    $finalTransactions[$count]['amount'] = $val;
                    $bal[$i]['amount'] += $val;
                    $bal[$j]['amount'] -= $val;
                    $count++;
                }
                $j--;
            }
        }
        
        
        //return only the transactions in which the given user was involved
        $ffTransactions = NULL;
        $j = 0;
       // var_dump($finalTransactions);
        for ($i = 0; $i < $count; $i++)
        {
            if ($finalTransactions[$i]['to'] == $id_u)
            {
				$other_id = $finalTransactions[$i]['from'];
                $ffTransactions[$other_id]['amount'] = $finalTransactions[$i]['amount'];
                $ffTransactions[$other_id]['id'] = $other_id;
                $tmp = fetchUserContact($other_id);
                $ffTransactions[$other_id]['name'] = $tmp['name'];
                $ffTransactions[$other_id]['email'] = $tmp['email'];
                $j++;
            }
            else if ($finalTransactions[$i]['from'] == $id_u)
            {
				$other_id = $finalTransactions[$i]['to'];
                $ffTransactions[$other_id]['amount'] = -$finalTransactions[$i]['amount'];
                $ffTransactions[$other_id]['id'] = $other_id;
                $tmp = fetchUserContact($other_id);
                $ffTransactions[$other_id]['name'] = $tmp['name'];
                $ffTransactions[$other_id]['email'] = $tmp['email'];
                $j++;
            }
        }
        //var_dump($ffTransactions);
        echo json_encode($ffTransactions);
        
    }
    
    
?>