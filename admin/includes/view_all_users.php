<script type="text/javascript">
    function delete_user(uid) {
        if (confirm('Are You Sure to Delete the user?')) {
            window.location.href = 'users.php?delete=' + uid;
        }
    }
</script>
    <!-- <?php 
        echo 'Role: '.  $_SESSION['user_role'];
    ?> -->
<table class="table table-bordered table-hover table-striped table-condensed">
    <thead>
        <tr style="background-color: lightpink;">
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>           
            <th>Role</th>
            <th colspan="2">Action</th><th>Edit</th><th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        global $connection;
        $query = "SELECT * FROM userlist";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
          
            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";  echo "<td>{$user_lastname}</td>";

            // $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
            // $select_post_id_query = mysqli_query($connection, $query);

            // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
            //     $post_id = $row['post_id'];
            //     $post_title = $row['post_title'];
            // }
            // echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";

            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
            echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscribe</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
        ?>
            <td><a href="javascript: delete_user(<?php echo $user_id; ?>)"> Delete</a></td>
            <?php
            if (isset($_GET['delete'])) {

                if($_SESSION['user_role'] == 'admin'){
                    $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);

                    $query = "DELETE FROM userlist WHERE user_id = {$the_user_id} ";
                    $delete_query = mysqli_query($connection, $query);
                    header("Location: users.php");
                }             
            }
            ?>
        <?php
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php 
    if(isset($_GET['change_to_admin'])){
       $the_user_id = $_GET['change_to_admin'];

       $query = "UPDATE userlist SET user_role = 'admin' WHERE user_id = {$the_user_id} ";
       $change_to_admin_query = mysqli_query($connection, $query);
       header("Location: users.php");
    } 
    if(isset($_GET['change_to_sub'])){
        $the_user_id = $_GET['change_to_sub'];
 
        $query = "UPDATE userlist SET user_role = 'subscribe' WHERE user_id = {$the_user_id} ";
        $change_to_sub_query = mysqli_query($connection, $query);
        header("Location: users.php");
     }                  
    ?>