<?php

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'auth') {

    $login = $_POST['login'] ?? '';
    $passwordInput = $_POST['password'] ?? '';

    $stmt = $connect->prepare("SELECT * FROM f_user WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($passwordInput, $user['password'])) {
      $_SESSION['login'] = $user['login'];
      $_SESSION['user_id'] = $user['id'];
      header('Location: /pt/?message=login_success');
    } else {
      header('Location: /pt/?page=auth&message=login_fail');
    }
  }
?>

<?php include PATH.'/header.php' ?>

<?php if(empty($_SESSION['login'])): ?>
  <form class="registration_form" action="/pt/?page=auth&action=auth" method="POST">
    <h1>Login</h1>
    <input type="text" name="login" placeholder="login" value="" />
    <input type="password" name="password" placeholder="password" value="" />
    <input type="submit" value="Sign in" />
  </form>
<?php else:?>
  <div class="">
    <p>You already in account. <a href="/pt/?action=logout">Logout</a></p>
  </div>
<?php endif ?>

<?php include PATH.'/footer.php' ?>