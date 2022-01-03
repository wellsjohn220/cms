   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><i class='far fa-address-card' style='color:lime;'>&nbsp;</i>CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="">Users Online: <span class="usersonline"></span></a></li>
                <li><a href="../index.php">Site Home</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                     <?php 
                     if(isset($_SESSION['username'])){
                        echo $_SESSION['username']; 
                     }                    
                     ?>                     
                     <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="../registration.php"><i class="far fa-address-card" aria-hidden="true"></i> Ragistration</a>
                        </li>
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <div class="menu-item">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fas fa-id-card"></i>&nbsp; My Data</a>
                    </li>
                    <?php if(is_admin()):    ?>
                            <li>
                            <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                            </li>
                    <?php endif         ?>                   
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Post Manage <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="posts.php?source=view_post">View Posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post">Add Post</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categries</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-arrows-v"></i> User Manage <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user" class="collapse">
                            <li>
                                <a href="users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_user">Add User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-wrench"></i> Profile</a>
                    </li>
                </ul>
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        