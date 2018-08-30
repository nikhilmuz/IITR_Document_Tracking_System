<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 26/8/18
 * Time: 4:35 AM
 */
require_once ('autoload.php');
class DB
{
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

    function telldb($table,$format,$data)//store data
    {
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
        ($this->connect)->query($sql);
    }
    function askdb($attribute,$table,$params)//fetch data
    {
        $sql="";
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
        $row = ($this->connect)->query($sql);
        $data = $row->fetch_assoc();
        if(is_array($attribute)){
            if(count($attribute)==1){return $data[$attribute[0]];}
            else {return $data;}
        }
        else {
            return $data[$attribute];
        }
    }
    function askdb_all($table,$params)//fetch data
    {
        $sql="SELECT * FROM ".$table." WHERE ";
        if($params==null){$sql="SELECT * FROM ".$table;}
        else{
        $length=count($params);
        foreach ($params as $key => $value){
            $sql=$sql.$key."='".$value."'";
            if ($length!=1){$sql=$sql." AND ";}
            $length--;
        }
        }
        $query = mysqli_query($this->connect,$sql) or die(mysql_error($this->connect));
        return mysqli_fetch_all($query,MYSQLI_ASSOC);
    }
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
        $row = ($this->connect)->query($sql);
        $data = $row->fetch_assoc();
        if(count($attribute)==1){return $data[$attribute[0]];}
        else {return $data;}
    }
    function forgetdb($table,$params)//delete data
    {
        $sql="DELETE FROM ".$table." WHERE ";
        $length=count($params);
        foreach ($params as $key => $value){
            $sql=$sql.$key."='".$value."'";
            if ($length!=1){$sql=$sql." AND ";}
            $length--;
        }
        ($this->connect)->query($sql);
    }
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
        ($this->connect)->query($sql);
    }
}