<?php
$req="0";
if (isset($_POST['req'])){$req=$_POST['req'];}
if ($req=="0"){header('Location: ../kb/err.php');}
if ($req=="4"){//update profile
    require_once(dirname(__FILE__).'/session.php');
	require_once(dirname(__FILE__).'/db.php');
    $key=$_POST['key'];
    $value=$_POST['value'];
	if ($key!="enrlid")
	{
		if ($key=="id"){$value=strtoupper($value);}
		if (chk_tok()){
		$tid = $_COOKIE[ "tid" ];
		$eid=askdb( array("eid"), "sessions", array("tid"=> $tid) );
		changedb("users",array($key=>$value),array("enrlid"=>$eid));
		echo 1;
	}
		else echo 0;}
	else echo 0;
}
if ($req=="6"){//change password
	require_once(dirname(__FILE__).'/db.php');
	$eid=askdb(array('eid'),'sessions',array('tid'=>$_COOKIE['tid']));
	$pwd=askdb(array('pwd'),'users',array('enrlid'=>$eid));
	if ($pwd==$_POST['pwd'])
	{
		changedb('users',array(pwd=>$_POST['newpwd']),array('enrlid'=>$eid));
		echo 1;
	}
	else echo 0;
}
if ($req=="7"){//logout all other
	require_once(dirname(__FILE__).'/db.php');
	$eid=askdb(array('eid'),'sessions',array('tid'=>$_COOKIE['tid']));
	forgetdb('sessions',array('eid'=>$eid));
	echo 1;
}