
  <?php
     /**Set timezone To Kenyan timezone */
    date_default_timezone_set('Africa/Nairobi');

    require_once('processMpesaTransaction.php');
     
    /**Get raw Response */
    $mpesaResponse = file_get_contents('php://input');

    /**audit log */
    $requestingServerData=$_SERVER;

    /**Variable for file name to hold   $requestingServerData*/
    $audit="lnmo-audit-access.log";

    // write the  requesting Server Data to file
    $log1 = fopen($audit, 'a');
    fwrite($log1, print_r($requestingServerData,true));
    fwrite($log1, "\n"); 
    fclose($log1);
      

    //[HTTP_CF_CONNECTING_IP]=>196.201.214.208
    $Client_IP=$_SERVER['REMOTE_ADDR'];
    
    //Whitelist  Safaricom IP address
    $Safaricom_IPs=[
      '196.201.212.69',
      '196.201.212.74',
      '196.201.212.127',
      '196.201.212.128',
      '196.201.212.129',
      '196.201.212.132',
      '196.201.212.136',
      '196.201.212.138',
      '196.201.213.44',
      '196.201.213.114',
      '196.201.214.200',
      '196.201.214.201',
      '196.201.214.206',
      '196.201.214.207',
      '196.201.214.208',
      '196.201.214.209'
    ];
           
           
           

    /**check if response IP address is from safaricom*/
    if(!in_array($Client_IP,$Safaricom_IPs)){
      $log="--------------------------------------------".PHP_EOL."
      #".date('Y-m-d h:i:s')." Anauthorised Access Detected: From IP {$Client_IP}".PHP_EOL."with the following Data".PHP_EOL."
      {$mpesaResponse} ".PHP_EOL ."--------------------------------------";
      $handle=fopen("lnmo_intrusion_attempts.txt","a");
      fwrite($handle,$log);    
    }else{

    
    // log the response
    $logFile = "STKPushResponse.log";

     
    // write the M-PESA Response to file
    $log = fopen($logFile, 'a');
    fwrite($log, $mpesaResponse);
    fwrite($log, "\n"); 
    fclose($log);

    /**Call  processMpesaTransaction class that is used to process STKPush  MPESA callback  response*/
    $processMpesaTransaction=new processMpesaTransaction();

    /**Json decode raw Mpesa callback response */
    $jsonMpesaResponse=json_decode($mpesaResponse);

    /**Process Mpesa Transaction */
    $processMpesaTransaction->processSTKPushRequestCallback($jsonMpesaResponse);
  
  }
?>