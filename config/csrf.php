<?php
require_once("session.php");
//CSRF class will guard against Cross Site Request forgery attack
//Note that CSRF Token works well with POST Method
class Csrf extends Session{
    protected $session;
    function __construct(){
        $this->session=new Session();
        //$this->session->startSession(0,'/',$_SERVER['SERVER_NAME'],true,true);
    }
    /*Generate CSRF Token*/
    public  function generateToken(){
        if(!isset($_SESSION['token'])){
            return $_SESSION['token']=bin2hex(random_bytes(32));
        }else{
            return $_SESSION['token']=bin2hex(random_bytes(32));
        }
    }
    /*Validate CSRF Token*/
    public  function checkToken($token){
        //If token is Valid
        if(isset($_SESSION['token']) && $token==$_SESSION['token']){
            //Unset the session token so as to make sure it is only used once
            unset($_SESSION['token']);
            return true;
        }
        //If token is invalid return false
            return false;
    }
}
?>