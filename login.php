<?php
//require_once('../config/initialize.php');
require_once __DIR__ . '/config/initialize.php';
$session=new Session();
$csrf=new Csrf();
$session->setPageTitle("login");
$session->setPageDescription("This is the login page");
?>
<!--Start of Header and Navabar-->
<?php   require_once('layouts/header_template.php');?>
<!--End of Header and Navbar-->

<!--Start of Login form Section-->
<section id="page-container" class="mt-4 mb-4 p-3">
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-8 m-auto">
                <div class="card border-dark">
                    <div class="card-header bg-dark">
                        <h1 id="login-heading" class="text-center text-white"> Login</h1>
                    </div>
                    <div class="card-body">
                        <form action="authenticate_login.php" class="needs-validation" novalidate method="POST">
                            <div class="row">
                                <div class="col-md-12 mt-1 mb-3 form-group">
                                    <label class="h4 form-control-label"  for="Email">Email<abbr class="text-danger" title="This is required">*</abbr></label>
                                    <input type="text" id="email"   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter email" class="form-control"  maxlength="50" name="email" maxlength="30" value="<?php echo htmlentities($email); ?>"  required/>
                                    <div class="valid-feedback">Email  looks good</div>
                                    <div class="invalid-feedback">This is not a valid email. This field is required.</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mt-1 mb-3 form-group">
                                    <label  class="h4 form-control-label"  for="password">Password<abbr class="text-danger" title="This is required">*</abbr></label>
                                    <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$" id="password"   maxlength="30" placeholder="Enter password" name="password" maxlength="30" class="form-control" value="<?php echo htmlentities($password); ?>" required/>
                                    <div class="valid-feedback">Password looks good</div>
                                    <div class="invalid-feedback">Please enter a valid Password. This field is required.</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3 form-group">
                                    <input type="hidden" name="token" value="<?php echo $csrf->generateToken();?>"/>                                
                                 <button type="submit" value="Login" name="login" class="btn btn-dark">Login</button>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End of Login form Section-->

<!--Start of Footer Template-->
<?php require_once('layouts/footer_template.php'); ?>
<!--End of Footer Template-->

</body>
</html>