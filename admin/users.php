<?php include "includes/admin_header.php" ?>

<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> Welcome to User Admin <small>John Yee <?php echo is_admin('wellsjohn'); ?></small> </h1>
                    <div class="col-xs-12">
                        <?php
                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        }
                        switch ($source) {
                            case 'add_user';
                                include "includes/add_user.php";
                                break;
                            case 'edit_user';
                                include "includes/edit_user.php";
                                break;
                            case '88';
                                echo "Nice 88";
                                break;
                            default:
                                include "includes/view_all_users.php";
                                break;
                        }

                        ?>
                    </div>
                    <!-- <div class="col-xs-0">                   </div> -->
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

        <?php include "includes/admin_footer.php" ?>