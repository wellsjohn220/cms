<?php include "includes/admin_header.php" ?>
    <script type="text/javascript">
    function delete_user(uid)
    {
        if (confirm('Are You Sure to Delete this Category?'))
        {
            window.location.href = 'categories.php?delete=' + uid;
        }
    }
    </script>
    <div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?> 

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>John Yee</small>
                        </h1>
                    <div class="col-xs-5">
                        <?php 
                            insert_categories();     
                        ?>
                         <form action="" method="post">
                             <div class="form-group">
                                 <label for="cat_title">Add Category</label>
                                 <input class="form-control" ype="text" name="cat_title">
                             </div>
                             <div class="form-group">
                                 <input class="btn btn-primary" type="submit" name="submit" value="Add New Category">
                             </div>
                         </form>
                      
            <?php 
                if(isset($_GET['edit'])){
                    $cat_id = $_GET['edit'];
                    include "includes/update_categories.php";
                }
            ?>
            </div>
            <div class="col-xs-7"> 
                        <table class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                 <tr>
                                     <th>Id</th>  <th>Category Title</th>    <th colspan="2">Action</th>
                                 </tr>
                            </thead>
                        <tbody>
                        <?php   //category view and delete category
                            findAllCategories();                      
                            deleteCategries();
                        ?>                        
                        </tbody>
                         </table>
                     </div> 
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

<?php include "includes/admin_footer.php" ?>   