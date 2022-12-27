<?php 
//require_once('../config/initialize.php');
require_once __DIR__ . '/config/initialize.php';
$session=new Session();
$csrf=new Csrf();
//obtaining the user id from the session class
$session->setPageTitle("process-mpesa");
$session->setPageDescription("This is the page used to validate mpesa transaction");

//$session->setcheckoutRequestID('ws_CO_191220212143411300');
//$session->setSearchCode('268');

$checkoutRequestID=$session->getcheckoutRequestID();
$session->getSearchCode();
?>
<!--Start of Header and Navabar-->
<?php   require_once('layouts/header_template.php');?>
<!--End of Header and Navbar-->

<!--Display loader when input field is empty-->
<div class="loading-bar"></div>

<section id ="content" class="confirm-mpesa-transaction content bg-light p-5">
    <div class="container">
        <div class="card d-flex justify-content-center">
              <!-- Modal Header -->
              <div class="modal-header d-flex justify-content-center">
              <h4 class="mpesa header">LIPA NA
              <img src="images/M-PESA.jpg" width="100" height="40" ></h4>
              </div>
                <div class="card-body d-flex justify-content-center">
                    
                    <form class="col-sm-6" method="POST" action="result.php" enctype="multipart/form-data"  novalidate=""  id="lnmo_payment">
                       <div class="form-group">
                           <label class="h4 form-control-label" for="result">Transaction ID<abbr class="text-danger" title="This is required">*</abbr></label>
                           <input type="text" class="form-control" id="result" readonly name="result" placeholder="Mpesa Transaction ID" required>
                           <div class="valid-feedback">Transaction ID  looks good</div>
                           <div class="invalid-feedback">Please enter a  valid Transaction ID. This field is required.</div> 
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="token" value="<?php echo $csrf->generateToken();?>"> 
                        <input type="submit" class="form-control btn btn-outline-success" id="myBtn" name="confirm_mpesa_transactionID" value="CONFIRM PAYMENT";>
                        </div>
                     </form>
            </div>
        </div>
    </div>
</section>

<!--Start of Footer Template-->
<?php require_once('layouts/footer_template.php'); ?>
<!--End of Footer Template-->

<script>
//Intialize body of HTML document to loading to that is displays loader
document.body.className="loading";
document.getElementById("myBtn").disabled = true;
let cqID="<?php echo $checkoutRequestID;?>"; 
let id=setInterval(function() { 
 fetchlnmo(cqID,id)}, 2000);
</script>
</body>
</html>