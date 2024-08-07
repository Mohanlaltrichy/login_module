<?php
$data['page_title'] = 'Roles';
echo view('\Modules\global_templates\Views\global_header',$data); // Header File Included
use App\Libraries\customlibraries;
$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller','company_role_custom_css'); //company_role Modules Custom CSS Files Included
$base_url = rtrim(base_url(), '/');
use Modules\company_role\Models\company_role_model;
$this->company_role_model = new company_role_model();
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
                                    <div class="m-t-0 m-b-30"><h3>Roles <span class="float-right" style="font-size:12px;color:red;">
                                    <?php
                                    if(session('roles_view_and_edit_edit') != '1')
                                    { 
                                        echo EDIT_PERMISSION;
                                    } 
                                    ?></span>
                                    </h3>
                                    </div>

                                    <form class="form-horizontal" id="update_company_role_client_config" action="<?php echo $base_url.route_to('company_role_update'); ?>" method="post" data-parsley-validate>
                                        
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <input type="hidden" name="role_id" value="<?=$roles_details[0]['id'];?>">

                                        <!-- Role Name Config Place Code Start -->                                        
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Role name<span>*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="role_name" class="form-control form-control-custom" value='<?=$roles_details[0]['role_name'];?>' placeholder="Enter role name" readonly required>                                                
                                                <input type='hidden' id='role_name_duplicate' value='0'>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">                                            
                                            <label class="col-sm-2 control-label" for="role_name">Description</label>
                                            <div class="col-sm-5">
                                            <textarea name='description' class="form-control form-control-custom" rows="5" id="description" value='<?=$roles_details[0]['description'];?>' placeholder="Description"><?=$roles_details[0]['description'];?></textarea>
                                            </div>
                                        </div>  
                                        <!-- Role Name Config Place Code End -->
                                            
                                        <!-- Setting Role Display Code Start -->
                                        <h3 class="m-t-0 mb-3">Settings for pages access</h3>
                                        <div class="row">

                                            <!-- Roles Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Roles</b>
                                                <input name='roles_all_checkbox_value' id="roles_all_checkbox_value" value='<?=($roles_details[0]['roles_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="roles_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['roles_all_pages'] == 'Y') ? 'checked' : ''?>>
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
                                                            $roles_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'], 
                                                                'page_id' => $roles_role['id'],                                  
                                                            ];
                                                
                                                            $roles_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $roles_data_whereConditions);

                                                            if(empty($roles_result))
                                                            {
                                                                $roles_result[0]['can_view'] = 'N';
                                                                $roles_result[0]['can_edit'] = 'N';
                                                                $roles_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$roles_role['page_name'])); ?></b></label>
                                                        <input name="roles_checkbox_id[]" value='<?=$roles_role['id'];?>' type="hidden"> 
                                                        <input name="roles_checkbox_view[]" id="checkbox_view_<?=$roles_role['id'];?>" class='roles_checkbox_value' value='<?=($roles_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="roles_checkbox_edit[]" id="checkbox_edit_<?=$roles_role['id'];?>" class='roles_checkbox_value' value='<?=($roles_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="roles_checkbox_delete[]" id="checkbox_delete_<?=$roles_role['id'];?>" class='roles_checkbox_value' value='<?=($roles_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                      
                                                        <span class="checkbox roles_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox" type="checkbox" <?=($roles_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                          
                                                            <label for="checkbox_view_<?=$roles_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox" type="checkbox" <?=($roles_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                           
                                                            <label for="checkbox_edit_<?=$roles_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($roles_role['page_name'] != "roles_add") { ?>
                                                            <input data-name='can_delete' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox"  type="checkbox" <?=($roles_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$roles_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                             
                                                    </div>
                                                    <?php                                                       
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Roles Code End -->

                                            <!-- Users Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Users</b>
                                                <input name='users_all_checkbox_value' id="users_all_checkbox_value" value='<?=($roles_details[0]['users_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="users_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['users_all_pages'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="users_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($users_module_data))
                                                    {                                                        
                                                        foreach($users_module_data as $users_role)
                                                        {                                                     
                                                            $users_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'], 
                                                                'page_id' => $users_role['id'],                                  
                                                            ];
                                                
                                                            $users_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $users_data_whereConditions);

                                                            if(empty($users_result))
                                                            {
                                                                $users_result[0]['can_view'] = 'N';
                                                                $users_result[0]['can_edit'] = 'N';
                                                                $users_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$users_role['page_name'])); ?></b></label>
                                                        <input name="users_checkbox_id[]" value='<?=$users_role['id'];?>' type="hidden"> 
                                                        <input name="users_checkbox_view[]" id="checkbox_view_<?=$users_role['id'];?>" class='users_checkbox_value' value='<?=($users_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="users_checkbox_edit[]" id="checkbox_edit_<?=$users_role['id'];?>" class='users_checkbox_value' value='<?=($users_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="users_checkbox_delete[]" id="checkbox_delete_<?=$users_role['id'];?>" class='users_checkbox_value' value='<?=($users_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                      
                                                        <span class="checkbox users_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$users_role['id'];?>' class="col-sm-2 users_checkbox" type="checkbox" <?=($users_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                          
                                                            <label for="checkbox_view_<?=$users_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$users_role['id'];?>' class="col-sm-2 users_checkbox" type="checkbox" <?=($users_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                           
                                                            <label for="checkbox_edit_<?=$users_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($users_role['page_name'] != "users_add") { ?>
                                                            <input data-name='can_delete' data-id='<?=$users_role['id'];?>' class="col-sm-2 users_checkbox"  type="checkbox" <?=($users_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$users_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                             
                                                    </div>
                                                    <?php                                                       
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Users Code End -->

                                            <!-- Groups Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Groups</b>
                                                <input name='groups_all_checkbox_value' id="groups_all_checkbox_value" value='<?=($roles_details[0]['groups_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="groups_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['groups_all_pages'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="groups_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($groups_module_data))
                                                    {                                                        
                                                        foreach($groups_module_data as $groups_role)
                                                        {                                                     
                                                            $groups_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'], 
                                                                'page_id' => $groups_role['id'],                                  
                                                            ];
                                                
                                                            $groups_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $groups_data_whereConditions);

                                                            if(empty($groups_result))
                                                            {
                                                                $groups_result[0]['can_view'] = 'N';
                                                                $groups_result[0]['can_edit'] = 'N';
                                                                $groups_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$groups_role['page_name'])); ?></b></label>
                                                        <input name="groups_checkbox_id[]" value='<?=$groups_role['id'];?>' type="hidden"> 
                                                        <input name="groups_checkbox_view[]" id="checkbox_view_<?=$groups_role['id'];?>" class='groups_checkbox_value' value='<?=($groups_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="groups_checkbox_edit[]" id="checkbox_edit_<?=$groups_role['id'];?>" class='groups_checkbox_value' value='<?=($groups_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="groups_checkbox_delete[]" id="checkbox_delete_<?=$groups_role['id'];?>" class='groups_checkbox_value' value='<?=($groups_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                      
                                                        <span class="checkbox groups_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$groups_role['id'];?>' class="col-sm-2 groups_checkbox" type="checkbox" <?=($groups_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                          
                                                            <label for="checkbox_view_<?=$groups_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$groups_role['id'];?>' class="col-sm-2 groups_checkbox" type="checkbox" <?=($groups_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                           
                                                            <label for="checkbox_edit_<?=$groups_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($groups_role['page_name'] != "groups_add") { ?>
                                                            <input data-name='can_delete' data-id='<?=$groups_role['id'];?>' class="col-sm-2 groups_checkbox"  type="checkbox" <?=($groups_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$groups_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                             
                                                    </div>
                                                    <?php                                                       
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Groups Code End -->

                                            <!-- OPC Role Code Start --> 
                                            <?php if (in_array('cloud_connector', $subscription_roles_page_data)) { ?>
                                            <h3 class="col-lg-12 mb-3">Cloud Connector</h3>                                                                                           
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">OPC</b>
                                                <input name="opc_all_checkbox_value" id="opc_all_checkbox_value" value='<?=($roles_details[0]['opc_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="opc_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['opc_all_pages'] == 'Y') ? 'checked' : ''?>>
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
                                                            if($opc_role['page_name'] == 'opc_add_server' && in_array('opc_ua_subscribe', $subscription_roles_page_data) || $opc_role['page_name'] == 'opc_bulk_import' && in_array('opc_bulk_import', $subscription_roles_page_data) || $opc_role['page_name'] != 'opc_add_server' && $opc_role['page_name'] != 'opc_bulk_import')
                                                            {
                                                                if($opc_role['page_name'] == 'opc_nodes_to_subscribe' && in_array('opc_ua_subscribe', $subscription_roles_page_data) || $opc_role['page_name'] == 'opc_history_data_nodes' && in_array('opc_ua_subscribe', $subscription_roles_page_data) || $opc_role['page_name'] != 'opc_nodes_to_subscribe' && $opc_role['page_name'] != 'opc_history_data_nodes') {

                                                                $opc_data_whereConditions = [                                  
                                                                    'role_id' => $roles_details[0]['id'], 
                                                                    'page_id' => $opc_role['id'],                                 
                                                                ];
                                                    
                                                                $opc_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $opc_data_whereConditions);   
                                                                
                                                                if(empty($opc_result))
                                                                {
                                                                    $opc_result[0]['can_view'] = 'N';
                                                                    $opc_result[0]['can_edit'] = 'N';
                                                                    $opc_result[0]['can_delete'] = 'N';
                                                                }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$opc_role['page_name'])); ?></b></label>
                                                        <input name="opc_checkbox_id[]" value='<?=$opc_role['id'];?>' type="hidden">  
                                                        <input name="opc_checkbox_view[]" id="checkbox_view_<?=$opc_role['id'];?>" type="hidden" class='opc_checkbox_value' value='<?=($opc_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>'>
                                                        <input name="opc_checkbox_edit[]" id="checkbox_edit_<?=$opc_role['id'];?>" type="hidden"  class='opc_checkbox_value'  value='<?=($opc_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>'>
                                                        <input name="opc_checkbox_delete[]" id="checkbox_delete_<?=$opc_role['id'];?>" type="hidden"  class='opc_checkbox_value'  value='<?=($opc_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>'>                                                                             
                                                        <span class="checkbox opc_checkbox_div"> 
                                                            <?php if($opc_role['page_name'] != "opc_nodes_to_subscribe" && $opc_role['page_name'] != "opc_events_to_subscribe" && $opc_role['page_name'] != "opc_history_data_nodes" && $opc_role['page_name'] != "opc_history_event_nodes") { ?>                                                
                                                            <input data-name='can_view' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox" <?=($opc_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                   
                                                            <label for="checkbox_view_<?=$opc_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <?php } ?>
                                                            <?php if($opc_role['page_name'] != "opc_add_node") { ?>
                                                            <input data-name='can_edit' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox" <?=($opc_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$opc_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($opc_role['page_name'] != "opc_nodes_to_subscribe" && $opc_role['page_name'] != "opc_events_to_subscribe" && $opc_role['page_name'] != "opc_history_data_nodes" && $opc_role['page_name'] != "opc_history_event_nodes" && $opc_role['page_name'] != "opc_add_server" && $opc_role['page_name'] != "opc_client_bcp" && $opc_role['page_name'] != "opc_bulk_import") { ?> 
                                                            <input data-name='can_delete' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox" <?=($opc_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$opc_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </span>                                              
                                                    </div>
                                                    <?php
                                                                }                                                        
                                                            }
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <!-- OPC Role Code End -->                                            

                                            <!-- Mqtt Role Code Start -->   
                                            <?php if (in_array('mqtt', $subscription_roles_page_data)) { ?>                                             
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">MQTT</b>
                                                <input name="mqtt_all_checkbox_value" id="mqtt_all_checkbox_value" value='<?=($roles_details[0]['mqtt_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="mqtt_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['mqtt_all_pages'] == 'Y') ? 'checked' : ''?>>
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
                                                            if($mqtt_role['page_name'] == 'mqtt_bulk_import' && in_array('mqtt_bulk_import', $subscription_roles_page_data) ||  $mqtt_role['page_name'] != 'mqtt_bulk_import')
                                                            {                                                             

                                                            $mqtt_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $mqtt_role['id'],                                
                                                            ];
                                                
                                                            $mqtt_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mqtt_data_whereConditions);
                                                            
                                                            if(empty($mqtt_result))
                                                            {
                                                                $mqtt_result[0]['can_view'] = 'N';
                                                                $mqtt_result[0]['can_edit'] = 'N';
                                                                $mqtt_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$mqtt_role['page_name'])); ?></b></label>   
                                                        <input name="mqtt_checkbox_id[]" value='<?=$mqtt_role['id'];?>' type="hidden"> 
                                                        <input name="mqtt_checkbox_view[]" id="checkbox_view_<?=$mqtt_role['id'];?>" class='mqtt_checkbox_value' value='<?=($mqtt_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="mqtt_checkbox_edit[]" id="checkbox_edit_<?=$mqtt_role['id'];?>" class='mqtt_checkbox_value' value='<?=($mqtt_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="mqtt_checkbox_delete[]" id="checkbox_delete_<?=$mqtt_role['id'];?>" class='mqtt_checkbox_value' value='<?=($mqtt_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                         
                                                        <span class="checkbox mqtt_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?=($mqtt_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$mqtt_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?=($mqtt_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$mqtt_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($mqtt_role['page_name'] != "mqtt_add_topic" && $mqtt_role['page_name'] != "mqtt_add_node" && $mqtt_role['page_name'] != "mqtt_bulk_import") { ?>
                                                            <input data-name='can_delete' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?=($mqtt_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$mqtt_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                              
                                                    </div>
                                                    <?php 
                                                            }                                                       
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <!-- Mqtt Role Code End -->

                                            <!-- http Role Code Start -->
                                            <?php if (in_array('https_request', $subscription_roles_page_data) || in_array('https_post', $subscription_roles_page_data)) { ?>
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Http(s)</b>
                                                <input name="http_all_checkbox_value" id="http_all_checkbox_value" value='<?=($roles_details[0]['http_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="http_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['http_all_pages'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="http_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($http_module_data))
                                                    {                                                      
                                                        foreach($http_module_data as $http_role)
                                                        {   
                                                            if($http_role['page_name'] == 'http(s)_bulk_import' && in_array('https_bulk_import', $subscription_roles_page_data) ||  $http_role['page_name'] != 'http(s)_bulk_import')
                                                            { 

                                                            $http_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'], 
                                                                'page_id' => $http_role['id'],                                 
                                                            ];
                                                
                                                            $http_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $http_data_whereConditions);    
                                                            
                                                            if(empty($http_result))
                                                            {
                                                                $http_result[0]['can_view'] = 'N';
                                                                $http_result[0]['can_edit'] = 'N';
                                                                $http_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$http_role['page_name'])); ?></b></label>
                                                        <input name="http_checkbox_id[]" value='<?=$http_role['id'];?>' type="hidden">  
                                                        <input name="http_checkbox_view[]" id="checkbox_view_<?=$http_role['id'];?>" type="hidden" class='http_checkbox_value' value='<?=($http_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>'>
                                                        <input name="http_checkbox_edit[]" id="checkbox_edit_<?=$http_role['id'];?>" type="hidden"  class='http_checkbox_value'  value='<?=($http_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>'>
                                                        <input name="http_checkbox_delete[]" id="checkbox_delete_<?=$http_role['id'];?>" type="hidden"  class='http_checkbox_value'  value='<?=($http_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>'>                                                                             
                                                        <span class="checkbox http_checkbox_div">                                                 
                                                            <input data-name='can_view' data-id='<?=$http_role['id'];?>' class="col-sm-2 http_checkbox" type="checkbox" <?=($http_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                   
                                                            <label for="checkbox_view_<?=$http_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$http_role['id'];?>' class="col-sm-2 http_checkbox" type="checkbox" <?=($http_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$http_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($http_role['page_name'] != "http(s)_add_server" && $http_role['page_name'] != "http(s)_add_node" && $http_role['page_name'] != "http(s)_bulk_import") { ?>
                                                            <input data-name='can_delete' data-id='<?=$http_role['id'];?>' class="col-sm-2 http_checkbox" type="checkbox" <?=($http_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$http_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                              
                                                    </div>
                                                    <?php 
                                                            }                                                       
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <!-- http Role Code End -->   

                                            <!-- Tag Role Code Start -->                                                
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Historian Config</b>
                                                <input name="tag_all_checkbox_value" id="tag_all_checkbox_value" value='<?=($roles_details[0]['tag_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="tag_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['tag_all_pages'] == 'Y') ? 'checked' : ''?>>
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
                                                            if($tag_role['page_name'] == 'historian_bulk_import' && in_array('historian_bulk_import', $subscription_roles_page_data) ||  $tag_role['page_name'] != 'historian_bulk_import')
                                                            { 

                                                            $tag_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $tag_role['id'],                                
                                                            ];
                                                
                                                            $tag_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $tag_data_whereConditions);   
                                                            
                                                            if(empty($tag_result))
                                                            {
                                                                $tag_result[0]['can_view'] = 'N';
                                                                $tag_result[0]['can_edit'] = 'N';
                                                                $tag_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$tag_role['page_name'])); ?></b></label> 
                                                        <input name="tag_checkbox_id[]" value='<?=$tag_role['id'];?>' type="hidden">
                                                        <input name="tag_checkbox_view[]" id="checkbox_view_<?=$tag_role['id'];?>" class='tag_checkbox_value' value='<?=($tag_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="tag_checkbox_edit[]" id="checkbox_edit_<?=$tag_role['id'];?>" class='tag_checkbox_value' value='<?=($tag_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">   
                                                        <input name="tag_checkbox_delete[]" id="checkbox_delete_<?=$tag_role['id'];?>" class='tag_checkbox_value' value='<?=($tag_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                             
                                                        <span class="checkbox tag_checkbox_div">                                                           
                                                            <input data-name='can_view' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox" <?=($tag_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$tag_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox" <?=($tag_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$tag_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($tag_role['page_name'] != "historian_create_table" && $tag_role['page_name'] != "historian_bulk_import") { ?>
                                                            <input data-name='can_delete' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox" <?=($tag_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                           
                                                            <label for="checkbox_delete_<?=$tag_role['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                              
                                                    </div>
                                                    <?php
                                                            }                                                        
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <!-- Tag Role Code End -->

                                            <!-- Bulk Import List View Role Code Start --> 
                                            <?php if(in_array('opc_bulk_import', $subscription_roles_page_data) || in_array('mqtt_bulk_import', $subscription_roles_page_data) || in_array('https_bulk_import', $subscription_roles_page_data) || in_array('historian_bulk_import', $subscription_roles_page_data)) { ?>                                               
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Bulk Import Status</b>
                                                <input name="bulk_all_checkbox_value" id="bulk_all_checkbox_value" value='<?=($roles_details[0]['bulk_import_status_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="bulk_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['bulk_import_status_all_pages'] == 'Y') ? 'checked' : ''?>>
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
                                                            $bulk_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $bulk_list_role['id'],                                
                                                            ];
                                                
                                                            $bulk_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $bulk_data_whereConditions);  
                                                            
                                                            if(empty($bulk_result))
                                                            {
                                                                $bulk_result[0]['can_view'] = 'N';
                                                                $bulk_result[0]['can_edit'] = 'N';
                                                                $bulk_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$bulk_list_role['page_name'])); ?></b></label> 
                                                        <input name="bulk_checkbox_id[]" value='<?=$bulk_list_role['id'];?>' type="hidden">
                                                        <input name="bulk_checkbox_view[]" id="checkbox_view_<?=$bulk_list_role['id'];?>" class='bulk_checkbox_value' value='<?=($bulk_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="bulk_checkbox_edit[]" id="checkbox_edit_<?=$bulk_list_role['id'];?>" class='bulk_checkbox_value' value='<?=($bulk_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="bulk_checkbox_delete[]" id="checkbox_delete_<?=$bulk_list_role['id'];?>" class='bulk_checkbox_value' value='<?=($bulk_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                                     
                                                        <span class="checkbox bulk_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$bulk_list_role['id'];?>' class="col-sm-2 bulk_checkbox" type="checkbox" <?=($bulk_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$bulk_list_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$bulk_list_role['id'];?>' class="col-sm-2 bulk_checkbox" type="checkbox" <?=($bulk_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$bulk_list_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$bulk_list_role['id'];?>' class="col-sm-2 bulk_checkbox" type="checkbox" <?=($bulk_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
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
                                            <?php } ?>
                                            <!-- Bulk Import List View Role Code End --> 


                                            <!-- Dashboard Role Code Start -->   
                                            <?php if (in_array('dashboards', $subscription_roles_page_data)) { ?>                                             
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Dashboard</b>
                                                <input name="dashboard_all_checkbox_value" id="dashboard_all_checkbox_value" value='<?=($roles_details[0]['dashboard_status_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="dashboard_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['dashboard_status_all_pages'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="dashboard_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($dashboard_module_data))
                                                    {                                                        
                                                        foreach($dashboard_module_data as $dashboard_role)
                                                        {              
                                                            $dashboard_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $dashboard_role['id'],                                
                                                            ];
                                                
                                                            $dashboard_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $dashboard_data_whereConditions); 
                                                            
                                                            if(empty($dashboard_result))
                                                            {
                                                                $dashboard_result[0]['can_view'] = 'N';
                                                                $dashboard_result[0]['can_edit'] = 'N';
                                                                $dashboard_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$dashboard_role['page_name'])); ?></b></label> 
                                                        <input name="dashboard_checkbox_id[]" value='<?=$dashboard_role['id'];?>' type="hidden">
                                                        <input name="dashboard_checkbox_view[]" id="checkbox_view_<?=$dashboard_role['id'];?>" class='dashboard_checkbox_value' value='<?=($dashboard_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="dashboard_checkbox_edit[]" id="checkbox_edit_<?=$dashboard_role['id'];?>" class='dashboard_checkbox_value' value='<?=($dashboard_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="dashboard_checkbox_delete[]" id="checkbox_delete_<?=$dashboard_role['id'];?>" class='dashboard_checkbox_value' value='<?=($dashboard_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                                     
                                                        <span class="checkbox dashboard_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$dashboard_role['id'];?>' class="col-sm-2 dashboard_checkbox" type="checkbox" <?=($dashboard_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$dashboard_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$dashboard_role['id'];?>' class="col-sm-2 dashboard_checkbox" type="checkbox" <?=($dashboard_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$dashboard_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$dashboard_role['id'];?>' class="col-sm-2 dashboard_checkbox" type="checkbox" <?=($dashboard_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$dashboard_role['id'];?>">
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
                                            <?php } ?>
                                            <!-- Dashboard Role Code End --> 

                                            <!-- Reports Role Code Start -->     
                                            <?php if (in_array('reports', $subscription_roles_page_data)) { ?>                                           
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Reports</b>
                                                <input name="reports_all_checkbox_value" id="reports_all_checkbox_value" value='<?=($roles_details[0]['reports_status_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="reports_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['reports_status_all_pages'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="reports_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($reports_module_data))
                                                    {                                                        
                                                        foreach($reports_module_data as $reports_role)
                                                        {              
                                                            $reports_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $reports_role['id'],                                
                                                            ];
                                                
                                                            $reports_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $reports_data_whereConditions); 
                                                            
                                                            if(empty($reports_result))
                                                            {
                                                                $reports_result[0]['can_view'] = 'N';
                                                                $reports_result[0]['can_edit'] = 'N';
                                                                $reports_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$reports_role['page_name'])); ?></b></label> 
                                                        <input name="reports_checkbox_id[]" value='<?=$reports_role['id'];?>' type="hidden">
                                                        <input name="reports_checkbox_view[]" id="checkbox_view_<?=$reports_role['id'];?>" class='reports_checkbox_value' value='<?=($reports_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="reports_checkbox_edit[]" id="checkbox_edit_<?=$reports_role['id'];?>" class='reports_checkbox_value' value='<?=($reports_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="reports_checkbox_delete[]" id="checkbox_delete_<?=$reports_role['id'];?>" class='reports_checkbox_value' value='<?=($reports_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                                     
                                                        <span class="checkbox reports_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$reports_role['id'];?>' class="col-sm-2 reports_checkbox" type="checkbox" <?=($reports_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$reports_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$reports_role['id'];?>' class="col-sm-2 reports_checkbox" type="checkbox" <?=($reports_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$reports_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$reports_role['id'];?>' class="col-sm-2 reports_checkbox" type="checkbox" <?=($reports_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$reports_role['id'];?>">
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
                                            <?php } ?>
                                            <!-- Reports Role Code End --> 

                                             <!-- Notification Code Start -->    
                                             <?php if (in_array('alert_and_notification', $subscription_roles_page_data)) { ?>                                            
                                             <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Notification</b>
                                                <input name="notification_all_checkbox_value" id="notification_all_checkbox_value" value='<?=($roles_details[0]['notify_all_checkbox_value'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="notification_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['notify_all_checkbox_value'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="notification_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($notification_data))
                                                    {                                                        
                                                        foreach($notification_data as $notification)
                                                        {   
                                                            if($notification['page_name'] == 'notification_bulk_import' && in_array('parameter_bulk_import', $subscription_roles_page_data) ||  $notification['page_name'] != 'notification_bulk_import')
                                                            { 

                                                            $notification_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $notification['id'],                                
                                                            ];
                                                
                                                            $notification_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $notification_data_whereConditions); 
                                                            
                                                            if(empty($notification_result))
                                                            {
                                                                $notification_result[0]['can_view'] = 'N';
                                                                $notification_result[0]['can_edit'] = 'N';
                                                                $notification_result[0]['can_delete'] = 'N';
                                                            }

                                                            if($notification['page_name'] == 'notification_group_list')
                                                            {
                                                                $notify_page_name = 'group_list';
                                                            }
                                                            else if($notification['page_name'] == 'notification_user_list')
                                                            {
                                                                $notify_page_name = 'user_list';
                                                            }
                                                            else if($notification['page_name'] == 'notification_user_role')
                                                            {
                                                                $notify_page_name = 'user_roles';
                                                            }
                                                            else if($notification['page_name'] == 'notification_template_list')
                                                            {
                                                                $notify_page_name = 'template_list';
                                                            }
                                                            else if($notification['page_name'] == 'notification_trigger_tag_configuration')
                                                            {
                                                                $notify_page_name = 'trigger_tag';
                                                            }
                                                            else if($notification['page_name'] == 'notification_configuration')
                                                            {
                                                                $notify_page_name = 'notification';
                                                            }
                                                            else if($notification['page_name'] == 'notification_bulk_import')
                                                            {
                                                                $notify_page_name = 'bulk_import';
                                                            }
                                                            else if($notification['page_name'] == 'notification_uom')
                                                            {
                                                                $notify_page_name = 'uom';
                                                            }
                                                            else if($notification['page_name'] == 'notification_alert_notification')
                                                            {
                                                                $notify_page_name = 'alert_notification';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$notify_page_name)); ?></b></label> 
                                                        <input name="notification_checkbox_id[]" value='<?=$notification['id'];?>' type="hidden">
                                                        <input name="notification_checkbox_view[]" id="checkbox_view_<?=$notification['id'];?>" class='notification_checkbox_value' value='<?=($notification_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="notification_checkbox_edit[]" id="checkbox_edit_<?=$notification['id'];?>" class='notification_checkbox_value' value='<?=($notification_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="notification_checkbox_delete[]" id="checkbox_delete_<?=$notification['id'];?>" class='notification_checkbox_value' value='<?=($notification_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                                     
                                                        <span class="checkbox notification_checkbox_div">   
                                                            <?php if($notification['page_name'] != 'notification_user_role') {  ?>                                                         
                                                            <input data-name='can_view' data-id='<?=$notification['id'];?>' class="col-sm-2 notification_checkbox" type="checkbox" <?=($notification_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$notification['id'];?>">
                                                                Can View
                                                            </label>
                                                            <?php } ?>
                                                            <input data-name='can_edit' data-id='<?=$notification['id'];?>' class="col-sm-2 notification_checkbox" type="checkbox" <?=($notification_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$notification['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <?php if($notification['page_name'] != 'notification_user_role' && $notification['page_name'] != 'notification_trigger_tag_configuration' && $notification['page_name'] != 'notification_alert_notification') { ?>
                                                            <input data-name='can_delete' data-id='<?=$notification['id'];?>' class="col-sm-2 notification_checkbox" type="checkbox" <?=($notification_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$notification['id'];?>">
                                                                Can Delete
                                                            </label>
                                                            <?php } ?>
                                                        </span>                                              
                                                    </div>
                                                    <?php   
                                                            }                                                     
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <!-- Notification Code End --> 

                                            <!-- Subscription Role Code Start -->     
                                            <div class="col-lg-12">                                                                                                      
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Subscription</b>
                                                <input name="subscription_all_checkbox_value" id="subscription_all_checkbox_value" value='<?=($roles_details[0]['subscription_all_pages'] == 'Y') ? '1' : '0'?>' type="hidden">
                                                <span class="checkbox">
                                                <input id="subscription_all_checkbox" class="form-check-inline" type="checkbox" <?=($roles_details[0]['subscription_all_pages'] == 'Y') ? 'checked' : ''?>>
                                                    <label for="subscription_all_checkbox">
                                                        Select all pages
                                                    </label>
                                                </span>
                                                </h5> 
                                                    
                                                <div class="form-group row">
                                                    <?php if(!empty($subscription_module_data))
                                                    {                                                        
                                                        foreach($subscription_module_data as $subscription_role)
                                                        {              
                                                            $subscription_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $subscription_role['id'],                                
                                                            ];
                                                
                                                            $subscription_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $subscription_data_whereConditions); 
                                                            
                                                            if(empty($subscription_result))
                                                            {
                                                                $subscription_result[0]['can_view'] = 'N';
                                                                $subscription_result[0]['can_edit'] = 'N';
                                                                $subscription_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$subscription_role['page_name'])); ?></b></label> 
                                                        <input name="subscription_checkbox_id[]" value='<?=$subscription_role['id'];?>' type="hidden">
                                                        <input name="subscription_checkbox_view[]" id="checkbox_view_<?=$subscription_role['id'];?>" class='subscription_checkbox_value' value='<?=($subscription_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="subscription_checkbox_edit[]" id="checkbox_edit_<?=$subscription_role['id'];?>" class='subscription_checkbox_value' value='<?=($subscription_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <input name="subscription_checkbox_delete[]" id="checkbox_delete_<?=$subscription_role['id'];?>" class='subscription_checkbox_value' value='<?=($subscription_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">                                                                                                                                     
                                                        <span class="checkbox subscription_checkbox_div">                                                            
                                                            <input data-name='can_view' data-id='<?=$subscription_role['id'];?>' class="col-sm-2 subscription_checkbox" type="checkbox" <?=($subscription_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_view_<?=$subscription_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$subscription_role['id'];?>' class="col-sm-2 subscription_checkbox" type="checkbox" <?=($subscription_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$subscription_role['id'];?>">
                                                                Can Edit
                                                            </label>                                                            
                                                        </span>                                              
                                                    </div>
                                                    <?php                                                        
                                                        }
                                                    }
                                                    ?>                                                    
                                                </div>
                                            </div>                                        
                                            <!-- Subscription Role Code End -->
                                        </div>
                                        <!--  Setting Role Display Code End -->

                                        <!-- Status Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Status<span>*</span></label>
                                            <div class="col-sm-3">
                                                <select name="status" class="form-control form-control-custom mb-3" id="status" required>
                                                    <option value="" readonly>Select</option>
                                                    <option value="active" <?=($roles_details[0]['status'] == 'active') ? 'selected' : '';?>>Active</option>
                                                    <option value="inactive" <?=($roles_details[0]['status'] == 'inactive') ? 'selected' : '';?>>Inactive</option>
                                                </select>
                                                <div id='status-error-message'></div>
                                            </div>
                                        </div>
                                        <!-- Status Code End -->

                                        <!-- -->
                                        <div class="text-center">                                           
                                            <button type="button" id="update_company_role" class="btn btn-primary waves-effect waves-light" <?=(session('roles_view_and_edit_edit') != '1') ? 'disabled' : '';?>>Update</button>                                         
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location='<?php echo $base_url.route_to('company_role_list'); ?>'">Cancel</button>                                            
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

<!--update_model_alert-->
<?php
echo $customlibraries->global_alert_msg('custom_update_model_alert', 'Roles', 'Are you sure update the role?');
?>
<!--update_model_alert-->


<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->



