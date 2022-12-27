<?php

#############################################################################

##THIS FILE CONTAINS SPECIAL FUNCTIONS THAT AID IN CARRYING OUT SPECIFIC TASKS

##############################################################################
class Utility{
    
    //Method for inputs sanitization
    public function testInput($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data); 
        return $data;
        
    }
    
    //Method for displaying success and error message
    
    public function showMessage($type, $message){
           return '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
                <strong>'.$message.'</strong>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>';
        
    }
    
    
    public function compress($source,$destination,$quality){
        $info=getimagesize($source);
        
        if($info['mime']=='image/jpeg'){
            $image=imagecreatefromjpeg($source);
        }elseif($info['mime']=='image/png'){
             $image=imagecreatefrompng($source);
            
        }
        
        
        //imagejpeg() creates a JPEG file from the given image.
        imagejpeg($image,$destination,$quality);
        return $destination;
        
    }
    
    // PHP code to check whether the number 
    // is Even or Odd in Normal way
    function check($number){
        if($number % 2 == 0){
            echo $number % 2 ; 
        }
        else{
            echo $number % 2 ;
        }
    }

    #Generate code used for email verification
    function generateVefificationCode($len){
    	
    	$rand_str=md5(uniqid(mt_rand(),true));
    	$base64_encode=base64_encode($rand_str);
    	$modified_base64_encode=str_replace(array('+','='),array('',''),$base64_encode);
    	$token=substr($modified_base64_encode,0,$len);
    	return $token;
    }
    
    //function to redirect user to a particular page
    function redirect_to($new_location){
    return header("Location: ".$new_location);
     exit; 
    }
    
    //function that automatically loads all the classes within the root directory
    function  myAutoload($class_name){
    	$class_name = strtolower($class_name);
    	$path = LIB_PATH.DS."{$class_name}.php";
    	if(file_exists($path)){
    		require_once($path);
    	}else{
    		die("The file {$class_name}.php could not be found");
    	}
    }
    

    
    
    //function that displays the message in a paragraph
    function output_message($message=""){
    	if(!empty($message)){
    		return "<p class=\"message\">{$message}</p>";
    		
    	}else{
    		return "";
    	}
    }
}
?>