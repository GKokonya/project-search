<?php
require_once('config/initialize.php');
$session=new Session();
$csrf=new Csrf();
$session->setPageTitle("blacklist-device");
$session->setPageDescription("This is the contact us page");
?>
<!--Start of Header and Navabar-->
<?php   require_once('layouts/header_template.php');?>
<!--End of Header and Navbar-->

<section class="blacklist-device-form-section mt-4 mb-4 p-3"> 
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-8 m-auto">
                <div class="card border-dark">
                    <div class="card-header bg-dark">
                        <h1 id="blacklist-device-heading" class="text-center text-white"> Report a Lost Device</h1>
                    </div>
                    <div class="card-body">

                    <form action="crud_blacklisted_device.php" method="POST" class="row g-3 needs-validation" novalidate>
                        
                        <input type="hidden" name="token" value="<?php echo $csrf->generateToken();?>">  
                        
                        <div class="row">
                            <div class="col-md-6 mb-3 mt-3 form-group">
                                <label for="name" class="h4"> Name<abbr class="text-danger" title="This is required">*</abbr></label>
                                <input type="text" pattern="(\s*(?:\S\s*){1,250})" id="name" class="form-control" name="name" required/>
                                <div class="valid-feedback">Name looks good</div>
                                <div class="invalid-feedback">Please enter a valid name.This field is required.</div>
                        	   </div>
                        	    
                        	   <div class="col-md-6 mb-3 mt-3 form-group">
                                    <label for="brand" class="h4">Brand<abbr class="text-danger" title="This is required">*</abbr></label>
                                    <input type="text" pattern="(\s*(?:\S\s*){1,100})" id="brand"class="form-control" name="brand" required/>
                                    <div class="valid-feedback">Brand looks good</div>
                                    <div class="invalid-feedback">Please enter a valid brand name.This field is required.</div>
                        	   </div>
                        </div>	
                        
                        <div class="row">
                            <div class="col-md-6 mb-3 form-group">
                                <label for="model" class="h4">Model<abbr class="text-danger" title="This is required">*</abbr></label>
                                <input type="text" id="model" class="form-control" name="model" required/>
                                <div class="valid-feedback">Model looks good</div>
                                <div class="invalid-feedback">Please enter a valid model name.This field is required.</div>
                            </div>

                            <div class="col-md-6 mb-3 form-group">  
                                <label for="serial_number" class="h4">Serial Number<abbr class="text-danger" title="This is required"></abbr></label>
                                <input type="text" pattern="(\s*(?:\S\s*){1,250})" id="serial_number" class="form-control" name="serial_number" />
                                <div class="valid-feedback">Serial number looks good</div>
                                    <div class="invalid-feedback">Please enter a valid serial number.This field is required.</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3 form-group">
                                <label for="imei_number" class="h4">IMEI Number<abbr class="text-danger" title="This is required">*</abbr></label>
                                <input type="text"pattern="^[0-9]{15}(,[0-9]{15,18})*$" id="imei_number" class="form-control" name="imei_number" required/>
                                <div class="valid-feedback">IMEI number looks good</div>
                                <div class="invalid-feedback">Please enter a valid IMEI number.This field is required.</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3 form-group">
                                Don't know your IMEI?
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5 mb-3 form-group">
                            1:For android users:<a class="child-right" href="https://www.google.com/android/find?u=0"  target="_blank">Click Here</a>
                            </div>
                            
                            <div class="col-md-7 mb-3 form-group">
                            2: Refer to the original packaging that came with the device
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5 mb-3 form-group">
                                <label for="ob_number" class="h4">OB Number<abbr class="text-danger" title="This is required">*</abbr></label>
                                <input type="text"  class="form-control" id="ob_number" pattern="(\s*(?:\S\s*){1,100})" name="ob_number" required/>
                                <div class="valid-feedback">OB number looks good</div>
                                <div class="invalid-feedback">Please enter a valid OB number.This field is required.</div>
                            </div>
                            
                            <div class="col-md-7 mb-3 form-group">
                                <label for="area" class="h4">Police Station where Reported<abbr class="text-danger" title="This is required">*</abbr></label>
                                <input type="text" pattern="(\s*(?:\S\s*){1,100})" class="form-control" id="area" name="area" required/>
                                <div class="valid-feedback">Police station looks good</div>
                                <div class="invalid-feedback">Please enter a valid police station.This field is required.</div>
                            </div>
                        </div>
                        
                        <div class="row">
                                <div class="col-md-12 mb-3 form-group">
                                <label for="message">Fields marked with asterisk (<abbr class="text-danger" title="This is required">*</abbr>) are mandatory</label>
                    		  </div>
                    	</div>  
                        
                        <div class="row">
                            <div class="col-md-6 mb-3 form-group">
                                <button class="btn btn-dark" type="submit" name="insert">Report</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Start of Footer Template-->
<?php require_once('layouts/footer_template.php'); ?>
<!--End of Footer Template>
</body>
</html>
