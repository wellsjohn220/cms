<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
include "includes/db.php"; 
?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include "includes/functions.php"; ?>
<!-- <?php // require 'classes/Config.php' ?> -->

<?php 
    //   $mail = new PHPMailer();
    //   echo get_class($mail);

    if(!ifItIsMethod('get') && !isset($_GET['forgot'])){
        redirect('index');
    }
    if(!ifItIsMethod('get')){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));
            //echo strlen($token);
            if(email_exists($email)){
                //echo $email . ' is on the database!';
                if($stmt = mysqli_prepare($connection, "UPDATE userlist SET token='{$token}' WHERE user_email= ?")){

                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    $mail = new PHPMailer(true);
                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     //Enable verbose debug output
                        $mail->isSMTP();                                           //Send using SMTP
                        $mail->Host       = Config::SMTP_HOST;                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                  //Enable SMTP authentication
                        $mail->Username   = Config::SMTP_USER;                     //SMTP username
                        $mail->Password   = Config::SMTP_PASSWORD;                 //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = Config::SMTP_PORT;     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                     
                        $mail->setFrom('wellsjohn220@gmail.com', 'John');
                        $mail->addAddress('john.y@wic.edu.au', 'Wellsjohn');     //Add a recipient
                        $mail->addAddress('johnyee@warwick.edu.au');               //Name is optional
                        $mail->addReplyTo('john.y@wic.edu.au', 'Information');
                        $mail->addCC('cc@example.com');
                        $mail->addBCC('bcc@example.com');
                    
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->CharSet = 'UTF-8';
                        $mail->Subject = 'Happy New Year!';
                        $mail->Body    = 'This is the HTML message body <b>Using Auto Load JSON Test More...!</b>';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    
                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo 'somthing was wrong';
                }

            }
        }
    }
?>

<!-- Page Content -->
<div class="container">
<br /><br /><br />
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" autocomplete="on" class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->