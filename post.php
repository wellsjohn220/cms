<?php include('includes/db.php')  ?>
<?php include('includes/header.php')  ?>

    <!-- Navigation -->
    <?php include('includes/navigation.php')  ?>
<?php 
    if(isset($_POST['liked'])){
        //echo '<h1> It Works! </h1>';
        //1=fetching the right post
        $post_id = $_POST['post_id'];
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $user_id =  $_SESSION['user_id'];
        //$likes = $post['likes'];
        // if(mysqli_num_rows($postResult)>=1){
        //     echo $post['post_id'];
        // }
        //2=update post with likes
        mysqli_query($connection, "UPDATE posts SET likes=likes+1 WHERE post_id=$post_id");
        //3=create likes for post
        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
        exit();
    }
    if(isset($_POST['unliked'])){      
        $post_id = $_POST['post_id'];
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $user_id =  $_SESSION['user_id'];      
      
        mysqli_query($connection, "UPDATE posts SET likes=likes-1 WHERE post_id=$post_id");
       
        mysqli_query($connection, "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id");
        exit();
    }

?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if(isset($_GET['p_id'])){
                    $the_post_id = $_GET['p_id'];

                    // $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id ";
                    // $send_query = mysqli_query($connection, $view_query);
                    // if(!$send_query){
                    //     die('Query Failed' . mysqli_error($connection));
                    // }
                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                } else {                        
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                }

                $select_all_posts_query = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                ?>                         
                <h1 class="page-header">       Post           <small>Secondary Text</small>                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p style="float: right;">
                    by <a href="index.php"><?php echo $post_author ?></a> <span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?>
                </p>                
                <hr>
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image) ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>  
                <div class="row">
                <?php 
                    if(isLoggedIn()){  ?>
                      <p class="pull-right">
                        <a href="#" class="unlike"><span class="glyphicon glyphicon-thumbs-down">&nbsp;Unlike</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" class="like"><span class="glyphicon glyphicon-thumbs-up"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="I liked it"
                        >&nbsp;Like</span></a>
                <?php     }            ?>                     
                    &nbsp;&nbsp;&nbsp;&nbsp;Like <?php getPostlikes($the_post_id); ?></a></p>
                </div>
                <?php }} else {
                    header("location: index.php");
                }
                
                ?>             
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
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group" style="width: 30%; float:right;">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group" style="width: 65%;">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                        <label for="Comment">Your Comment</label>
                            <textarea class="form-control" rows="5" name="comment_content" id="summernote"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>
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

        <?php }
        ?>         
        </div>  
         <!-- Blog Sidebar Widgets Column -->
         <?php include('./includes/sidebar.php')  ?>
        </div> </div>        
        <!-- /.row -->
        <hr>

<?php include('./includes/footer.php')  ?>
<script>
    $(document).ready(function(){
        $('.like').click(function(){
            console.log('it works!')
            var post_id = <?php echo $the_post_id; ?>
            //var user_id = 42;
            $.ajax({
                url: "post.php?post_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1, 'post_id': post_id//, 'user_id': user_id
                }
            });
        });
        $('.unlike').click(function(){
            console.log('unlike works!')
            var post_id = <?php echo $the_post_id; ?>
            //var user_id = 42;
            $.ajax({
                url: "post.php?post_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'unliked': 1, 'post_id': post_id//, 'user_id': user_id
                }
            });
        });
        $("[data-toggle='tooltip']").tooltip();
    });
</script>

 
