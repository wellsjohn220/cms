<?php 
if(isset($_POST['submit'])){
    // echo $_POST['search'];
    $search = $_POST['search'];
    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
    $search_query = mysqli_query($connection, $query);
    if(!$search_query){
        die("Query Failed" . mysqli_errno($connection));
    }
    $count = mysqli_num_rows($search_query);
    if($count == 0){
        echo "<h3> No Result </h3>";
    } else {
        echo "some result";
    }
}   
?>