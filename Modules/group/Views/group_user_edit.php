<?php
$data['page_title'] = 'Groups';
echo view('\Modules\global_templates\Views\global_header', $data); // Header File Included
use App\Libraries\customlibraries;
use Modules\group\Models\group_model;

$this->group_model = new group_model();

$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\group\Controllers\group_controller', 'group_custom_css'); //group Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');
echo view('\Modules\global_templates\Views\global_datatables_css'); //Datatable CSS Files Included
?>

<!-- ============================================================== -->
<!-- Content here -->
<!-- ============================================================== -->
<div class="wrapper">
    <div class="container-fluid-custom">

        </br>
        <!-- Custom Error Alert Message -->
        <div id="custom_error_alert_controller_message">
            <?php
            $session = session();
            if ($session->getTempdata('group_user_success')) {
                echo $customlibraries->global_alert_msg('success', $session->getTempdata('group_user_success'));
            }
            session()->removeTempdata('group_user_success');
            ?>

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
        <!-- Custom Error Alert Message -->

        <!-- Table Start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="heading1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <h4 class="page-title m-0">Group User Edit Details</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <p class="mt-3"> <b> Name : </b> <?= $group_details[0]['grp_name']; ?> </p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="mt-3"> <b> Description : </b> <?= $group_details[0]['grp_desc']; ?> </p>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <a href="<?php echo $base_url . route_to('group_list'); ?>" type="button" class="btn btn-secondary waves-effect waves-light mb-3"> <i class="ti ti-angle-double-left"></i> Go Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;margin-left:-10px;">
                            <div class="col-sm-12">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><input class="col-md-2" type="checkbox" id="checkAll">Select All</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Mobile Number</th>
                                            <th>User Email</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php if (!empty($result)) { ?>
                                            <?php foreach ($result as $item) {
                                                $user_check_where = [
                                                    'grpid' => $group_id,
                                                    'user_id' => $item['id'],
                                                    'active' => 'Y'
                                                ];
                                                $user_mapped_check = $this->group_model->GetTableValue('tbl_user_mapping', 'id', $user_check_where);
                                            ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <input class="change-checkbox-value checkbox-<?= $item['id'] ?>" <?= (!empty($user_mapped_check)) ? 'checked' : ''; ?> type="checkbox" data-id="<?= $item['id'] ?>">
                                                    </td>
                                                    <td><?= $item['name']; ?></td>
                                                    <td><?= $item['city']; ?></td>
                                                    <td><?= $item['department']; ?></td>
                                                    <td><?= $item['designation']; ?></td>
                                                    <td><?= $item['mobile']; ?></td>
                                                    <td><?= $item['email']; ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                                <div class="w100 text-center">
                                    <input type="hidden" id="group_id" value="<?= $group_id; ?>">
                                    <button type="submit" id="update_user_mapped" class="btn btn-info mt-2 mb-3"> Update </button>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Tavle End -->

    </div>
</div>
<!-- end wrapper -->
<!-- ============================================================== -->
<!-- End content here -->
<!-- ============================================================== -->

<?php
echo view('\Modules\global_templates\Views\global_footer'); // Footer File Included
echo view('\Modules\global_templates\Views\global_datatables_js'); //Datatable CSS Files Included
?>

<!-- Custom Js File Include Code Start -->
<?php
echo $customlibraries->versioning('\Modules\group\Controllers\group_controller', 'group'); // group Modules Custom Js File Included
?>

<!-- Bootstrap File Style -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>

<!-- Custom Js File Include Code End -->


<script>
    $(document).ready(function() {
        var dataTable = $('#datatable-fixed-header').DataTable();
        dataTable.destroy(); // Destroy the existing DataTable instance

        $('#datatable-fixed-header').DataTable({
            paging: true,
            pageLength: 50,
            lengthMenu: [10, 25, 50, 75, 100],
            order: [],
        });
    });
</script>