<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>   

<?php 
//$token = '8b59fc8a9717fe6b4c4b499a75a02ea6751b662517b6a295f80e118b7efed3d00921ef1623f45ff6ad99d030f25a42e21b41';
if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM userlist WHERE token=? ')){
    mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
    //mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    //echo $username . ' ' . $token;
    // if($_GET['token'] !== $token || $_GET['email'] !== $email){
    //     redirect('index');        
    // }
    if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
        
        if($_POST['password'] === $_POST['confirmPassword']){
            //echo 'They are both the same.';
            $password = $_POST['password'];
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

            if($stmt = mysqli_prepare($connection, "UPDATE userlist SET token='', user_password='{$hashedPassword}' WHERE user_email = ?")){

                mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
                mysqli_stmt_execute($stmt);

                if(mysqli_stmt_affected_rows($stmt) >= 1){
                  redirect('/cms/login.php');
                }
                mysqli_stmt_close($stmt);
            }
        }else{
            echo 'Password is not match';
        }
    }
}
?>
<!-- Page Content -->
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-6x"></i></h3>
                                <h2 class="text-center">Reset Password</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                                <h2>Please check your email</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>
</div> <!-- /.container -->