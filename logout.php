<?php
require_once('config/initialize.php');
$session = new Session();
$utility=new Utility();
$session->logout();
$utility->redirect_to("../login.php");
?>