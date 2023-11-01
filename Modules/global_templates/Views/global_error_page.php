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
        <div class="wrapper-page">
            <div class="ex-page-content text-center">

                <?php if($error == "catch_error") { ?>
                    <h2 class="text-white">Sorry, something went wrong</h2><br>                    
                <?php } else if($error == "404_error") {  ?>
                    <h1 class="text-white">404!</h1>
                    <h2 class="text-white">Sorry, page not found</h2><br>
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