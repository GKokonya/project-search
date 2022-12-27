<?php
require_once('mpesadb.php');

/** processMpesaTransaction is used to process Mpesa Callback Responses*/
class processMpesaTransaction{
    /**This property is to be assigned to MPesaDB class */
    private $mpedadb;
    
    
    function __construct(){
        /** Call MPesaDB class and assign it to $mpedadb property*/
       $this->mpedadb=new MpesaDB();       
    }

    /**Methd used to Process STKPush Callback Response and Insert it to Database */
    public function processSTKPushRequestCallback($callbackJsonMpesaResponse){

        
        $callbackData=$callbackJsonMpesaResponse;
        if($callbackData->Body->stkCallback->ResultCode==0){
            $resultCode=$callbackData->Body->stkCallback->ResultCode;
            $resultDesc=$callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;
        
            $amount=$callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $mpesaReceiptNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $balance=$callbackData->Body->stkCallback->CallbackMetadata->Item[2]->Name;
            $transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
        
             $result= array(
                 ":resultDesc"=>$resultDesc,
                 ":resultCode"=>$resultCode,
                 ":merchantRequestID"=>$merchantRequestID,
                 ":checkoutRequestID"=>$checkoutRequestID,
                 ":amount"=>$amount,
                 ":mpesaReceiptNumber"=>$mpesaReceiptNumber,
                 ":balance"=>$balance,
                 ":transactionDate"=>$transactionDate,
                 ":phoneNumber"=>$phoneNumber
             );
             
             
               /**Call method to insert into db */
             $this->mpedadb->insert_lnmo_transaction($result);
             //return true;
        }else{
            $resultCode=$callbackData->Body->stkCallback->ResultCode;
            $resultDesc=$callbackData->Body->stkCallback->ResultDesc;
            $merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
            $checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;


            $result= array(
                ":resultDesc"=>$resultDesc,
                ":resultCode"=>$resultCode,
                ":merchantRequestID"=>$merchantRequestID,
                ":checkoutRequestID"=>$checkoutRequestID,
                ":amount"=>null,
                ":mpesaReceiptNumber"=>null,
                ":balance"=>null,
                ":transactionDate"=>null,
                ":phoneNumber"=>null
            );

          
            
            
    
            $this->mpedadb->insert_lnmo_transaction($result);
           // return true;

        }
        
    }



      /**Methd used to Process STKPush Callback Response and Insert it to Database */
      public function processC2B($callbackJsonMpesaResponse){

        
        $callbackData=$callbackJsonMpesaResponse;
     
            $TransactionType=$callbackData->TransactionType;
            $TransID=$callbackData->TransID;
            $TransTime=$callbackData->TransTime;
            $TransAmount=$callbackData->TransAmount;
            $BusinessShortCode=$callbackData->BusinessShortCode;
            $BillRefNumber=$callbackData->BillRefNumber;
            $InvoiceNumber=$callbackData->InvoiceNumber;
            $OrgAccountBalance=$callbackData->OrgAccountBalance;
            $ThirdPartyTransID=$callbackData->ThirdPartyTransID;
            $MSISDN=$callbackData->MSISDN;
            $FirstName=$callbackData->FirstName;
            $MiddleName=$callbackData->MiddleName;
            $LastName=$callbackData->LastName;
        
          
        
             $result= array(
                ':TransactionType'      => $TransactionType,
                ':TransID'              => $TransID,
                ':TransTime'            => $TransTime,
                ':TransAmount'          => $TransAmount,
                ':BusinessShortCode'    => $BusinessShortCode,
                ':BillRefNumber'        => $BillRefNumber,
                ':InvoiceNumber'        => $InvoiceNumber,
                ':OrgAccountBalance'    => $OrgAccountBalance,
                ':ThirdPartyTransID'    => $ThirdPartyTransID,
                ':MSISDN'               => $MSISDN,
                ':FirstName'            => $FirstName,
                ':MiddleName'           => $MiddleName,
                ':LastName'             => $LastName
             );
             
             
               /**Call method to insert into db */
             $this->mpedadb->insert_c2b_transaction($result);
             return true;
        
        
    }


}
    
    
        

?>