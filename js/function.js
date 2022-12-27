    
/*##################### START OF FUNCTION TO INITIATE MPESA ###############*/
    function initiateStk(){ 
        $(".make_payment").click(function(e){
            e.preventDefault();
            $("#loader").show();
            let token=$("#mpesa_token").val();
            //document.getElementById("make_payment").disabled = true;
            let phone=$("#phone").val();
            $.ajax({
                url:"stkpush.php",
                method:"POST",
                data:{make_payment:1,token:token,phone:phone},  
                success:function(response){
                     let obj = JSON.parse(response);
                    $('#mpesa_token').val(obj.token);
                    $("#loader").hide();
                    $("#exampleModal").modal("hide");
                    if(obj.msg==1){
                        stkPush();
                    }else{
                        errorMessage('index.php',obj.html);   
                    }
                }
            });
       });
    }
/*######################## END OF FUNCTION TO INITIATE MPESA #################*/

/*##################################################################################################################################*/
/**Start of STKPUsh Alert*/
/**This function shows an alert mesage to redirect user to M-PESA Payment Processing page or redirect user to resend  MPESA STKPush */
    function stkPush(){
        Swal.fire({
            title: 'Payment Instructions',
            icon: 'info',
            width: 1200,
            html: '1.Check your mobile phone for a prompt asking to enter M-PESA pin.<br>2.Enter your M-PESA PIN and the amount specified on the notification will be deducted from your M-PESA  account when you press send.<br>3.When you enter the pin and click on send, you will receive an M-PESA payment confirmation message on your mobile phone.<br>4.After receiving the M-Pesa payment confirmation message please click on the Complete order button below to complete the order.<br>',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#008000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Complete Order!',
            cancelButtonText: 'No,Send Prompt again',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location ="processing.php";
            }else{
              window.location ="index.php";
            }
          })
    }
   /**End of STKPush*/
/*##################################################################################################################################*/


/*##################################################################################################################################*/
/**Start of changePage */
/** This function will output alert message and change to a different web page when clicked */
function changePage(whereToGo, messageText)
{
    alert(messageText);
    window.location=whereToGo;
}
/**End of changePge */
/*##################################################################################################################################*/

 /*##################################################################################################################################*/
/**Start of errorMessage Alert*/
 //Function that shows a Failed alert when payment is successful and order is  place
function errorMessage(redirectURL,message){
    Swal.fire({
        title: message,
        icon: 'error',
        timer: 5000,
        timerProgressBar: true,
        allowOutsideClick: false,
         footer:"you will be automatically redirected in 5 seconds",
        confirmButtonColor: '#FF0000',
        confirmButtonText: 'CONTINUE',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location =redirectURL;
        }
         if (result.dismiss === swal.DismissReason.timer) {
          window.location =redirectURL;
      }
      })
 }
   /**End of errorMessage*/
/*##################################################################################################################################*/

 /*##################################################################################################################################*/
/**Start of successMessage Alert*/
 //Function that shows a Failed alert when payment is successful and order is  place
function successMessage(redirectURL,message){
    Swal.fire({
        title: message,
        icon: 'success',
        //timer: 5000,
        timerProgressBar: true,
        allowOutsideClick: false,
         footer:"you will be automatically redirected in 5 seconds",
        confirmButtonColor: '#FF0000',
        confirmButtonText: 'CONTINUE',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location =redirectURL;
        }
         if (result.dismiss === swal.DismissReason.timer) {
          window.location =redirectURL;
      }
      })
 }
   /**End of successMessage*/
/*##################################################################################################################################*/



