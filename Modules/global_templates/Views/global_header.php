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

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/solware_fav.png" type="image/png">

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
                    <!-- logo start -->
                    <div>
                            <a href="<?php echo "javascript:void(0);" ?>" class="logo">
                            <?php if(session('logo')) : ?>
                                <img src="data:image;base64,<?php echo htmlspecialchars(session('logo')); ?>" title="Company Logo" alt="Company Logo" width="55" height="50">
                                <a href="<?php echo "javascript:void(0);" ?>" class="logo">
                                    <h5 style="padding: 15px 10px;margin-left: -35px;color: white;"><?php echo session('company_name') ?></h5>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo "javascript:void(0);" ?>"  class="logo">
                                    <h5 style="padding: 15px 10px;margin-left: 0px;color: white;"><?php echo session('company_name') ?></h5>
                                </a>
                            <?php endif; ?>
                            </a>
                    </div>
                    <!-- End Logo-->
                       
                    <div class="menu-extras topbar-custom navbar p-0">
                        <ul class="mb-0 nav navbar-right ml-auto list-inline">

                            <?php if (session('alert_notification_add_view') == '1') { ?>
                                <li class="list-inline-item dropdown notification-list">
                                    <a href="#" data-target="#"
                                        class="dropdown-toggle waves-effect waves-light notification-icon-box"
                                        data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-bell"></i> <span id="reddot" style="visibility: hidden;"
                                            class="badge badge-xs badge-danger"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">Notification <span id="datacount"
                                                class="badge badge-xs badge-success"></span></li>
                                        <li class="list-group">
                                            <a href="javascript:void(0);" id="anchor1"
                                                class="dropdown-item notify-item mt-2">
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
                                            <a href="javascript:void(0);" id="anchor3"
                                                class="dropdown-item notify-item mb-2">
                                                <div class="notify-icon bg-danger"><i class="mdi mdi-bell"></i></div>
                                                <p id="div3" class="cusnotify notify-details"></p>
                                                <span id="sp3" class="customspan"></span>
                                            </a>

                                            <!-- last list item -->
                                            <a href="<?php echo $base_url . route_to('get_all_notification'); ?>"
                                                class="list-group-item text-center">
                                                <small class="text-primary mb-0">View all </small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>


                            <li class="dropdown">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light"
                                    data-toggle="dropdown" aria-expanded="true">
                                    <img src="<?php echo base_url(); ?>assets/images/users/user_avatar.png"
                                        alt="user-img" class="rounded-circle">
                                    <span class="profile-username">
                                        <?php echo session('Taguser_name'); ?> <span
                                            class="mdi mdi-chevron-down font-15"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="javascript:void(0)" class="dropdown-item"> Profile</a></li> -->
                                    <li class="dropdown-divider"></li>
                                    <li><a href="<?php echo $base_url . route_to('password_change'); ?>" class="dropdown-item">
                                            <i class="fas fa-unlock"></i> Change Password</a></li>
                                    <li><a href="<?php echo $base_url . route_to('logout'); ?>" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout</a></li>
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

                        <ul class="navigation-menu" style="display: flex;">

                            <!-- Dashboard Navbar Code Start -->
                            <li class="has-submenu">
                                <a href="<?php echo $base_url . route_to('dashboard'); ?>"><i class="ti-home"></i>
                                    Quick Access</a>
                            </li>
                            <!-- Dashboard Navbar Code End -->                            

                            <!-- admin menu start -->
                            <li class="has-submenu">
                                <a href="javascript:void(0)"><i class="ti-user"></i> Access Management <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                <ul class="submenu">
                                    <li>
                                    <a href="<?php echo $base_url . route_to('edit_company'); ?>">
                                    Company Details</a>
                                    </li>
                                    
                                    <?php if (session('roles_add_view') == '1' || session('roles_view_and_edit_view') == '1') { ?>
                                    <li class="has-submenu">
                                        <a href="javascript:void(0)">Roles </a>
                                        <ul class="submenu">
                                        <?php if (session('roles_add_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('company_role') ?>">Add</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (session('roles_view_and_edit_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('company_role_list') ?>">Edit And Delete</a></li>
                                                <?php } ?>
                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <?php if (session('user_add_view') == '1' || session('user_view_and_edit_view') == '1') { ?>
                                        <li class="has-submenu">
                                            <a href="javascript:void(0)">Users</a>
                                            <ul class="submenu">
                                            <?php if (session('user_add_view') == '1') { ?>
                                                        <li><a href="<?php echo $base_url . route_to('company_user_add') ?>">Add</a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if (session('user_view_and_edit_view') == '1') { ?>
                                                        <li><a href="<?php echo $base_url . route_to('company_user_list') ?>">View and Edit</a></li>
                                                    <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>

                                    <?php if (session('group_add_view') == '1' || session('group_view_and_edit_view') == '1') { ?>
                                        <li class="has-submenu">
                                        <a href="javascript:void(0)">Report & <br>Dashboard Groups</a>
                                        <ul class="submenu">
                                                <?php if (session('group_add_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('group') ?>">Add</a>
                                                    </li>
                                                <?php } ?>
                                                <?php if (session('group_view_and_edit_view') == '1') { ?>
                                                    <li><a href="<?php echo $base_url . route_to('group_list') ?>">Edit
                                                            And Delete</a></li>
                                                <?php } ?>
                                        </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                          <!-- admin menu end -->

                            <li class="has-submenu">
                                <!-- this menu need for design issue, dont remove -->
                            </li>

                            <!-- Module Title Navigation Code Start -->
                            <li class="has-submenu" style="margin-left: auto;margin-top: 17px;font-weight: bold;font-size: larger;display: inline-flex; align-items: center;">
                                <p>
                                    Logged into Administration                                    
                                </p>
                            </li>
                            <!-- Module Title Navigation Code End -->

                            <li class="has-submenu">
                                <a target="_blank" href="http://3.110.35.56/documentation/overview/"><i style="margin-right: 0;font-size: 22px;" class="mdi mdi-book-open-variant"></i>
                                    Help</a>
                            </li>
                            <!-- users Navbar Code End -->
                            <!-- <i style="margin-right: 0;font-size: 22px;" class="mdi mdi-book-open-variant"></i> -->
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