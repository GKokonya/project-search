<?php
class Mpesa{

     # header for access token
    private $headers;

    #M-PESA access token variable allows one to access the M-PESA DARAJA API
    private $accessToken;
    
     #M-PESA consumerKey variable allows one to access the M-PESA DARAJA API
    private $consumerKey;
    
    #M-PESA consumerSecret variable allows one to access the M-PESA DARAJA API
    private $consumerSecret;

    #M-PESA request header which contains the access token
    private $requestHeader;

    # M-PESA STKPush(Lipa na Mpesa Online) callback urls
    private $lnmoCallbackURL;

    # M-PESA STKPush(Lipa na Mpesa Online) endpoint urls
    private $lnmoInitiateURL;

    #M-PESA pay Bill number or Till number that is usually (5-7)
    private $businessShortCode;

    #M-PESA credintial used in generating password for STKpush Transaction
    private $passKey;

    #Variable that holds current date and time,format YYYYmmddhms -> 20181004151020
    private $timeStamp;

    #M-PESA STKPush transaction description
    private $transactonDesc;

    private $accountReference;

    #Password
    private $password;

    #Safaricom mobile number used to initiate lipa na mpesa online
    private $phoneNumber;

    #Amount used to STKPush
    private $amount;

    #Variable will hold C2B Confirmation URL
    private $c2bConfirmationURL;

    #Variable will hold C2B Validation URL
    private $c2bValidationURL;

    #Variable to hold M-PESA shortCode(can be till number or Pay Bill Number)
    private $shortCode;

     #Variable to hold M-PESA MSISDN(In this case it is your phone number)
     private $MSISDN;

     #Variable to hold C2B MPESA endpoint URL
     private $c2bEndPointURL;
     
     #Variable to hold stkPush $CheckoutRequestID
     private $CheckoutRequestID;

    function __construct(){

    }

    /**ConsumerKey key to used to generate access token */
    public function getConsumerKey(){
      return $this->consumerKey="";

    }

     /**ConsumerSecret key to used to generate access token */
    public function getConsumerSecret(){
      return $this->consumerSecret="";

    }

    /**Header indicating that the web page contains json Data */
    public function getHeaders(){
      $this->headers= ['Content-Type:application/json; charset=utf8'];
      return $this->headers;

    }

     /**Method use dto obtain access token */
     public function getAccessToken(){
      $curl=curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
      
      curl_setopt_array($curl,
         array(
             CURLOPT_HTTPHEADER=>$this->getHeaders(),
             CURLOPT_RETURNTRANSFER=>true,
             CURLOPT_HEADER=>false,
             CURLOPT_USERPWD=>$this->getConsumerKey().':'.$this->getConsumerSecret()
             )
         );
 
         $result=json_decode(curl_exec($curl));
         curl_close($curl);
         return  $result->access_token;
     }

    /**Request Header for M-PESA API which contains the Access token */
    public function getRequestHeader(){
      $this->requestHeader=array('Content-Type:application/json','Authorization:Bearer '.$this->getAccessToken());
      //$this->requestHeader=array('Content-Type:application/json','Authorization:Bearer '.$this->getAccessToken());
      return $this->requestHeader;
    }

     /**Method to get M-PESA BusinessShortCode */
    public function getbusinessShortCode(){
      return $this->businessShortCode="174379";
    }

    ###############################  START OF STKPUSH METHODS  ###################################################################################

    public function getPassKey(){
      return $this->passKey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
    }

    public function setAccountReference($accountReference){
      $this->accountReference=$accountReference;
      return $this->accountReference;

    }

    public function getTransactonDesc(){
      $this->transactonDesc="Payment into system";
      return $this->transactonDesc;

    }

    public function setPhoneNumber($phoneNumber){
      $this->phoneNumber=$phoneNumber;
      return $this->phoneNumber;

    }

    /**Set Amount */
    public function setAmount($amount){
      $this->amount=$amount;
      return $this->amount;

    }

     
    /**Gets the lnmoCallbackURL*/
    public function getLnmoCallbackURL(){
      return $this->lnmoCallbackURL="https://projectsearch.itn3.co.ke/config/ExpressCheckout/lnmo_result_url.php";
    }


