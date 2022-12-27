<?php
	require_once('config/initialize.php');
    if(isset($_POST['payment_processing']) && isset($_POST['action'])){
    $action=htmlentities($_POST['action']);
    $lnmo=new MpesaDB();
    $rows=$lnmo->getlnmo($action);
    $data=array();
    if (!$rows) { // here! as simple as that
        $data['null']=0;
    }else{
        foreach($rows as $row) {
            $data["mpesaReceiptNumber"] = $row["mpesaReceiptNumber"];
            $data["checkoutRequestID"] = $row["checkoutRequestID"];
            $data["resultCode"]=$row["resultCode"];
        }
    }
    echo json_encode($data);
    }else{
        echo "This is not a valid Transaction";
    }
?>
    
   
   
  