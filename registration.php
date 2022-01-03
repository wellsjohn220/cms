<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php require 'vendor/autoload.php'; ?>
<?php  include "includes/navigation.php"; ?>    
<?php //include "admin/functions.php" ?>
<?php 
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
        echo "<script type='text/javascript'>location.reload();</script>";
    }
}

    if(isset($_SESSION['lang'])){
        include "includes/languages/" . $_SESSION['lang'] . ".php";
    } else {
        include "includes/languages/en.php";    }


 if(isset($_POST['submit'])){
    //echo 'It is working for submit';
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);      
    $password = trim($_POST['password']);

    $error = ['username' => '', 'email' => '', 'password' => ''];
    if ($uername ==''){
        $error['username'] = 'User name can not be empty.';
    }
    if ($email ==''){
        $error['email'] = 'Email can not be empty.';
    }
    if ($password ==''){
        $error['password'] = 'Password can not be empty.';
    }

    //echo 'user: ' . username_exists($username);
    $query = "SELECT username FROM userlist WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    //confirm($result);
    $usercount = mysqli_num_rows($result); 
    // if(email_exists($email)){
    //      $messasge = "email exists";
    // }
    $queryemail = "SELECT user_email FROM userlist WHERE user_email = '$email' ";
    $result2 = mysqli_query($connection, $queryemail);
    //confirm($result);
    $emailcount = mysqli_num_rows($result2); 

    if(!empty($username) && !empty($email) && !empty($password) && $usercount==0 && $emailcount==0){
        $username = mysqli_real_escape_string($connection, $username);
        $email    = mysqli_real_escape_string($connection, $email);   
        $password = mysqli_real_escape_string($connection, $password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
       
        $query = "INSERT INTO userlist (username, user_email, user_password, user_role) ";
        $query .= "VALUES('{$username}','{$email}','{$password}','subscriber' )";
        $register_user_query = mysqli_query($connection, $query);
        if(!$register_user_query) {
            die("Query Failed " . mysqli_error($connection));
        }
        $messasge = "Your Registration has been submitted";
        header("location: admin/index.php");
    } else {
        $messasge = "Fields can not be empty and name or email duplicated!";
    } 
}  else {
    $messasge = "";
}  
?>
  
 
    <!-- Page Content -->
    <div class="container">
    <form method="get" class="navbar-form navbar-right" action="" id="language_form"> 
        <div class="form-group">
            <select name="lang" class="form-control" onchange="changeLanguage()" >
                <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected";} ?>>English</option>
                <option value="cn" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'cn'){ echo "selected";} ?>>Chinese</option>   
            </select>
        </div>
    </form>
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $messasge ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" 
                            autocomplete="on" value="<?php echo isset($username) ? $username: '' ?>">
                            <p><?php echo isset($error['username']) ? $error['username']: '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder=<?php echo _EMAIL; ?> 
                            autocomplete="on" value="<?php echo isset($email) ? $email: '' ?>">
                            <p><?php echo isset($error['email']) ? $error['email']: '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error['password']) ? $error['password']: '' ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                    
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
        <hr>
<?php include "includes/footer.php";?>

<script>
    function changeLanguage(){
        console.log("Language page works");
        document.getElementById('language_form').submit();
    }
</script>
