<?php
$data['page_title'] = 'Company Edit';
echo view('\Modules\global_templates\Views\global_header', $data); // Header File Included
use App\Libraries\customlibraries;

$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\group\Controllers\group_controller', 'group_custom_css'); //group Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<link href="<?php echo base_url(); ?>assets/plugins/jquery_editable_select/jquery-editable-select.min.css" rel="stylesheet">

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

                            <!-- group Add Code Start -->
                            <div class="card">
                                <div class="card-body">


                                    <form class="form-horizontal" id="edit_company_form" action="<?php echo $base_url . route_to('update_company'); ?>" method="post" data-parsley-validate enctype="multipart/form-data" data-parsley-validate>

                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <h3 class="m-b-30">Company Details</h3>
                                        <div class="form-group row">
                                            <label class="col-sm-1 control-label">Company Name<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                            <input type="text" name="company_name" class="form-control form-control-custom" value='<?= $comp_data[0]['company_name']; ?>' id="company_name" required>
                                            </div>

                                            <label class="col-sm-1 control-label">Company Email<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                            <input type="text" name="company_email" class="form-control form-control-custom" value='<?= $comp_data[0]['company_email']; ?>' id="company_email" required>
                                            </div>

                                            <label class="col-sm-1 control-label">GSTN<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="gstn" class="form-control form-control-custom" minlength="15" maxlength="15" value='<?= $comp_data[0]['gstn']; ?>' id="gstn" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                        <label class="col-sm-1 control-label">Contact Phone</label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="phone" class="form-control form-control-custom" value='<?= $comp_data[0]['company_phone']; ?>' style="width: 130%;" id="phone">
                                            </div>

                                        <label class="col-sm-1 control-label">Website</label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="website" class="form-control form-control-custom" value='<?= $comp_data[0]['company_website']; ?>' id="website">
                                            </div>

                                            <label class="col-sm-1 control-label">Country<span>*</span></label>
                                            <div class="col-sm-3">
                                                <select name="country" class="form-control form-control-custom" id="country" required data-parsley-errors-container="#country_error" data-parsley-error-message="Please select your country" disabled>
                                                <option value="" disabled selected>Select your country</option>
                                                <?php foreach ($countries as $countryOption): ?>
                                                    <option data-id="<?php echo $countryOption['id'] ?>"
                                                        value="<?php echo $countryOption['name'] ?>" <?php echo ($countryOption['name'] === $comp_data[0]['country']) ? 'selected' : ''; ?>>
                                                        <?php echo $countryOption['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
								        	</select>
									            <span id="country_error"></span>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                        <label class="col-sm-1 control-label">Time zone<span>*</span></label>
                                        <div class="col-sm-3 mb-3" id="zone_div">
                                                <select name="zone" class="form-control form-control-custom" id="zone" required>
                                                <?php if (isset($comp_data[0]['time_zone'])): ?>
											<option value="<?php echo $comp_data[0]['time_zone']; ?>" selected><?php echo $comp_data[0]['time_zone']; ?></option>
										<?php endif; ?>
                                                </select>
                                        </div>

                                        <label class="col-sm-1 control-label">State<span>*</span></label>
                                        <div class="col-sm-3 mb-3" id="state_div">
                                                <select name="state" class="form-control form-control-custom" id="state" required>
                                                <?php if (isset($comp_data[0]['state'])): ?>
											<option value="<?php echo $comp_data[0]['state']; ?>" selected><?php echo $comp_data[0]['state']; ?></option>
										<?php endif; ?>
                                                </select>
                                        </div>
                                        
                                        <label class="col-sm-1 control-label">City<span>*</span></label>
                                        <div class="col-sm-3" id="city_div">
                                            <select name="city" class="form-control form-control-custom" id="city" required>
                                            <?php if (isset($comp_data[0]['state'])): ?>
											<option value="<?php echo $comp_data[0]['city']; ?>" selected><?php echo $comp_data[0]['city']; ?></option>
										<?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 control-label">Address<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="address" class="form-control form-control-custom" value='<?= $comp_data[0]['company_address']; ?>' id="Address" required>
                                            </div>

                                        <label class="col-sm-1 control-label">Pincode<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="pincode" class="form-control form-control-custom" value='<?= $comp_data[0]['zipcode']; ?>' id="pincode" required>
                                            </div>

                                        <label class="col-sm-1 control-label">Company Logo (jpg, png)</label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="file" name="logo" accept=".jpg, .png" class="form-control form-control-custom" id="logo">
                                            </div>
                                        </div>
                                        <h3 class="m-b-30">User Details*</h3>
                                        <div class="form-group row">                                        
                                        <label class="col-sm-1 control-label">First Name<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="firstname" class="form-control form-control-custom" value='<?= $user_data[0]['first_name']; ?>' id="firstname" required>
                                            </div>

                                        <label class="col-sm-1 control-label">Middle Name</label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="middlename" class="form-control form-control-custom" value='<?= $comp_data[0]['middle_name']; ?>' id="middlename">
                                            </div>
                                        
                                        <label class="col-sm-1 control-label">Last Name<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="lastname" class="form-control form-control-custom" value='<?= $user_data[0]['last_name']; ?>' id="lastname" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">                                        
                                        <label class="col-sm-1 control-label">Contact Email<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="useremail" class="form-control form-control-custom" value='<?= $user_data[0]['email']; ?>' id="useremail" readonly>
                                            </div>

                                        <label class="col-sm-1 control-label">Contact Mobile<span>*</span></label>
                                            <div class="col-sm-3 mb-3">
                                                <input type="text" name="mobile" style="width: 130%;" class="form-control form-control-custom" value='<?= $user_data[0]['mobile']; ?>' id="mobile">
                                            </div>
                                        </div>

                                        <!-- -->
                                        <div class="text-center">
                                            <button type="button" id="update_company_btn" class="btn btn-primary waves-effect waves-light">Update</button>
                                            <button type="reset" class="btn btn-danger waves-effect waves-light">Reset</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location.reload();">Cancel</button>
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


<!-- Custom Js File Include Code End -->
<script src="<?php echo base_url(); ?>assets/js/intlTelInput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/utils.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery_editable_select/jquery-editable-select.min.js"></script>

<script>
	$('#state,#city').editableSelect(); //Dropdown Editable Allowed

	document.addEventListener("DOMContentLoaded", function () {
		var inputPhone = document.querySelector("#phone");
		var inputMobile = document.querySelector("#mobile");

		var itiPhone = window.intlTelInput(inputPhone, {
			initialCountry: "in",
			preferredCountries: ["in", "us"],
			utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
		});

		var itiMobile = window.intlTelInput(inputMobile, {
			initialCountry: "in",
			preferredCountries: ["in", "us"],
			utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
		});

        
    $('#update_company_btn').on('click', function (e) {
        e.preventDefault();

        var form = $('#edit_company_form').parsley();
        form.validate();

        // Validate phone numbers
        var phoneValid = itiPhone.isValidNumber();
        var mobileValid = itiMobile.isValidNumber();

        $('#phone').parsley().removeError('phoneInvalid');
        $('#mobile').parsley().removeError('mobileInvalid');

        if (form.isValid() && phoneValid && mobileValid) {
            // Format phone numbers with country code
            $('#phone').val(itiPhone.getNumber());
            $('#mobile').val(itiMobile.getNumber());

            $('.cust_loader_wrapper').show();
            $('form#edit_company_form').submit();
        } else {
            if (!phoneValid) {
                if ($('#phone').val() === '') {
                    $('#phone').parsley().addError('phoneInvalid', { message: 'This value is required', updateClass: true });
                } else {
                    $('#phone').parsley().addError('phoneInvalid', { message: 'Invalid phone number', updateClass: true });
                }
            }
            if (!mobileValid) {
                if ($('#mobile').val() === '') {
                    $('#mobile').parsley().addError('mobileInvalid', { message: 'This value is required', updateClass: true });
                } else {
                    $('#mobile').parsley().addError('mobileInvalid', { message: 'Invalid mobile number', updateClass: true });
                }
            }
        }
    });
    });

    $('#country').on('change', function () {
        var selectedOption = $(this).find('option:selected');
        var country_id = selectedOption.data('id');
        var country_name = selectedOption.val();

        $.ajax({
            url: base_url+'templates/get_states',
            method: 'GET',
            data: { country_id: country_id, country_name:country_name },
            dataType: 'json',
            success: function (response) {
                var states = response.states;
					var zones = response.zones;
					var sta = '';
					var zon = '';
                $('#state_div').html('');

                sta += '<select name="state" id="state" class="form-control form-control-custom" required>';

                $.each(states, function (index, state) {
                    sta += '<option value="' + state.name + '" data-id="' + state.id + '">' + state.name + '</option>';
                });
                sta += '</select>';
                $('#state_div').append(sta);
                $('#state').editableSelect();

				$('#zone_div').html('');
				if (zones.length > 0) {
					zon += '<select name="zone" id="zone" class="form-control form-control-custom" required>';
					$.each(zones, function (index, zone) {
						zon += '<option value="' + zone.time_zone + '">' + zone.time_zone + '</option>';
					});
					zon += '</select>';
				} else {
					zon += '<input type="text" class="form-control form-control-custom" name="zone" id="zone" placeholder="Enter time zone" required>';
				}
					$('#zone_div').append(zon);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });

    $(document).on('blur', '#state', function () {
        var state_id = $('#state').val();

        $.ajax({
            url: base_url+'templates/get_cities',
            method: 'GET',
            data: { state_id: state_id },
            dataType: 'json',
            success: function (response) {
                var cities = response.cities;
                var cit = '';
                $('#city_div').html('');

                cit += '<select name="city" id="city" class="form-control form-control-custom" required>';
                $.each(cities, function (index, city) {
                    cit += '<option value="' + city.name + '" data-id="' + city.id + '">' + city.name + '</option>';
                });
                cit += '</select>';
                $('#city_div').append(cit);
                $('#city').editableSelect();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });

        </script>

<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->