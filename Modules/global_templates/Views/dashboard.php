<?php
$data['page_title'] = 'Quick Access';
echo view('\Modules\global_templates\Views\global_header',$data); // Header File Included
?>
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>assets/css/custom_style.css?v=1.1" rel="stylesheet" type="text/css"> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flaticon.css?v=1.1" type="text/css" media="all" />	

<!-- Custom CSS -->
 
<!-- ============================================================== -->
<!-- Content here -->
<!-- ============================================================== -->
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <!-- <h4 class="page-title m-0">Quick Access</h4> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>    

       
<!--==================================================-->
<!-- Start datatech technology Area -->
<!--==================================================-->
<div class="technology-area pt-70 pb-40">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 ">
				<div class="row">
					<?php if(session('ai_prediction_module_view') == '1') { ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="em-feature-box1 white" onclick="open_ai()" target="_blank"> 
							<div class="em-feature-box-inner">
								<div class="em-feature-icon">
                                 <i class="flaticon-call" style="padding: 10px 10px;font-size: 80px;margin-top:-23px"></i> 
                                     <h2 style="font-size: 23px;color:white;margin-top:-5px;">AI Predictions</h2>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if(session('alert_notification_module_view') == '1') { ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="em-feature-box" onclick="open_alert_and_notify()" target="_blank"> 
							<div class="em-feature-box-inner">
								<div class="em-feature-icon">
                                <img src="<?php echo base_url(); ?>assets/images/Alert1.png" style='padding: 10px 10px;' width='90px;' height='90px;' alt="user-img">
								</div>
								<div class="em-content-text">
									<div class="em-feature-title">
										<h2>Alert and Notifications</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if(session('cloud_connector_module_view') == '1') { ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="em-feature-box" onclick="open_cloudconnector()" target="_blank">
							<div class="em-feature-box-inner">
								<div class="em-feature-icon">
                                <img class="color-change-image" src="<?php echo base_url(); ?>assets/images/Cloud1.png" alt="user-img">
								</div>
								<div class="em-content-text">
									<div class="em-feature-title">
										<h2>Cloud Connectors</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>										
					<?php if(session('dashboard_module_view') == '1') { ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="em-feature-box" onclick="open_dashboard()" target="_blank">
							<div class="em-feature-box-inner">
								<div class="em-feature-icon">
                                <img src="<?php echo base_url(); ?>assets/images/Dashboards2.png" width='90px;' height='90px;' alt="user-img">
								</div>
								<div class="em-content-text">
									<div class="em-feature-title">
										<h2>Dashboards</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
					<?php if(session('reports_module_view') == '1') { ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="em-feature-box" onclick="open_reports()" target="_blank">
							<div class="em-feature-box-inner">
								<div class="em-feature-icon">
                                <img src="<?php echo base_url(); ?>assets/images/Reports1.png" height='75px;' style="margin-bottom: 5px;margin-top: 8px;" alt="user-img">
								</div>
								<div class="em-content-text">
									<div class="em-feature-title">
										<h2>Reports</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>	
					<?php if(session('subscription_module_view') == '1') { ?>
					<div class="col-lg-4 col-md-6 col-sm-12">
						<div class="em-feature-box" onclick="open_subscription()" target="_blank"> 
							<div class="em-feature-box-inner">
								<div class="em-feature-icon">
                                <img src="<?php echo base_url(); ?>assets/images/Subscription1.png" width='90px;' height='90px;' alt="user-img">
								</div>
								<div class="em-content-text">
									<div class="em-feature-title">
										<h2>Subscriptions</h2>
									</div>
								</div>
							</div>
						</div>
					</div> 
					<?php } ?>				
				</div>
			</div>
		</div>
	</div>
</div>
<!--==================================================-->
<!-- End datatech technology Area -->
<!--==================================================-->
  
                 
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
        //Open Cloud Connector Module
        function open_cloudconnector() {
            window.open('<?=OPEN_CLOUDCONNECTOR.$login_key;?>', '_blank');
        }

        //Open Subscription Module
        function open_subscription() {
            window.open('<?=OPEN_SUBSCRIPTION.$login_key;?>', '_blank');
        }

        //Open Alert And Notification
        function open_alert_and_notify() {
            window.open('<?=OPEN_ALERT_AND_NOTIFY.$login_key;?>', '_blank');
        }

        function open_dashboard() {
            window.open('<?=OPEN_DASHBOARD.$login_key;?>', '_blank');
        }

        function open_reports() {
            window.open('<?=OPEN_REPORTS.$login_key;?>', '_blank');
        }

        function open_ai() {
            window.open('<?=OPEN_AI.$login_key;?>', '_blank');
        }
    </script>


