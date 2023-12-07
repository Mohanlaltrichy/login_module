<?php
$data['page_title'] = 'Users';
echo view('\Modules\global_templates\Views\global_header',$data); // Header File Included
use App\Libraries\customlibraries;
$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\company_user\Controllers\company_user_controller','company_user_custom_css'); //company_user Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/international-telephone-input.css" />

<style>
    #phone,#mobile{
display: block;
width: 100%;
font-size: 1rem;
line-height: 1.5;
color: #495057;
background-color: #fff;
background-clip: padding-box;
border: 1px solid #ced4da;
border-radius: 0.25rem;
transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
padding-right: 109px;
padding-left: 52px;
height: 35px;
    }
</style>

    
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
                                echo $customlibraries->global_alert_msg('controller_error',session()->getFlashdata('duplicate_record_found'));
                            }?>

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
                                echo $customlibraries->global_alert_msg('controller_success',session()->getFlashdata('success'));
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

                            <!-- mqtt Add Code Start -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="m-t-0 m-b-30">Create User</h4>

                                    <form class="form-horizontal" id="company_user_form" action="<?php echo $base_url.route_to('save_company_user'); ?>" method="post" data-parsley-validate>
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <div class="form-group row">
                                            <label class="col-sm-1 control-label" for="fullname">Full Name<span>*</span></label>
                                            <div class="col-sm-3">
                                            <input type="text" name="fullname" class="form-control form-control-custom" value="" id="fullname" required>
                                            <div id='error-message'></div>
                                            </div>

                                            <label class="col-sm-1 control-label" for="email">Email<span>*</span></label>
                                            <div class="col-sm-3">
                                            <input type="email" name="email" class="form-control form-control-custom" value="" id="email" required>
                                            </div>

                                            <label class="col-sm-1 control-label" for="phone">Phone</label>
                                            <div class="iti col-sm-3">
                                            <input type="tel" id="phone" value=" " name="phone">
                                            </div>
                                        </div>
                                            
                                        <div class="form-group row">
                                            <label class="col-sm-1 control-label" for="zone">Mobile</label>
                                            <div class="iti col-sm-3">
                                            <input type="tel" name="mobile" value=" " id="mobile">
                                            </div>
                                            <!-- oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  -->

                                            <label class="col-sm-1 control-label" for="zone">Password<span>*</span></label>
                                            <div class="col-sm-3">
                                            <input type="password" name="password"  class="form-control form-control-custom" value="" minlength="6" id="password" required>
                                            </div>

                                            <label class="col-sm-1 control-label" for="zone">Confirm Password<span>*</span></label>
                                            <div class="col-sm-3">
                                            <input type="password" name="conf_password" class="form-control form-control-custom" value="" id="conf_password" required>
                                            <span id="message"></span>
                                        </div>
                                        </div>
                                            
                                        <div class="form-group row">
                                            <label class="col-sm-1 control-label" for="designation">Designation</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="designation"  class="form-control form-control-custom" value="" id="designation">
                                            </div>

                                            <label class="col-sm-1 control-label" for="zone">Address</label>
                                            <div class="col-sm-3">
                                            <textarea name="address" class="form-control form-control-custom" id="address" value="" maxlength="100"></textarea>
                                        </div>
                                        </div>
                                            
                                        <div class="form-group row role d-flex justify-content-center">   
                                            <label class="col-sm-1 control-label" for="role">Role<span>*</span></label>
                                            <div class="col-sm-3"> 
                                                     <select name="role" class="form-control form-control-custom" id="role" required>
                                                    <option value="" readonly>Select</option>
                                                    <?php 
                                                    if(!empty($role)) {
                                                        foreach($role as $role_name)
                                                        {                                       
                                                    ?>
                                                        <option value="<?php echo $role_name['id']?>"><?php echo $role_name['role_name']?></option>                                       
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <label class="col-sm-1 control-label" for="status">Status<span>*</span></label>
                                            <div class="col-sm-3">
                                            <select name="status" class="form-control form-control-custom" id="status" required>
                                                    <option value="" readonly>Select</option>
                                                    <option value="active" selected>Active</option>
                                                    <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        </div>


                                        <div class="text-center">
                                        <input type='hidden' id='remove_content' value=''>
                                        <input type='hidden' id='phone_code' name="phone_code" value=''>
                                        <input type='hidden' id='mob_code' name="mobile_code"  value=''>
                                            <button type="button" id="save_user" class="btn btn-primary waves-effect waves-light" <?=(session('user_add_edit') != '1') ? 'disabled' : '';?>>Save</button>
                                            <button type="reset" id="reset" class="btn btn-danger" >Reset</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location='<?php echo $base_url.route_to('company_user_add'); ?>'">Cancel</button>
                                        </div> 

                                    </form>
                                </div> <!-- card-body -->
                            </div> <!-- card -->
                            <!-- mqtt Add Code End -->

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

<script src="<?php echo base_url(); ?>assets/js/international-telephone-input.js"></script>

<?php
echo $customlibraries->versioning('\Modules\company_user\Controllers\company_user_controller','company_user'); // Modules Custom Js File Included
?>

<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->



