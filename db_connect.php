<?php
 
class DB_CONNECT {
 
    function __construct() {
    }
 
    function __destruct() {
    }

    function connect() {
        require_once __DIR__ . '/db_config.php';
		
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
		// check connection
		if ($conn->connect_error) {
		  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
		}
		
        return $conn;
	}
}
 
?>