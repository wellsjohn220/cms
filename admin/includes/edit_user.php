<?php
include "../functions.php";
if(isset($_GET['edit_user'])){
    $the_user_id=escape($_GET['edit_user']);

    //global $connection;
    $query = "SELECT * FROM userlist WHERE user_id = $the_user_id ";
    $select_users_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role']; 
    }
    
    if (isset($_POST['edit_user'])) {
        $username = $_POST['username'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];
        $user_password = $_POST['user_password'];

        if(!empty($user_password)) { 

            $query_password = "SELECT user_password FROM userlist WHERE user_id =  $the_user_id";
            $get_user_query = mysqli_query($connection, $query_password);
            confirm($get_user_query);
  
            $row = mysqli_fetch_array($get_user_query);
  
            $db_user_password = $row['user_password'];  
  
            if($db_user_password != $user_password) {  
              $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));  
            }
        
        $query = "UPDATE userlist SET ";
        $query .= "username = '{$username}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = {$the_user_id} ";
    
        $update_user_query = mysqli_query($connection, $query);

        confirm($update_user_query);
    // $the_post_id = mysqli_insert_id($connection);
        echo "<p class='bg-success'>User Updated." . " <a href='users.php'>View Users?</a></p>";
        } 
    } 
} else {
            header("Location: /admin/users.php");
    }   

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value ="<?php echo $username; ?>" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_firstname">User Firstname</label>
        <input type="text" value ="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Uese Lastname</label>
        <input type="text" value ="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_email">User Email</label>
        <input type="email" value ="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>
    <div class="form-group" style="float: right; margin-top: 16px;">
        <label for="user_role">User Role</label>
        <select name="user_role" id="">
            <option value="subscriber"><?php echo $user_role; ?></option>
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>           
        </select>
    </div> 
    <div class="form-group" style="width: 50%">
        <label for="user_password">User Password</label>
        <input type="password" value ="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div>   
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
    </div>
</form>