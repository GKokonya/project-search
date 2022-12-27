<?php
require_once('database.php');

class BlacklistedDevices{
    protected $id;
	protected $name;
	private $brand;
	private $serial_number;
	private $imei_number;
	private $ob_number;
	private $area;
	private $created_at;
	private $updated_at;
        
    private $tableName = 'blacklisted_devices';
   
    private $dbConn;
	
    //encapsulating the properties in setters and getters

    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }
    
    public function setName($name) { $this->name = $name;}
    public function getName() { return $this->name;}
    
    public function setBrand($brand) { $this->brand = $brand;}
    public function getBrand() { return $this->brand;}
    
    public function setModel($model) { $this->model = $model;}
    public function getModel() { return $this->model;}
    
    public function setSerialNumber($serial_number) { $this->serial_number = $serial_number;}
    public function getSerialNumber() { return $this->serial_number;}
    
    public function setImeiNumber($imei_number) { $this->imei_number = $imei_number;}
    public function getImeiNumber() { return $this->imeiNumber;}
    
    public function setObNumber($ob_number) { $this->ob_number =$ob_number;}
    public function getObNumber() { return $this->ob_number;}
    
    public function setArea($area) { $this->area = $area;}
    public function getArea() { return $this->area;}
    
    public function setCreatedAt($created_at) { $this->created_at = $created_at;}
    public function getCreatedAt() { return $this->created_at;}
    
    public function setUpdateAt($updated_at) { $this->updated_at = $updated_at;}
    public function getUpdatedAt() { return $this->updated_at;}


    public function __construct(){
     $db = new DBConnect();
     $this->dbConn = $db->connect();

    }

    //insert
    public function insert(){
        $sql = 'INSERT INTO '.$this->tableName .' VALUES(null,:name,:brand,:model,:serial_number,:imei_number,:ob_number,:area,:created_at,:updated_at)';
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':brand',$this->brand);
        $stmt->bindParam(':model',$this->model);
        $stmt->bindParam(':serial_number',$this->serial_number);
        $stmt->bindParam(':imei_number',$this->imei_number);
        $stmt->bindParam(':ob_number',$this->ob_number);
        $stmt->bindParam(':area',$this->area);
        $stmt->bindParam(':created_at',$this->created_at);
        $stmt->bindParam(':updated_at',$this->updated_at);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    
    //delete a single record 
    public function delete($id){
	    $stmt = $this->dbConn->prepare('DELETE FROM '.$this->tableName . ' WHERE id = :id');
	    if($stmt->execute(['id'=>$id])){
		    return true;
	    }else{
		    return false;
	    }
    }
    
    
    //function to find the category by id
    public function search($imei_number){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE imei_number = :imei_number');
        $stmt->execute(['imei_number'=> $imei_number]);
        $return = $stmt->fetch();
     return $return;
    }
    
        //function to get all records
    public function getAll(){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName);
        $stmt->execute();
        $return =$stmt->fetchAll(PDO::FETCH_ASSOC);
     return $return;
    }
    
}
?>