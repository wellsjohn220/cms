<?php
function confirm($result){
    global $connection;
    if(!$result){
        die("Query Failed." . mysqli_error($connection));
    }
}
function insert_categories(){
    global $connection;
    if (isset($_POST['submit'])) {
        // echo "<h1>Hello from John</h1>";
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "<div style='color:red'>This field should not be empty</div>";
        } else {
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUE('{$cat_title}') ";

            $create_category_query = mysqli_query($connection, $query);
            if (!$create_category_query) {
                die('Query Failed' . mysqli_errno(($connection)));
            }
        }
    }
}
function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

   while($row = mysqli_fetch_assoc($select_categories)){
       $cat_id = $row['cat_id'];
       $cat_title = $row['cat_title'];
       echo "<tr>";
       echo "<td>{$cat_id}</td>";             echo "<td>{$cat_title}</td>";   
       // echo "<td><a href='categories.php?delete={$cat_id}' >Delete</td>"; 
       ?>
       <td><a href="javascript: delete_user(<?php echo $row['cat_id']; ?>)"> Delete</a></td>
       <?php
       echo "<td><a href='categories.php?edit={$cat_id}' >Edit</td>"; 
       echo "</tr>";
   }
}
function deleteCategries(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}
function escape($string) {
    global $connection;    
    return mysqli_real_escape_string($connection, trim($string));    
}
function users_online(){   
    if(isset($_GET['onlineusers'])){
        global $connection; 
        if(!$connection){
            session_start();
            include("../includes/db.php");
            $session = session_id();
        $time = time();
        $time_out_in_seconds = 30;
        $time_out = $time - $time_out_in_seconds;
    
        $query = "SELECT * FROM users_online WHERE session = '$session' ";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);
    
        if($count == null) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
        } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);
        }  
        
    }    
}
users_online();
function recordCount($table){
    global $connection;    
    $query = "SELECT * FROM " . $table;
    $select_All_post = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_All_post);
    confirm($result);
    return $result;
}
function recordCountWhere($table, $column, $status){
    global $connection;   
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);
    $result = mysqli_num_rows($result);
    confirm($result);
    return $result;
}
function checkUserRole($table, $role){
    global $connection;  
    $query = "SELECT * FROM $table WHERE user_role = '$role' ";
    //echo $query;
    $select_all_userrole = mysqli_query($connection, $query);
    confirm($select_all_userrole);
    return mysqli_num_rows($select_all_userrole);
}
function username_exists($username){
    global $connection;
    $query = "SELECT username FROM userlist WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    //confirm($result);
    echo 'user: ' . mysqli_num_rows($result); 
    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
function email_exists($email){
    global $connection;
    $query = "SELECT user_email FROM userlist WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirm($result);
    //echo 'user: ' . mysqli_num_rows($result); 
    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
function is_admin($username) {
    global $connection; 
    $query = "SELECT user_role FROM userlist WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    $row = mysqli_fetch_array($result);

    if($row['user_role'] == 'admin'){
        return 'true';
    }else {
        return 'false';
    }
}
function redirect($location){
    header("Location:" . $location);
    exit;
}
function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}
function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}
function login_user($username, $password)
 {
     global $connection;
     $username = trim($username);
     $password = trim($password);
     $username = mysqli_real_escape_string($connection, $username);
     $password = mysqli_real_escape_string($connection, $password);

     $query = "SELECT * FROM userlist WHERE username = '{$username}' ";
     $select_user_query = mysqli_query($connection, $query);
     if (!$select_user_query) {
         die("QUERY FAILED" . mysqli_error($connection));
     }
     while ($row = mysqli_fetch_array($select_user_query)) {
         $db_user_id = $row['user_id'];
         $db_username = $row['username'];
         $db_user_password = $row['user_password'];
         $db_user_firstname = $row['user_firstname'];
         $db_user_lastname = $row['user_lastname'];
         $db_user_role = $row['user_role'];

         if (password_verify($password,$db_user_password)) {

             $_SESSION['username'] = $db_username;
             $_SESSION['firstname'] = $db_user_firstname;
             $_SESSION['lastname'] = $db_user_lastname;
             $_SESSION['user_role'] = $db_user_role;

             redirect("/cms/admin");
         } else {
             return false;
         }
     }
     return true;
 }
 function currentUser(){
     if(isset($_SESSION['username'])){
         return $_SESSION['username'];
     }
     return false;
 }
 function imagePlaceholder($image=''){
     if(!$image){
         return 'image_hold.jpg';
         
     } else {
         return $image;
     }
 }

