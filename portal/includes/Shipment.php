<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 7:18 AM
 */
include_once ('autoload.php');
class Shipment
{
    private $awb_table_name="awb_meta";
    private $events_table_name="events";
    public function __construct($awb)
    {
        $dbServer = DB_HOST;
        $dbUsername = DB_LOGIN;
        $dbPassword = DB_PASS;
        $dbName = DB_NAME;
        $this->awb=$awb;
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
        $query = mysqli_query($this->connect,"SELECT * FROM ".$this->awb_table_name." WHERE awb = '".$this->awb."'") or die(mysql_error($this->connect));
        if(mysqli_num_rows($query)>0){
            $result = mysqli_fetch_array($query);
            $this->created=$result['created'];
            $this->created_by=$result['created_by'];
            $this->completed=$result['completed'];
            $this->completed_by=$result['completed_by'];
            $this->origin=$result['origin'];
            $this->destination=$result['destination'];
            $this->status=$result['status'];
            return true;
        }else{
            return false;
        }
    }
    public function addEvent($remarks,$privacy){
        $id=(new Sessions())->getID();
        (new DB())->telldb(
            $this->events_table_name,
            array(
                'timestamp',
                'awb',
                'owner',
                'office',
                'remarks',
                'privacy'
            ),
            array(
                time(),
                $this->awb,
                $id,
                (new Users($id))->office,
                $remarks,
                $privacy
            ));
    }
    function flagDelivered(){
        (new DB())->changedb($this->awb_table_name,array('completed'=>time(),'completed_by'=>(new Sessions())->getID(),'status'=>'1'),array('awb'=>$this->awb));
    }
    static function getShipments($id){
        return (new DB())->askdb_all("awb_meta",array('created_by'=>$id));
    }
}
