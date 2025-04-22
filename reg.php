<?php
	if (isset($_GET['action']) && $_GET['action'] === 'reg' && $_SERVER['REQUEST_METHOD'] === 'POST') {
		$login = trim($_POST['login'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';
		$name = trim($_POST['name'] ?? '');
		$surname = trim($_POST['surname'] ?? '');

		$checkStmt = $connect->prepare("SELECT id FROM f_user WHERE login = ? OR email = ?");
		$checkStmt->bind_param("ss", $login, $email);
		$checkStmt->execute();
		$checkStmt->store_result();

		if ($checkStmt->num_rows > 0) {
			header('Location: /pt/?page=reg&message=busy_data');
			exit;
		}
	
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	
		$stmt = $connect->prepare("INSERT INTO f_user (login, email, password, name, surname) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $login, $email, $hashedPassword, $name, $surname);
		$stmt->execute();

		header('location: /pt/?page=auth&message=reg_success');
		exit;
	};
?>

<?php include PATH.'/header.php' ?>


<?php if(empty($_SESSION['login'])): ?>
	<form class="registration_form" action="/pt/?page=reg&action=reg" method="POST">
		<h1>Sign Up</h1>
		<input type="text" name="login" placeholder="Select Login" value="">
		<input type="email" name="email" placeholder="Select e-mail" value="" />
		<input type="password" name="password" placeholder="Create password" value="" />
		<input type="text" name="name" placeholder="Select name" value="" />
		<input type="text" name="surname" placeholder="Select surname" value="" />
		<input type="submit" value="Create account" />
	</form>
<?php else:?>
  <div class="">
    <p>You already in account. <a href="/pt/?action=logout">Logout</a></p>
  </div>
<?php endif ?>

<?php include PATH.'/footer.php' ?>