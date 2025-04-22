<?php
	$username = "heexys";
	$password = "aloS1";
	$dbname = "h_forum";

	$connect = new mysqli( "localhost", $username, $password, $dbname );

	if ($connect->connect_error) {
			die('Something went wrong! error: '.$connect->connect_error);
	}
?>