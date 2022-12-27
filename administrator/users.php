<?php
require_once('../config/initialize.php');
$user=new User();
$session=new Session();
$csrf=new Csrf();
$session->setPageTitle("users");
$session->setPageDescription("This page allows managing of users");
//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);
require_once('../layouts/admin_header_template.php');
?>
<section class="users-section"> 
    <div class="container-fluid px-4">
         <!--Section that holds the table--->
    <div class="card">
        <h3 id="create-users-header" class="text-center"> Users</h3>
    </div>
    
    <div class="card">
        <div class="card-body">
            <!-- Button trigger createModal -->
            <button   type="submit"  class="btn btn-primary addbtn mb-2"
            
             data-bs-target="#createModal" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false">Add</button>
        </div>
    </div>
    
    <div class="card">
        <div class="table-responsive">  
            <table id="users_table" class="table table-bordered table-hover w-100">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Last Login</th>
                        <th scope="col">Password</th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                    $users=$user->getAll();
                     foreach($users as $row){   
                ?>
                    <tr>
                        <td id="0"><?php echo $row['id'];?></td>
                        <td id="1"><?php echo $row['first_name'];?></td>
                        <td id="2"><?php echo $row['last_name'];?></td>
                        <td id="3"><?php echo $row['email'];?></td>
                        <td id="4"><?php echo $row['role']?></td>
                        <td id="5"><?php echo $row['created_at'];?></td>
                        <td id="5"><?php echo $row['last_login'];?></td>
                        <td id="6"><button  type='submit'  class='btn btn-success editpasswordbtn'>CHANGE</button></td>
                    </tr>
              <?php } ?>
              </tbody>
            </table>
        </div>
    </div>
     
    <!---ALL MODALS--->
<!--#############################################################################################################################################-->

<!--Start Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h3 class="modal-title text-white text-center" id="exampleModalLabel">Create User</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <!--Start of Form-->
            <form action="crud_user.php" method="post" enctype="multipart/form-data"  class="needs-validation card-body" novalidate    
            >
            <div class="modal-body">
                <!--Textfield for First Name-->
                <div class="form-group">
                    <label id="form-label" class="h4 form-control-label" for="first_name">First Name<abbr class="text-danger" title="This is required">*</abbr></label>
                    <input type="text" pattern="(\s*(?:\S\s*){2,100})" class="form-control" id="first_name" placeholder="Enter first name" name="first_name"  maxlength="100" required/>
                    <div class="valid-feedback">First Name looks good</div>
                    <div class="invalid-feedback">Please enter a valid first name.This field is required.</div>

                </div>
                <div class="form-group">
                <!--Textfield for Last Name-->
                    <label id="form-label" class="h4 form-control-label" for="last_name">Last Name<abbr class="text-danger" title="This is required">*</abbr></label>
                    <input type="text" pattern="(\s*(?:\S\s*){2,100})" class="form-control" id="fullname" placeholder="Enter last name" name="last_name"  maxlength="100" required/>
                    <div class="valid-feedback">Last name looks good</div>
                    <div class="invalid-feedback">Please enter a valid last name.This field is required.</div>

                </div>
                
                <!--Email-->
                <div class="form-group">
                    <label id="form-label" class="h4 form-control-label" for="email">Email<abbr class="text-danger" title="This is required">*</abbr></label>
                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  maxlength="50" class="form-control" id="email" placeholder="Enter email" name="email" required/>
                    <div class="valid-feedback">Email looks good</div>
                    <div class="invalid-feedback">Please enter a valid email.This field is required.</div>

                </div>
                
                <!--Role-->
                <div class="form-group">
                    <label  id="form-label" class="h4 form-control-label" for="role">User Group<abbr class="text-danger" title="This is required">*</abbr></label>
                    <select name="role" class="form-control"id="role">
                        <option value="administrator">administrator</option>
                    </select>
                    <div class="valid-feedback">User groups looks good</div>
                    <div class="invalid-feedback">Please enter a valid user group.This field is required.</div>
                </div>
                
                <!--Account status-->
                <div class="form-group" style="display:none;">
                    <label id="form-label"   class="h4 form-control-label" for="account_status">Account Status<abbr class="text-danger" title="This is required">*</abbr></label>
                    <select hidden name="account_status" id="account_status" class="form-control" required/>
                        <option value="1" selected>Active</option>
                        <option value="0">Disabled</option>
                    </select>
                    
                    <div class="valid-feedback">Account status looks good</div>
                    <div class="invalid-feedback">Please enter a valid account status.This field is required.</div>
                </div>
                
                <!--Password-->
                <div class="form-group">
                    <label id="form-label" class="h4 form-control-label" for="password">Password<abbr class="text-danger" title="This is required">*</abbr></label>
                    <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$" class="form-control" id="password"  maxlength="30" placeholder="Enter password" name="password" required/>
                    <div class="valid-feedback">Password looks good</div>
                    <div class="invalid-feedback">Please enter a valid password.This field is required.</div>
                </div>
                
            <input type="hidden" name="token" id="create_user_token"/>


      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
        <button  type="submit" name="insert" class="btn btn-primary" >Save</button>
      </div>
      </form>

    <!--End of Form-->
    
    </div>
  </div>
</div>

<!--End Create Modal-->

<!--#############################################################################################################################################-->

<!--#############################################################################################################################################-->
<!--Start Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h3 class="modal-title text-white" id="exampleModalLabel">Change Password</h3>
        <button  type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <!--Start of Form-->
      <form action="crud_user.php"  method="post" class="needs-validation" novalidate>
      <div class="modal-body">

      <input type="hidden" class="form-control" id="passworduser_id"  name="user_id" required/>
      
    <!--Password-->
    <label id="form-label" class="h4 form-control-label" for="phone">Password<abbr class="text-danger" title="This is required">*</abbr></label>
    <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$" class="form-control" id="editpassword" placeholder="Enter password" name="password"  maxlength="30" required/>
    <div class="valid-feedback">Password looks good</div>
    <div class="invalid-feedback">Please enter a password with a minimum of 8 and maximum 30 characters, at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character. This field is required..</div>
                           
    <input type="hidden" name="token" id="password_token" >

      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-secondary " data-bs-dismiss="modal">No</button>
        <button  type="submit" name="editpasssworddata" class="btn btn-primary">Yes</button>
      </div>
      </form>

    <!--End of Form-->
    
    </div>
  </div>
</div>

<!--End Password Modal-->

<?php
require_once('../layouts/admin_footer_template.php');
?>



<script>
//If hidden token field is empty assign value
if(document.getElementById("create_user_token").value.length == 0 || document.getElementById("password_token").value.length == 0){
   let value="<?php echo $csrf->generateToken();?>";
    $("#create_user_token").val(value);
    $("#password_token").val(value);
    
}


$(document).ready(function() {
    $('#users_table').DataTable({
        "order": [[ 0, "desc" ]]
        
    });
});

/*************START OF TRIGGER editpasswordbtn BUTTON**************************/

$(document).on('click','.editpasswordbtn',function(){ 
   //editModal should pop up
   $('#passwordModal').modal('show');
   
 

     
    $tr=$(this).closest('tr');

    var data=$tr.children("td").map(function(){
      return $(this).text();
    }).get();
    

    //does to form in editModal  
    $('#passworduser_id').val(data[0]);
});
/*************END OF TRIGGER editpasswordbtn BUTTON**************************/
</script>