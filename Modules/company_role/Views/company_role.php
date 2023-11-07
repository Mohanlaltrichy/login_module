<?php
$data['page_title'] = 'Roles';
echo view('\Modules\global_templates\Views\global_header',$data); // Header File Included
use App\Libraries\customlibraries;
$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller','company_role_custom_css'); //company_role Modules Custom CSS Files Included
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

                            <!-- company_role Add Code Start -->
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="m-t-0 m-b-30">Roles</h3>

                                    <form class="form-horizontal" id="add_company_role_client_config" action="<?php echo $base_url.route_to('company_role_save'); ?>" method="post" data-parsley-validate>
                                        
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <!-- Role Name Config Place Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Role name<span>*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="role_name" class="form-control form-control-custom" value="" id="role_name" placeholder="Enter role name" required>
                                                <div id='error-message'></div>
                                                <input type='hidden' id='role_name_duplicate' value='0'>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">                                            
                                            <label class="col-sm-2 control-label" for="role_name">Description</label>
                                            <div class="col-sm-5">
                                            <textarea name='description' class="form-control form-control-custom" rows="5" id="description" placeholder="Description"></textarea>
                                            </div>
                                        </div>  
                                        <!-- Role Name Config Place Code End -->
                                            
                                        <!-- Setting Role Display Code Start -->
                                        <h3 class="m-t-0 mb-3">Settings for pages access</h3>                                      
                                        <div class="row">

                                            <!-- Roles Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Roles</b>
                                                <input name='roles_all_checkbox_value' id="roles_all_checkbox_value" value='0' type="hidden">
                                                <span class="checkbox">
                                                <input id="roles_all_checkbox" class="form-check-inline" type="checkbox">
                                                    <label for="roles_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($roles_module_data))
                                                    {                                                        
                                                        foreach($roles_module_data as $roles_role)
                                                        {                                                             
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$roles_role['page_name'])); ?></b></label>
                                                        <input name="roles_checkbox_id[]" value='<?=$roles_role['id'];?>' type="hidden"> 
                                                        <input name="roles_checkbox_view[]" id="checkbox_view_<?=$roles_role['id'];?>" class='roles_checkbox_value' value='0' type="hidden">
                                                        <input name="roles_checkbox_edit[]" id="checkbox_edit_<?=$roles_role['id'];?>" class='roles_checkbox_value' value='0' type="hidden">
                                                        <input name="roles_checkbox_delete[]" id="checkbox_delete_<?=$roles_role['id'];?>" class='roles_checkbox_value' value='0' type="hidden">                                                                                                                      
                                                        <span class="checkbox roles_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox" type="checkbox">                                                           
                                                            <label for="checkbox_view_<?=$roles_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_edit_<?=$roles_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox"  type="checkbox">                                                            
                                                            <label for="checkbox_delete_<?=$roles_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                        </span>                                             
                                                    </div>
                                                    <?php                                                       
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Roles Code End --> 

                                            <h4 class="col-lg-12 mb-3">Cloud Connector</h4>
                                            <!-- OPC Role Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">OPC</b>
                                                <input name="opc_all_checkbox_value" id="opc_all_checkbox_value" value='0' type="hidden">
                                                <span class="checkbox">
                                                <input id="opc_all_checkbox" class="form-check-inline" type="checkbox">
                                                    <label for="opc_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($opc_module_data))
                                                    {                                                      
                                                        foreach($opc_module_data as $opc_role)
                                                        {                                                         
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$opc_role['page_name'])); ?></b></label>
                                                        <input name="opc_checkbox_id[]" value='<?=$opc_role['id'];?>' type="hidden">  
                                                        <input name="opc_checkbox_view[]" id="checkbox_view_<?=$opc_role['id'];?>" type="hidden" class='opc_checkbox_value' value='0'> 
                                                        <input name="opc_checkbox_edit[]" id="checkbox_edit_<?=$opc_role['id'];?>" type="hidden"  class='opc_checkbox_value'  value='0'> 
                                                        <input name="opc_checkbox_delete[]" id="checkbox_delete_<?=$opc_role['id'];?>" type="hidden"  class='opc_checkbox_value'  value='0'>                                                                                 
                                                        <span class="checkbox opc_checkbox_div">                                                 
                                                            <input data-name='can_view' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox">                                                   
                                                            <label for="checkbox_view_<?=$opc_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_edit_<?=$opc_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_delete_<?=$opc_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                        </span>                                              
                                                    </div>
                                                    <?php                                                        
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- OPC Role Code End --> 

                                            <!-- Tag Role Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Tag Config</b>
                                                <input name="tag_all_checkbox_value" id="tag_all_checkbox_value" value='0' type="hidden">
                                                <span class="checkbox">
                                                <input id="tag_all_checkbox" class="form-check-inline" type="checkbox">
                                                    <label for="tag_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($tag_module_data)) 
                                                    {                                                       
                                                        foreach($tag_module_data as $tag_role)
                                                        {                                                             
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$tag_role['page_name'])); ?></b></label> 
                                                        <input name="tag_checkbox_id[]" value='<?=$tag_role['id'];?>' type="hidden">
                                                        <input name="tag_checkbox_view[]" id="checkbox_view_<?=$tag_role['id'];?>" class='tag_checkbox_value' value='0' type="hidden">
                                                        <input name="tag_checkbox_edit[]" id="checkbox_edit_<?=$tag_role['id'];?>" class='tag_checkbox_value' value='0' type="hidden">   
                                                        <input name="tag_checkbox_delete[]" id="checkbox_delete_<?=$tag_role['id'];?>" class='tag_checkbox_value' value='0' type="hidden">                                                                                                                             
                                                        <span class="checkbox tag_checkbox_div">                                                           
                                                            <input data-name='can_view' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_view_<?=$tag_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_edit_<?=$tag_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_delete_<?=$tag_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                        </span>                                              
                                                    </div>
                                                    <?php                                                        
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Tag Role Code End -->

                                            <!-- Mqtt Role Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">MQTT</b>
                                                <input name="mqtt_all_checkbox_value" id="mqtt_all_checkbox_value" value='0' type="hidden">
                                                <span class="checkbox">
                                                <input id="mqtt_all_checkbox" class="form-check-inline" type="checkbox">
                                                    <label for="mqtt_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($mqtt_module_data)) 
                                                    {                                                        
                                                        foreach($mqtt_module_data as $mqtt_role)
                                                        {                                                            
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$mqtt_role['page_name'])); ?></b></label>   
                                                        <input name="mqtt_checkbox_id[]" value='<?=$mqtt_role['id'];?>' type="hidden"> 
                                                        <input name="mqtt_checkbox_view[]" id="checkbox_view_<?=$mqtt_role['id'];?>" class='mqtt_checkbox_value' value='0' type="hidden">
                                                        <input name="mqtt_checkbox_edit[]" id="checkbox_edit_<?=$mqtt_role['id'];?>" class='mqtt_checkbox_value' value='0' type="hidden">
                                                        <input name="mqtt_checkbox_delete[]" id="checkbox_delete_<?=$mqtt_role['id'];?>" class='mqtt_checkbox_value' value='0' type="hidden">                                                                                                                         
                                                        <span class="checkbox mqtt_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_view_<?=$mqtt_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_edit_<?=$mqtt_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_delete_<?=$mqtt_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                        </span>                                              
                                                    </div>
                                                    <?php                                                        
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Mqtt Role Code End -->

                                            <!-- Bulk Import List View Role Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Bulk Import Status</b>
                                                <input name="bulk_all_checkbox_value" id="bulk_all_checkbox_value" value='0' type="hidden">
                                                <span class="checkbox">
                                                <input id="bulk_all_checkbox" class="form-check-inline" type="checkbox">
                                                    <label for="bulk_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($bulk_import_list_module_data))
                                                    {                                                        
                                                        foreach($bulk_import_list_module_data as $bulk_list_role)
                                                        {                                                           
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$bulk_list_role['page_name'])); ?></b></label> 
                                                        <input name="bulk_checkbox_id[]" value='<?=$bulk_list_role['id'];?>' type="hidden">
                                                        <input name="bulk_checkbox_view[]" id="checkbox_view_<?=$bulk_list_role['id'];?>" class='bulk_checkbox_value' value='0' type="hidden">
                                                        <input name="bulk_checkbox_edit[]" id="checkbox_edit_<?=$bulk_list_role['id'];?>" class='bulk_checkbox_value' value='0' type="hidden">
                                                        <input name="bulk_checkbox_delete[]" id="checkbox_delete_<?=$bulk_list_role['id'];?>" class='bulk_checkbox_value' value='0' type="hidden">                                                                                                                                     
                                                        <span class="checkbox bulk_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$bulk_list_role['id'];?>' class="col-sm-2 bulk_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_view_<?=$bulk_list_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$bulk_list_role['id'];?>' class="col-sm-2 bulk_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_edit_<?=$bulk_list_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$bulk_list_role['id'];?>' class="col-sm-2 bulk_checkbox" type="checkbox">                                                            
                                                            <label for="checkbox_delete_<?=$bulk_list_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                        </span>                                              
                                                    </div>
                                                    <?php                                                        
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Bulk Import List View Role Code End -->                                            

                                        </div>
                                        <!--  Setting Role Display Code End -->

                                        <!-- Status Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Status<span>*</span></label>
                                            <div class="col-sm-3">
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
                                            <button type="button" id="save_company_role" class="btn btn-primary waves-effect waves-light">Save</button>                                         
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location='<?php echo $base_url.route_to('company_role'); ?>'">Cancel</button>                                            
                                        </div> 
                                        <!-- -->

                                    </form>

                                </div> <!-- card-body -->
                            </div> <!-- card -->
                            <!-- company_role Add Code End -->

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
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller','company_role'); // company_role Modules Custom Js File Included
?>
<!-- Custom Js File Include Code End -->


<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->



