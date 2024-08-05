<?php
$data['page_title'] = 'Update Password';
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
                            <div id="custom_success_alert_controller_message">
                                <?php if (session()->getFlashdata('success')): ?>
                                    <div id="flash-message">
                                        <?php echo $customlibraries->global_alert_msg('controller_success', session()->getFlashdata('success')); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- group Add Code Start -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-t-0 m-b-30">
                                        <h3>Change Password</h3>
                                    </div>
                                    <form class="form-horizontal" id="update_pwd_form"
                                        action="<?php echo $base_url . route_to('update_pwd'); ?>" method="post"
                                        data-parsley-validate>

                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-1 control-label">Old Password<span>*</span></label>
                                            <div class="col-sm-3 position-relative">
                                                <input type="password" name="old_pass"
                                                    class="form-control form-control-custom" value="" id="old_pass"
                                                    placeholder="Enter Old password" required>
                                                <span class="toggle-password" data-target="#old_pass"><i
                                                        class="fas fa-eye"></i></span>
                                                        <div id="old_pass_error" class="error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-1 control-label">New Password<span>*</span></label>
                                            <div class="col-sm-3 position-relative">
                                                <input type="password" name="new_pass"
                                                    class="form-control form-control-custom" value="" id="new_pass"
                                                    placeholder="Enter New password" required>
                                                <span class="toggle-password" data-target="#new_pass"><i
                                                        class="fas fa-eye"></i></span>
                                                <div id="new_pass_error" class="error"></div> <!-- Error container -->
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-1 control-label">Confirm Password<span>*</span></label>
                                            <div class="col-sm-3 position-relative">
                                                <input type="password" name="conf_pass"
                                                    class="form-control form-control-custom" value="" id="conf_pass"
                                                    placeholder="Enter Confirm password" required>
                                                <span class="toggle-password" data-target="#conf_pass"><i
                                                        class="fas fa-eye"></i></span>
                                                <div id="conf_pass_error" class="error"></div> <!-- Error container -->
                                            </div>
                                        </div>


                                        <!-- -->
                                        <div class="text-center">
                                            <button type="button" id="save_pwd"
                                                class="btn btn-primary waves-effect waves-light">Save</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5"
                                                onclick="window.location='<?php echo $base_url . route_to('login'); ?>'">Cancel</button>
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
<script>
     document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('flash-message')) {
            var logoutUrl = "<?php echo $base_url . route_to('logout'); ?>";
            setTimeout(function() {
                window.location.href = logoutUrl;
            }, 2000);
        }
    });

    $(document).ready(function () {
        $('.toggle-password').on('click', function () {
            var input = $($(this).data('target'));
            var icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });

    $(document).on('blur', '#old_pass', function () {
        $('#old_pass_error').text("");
        var old_pass = $('#old_pass').val();
        if (old_pass != "") {
            $.ajax({
                url: base_url + 'login/check_old_password',
                method: 'GET',
                data: { old_pass: old_pass },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'error') {
                        $('#old_pass').parsley().removeError('old_pass_error', { namespace: 'parsley' });
                        $('#old_pass').parsley().addError('old_pass_error', {
                            message: response.message,
                            updateClass: true
                        });
                    } else {
                        $('#old_pass').parsley().removeError('old_pass_error', { namespace: 'parsley' });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching states:', error);
                }
            });
        }
    });
    function validatePassword(value) {
        const minLength = 8;
        const allowedSpecialChars = /[!@#$]/;
        const unsupportedSpecialChars = /[^A-Za-z0-9!@#$]/;

        const hasUpperCase = /[A-Z]/.test(value);
        const hasSpecialChar = allowedSpecialChars.test(value);
        const hasUnsupportedChar = unsupportedSpecialChars.test(value);

        if (value.length < minLength) {
            return 'Password must be at least 8 characters long.';
        }
        if (!hasUpperCase) {
            return 'Password must contain at least one uppercase letter.';
        }
        if (!hasSpecialChar) {
            return 'Password must contain at least one special character: !, @, #, $.';
        }
        if (hasUnsupportedChar) {
            return 'Password contains unsupported special characters. Only !, @, #, $ are allowed.';
        }
        return '';
    }

    function validateConfirmPassword(value, newPassword) {
        if (value !== newPassword) {
            return 'Passwords do not match.';
        }
        return '';
    }


    function validateDifferentPassword(newPassword, oldPassword) {
        if (newPassword === oldPassword) {
            return 'New password cannot be the same as the old password.';
        }
        return '';
    }

    $('#new_pass').on('input blur', function () {
        const newPassword = $(this).val();
        if(newPassword != ""){
        const oldPassword = $('#old_pass').val();
        const differentPasswordMessage = validateDifferentPassword(newPassword, oldPassword);
        const errorMessage = validatePassword(newPassword);

        $('#new_pass_error').text(errorMessage || differentPasswordMessage).toggle(!!(errorMessage || differentPasswordMessage));
    }});

    $('#conf_pass').on('blur', function () {
        const confirmPassword = $(this).val();
        if(confirmPassword != ""){
        const newPassword = $('#new_pass').val();
        const errorMessage = validateConfirmPassword(confirmPassword, newPassword);
        $('#conf_pass_error').text(errorMessage).toggle(!!errorMessage);
    }});

    $('#save_pwd').on('click', function () {
        var old_pass = $('#old_pass').val();
        if(old_pass == ""){
            $('#old_pass_error').text("Old Password required");
            return false;
        }
        const newPassword = $('#new_pass').val();
        const confirmPassword = $('#conf_pass').val();

        const passwordError = validatePassword(newPassword);
        const confirmError = validateConfirmPassword(confirmPassword, newPassword);

        if (passwordError || confirmError) {
            $('#new_pass_error').text(passwordError).toggle(!!passwordError);
            $('#conf_pass_error').text(confirmError).toggle(!!confirmError);
        } else {           
            $('#update_pwd_form').submit();
        }
    });


</script>
<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->