<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 6:52 AM
 */
require_once(dirname(dirname(__FILE__)).'/includes/autoload.php');
$shipment=new Shipment($_POST['awb']);
if ($shipment->status){
    echo 0;
    die();
}
$shipment->addEvent($_POST['remarks'],$_POST['privacy']);
if ($_POST['remarks']=="Delivered"){
    $shipment->flagDelivered();
}
echo 1;