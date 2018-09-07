<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 7:56 AM
 */
require_once(dirname(dirname(__FILE__)).'/includes/autoload.php');
$id=(new Sessions())->getID();
if((new Users($id))->isAdmin){
    if(isset($_POST['awb'])&&$_POST['awb']!=""){
        (new DB())->forgetdb("awb_meta",array("awb"=>$_POST['awb']));
        (new DB())->forgetdb("events",array("awb"=>$_POST['awb']));
        echo 1;
    }
    else echo 0;
}
else echo 0;