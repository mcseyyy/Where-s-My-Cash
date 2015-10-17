<?php
    //function exchange1($from, $to, $value)
    //{
    //    $rate['USD']['EUR'] = 0.922;
    //    $rate['EUR']['USD'] = 1.084;
    //    $rate['USD']['GBP'] = 0.665;
    //    $rate['GBP']['USD'] = 1.503;
    //    $rate['EUR']['GBP'] = 0.721;
    //    $rate['GBP']['EUR'] = 1.386;
    //    
    //    if ($from === $to)
    //        return $value;
    //        
    //    return $value * $rate[$from][$to];
    //}
    
 
    
    function exchange($from, $to, $value)
    {
        //echo "here";
        //return 22;
        $url = 'http://finance.yahoo.com/d/quotes.csv?f=l1d1t1&s='.$from.$to.'=X';
        $handle = fopen($url, 'r');
        
        if ($handle)
        {
            $result = fgetcsv($handle);
            fclose($handle);
        }
        $rate = $result[0];
        return sprintf('%.2f',$value * $rate);
    }
?>