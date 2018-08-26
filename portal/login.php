<?php
require_once('plugins/session.php');
require_once('config.php');
if (chk_tok()){header('Location: track.php');}
if (isset($_POST['id'])&&isset($_POST['password'])){
    if (gen_tok(strtoupper($_POST['id']),$_POST['password'])) {header('Location: track.php');}
    else header('Location: '.DOMAIN.PATH.'/login.php?msg=1');}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<title>Login | <?php echo TITLE; ?></title>
</head>
	<body>
        <div class="row" style="padding-top:5%;">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="login well" align="center">
                    <h3>Please login<h3>
                    <div id="msgdiv">
                    </div>
                    <p align=center id=message></p><br/>
                     <form id="login" onsubmit="hash()" action="login.php" method="post">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						  <input class="form-control" name="id" type="text" placeholder="User Name" autofocus>
                        </div>
                        <br/>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input class="form-control" name="password" id="password" type="password" placeholder="Password">
                        </div>
                        <br>
                        <input class="btn btn-primary" id="submit" type="submit" value="Log In">
                     </form>
				</div>
            </div>
            <div class="col-sm-4"></div>
        </div>
        
<script src="<?php echo DOMAIN.PATH; ?>/js/hash.js"></script>
<script src="<?php echo DOMAIN.PATH; ?>/js/msg.js"></script>
<script>
function hash(){$("#password").val(sha256_digest($("#password").val()));
                $("#submit").attr("value","Logging In...");
                document.getElementById("submit").disabled = "true";}
$(document).ready(function(){
        switch (<?php if (isset($_GET['msg'])) echo $_GET['msg']; else echo "0"; ?>){
            case 1:
                generate_message('msgdiv','danger','Incorrect Credentials!','msgid','','clear');
                break;
			case 2:
                generate_message('msgdiv','success','Sucessfully Logged out','msgid','','clear');
                break;
			case 3:
                generate_message('msgdiv','info','You must login first.','msgid','','clear');
                break;
                }
         });
</script>
</body>
</html>
