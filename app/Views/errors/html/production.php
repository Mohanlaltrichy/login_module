<!doctype html>
<html lang="en">

    <head>
    <meta charset="utf-8" />
    <title>Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/solware_fav.png" type="image/png">

        <?php
        echo view('\Modules\global_templates\Views\global_css_files'); // Global CSS File Included
        $base_url = rtrim(base_url(), '/');
        ?>

    </head>

    <body>
        <!-- Begin page -->
        <div class="breatcumb-area d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breatcumb-content text-center">
                            <div class="breatcumb-title ex-page-content text-center">
              
                            <h1 style='color:#FD7E14;'><i class="mdi mdi-cloud-alert"></i></h1>
                            <h2 style='color:#FD7E14;'>Ooops...</h2>
                            <h4 style='color:#413C3E;'>something went wrong</h4><br>    

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

                             <a class="btn waves-effect waves-light" style='background-color:#FD7E14;color: white;' href="<?php echo $base_url.route_to($back_url)?>">BACK</a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <?php
            echo view('\Modules\global_templates\Views\global_js_files'); // Global JS File Included
        ?>
    </body>

</html>