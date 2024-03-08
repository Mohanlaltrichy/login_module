<?php
$data['page_title'] = 'Groups';
echo view('\Modules\global_templates\Views\global_header', $data); // Header File Included
use App\Libraries\customlibraries;

$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\group\Controllers\group_controller', 'group_custom_css'); //group Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');
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

                                    <form class="form-horizontal" id="add_group_details" action="<?php echo $base_url . route_to('group_save'); ?>" method="post" data-parsley-validate>

                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <!-- group Name Config Place Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="group_name">Group
                                                name<span>*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="group_name" class="form-control form-control-custom" value="" id="group_name" placeholder="Enter group name" required>
                                                <div id='error-message'></div>
                                                <input type='hidden' id='group_name_duplicate' value='0'>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="description">Description</label>
                                            <div class="col-sm-5">
                                                <textarea name='description' class="form-control form-control-custom" rows="5" id="description" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <!-- group Name Config Place Code End -->

                                        <!-- Modules Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="modules">Modules<span>*</span>
                                            </label>
                                            <div class="col-sm-5">
                                                <input name='reports_dashboard' class="reports_dashboard_checkbox" value='reports_dashboard' data-parsley-errors-container="#reports_dashboard_req_errors" type="checkbox" required>
                                                <label for="reports_dashboard">
                                                    Report & Dasboard
                                                </label>
                                                <div id="reports_dashboard_req_errors"></div>
                                            </div>
                                        </div>
                                        <!-- Modules Code End -->

                                        <!-- Status Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="status">Status<span>*</span></label>
                                            <div class="col-sm-5">
                                                <select name="status" class="form-control form-control-custom mb-3" id="status" required>
                                                    <option value="" readonly>Select</option>
                                                    <option value="active" selected>Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                                <div id='status-error-message'></div>
                                            </div>
                                        </div>
                                        <!-- Status Code End -->

                                        <!-- -->
                                        <div class="text-center">
                                            <button type="button" id="save_group" class="btn btn-primary waves-effect waves-light">Save</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location='<?php echo $base_url . route_to('group'); ?>'">Cancel</button>
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


<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->