<?php include "admin/functions.php"; ?>    
<?php error_reporting(0);  ?>
<?php session_start(); ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: blue;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <?php 
                    global $connection;  
                    $query = "SELECT * FROM categories LIMIT 3";
                    $select_all_categories_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_all_categories_query)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];        

                        $category_class = '';
                        $registration_class = '';
                        $login_class = '';
                        $pageName = basename($_SERVER['PHP_SELF']);
                        $registration = 'registration.php';
                        $login = 'login.php';

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                          $category_class ='active';
                        } else if ($pageName == $registration) {
                          $registration_class = 'active';
                        } else if ($pageName == $login) {
                          $login_class = 'active';
                        }

                        echo "<li class='$category_class'><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
                        //echo "<li><a href='#'>{$cat_title}</a></li>";
                    }
                  ?>
                  <?php if(isLoggedIn()):                 ?>                 
                  <li><a href="includes/logout.php">Logout</a></li>   
                  <li><a href="admin/index.php">Admin</a></li>   
                  <?php else: ?>
                  <li class='<?php echo $login_class; ?>'><a href="login.php">Login</a></li>   
                  <?php endif; ?>
                  <li class='<?php echo $registration_class; ?>'><a href="registration.php">Registration</a></li>
                  <?php 
                //   if(isset($_SESSION['user_role'])){
                //         if(isset($_GET['p_id'])){
                //             $the_post_id = $_GET['p_id'];
                //             echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                //         }            
                //   }
                  ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>