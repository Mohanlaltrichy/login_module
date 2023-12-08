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
                                                            <input data-name='can_delete' data-id='<?=$roles_role['id'];?>' class="col-sm-2 roles_checkbox"  type="checkbox" <?=($roles_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
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
                                                            <input data-name='can_delete' data-id='<?=$users_role['id'];?>' class="col-sm-2 users_checkbox"  type="checkbox" <?=($users_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$users_role['id'];?>">
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
                                            <!-- Users Code End -->

                                            <h3 class="col-lg-12 mb-3">Cloud Connector</h3>
                                            <!-- OPC Role Code Start -->                                                
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
                                                            $opc_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'], 
                                                                'page_id' => $opc_role['id'],                                 
                                                            ];
                                                
                                                            $opc_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $opc_data_whereConditions);                                                      
                                                    ?>
                                                    <div class="col-sm-6 mb-3">                                                   
                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_"," ",$opc_role['page_name'])); ?></b></label>
                                                        <input name="opc_checkbox_id[]" value='<?=$opc_role['id'];?>' type="hidden">  
                                                        <input name="opc_checkbox_view[]" id="checkbox_view_<?=$opc_role['id'];?>" type="hidden" class='opc_checkbox_value' value='<?=($opc_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>'>
                                                        <input name="opc_checkbox_edit[]" id="checkbox_edit_<?=$opc_role['id'];?>" type="hidden"  class='opc_checkbox_value'  value='<?=($opc_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>'>
                                                        <input name="opc_checkbox_delete[]" id="checkbox_delete_<?=$opc_role['id'];?>" type="hidden"  class='opc_checkbox_value'  value='<?=($opc_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>'>                                                                             
                                                        <span class="checkbox opc_checkbox_div">                                                 
                                                            <input data-name='can_view' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox" <?=($opc_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>                                                   
                                                            <label for="checkbox_view_<?=$opc_role['id'];?>">
                                                                Can View
                                                            </label>
                                                            <input data-name='can_edit' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox" <?=($opc_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_edit_<?=$opc_role['id'];?>">
                                                                Can Edit
                                                            </label>
                                                            <input data-name='can_delete' data-id='<?=$opc_role['id'];?>' class="col-sm-2 opc_checkbox" type="checkbox" <?=($opc_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
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

                                            <!-- Mqtt Role Code Start -->                                                
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
                                                            $mqtt_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $mqtt_role['id'],                                
                                                            ];
                                                
                                                            $mqtt_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mqtt_data_whereConditions);                                                     
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
                                                            <input data-name='can_delete' data-id='<?=$mqtt_role['id'];?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?=($mqtt_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
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

                                            <!-- http Role Code Start -->
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
                                                            $http_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'], 
                                                                'page_id' => $http_role['id'],                                 
                                                            ];
                                                
                                                            $http_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $http_data_whereConditions);                                                                                  
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
                                                            <input data-name='can_delete' data-id='<?=$http_role['id'];?>' class="col-sm-2 http_checkbox" type="checkbox" <?=($http_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                            
                                                            <label for="checkbox_delete_<?=$http_role['id'];?>">
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
                                                            $tag_data_whereConditions = [                                  
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $tag_role['id'],                                
                                                            ];
                                                
                                                            $tag_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $tag_data_whereConditions);                                                   
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
                                                            <input data-name='can_delete' data-id='<?=$tag_role['id'];?>' class="col-sm-2 tag_checkbox" type="checkbox" <?=($tag_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>                                                           
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

                                            <!-- Bulk Import List View Role Code Start -->                                                
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
                                            <!-- Bulk Import List View Role Code End -->                                            

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

<!--update_model_alert-->
<?php
echo $customlibraries->global_alert_msg('custom_update_model_alert', 'Roles', 'Are you sure update the role?');
?>
<!--update_model_alert-->


<!-- Form Validation Code Plugin Start -->
<script src="<?php echo base_url(); ?>assets/plugins/parsleyjs/parsley.min.js"></script>
<!-- Form Validation Code Plugin End -->



