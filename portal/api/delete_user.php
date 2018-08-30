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
    if(isset($_POST['id'])&&$_POST['id']!=""&&$_POST['id']!=$id){
        (new DB())->forgetdb("users",array("enrlid"=>$_POST['id']));
        (new DB())->forgetdb("sessions",array("eid"=>$_POST['id']));
        echo 1;
    }
    else echo 0;
}
else echo 0;