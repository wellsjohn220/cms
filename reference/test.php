<?php 
//echo password_hash('secret', PASSWORD_DEFAULT, array('cost' => 12));
//phpinfo();
include "../includes/db.php";
session_start();
include "../admin/functions.php";
echo 'Current login user role is: ' . $_SESSION['user_role'] . ' and is login: ' . isLoggedIn();
echo '<br />';
echo 'Current login user id: ' . loggedInUserId();
?>