<!doctype html>
<html lang="en">

    <head>
    <meta charset="utf-8" />
    <title>403 Access Denied</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-dark.svg" type="image/gif">

        <?php
        echo view('\Modules\global_templates\Views\global_css_files'); // Global CSS File Included
        $base_url = rtrim(base_url(), '/');
        ?>

    </head>

    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page card col-sm-12 row">
            <div class="card-body ex-page-content text-center">
            
                <h1 style='color:#6CBAFA;'>4<i style="font-size: smaller;" class="mdi mdi-block-helper"></i>3</h1>
                <h2 style='color:#413C3E;'>ACCESS DENIED</h2>
                <h4 style='color:#413C3E;'>Oops, You don't have permission to access this page.</h4><br>
             

                <?php
                if(!empty(session('Taglogged_in')))
                {
                    $back_url = 'dashboard';
                }
                else
                {
                    $back_url = 'login';
                }
                ?>

                <a class="btn btn-primary waves-effect waves-light" href="<?php echo $base_url.route_to($back_url)?>">BACK</a>
            </div>
        </div>



        <?php
            echo view('\Modules\global_templates\Views\global_js_files'); // Global JS File Included
        ?>
    </body>

</html>