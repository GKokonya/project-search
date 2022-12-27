<?php
require_once('utility.php');
// A class to help work with sessions
//In our case primarily to manage log ins/outs
//Keep in mind when working with sessions that it is generally
//inadvisable to store DB_reated objects in sessions
class Session{
    private $logged_in = false;
    public $user_id;
    public $full_name;
    public $role;
    public $message;
    public $session_id;
    public $parameters;
    public $total;
    private $email;
    private $search_value;
    private $page_description;
    private $page_title;  
    private $search_code;
    
    private $utilityObj;

    function __construct(){
        $this->startSession(0,'/',$_SERVER['SERVER_NAME'],true,true);
        $this->check_login();
        $this->utilityObj=new Utility();

    }


    /**used to mitigate stealing session through javascript Cross site(XSS) Attacks */
    public function startSession($lifetime,$path,$host,$secure,$httponly){
          
        if(!isset($_SESSION)){  
         session_set_cookie_params($lifetime,$path,$host,$secure,$httponly);
         @session_regenerate_id(true);    
        session_start();
         } 
        //session_set_cookie_params($lifetime,$path,$host,$secure,$httponly);

        /**Lifetime */
        /**Path */
        /**Host in our case is localhost*/
        /**Secure means that it uses SSL when set to true */
        /**Htttponly menas that the session id store in the cookie is only accessed through http and not Javascript*/
    }

    public function is_logged_in(){
        return $this->logged_in;
  }


  #This function carries the user id and full name once the user has logged in
    public function login($user_session){
        //database finds user based on username and password
        if($user_session){

        /**Regenerates a new session id whenever a http request is made */
        //$this->session_id=session_regenerate_id(true); 
        $this->user_id = $_SESSION["user_id"] = $user_session['id'];
        $full_name=$user_session['first_name'].' '.$user_session['last_name'];
        $this->full_name = $_SESSION["full_name"] =$full_name;
        $this->role = $_SESSION["role"] = $user_session['role'];
        $this->logged_in = true;
        }
    }
    
      #This function carries the user id and full name once the user has logged in
    public function UpdateSessionName($first_name,$last_name){
        //database finds user based on username and password
        if($first_name  && $last_name){
        //$this->user_id = $_SESSION["user_id"] = $user_session['id'];
        $full_name=$first_name.' '.$last_name;
        $this->full_name = $_SESSION["full_name"] =$full_name;
        }
    }
  
  #This function unsets the user id and the full name when the user logs out
    public function logout(){
    
    /**Unsets all session variables */
    session_unset();
    
    /**Checks if session is stoed in cookie */

      if(ini_get("session.use_cookies")){

          $params=$this->parameters;

          /**Gets cookie parameters */
         $params=session_get_cookie_params();
         
         /**Deletes the php session cookie from the web browser*/
         setcookie(session_name(),'',time()-3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);

      }
      
        /**Completely destroys all session details */
        session_destroy();
        
        $this->logged_in = false;
    }

    public function message($msg=""){
        if(!empty($msg)){
            //then this is "set message"
            //make sure you understand why $this->message = $msg wouldn work
            $_SESSION["message"] = $msg;
        }else{
            //then this is "get message"
            return $this->message;
        }
    }
    
    public function check_Message(){
        if(!empty($msg)){
            //then this is "set message"
            //make sure you understand why $this->message = $msg wouldn work
            $_SESSION["message"] = $msg;
        }else{
            //then this is "get message"
            return $this->message;
        }
    }
    
    
    private function check_login(){
        if(isset($_SESSION['user_id']) && isset($_SESSION["full_name"]) && isset($_SESSION['role'])){
      $this->user_id = $_SESSION['user_id'];
      $this->full_name = $_SESSION['full_name'];
      $this->role = $_SESSION['role'];
      
            $this->logged_in = true;
        }else{
        unset($_SESSION["user_id"]);
        unset($_SESSION["full_name"]);
            $this->logged_in = false;
        }
    }
    public function getMessage(){
        //Is there a message stored in the session
        if(isset($_SESSION['message'])){
            //Add it as an attribute and erase the stored version
            $this->message = $_SESSION["message"];
            unset($_SESSION['message']);
        }else{
            $this->message = "";
        }
  }