/*##################################################################################################################################*/
/**Start of myTimer function*/
//function used to fetch lnmo(Lipa na Mpesa online) TransactionID from lnmo_payments table
function fetchlnmo(checkoutRequestID,stopInterval) {
  let payment_processing="payment_processing";
  let action=checkoutRequestID;
 
  $.ajax({
        url:"lnmo_payments.php",
        method:"POST",
        dataType:'json', 
        data:{action:action,payment_processing:payment_processing},  
        success:function(res){
        //console.log(res);
            if(res.checkoutRequestID==action){
              if(res.resultCode==0){
                if(document.getElementById("result").value==""){
                  document.getElementById("result").value=res.mpesaReceiptNumber;
                  myStopFunction(stopInterval);
                  document.body.className="";
                  document.getElementById("myBtn").disabled = false;
                }else{
                myStopFunction(stopInterval);
                document.getElementById("myBtn").disabled = false;
              }

            }else 

            if(res.resultCode==1032){
              myStopFunction(stopInterval);
              document.body.className="";
              errorMessage("lipa.php","Payment Cancelled");

            }else 

            if(res.resultCode!=1032 && res.resultCode!=0){
              myStopFunction(stopInterval);
              document.body.className="";
              errorMessage("lipa.php","Mpesa Transaction Failed");
            }
        }
      }
})
}
   /**End of myTimer*/
/*##################################################################################################################################*/

/*##################################################################################################################################*/
/*##################################################################################################################################*/
/**Start of setInterval */
/**Stop setInterval function */
function myStopFunction(stopInterval) {
  clearInterval(stopInterval);
}
   /**End of setInterval*/
/*##################################################################################################################################*/
/*##################################################################################################################################*/




/*##################################################################################################################################*/
/**Start of validate IMEI NUMBER function*/
function validateIMEINumber() {
    $("#searchBtn").click(function(e){
    e.preventDefault();
    let search_value = $("#search").val();
    if(search_value.length==0){
        $("#search_error").html("Please enter a value!");
    }else{
        if(search_value.match("^[0-9]{15,18}$")){
            $("#search_error").html("");
            searchBtn();
        }else{
            $("#search_error").html("Please enter the correct format for the IMEI Number");
        }
    }
    });
}
/**End of validate IMEI NUMBER function*/
/*##################################################################################################################################*/



/*##################################################################################################################################*/
/**Start of Search IMEI NUMBER function*/
function searchBtn(){
    let search=$("#search").val();
    let token_value=$("#token").val();
    // Ajax request    
    $.ajax({
        url: "crud_incomplete_search.php",
        method:'POST',
        data:{search:search,token:token_value},
        success: function(response){
            let obj = JSON.parse(response);
            $('#token').val(obj.token);
            $("#mpesa_token").val(obj.token);
            if(obj.msg==1){
                // trigger modal
                $("#mpesaModal").modal("show");
                
            }else if(obj.msg==0){
                $('#token').val(obj.token);
                 errorMessage('index.php',obj.message); 
            }
        }
    });
}
/**End of Search IMEI NUMBER function*/
/*##################################################################################################################################*/


/**############START OF function for display alrt message#####################**/
function showMessage(type,message){
    return `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>`;
}

/**############END OF function for display alert message########################**/

/*##################### START OF FUNCTION TO INITIATE MPESA ###############*/
    function contactUS(){ 
        $("#contactUsBtn").click(function(e){
            e.preventDefault();
            $("#loader").show();
            let first_name=$("#first_name").val();
            let last_name=$("#last_name").val();
            let message=$("#message").val();
            let phone_number=$("#phone_number").val();
            let email=$("#email").val();
            let token=$("#token").val();

            $.ajax({
                url:"crud_contact.php",
                method:"POST",
                data:{contact_us:1,
                first_name:first_name,
                last_name:last_name,
                message:message,
                phone_number:phone_number,
                email:email,
                token:token
                },  
                success:function(response){
                    console.log(response);
                     let obj = JSON.parse(response);
                    $('#token').val(obj.token);
                    $("#loader").hide();
                    let alert=obj.alert;
                    let message=obj.message;
                    if(obj.msg==1){
                        $("#alert_message").html(showMessage(alert,message));
                    }else{
                        $("#alert_message").html(showMessage(alert,message));
                    }
                }
            });
       });
    }
/*######################## END OF FUNCTION TO INITIATE MPESA #################*/