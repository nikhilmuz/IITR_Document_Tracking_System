<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 25/8/18
 * Time: 6:44 AM
 */
include_once ('autoload.php');
class AWB
{
    public $isValid=false;
    private $meta_table_name="awb_meta";
    private $events_table_name="events";
    public function __construct($awbno)
    {
        $dbServer = DB_HOST;
        $dbUsername = DB_LOGIN;
        $dbPassword = DB_PASS;
        $dbName = DB_NAME;
        $this->awb=$awbno;
        $con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
        if(mysqli_connect_errno()){
            die("Failed to connect with MySQL: ".mysqli_connect_error());
        }else{
            $this->connect = $con;
        }
        $this->isValid=$this->isValid();

    }

    public function __destruct()
    {
        ($this->connect)->close();
    }

    private function isValid(){
        $query = mysqli_query($this->connect,"SELECT * FROM ".$this->meta_table_name." WHERE awb = '".$this->awb."'") or die(mysql_error($this->connect));
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_array($query);
            $this->created=$result['created'];
            $this->created_by=$result['created_by'];
            $this->completed=$result['completed'];
            $this->completed_by=$result['completed_by'];
            $this->origin=$result['origin'];
            $this->destination=$result['destination'];
            $this->status=$result['status'];
            $this->docid=$result['docid'];
            $this->remarks=$result['remarks'];
            return true;
        }else{
            return false;
        }
    }
    function getEvents(){
        $query = mysqli_query($this->connect,"SELECT * FROM ".$this->events_table_name." WHERE awb = '".$this->awb."' ORDER BY timestamp DESC") or die(mysql_error($this->connect));
        return mysqli_fetch_all($query,MYSQLI_ASSOC);
    }
    function createAWB($docid,$origin,$destination,$expected,$remarks){
        (new DB())->telldb($this->meta_table_name,
            array(
                'awb',
                'created',
                'created_by',
                'completed',
                'origin',
                'destination',
                'status',
                'docid',
                'remarks'
            ),
        array(
            $this->awb,
            time(),
            (new Sessions())->getID(),
            time()+($expected*24*3600),
            $origin,
            $destination,
            0,
            $docid,
            $remarks
            )
        );
        $this->isValid=$this->isValid();
    }
    function getAWBfromSAP($sap){
        $query = mysqli_query($this->connect,"SELECT * FROM ".$this->meta_table_name." WHERE upper(docid) = '".strtoupper($sap)."'") or die(mysql_error($this->connect));
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_array($query);
            return $result['awb'];
        }else{
            (new DB())->telldb($this->office_table_name,array("officeid","name"),array($this->officeid,$name));
            return -1;
        }
    }
}