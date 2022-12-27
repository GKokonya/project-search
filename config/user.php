<?php
require_once('initialize.php');
require_once('database.php');
class User{
    protected $tableName = 'users';
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $role;
    private $password;
    private $email_verified;
    private $account_status;
    private $token;
    private $created_at;
    private $update_at;
    private $last_login;

    private $temp_path;
	protected $upload_dir="profile_pics";
    public $errors = array();
    private $dbConn;
    private $merchant="Merchant";

	protected $upload_errors = array(
	  UPLOAD_ERR_OK =>"No errors.",
    UPLOAD_ERR_INI_SIZE =>"larger than upload max_file_size.",
    UPLOAD_ERR_FORM_SIZE =>"larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL => "Partial upload.",
    UPLOAD_ERR_NO_FILE =>"No file",
    UPLOAD_ERR_NO_TMP_DIR=>"No temporary directory",
    UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
	);
  
    //encapsulating the properties in setters and getters

    public function setId($id) { $this->id = $id; }
    public function geId() { return $this->id; }
    
    public function setFirstName($first_name) { $this->first_name = $first_name; }
    public function getFirstName() { return $this->first_name; }
    
    public function setLastName($last_name) { $this->last_name = $last_name; }
    public function getLastName() { return $this->last_name; }
    
    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }
    
    
    public function setRole($role) { $this->role = $role; }
    public function getRole() { return $this->role; }
    
    public function setPassword(String $password) { $this->password = $password; }
    public function getPassword() { return $this->password; }
    
    public function setToken($token) { $this->token = $token; }
    public function getToken() { return $this->token; }
    
    public function setEmailVerified($email_verified) { $this->email_verified = $email_verified; }
    public function getEmailVerified() { return $this->email_verified; }

    public function setAccountStatus($account_status) { $this->account_status = $account_status; }
    public function getAccountStatus() { return $this->account_status; }
    
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function getCreateAt() { return $this->created_at; }

    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    public function __construct(){
        $db = new DBConnect();
        $this->dbConn = $db->connect();
    }

    //create users in the users table
    public function insert(){
        $sql = 'INSERT INTO ' .$this->tableName. ' VALUES(null, :first_name,:last_name, :email, :role,:password, :token,:email_verified, :account_status, :created_at,:updated_at,null)';
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':first_name',$this->first_name);
        $stmt->bindParam(':last_name',$this->last_name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':role',$this->role);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':token',$this->token);
        $stmt->bindParam(':email_verified',$this->email_verified);
        $stmt->bindParam(':account_status',$this->account_status);
        $stmt->bindParam(':created_at',$this->created_at);
        $stmt->bindParam(':updated_at',$this->updated_at);
       if($stmt->execute()){
           return true;

       }else{
           return false;
       }



    } 

    //function to get All Users
    public function getAll(){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    
    //function to find the user by id
    public function getByID($id){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName. ' WHERE id = :id');
        $stmt->execute(['id'=> $id]);
        $users = $stmt->fetch();
        return $users;
    }

    public function getUserByEmail($email){
        $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE email = :email');
        $stmt->execute(['email'=> $email]);
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        return $users;
    }
    
    //Checks whether Token is valid
    public function validToken($email,$token){
      $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE email = :email AND token=:token');
      $stmt->bindParam(':token',$token);
      $stmt->bindParam(':email',$email);
      $stmt->execute();
      $users=$stmt->fetch();
      return $users;
    }

  //Change Account status
  public function changeAccountStatus(){
      $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET account_status = :account_status WHERE email = :email');  
      $stmt->bindParam(':email',$this->email);
      $stmt->bindParam(':account_status',$this->account_status);

    if($stmt->execute()){
      return true;
    }else{
     return false;
    }
  }
  
  
  //Update last Login
  public function setLastLogin($email){
      /**Get Current datetime */
      $last_login=date("Y-m-d H:i:s");
      $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET last_login= :last_login  WHERE email = :email');  
      $stmt->bindParam(':email',$email);
      $stmt->bindParam(':last_login',$last_login);
      
      if($stmt->execute()){
          return true;
          
      }else{
          return false;
          
      }
   }


  public function validation($email,$phone){
    $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE email = :email OR phone= :phone');
        $stmt->execute(['email'=> $email]);
        $stmt->execute(['phone'=> $email]);
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        return $users;

  }


   
   
       //function to update token for a user
     public function setTokenZero($token){
        $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET token=0  WHERE token = :token');  
          $stmt->bindParam(':token',$token);
          if($stmt->execute()){
              return true;
          }else{
              return false;
          }
         
     }
   
       //Change Email Verified status
  public function changeEmailVerified($email,$email_verified,$token){
      $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET email_verified = :email_verified, token=:token WHERE email = :email');
      $stmt->bindParam(':email_verified',$email_verified);
      $stmt->bindParam(':token',$token);
      $stmt->bindParam(':email',$email);

    if($stmt->execute()){
      return true;
    }else{
     return false;
    }
  }
  
     //Email Verification
    public function emailVerification($email,$token,$email_verified){
      $stmt = $this->dbConn->prepare('SELECT * FROM '.$this->tableName.' WHERE email = :email AND token=:token AND email_verified=:email_verified');
      $stmt->bindParam(':token',$token);
      $stmt->bindParam(':email',$email);
      $stmt->bindParam(':email_verified',$email_verified);
      $stmt->execute();
      $users=$stmt->fetch();
      return $users;
    }


     //function to update token for a user
     public function updatePassword(){
       $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET password = :password  WHERE id=:id');  
       $stmt->bindParam(':password',$this->password);
       $stmt->bindParam(':id',$this->id);
       if($stmt->execute()){
         return true;
        }else{
          return false;
        }

      }


    //delete a single user 
    public function delete($id){
	    $stmt = $this->dbConn->prepare('DELETE FROM '.$this->tableName . ' WHERE id = :id');
	    if($stmt->execute(['id'=>$id])){
		    return true;
	    }else{
		    return false;
	    }
    }
    
    //update first name and last name
    public function updateName(){
       $stmt = $this->dbConn->prepare('UPDATE '.$this->tableName. ' SET first_name = :first_name, last_name=:last_name  WHERE id=:id');  
       $stmt->bindParam(':first_name',$this->first_name);
       $stmt->bindParam(':last_name',$this->last_name);
       $stmt->bindParam(':id',$this->id);
       if($stmt->execute()){
         return true;
        }else{
          return false;
        }

      }




  //functions to encrypt password

    //1 function that generates the salt
    public function generate_salt($length) {
        // Not 100% unique, not 100% random, but good enough for a salt
        // MD5 returns 32 characters
        $unique_random_string = md5(uniqid(mt_rand(), true));
        
          // Valid characters for a salt are [a-zA-Z0-9./]
        $base64_string = base64_encode($unique_random_string);
        
          // But not '+' which is valid in base64 encoding
        $modified_base64_string = str_replace('+', '.', $base64_string);
        
          // Truncate string to the correct length
        $salt = substr($modified_base64_string, 0, $length);
        
          return $salt;
      }
    //2: function that encrypts the password
    public function password_encrypt($password) {
        $hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
        $salt_length = 22; 					// Blowfish salts should be 22-characters or more
        $salt = $this->generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
          return $hash;
      }
    //3: function that checks the inserted password and compares it with the one in the db
    public function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
      return true;
	  } else {
      return false;
    }
    }
    
    //4:function that attempts to login a user
    public function attempt_login($email, $password) {
    $myuser = $this->getUserByEmail($email);
    
		
      if($myuser){
        //found author now check password
        if($this->password_check($password,$myuser['password'])){
          //password matches 
          return $myuser;
        }else{
          //password does not matche
          return false;
        }
        
      }else{
        
        return false;
      }
    
  }
}//end of user class
?>