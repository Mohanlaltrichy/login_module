<?php
if ($page_type == 'group') {
?>
<!--- group Modules Custom Js File -->
<script src="<?php echo base_url(); ?>assets/md_js/group.js?v=1.6"></script>
<!--- group Modules Custom Js File -->
<?php
}
?>

<?php if ($page_type == 'group_custom_css') { ?>
<!-- group Modules Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom_style.css?v=1.2">
<!-- group Modules Custom CSS -->
<?php } ?>

<!-- Multi Select css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/selects/select2.min.css">
<!-- Multi Select css -->

<!-- Multi Select Dropdown Js-->
<script src="<?php echo base_url(); ?>assets/plugins/selects/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/selects/form-select2.js"></script>
<!-- Multi Select Dropdown Js-->