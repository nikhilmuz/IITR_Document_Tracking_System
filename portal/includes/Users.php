<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 25/8/18
 * Time: 6:43 AM
 */
define("USER_TABLE_NAME","users");
class Users
{
    public $isValid=false;
    public $isAdmin=false;
    private $user_table_name=USER_TABLE_NAME;
    private $pwd;
    public function __construct($id)
    {
        $dbServer = DB_HOST;
        $dbUsername = DB_LOGIN;
        $dbPassword = DB_PASS;
        $dbName = DB_NAME;
        $this->enrlid=$id;
        $con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
        if(mysqli_connect_errno()){
            die("Failed to connect with MySQL: ".mysqli_connect_error());
        }else{
            $this->connect = $con;
        }
        $this->isValid=$this->isValid();

    }
    private function isValid(){
        $query = mysqli_query($this->connect,"SELECT * FROM ".$this->user_table_name." WHERE enrlid = '".$this->enrlid."'") or die(mysql_error($this->connect));
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_array($query);
            $this->id=$result['id'];
            $this->pwd=$result['pwd'];
            $this->fn=$result['fn'];
            $this->ln=$result['ln'];
            $this->dob=$result['dob'];
            $this->ph=$result['ph'];
            $this->email=$result['email'];
            $this->office=$result['officeid'];
            if($result['permission']=="ADMIN"){$this->isAdmin=true;}
            return true;
        }else{
            return false;
        }
    }

    public function __destruct()
    {
        ($this->connect)->close();
    }
    static function getUsers($array){
        return (new DB())->askdb_all(USER_TABLE_NAME,$array);
    }
}