
<table class="table table-bordered table-hover table-striped table-condensed">
                        <thead><tr style="background-color: lightyellow;">
                            <th>Id</th> <th>Author</th> <th>Email</th><th>Post Title</th><th>Contents</th> <th>Status</th> 
                            <th>Date</th>  <th colspan="3">Action</th><th>Post Id</th> 
                        </tr></thead>
                        <tbody>
<?php
    include("delete_modal.php");
    global $connection;                        
    $query = "SELECT * FROM comments";
    $select_comments = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_comments)){
       $comment_id = $row['comment_id'];               $comment_post_id = $row['comment_post_id'];
       $comment_author = $row['comment_author'];       $comment_email = $row['comment_email'];
       $comment_content = $row['comment_content'];
       $comment_status = $row['comment_status'];  $comment_date = $row['comment_date'];
     
       echo "<tr>";
       echo "<td>{$comment_id}</td>";              echo "<td>{$comment_author}</td>";         echo "<td>{$comment_email}</td>";           
       
       $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
       $select_post_id_query = mysqli_query($connection, $query);
        
       while($row = mysqli_fetch_assoc($select_post_id_query)){
           $post_id = $row['post_id'];
           $post_title = $row['post_title'];
       } 
       echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>"; 
       echo "<td>{$comment_content}</td>"; 
       echo "<td>{$comment_status}</td>";    
             
       echo "<td>{$comment_date}</td>";  
       echo "<td><a href='comments.php?approved={$comment_id}'>Approved</a></td>";  
       echo "<td><a href='comments.php?unapproved={$comment_id}'>Unapproved</a></td>";        
    
       echo "<td><a rel='$comment_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";    
        //echo "<td><a onClick=\"javascript: return confirm('Are your sruet to delete this comment?');\" href='comments.php?delete={$comment_id}'> Delete</a></td>";
    
       echo "<td>{$comment_post_id}</td>";      
       echo "</tr>";
    }
    ?>
                    </tbody>
                    </table>
    <?php 
    if(isset($_GET['delete'])){
       $the_comment_id = escape($_GET['delete']);

       $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
       $delete_query = mysqli_query($connection, $query);
       header("Location: comments.php");
    }     
    if(isset($_GET['unapproved'])){
       $the_comment_id = escape($_GET['unapproved']);

       $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
       $unapprove_comment_query = mysqli_query($connection, $query);
       header("Location: comments.php");
    } 
    if(isset($_GET['approved'])){
        $the_comment_id = escape($_GET['approved']);
 
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
     }                  
    ?>
<script type="text/javascript">
    function delete_comment(uid)
    {
        if (confirm('Are You Sure to Delete this Comment?'))
        {
            window.location.href = 'comments.php?delete=' + uid;
        }
    }
    $(document).ready(function(){
       $(".delete_link").on('click', function(){
        //   alert("it works");
          var id = $(this).attr("rel"); //alert(id);
          var delete_url = "comments.php?delete=" + id + " "; //alert(delete_url);
          $(".model_delete_link").attr("href", delete_url);
          $("#myModal").modal('show');
       });
    });
</script>
   