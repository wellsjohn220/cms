<?php
    //global $connection;   
    if(isset($_GET['p_id'])){
      $the_post_id =  $_GET['p_id'];
    }                   
    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_posts_by_id)){
       $post_id = $row['post_id'];             $post_author = $row['post_author']; $post_user = $row['post_user'];
       $post_title = $row['post_title'];       $post_category_id = $row['post_category_id'];
       $post_status = $row['post_status'];     $post_content = $row['post_content'];
       $post_image = $row['post_image'];  $post_date = $row['post_date'];
       $post_tags = $row['post_tags'];  $post_comment_count = $row['post_comment_count'];
    }
    //echo $post_category_id;
if(isset($_POST['update_post'])) {
  //echo 'Hi from John ' . $row['post_date'];
  $post_author         =  escape($_POST['post_author']);
  $post_user           =  escape($_POST['post_user']);
  $post_title          =  escape($_POST['post_title']);
  $post_category_id    =  escape($_POST['post_category']);
  $post_status         =  escape($_POST['post_status']);
  $post_image          =  escape($_FILES['image']['name']);
  $post_image_temp     =  escape($_FILES['image']['tmp_name']);
  $post_content        =  escape($_POST['post_content']);           $post_comment_count = $row['post_comment_count'];
  $post_tags           =  escape($_POST['post_tags']);              $post_date = $row['post_date'];
  move_uploaded_file($post_image_temp, "../images/$post_image"); 

  if(empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($connection,$query);
        
        while($row = mysqli_fetch_array($select_image)) {
          $post_image = $row['post_image'];   } 
  }

  $query = "UPDATE posts SET ";
          $query .="post_title  = '{$post_title}', ";
          $query .="post_author  = '{$post_author}', ";
          $query .="post_category_id = '{$post_category_id}', ";
          //$query .="post_date   =  '{$post_date}', ";
          $query .="post_user = '{$post_user}', ";
          $query .="post_status = '{$post_status}', ";
          $query .="post_tags   = '{$post_tags}', ";
          $query .="post_content= '{$post_content}', ";
          $query .="post_image  = '{$post_image}' ";
          $query .= "WHERE post_id = {$the_post_id} ";
        
        $update_post = mysqli_query($connection,$query);
        confirm($update_post);
        
        echo "<p class='bg-success'>Post Updated. <a href='../admin/posts.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
        
}
?>

<form action="" method="post" enctype="multipart/form-data">       
     
     <div class="form-group" style="width: 40%; float:right;">
        <label for="author">Edit Post Author</label>
         <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="post_author">
     </div>
     
     <div class="form-group" style="width: 50%;">
        <label for="title">Edit Post Title</label>
         <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="post_title">
     </div>
    <hr />
    <div class="form-group" style="width: 25%; float:right;">
      <label for="category">Edit Category</label>
      <select name="post_category" id="">
      <?php         
          $query = "SELECT * FROM categories";
          $select_categories = mysqli_query($connection,$query);

          confirm($select_categories);

          while($row = mysqli_fetch_assoc($select_categories )) {
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];

          if($cat_id == $post_category_id) {      
            echo "<option selected value='{$cat_id}'>{$cat_title}</option>";      
            } else {    
              echo "<option value='{$cat_id}'>{$cat_title}</option>";      
            }
          }
     ?>
     </select>
      
    </div>

    <div class="form-group" style="width: 25%; float:right;">
       <label for="users">Edit Users</label>
       <select name="post_user" id="">
       <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
       <?php
          $users_query = "SELECT * FROM userlist";
          $select_users = mysqli_query($connection,$users_query);

          confirm($select_users);
          while($row = mysqli_fetch_assoc($select_users)) {
          $user_id = $row['user_id'];
          $username = $row['username'];    
    
          echo "<option value='{$username}'>{$username}</option>";             
          }
       ?>
       </select>      
    </div>
          
    <div class="form-group" style="width: 25%; float:right;">
         <select name="post_status" id="">
         <option value='<?php echo $post_status ?>'><?php echo $post_status; ?></option>
         <?php          
          if($post_status == 'published' ) {             
            echo "<option value='draft'>Draft</option>";          
          } else {          
            echo "<option value='published'>Publish</option>";
          }              
         ?>          
         </select>
      </div>
    <div class="form-group">
         <label for="post_image">Post Image</label>
         <img width="100" height="25px;" src="../images/<?php echo $post_image; ?>" alt="">
         <br /><br /><input type="file"  name="image">
      </div>

    <div class="form-group">
         <label for="post_tags">Edit Post Tags</label>
          <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags">
      </div>
      
    <div class="form-group">
         <label for="post_content">Post Content</label>
         <textarea class="form-control "name="post_content" id="summernote" cols="30" rows="8"><?php echo $post_content; ?></textarea>
    </div>    

    <div class="form-group">
          <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>