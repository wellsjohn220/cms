<?php
include "../functions.php";
if (isset($_POST['create_user'])) {
    $username              = $_POST['username'];
    $user_firstname        = $_POST['user_firstname'];
    $user_lastname         = $_POST['user_lastname'];
    $user_email            = $_POST['user_email'];
    $user_role             = $_POST['user_role'];
    $user_password         = $_POST['user_password'];

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));    
    // $post_image        = $_FILES['image']['name'];
    // $post_image_temp   = $_FILES['image']['tmp_name'];
    //$post_date         = date('Y-m-d');  
    //move_uploaded_file($post_image_temp, "../images/$post_image");
    $query = "INSERT INTO userlist(username, user_firstname, user_lastname, user_role, user_password, user_email) ";
    $query .= "VALUES('{$username}','{$user_firstname}','{$user_lastname}','{$user_role}','{$user_password}','{$user_email}') ";

    $create_user_query = mysqli_query($connection, $query);

    confirm($create_user_query);
    // $the_post_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>User Created. <a href='users.php'>View All users </a> or <a href='posts.php'>Edit More Posts</a></p>";
    //header("Location: /admin/users.php");
}

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_firstname">User Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Uese Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_email">User Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group" style="width: 50%">
        <label for="user_password">User Password</label>
        <input type="password" class="form-control" name="user_password">
    </div><br />
    <div class="form-group">
        <label for="user_role">User Role</label>
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>           
        </select>
    </div> 
    <hr />  

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>


</form>