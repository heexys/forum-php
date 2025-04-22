<?php
	function d($array) {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}

	// setting config
	define('PATH', __DIR__);
	$FOLDER = "pt";

	include PATH.'/db_conn.php';
	session_start();

	if (isset($_GET['action']) && $_GET['action'] === 'logout' && $_SESSION['login']) {
		session_unset();
		session_destroy();
		header('Location: /pt/?page=auth&message=logout_success');
		exit;
	  }

	//site structure
	if (!isset($_REQUEST['page'])) {
    include PATH.'/forum.php';
    exit;
}

	$page = ($_REQUEST['page']);

	
	if ($page === "topic") {
			include PATH.'/topic.php';
			exit;
	}
	
	if ($page === "reg") {
			include PATH.'/reg.php';
			exit;
	}
	
	if ($page === "auth") {
			include PATH.'/auth.php';
			exit;
	}

	echo 'Error 404 - Page not find, <a href="/pt/">back to main page</a>';
?>