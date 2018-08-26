<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 25/8/18
 * Time: 6:43 AM
 */
class Users
{
    public $isValid=false;
    private $user_table_name="users";
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
            $this->permission=$result['permission'];
            return true;
        }else{
            return false;
        }
    }

    public function __destruct()
    {
        ($this->connect)->close();
    }

    function getEvents(){
        $query = mysqli_query($this->connect,"SELECT * FROM ".$this->events_table_name." WHERE awb = '".$this->awb."' ORDER BY timestamp DESC") or die(mysql_error($this->connect));
        return mysqli_fetch_all($query,MYSQLI_ASSOC);
    }
}