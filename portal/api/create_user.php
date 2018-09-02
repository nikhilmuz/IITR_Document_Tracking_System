<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 7:56 AM
 */
require_once(dirname(dirname(__FILE__)).'/includes/autoload.php');
$user=new Users((new Sessions())->getID());
if($user->isAdmin){
 if(isset($_POST['fn'])&&isset($_POST['ln'])&&isset($_POST['un'])&&isset($_POST['pwd'])&&isset($_POST['dob'])&&isset($_POST['ph'])&&isset($_POST['email'])&&isset($_POST['office'])&&$_POST['fn']!=""&&$_POST['un']!=""&&$_POST['pwd']!=""&&$_POST['ph']!=""&&$_POST['email']!=""&&$_POST['office']!=""){
     if($user->checkUsername($_POST['un'])){
         echo 2;
     }
     else{
     (new DB())->telldb("users",array(
         'enrlid',
         'id',
         'pwd',
         'fn',
         'ln',
         'dob',
         'ph',
         'email',
         'officeid',
         'permission'
         ),
     array(
         time(),
         strtoupper($_POST['un']),
         hash("sha256",$_POST['pwd']),
         $_POST['fn'],
         $_POST['ln'],
         $_POST['dob'],
         $_POST['ph'],
         $_POST['email'],
         $_POST['office'],
         ""
     )
     );
         echo 1;
     }
 }
 else echo 0;
}
else echo 0;