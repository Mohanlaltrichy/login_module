<?php if($type == 'success') { ?>
<div class="alert btn-info alert-dismissible fade show">
<center><span id="success_msg_id"><b><?php echo $message; ?></b></span></center>
</div>
<?php } ?> 

<?php if($type == 'error') { ?>
<div class="alert alert-danger alert-dismissible fade show">
<center><span id="error_msg_id"><b><?php echo $message; ?></b></span></center>
</div>
<?php } ?> 

<?php if($type == 'controller_success') { ?>
<div class="alert btn-info alert-dismissible fade show">
<center><span id="controller_success_msg_id"><b><?php echo $message; ?></b></span></center>
</div>
<?php } ?> 

<?php if($type == 'controller_error') { ?>
<div class="alert alert-danger alert-dismissible fade show">
<center><span id="controller_error_msg_id"><b><?php echo $message; ?></b></span></center>
</div>
<?php } ?> 

<?php if($type == 'custom_model_alert') { ?>
    <div class="modal fade custom_model_alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                   <h4 class="modal-title m-0" id="mySmallModalLabel"><?php echo $message; ?></h4>
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <?php echo $message2 ?>
                </div>
                <input type="hidden" id="this_id" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-primary" id="save_changes">Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if($type == 'custom_model_ok_alert') { ?>
    <div class="modal fade custom_model_ok_alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                   <h4 class="modal-title m-0" id="mySmallModalLabel"><?php echo $message; ?></h4>
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <?php echo $message2 ?>
                </div>
                
                <div class="modal-footer">
                                     
                </div>
            </div>
        </div>
    </div>
<?php } ?>

