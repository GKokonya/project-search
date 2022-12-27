<?php
require_once('config/initialize.php');
//Instantiate Classes
$inCompleteSearch = new InCompleteSearch();
$session=new Session();
$csrf=new Csrf();

if(isset($_POST['token']) || isset($_POST['search'])){
    $token=htmlentities($_POST['token']);
    if($csrf->checkToken($token)){
        $imei_number=htmlentities($_POST['search']);
        $pattern = "/^[0-9]{15,18}$/";
        if(preg_match($pattern, $imei_number)!=1){ 
            $token=$csrf->generateToken();
            $output=array(
            'token'=>$token,
            'msg'=>'0',
            'message'=>'Please Enter a valid IMEI Number'
            );
            echo json_encode($output);
        }else{
            $last_id=$inCompleteSearch->getLastId();
            $search_code=1+$last_id;
            $session->setSearchCode($search_code);
            $inCompleteSearch->setSearchCode($search_code);
            $inCompleteSearch->setIpAddress($_SERVER['REMOTE_ADDR']);
            $inCompleteSearch->setUserAgent($_SERVER["HTTP_USER_AGENT"]);
            $inCompleteSearch->setImeiNumber($imei_number);
            $inCompleteSearch->setCreatedAt(date("Y-m-d h:i:s"));
            $inCompleteSearch->setUpdateAt(date("Y-m-d h:i:s"));
            
            if($inCompleteSearch->insert()){
                $token=$csrf->generateToken();
                $session->setSearchCode($search_code);
                $output=array(
                'token'=>$token,
                'msg'=>'1',
                'message'=>'Success!Search/Insert for IMEI number successfully'
                );
                echo json_encode($output);
            }else{
                $token=$csrf->generateToken();
                $output=array(
                'token'=>$token,
                'msg'=>'0',
                'message'=>'Error!Failed to search/Insert for IMEI Number'
                );
            echo json_encode($output);
            }
        }
    }else{
        $token=$csrf->generateToken();
        $output=array(
        'token'=>$token,
        'msg'=>'0',
        'message'=>'Invalid Csrf Token'
        );
        echo json_encode($output);
    }
}else{
    $token=$csrf->generateToken();
    $output=array(
    'token'=>$token,
    'msg'=>'0',
    'message'=>'Invalid Requesr'
    );
    echo json_encode($output);
}
?>