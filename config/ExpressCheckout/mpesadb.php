<?php
//DIRECTORY SEPARATOR is a PHP pre_defined constant 
//((\ for Windows))
defined('DS')? null : define('DS',DIRECTORY_SEPARATOR);
defined('SITE_ROOT')? null: define('SITE_ROOT',DS.'home'.DS.'itncoke1'.DS.'projectsearch.itn3.co.ke');
//\xampp\htdocs\Pepea
defined('LIB_PATH')? null: define('LIB_PATH',SITE_ROOT.DS.'config');

//N
//load core objects

require_once(LIB_PATH.DS."database.php");
/**
 * Connect to MySQL and instantiate the PDO object.
 * Set the error mode to throw exceptions and disable emulated prepared statements.
 */


class MpesaDB{

    private $tableName="lnmo_payments";


    private $dbConn;


    function __construct(){
        $db = new DBConnect();
        $this->dbConn = $db->connect();
        
    }


     //Insert order_num into order 
     public function getlnmo($checkoutRequestID){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName. ' WHERE checkoutRequestID = :checkoutRequestID');
        $stmt->execute(['checkoutRequestID'=>$checkoutRequestID]);
        $lnmo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lnmo;
    }

     //Insert order_num into order 
     public function getlnmoTransanctionID($checkoutRequestID){
        $stmt = $this->dbConn->prepare('SELECT mpesaReceiptNumber FROM '.$this->tableName. ' WHERE checkoutRequestID = :checkoutRequestID');
        $stmt->execute(['checkoutRequestID'=>$checkoutRequestID]);
        $mpesaReceiptNumber =$stmt->fetchColumn();
        return $mpesaReceiptNumber;
    }

    




    public function insert_lnmo_transaction($jsonMpesaResponse){

        /**
        * READ CAREFULLY
        * 1.0 Create a database, or import the table mobile_payments.sql
        * 1.1 Change the db config section below to reflect your system 
        * 1.2 Ensure you have updated your access token to simulate the transaction
        * 1.4 Simulate the transaction
        *
        * Kindly, note the changes on our simulate.php, otherwise this will not work as expected.
        **/
    
    
    
    
        # 1.1.2 Insert Response to Database
        try{
    
            $insert = $this->dbConn->prepare("INSERT INTO lnmo_payments(resultDesc,resultCode,merchantRequestID,checkoutRequestID,amount,mpesaReceiptNumber,balance,transactionDate,phoneNumber) VALUES 
             (:resultDesc,:resultCode,:merchantRequestID,:checkoutRequestID,:amount,:mpesaReceiptNumber,:balance,:transactionDate,:phoneNumber)");
                $insert->execute((array)($jsonMpesaResponse));
             
            # 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
           /* $Transaction = fopen('Transaction.txt', 'a');
            fwrite($Transaction, json_encode($jsonMpesaResponse));
            fwrite($Transaction, "\n"); 
            fclose($Transaction);*/
        }
        catch(PDOException $e){
    
            # 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
            $errLog = fopen('mysqlError.log', 'a');
            fwrite($errLog, $e->getMessage());
            fwrite($errLog, "\n"); 
            fclose($errLog);
    
            # 1.1.2o Optional. Log the failed transaction. Remember, it has only failed to save to your database but M-PESA Transaction itself was successful. 
            $logFailedTransaction = fopen('failedLNMODatabaseTransaction.log', 'a');
            fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
            fwrite($logFailedTransaction, "\n"); 
            fclose($logFailedTransaction);
        }
    }


    function insert_c2b_response($jsonMpesaResponse){


        // 1.1.2 Insert Response to Database
        try{
            $insert = $this->dbConn->prepare("INSERT INTO `c2b_payments`(`TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`, `MiddleName`, `LastName`) 
            VALUES 
            (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)");
            $insert->execute((array)($jsonMpesaResponse));
      
          # 1.1.2o Optional - Log the transaction to a .txt or .log file(May Expose your transactions if anyone gets the links, be careful with this. If you don't need it, comment it out or secure it)
           /* $Transaction = fopen('Transaction.txt', 'a');
            fwrite($Transaction, json_encode($jsonMpesaResponse));
            fwrite($Transaction, "\n"); 
            fclose($Transaction);*/
        
        }
        catch(PDOException $e){
    
           # 1.1.2b Log the error to a file. Optionally, you can set it to send a text message or an email notification during production.
            $errLog = fopen('mysqlError.log', 'a');
            fwrite($errLog, $e->getMessage());
            fwrite($errLog, "\n"); 
            fclose($errLog);
    
            # 1.1.2o Optional. Log the failed transaction. Remember, it has only failed to save to your database but M-PESA Transaction itself was successful. 
            $logFailedTransaction = fopen('failedC2BDatabaseTransaction.log', 'a');
            fwrite($logFailedTransaction, json_encode($jsonMpesaResponse));
            fwrite($logFailedTransaction, "\n"); 
            fclose($logFailedTransaction);
        }
    }
    
    //function to get all rows
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