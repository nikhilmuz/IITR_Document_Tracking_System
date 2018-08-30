<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 7:56 AM
 */
require_once(dirname(dirname(__FILE__)).'/includes/autoload.php');
if((new Users((new Sessions())->getID()))->isAdmin){
 if(isset($_POST['id'])&&isset($_POST['newpwd'])&&$_POST['id']!=""&&$_POST['newpwd']!=""){
     (new DB())->changedb("users",array("pwd"=>$_POST['newpwd']),array("enrlid"=>$_POST['id']));
     echo 1;
 }
 else echo 0;
}
else echo 0;