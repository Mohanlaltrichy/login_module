<?php
echo view('\Modules\global_templates\Views\global_header'); // Header File Included
?>
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>assets/css/custom_style.css" rel="stylesheet" type="text/css"> 
<!-- Custom CSS -->

<!-- ============================================================== -->
<!-- Content here -->
<!-- ============================================================== -->
<div class="wrapper">
    <div class="container-fluid container-fluid-custom">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Dashboard</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>    

        <div class="row">
            <div class="col-sm-6 col-xl-2">
                <div class="card" style="border: 2px solid #61D7C7;">
                    <div onclick="open_cloudconnector()" target="_blank"> 
                        <div class="card-heading1 p-4">                                     
                            <center>               
                            <i class="fas fa-cloud mb-3" style="font-size: 30px;"></i>                    
                            <p>Cloud Connector</p>
                            </center>
                        </div>                     
                    </div>
                </div>
            </div>
        </div>    
                 
    </div>
</div>
<!-- end wrapper -->
<!-- ============================================================== -->
<!-- End content here -->
<!-- ============================================================== -->

<?php
echo view('\Modules\global_templates\Views\global_footer'); // Footer File Included
?>


<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->

<script>
        function open_cloudconnector() {
            window.open('http://localhost:9000/login/user_login_key_validation/<?=$login_key;?>', '_blank');
        }
    </script>


