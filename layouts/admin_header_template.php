<?php
$page_title="";
$page_description="";
$nav_link_status="";
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo $page_description=$session->getPageDescription(); ?>">
     <title><?php echo $page_title=$session->getPageTitle(); ?></title>
    
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
        <!--Data Tables Link with Bootstrap 5--->
    <link
     rel="stylesheet"
     href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css"/> 
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
    <link rel="stylesheet" href="../css/style.css" />
   
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 text-white fs-4 fw-bold text-uppercase border-bottom"><?php echo SITE_NAME;?></div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="<?php if($page_title=="admin-home"){echo $nav_link_status="active";}?> list-group-item list-group-item-action bg-transparent second-text"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        
                <a href="mpesa_transactions.php" class="<?php if($page_title=="mpesa-transactions"){echo $nav_link_status="active";}?> list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-money-bill me-2"></i>Mpesa Transaction</a>
                        
                <a href="incomplete_search.php" class="<?php if($page_title=="incomplete-search"){echo $nav_link_status="active";}?> list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-search me-2"></i>Incomplete Search</a>
                        
                <a href="complete_search.php" class="<?php if($page_title=="complete-search"){echo $nav_link_status="active";}?> list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-search me-2"></i>Complete Search</a>
                        
                <a href="users.php" class="<?php if($page_title=="users"){echo $nav_link_status="active";}?> list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-users me-2" aria-hidden="true"></i>
                    Users</a>
                <a href="blacklisted_devices.php" class="<?php if($page_title=="blacklisted-devices"){echo $nav_link_status="active";}?> list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-mobile me-2" aria-hidden="true"></i>
                    Blacklisted Devices</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?php echo $session->full_name; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>