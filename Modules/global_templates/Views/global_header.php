<!doctype html>
<html lang="en">

<?php 
$base_url = rtrim(base_url(), '/');
?>

<head>
    <meta charset="utf-8" />
    <title>OPC Client Configuration</title>
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
                        <ul class="list-inline d-none d-lg-block mb-0">

                            <li class="hide-phone app-search float-left">
                                <form role="search" class="navbar-form">
                                    <input type="text" placeholder="Search..." class="form-control search-bar">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                        </ul>

                        <ul class="mb-0 nav navbar-right ml-auto list-inline">
                            <li class="list-inline-item dropdown notification-list">
                                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-lg">
                                    <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success">3</span></li>
                                    <li class="list-group">
                                        <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                                            <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                            <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                        </a>
                                        <!-- item-->

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-info"><i class="mdi mdi-glass-cocktail"></i></div>
                                            <p class="notify-details">Your item is shipped<span class="text-muted">It is a long established fact that a reader will</span></p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item mb-2">
                                            <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                            <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                                        </a>

                                        <!-- last list item -->
                                        <a href="javascript:void(0);" class="list-group-item text-center">
                                            <small class="text-primary mb-0">View all </small>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="list-inline-item notification-list d-none d-sm-inline-block">
                                <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="fas fa-expand"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                    <img src="<?php echo base_url(); ?>assets/images/users/avatar-1.jpg" alt="user-img" class="rounded-circle">
                                    <span class="profile-username">
                                        <?php echo session('Taguser_name'); ?> <span class="mdi mdi-chevron-down font-15"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" class="dropdown-item"> Profile</a></li>
                                    <li><a href="javascript:void(0)" class="dropdown-item"><span class="badge badge-success float-right">5</span> Settings </a></li>
                                    <li><a href="javascript:void(0)" class="dropdown-item"> Lock screen</a></li>
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
                <div class="container-fluid container-fluid-custom">

                    <div id="navigation">

                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li class="has-submenu">
                                <a href="<?php echo $base_url.route_to('dashboard'); ?>"><i class="ti-home"></i> Dashboard</a>
                            </li>
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