<?php
	if(isset($_REQUEST['message'])) {
    $systemMessage = "";
    switch($_REQUEST['message']) {
      case 'reg_success':
        $systemMessage = "account created";
        break;

      case "logout_success":
        $systemMessage = "logout";
        break;

      case "login_fail":
        $systemMessage = "try another password or login";
        break;
      
      case 'login_success':
        $systemMessage = "Wellcome";
        break;
      
      case 'busy_data':
        $systemMessage = "User with the same email or login already exists.";
        break;
      }
    }
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>Forum - lets start meet</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<div class="wrapper">
    <div class="sidebar_left"></div>
    <div class="content">

<div class="header">
  <a href="/pt/">Forum</a>
  <div class="nav">

    <?php if(empty($_SESSION['login'])):?>
      <a href="/pt/?page=reg">SignUp</a>
      <a href="/pt/?page=auth">Login</a>
      <?php else: ?>
        <a href="/pt/?action=logout">Logout( <?=$_SESSION['login']?> )</a>
        <?php endif?>
        <span>Today: <?=date('d-m-Y', time()) ?></span>
      </div>
</div>
<hr />

<?php if(!empty($systemMessage)): ?>
  <div class="message_system">
    <b>System message: </b>
    <?=$systemMessage?>
  </div>
<?php endif ?>