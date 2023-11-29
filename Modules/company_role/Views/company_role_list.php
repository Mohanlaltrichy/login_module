<?php
$data['page_title'] = 'Roles';
echo view('\Modules\global_templates\Views\global_header',$data); // Header File Included
use App\Libraries\customlibraries;
$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller','company_role_custom_css'); //company_role Modules Custom CSS Files Included
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
            if ($session->getTempdata('company_role_deleted_success')) {
                echo $customlibraries->global_alert_msg('success', $session->getTempdata('company_role_deleted_success'));
            }
            session()->removeTempdata('company_role_deleted_success');
            ?>
        </div>
        <!-- Custom Error Alert Message -->

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
            if (session()->getFlashdata('error')) {
                echo $customlibraries->global_alert_msg('error',session()->getFlashdata('error'));
            }
            ?> 
         </div> 
        <!-- Custom Error Alert Message -->

        <!-- Table Start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">               
                    <div class="card-body">
                    <div id="heading1"><h3 class="m-0">Roles</h3></div>
                        <div class="row" style="margin-top:20px;margin-left:-10px;">
                            <div class="col-sm-12">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Role name</th>
                                            <th data-orderable="false">Description</th>
                                            <th>Status</th>
                                            <th>User count</th>
                                            <th>Creation date</th>                                            
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php if (!empty($result)) { ?>
                                            <?php foreach ($result as $item) { ?>
                                                <tr>
                                                    <td><?= $item['role_name']; ?></td>
                                                    <td><?= $item['description']; ?></td>
                                                    <td><?= ucfirst($item['status']); ?></td>
                                                    <td></td>
                                                    <td><?= $item['utc_created_at']; ?></td>
                                                    <td>
                                                        <?php if($item['status'] != 'deleted')  { ?>
                                                        <a href="<?=$base_url.route_to('company_role_edit',$item['id']);?>"><i style="font-size: x-large;color: #6CBAFA;" class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" data-id='<?php echo $item['id']; ?>' id="delete_role_list"><i style="font-size: x-large;color: #ef5c6a;" class="mdi mdi-delete"></i></a>
                                                        <?php } ?>
                                                    </td>                                                   
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                </table>

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
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller', 'company_role'); // company_role Modules Custom Js File Included
?>

<!-- Bootstrap File Style -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>

<!-- Custom Js File Include Code End -->

<!--update_model_alert-->
<div class="modal fade custom_model_alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="mySmallModalLabel">Roles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                Are you sure delete the role?
                </br><span class='font-red'>user map to this role will be inactive</span>
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
<!--update_model_alert-->

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