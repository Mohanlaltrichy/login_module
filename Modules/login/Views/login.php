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
<style>
h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

h2 {
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.form-control {
    border-radius: 4px;
}
.btn-block {
    border-radius: 4px;
}
.list-unstyled{
    font-size: 17px;
    line-height: 40px;
}
</style>
<body>

    <!-- Begin page -->
    <!-- <div class="accountbg"></div> -->
    <div class="container-fluid vh-100">
        <div class="row h-100 align-items-center justify-content-center">
            <!-- Left content -->
            <div class="col-lg-6 d-flex flex-column justify-content-center p-5">
            <!-- <div class="text-left m-t-20 m-b-30">
                    <a href="<?php echo $base_url . route_to('login'); ?>" class="logo logo-admin"><img
                            src="<?php echo base_url(); ?>assets/images/Solware_IIoT.png" alt="" height="100"></a>
                </div> -->
                <h1>Welcome to Solware IIoT</h1>
                <h4>A robust, cloud based IIoT Data analytics for your Industrial Digital Transformation.</h4>
                <ul class="list-unstyled">
                    <li>✔ Build on no code approach.</li>
                    <li>✔ Template based reports, and dashboards.</li>
                    <li>✔ High performance cloud historian.</li>
                    <li>✔ AI prediction without data science background.</li>
                </ul>
            </div>
            <!-- Form section -->
            <div class="col-lg-5 d-flex flex-column justify-content-center p-5" style="box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1), 6px 6px 20px rgba(0, 0, 0, 0.1);">
                <div class="text-center m-t-20 m-b-30">
                    <a href="<?php echo $base_url . route_to('login'); ?>" class="logo logo-admin"><img
                            src="<?php echo base_url(); ?>assets/images/Solware_IIoT.png" alt="" height="100"></a>
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

                <form class="form-horizontal m-t-20" id="login_form"
                    action="<?php echo $base_url . route_to('user_validation'); ?>" method="post">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                    <?php if (session()->getFlashdata('msg')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" name="email" type="email" required="" id="email"
                                placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" name="password" type="password" required=""
                                placeholder="Password" id="password">
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="col-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" id="login"
                                type="submit">Log In</button>
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