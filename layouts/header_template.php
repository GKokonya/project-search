<?php
$page_title="";
$page_description="";
$nav_link_status="";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $page_description=$session->getPageDescription();?>">
    <title><?php echo $page_title=$session->getPageTitle(); ?></title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Bootstrapcss link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
    <!--font awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"/>
    <!--Custom CSS link-->
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="d-flex flex-column">
    <div  id="page-content">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><?php echo SITE_NAME;?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <!--
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>-->
      </ul>
      
      blacklist-device
      <ul class="d-flex navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if($page_title=="blacklist-device"){echo $nav_link_status="active";}?>" href="create_blacklisted_device.php">Blacklist Device</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page_title=="contact"){echo $nav_link_status="active";}?>" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page_title=="login"){echo $nav_link_status="active";}?>" href="login.php">Login</a>
        </li>
        
         <?php if($page_title=="result"){?>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page_title=="resul;t"){echo $nav_link_status="active";}?>" href="login.php">result</a>
        </li>
        
        <?php }?>
      </ul>
    </div>
  </div>
</nav>