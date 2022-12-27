<?php
//require_once('../config/initialize.php');
require_once __DIR__ . '/config/initialize.php';
$session=new Session();
$csrf=new Csrf();
$session->setPageTitle("contact");
$session->setPageDescription("This is the contact us page");
?>
<!--Start of Header and Navabar-->
<?php   require_once('layouts/header_template.php');?>
<!--End of Header and Navbar-->

<!--Start of Contact Form Section-->
<section class="contact-form-section mt-4 mb-4 p-3"> 
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-8 m-auto">
                <div class="card border-dark">
                    <div class="card-header bg-dark">
                        <h1 id="login-heading" class="text-center text-white"> Contact Us</h1>
                    </div>
                    <div class="card-body">
                        
                        <h3 style="text-align: center;">We'd love to hear from you!</h3>
                        <div id="alert_message"></div>
                        <div id="loader" class="text-center" style='display: none;'>
                            <img src='images/loader.gif' width='32px' height='32px'>
                        </div>
                        
                        <form action="crud_contact.php" method="POST" class="needs-validation" novalidate>

                            <input type="hidden" id="token" name="token"/>
                            <div class="row">
                                <div class="col-md-6 mb-3 form-group">
                                    <label for="first_name">First Name<abbr class="text-danger" title="This is required">*</abbr></label>
                        	        <input type="text"  pattern="^[a-zA-Z]{2,30}$" class="form-control" name="first_name"  id="first_name"  required/>
                        	       <div class="valid-feedback">First Name looks good</div>
                          <div class="invalid-feedback">Please enter a valid first name.This field is required.</div>
                        	    </div>

                                <div class="col-md-6 mb-3 form-group">
                        	        <label for="last_name">Last Name<abbr class="text-danger" title="This is required">*</abbr></label>
                        	        <input type="text"  pattern="^[a-zA-Z]{2,30}$" class="form-control" name="last_name"  id="last_name" required/>
                        	       <div class="valid-feedback">last name looks good</div>
                                    <div class="invalid-feedback">Please enter a valid last name.This field is required.</div>
                        	   </div>
                        	</div>
                        	        
                            <div class="row">
                                <div class="col-md-6 mb-3 form-group">
                    	            <label for="Email">Email<abbr class="text-danger" title="This is required">*</abbr></label>
                    		        <input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" name="email"  id="email"  required/>
                    		    </div>

                                <div class="col-md-6 mb-3 form-group">
                            	    <label for="phone_number">Phone Number<abbr class="text-danger" title="This is required">(Optional)</abbr></label>
                            		<input type="text"  id="phone_number" name="phone_number" class="form-control" placeholder="0712345678" pattern="^(\d{10})$"/>
                    		      </div>
                    		</div>  
                    		
                    		<div class="row">
                                <div class="col-md-12 mb-3 form-group">
                            	    <label for="message">Message<abbr class="text-danger" title="This is required">*</abbr></label>
                            		<textarea class="form-control" name="message"  id="message" pattern="(\s*(?:\S\s*){1,250})" maxlength="250" minlength="1" required/></textarea>
                    		
                    		  </div>
                    		</div>  
                    		
                    		<div class="row">
                                <div class="col-md-12 mb-3 form-group">
                                <label for="message">Fields marked with asterisk (<abbr class="text-danger" title="This is required">*</abbr>) are mandatory</label>
                    		  </div>
                    		</div>  
                    		
                        	<button type="submit" id="contactUsBtn"  name="contact_us" class="btn btn-dark">Send Message</button>
                        </form>
                    </div>
    	        </div>
    	   </div>
    	</div>
    </div>
</section>
<!--End of Contact Form Section-->

<!--Start of Footer Template-->
<?php require_once('layouts/footer_template.php'); ?>
<!--End of Footer Template-->

<script>
//If hidden token field is empty assign value
if(document.getElementById("token").value.length == 0){
   let value="<?php echo $csrf->generateToken();?>";
    $("#token").val(value);
}

//contactUS();


</script>
</body>
</html>