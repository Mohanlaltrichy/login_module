<?php
$data['page_title'] = 'List of All Notification';
echo view('\Modules\global_templates\Views\global_header', $data); // Header File Included
use App\Libraries\customlibraries;

$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\company_user\Controllers\company_user_controller','company_user_custom_css'); //company_user Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');
echo view('\Modules\global_templates\Views\global_datatables_css'); //Datatable CSS Files Included
?>

<!-- ============================================================== -->
<!-- Content here -->
<!-- ============================================================== -->
<div class="wrapper">
    <div class="container-fluid-custom">

        <!-- Data After Successfully Insert Alert -->
        <div id="custom_success_alert_controller_message">
            <?php if (session()->getFlashdata('success')) {
                echo $customlibraries->global_alert_msg('controller_success', session()->getFlashdata('success'));
            } ?>
        </div>
        <!-- Data After Successfully Insert Alert -->

        <!-- Table Start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="heading1">
                            <h4 class="m-0">List of All Notification
                                <span class="float-right" style="font-size:12px;color:red;">
                                <input type="text" id="alert_notification_add_edit" value="<?= session('alert_notification_add_edit'); ?>" hidden>
                                    <?php
                                    if (session('alert_notification_add_edit') != '1') {
                                        echo EDIT_PERMISSION;
                                    }
                                    ?>
                                </span>
                            </h4>
                        </div>
                        <div class="row" style="margin-top:20px;margin-left:-10px;">
                            <div class="col-sm-12">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all" data-orderable="false"></th>
                                            <th>Trigger Time</th>
                                            <th>Parameter Name</th>
                                            <th>UOM</th>
                                            <th>Target</th>
                                            <th>Actual Value</th>
                                            <th>Upper Limit</th>
                                            <th>Lower Limit</th>
                                            <th>Table Type</th>
                                            <th>Table Name</th>
                                            <th>Device Name</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php if (!empty($all_notification)) {
                                            foreach ($all_notification as $notification) {
                                        ?>
                                                <tr>
                                                    <td><input type="checkbox" class="select-checkbox" value="<?= $notification['id'] ?>"></td>
                                                    <td><?= $notification['trigger_time'] ?></td>
                                                    <td><?= $notification['parameter_name'] ?></td>
                                                    <td><?= $notification['uom'] ?></td>
                                                    <td><?= $notification['set_point'] ?></td>
                                                    <td><?= $notification['actual_value'] ?></td>
                                                    <td><?= $notification['upper_limit'] ?></td>
                                                    <td><?= $notification['lower_limit'] ?></td>
                                                    <td><?= $notification['table_type'] ?></td>
                                                    <td><?= $notification['table_name'] ?></td>
                                                    <td><?= $notification['device_name'] ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Table End -->

    </div>
</div>

<!-- Search Load Icon -->
<div id="loading-icon" class="load_icon_image">
       
</div>




<!-- end wrapper -->
<!-- ============================================================== -->
<!-- End content here -->
<!-- ============================================================== -->

<?php
echo view('\Modules\global_templates\Views\global_footer'); // Footer File Included
echo view('\Modules\global_templates\Views\global_datatables_js'); //Datatable CSS Files Included
?>

<!-- Bootstrap File Style -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
<!-- Bootstrap File Style -->

<script>
    $(document).ready(function() {

        var alert_notification_add_edit = $("#alert_notification_add_edit").val();
        var edit_permission_message = "<?= env('EDIT_PERMISSION') ?>";

        if (alert_notification_add_edit == '1') {
            var button_status = '';
        } else {
            var button_status = 'disabled';
        }

        var dataTable = $('#datatable-fixed-header').DataTable();
        dataTable.destroy(); // Destroy the existing DataTable instance

        $('#datatable-fixed-header').DataTable({
            paging: true,
            pageLength: 50,
            lengthMenu: [10, 25, 50, 75, 100],
            order: [],
            // "searching": false, // Disable the search feature    
        });

        $('.dataTables_length').append('<button id="customButton" class="btn btn-primary waves-effect waves-light" style="margin-left:30px;" ' + button_status + '>Acknowledge</button>');

        $('#select-all').on('change', function() {
            $('.select-checkbox', dataTable.rows().nodes()).prop('checked', this.checked);
        });

        $('#customButton').on('click', function() {
        var selectedIds = $('.select-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (selectedIds.length > 0) {

            if (confirm("Are you sure you want to proceed?")) {
                if (alert_notification_add_edit == '1') {
                    setTimeout(showLoadingIcon1, 10);
                    $.ajax({
                        type: 'POST',
                        url: base_url+"templates/acknowledge_notification",
                        data: {
                            selectedIds: selectedIds
                        },
                        success: function(result) {
                            hideLoadingIcon1();
                            if (result['status'] == 'success') {
                                $('input[type="checkbox"]').prop('checked', false);
                                alert('Data Update Successfully');
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                alert('Please try again later!!!');
                            }
                        }

                    });
                }
                else
                {
                    toastr.info(edit_permission_message+'!!!');
                }
            }
        } else {
            return false;
        }
        });
    });

    // Function to display the loading icon
    function showLoadingIcon1() {
        var loadingIcon = document.getElementById("loading-icon");
        loadingIcon.style.display = "block";
    }

    // Function to hide the loading icon
    function hideLoadingIcon1() {
        var loadingIcon = document.getElementById("loading-icon");
        loadingIcon.style.display = "none";
    }
</script>