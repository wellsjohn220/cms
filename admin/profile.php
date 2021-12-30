<?php include "includes/admin_header.php" ?>
<?php if(isset($_SESSION['username'])){
         $username = $_SESSION['username'];
         $user_id = $_SESSION['user_id'];
         $query = "SELECT * FROM userlist WHERE user_id = '{$user_id}' ";
         $select_user_profile_query = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($select_user_profile_query)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role']; 
         }
      }
?>
<?php
if (isset($_POST['edit_profile'])) {
    //$user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];
    $user_password = $_POST['user_password'];
    
    $query = "UPDATE userlist SET ";
    $query .= "username = '{$username}', ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_role = '{$user_role}' ";
    //$query .= "user_password = '{$user_password}' ";
    $query .= "WHERE user_id = {$_SESSION['user_id']} ";

$update_user_query = mysqli_query($connection, $query);

confirm($update_user_query);

// $the_post_id = mysqli_insert_id($connection);
//echo "<p class='bg-success'>User Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
header("Location: /admin/users.php");
}
?>
                       
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> User Profile <small><?php echo $_SESSION['username']; ?></small> </h1>
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
    <!-- <div class="form-group" style="width: 50%">
        <label for="user_password">User Password</label>
        <input type="password" value ="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div><br />     -->
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_profile" value="Update Profile">
    </div>
</form>
                   
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

        <?php include "includes/admin_footer.php" ?>