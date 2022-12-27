<?php
require_once('config/initialize.php');
//Instantiate Classes
$blacklistedDevices = new BlacklistedDevices();
$csrf=new Csrf();
?>
<!-- Custom JS function-->
<script type="text/javascript" src="js/function.js"></script>
<?php
if(isset($_POST['token']) && isset($_POST['insert'])){
    $token=htmlentities($_POST['token']);
    if($csrf->checkToken($token)){
        if(empty($_POST['name']) || empty($_POST['brand']) ||
        empty($_POST['model']) || empty($_POST['serial_number']) || 
        empty($_POST['imei_number']) || empty($_POST['ob_number']) || empty($_POST['area']) ){
            echo '<script>changePage("create_blacklisted_device.php","Error! Please fill in the empty fields");</script>';
        }else{
        
        //after obtaining the category name we insert it into the database
            $blacklistedDevices->setName(htmlentities($_POST['name']));
            $blacklistedDevices->setBrand(htmlentities($_POST['brand']));
            $blacklistedDevices->setModel(htmlentities($_POST['model']));
            $blacklistedDevices->setSerialNumber(htmlentities($_POST['serial_number']));
            $blacklistedDevices->setImeiNumber(htmlentities($_POST['imei_number']));
            $blacklistedDevices->setObNumber(htmlentities($_POST['ob_number']));
            $blacklistedDevices->setArea(htmlentities($_POST['area']));
            $blacklistedDevices->setCreatedAt(date("Y-m-d h:i:s"));
            $blacklistedDevices->setUpdateAt(date("Y-m-d h:i:s"));
            
            if($blacklistedDevices->insert()){
                echo "<script> changePage('create_blacklisted_device.php','You have successfully blacklisted the device'); </script>";
            }else{
                echo "<script> changePage('create_blacklisted_device.php','An error occured!Please try again later'); </script>";
            }
        }
    }else{
        echo "<script> changePage('create_blacklisted_device.php','INVALID CSRF TOKEN!');</script>";
    }
}else{
    echo "<script>changePage('create_blacklisted_device.php','INVALID REQUEST!');</script>";
}
?>