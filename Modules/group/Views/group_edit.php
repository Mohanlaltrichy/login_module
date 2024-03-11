<?php
$data['page_title'] = 'Groups';
echo view('\Modules\global_templates\Views\global_header', $data); // Header File Included
use App\Libraries\customlibraries;

$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\group\Controllers\group_controller', 'group_custom_css'); //group Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');

use Modules\group\Models\group_model;

$this->group_model = new group_model();
?>

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
                        <div class="col-md-12">

                            <!-- Duplicate record not allowed Alert -->
                            <div id="custom_error_alert_controller_message">
                                <?php if (session()->getFlashdata('duplicate_record_found')) {
                                    echo $customlibraries->global_alert_msg('controller_error', session()->getFlashdata('duplicate_record_found'));
                                } ?>

                                <?php if (session()->getFlashdata('msg')) : ?>
                                    <div class="alert alert-danger">
                                        <center>
                                            <?php if (is_array(session()->getFlashdata('msg'))) : ?>
                                                <?php foreach (session()->getFlashdata('msg') as $item) : ?>
                                                    <?= $item . '<br/>' ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <?= session()->getFlashdata('msg') ?>
                                            <?php endif; ?>
                                        </center>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <!-- Duplicate record not allowed Alert -->

                            <!-- Data After Successfully Insert Alert -->
                            <div id="custom_success_alert_controller_message">
                                <?php if (session()->getFlashdata('success')) {
                                    echo $customlibraries->global_alert_msg('controller_success', session()->getFlashdata('success'));
                                } ?>
                            </div>
                            <!-- Data After Successfully Insert Alert -->

                            <!-- Custom Error Alert Message -->
                            <div id="custom_error_alert_message" class="d-none">
                                <?php
                                echo $customlibraries->global_alert_msg('error');
                                ?>
                            </div>
                            <!-- Custom Error Alert Message -->

                            <!-- group Add Code Start -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-t-0 m-b-30">
                                        <h3>Groups
                                        </h3>
                                    </div>

                                    <form class="form-horizontal" id="update_group_details" action="<?php echo $base_url . route_to('group_update'); ?>" method="post" data-parsley-validate>

                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <input type="hidden" name="group_id" value="<?= $group_details[0]['id']; ?>">

                                        <!-- group Name Config Place Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="group_name">Group
                                                Name<span>*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="grp_name" class="form-control form-control-custom" value='<?= $group_details[0]['grp_name']; ?>' placeholder="Enter group name" readonly required>
                                                <input type='hidden' id='grp_name_duplicate' value='0'>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="group_name">Description</label>
                                            <div class="col-sm-5">
                                                <textarea name='description' class="form-control form-control-custom" rows="5" id="description" value='<?= $group_details[0]['grp_desc']; ?>' placeholder="Description"><?= $group_details[0]['grp_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <!-- group Name Config Place Code End -->

                                        <!-- Modules Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="modules">Modules<span>*</span>
                                            </label>
                                            <div class="col-sm-5">
                                                <?php foreach ($modules as $m) { ?>
                                                    <input name='modules[]' class="modules_checkbox" value='<?= $m['modules_option_name'] ?>' <?= ($group_details[0][$m['modules_option_name']] == '1') ? 'checked' : ''; ?> data-parsley-errors-container="#modules_req_errors" type="checkbox" required>
                                                    <label for="modules">
                                                        <?= $m['modules'] ?> &nbsp;
                                                    </label>
                                                <?php } ?>
                                                <div id="modules_req_errors"></div>
                                            </div>
                                        </div>
                                        <!-- Modules Code End -->


                                        <!-- Status Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="group_name">Status<span>*</span></label>
                                            <div class="col-sm-5">
                                                <select name="status" class="form-control form-control-custom mb-3" id="status" required>
                                                    <option value="" readonly>Select</option>
                                                    <option value="active" <?= ($group_details[0]['active_status'] == 'active') ? 'selected' : ''; ?>>
                                                        Active</option>
                                                    <option value="inactive" <?= ($group_details[0]['active_status'] == 'inactive') ? 'selected' : ''; ?>>
                                                        Inactive</option>
                                                </select>
                                                <div id='status-error-message'></div>
                                            </div>
                                        </div>
                                        <!-- Status Code End -->

                                        <!-- -->
                                        <div class="text-center">
                                            <button type="button" id="update_group" class="btn btn-primary waves-effect waves-light">Update</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location='<?php echo $base_url . route_to('group_list'); ?>'">Cancel</button>
                                        </div>
                                        <!-- -->

                                    </form>

                                </div> <!-- card-body -->
                            </div> <!-- card -->
                            <!-- group Add Code End -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container-fluid -->
    </div>
</div>
<!-- end wrapper -->
<!-- ============================================================== -->
<!-- End content here -->
<!-- ============================================================== -->

<?php
echo view('\Modules\global_templates\Views\global_footer'); // Footer File Included
?>

<!-- Custom Js File Include Code Start -->

<?php
echo $customlibraries->versioning('\Modules\group\Controllers\group_controller', 'group'); // group Modules Custom Js File Included
?>
<!-- Custom Js File Include Code End -->

<!--update_model_alert-->
<?php
echo $customlibraries->global_alert_msg('custom_update_model_alert', 'group', 'Are you sure update the group?');
?>
<!--update_model_alert-->


<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->