<?php
require_once('config/initialize.php');
$session=new Session();
$csrf=new Csrf();
$session->setPageTitle("home");
$session->setPageDescription("This is the Homepage");
$amount=1;
?>
<!--Start of Header and Navabar-->
<?php   require_once('layouts/header_template.php');?>
<!--End of Header and Navbar-->

<!--Lipa na M-pesa Section--->
<section id ="lipa-na-mpesa-section" class="content mt-4 mb-4 p-3">
    <!-- Modal -->
    <div class="modal fade" id="mpesaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h3 id="custom-product-header" class="modal-title text-center text-white mb-2">LIPA NA
                    <img src="images/M-PESA.jpg" width="100" height="40" ></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!--Start Modal Body-->
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <form method="post" action="#" enctype="multipart/form-data"  novalidate=""  id="bootstrapForm">
                                <input type="hidden" id="mpesa_token" name="token" value="">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="card-header">
                                            <h4 id="custom-product-header" class="text-center"><strong>TOTAL TO PAY <?php
                                     echo CURRENCY." ";
                                     echo $amount;?>.00</strong></h4>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="form-group">
                                            <strong id="form-text" >Please ensure you have your phone with you and sufficient balance in your account</strong>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label id="form-label" class="h4 form-control-label" for="phone">Phone Number<abbr class="text-danger" title="This is required">*</abbr></label>
                                            <input type="text" class="form-control" id="phone"   name="phone" placeholder="07xxxxxxxx"> 
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div  class="card-footer">
                                            <p id="form-text" >We will send a prompt to your phone.Enter PIN to authorize payment.Click  <strong id="form-text">PAY NOW</strong> button when ready</p>
                                        </div>
                                    </div>
                                </div>
                        </form>
                      <!--End of Card Body-->
        
                    </div>
                </div>
            </div>
            <!--Modal Body End-->
            
          <div class="modal-footer">
            <div id="loader" class="text-center" style='display: none;'>
                <img src='images/loader.gif' width='32px' height='32px'>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <button  type="submit" class="form-control btn btn-danger" data-bs-dismiss="modal">Cancel Payment</button>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <input type="hidden" id="token" name="token" value="">
                        <input  type="submit" id="make_payment" class="make_payment form-control btn btn-outline-success"  name="make_payment" value="PAY NOW: KES <?php echo $amount;?>.00";/>
                    </div>
                </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <!--End of Lipa na Mpesa Modal-->
</section>
<!--End of Modal section-->

<!--Start of Search Section-->
<section class="search-section">  
    <div id="app">
        <main class="py-2">
            <div class="container">
                <div class="row height d-flex justify-content-center align-items-center">
                    <div class="col-md-8">
                        <form  method="post">
                         <div class="search">
                         <input type="text" name="search" id="search" class="form-control" placeholder="Please Enter IMEI number here!" /> 
                         <i class="fa fa-search"></i>
                         <small class="text-danger" id="search_error"></small>
                         <input type="hidden" id="token" name="token">
                         <button id="searchBtn" name="searchBtn" class="btn btn-dark" type="submit">Search</button>
                         
                         </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</section>
<!--End of Search Section-->



<!--Start of Footer Template-->
<?php require_once('layouts/footer_template.php'); ?>
<!--End of Footer Template-->

<script>
//If hidden token field is empty assign value
if(document.getElementById("token").value.length == 0 || document.getElementById("mpesa_token").value.length == 0){
   let value="<?php echo $csrf->generateToken();?>";
    $("#token").val(value);
    $("#mpesa_token").val(value);
}



validateIMEINumber();

//Iniate M-Pesa STKPush
initiateStk();
</script>
</body>
</html>