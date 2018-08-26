<?php
require_once(dirname(dirname(__FILE__)).'/config.php');
require_once (dirname(dirname(__FILE__)).'/includes/autoload.php');
$conn;
function dbconn()//for connecting database
{
    global $conn;
    $servername = DB_HOST;
	$port = DB_PORT;
	$username = DB_LOGIN;
	$password = DB_PASS;
	$db = DB_NAME;
// Create connection
	$conn = new mysqli($servername, $username, $password, $db, $port);

// Check connection
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	header('Location: ../kb/dberr.php');
	}
};
function dbdisconn()//for disconnecting database
{
	global $conn;
	$conn->close();
	};
function telldb($table,$format,$data)//store data
{
	dbconn();
	global $conn;
	$sql="insert into ".$table." (";
	$counter=count($format);
	foreach($format as $column){
		if($counter>1){
		$sql=$sql.$column.",";
			$counter--;
		}
		else{
			$sql=$sql.$column;
		}
	}
	$sql=$sql.")values ('";
	$length=count($data);
	for ($i=0;$i<$length-1;$i++){
		$sql=$sql.$data[$i]."','";
	}
	$sql=$sql.$data[$length-1]."')";
	$row = $conn->query($sql);
	dbdisconn();
	};
function askdb($attribute,$table,$params)//fetch data
{
	$sql;
	if(is_array($attribute)){
		$sql="SELECT ".Functions::generate_csv($attribute)." FROM ".$table." WHERE ";
	}
	else{
		$sql="SELECT ".$attribute." FROM ".$table." WHERE ";
	}
	$length=count($params);
	foreach ($params as $key => $value){
		$sql=$sql.$key."='".$value."'";
		if ($length!=1){$sql=$sql." AND ";}
		$length--;
	}
	dbconn();
	global $conn;
	$row = $conn->query($sql);
	$data = $row->fetch_assoc();
	dbdisconn();
	if(is_array($attribute)){
		if(count($attribute)==1){return $data[$attribute[0]];}
		else {return $data;}
							}
	else {
		return $data[$attribute];
		}
	};
function askdb_ljoin($attribute,$table,$params)//fetch data
{
	$sql="SELECT contents.id as id,contents.eid as eid,contents.file_name as file_name,contents.size as size,contents.comment as comment,users.fn as fn FROM contents LEFT JOIN users ON contents.eid = users.enrlid WHERE contents.course='".$course."' ORDER BY contents.id DESC";
		$sql="SELECT ".Functions::generate_csv($attribute)." FROM ".$table." WHERE ";
	$length=count($params);
	foreach ($params as $key => $value){
		$sql=$sql.$key."='".$value."'";
		if ($length!=1){$sql=$sql." AND ";}
		$length--;
	}
	dbconn();
	global $conn;
	$row = $conn->query($sql);
	$data = $row->fetch_assoc();
	dbdisconn();
		if(count($attribute)==1){return $data[$attribute[0]];}
		else {return $data;}
	};
function forgetdb($table,$params)//delete data
{
	dbconn();
	global $conn;
	$sql="DELETE FROM ".$table." WHERE ";
	$length=count($params);
	foreach ($params as $key => $value){
		$sql=$sql.$key."='".$value."'";
		if ($length!=1){$sql=$sql." AND ";}
		$length--;
	}
	$row = $conn->query($sql);
	dbdisconn();
	};
function changedb($table,$data,$params)//update data
{
	$fields=array();
	foreach($data as $key=>$value){
		array_push($fields,$key."='".$value."'");
	}
	$length=count($params);
	$sql="UPDATE ".$table." SET ".Functions::generate_csv($fields)." WHERE ";
	foreach ($params as $key => $value){
		$sql=$sql.$key."='".$value."'";
		if ($length!=1){$sql=$sql." AND ";}
		$length--;
	}
	dbconn();
	global $conn;
	$row = $conn->query($sql);
	dbdisconn();
	};