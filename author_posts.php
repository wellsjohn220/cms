<?php include('./includes/db.php')  ?>
<?php include('./includes/header.php')  ?>

    <!-- Navigation -->
    <?php include('./includes/navigation.php')  ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if(isset($_GET['p_id'])){
                    $the_post_id = $_GET['p_id']; 
                    $the_post_author = $_GET['author'];
                }
                $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' ";
                $select_all_posts_query = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                ?>                    
                <h1 class="page-header">       Page Heading                <small>Secondary Text</small>                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p style="float: right;">
                    by <?php echo $post_author ?> <span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?>
                </p>                
                <hr>
                <img class="img-responsive" src="./images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>               
                <!-- Pager -->               
                <!-- Blog Comments -->
                <?php 
                if(isset($_POST['create_comment'])){
                    //echo $_POST['comment_author'];
                    $the_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];

                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                        $query .= "VALUES( $the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())" ;
    
                        $create_comment_query = mysqli_query($connection, $query);
                        if(!$create_comment_query){
                            die('Query Failed' . mysqli_error($connection));
                        }
                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                        $query .= "WHERE post_id = $the_post_id ";
                        $update_comment_count = mysqli_query($connection, $query);
                    } else {
                        echo "<script>alert('Fields can not be empty!')</script>";                      
                    }          
                }                        
                ?>           
                <!-- Comments Form -->
                
                <!-- Posted Comments -->
        <?php 
        $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
        $query .= "AND comment_status = 'approved' ";
        $query .= "ORDER BY comment_id DESC ";
        $select_comment_query = mysqli_query($connection, $query);
        if(!$select_comment_query){
            die('Query Failed' . mysqli_error($connection));
        }
        while ($row = mysqli_fetch_array($select_comment_query)){
            $comment_date = $row['comment_date'];
            $comment_content = $row['comment_content'];
            $comment_author = $row['comment_author']; $comment_email = $row['comment_email'];
        ?>
        <!-- Comment -->
        <div class="media">
            <a class="pull-left" href="#">
                <!-- <img class="media-object" src="http://placehold.it/64x64" alt=""> -->
                <img class="media-object" src="images/SMOKE.GIF" style="width: 100px;" alt="">
            </a>
            <div class="media-body">
            <h4 class="media-heading"><?php echo $comment_author; ?>
                <small>on <?php echo $comment_date; ?> from <?php echo $comment_email; ?></small>
            </h4>
            <?php echo $comment_content; ?>
        </div> </div>  

        <?php }} 
        ?>         
        </div>  
         <!-- Blog Sidebar Widgets Column -->
         <?php include('./includes/sidebar.php')  ?>
        </div> </div>        
        <!-- /.row -->
        <hr>

<?php include('./includes/footer.php')  ?>

 
