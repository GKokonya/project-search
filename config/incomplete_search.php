<?php
require_once('database.php');

class InCompleteSearch{
    protected $id;
    private $search_code;
	private $ip_address;
	private $user_agent;
	private $imei_number;
	private $created_at;
	private $updated_at;
        
    private $tableName = 'incomplete_search';
   
    private $dbConn;
	
    //encapsulating the properties in setters and getters

    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }
    
    public function setSearchCode($search_code) { $this->search_code = $search_code;}
    public function getSearchCode() { return $this->search_code;}
    
    public function setIpAddress($ip_address) { $this->ip_address = $ip_address;}
    public function getIpAddress() { return $this->ip_address;}
    
      public function setUserAgent($user_agent) { $this->user_agent = $user_agent;}
    public function getUserAgent() { return $this->user_agent;}
    
    public function setImeiNumber($imei_number) { $this->imei_number = $imei_number;}
    public function getImeiNumber() { return $this->imeiNumber;}
    
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
        $sql = 'INSERT INTO '.$this->tableName .' VALUES(null,
        :search_code,
        :ip_address,
        :user_agent,
        :imei_number,
        :created_at,
        :updated_at)';
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':search_code',$this->search_code);
        $stmt->bindParam(':ip_address',$this->ip_address);
        $stmt->bindParam(':user_agent',$this->user_agent);
        $stmt->bindParam(':imei_number',$this->imei_number);
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
    
        //function to find the category by id
    public function getBySearchCode($search_code){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE search_code = :search_code');
        $stmt->execute(['search_code'=> $search_code]);
        $return = $stmt->fetch();
        return $return;
    }
    
    //Get the id of the lat row 
    public function getLastId(){
        $stmt = $this->dbConn->prepare('SELECT id FROM '.$this->tableName.' ORDER BY id DESC');
        $stmt->execute();
        $return = $stmt->fetch();
        
     return $return[0];
    }
    
    //function to get all records
    public function getAll(){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName);
        $stmt->execute();
        $return =$stmt->fetchAll(PDO::FETCH_ASSOC);
     return $return;
    }
        
        
    //count all rows
    public function countAll(){
        $stmt = $this->dbConn->prepare('SELECT COUNT(*) AS count FROM '.$this->tableName);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return $count[0];
    }
}
?>