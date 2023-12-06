<?php
if($page_type=='company_user')
{     
?>
<!--- company_user Modules Custom Js File -->
<script src="<?php echo base_url(); ?>assets/md_js/company_user.js?v=1.1"></script>
<!--- company_user Modules Custom Js File -->
<?php 
} 
?>

<?php if($page_type == 'company_user_custom_css') { ?>
<!-- company_user Modules Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom_style.css?v=1.1">
<!-- company_user Modules Custom CSS -->
<?php } ?>

<!-- Multi Select css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/selects/select2.min.css">
<!-- Multi Select css -->

<!-- Multi Select Dropdown Js-->
<script src="<?php echo base_url(); ?>assets/plugins/selects/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/selects/form-select2.js"></script>
<!-- Multi Select Dropdown Js-->