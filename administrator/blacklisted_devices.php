<?php
require_once('../config/initialize.php');
$blacklistedDevicesObj=new BlacklistedDevices();
$session=new Session();
$session->setPageTitle("blacklisted-devices");
$session->setPageDescription("This page displays all blacklised devices in the database");
//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);
require_once('../layouts/admin_header_template.php');
?>
<section class="incompelte-section"> 
    <div class="container-fluid px-4">
        <div class="row my-5">
            <div class="col">
                <div class="card">
                    <h3 id="create-users-header" class="text-center">Blacklisted Devices</h3>
                </div>
                <div class="card">
                    <div class="table-responsive">  
                        <table id="blacklisted_devices_table" class="table table-bordered table-hover w-100">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Device</th> </th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">#Serial</th>
                                    <th scope="col">#IMEI</th>
                                    <th scope="col">#OB</th>
                                    <th scope="col">Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $blacklistedDevices=$blacklistedDevicesObj->getAll();
                                    foreach($blacklistedDevices as $row){
                                    echo '<tr>
                                    <td scope="col">'.$row['id'].'</td>
                                    <td scope="col">'.$row['name'].'</td>
                                    <td scope="col">'.$row['brand'].'</td>
                                    <td scope="col">'.$row['serial_number'].'</td>
                                    <td scope="col">'.$row['imei_number'].'</td>
                                    <td scope="col">'.$row['ob_number'].'</td>
                                    <td scope="col">'.$row['area'].'</td>
                                    </tr>
                                    ';
                                    }?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
<?php
require_once('../layouts/admin_footer_template.php');
?>
<script>
$(document).ready(function() {
    $('#blacklisted_devices_table').DataTable({
         "order": [[ 0, "desc" ]]
    });
});
</script>