<?php include "includes/admin_header.php" ?>

<div id="wrapper">    
    <!-- <?php if($connection) echo "conn"; ?> -->
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?> 
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small> 
    <?php echo 'Login by: ' . $_SESSION['username'] . ' and role is: ' . $_SESSION['user_role']; ?>
    <?php echo checkUserRole('userlist', 'admin'); ?>
                        </h1>                 
                      
                    </div>
                </div>
                <!-- /.row -->
    <div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php 
                        // $query = "SELECT * FROM posts WHERE post_status = 'published'";
                        // $select_all_post = mysqli_query($connection, $query);
                        // $post_count = mysqli_num_rows($select_all_post);
                        $post_count = recordCountWhere('posts','post_status','published');
                    ?>
                    <div class='huge'><?php echo $post_count; ?></div>
                        <div>Active Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Post Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php 
                        // $query = "SELECT * FROM comments WHERE comment_status = 'approved'";
                        // $select_all_comments = mysqli_query($connection, $query);
                        // $comment_count = mysqli_num_rows($select_all_comments);
                        $comment_count = recordCountWhere('comments', 'comment_status', 'approved');
                    ?>
                     <div class='huge'><?php echo $comment_count; ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Comment Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php 
                        // $query = "SELECT * FROM userlist";
                        // $select_all_user = mysqli_query($connection, $query);
                        // $user_count = mysqli_num_rows($select_all_user);
                        $user_count = recordCount('userlist')
                    ?>
                    <div class='huge'><?php echo $user_count; ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View User Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div> -->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php 
                        // $query = "SELECT * FROM categories";
                        // $select_all_cat = mysqli_query($connection, $query);
                        // $cat_count = mysqli_num_rows($select_all_cat);
                        $cat_count = recordCount('categories')
                    ?>
                        <div class='huge'> <?php echo $cat_count; ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Category Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    </div>
    <div class="row">
    <?php     
        $query = "SELECT * FROM posts";
        // WHERE post_author =" . currentUser() . "";
        $select_all_draft_post = mysqli_query($connection, $query);
        $post_draft_count = mysqli_num_rows($select_all_draft_post);
        //$post_draft_count = get_user_posts();
        //$post_draft_count = recordCountWhere('posts','post_status','draft');;
        $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
        $select_unapproved_comment = mysqli_query($connection, $query);
        $comment_unapproved_count = mysqli_num_rows($select_unapproved_comment);
        //$comment_unapproved_count = recordCountWhere('comments', 'comment_status', 'unapproved');
    ?>    
    <script type="text/javascript">
        google.load("visualization", "1.1", {packages:["bar"]});
        google.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Count'],
                <?php 
                $element_text = ['Active Posts', 'Draft Post', 'Comments', 'Pending Comments', 'Users', 'Categories'];
                $element_count = [$post_count, $post_draft_count, $comment_count, $comment_unapproved_count, $user_count, $cat_count];
                for($i = 0; $i < 6; $i++){
                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                }
                ?>                        
            ]);
            var options = {
                chart: {
                    title:'',
                    subtitle:''
                }
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, options);
        }
    </script>
        <div id="columnchart_material" style="width:auto; height: 500px;"></div>
    </div>
    </div>
    <!-- /.container-fluid -->     
    </div>
<?php include "includes/admin_footer.php" ?>   
