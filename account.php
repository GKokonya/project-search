<?php

require_once('../includes/initialize.php');
$session = new Session();
$cookie = new Cookie();
$csrf=new Csrf();
$user = new User();
//Call Category Class
$categoryObj=new Category();
//obtaining the user id from the session class
$id = $session->user_id; 
//to check whether the user has logged in
define("ROLE","Customer");
//get the user session role 
$role = $session->role;
//function that checks whether the user is logged in and whether the role is correct

$session->checkUserRole($role,ROLE);

$user_array = $user->getUserByID($id);

if(isset($_POST['update'])){
    $user->setFullName($_POST['fullname']);
    $user->setPhone($_POST['phone']);
    $user->setUserId($id);
    
    
    if(!empty($user_array)){
        $user->update_some();
           echo "<script>
        alert('Update Successful: Refresh Page to view Changes');
        </script>";
    }else{
        echo "<script>
        alert('Update Failed');
        </script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="icon" href="icons/estore.png" type="image/png" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
       .custom-img{
           border-radius: 50%;
          height: 200px;
             width: 200px;
             object-fit: cover;
             object-position: center;
                   }
    </style>   

    <title>My Account</title>

</head>
<body>
       <!--NavBar-->
    <nav class="navbar navbar-dark navbar-expand-lg bg-success">
      <div class="container-fluid">
        <a href="index.php"
          ><img
            id="logo"
            class="rounded-circle m-3"
            src="images/dove-image.jpg"
            alt="logo"
        /></a>
        <a class="navbar-brand" href="index.php">Pepea</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto navbar-nav-scroll" style="--bs-scroll-height: 250px;">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="index.php"
                >Home</a>
            </li>
                        <!--Start Category-->
            <li class="nav-item dropdown ">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarScrollingDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Category
              </a>
              <ul
                class="dropdown-menu bg-dark "
                aria-labelledby="navbarScrollingDropdown"
              >
                <?php
                $categoryRows=$categoryObj->getAllCategories();
                  foreach($categoryRows as $categoryRow){?>
                    <li>
                        <a class="dropdown-item text-success text-center" 
                        href="view_product.php?category=<?php echo $categoryRow["category_name"];?>" >
                            <?php echo $categoryRow['category_name'] ?>
                        </a>
                    </li>
                <?php
                  }
                ?>
              </ul>
            </li>
            <!--End Category-->
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle active"
                href="#"
                id="navbarScrollingDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                User
              </a>
              <ul
                class="dropdown-menu bg-dark text-center"
                aria-labelledby="navbarScrollingDropdown"
              >
                <li><a class="dropdown-item text-success" href="login.php">Login</a></li>
                <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-success" href="logout.php">Logout</a></li>
                <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-success " href="create_account.php">Sign Up</a></li>
                <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-success" href="customer_orders.php">Orders</a></li>
                <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-success" href="customer_wishlist.php">Wishlist</a></li>
                <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-white" href="account.php">Account</a></li>
                  <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-success" href="contact_us.php">Contact Us</a></li>
                <li><hr class="dropdown-divider text-white" /></li>
                <li><a class="dropdown-item text-success" href="reset.php">Change Password</a></li>
              </ul>
            </li>
             <li class="nav-item dropdown ">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarScrollingDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Products
              </a>
              <ul
                class="dropdown-menu bg-dark "
                aria-labelledby="navbarScrollingDropdown"
              >
                <li><a class="dropdown-item text-success text-center" href="view_product.php" >View Product</a></li>
                
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="cart.php" 
                ><i class="fa fa-shopping-cart fa-2x text-dark"></i
                ><span class="badge bg-secondary"> (<?php echo $cookie->cart_count();?>)</span></a
              >
            </li>
            
          </ul>
        </div>
      </div>
    </nav>
    <!--end-NavBar--> 
    <!--Showcase--img--div-->
    <section id="img-section" class="mt-4 mb-4 p-2">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center m-auto">
                    <img  class="custom-img " src="profile_pics/<?php echo $user_array['profile_pic_name'];?>" alt="Avatar"  />
                </div>
            </div>
        </div>
    </section>
    <!--end showcase---->
    <!--Sign up form-->
<section id="sign-up" class="mt-4 mb-4 p-2">
<div class="container">
  <div class="row">
    <div class="col-md-8 m-auto">
      <div class="card border-success">
               <div class="card-header bg-success">
               <h3 id="sign-up-heading" class="text-center text-white">My Account</h3>
               </div>
                <div class="card-body">
                <p class="text-center text-danger"><?php echo $message;?></p>
                  <form action="account.php" class="" method="post" enctype="multipart/form-data"  novalidate=""   id="bootstrapForm"  onsubmit="return imageValidation();" >
                          <!--Full Name-->
                          <div class="row">
                              <div class="col-md-12 mb-2">
                              <div class="form-group">
                                  <label id="form-label" class="h4 form-control-label" for="fullname">Full Name<abbr class="text-danger" title="This is required">*</abbr></label>
                                  <input type="text" class="form-control" id="fullname" placeholder="eg. John" name="fullname" pattern="^[a-zA-Z]{2,30}$"   maxlength="100" required value="<?php 
                                      if(isset($id)){
                                        echo  $user_array['full_name'];
                                      }else{
                                          echo "";
                                      }?>">
                                  <div class="valid-feedback">Name  looks good</div>
                                  <div class="invalid-feedback">Please enter an Name like John. This field is required.</div>
                                </div>
                              </div>
                          </div>
                          
                          <div class="row">
                                <div class="col-md-12 mb-2">
                                  <!--Phone-->
                                    <div class ="form-group">
                                      <label id="form-label" class="h4 form-control-label"  for="phone">Phone Number<abbr class="text-danger" title="This is required">*</abbr></label>
                                        <input type="text" class="form-control" id="phone" placeholder="e.g 0711112222" pattern="^0((1|7)(\d{8}))$"  name="phone" maxlength="10" required value="<?php  if(isset($id)){
                                        echo  $user_array['phone'];
                                      }else{
                                          echo "";
                                      }?>">
                                        <div class="valid-feedback">Phone Number  looks good</div>
                                        <div class="invalid-feedback">Please enter a phone # like 0712345678. This field is required.</div>
                                    </div> 
                                </div>
                          </div>
                          <!--Select-Image-BTN
                          <div class="row">
                            <div class="col-md-12 mb-2">
                              <div class="form-group">
                                  <label id="form-label" class="form-label" for="Select an Image">Select an image<abbr class="text-danger" title="This is required">*</abbr></label>
                                  <input type="file" id="image" class="form-control" name="image" accept="image/*"   onchange="imageValidation()" required>   
                                </div>
                              </div>    
                          </div>
                          --->
                          <div class="row">
                              <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <input type="hidden" name="token" value="<?php echo $csrf->generateToken();?>">                                   
                                    <input id="form-button" type="submit" value="Update Account" name="update" class="form-control btn btn-success btn-block">
                                </div>
                                
                              </div>     
                          </div>
                  </form>
                </div>                        
      </div>
    </div>
  </div>
  <div class="row mb-3">
  <div class="col-md-6 m-auto text-center">
          <p id="login">Already heave an account?<a class="text-info " href="login.php">Login</a></p>
          </div>
  </div>
 
</div>
</section>
    
    <!---end-Create-Account-->
    <!--Footer-->
<footer id="main-footer" class="px-5 bg-success text-white">
      <div class="container">
        <div class="row first-row">
          <div class="col-md-3 mb-4">
            <h4 class="mb-4">Locations</h4>
            <p><i class="fas fa-map-marker-alt"></i> South B,</p>
            <p>Champions Boulevard</p>
            <p>Opposite Tomlands Fitness Centre</p>
          </div>
          <div class="col-md-3 col-sm-12 mb-4">
            <div class="row">
              <h4 class="mb-4">Menu</h4>
              <div class="col-md-6 col-sm-6">
                <p>
                  <i class="fa fa-home"></i
                  ><a href="index.php" class="text-white p-2">Home</a>
                </p>
                <p>
                 <i class="fas fa-user"></i>
                   <a href="create_account.php" class="text-white p-2">Sign Up</a>
                </p>
                <p>
                  <i class="fas fa-question-circle"></i
                  ><a href="info.php" class="text-white p-2">About</a>
                </p>
                <p>
                  <i class="fa fa-envelope"></i
                  ><a href="contact_us.php" class="text-white p-2">Contact</a>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <h4 class="mb-4">Contact Us</h4>
            <p>PHONE: 07345256228</p>
            <p>EMAIL: info@pepea.com</p>
            <p>SOCIAL MEDIA:</p>
            <i class="fab fa-facebook p-2"></i>
            <i class="fab fa-instagram p-2"></i>
            <i class="fab fa-youtube p-2"></i>
            <i class="fab fa-twitter p-2"></i>
          </div>
          <div class="col-md-3 mb-4 text-center">
            <h4 class="mb-4">Pepea</h4>
            <img
              class="rounded-circle"
              src="images/dove-image.jpg"
              width="150"
              alt=""
            />
          </div>
        </div>
        <div class="row second-row text-center">
          <div class="col-md-12 ml-auto">
            <p class="lead">
              Copyright &copy;
              <span id="year"></span>
            </p>
          </div>
        </div>
      </div>
    </footer>
<!--end-of-footer-->

 <!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!--Bootsratp CDNs-->
<script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"
      integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU"
      crossorigin="anonymous"
></script>
<script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js"
      integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj"
      crossorigin="anonymous"
></script>


<script src="js/bootstrapValidation.js"></script>

<script>
      //JQuery for setting the current year
      $("#year").text(new Date().getFullYear());
</script>

</body>
</html>