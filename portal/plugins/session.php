<?php
//For login management
require_once(dirname(dirname(__FILE__)).'/includes/autoload.php');

function gen_tok($username,$password)//generate token
{
    $dbobj=(new DB());
	if(!isset($_COOKIE["tid"])){
	$pwd = $dbobj->askdb(array("pwd"),"users",array("id"=>$username));
	if ($pwd==$password&&$password!=""){
		$tid=time();
		$token=hash('sha256',$tid.$pwd);
		$eid = $dbobj->askdb("enrlid","users",array("id"=>$username));
		$tokentodb=array($tid, $token, $eid);
		$dbobj->telldb("sessions",array('tid','token','eid'),$tokentodb);
		setcookie('tid', $tid, time()+60*60*24*365, "/");
		setcookie('token', $token, time()+60*60*24*365, "/");
		return 1;
}
	else{
		return 0;
	}
	}
	else{return chk_tok();}
}
function des_tok()//destroy token
{
    $dbobj=(new DB());
	$tid="";
	if (isset($_COOKIE['tid'])){$tid=$_COOKIE['tid'];} else {$tid=$_POST['tid'];}
	$dbobj->forgetdb("sessions",array("tid"=>$tid));
	if(isset($_COOKIE['tid'])){setcookie('tid', '', time()-60*60*24*365, "/");}
	if(isset($_COOKIE['token'])){setcookie('token', '', time()-60*60*24*365, "/");}
}

/**
 * @return int
 */
function chk_tok()//check token
{
    $dbobj=(new DB());
	if(!isset($_COOKIE["tid"])){return 0;}
	else {
		$tid=$_COOKIE["tid"];
		$token = $dbobj->askdb("token","sessions",array("tid"=>$tid));
		if(!isset($_COOKIE["token"])){
			des_tok();
			return 0;}			
		else if ($token==$_COOKIE["token"]){return 1;}
		else{
			des_tok();
			return 0;}
		}
}
function chk_tok_post()//check token
{
    $dbobj=(new DB());
	if(!isset($_POST["tid"])){return 0;}
	else {
		$tid=$_POST["tid"];
		$token = $dbobj->askdb("token","sessions",array("tid"=>$tid));
		if(!isset($_POST["token"])){
			des_tok();
			return 0;}			
		else if ($token==$_POST["token"]){return 1;}
		else{
			des_tok();
			return 0;}
		}
}