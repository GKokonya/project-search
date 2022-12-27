<?php
require_once('config/initialize.php');
//create a new instance of the session class
$session = new Session();
//Create an instance of Csrf class
$csrf=new Csrf();
//obtaining the user id from the session class

#If button is clicked
if(isset($_POST['make_payment']) && isset($_POST['token'])){
    $post_token=htmlentities($_POST['token']);
    if($csrf->checkToken($post_token)){
        $post_phone=htmlentities($_POST['phone']);
        if(empty($post_phone)){
            $token=$csrf->generateToken();
            $msg=0;
            $html="Error!phone number cannot be empty";
                
                $array= array("token"=>$token,"msg"=>$msg,"html"=>$html);
                echo json_encode($array);
        }else{
            if(strlen($post_phone)!=10){
                $token=$csrf->generateToken();
                $msg=0;
                $html="Please enter 10 digits!";
                
                $array= array("token"=>$token,"msg"=>$msg,"html"=>$html);
                echo json_encode($array);
            }else{
                $mpesa=new Mpesa();
            
                /*Sanitize Post Variables to prevent Cross-Site Scripting Attack*/
                $post_amount=1;
                $countryCode="254";
            
                //Concatenate post_phone and post_countryCode to get phone number
                $post_phone = str_replace("-", "", $post_phone);
                $post_phone = str_replace( array(' ', '<', '>', '&', '{', '}', '*', "+", '!', '@', '#', "$", '%', '^', '&'), "", $post_phone );
            
                $phoneNumber=$countryCode.substr($post_phone, -9);
            
                #define the variales
                #provide the following details, this part is found on your test credentials on the developer account
                $BusinessShortCode = $mpesa->getbusinessShortCode();
            
                //This is your phone number, 
                $PartyA = $mpesa->setPhoneNumber($phoneNumber);
              
                $AccountReference = $mpesa->setAccountReference(SITE_NAME);
                $TransactionDesc = $mpesa->getTransactonDesc();
            
                #Amont to sent to M-PESA
                $Amount = $mpesa->setAmount($post_amount);
             
                #Get the timestamp, format YYYYmmddhms -> 20181004151020
                $Timestamp = $mpesa->getTimestamp();    
              
                #Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
                $Password = $mpesa->getLnmoPassword();
            
                #callback url
                $CallBackURL = $mpesa->getLnmoCallbackURL();
            
                $curl_post_data = array(
                //Fill in the request parameters with valid values
                'BusinessShortCode' => $BusinessShortCode,
                'Password' => $Password,
                'Timestamp' => $Timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $Amount,
                'PartyA' => $PartyA,
                'PartyB' => $BusinessShortCode,
                'PhoneNumber' => $PartyA,
                'CallBackURL' => $CallBackURL,
                'AccountReference' => $AccountReference,
                'TransactionDesc' => $TransactionDesc
                );
            
                $data_string = json_encode($curl_post_data);
                if($mpesa->lipa_na_mpesa_online($data_string)){
                    $CheckoutRequestID=$mpesa->getCheckoutRequestID();
                    $session->setCheckoutRequestID($CheckoutRequestID);
                    $session->getCheckoutRequestID();
                    $session->getSearchCode();

                    $token=$csrf->generateToken();
                    $msg=1;
                    $html="success";
                    $array= array("token"=>$token,"msg"=>$msg,"html"=>$html);
                    echo json_encode($array);
                }else{
                    $token=$csrf->generateToken();
                    $msg=0;;
                    $html="<script>
                    errorMessage('index.php','M-Pesa System has an error'); 
                    </script>";
                    $array= array("token"=>$token,"msg"=>$msg,"html"=>$html);
                    echo json_encode($array);
                }
            }
        }
    }else{
        $token=$csrf->generateToken();
        $msg=0;
        $html="Error!Invalid Token";
        $array= array("token"=>$token,"msg"=>$msg,"html"=>$html);
                echo json_encode($array);
    }
}else{
  $token=$csrf->generateToken();
  $msg=0;
  $message="Error!This is not a valid Request";
  
  $array= array("token"=>$token,"msg"=>$msg,"html"=>$html);
  echo json_encode($array);
}
?>