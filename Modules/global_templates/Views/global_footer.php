 <!-- Footer -->
 <footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                © <?=date('Y');?> Unfold Technologies
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<script>
    base_url = "<?php echo base_url(); ?>";
    csrf_token = "<?php echo csrf_token(); ?>"; 
    csrf_hash = "<?php echo csrf_hash(); ?>";  
</script>    

<?php
    echo view('\Modules\global_templates\Views\global_js_files'); // Global JS File Included
?>

