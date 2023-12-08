<?php
$data['page_title'] = 'Users';
echo view('\Modules\global_templates\Views\global_header',$data); // Header File Included
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
        
        </br>
        <!-- Custom Error Alert Message -->
        <div id="custom_error_alert_controller_message">
            <?php
            $session = session();
            if ($session->getTempdata('company_user_deleted_success')) {
                echo $customlibraries->global_alert_msg('success', $session->getTempdata('company_user_deleted_success'));
            }
            session()->removeTempdata('company_user_deleted_success');
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
                    <div id="heading1">
                        <h3 class="m-0">Users
                            <span class="float-right" style="font-size:12px;color:red;">
                            <?php
                            if(session('user_view_and_edit_edit') != '1' && session('user_view_and_edit_delete') != '1')
                            {
                                echo EDIT_AND_DELETE_PERMISSION;
                            }
                            else if(session('user_view_and_edit_edit') != '1')
                            {
                                echo EDIT_PERMISSION;
                            }
                            else if(session('user_view_and_edit_delete') != '1')
                            {
                                echo DELETE_PERMISSION;
                            }
                            ?>
                            </span>
                        </h3>
                    </div>
                        <div class="row" style="margin-top:20px;margin-left:-10px;">
                            <div class="col-sm-12">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th data-orderable="false">Previlige</th>
                                            <th data-orderable="false">Organization</th>
                                            <th data-orderable="false">Email</th>
                                            <th data-orderable="false">Phone</th>                                         
                                            <th data-orderable="false">Mobile</th>                                         
                                            <th data-orderable="false">Designation</th>                                         
                                            <th data-orderable="false">Status</th>                                         
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php if (!empty($result)) { ?>
                                            <?php foreach ($result as $item) { ?>
                                                <tr>
                                                    <td><?= $item['name']; ?></td>
                                                    <td><?= $item['role_name']; ?></td>
                                                    <td><?= $item['company_name']; ?></td>
                                                    <td><?= $item['email']; ?></td>
                                                    <td><?= $item['phone']; ?></td>
                                                    <td><?= $item['mobile']; ?></td>
                                                    <td><?= $item['designation']; ?></td>
                                                    <td><?= ucfirst($item['status']); ?></td>
                                                    <td>
                                                        <?php if($item['status'] != 'deleted')  { ?>                                                        
                                                        <a href="<?=$base_url.route_to('company_user_edit',$item['id']);?>"><i style="font-size: x-large;color: #6CBAFA;" class="mdi mdi-square-edit-outline"></i></a>                                                        
                                                        <?php if(session('user_view_and_edit_delete') == '1') { ?>
                                                        <a href="javascript:void(0);" data-id='<?php echo $item['id']; ?>' id="delete_user"><i style="font-size: x-large;color: #ef5c6a;" class="mdi mdi-delete"></i></a>
                                                        <?php } ?>
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
echo $customlibraries->versioning('\Modules\company_user\Controllers\company_user_controller', 'company_user'); // company_user Modules Custom Js File Included
?>

<!-- Bootstrap File Style -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>

<!-- Custom Js File Include Code End -->

<!--update_model_alert-->
<div class="modal fade custom_model_alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0" id="mySmallModalLabel">Users</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                Are you sure delete the User?
                </br><span class='font-red'>User will be inactive !</span>
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
            // "searching": false, // Disable the search feature    
        });
    });
</script>