    //fuunction to confirm wheher or not a user is logged in
    public function confirm_logged_in(){
        if (!$this->is_logged_in()) { 
          //redirect_to("../login.php"); 
         $this->utilityObj->redirect_to("../login.php"); 
        } 
    }
    
    //function to check the user role
    public function checkRole ($user_role, $page_role){
        if($user_role !== $page_role){
           
           $this->utilityObj->redirect_to("../login.php"); 
        }
    }
    
    //function to set the CheckoutRequestID
    public function setCheckoutRequestID($CheckoutRequestID){
        if(!isset($_SESSION['CheckoutRequestID'])){
            $_SESSION['CheckoutRequestID']=$CheckoutRequestID;
        }else{
             $_SESSION['CheckoutRequestID']=$CheckoutRequestID;
        }
    }
    
    //function to get the $CheckoutRequestID
    public function getCheckoutRequestID(){
        if(isset($_SESSION['CheckoutRequestID'])){
    		return $_SESSION['CheckoutRequestID'];
        }else{
           // return $_SESSION['CheckoutRequestID']=0;
         return  $_SESSION['CheckoutRequestID']=$CheckoutRequestID;
     
        }
    }
    
    //function to set the Email
    public function setEmail($email){
        if(!isset($_SESSION['email'])){
            $this->email = $_SESSION["email"] = $email;
        }else{
             $this->email = $_SESSION["email"] = $email;
        }
    }
    
    //function to get the Email
    public function getEmail(){
        if(isset($_SESSION['email'])){
    		return  $this->email = $_SESSION["email"];
        }else{
            return $this->email = $_SESSION["email"]=0;
     
        }
    }
    
    
    //function to set the Email
    public function setSearchValue($email){
        if(!isset($_SESSION['search_value'])){
            $this->search_value = $_SESSION["search_value"] = $search_value;
        }else{
             $this->search_value = $_SESSION["search_value"] = $search_value;
        }
    }
    
    //function to get the search_value
    public function getSearchValue(){
        if(isset($_SESSION['search_value'])){
    		return  $this->search_value = $_SESSION["search_value"];
        }else{
            return $this->search_value = $_SESSION["search_value"]=0;
     
        }
    }
    
    //function to set page description
    function setPageTitle($page_title){
        if(!isset($_SESSION['page_title'])){
            $this->page_title = $_SESSION["page_title"] = $page_title;
        }else{
             $this->page_title = $_SESSION["page_title"] = $page_title;
        }
    } 
    
    //function to get page title
    function getPageTitle(){
        if(isset($_SESSION['page_title'])){
            return $this->page_title = $_SESSION["page_title"];
        }else{
            return $this->page_title = $_SESSION["page_title"]=0;
        }
    } 
    
    //function to set page description
    function setPageDescription($page_description){
         if(!isset($_SESSION['page_description'])){
            $this->page_description = $_SESSION["page_description"] = $page_description;
        }else{
             $this->page_description = $_SESSION["page_description"] = $page_description;
        }
    }
    
    //function to get page description
    function getPageDescription(){
        if(isset($_SESSION['page_description'])){
           return $this->page_description = $_SESSION["page_description"];
        }else{
            return $this->page_description = $_SESSION["page_description"]=0;
        }
    }
    
    //function to set page description
    function setSearchCode($search_code){
         if(!isset($_SESSION['search_code'])){
            $this->search_code = $_SESSION["search_code"] = $search_code;
        }else{
             $this->search_code = $_SESSION["search_code"] = $search_code;
        }
    }
    
    //function to get page description
    function getSearchCode(){
        if(isset($_SESSION['search_code'])){
           return $this->search_code = $_SESSION["search_code"];
        }else{
            return $this->search_code = $_SESSION["search_code"]=0;
        }
    }
}
?>