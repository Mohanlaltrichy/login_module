<!doctype html>
<html lang="en">

<?php 
$base_url = rtrim(base_url(), '/');
if($page_title != '')
{
    $title = $page_title;
}
else
{
    $title = '';
}
?>

<head>
    <meta charset="utf-8" />
    <title><?=$title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-dark.svg" type="image/gif">

    <?php
    echo view('\Modules\global_templates\Views\global_css_files'); // Global CSS File Included
    ?>

</head>

<body>

    <div class="header-bg">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid container-fluid-custom">

                    <!-- Logo-->
                    <div>
                        <a href="<?php echo "javascript:void(0);"?>" class="logo">
                            <img src="<?php echo base_url(); ?>assets/images/logo-light.svg" class="logo-lg" alt="" height="50">
                            <img src="<?php echo base_url(); ?>assets/images/logo-light.svg" class="logo-sm" alt="" height="28">
                        </a>
                    </div>
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">                      
                        <ul class="mb-0 nav navbar-right ml-auto list-inline">                           

                            <li class="list-inline-item notification-list d-none d-sm-inline-block">
                                <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="fas fa-expand"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                    <img src="<?php echo base_url(); ?>assets/images/users/user_avatar.png" alt="user-img" class="rounded-circle">
                                    <span class="profile-username">
                                        <?php echo session('Taguser_name'); ?> <span class="mdi mdi-chevron-down font-15"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" class="dropdown-item"> Profile</a></li>                                  
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?php echo $base_url.route_to('logout'); ?>" class="dropdown-item"> Logout</a></li>
                                </ul>
                            </li>

                            <li class="menu-item dropdown notification-list list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>

                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">

                    <div id="navigation">

                        <!-- Navigation Menu-->

                        <ul class="navigation-menu">

                            <!-- Dashboard Navbar Code Start -->
                            <li class="has-submenu">
                                <a href="<?php echo $base_url.route_to('dashboard'); ?>"><i class="ti-home"></i> Dashboard</a>
                            </li>
                            <!-- Dashboard Navbar Code End -->

                            <!-- Role Navbar Code Start -->      
                            <li class="has-submenu">
                                <a href="javascript:void(0)"><i class="ti-shield"></i> Roles <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo $base_url.route_to('company_role')?>">Add</a></li>
                                            <li><a href="<?php echo $base_url.route_to('company_role_list')?>">Edit And Delete</a></li>                                                                           
                                        </ul>
                                    </li>                                    
                                </ul>
                            </li>
                            <!-- Role Navbar Code End -->

                        </ul>          
                        
                        <!-- End navigation menu -->

                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->

    </div>
    <!-- header-bg -->