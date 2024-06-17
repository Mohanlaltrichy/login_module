<!doctype html>
<html lang="en">

<?php
$base_url = rtrim(base_url(), '/');
if ($page_title != '') {
    $title = $page_title;
} else {
    $title = '';
}
?>

<head>
    <meta charset="utf-8" />
    <title><?= $title; ?></title>
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
                        <a href="<?php echo "javascript:void(0);" ?>" class="logo">
                            <img src="<?php echo base_url(); ?>assets/images/logo-light.svg" class="logo-lg" alt="" height="50">
                            <img src="<?php echo base_url(); ?>assets/images/logo-light.svg" class="logo-sm" alt="" height="28">
                        </a>
                    </div>
                    <!-- End Logo-->

                    <div class="menu-extras topbar-custom navbar p-0">
                        <ul class="mb-0 nav navbar-right ml-auto list-inline">

                            <?php if(session('alert_notification_add_view') == '1') { ?>
                            <li class="list-inline-item dropdown notification-list">
                                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-bell"></i> <span id="reddot" class="badge badge-xs badge-danger"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-lg">
                                    <li class="text-center notifi-title">Notification <span id="datacount" class="badge badge-xs badge-success"></span></li>
                                    <li class="list-group">
                                        <a href="javascript:void(0);" id="anchor1" class="dropdown-item notify-item mt-2">
                                            <div class="notify-icon bg-danger"><i class="mdi mdi-bell"></i></div>
                                            <p id="div1" class="cusnotify notify-details"></p>
                                            <span id="sp1" class="customspan"></span>
                                        </a>

                                        <a href="javascript:void(0);" id="anchor2" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-danger"><i class="mdi mdi-bell"></i></div>
                                            <p id="div2" class="cusnotify notify-details"></p>
                                            <span id="sp2" class="customspan"></span>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" id="anchor3" class="dropdown-item notify-item mb-2">
                                            <div class="notify-icon bg-danger"><i class="mdi mdi-bell"></i></div>
                                            <p id="div3" class="cusnotify notify-details"></p>
                                            <span id="sp3" class="customspan"></span>
                                        </a>

                                        <!-- last list item -->
                                        <a href="<?php echo $base_url.route_to('get_all_notification'); ?>" class="list-group-item text-center">
                                            <small class="text-primary mb-0">View all </small>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>

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
                                    <li><a href="<?php echo $base_url . route_to('logout'); ?>" class="dropdown-item">
                                            Logout</a></li>
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
                                <a href="<?php echo $base_url . route_to('dashboard'); ?>"><i class="ti-home"></i>
                                    Dashboard</a>
                            </li>
                            <!-- Dashboard Navbar Code End -->

                            <!-- users Navbar Code Start -->
                            <?php if (session('user_add_view') == '1' || session('user_view_and_edit_view') == '1') { ?>
                                <li class="has-submenu">
                                    <a href="javascript:void(0)"><i class="ti-user"></i> Users <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu megamenu">
                                        <li>
                                            <ul>
                                                <?php if (session('user_add_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('company_user_add') ?>">Add</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (session('user_view_and_edit_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('company_user_list') ?>">View
                                                            and
                                                            Edit</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- users Navbar Code End -->

                            <!-- Users Group Code Start -->
                            <li class="has-submenu">
                                <a href="javascript:void(0)"><i class="ti-notepad"></i> Groups <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo $base_url . route_to('group') ?>">Add</a>
                                            </li>
                                            <li><a href="<?php echo $base_url . route_to('group_list') ?>">Edit
                                                    And Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!--Users Group Code End -->

                            <!-- Role Navbar Code Start -->
                            <?php if (session('roles_add_view') == '1' || session('roles_view_and_edit_view') == '1') { ?>
                                <li class="has-submenu">
                                    <a href="javascript:void(0)"><i class="ti-shield"></i> Roles <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu megamenu">
                                        <li>
                                            <ul>
                                                <?php if (session('roles_add_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('company_role') ?>">Add</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (session('roles_view_and_edit_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('company_role_list') ?>">Edit
                                                            And
                                                            Delete</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
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

    