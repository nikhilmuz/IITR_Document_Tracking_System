<?php
require_once(dirname(__FILE__).'/includes/autoload.php');
$session=new Sessions();
if ($session->chk_tok()){
if((new Users($session->getID()))->isAdmin) {header('Location: '.PATH.ADMIN.'/dashboard.php');}
else header('Location: track.php');
}
else {header('Location: login.php');}