<?php
echo view('\Modules\global_templates\Views\global_css_files'); // Global CSS File Included
use App\Libraries\customlibraries;
$customlibraries = new customlibraries();
$base_url = rtrim(base_url(), '/');
?>

<!-- ============================================================== -->
<!-- Content here -->
<!-- ============================================================== -->
<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-dark.svg" type="image/gif">
<body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="card card-pages">

                <div class="card-body">
                    <div class="text-center m-t-20 m-b-30">
                            <a href="<?php echo $base_url.route_to('login'); ?>" class="logo logo-admin"><img src="<?php echo base_url(); ?>assets/images/logo-dark.svg" alt="" height="80"></a>
                    </div>
                    <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

                    <form class="form-horizontal m-t-20" id="login_form" action="<?php echo $base_url.route_to('user_validation'); ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                        <?php if(session()->getFlashdata('msg')):?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                        <?php endif;?>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" name="email" type="email" required="" id="email" placeholder="Email">
                            </div>                            
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" name="password" type="password" required="" placeholder="Password" id="password">                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" id="login" type="submit">Log In</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>       

</body>
<!-- ============================================================== -->
<!-- End content here -->
<!-- ============================================================== -->

<?php
echo view('\Modules\global_templates\Views\global_js_files'); // Global JS File Included
?>

<!-- Custom Js File Include Code Start -->

<?php
echo $customlibraries->versioning('\Modules\Login\Controllers\Login_Controller','login'); // Login Modules Custom Js File Included
?>

<script>
    $.login_landing.login_sign_in();   
</script>   

<!-- Custom Js File Include Code End -->

<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->