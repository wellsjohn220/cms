<?php include "db.php"; ?>
<?php session_start(); ?>
<?php
if(isset($_POST['login'])){
   // echo 'Found';
   $username = $_POST['username'];
   $password = $_POST['password'];
   $username = mysqli_real_escape_string($connection, $username);
   $password = mysqli_real_escape_string($connection, $password);

   $query = "SELECT * FROM userlist WHERE username = '{$username}' ";
   $select_user_query = mysqli_query($connection, $query);
   if(!$select_user_query) {
      die("Query Failed" . mysqli_error($connection));
   //  } else {
   //    echo "Database links OK";
   }
   while($row = mysqli_fetch_array($select_user_query)){
      $db_user_id = $row['user_id'];
      $db_username = $row['username'];
      $db_user_firstname = $row['user_firstname'];
      $db_user_lastname = $row['user_lastname'];
      $db_user_role = $row['user_role'];
      $db_user_password = $row['user_password'];
   }
   //$password = crypt($password,  $db_user_password);
   //echo 'From input: ' . $username . '  ' . $password . '<br />' . 'From database: ' . $db_username . '  ' . $db_user_password;
   // if($username !== $db_username && $password !== $db_user_password ){
   //    header("Location: ../index.php ");
   // } else if($username == $db_username && $password == $db_user_password ){
   //    $_SESSION['username'] = $db_username;
   //    $_SESSION['firstname'] = $db_user_firstname;
   //    $_SESSION['lastname'] = $db_user_lastname;
   //    $_SESSION['user_role'] = $db_user_role;
   //    header("Location: ../admin/index.php");
   // } else {
   //    header("Location: ../index.php");
   // }
   //if($username === $db_username && $password === $db_user_password ){
   if(password_verify($password, $db_user_password)){
      
      $_SESSION['username'] = $db_username;
      $_SESSION['firstname'] = $db_user_firstname;
      $_SESSION['lastname'] = $db_user_lastname;
      $_SESSION['user_role'] = $db_user_role;
      $_SESSION['user_id'] = $db_user_id;  
      $_SESSION['loginstatus'] = 1;

      header("Location: ../admin/index.php");
   } else {
      header("Location: ../index.php");    
   }
}
?>