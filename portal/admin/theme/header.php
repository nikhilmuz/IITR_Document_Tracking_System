<?php
require_once(dirname(dirname(dirname(__FILE__))).'/includes/autoload.php');
$session=new Sessions();
if (!$session->chk_tok()){
header('Location: '.DOMAIN.PATH .'/login.php?msg=3');
}
else if(!(new Users($session->getID()))->isAdmin){
	die("Not an Admin!");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <!--JQuery UI Start-->
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <!--JQuery UI End-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width">
<title><?php echo TITLE; ?></title>
</HEAD>
<BODY>
	<div class="page-header">
		<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo DOMAIN.PATH; ?>/admin/dashboard.php"><?php echo TITLE; ?></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
        </button>
    </div>
    <div class="collapse navbar-collapse" id="Navbar">
      <ul class="nav navbar-nav">
        <li id="tab1"><a href="<?php echo DOMAIN.PATH.ADMIN; ?>/dashboard.php">Dashboard</a></li>
        <li id="tab2"><a href="<?php echo DOMAIN.PATH.ADMIN; ?>/reset_password.php">Reset Password</a></li>
        <li id="tab3"><a href="<?php echo DOMAIN.PATH.ADMIN; ?>/create_user.php">Create User</a></li>
        <li id="tab4"><a href="<?php echo DOMAIN.PATH.ADMIN; ?>/delete_user.php">Delete User</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <?php echo (new Users((new Sessions())->getID()))->fn; ?>'s Account
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo DOMAIN.PATH; ?>/profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
          <li><a href="<?php echo DOMAIN.PATH; ?>/prefrences.php"><span class="glyphicon glyphicon-cog"></span> Prefrences</a></li>
          <li><a href="<?php echo DOMAIN.PATH; ?>/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
          </li>
      </ul>
    </div>
  </div>
</nav>
	</div>
