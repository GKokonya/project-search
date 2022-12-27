<?php
require_once('config/initialize.php');
$session=new Session();

$session->setPageTitle("result");
$session->setPageDescription("This is the page used to identify if a device or gadget has been reported lost or stolen");

$blacklistedDevices = new BlacklistedDevices();
$csrf=new Csrf();
$search="";
$completeSearch=new CompleteSearch();
$inCompleteSearch=new InCompleteSearch();
$utility=new Utility();

$checkoutRequestID=$session->getcheckoutRequestID();
$session->getSearchCode();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>

    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Bootstrapcss link-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
      crossorigin="anonymous"
    />
    <!--font awesome-->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
      integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
      crossorigin="anonymous"
    />

    <!--Slick Css-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
      integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"
      integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
      crossorigin="anonymous"
    />
    <!--Custom CSS link-->

    <link rel="stylesheet" href="css/style.css" />
    <script type="text/javascript" src="js/function.js"></script>
    <!--JS Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    
    <!--Navbar-->
    <?php   require_once('layouts/header_template.php');?>
    <!--End Navbar-->
    
    <?php
    if(isset($_POST['token'])){
        $post_token=htmlentities($_POST['token']);
         ##########################START OF VALID CSRF TOKEN #######################
        if($csrf->checkToken($post_token)){
             /*Sanitize mpesa Transaction ID*/
            $postTransactionID=empty($_POST['result'])?$postTransactionID="None": $postTransactionID=htmlentities($_POST['result']);
            ################### START OF M-PESA ####################################
            if(isset($_POST['confirm_mpesa_transactionID'])){
                   /**Instantiate MpesaDB class
                   This class handles all mpesa transactions stored in the database*/ 
                   $mpesaDB=new MpesaDB();
                   $checkoutRequestID=$session->getcheckoutRequestID();
                   /**
                    *  Check if mpesa postTransactionID is equal to TransactionID in lnmo_payments table
                    *If TransactionID does not exist in the lnmo_table then it is a fake transaction
                    */
                   if($mpesaDB->getlnmoTransanctionID($checkoutRequestID)==$postTransactionID){
                     
                    
                    /**
                    *  Check if mpesa postTransactionID exists in payment_details table
                    *If postTransactionID exists in the payment_details then it should flag an error to show that the transaction already exists
                    */
                    if($postTransactionID==$completeSearch->getTransanctionID($postTransactionID)){
                             echo"<script>
                             errorMessage('index.php','This transaction already exists!');
                             </script>";
                            
                        }else{
                            $payment_method="M-PESA";
                            $search_code=$session->getSearchCode();
                            
                            //Fetch data fro mpesa table
                            $mpesaArrays=$mpesaDB->getlnmo($checkoutRequestID);
                            foreach($mpesaArrays as $mpesaArray) {
                                $phone_number=$mpesaArray['phoneNumber'];
                            }
                            
                            //Fetch data from incomplete table
                            $inCompleteSearchArray=$inCompleteSearch->getBySearchCode($search_code);
                            
                            $id=$inCompleteSearchArray['id'];
                            $ip_address=$inCompleteSearchArray['ip_address'];
                            $user_agent=$inCompleteSearchArray['user_agent'];
                            $imei_number=$inCompleteSearchArray['imei_number'];
                            $transaction_id=$postTransactionID;
                            $created_at=date("Y-m-d H:i:s");
                            $updated_at=date("Y-m-d H:i:s");
                            
                            $search=$inCompleteSearchArray['imei_number'];
                            /*If postTransactionID does not exist in the payment_detail then place order*/
                            //If transaction succeeds
                            if($completeSearch->completeSearch($id,$search_code,$ip_address,$user_agent,$imei_number,$transaction_id,$payment_method,$phone_number,$created_at,$updated_at)){
                            echo"<script>;
                            errorMessage('index.php','Payment Failed!');
                            </script>";
                            
                            //  If Transaction Fails
                            }else{
                                 //SetCHeckoutRequestID to 0
                                //$session->setcheckoutRequestID(0);
                                //$session->setSearchCode(0);
                                //Success Page
                                ?>
                                
                                <div id="a">
                                    <main class="py-2">
                                        <div class="container">
                                            <div class="row height d-flex justify-content-center align-items-center">
                                                <div class="col-12">
                                                    
                                                    
                                                    <table class="table table-dark table-hover">
                                                        <thead>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php 
                                                                 $search=$blacklistedDevices->search($search);
                                                                if(empty($search)){
                                                                    echo '<td colspan="2">The IMEI number is clean</td>';
                                                                }else{
                                                                ?>
                                                                     <td><?php echo $search['brand'];?></td>
                                                                    <td><?php echo $search['model'];?></td>
                                                                <?php
                                                                }
                            
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-12 alert alert-danger">
                                                    <h1 class="text-center"><i class="fas fa-exclamation-triangle"></i>Disclamer!</h1>
                                                    <h2>Please not that we rely on data from various sources and the data may note be conclusive</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </main>
                                </div>
                                
                                <?php
                                
                        }

                    }
                       
                }
                //If Transacion ID does not exist in lnmo_payments table then flag an error
                 else{
                    echo "<script>
                    errorMessage('index.php','This is not a valid Transaction ID!');
                    </script>";
                       
                }
                
            }
            ########################## END OF MPESA ################################
        ##########################END OF VALID CSRF TOKEN ##########################
        
        
        
    ######################### START OF INVALID CSRF TOKEN###########################        
        }else{
             echo"<script>errorMessage('index.php','INVALID TOKEN!')</script>";
        }
    ######################### END OF INVALID CSRF TOKEN#############################      
    }
    
    ########################## START OF  TOKEN IS NOT SET ##########################
    else{
        echo"<script>
        errorMessage('index.php','This is not a valid Transaction/No Token Set!');
        </script>";
    
    }
    ########################## END OF  TOKEN IS NOT SET ##########################
    ?>


    <!--Footer-->
    <?php require_once('layouts/footer_template.php'); ?>
            <script type="text/javascript" src="js/function.js"></script>
</body>
</html>