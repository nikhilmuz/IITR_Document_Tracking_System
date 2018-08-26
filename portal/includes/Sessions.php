<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 6:58 AM
 */
include_once ('autoload.php');
class Sessions
{
    private $session_table_name="sessions";
    public function __construct()
    {
        $dbServer = DB_HOST;
        $dbUsername = DB_LOGIN;
        $dbPassword = DB_PASS;
        $dbName = DB_NAME;
        $con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
        if(mysqli_connect_errno()){
            die("Failed to connect with MySQL: ".mysqli_connect_error());
        }else{
            $this->connect = $con;
        }
    }

    public function __destruct()
    {
        ($this->connect)->close();
    }

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
        else{return $this->chk_tok();}
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
                $this->des_tok();
                return 0;}
            else if ($token==$_COOKIE["token"]){return 1;}
            else{
                $this->des_tok();
                return 0;
            }
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
                $this->des_tok();
                return 0;}
            else if ($token==$_POST["token"]){return 1;}
            else{
                $this->des_tok();
                return 0;
            }
        }
}
function getID(){
    $query = mysqli_query($this->connect,"SELECT * FROM ".$this->session_table_name." WHERE tid = '".$_COOKIE['tid']."'") or die(mysql_error($this->connect));
    if(mysqli_num_rows($query)>0&&$this->chk_tok()){
        $result = mysqli_fetch_array($query);
        return $result['eid'];
    }else{
        return null;
    }
}
}