    /**Gets the lnmoInitiateURL*/
    public function getLnmoInitiateURL(){
      return $this->lnmoInitiateURL="https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    }

    /**Create current date and time */
    public function getTimeSTamp(){
      return $this->timestamp=date('YmdHis');

    }

    /**Generate password using businessShortCode, passKey and timeStamp*/
    public function getLnmoPassword(){
      $businessShortCode=$this->getbusinessShortCode();
      $passKey=$this->getPassKey();
      $timeStamp=$this->getTimeSTamp();
      $this->password = $PASSWORD;
      return $this->password=base64_encode($businessShortCode.$passKey.$timeStamp);
    }
    
    /**function to sets CheckoutRequestID*/
    public function setCheckoutRequestID($CheckoutRequestID){
        $this->CheckoutRequestID=$CheckoutRequestID;
        
    }
    
    /**function to sets CheckoutRequestID*/
    public function getCheckoutRequestID(){
        return $this->CheckoutRequestID;
        
    }

       /**Method to intiatiate STKPush */
    public function lipa_na_mpesa_online($curl_post_data){
        $curl=curl_init();
        
        curl_setopt_array($curl,
        array(
            CURLOPT_URL=>$this->getLnmoInitiateURL(),
            CURLOPT_HTTPHEADER=>$this->getRequestHeader(),
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$curl_post_data
            )
        );

        $lnmo_response = curl_exec($curl);
        //curl_close($curl);
        
        
        #Return result in json format
        $lnmo_response=json_decode($lnmo_response);
        $ResponseCode=$lnmo_response->ResponseCode;
        $CheckoutRequestID=$lnmo_response->CheckoutRequestID;
        if($ResponseCode==0){
            $this->setCheckoutRequestID($CheckoutRequestID);
            return   true;
        }else{
            return false;
        }
       
    }

    ###############################  END OF STKPUSH METHODS  ###################################################################################




     ###############################  START OF C2B  METHODS ###################################################################################
  

     /**Gets the C2B shortCode*/
     public function getShortCode(){
      $this->shortCode="600446";
      return $this->shortCode;
    }

     /**Gets the C2B  MSISDN*/
     public function getMSISDN(){
      $this->MSISDN="254708374149";
      return $this->MSISDN;
    }

     /**Gets the C2B  endPointRL*/
     public function getC2bEndPointURL(){
      $this->c2bEndPointURL='https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
      return $this->c2bEndPointURL;
    }

     /**Gets the C2B ConfirmationURL*/
     public function getC2bConfirmationURL(){
      $this->c2bConfirmationURL="";
      return $this->c2bConfirmationURL;
    }

     /**Gets the C2B ValidationURL*/
     public function getC2bValidationURL(){
      $this->c2bValidationURL="";
      return $this->c2bValidationURL;
    }
      /**Method to register url */
      public function register_urls($endPointURL,$curl_post_data){
        return $this->transaction_request_body($endPointURL,$curl_post_data);
    }

    /**Method to simulate C2B Transaction */
    public function simulate_transaction($endPointURL,$curl_post_data){
        return $this->transaction_request_body($endPointURL,$curl_post_data);
    }
    

    ###############################  END OF C2B METHODS  ###################################################################################




     ###############################  START OF C2B  METHODS ###################################################################################

    /**Method to simulate C2B Transaction */
    public function reverse_transaction($endPointURL,$curl_post_data){
        return $this->transaction_request_body($endPointURL,$curl_post_data);
    }
    ###############################  END OF C2B METHODS  ###################################################################################
  
    public function transaction_request_body($endPointURL,$curl_post_data){
     
    $curl=curl_init();
     
     curl_setopt_array($curl,
        array(
            CURLOPT_URL=>$endPointURL,
            CURLOPT_HTTPHEADER=>$this->getRequestHeader(),
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$curl_post_data
            )
        );

        $curl_response=curl_exec($curl);
        curl_close($curl);
        return  $curl_response;
    }
    
}
?>