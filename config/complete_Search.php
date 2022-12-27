<?php
require_once('database.php');

class CompleteSearch{
    private $id;
    private $search_code;
	private $ip_address;
	private $user_agent;
	private $imei_number;
	private $transaction_id;
	private $payment_method;
	private $phone_number;
	private $created_at;
	private $updated_at;
        
    private $tableName = 'complete_search';
    
    private $incomplete_search='incomplete_search';
   
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
    
    public function setTransactionId($transaction_id) { $this->transaction_id = $transaction_id;}
    public function getTransactionId() { return $this->transaction_id;}
    
    public function setPaymentMethod($payment_method) { $this->payment_method = $payment_method;}
    public function getPaymentMethod() { return $this->payment_method;}
    
    public function setPhoneNumber($phone_number) { $this->phone_number = $payment_method;}
    public function getPhoneNumber() { return $this->phone_number;}
    
    public function setCreatedAt($created_at) { $this->created_at = $created_at;}
    public function getCreatedAt() { return $this->created_at;}
    
    public function setUpdateAt($updated_at) { $this->updated_at = $updated_at;}
    public function getUpdatedAt() { return $this->updated_at;}


    public function __construct(){
     $db = new DBConnect();
     $this->dbConn = $db->connect();
    }

    //insert
    public function insertRecord($search_code,$ip_address,$user_agent,$imei_number,$transaction_id,$payment_method,$phone_number,$created_at,$updated_at){
        $sql = 'INSERT INTO '.$this->tableName .' VALUES(null,
        :search_code,
        :ip_address,
        :user_agent,
        :imei_number,
        :transaction_id,
        :payment_method,
        :phone_number,
        :created_at,
        :updated_at)';
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':search_code',$search_code);
        $stmt->bindParam(':ip_address',$ip_address);
        $stmt->bindParam(':user_agent',$user_agent);
        $stmt->bindParam(':imei_number',$imei_number);
        $stmt->bindParam(':transaction_id',$transaction_id);
        $stmt->bindParam(':payment_method',$payment_method);
        $stmt->bindParam(':phone_number',$phone_number);
        $stmt->bindParam(':created_at',$created_at);
        $stmt->bindParam(':updated_at',$updated_at);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    
    
             //count all rows
    public function countAll(){
        $stmt = $this->dbConn->prepare('SELECT COUNT(*) AS count FROM '.$this->tableName);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_NUM);
        return $count[0];
    }
    
        //function to get all records
    public function getAll(){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName);
        $stmt->execute();
        $return =$stmt->fetchAll(PDO::FETCH_ASSOC);
     return $return;
    }
    
    //get transaction_id
    public function getTransanctionID($transaction_id){
        $stmt = $this->dbConn->prepare('SELECT transaction_id FROM '.$this->tableName. ' WHERE transaction_id = :transaction_id');
        $stmt->execute(['transaction_id'=>$transaction_id]);
        $transaction_id =$stmt->fetchColumn();
        return $transaction_id;
    }
    
        //delete a single record 
    public function delete($id){
	    $stmt = $this->dbConn->prepare('DELETE FROM '.$this->incomplete_search. ' WHERE id = :id');
	    if($stmt->execute(['id'=>$id])){
		    return true;
	    }else{
		    return false;
	    }
    }
    
      
      
//We will need to wrap our queries inside a TRY / CATCH block.
   //That way, we can rollback the transaction if a query fails and a PDO exception occurs. 
   /*$transaction_id,$order_num,$customer_id,$amount_due,$status,*/
   
    public function completeSearch($id,$search_code,$ip_address,$user_agent,$imei_number,$transaction_id,$payment_method,$phone_number,$created_at,$updated_at){
       try{
           //We start our transaction.
           $this->dbConn->beginTransaction();
           
            //Query 1: Insert Payment Details
            $this->delete($id);
    
            //Query 2: INsert into order_details table
            $this->insertRecord($search_code,$ip_address,$user_agent,$imei_number,$transaction_id,$payment_method,$phone_number,$created_at,$updated_at);
          
            //We've got this far without an exception, so commit the changes
            $this->dbConn->commit();
        } 
        //Our catch block will handle any exceptions that are thrown.
        
        catch(Exception $e){
            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            echo $e->getMessage();
        
            //Rollback the transaction.   
            $this->dbConn->rollBack();
        }
    }
}
?>