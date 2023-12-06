<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ccheck</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/international-telephone-input.css" />
    <style>
        body {
            position: absolute;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }

        ul {
            top: 100% !important;
            transform: translateY(0%) !important;
        }

        .iti {
            position: relative;
            display: inline-block;
        }

        input[type=tel] {
            padding-right: 6px;
            padding-left: 52px;
            margin-left: 0;

            position: relative;
            z-index: 0;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            margin-right: 0;
            border: 1px solid #CCC;
            width: 270px;
            height: 35px;
            /* padding: 6px 12px; */
            border-radius: 2px;
            font-family: inherit;
            font-size: 100%;
            color: inherit;
        }

        button {
            color: #FFF;
            background-color: #428BCA;
            border: 1px solid #357EBD;
            height: 39px;
            margin: 0;
            padding: 6px 20px;
            border-radius: 2px;
            font-family: inherit;
            font-size: 100%;
        }

        button:hover {
            background-color: #3276B1;
            border-color: #285E8E;
            cursor: pointer;
        }
    </style>

<!-- Use as a jQuery plugin -->

 </head>

<body>
    
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


                            <!-- mqtt Add Code Start -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="m-t-0 m-b-30">Create User</h4>

                                    <form class="form-horizontal" id="company_user_form" method="post" data-parsley-validate>
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
                                            <div class="iti">
                                            <input type="tel" name="phone">
                                            </div>
                                        </div>
                                            
                                        <div class="form-group row">
                                            <label class="col-sm-1 control-label" for="zone">Mobile</label>
                                            <div class="col-sm-3">
                                            <input type="text" name="mobile" value="" id="mobile">
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
                                            <button type="button" id="save_user" class="btn btn-primary waves-effect waves-light">Save</button>
                                            <button type="reset" id="reset" class="btn btn-danger" >Reset</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
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

 </body>
</html>


