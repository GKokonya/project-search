<?php
class DbConnect{
	private $host = 'localhost';
	private $dbname = '';
	private $user = '';
	private $pass = '';
	private $conn;
	

	//function to open connection to the database
	public function connect(){
       try{
	   $this->conn = new PDO('mysql:host=' .$this->host .';dbname=' .$this->dbname, $this->user,$this->pass);
	   $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	   $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
	   return $this->conn;
	}catch(PDOExcetion $e){
		echo 'Database Error: '.$e->getMessage();
	}
		
	}

	//function to close connection to the database;
	public function close_connection(){
		$this->conn = null;

	}
	
}
?>