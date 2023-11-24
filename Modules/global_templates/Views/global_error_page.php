<!doctype html>
<html lang="en">

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
        $base_url = rtrim(base_url(), '/');
        ?>

    </head>

    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page card col-sm-12 row">
            <div class="card-body ex-page-content text-center">

                <?php if($error == "catch_error") { ?>
                    <h1 style='color:darkorange;'><i class="mdi mdi-cloud-alert"></i></h1>
                    <h2 style='color:darkorange;'>Ooops...</h2>
                    <h4 style='color:#413C3E;'>something went wrong</h4><br>                    
                <?php } else if($error == "404_error") {  ?>
                    <h1 style='color:darkorange;'>4<i class="mdi mdi-cloud-off-outline"></i>4</h1>
                    <h2 style='color:#413C3E;'>OPPS! PAGE NOT FOUND</h2>
                    <h4 style='color:#413C3E;'>Sorry, the page you're looking for doesn't exist. if yoy think something is broken, report a problem</h4><br>
                <?php }?>

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

                <a class="btn btn-primary waves-effect waves-light" href="<?php echo $base_url.route_to($back_url)?>">Back</a>
            </div>
        </div>



        <?php
            echo view('\Modules\global_templates\Views\global_js_files'); // Global JS File Included
        ?>
    </body>

</html>