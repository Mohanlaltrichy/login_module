<?php
$data['page_title'] = 'Roles';
echo view('\Modules\global_templates\Views\global_header', $data); // Header File Included
use App\Libraries\customlibraries;

$customlibraries = new customlibraries();
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller', 'company_role_custom_css'); //company_role Modules Custom CSS Files Included
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
                                    echo $customlibraries->global_alert_msg('controller_error', session()->getFlashdata('duplicate_record_found'));
                                } ?>

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
                                    <div class="m-t-0 m-b-30">
                                        <h3>Roles <span class="float-right" style="font-size:12px;color:red;">
                                                <?php
                                                if (session('roles_view_and_edit_edit') != '1') {
                                                    echo EDIT_PERMISSION;
                                                }
                                                ?></span>
                                        </h3>
                                    </div>

                                    <form class="form-horizontal" id="update_company_role_client_config" action="<?php echo $base_url . route_to('company_role_update'); ?>" method="post" data-parsley-validate>

                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                                        <input type="hidden" name="role_id" value="<?= $roles_details[0]['id']; ?>">

                                        <!-- Role Name Config Place Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Role name<span>*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" name="role_name" class="form-control form-control-custom" value='<?= $roles_details[0]['role_name']; ?>' placeholder="Enter role name" readonly required>
                                                <input type='hidden' id='role_name_duplicate' value='0'>
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Description</label>
                                            <div class="col-sm-5">
                                                <textarea name='description' class="form-control form-control-custom" rows="5" id="description" value='<?= $roles_details[0]['description']; ?>' placeholder="Description"><?= $roles_details[0]['description']; ?></textarea>
                                            </div>
                                        </div>
                                        <!-- Role Name Config Place Code End -->

                                        <!-- Setting Role Display Code Start -->
                                        <h3 class="m-t-0 mb-3">Settings for pages access</h3>
                                        <div class="row">

                                            <!-- Roles Code Start -->
                                            <div class="col-lg-12">
                                                <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Roles</b>
                                                    <input name='roles_all_checkbox_value' id="roles_all_checkbox_value" value='<?= ($roles_details[0]['roles_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                    <span class="checkbox">
                                                        <input id="roles_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['roles_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                        <label for="roles_all_checkbox">
                                                            Select all pages
                                                        </label>
                                                    </span>
                                                </h5>

                                                <div class="form-group row">
                                                    <?php if (!empty($roles_module_data)) {
                                                        foreach ($roles_module_data as $roles_role) {
                                                            $roles_data_whereConditions = [
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $roles_role['id'],
                                                            ];

                                                            $roles_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $roles_data_whereConditions);

                                                            if (empty($roles_result)) {
                                                                $roles_result[0]['can_view'] = 'N';
                                                                $roles_result[0]['can_edit'] = 'N';
                                                                $roles_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("roles", " ", $roles_role['page_name']))); ?></b></label>
                                                                <input name="roles_checkbox_id[]" value='<?= $roles_role['id']; ?>' type="hidden">
                                                                <input name="roles_checkbox_view[]" id="checkbox_view_<?= $roles_role['id']; ?>" class='roles_checkbox_value' value='<?= ($roles_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="roles_checkbox_edit[]" id="checkbox_edit_<?= $roles_role['id']; ?>" class='roles_checkbox_value' value='<?= ($roles_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="roles_checkbox_delete[]" id="checkbox_delete_<?= $roles_role['id']; ?>" class='roles_checkbox_value' value='<?= ($roles_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <span class="checkbox roles_checkbox_div">
                                                                     <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                    <input data-name='can_view' data-id='<?= $roles_role['id']; ?>' class="col-sm-2 roles_checkbox" type="checkbox" <?= ($roles_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_view_<?= $roles_role['id']; ?>">
                                                                        Can View
                                                                    </label>
                                                                    <input data-name='can_edit' data-id='<?= $roles_role['id']; ?>' class="col-sm-2 roles_checkbox" type="checkbox" <?= ($roles_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_edit_<?= $roles_role['id']; ?>">
                                                                        Can Edit
                                                                    </label>
                                                                    <?php if ($roles_role['page_name'] != "roles_add") { ?>
                                                                        <input data-name='can_delete' data-id='<?= $roles_role['id']; ?>' class="col-sm-2 roles_checkbox" type="checkbox" <?= ($roles_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_delete_<?= $roles_role['id']; ?>">
                                                                            Can Delete
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                    <input name='users_all_checkbox_value' id="users_all_checkbox_value" value='<?= ($roles_details[0]['users_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                    <span class="checkbox">
                                                        <input id="users_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['users_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                        <label for="users_all_checkbox">
                                                            Select all pages
                                                        </label>
                                                    </span>
                                                </h5>

                                                <div class="form-group row">
                                                    <?php if (!empty($users_module_data)) {
                                                        foreach ($users_module_data as $users_role) {
                                                            $users_data_whereConditions = [
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $users_role['id'],
                                                            ];

                                                            $users_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $users_data_whereConditions);

                                                            if (empty($users_result)) {
                                                                $users_result[0]['can_view'] = 'N';
                                                                $users_result[0]['can_edit'] = 'N';
                                                                $users_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("users", "", $users_role['page_name']))); ?></b></label>
                                                                <input name="users_checkbox_id[]" value='<?= $users_role['id']; ?>' type="hidden">
                                                                <input name="users_checkbox_view[]" id="checkbox_view_<?= $users_role['id']; ?>" class='users_checkbox_value' value='<?= ($users_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="users_checkbox_edit[]" id="checkbox_edit_<?= $users_role['id']; ?>" class='users_checkbox_value' value='<?= ($users_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="users_checkbox_delete[]" id="checkbox_delete_<?= $users_role['id']; ?>" class='users_checkbox_value' value='<?= ($users_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <span class="checkbox users_checkbox_div">
                                                                     <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                    <input data-name='can_view' data-id='<?= $users_role['id']; ?>' class="col-sm-2 users_checkbox" type="checkbox" <?= ($users_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_view_<?= $users_role['id']; ?>">
                                                                        Can View
                                                                    </label>
                                                                    <input data-name='can_edit' data-id='<?= $users_role['id']; ?>' class="col-sm-2 users_checkbox" type="checkbox" <?= ($users_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_edit_<?= $users_role['id']; ?>">
                                                                        Can Edit
                                                                    </label>
                                                                    <?php if ($users_role['page_name'] != "users_add") { ?>
                                                                        <input data-name='can_delete' data-id='<?= $users_role['id']; ?>' class="col-sm-2 users_checkbox" type="checkbox" <?= ($users_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_delete_<?= $users_role['id']; ?>">
                                                                            Can Delete
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                    <input name='groups_all_checkbox_value' id="groups_all_checkbox_value" value='<?= ($roles_details[0]['groups_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                    <span class="checkbox">
                                                        <input id="groups_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['groups_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                        <label for="groups_all_checkbox">
                                                            Select all pages
                                                        </label>
                                                    </span>
                                                </h5>

                                                <div class="form-group row">
                                                    <?php if (!empty($groups_module_data)) {
                                                        foreach ($groups_module_data as $groups_role) {
                                                            $groups_data_whereConditions = [
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $groups_role['id'],
                                                            ];

                                                            $groups_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $groups_data_whereConditions);

                                                            if (empty($groups_result)) {
                                                                $groups_result[0]['can_view'] = 'N';
                                                                $groups_result[0]['can_edit'] = 'N';
                                                                $groups_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("groups", "", $groups_role['page_name']))); ?></b></label>
                                                                <input name="groups_checkbox_id[]" value='<?= $groups_role['id']; ?>' type="hidden">
                                                                <input name="groups_checkbox_view[]" id="checkbox_view_<?= $groups_role['id']; ?>" class='groups_checkbox_value' value='<?= ($groups_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="groups_checkbox_edit[]" id="checkbox_edit_<?= $groups_role['id']; ?>" class='groups_checkbox_value' value='<?= ($groups_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="groups_checkbox_delete[]" id="checkbox_delete_<?= $groups_role['id']; ?>" class='groups_checkbox_value' value='<?= ($groups_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <span class="checkbox groups_checkbox_div">
                                                                     <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                    <input data-name='can_view' data-id='<?= $groups_role['id']; ?>' class="col-sm-2 groups_checkbox" type="checkbox" <?= ($groups_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_view_<?= $groups_role['id']; ?>">
                                                                        Can View
                                                                    </label>
                                                                    <input data-name='can_edit' data-id='<?= $groups_role['id']; ?>' class="col-sm-2 groups_checkbox" type="checkbox" <?= ($groups_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_edit_<?= $groups_role['id']; ?>">
                                                                        Can Edit
                                                                    </label>
                                                                    <?php if ($groups_role['page_name'] != "groups_add") { ?>
                                                                        <input data-name='can_delete' data-id='<?= $groups_role['id']; ?>' class="col-sm-2 groups_checkbox" type="checkbox" <?= ($groups_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_delete_<?= $groups_role['id']; ?>">
                                                                            Can Delete
                                                                        </label>
                                                                    <?php } ?>
                                                                    <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                        <input name="opc_all_checkbox_value" id="opc_all_checkbox_value" value='<?= ($roles_details[0]['opc_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="opc_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['opc_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="opc_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($opc_module_data)) {
                                                            foreach ($opc_module_data as $opc_role) {
                                                                if ($opc_role['page_name'] == 'opc_add_server' && in_array('opc_ua_subscribe', $subscription_roles_page_data) || $opc_role['page_name'] == 'opc_bulk_import' && in_array('opc_bulk_import', $subscription_roles_page_data) || $opc_role['page_name'] != 'opc_add_server' && $opc_role['page_name'] != 'opc_bulk_import') {
                                                                    if ($opc_role['page_name'] == 'opc_nodes_to_subscribe' && in_array('opc_ua_subscribe', $subscription_roles_page_data) || $opc_role['page_name'] == 'opc_history_data_nodes' && in_array('opc_ua_subscribe', $subscription_roles_page_data) || $opc_role['page_name'] != 'opc_nodes_to_subscribe' && $opc_role['page_name'] != 'opc_history_data_nodes') {

                                                                        $opc_data_whereConditions = [
                                                                            'role_id' => $roles_details[0]['id'],
                                                                            'page_id' => $opc_role['id'],
                                                                        ];

                                                                        $opc_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $opc_data_whereConditions);

                                                                        if (empty($opc_result)) {
                                                                            $opc_result[0]['can_view'] = 'N';
                                                                            $opc_result[0]['can_edit'] = 'N';
                                                                            $opc_result[0]['can_delete'] = 'N';
                                                                        }
                                                        ?>
                                                                        <div class="col-sm-6 mb-3">
                                                                            <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("opc", "", $opc_role['page_name']))); ?></b></label>
                                                                            <input name="opc_checkbox_id[]" value='<?= $opc_role['id']; ?>' type="hidden">
                                                                            <input name="opc_checkbox_view[]" id="checkbox_view_<?= $opc_role['id']; ?>" type="hidden" class='opc_checkbox_value' value='<?= ($opc_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>'>
                                                                            <input name="opc_checkbox_edit[]" id="checkbox_edit_<?= $opc_role['id']; ?>" type="hidden" class='opc_checkbox_value' value='<?= ($opc_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>'>
                                                                            <input name="opc_checkbox_delete[]" id="checkbox_delete_<?= $opc_role['id']; ?>" type="hidden" class='opc_checkbox_value' value='<?= ($opc_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>'>
                                                                            <span class="checkbox opc_checkbox_div">
                                                                                 <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                                <?php if ($opc_role['page_name'] != "opc_nodes_to_subscribe" && $opc_role['page_name'] != "opc_events_to_subscribe" && $opc_role['page_name'] != "opc_history_data_nodes" && $opc_role['page_name'] != "opc_history_event_nodes") { ?>
                                                                                    <input data-name='can_view' data-id='<?= $opc_role['id']; ?>' class="col-sm-2 opc_checkbox" type="checkbox" <?= ($opc_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                                    <label for="checkbox_view_<?= $opc_role['id']; ?>">
                                                                                        Can View
                                                                                    </label>
                                                                                <?php } ?>
                                                                                <?php if ($opc_role['page_name'] != "opc_add_node") { ?>
                                                                                    <input data-name='can_edit' data-id='<?= $opc_role['id']; ?>' class="col-sm-2 opc_checkbox" type="checkbox" <?= ($opc_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                                    <label for="checkbox_edit_<?= $opc_role['id']; ?>">
                                                                                        Can Edit
                                                                                    </label>
                                                                                    <?php if ($opc_role['page_name'] != "opc_nodes_to_subscribe" && $opc_role['page_name'] != "opc_events_to_subscribe" && $opc_role['page_name'] != "opc_history_data_nodes" && $opc_role['page_name'] != "opc_history_event_nodes" && $opc_role['page_name'] != "opc_add_server" && $opc_role['page_name'] != "opc_client_bcp" && $opc_role['page_name'] != "opc_bulk_import") { ?>
                                                                                        <input data-name='can_delete' data-id='<?= $opc_role['id']; ?>' class="col-sm-2 opc_checkbox" type="checkbox" <?= ($opc_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                                        <label for="checkbox_delete_<?= $opc_role['id']; ?>">
                                                                                            Can Delete
                                                                                        </label>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                        <input name="mqtt_all_checkbox_value" id="mqtt_all_checkbox_value" value='<?= ($roles_details[0]['mqtt_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="mqtt_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mqtt_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="mqtt_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($mqtt_module_data)) {
                                                            foreach ($mqtt_module_data as $mqtt_role) {
                                                                if ($mqtt_role['page_name'] == 'mqtt_bulk_import' && in_array('mqtt_bulk_import', $subscription_roles_page_data) ||  $mqtt_role['page_name'] != 'mqtt_bulk_import') {

                                                                    $mqtt_data_whereConditions = [
                                                                        'role_id' => $roles_details[0]['id'],
                                                                        'page_id' => $mqtt_role['id'],
                                                                    ];

                                                                    $mqtt_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mqtt_data_whereConditions);

                                                                    if (empty($mqtt_result)) {
                                                                        $mqtt_result[0]['can_view'] = 'N';
                                                                        $mqtt_result[0]['can_edit'] = 'N';
                                                                        $mqtt_result[0]['can_delete'] = 'N';
                                                                    }
                                                        ?>
                                                                    <div class="col-sm-6 mb-3">
                                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("mqtt", "", $mqtt_role['page_name']))); ?></b></label>
                                                                        <input name="mqtt_checkbox_id[]" value='<?= $mqtt_role['id']; ?>' type="hidden">
                                                                        <input name="mqtt_checkbox_view[]" id="checkbox_view_<?= $mqtt_role['id']; ?>" class='mqtt_checkbox_value' value='<?= ($mqtt_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                        <input name="mqtt_checkbox_edit[]" id="checkbox_edit_<?= $mqtt_role['id']; ?>" class='mqtt_checkbox_value' value='<?= ($mqtt_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                        <input name="mqtt_checkbox_delete[]" id="checkbox_delete_<?= $mqtt_role['id']; ?>" class='mqtt_checkbox_value' value='<?= ($mqtt_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                        <span class="checkbox mqtt_checkbox_div">
                                                                             <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                            <input data-name='can_view' data-id='<?= $mqtt_role['id']; ?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?= ($mqtt_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_view_<?= $mqtt_role['id']; ?>">
                                                                                Can View
                                                                            </label>
                                                                            <input data-name='can_edit' data-id='<?= $mqtt_role['id']; ?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?= ($mqtt_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_edit_<?= $mqtt_role['id']; ?>">
                                                                                Can Edit
                                                                            </label>
                                                                            <?php if ($mqtt_role['page_name'] != "mqtt_add_topic" && $mqtt_role['page_name'] != "mqtt_add_node" && $mqtt_role['page_name'] != "mqtt_bulk_import") { ?>
                                                                                <input data-name='can_delete' data-id='<?= $mqtt_role['id']; ?>' class="col-sm-2 mqtt_checkbox" type="checkbox" <?= ($mqtt_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                                <label for="checkbox_delete_<?= $mqtt_role['id']; ?>">
                                                                                    Can Delete
                                                                                </label>
                                                                            <?php } ?>
                                                                            <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                        <input name="http_all_checkbox_value" id="http_all_checkbox_value" value='<?= ($roles_details[0]['http_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="http_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['http_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="http_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($http_module_data)) {
                                                            foreach ($http_module_data as $http_role) {
                                                                if ($http_role['page_name'] == 'http(s)_bulk_import' && in_array('https_bulk_import', $subscription_roles_page_data) ||  $http_role['page_name'] != 'http(s)_bulk_import') {

                                                                    $http_data_whereConditions = [
                                                                        'role_id' => $roles_details[0]['id'],
                                                                        'page_id' => $http_role['id'],
                                                                    ];

                                                                    $http_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $http_data_whereConditions);

                                                                    if (empty($http_result)) {
                                                                        $http_result[0]['can_view'] = 'N';
                                                                        $http_result[0]['can_edit'] = 'N';
                                                                        $http_result[0]['can_delete'] = 'N';
                                                                    }
                                                        ?>
                                                                    <div class="col-sm-6 mb-3">
                                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("http(s)", "", $http_role['page_name']))); ?></b></label>
                                                                        <input name="http_checkbox_id[]" value='<?= $http_role['id']; ?>' type="hidden">
                                                                        <input name="http_checkbox_view[]" id="checkbox_view_<?= $http_role['id']; ?>" type="hidden" class='http_checkbox_value' value='<?= ($http_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>'>
                                                                        <input name="http_checkbox_edit[]" id="checkbox_edit_<?= $http_role['id']; ?>" type="hidden" class='http_checkbox_value' value='<?= ($http_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>'>
                                                                        <input name="http_checkbox_delete[]" id="checkbox_delete_<?= $http_role['id']; ?>" type="hidden" class='http_checkbox_value' value='<?= ($http_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>'>
                                                                        <span class="checkbox http_checkbox_div">
                                                                             <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                            <input data-name='can_view' data-id='<?= $http_role['id']; ?>' class="col-sm-2 http_checkbox" type="checkbox" <?= ($http_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_view_<?= $http_role['id']; ?>">
                                                                                Can View
                                                                            </label>
                                                                            <input data-name='can_edit' data-id='<?= $http_role['id']; ?>' class="col-sm-2 http_checkbox" type="checkbox" <?= ($http_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_edit_<?= $http_role['id']; ?>">
                                                                                Can Edit
                                                                            </label>
                                                                            <?php if ($http_role['page_name'] != "http(s)_add_server" && $http_role['page_name'] != "http(s)_add_node" && $http_role['page_name'] != "http(s)_bulk_import") { ?>
                                                                                <input data-name='can_delete' data-id='<?= $http_role['id']; ?>' class="col-sm-2 http_checkbox" type="checkbox" <?= ($http_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                                <label for="checkbox_delete_<?= $http_role['id']; ?>">
                                                                                    Can Delete
                                                                                </label>
                                                                            <?php } ?>
                                                                            <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                    <input name="tag_all_checkbox_value" id="tag_all_checkbox_value" value='<?= ($roles_details[0]['tag_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                    <span class="checkbox">
                                                        <input id="tag_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['tag_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                        <label for="tag_all_checkbox">
                                                            Select all pages
                                                        </label>
                                                    </span>
                                                </h5>

                                                <div class="form-group row">
                                                    <?php if (!empty($tag_module_data)) {
                                                        foreach ($tag_module_data as $tag_role) {
                                                            if ($tag_role['page_name'] == 'historian_bulk_import' && in_array('historian_bulk_import', $subscription_roles_page_data) ||  $tag_role['page_name'] != 'historian_bulk_import') {

                                                                $tag_data_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $tag_role['id'],
                                                                ];

                                                                $tag_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $tag_data_whereConditions);

                                                                if (empty($tag_result)) {
                                                                    $tag_result[0]['can_view'] = 'N';
                                                                    $tag_result[0]['can_edit'] = 'N';
                                                                    $tag_result[0]['can_delete'] = 'N';
                                                                }
                                                    ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("historian", "", $tag_role['page_name']))); ?></b></label>
                                                                    <input name="tag_checkbox_id[]" value='<?= $tag_role['id']; ?>' type="hidden">
                                                                    <input name="tag_checkbox_view[]" id="checkbox_view_<?= $tag_role['id']; ?>" class='tag_checkbox_value' value='<?= ($tag_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="tag_checkbox_edit[]" id="checkbox_edit_<?= $tag_role['id']; ?>" class='tag_checkbox_value' value='<?= ($tag_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="tag_checkbox_delete[]" id="checkbox_delete_<?= $tag_role['id']; ?>" class='tag_checkbox_value' value='<?= ($tag_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox tag_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $tag_role['id']; ?>' class="col-sm-2 tag_checkbox" type="checkbox" <?= ($tag_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $tag_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $tag_role['id']; ?>' class="col-sm-2 tag_checkbox" type="checkbox" <?= ($tag_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $tag_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <?php if ($tag_role['page_name'] != "historian_create_table" && $tag_role['page_name'] != "historian_bulk_import") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $tag_role['id']; ?>' class="col-sm-2 tag_checkbox" type="checkbox" <?= ($tag_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $tag_role['id']; ?>">
                                                                                Can Delete
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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

                                            <!-- Aggregation Role Code Start -->
                                            <?php if (in_array('tag_data_aggregation', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Data Aggregation</b>
                                                        <input name="aggregation_all_checkbox_value" id="aggregation_all_checkbox_value" value='<?= ($roles_details[0]['data_aggregation_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="aggregation_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['data_aggregation_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="aggregation_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($data_aggregation_module_data)) {
                                                            foreach ($data_aggregation_module_data as $data_aggregation) {

                                                                $aggregation_data_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $data_aggregation['id'],
                                                                ];

                                                                $aggregation_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $aggregation_data_whereConditions);

                                                                if (empty($aggregation_result)) {
                                                                    $aggregation_result[0]['can_view'] = 'N';
                                                                    $aggregation_result[0]['can_edit'] = 'N';
                                                                    $aggregation_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <?php if ($data_aggregation['page_name'] == 'aggregation_add') { ?>
                                                                        <label class="col-sm-3 font-orange"><b>ADD</b></label>
                                                                    <?php } else if ($data_aggregation['page_name'] == 'aggregation_search_&_edit') { ?>
                                                                        <label class="col-sm-3 font-orange"><b>SEARCH & EDIT</b></label>
                                                                    <?php } ?>
                                                                    <input name="aggregation_checkbox_id[]" value='<?= $data_aggregation['id']; ?>' type="hidden">
                                                                    <input name="aggregation_checkbox_view[]" id="checkbox_view_<?= $data_aggregation['id']; ?>" class='aggregation_checkbox_value' value='<?= ($aggregation_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="aggregation_checkbox_edit[]" id="checkbox_edit_<?= $data_aggregation['id']; ?>" class='aggregation_checkbox_value' value='<?= ($aggregation_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="aggregation_checkbox_delete[]" id="checkbox_delete_<?= $data_aggregation['id']; ?>" class='aggregation_checkbox_value' value='<?= ($aggregation_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox aggregation_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $data_aggregation['id']; ?>' class="col-sm-2 aggregation_checkbox" type="checkbox" <?= ($aggregation_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $data_aggregation['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $data_aggregation['id']; ?>' class="col-sm-2 aggregation_checkbox" type="checkbox" <?= ($aggregation_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $data_aggregation['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <?php if ($data_aggregation['page_name'] != "aggregation_add") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $data_aggregation['id']; ?>' class="col-sm-2 aggregation_checkbox" type="checkbox" <?= ($aggregation_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $data_aggregation['id']; ?>">
                                                                                Can Delete
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- Aggregation Role Code End -->

                                            <!-- Bulk Import List View Role Code Start -->
                                            <?php if (in_array('opc_bulk_import', $subscription_roles_page_data) || in_array('mqtt_bulk_import', $subscription_roles_page_data) || in_array('https_bulk_import', $subscription_roles_page_data) || in_array('historian_bulk_import', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Bulk Import Status</b>
                                                        <input name="bulk_all_checkbox_value" id="bulk_all_checkbox_value" value='<?= ($roles_details[0]['bulk_import_status_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="bulk_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['bulk_import_status_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="bulk_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($bulk_import_list_module_data)) {
                                                            foreach ($bulk_import_list_module_data as $bulk_list_role) {
                                                                $bulk_data_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $bulk_list_role['id'],
                                                                ];

                                                                $bulk_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $bulk_data_whereConditions);

                                                                if (empty($bulk_result)) {
                                                                    $bulk_result[0]['can_view'] = 'N';
                                                                    $bulk_result[0]['can_edit'] = 'N';
                                                                    $bulk_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", $bulk_list_role['page_name'])); ?></b></label>
                                                                    <input name="bulk_checkbox_id[]" value='<?= $bulk_list_role['id']; ?>' type="hidden">
                                                                    <input name="bulk_checkbox_view[]" id="checkbox_view_<?= $bulk_list_role['id']; ?>" class='bulk_checkbox_value' value='<?= ($bulk_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="bulk_checkbox_edit[]" id="checkbox_edit_<?= $bulk_list_role['id']; ?>" class='bulk_checkbox_value' value='<?= ($bulk_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="bulk_checkbox_delete[]" id="checkbox_delete_<?= $bulk_list_role['id']; ?>" class='bulk_checkbox_value' value='<?= ($bulk_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox bulk_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $bulk_list_role['id']; ?>' class="col-sm-2 bulk_checkbox" type="checkbox" <?= ($bulk_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $bulk_list_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $bulk_list_role['id']; ?>' class="col-sm-2 bulk_checkbox" type="checkbox" <?= ($bulk_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $bulk_list_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <input data-name='can_delete' data-id='<?= $bulk_list_role['id']; ?>' class="col-sm-2 bulk_checkbox" type="checkbox" <?= ($bulk_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_delete_<?= $bulk_list_role['id']; ?>">
                                                                            Can Delete
                                                                        </label>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                        <input name="dashboard_all_checkbox_value" id="dashboard_all_checkbox_value" value='<?= ($roles_details[0]['dashboard_status_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="dashboard_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['dashboard_status_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="dashboard_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($dashboard_module_data)) {
                                                            foreach ($dashboard_module_data as $dashboard_role) {
                                                                $dashboard_data_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $dashboard_role['id'],
                                                                ];

                                                                $dashboard_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $dashboard_data_whereConditions);

                                                                if (empty($dashboard_result)) {
                                                                    $dashboard_result[0]['can_view'] = 'N';
                                                                    $dashboard_result[0]['can_edit'] = 'N';
                                                                    $dashboard_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", $dashboard_role['page_name'])); ?></b></label>
                                                                    <input name="dashboard_checkbox_id[]" value='<?= $dashboard_role['id']; ?>' type="hidden">
                                                                    <input name="dashboard_checkbox_view[]" id="checkbox_view_<?= $dashboard_role['id']; ?>" class='dashboard_checkbox_value' value='<?= ($dashboard_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="dashboard_checkbox_edit[]" id="checkbox_edit_<?= $dashboard_role['id']; ?>" class='dashboard_checkbox_value' value='<?= ($dashboard_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="dashboard_checkbox_delete[]" id="checkbox_delete_<?= $dashboard_role['id']; ?>" class='dashboard_checkbox_value' value='<?= ($dashboard_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox dashboard_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $dashboard_role['id']; ?>' class="col-sm-2 dashboard_checkbox" type="checkbox" <?= ($dashboard_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $dashboard_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $dashboard_role['id']; ?>' class="col-sm-2 dashboard_checkbox" type="checkbox" <?= ($dashboard_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $dashboard_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <input data-name='can_delete' data-id='<?= $dashboard_role['id']; ?>' class="col-sm-2 dashboard_checkbox" type="checkbox" <?= ($dashboard_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_delete_<?= $dashboard_role['id']; ?>">
                                                                            Can Delete
                                                                        </label>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                        <input name="reports_all_checkbox_value" id="reports_all_checkbox_value" value='<?= ($roles_details[0]['reports_status_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="reports_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['reports_status_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="reports_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($reports_module_data)) {
                                                            foreach ($reports_module_data as $reports_role) {
                                                                $reports_data_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $reports_role['id'],
                                                                ];

                                                                $reports_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $reports_data_whereConditions);

                                                                if (empty($reports_result)) {
                                                                    $reports_result[0]['can_view'] = 'N';
                                                                    $reports_result[0]['can_edit'] = 'N';
                                                                    $reports_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", $reports_role['page_name'])); ?></b></label>
                                                                    <input name="reports_checkbox_id[]" value='<?= $reports_role['id']; ?>' type="hidden">
                                                                    <input name="reports_checkbox_view[]" id="checkbox_view_<?= $reports_role['id']; ?>" class='reports_checkbox_value' value='<?= ($reports_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="reports_checkbox_edit[]" id="checkbox_edit_<?= $reports_role['id']; ?>" class='reports_checkbox_value' value='<?= ($reports_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="reports_checkbox_delete[]" id="checkbox_delete_<?= $reports_role['id']; ?>" class='reports_checkbox_value' value='<?= ($reports_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox reports_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $reports_role['id']; ?>' class="col-sm-2 reports_checkbox" type="checkbox" <?= ($reports_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $reports_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $reports_role['id']; ?>' class="col-sm-2 reports_checkbox" type="checkbox" <?= ($reports_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $reports_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <input data-name='can_delete' data-id='<?= $reports_role['id']; ?>' class="col-sm-2 reports_checkbox" type="checkbox" <?= ($reports_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_delete_<?= $reports_role['id']; ?>">
                                                                            Can Delete
                                                                        </label>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                        <input name="notification_all_checkbox_value" id="notification_all_checkbox_value" value='<?= ($roles_details[0]['notify_all_checkbox_value'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="notification_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['notify_all_checkbox_value'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="notification_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($notification_data)) {
                                                            foreach ($notification_data as $notification) {
                                                                if ($notification['page_name'] == 'notification_bulk_import' && in_array('parameter_bulk_import', $subscription_roles_page_data) ||  $notification['page_name'] != 'notification_bulk_import') {

                                                                    $notification_data_whereConditions = [
                                                                        'role_id' => $roles_details[0]['id'],
                                                                        'page_id' => $notification['id'],
                                                                    ];

                                                                    $notification_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $notification_data_whereConditions);

                                                                    if (empty($notification_result)) {
                                                                        $notification_result[0]['can_view'] = 'N';
                                                                        $notification_result[0]['can_edit'] = 'N';
                                                                        $notification_result[0]['can_delete'] = 'N';
                                                                    }

                                                                    if ($notification['page_name'] == 'notification_group_list') {
                                                                        $notify_page_name = 'group_list';
                                                                    } else if ($notification['page_name'] == 'notification_user_list') {
                                                                        $notify_page_name = 'user_list';
                                                                    } else if ($notification['page_name'] == 'notification_user_role') {
                                                                        $notify_page_name = 'user_roles';
                                                                    } else if ($notification['page_name'] == 'notification_template_list') {
                                                                        $notify_page_name = 'template_list';
                                                                    } else if ($notification['page_name'] == 'notification_trigger_tag_configuration') {
                                                                        $notify_page_name = 'trigger_tag';
                                                                    } else if ($notification['page_name'] == 'notification_configuration') {
                                                                        $notify_page_name = 'notification';
                                                                    } else if ($notification['page_name'] == 'notification_bulk_import') {
                                                                        $notify_page_name = 'bulk_import';
                                                                    } else if ($notification['page_name'] == 'notification_uom') {
                                                                        $notify_page_name = 'uom';
                                                                    } else if ($notification['page_name'] == 'notification_alert_notification') {
                                                                        $notify_page_name = 'alert_notification';
                                                                    }
                                                        ?>
                                                                    <div class="col-sm-6 mb-3">
                                                                        <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", $notify_page_name)); ?></b></label>
                                                                        <input name="notification_checkbox_id[]" value='<?= $notification['id']; ?>' type="hidden">
                                                                        <input name="notification_checkbox_view[]" id="checkbox_view_<?= $notification['id']; ?>" class='notification_checkbox_value' value='<?= ($notification_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                        <input name="notification_checkbox_edit[]" id="checkbox_edit_<?= $notification['id']; ?>" class='notification_checkbox_value' value='<?= ($notification_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                        <input name="notification_checkbox_delete[]" id="checkbox_delete_<?= $notification['id']; ?>" class='notification_checkbox_value' value='<?= ($notification_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                        <span class="checkbox notification_checkbox_div">
                                                                             <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                            <?php if ($notification['page_name'] != 'notification_user_role') {  ?>
                                                                                <input data-name='can_view' data-id='<?= $notification['id']; ?>' class="col-sm-2 notification_checkbox" type="checkbox" <?= ($notification_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                                <label for="checkbox_view_<?= $notification['id']; ?>">
                                                                                    Can View
                                                                                </label>
                                                                            <?php } ?>
                                                                            <input data-name='can_edit' data-id='<?= $notification['id']; ?>' class="col-sm-2 notification_checkbox" type="checkbox" <?= ($notification_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_edit_<?= $notification['id']; ?>">
                                                                                Can Edit
                                                                            </label>
                                                                            <?php if ($notification['page_name'] != 'notification_user_role' && $notification['page_name'] != 'notification_trigger_tag_configuration' && $notification['page_name'] != 'notification_alert_notification') { ?>
                                                                                <input data-name='can_delete' data-id='<?= $notification['id']; ?>' class="col-sm-2 notification_checkbox" type="checkbox" <?= ($notification_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                                <label for="checkbox_delete_<?= $notification['id']; ?>">
                                                                                    Can Delete
                                                                                </label>
                                                                            <?php } ?>
                                                                            <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
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
                                                    <input name="subscription_all_checkbox_value" id="subscription_all_checkbox_value" value='<?= ($roles_details[0]['subscription_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                    <span class="checkbox">
                                                        <input id="subscription_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['subscription_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                        <label for="subscription_all_checkbox">
                                                            Select all pages
                                                        </label>
                                                    </span>
                                                </h5>

                                                <div class="form-group row">
                                                    <?php if (!empty($subscription_module_data)) {
                                                        foreach ($subscription_module_data as $subscription_role) {
                                                            $subscription_data_whereConditions = [
                                                                'role_id' => $roles_details[0]['id'],
                                                                'page_id' => $subscription_role['id'],
                                                            ];

                                                            $subscription_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $subscription_data_whereConditions);

                                                            if (empty($subscription_result)) {
                                                                $subscription_result[0]['can_view'] = 'N';
                                                                $subscription_result[0]['can_edit'] = 'N';
                                                                $subscription_result[0]['can_delete'] = 'N';
                                                            }
                                                    ?>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", $subscription_role['page_name'])); ?></b></label>
                                                                <input name="subscription_checkbox_id[]" value='<?= $subscription_role['id']; ?>' type="hidden">
                                                                <input name="subscription_checkbox_view[]" id="checkbox_view_<?= $subscription_role['id']; ?>" class='subscription_checkbox_value' value='<?= ($subscription_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="subscription_checkbox_edit[]" id="checkbox_edit_<?= $subscription_role['id']; ?>" class='subscription_checkbox_value' value='<?= ($subscription_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <input name="subscription_checkbox_delete[]" id="checkbox_delete_<?= $subscription_role['id']; ?>" class='subscription_checkbox_value' value='<?= ($subscription_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                <span class="checkbox subscription_checkbox_div">
                                                                     <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                    <input data-name='can_view' data-id='<?= $subscription_role['id']; ?>' class="col-sm-2 subscription_checkbox" type="checkbox" <?= ($subscription_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_view_<?= $subscription_role['id']; ?>">
                                                                        Can View
                                                                    </label>
                                                                    <input data-name='can_edit' data-id='<?= $subscription_role['id']; ?>' class="col-sm-2 subscription_checkbox" type="checkbox" <?= ($subscription_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                    <label for="checkbox_edit_<?= $subscription_role['id']; ?>">
                                                                        Can Edit
                                                                    </label>
                                                                    <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                </span>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <!-- Subscription Role Code End -->

                                            <!-- AI Prediction Role Code Start -->
                                            <?php if (in_array('ai_prediction', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">AI Prediction</b>
                                                        <input name="ai_prediction_all_checkbox_value" id="ai_prediction_all_checkbox_value" value='<?= ($roles_details[0]['ai_prediction_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="ai_prediction_all_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['ai_prediction_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="ai_prediction_all_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($ai_prediction_module_data)) {
                                                            foreach ($ai_prediction_module_data as $ai_prediction_role) {
                                                                $ai_prediction_data_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $ai_prediction_role['id'],
                                                                ];

                                                                $ai_prediction_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $ai_prediction_data_whereConditions);

                                                                if (empty($ai_prediction_result)) {
                                                                    $ai_prediction_result[0]['can_view'] = 'N';
                                                                    $ai_prediction_result[0]['can_edit'] = 'N';
                                                                    $ai_prediction_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("ai_prediction", "", $ai_prediction_role['page_name']))); ?></b></label>
                                                                    <input name="ai_prediction_checkbox_id[]" value='<?= $ai_prediction_role['id']; ?>' type="hidden">
                                                                    <input name="ai_prediction_checkbox_view[]" id="checkbox_view_<?= $ai_prediction_role['id']; ?>" class='ai_prediction_checkbox_value' value='<?= ($ai_prediction_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="ai_prediction_checkbox_edit[]" id="checkbox_edit_<?= $ai_prediction_role['id']; ?>" class='ai_prediction_checkbox_value' value='<?= ($ai_prediction_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="ai_prediction_checkbox_delete[]" id="checkbox_delete_<?= $ai_prediction_role['id']; ?>" class='ai_prediction_checkbox_value' value='<?= ($ai_prediction_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox ai_prediction_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $ai_prediction_role['id']; ?>' class="col-sm-2 ai_prediction_checkbox" type="checkbox" <?= ($ai_prediction_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $ai_prediction_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $ai_prediction_role['id']; ?>' class="col-sm-2 ai_prediction_checkbox" type="checkbox" <?= ($ai_prediction_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $ai_prediction_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <?php if ($ai_prediction_role['page_name'] == 'ai_prediction_search_&_edit') { ?>
                                                                            <input data-name='can_delete' data-id='<?= $ai_prediction_role['id']; ?>' class="col-sm-2 ai_prediction_checkbox" type="checkbox" <?= ($ai_prediction_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $ai_prediction_role['id']; ?>">
                                                                                Can Delete
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- AI Prediction Role Code End -->

                                            <!-- model builder code starts  -->
                                            <!-- dataroot code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <h3 class="col-lg-12 mb-3">Model Builder</h3>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Data Root</b>
                                                        <input name="model_builder_all_dataroot_checkbox_value" id="model_builder_all_dataroot_checkbox_value" value='<?= ($roles_details[0]['mb_dataroot_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_dataroot_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_dataroot_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_dataroot_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_dataroot_page_data)) {
                                                            foreach ($model_builder_dataroot_page_data as $model_builder_dataroot_role) {
                                                                $mb_dataroot_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_dataroot_role['id'],
                                                                ];

                                                                $mb_dataroot_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_dataroot_whereConditions);

                                                                if (empty($mb_dataroot_result)) {
                                                                    $mb_dataroot_result[0]['can_view'] = 'N';
                                                                    $mb_dataroot_result[0]['can_edit'] = 'N';
                                                                    $mb_dataroot_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange"><b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $model_builder_dataroot_role['page_name']))); ?></b></label>
                                                                    <input name="model_builder_dataroot_checkbox_id[]" value='<?= $model_builder_dataroot_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_dataroot_checkbox_view[]" id="checkbox_view_<?= $model_builder_dataroot_role['id']; ?>" class='model_builder_dataroot_checkbox_value' value='<?= ($mb_dataroot_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_dataroot_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_dataroot_role['id']; ?>" class='model_builder_dataroot_checkbox_value' value='<?= ($mb_dataroot_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_dataroot_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_dataroot_role['id']; ?>" class='model_builder_dataroot_checkbox_value' value='<?= ($mb_dataroot_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox model_builder_dataroot_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_dataroot_role['id']; ?>' class="col-sm-2 model_builder_dataroot_checkbox" type="checkbox" <?= ($mb_dataroot_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_dataroot_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $model_builder_dataroot_role['id']; ?>' class="col-sm-2 model_builder_dataroot_checkbox" type="checkbox" <?= ($mb_dataroot_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_dataroot_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <?php if ($model_builder_dataroot_role['page_name'] == "model_builder_dataroot_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_dataroot_role['id']; ?>' class="col-sm-2 model_builder_dataroot_checkbox" type="checkbox" <?= ($mb_dataroot_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_dataroot_role['id']; ?>">
                                                                                Can Delete
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- dataroot code ends here -->

                                            <!-- project code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <!-- <h3 class="col-lg-12 mb-3">Model Builder</h3> -->
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0"><b class="font-grey" style="font-size: 18px;">Project</b>
                                                        <input name="model_builder_all_project_checkbox_value" id="model_builder_all_project_checkbox_value" value='<?= ($roles_details[0]['mb_project_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_project_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_project_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_project_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_project_page_data)) {
                                                            foreach ($model_builder_project_page_data as $model_builder_project_role) {
                                                                $mb_project_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_project_role['id'],
                                                                ];

                                                                $mb_project_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_project_whereConditions);

                                                                if (empty($mb_project_result)) {
                                                                    $mb_project_result[0]['can_view'] = 'N';
                                                                    $mb_project_result[0]['can_edit'] = 'N';
                                                                    $mb_project_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $model_builder_project_role['page_name']))); ?></b>
                                                                    </label>
                                                                    <input name="model_builder_project_checkbox_id[]" value='<?= $model_builder_project_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_project_checkbox_view[]" id="checkbox_view_<?= $model_builder_project_role['id']; ?>" class='model_builder_project_checkbox_value' value='<?= ($mb_project_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_project_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_project_role['id']; ?>" class='model_builder_project_checkbox_value' value='<?= ($mb_project_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_project_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_project_role['id']; ?>" class='model_builder_project_checkbox_value' value='<?= ($mb_project_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <span class="checkbox model_builder_project_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_project_role['id']; ?>' class="col-sm-2 model_builder_project_checkbox" type="checkbox" <?= ($mb_project_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_project_role['id']; ?>">
                                                                            Can View
                                                                        </label>
                                                                        <input data-name='can_edit' data-id='<?= $model_builder_project_role['id']; ?>' class="col-sm-2 model_builder_project_checkbox" type="checkbox" <?= ($mb_project_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_project_role['id']; ?>">
                                                                            Can Edit
                                                                        </label>
                                                                        <?php if ($model_builder_project_role['page_name'] == "model_builder_project_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_project_role['id']; ?>' class="col-sm-2 model_builder_project_checkbox" type="checkbox" <?= ($mb_project_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_project_role['id']; ?>">
                                                                                Can Delete
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- project code ends here -->

                                            <!-- node code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Node</b>
                                                        <input name="model_builder_all_node_checkbox_value" id="model_builder_all_node_checkbox_value" value='<?= ($roles_details[0]['mb_node_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_node_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_node_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_node_checkbox">Select all pages</label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_node_page_data)) {
                                                            foreach ($model_builder_node_page_data as $model_builder_node_role) {
                                                                $mb_node_whereConditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_node_role['id'],
                                                                ];

                                                                $mb_node_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_node_whereConditions);

                                                                if (empty($mb_node_result)) {
                                                                    $mb_node_result[0]['can_view'] = 'N';
                                                                    $mb_node_result[0]['can_edit'] = 'N';
                                                                    $mb_node_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", str_replace("(s)", "", $model_builder_node_role['page_name'])))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_node_checkbox_id[]" value='<?= $model_builder_node_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_node_checkbox_view[]" id="checkbox_view_<?= $model_builder_node_role['id']; ?>" class='model_builder_node_checkbox_value' value='<?= ($mb_node_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_node_role['id']; ?>" class='model_builder_node_checkbox_value' value='<?= ($mb_node_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_node_role['id']; ?>" class='model_builder_node_checkbox_value' value='<?= ($mb_node_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_node_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_node_role['id']; ?>' class="col-sm-2 model_builder_node_checkbox" type="checkbox" <?= ($mb_node_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_node_role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $model_builder_node_role['id']; ?>' class="col-sm-2 model_builder_node_checkbox" type="checkbox" <?= ($mb_node_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_node_role['id']; ?>">Can Edit</label>

                                                                        <?php if ($model_builder_node_role['page_name'] == "model_builder_node(s)_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_node_role['id']; ?>' class="col-sm-2 model_builder_node_checkbox" type="checkbox" <?= ($mb_node_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_node_role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- node code ends here -->

                                            <!-- node parameter starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Node Parameter</b>
                                                        <input name="model_builder_all_node_parameter_checkbox_value" id="model_builder_all_node_parameter_checkbox_value" value='<?= ($roles_details[0]['mb_node_parameter_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_node_parameter_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_node_parameter_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_node_parameter_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_node_parameter_data)) {
                                                            foreach ($model_builder_node_parameter_data as $model_builder_node_parameter_role) {
                                                                $mb_node_param_conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_node_parameter_role['id'],
                                                                ];

                                                                $mb_node_param_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_node_param_conditions);

                                                                if (empty($mb_node_param_result)) {
                                                                    $mb_node_param_result[0]['can_view'] = 'N';
                                                                    $mb_node_param_result[0]['can_edit'] = 'N';
                                                                    $mb_node_param_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $model_builder_node_parameter_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_node_parameter_checkbox_id[]" value='<?= $model_builder_node_parameter_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_node_parameter_checkbox_view[]" id="checkbox_view_<?= $model_builder_node_parameter_role['id']; ?>" class='model_builder_node_parameter_checkbox_value' value='<?= ($mb_node_param_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_parameter_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_node_parameter_role['id']; ?>" class='model_builder_node_parameter_checkbox_value' value='<?= ($mb_node_param_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_parameter_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_node_parameter_role['id']; ?>" class='model_builder_node_parameter_checkbox_value' value='<?= ($mb_node_param_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_node_parameter_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_node_parameter_role['id']; ?>' class="col-sm-2 model_builder_node_parameter_checkbox" type="checkbox" <?= ($mb_node_param_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_node_parameter_role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $model_builder_node_parameter_role['id']; ?>' class="col-sm-2 model_builder_node_parameter_checkbox" type="checkbox" <?= ($mb_node_param_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_node_parameter_role['id']; ?>">Can Edit</label>

                                                                        <?php if ($model_builder_node_parameter_role['page_name'] == "model_builder_node_parameter_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_node_parameter_role['id']; ?>' class="col-sm-2 model_builder_node_parameter_checkbox" type="checkbox" <?= ($mb_node_param_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_node_parameter_role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- node parameter starts here -->

                                            <!-- node calculation starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Node Calculation</b>
                                                        <input name="model_builder_all_node_calculation_checkbox_value" id="model_builder_all_node_calculation_checkbox_value" value='<?= ($roles_details[0]['mb_node_calculation_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_node_calculation_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_node_calculation_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_node_calculation_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_node_calculation_data)) {
                                                            foreach ($model_builder_node_calculation_data as $model_builder_node_calculation_role) {
                                                                $mb_node_calc_conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_node_calculation_role['id'],
                                                                ];

                                                                $mb_node_calc_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_node_calc_conditions);

                                                                if (empty($mb_node_calc_result)) {
                                                                    $mb_node_calc_result[0]['can_view'] = 'N';
                                                                    $mb_node_calc_result[0]['can_edit'] = 'N';
                                                                    $mb_node_calc_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $model_builder_node_calculation_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_node_calculation_checkbox_id[]" value='<?= $model_builder_node_calculation_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_node_calculation_checkbox_view[]" id="checkbox_view_<?= $model_builder_node_calculation_role['id']; ?>" class='model_builder_node_calculation_checkbox_value' value='<?= ($mb_node_calc_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_calculation_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_node_calculation_role['id']; ?>" class='model_builder_node_calculation_checkbox_value' value='<?= ($mb_node_calc_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_calculation_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_node_calculation_role['id']; ?>" class='model_builder_node_calculation_checkbox_value' value='<?= ($mb_node_calc_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_node_calculation_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_node_calculation_role['id']; ?>' class="col-sm-2 model_builder_node_calculation_checkbox" type="checkbox" <?= ($mb_node_calc_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_node_calculation_role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $model_builder_node_calculation_role['id']; ?>' class="col-sm-2 model_builder_node_calculation_checkbox" type="checkbox" <?= ($mb_node_calc_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_node_calculation_role['id']; ?>">Can Edit</label>

                                                                        <?php if ($model_builder_node_calculation_role['page_name'] == "model_builder_node_calculation_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_node_calculation_role['id']; ?>' class="col-sm-2 model_builder_node_calculation_checkbox" type="checkbox" <?= ($mb_node_calc_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_node_calculation_role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- node calculation ends here -->

                                            <!-- node expression starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Node Expression</b>
                                                        <input name="model_builder_all_node_expression_checkbox_value" id="model_builder_all_node_expression_checkbox_value" value='<?= ($roles_details[0]['mb_node_expression_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_node_expression_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_node_expression_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_node_expression_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_node_expression_data)) {
                                                            foreach ($model_builder_node_expression_data as $model_builder_node_expression_role) {
                                                                $mb_node_expr_conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_node_expression_role['id'],
                                                                ];

                                                                $mb_node_expr_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_node_expr_conditions);

                                                                if (empty($mb_node_expr_result)) {
                                                                    $mb_node_expr_result[0]['can_view'] = 'N';
                                                                    $mb_node_expr_result[0]['can_edit'] = 'N';
                                                                    $mb_node_expr_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $model_builder_node_expression_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_node_expression_checkbox_id[]" value='<?= $model_builder_node_expression_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_node_expression_checkbox_view[]" id="checkbox_view_<?= $model_builder_node_expression_role['id']; ?>" class='model_builder_node_expression_checkbox_value' value='<?= ($mb_node_expr_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_expression_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_node_expression_role['id']; ?>" class='model_builder_node_expression_checkbox_value' value='<?= ($mb_node_expr_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_node_expression_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_node_expression_role['id']; ?>" class='model_builder_node_expression_checkbox_value' value='<?= ($mb_node_expr_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_node_expression_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_node_expression_role['id']; ?>' class="col-sm-2 model_builder_node_expression_checkbox" type="checkbox" <?= ($mb_node_expr_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_node_expression_role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $model_builder_node_expression_role['id']; ?>' class="col-sm-2 model_builder_node_expression_checkbox" type="checkbox" <?= ($mb_node_expr_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_node_expression_role['id']; ?>">Can Edit</label>

                                                                        <?php if ($model_builder_node_expression_role['page_name'] == "model_builder_node_expression_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_node_expression_role['id']; ?>' class="col-sm-2 model_builder_node_expression_checkbox" type="checkbox" <?= ($mb_node_expr_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_node_expression_role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- node expression ends here -->

                                            <!-- model builder search code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Search</b>
                                                        <input name="model_builder_all_search_checkbox_value" id="model_builder_all_search_checkbox_value" value='<?= ($roles_details[0]['mb_search_all_pages'] == 'Y') ? '1' : '0' ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_search_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_search_all_pages'] == 'Y') ? 'checked' : '' ?>>
                                                            <label for="model_builder_all_search_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_search)) {
                                                            foreach ($model_builder_search as $model_builder_search_role) {
                                                                $mb_search_conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_search_role['id'],
                                                                ];

                                                                $mb_search_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $mb_search_conditions);

                                                                if (empty($mb_search_result)) {
                                                                    $mb_search_result[0]['can_view'] = 'N';
                                                                    $mb_search_result[0]['can_edit'] = 'N';
                                                                    $mb_search_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $model_builder_search_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_search_checkbox_id[]" value='<?= $model_builder_search_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_search_checkbox_view[]" id="checkbox_view_<?= $model_builder_search_role['id']; ?>" class='model_builder_search_checkbox_value' value='<?= ($mb_search_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_search_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_search_role['id']; ?>" class='model_builder_search_checkbox_value' value='<?= ($mb_search_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_search_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_search_role['id']; ?>" class='model_builder_search_checkbox_value' value='<?= ($mb_search_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_search_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_search_role['id']; ?>' class="col-sm-2 model_builder_search_checkbox" type="checkbox" <?= ($mb_search_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_search_role['id']; ?>">Can View</label>

                                                                        <?php if ($model_builder_search_role['page_name'] == "model_builder_search_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_search_role['id']; ?>' class="col-sm-2 model_builder_search_checkbox" type="checkbox" <?= ($mb_search_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_search_role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- model builder search code ends here -->

                                            <!-- template code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Template</b>
                                                        <input name="model_builder_all_template_checkbox_value" id="model_builder_all_template_checkbox_value" value='<?= ($roles_details[0]['mb_template_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_template_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_template_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_template_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_template_data)) {
                                                            foreach ($model_builder_template_data as $model_builder_template_role) {
                                                                $template_conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $model_builder_template_role['id'],
                                                                ];

                                                                $template_result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $template_conditions);

                                                                // Fallback defaults if no permission found
                                                                if (empty($template_result)) {
                                                                    $template_result[0]['can_view'] = 'N';
                                                                    $template_result[0]['can_edit'] = 'N';
                                                                    $template_result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", str_replace("(s)", "", $model_builder_template_role['page_name'])))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_template_checkbox_id[]" value='<?= $model_builder_template_role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_template_checkbox_view[]" id="checkbox_view_<?= $model_builder_template_role['id']; ?>" class='model_builder_template_checkbox_value' value='<?= ($template_result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_checkbox_edit[]" id="checkbox_edit_<?= $model_builder_template_role['id']; ?>" class='model_builder_template_checkbox_value' value='<?= ($template_result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_checkbox_delete[]" id="checkbox_delete_<?= $model_builder_template_role['id']; ?>" class='model_builder_template_checkbox_value' value='<?= ($template_result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_template_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $model_builder_template_role['id']; ?>' class="col-sm-2 model_builder_template_checkbox" type="checkbox" <?= ($template_result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $model_builder_template_role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $model_builder_template_role['id']; ?>' class="col-sm-2 model_builder_template_checkbox" type="checkbox" <?= ($template_result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $model_builder_template_role['id']; ?>">Can Edit</label>

                                                                        <?php if ($model_builder_template_role['page_name'] == "model_builder_template(s)_edit_&_delete.") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $model_builder_template_role['id']; ?>' class="col-sm-2 model_builder_template_checkbox" type="checkbox" <?= ($template_result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $model_builder_template_role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- template code ends here -->

                                            <!-- template parameter code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Template Parameter</b>
                                                        <input name="model_builder_all_template_parameter_checkbox_value" id="model_builder_all_template_parameter_checkbox_value" value='<?= ($roles_details[0]['mb_template_parameter_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_template_parameter_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_template_parameter_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_template_parameter_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_template_parameter_data)) {
                                                            foreach ($model_builder_template_parameter_data as $role) {
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $role['id'],
                                                                ];

                                                                $result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                // Default permissions if not found
                                                                if (empty($result)) {
                                                                    $result[0]['can_view'] = 'N';
                                                                    $result[0]['can_edit'] = 'N';
                                                                    $result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_template_parameter_checkbox_id[]" value='<?= $role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_template_parameter_checkbox_view[]" id="checkbox_view_<?= $role['id']; ?>" class='model_builder_template_parameter_checkbox_value' value='<?= ($result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_parameter_checkbox_edit[]" id="checkbox_edit_<?= $role['id']; ?>" class='model_builder_template_parameter_checkbox_value' value='<?= ($result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_parameter_checkbox_delete[]" id="checkbox_delete_<?= $role['id']; ?>" class='model_builder_template_parameter_checkbox_value' value='<?= ($result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_template_parameter_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_parameter_checkbox" type="checkbox" <?= ($result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_parameter_checkbox" type="checkbox" <?= ($result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $role['id']; ?>">Can Edit</label>

                                                                        <?php if ($role['page_name'] == "model_builder_template_parameter_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_parameter_checkbox" type="checkbox" <?= ($result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- template parameter code ends here -->

                                            <!-- template calculation code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Template Calculation</b>
                                                        <input name="model_builder_all_template_calculation_checkbox_value" id="model_builder_all_template_calculation_checkbox_value" value='<?= ($roles_details[0]['mb_template_calculation_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_template_calculation_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_template_calculation_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_template_calculation_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php if (!empty($model_builder_template_calculation_data)) {
                                                            foreach ($model_builder_template_calculation_data as $role) {
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $role['id'],
                                                                ];

                                                                $result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                if (empty($result)) {
                                                                    $result[0]['can_view'] = 'N';
                                                                    $result[0]['can_edit'] = 'N';
                                                                    $result[0]['can_delete'] = 'N';
                                                                }
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_template_calculation_checkbox_id[]" value='<?= $role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_template_calculation_checkbox_view[]" id="checkbox_view_<?= $role['id']; ?>" class='model_builder_template_calculation_checkbox_value' value='<?= ($result[0]['can_view'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_calculation_checkbox_edit[]" id="checkbox_edit_<?= $role['id']; ?>" class='model_builder_template_calculation_checkbox_value' value='<?= ($result[0]['can_edit'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_calculation_checkbox_delete[]" id="checkbox_delete_<?= $role['id']; ?>" class='model_builder_template_calculation_checkbox_value' value='<?= ($result[0]['can_delete'] == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_template_calculation_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_calculation_checkbox" type="checkbox" <?= ($result[0]['can_view'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_calculation_checkbox" type="checkbox" <?= ($result[0]['can_edit'] == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $role['id']; ?>">Can Edit</label>

                                                                        <?php if ($role['page_name'] == "model_builder_template_calculation_edit_&_del") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_calculation_checkbox" type="checkbox" <?= ($result[0]['can_delete'] == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- template calculation code ends here -->

                                            <!-- template expression -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Template Expression</b>
                                                        <input name="model_builder_all_template_expression_checkbox_value" id="model_builder_all_template_expression_checkbox_value" value='<?= ($roles_details[0]['mb_template_expression_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_template_expression_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_template_expression_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_template_expression_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php
                                                        if (!empty($model_builder_template_expression_page_data)) {
                                                            foreach ($model_builder_template_expression_page_data as $role) {
                                                                // Fetch permission data for this page and role
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $role['id'],
                                                                ];

                                                                $result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                // Default values if not set
                                                                $can_view = $result[0]['can_view'] ?? 'N';
                                                                $can_edit = $result[0]['can_edit'] ?? 'N';
                                                                $can_delete = $result[0]['can_delete'] ?? 'N';
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_template_expression_checkbox_id[]" value='<?= $role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_template_expression_checkbox_view[]" id="checkbox_view_<?= $role['id']; ?>" class='model_builder_template_expression_checkbox_value' value='<?= ($can_view == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_expression_checkbox_edit[]" id="checkbox_edit_<?= $role['id']; ?>" class='model_builder_template_expression_checkbox_value' value='<?= ($can_edit == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_expression_checkbox_delete[]" id="checkbox_delete_<?= $role['id']; ?>" class='model_builder_template_expression_checkbox_value' value='<?= ($can_delete == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_template_expression_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_expression_checkbox" type="checkbox" <?= ($can_view == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $role['id']; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_expression_checkbox" type="checkbox" <?= ($can_edit == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $role['id']; ?>">Can Edit</label>

                                                                        <?php if ($role['page_name'] == "model_builder_tmp_expression_edit_&_del") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_expression_checkbox" type="checkbox" <?= ($can_delete == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $role['id']; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- template expression -->

                                            <!-- template mapped node edit -->
                                             <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Template Mapped Node</b>
                                                        <input name="model_builder_all_template_mapped_node_checkbox_value" id="model_builder_all_template_mapped_node_checkbox_value" value='<?= ($roles_details[0]['mb_template_mapped_node_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_template_mapped_node_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_template_mapped_node_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_template_mapped_node_checkbox">
                                                                Select all pages
                                                            </label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php
                                                        if (!empty($model_builder_template_mapped_node_data)) {
                                                            foreach ($model_builder_template_mapped_node_data as $role) {
                                                                // Fetch permission data for this page and role
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $role['id'],
                                                                ];
                                                            
                                                                $result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit', $conditions);
                                                            
                                                                // Default values if not set
                                                                $can_view = $result[0]['can_view'] ?? 'N';
                                                                $can_edit = $result[0]['can_edit'] ?? 'N';
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $role['page_name']))); ?></b>
                                                                    </label>
                                                            
                                                                    <input name="model_builder_template_mapped_node_checkbox_id[]" value='<?= $role['id']; ?>' type="hidden">
                                                                    <input name="model_builder_template_mapped_node_checkbox_view[]" id="checkbox_view_<?= $role['id']; ?>" class='model_builder_template_mapped_node_checkbox_value' value='<?= ($can_view == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_template_mapped_node_checkbox_edit[]" id="checkbox_edit_<?= $role['id']; ?>" class='model_builder_template_mapped_node_checkbox_value' value='<?= ($can_edit == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                            
                                                                    <span class="checkbox model_builder_template_mapped_node_checkbox_div">
                                                                        <div class="row">
                                                                            <input data-name='can_view' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_mapped_node_checkbox" type="checkbox" <?= ($can_view == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_view_<?= $role['id']; ?>">Can View</label>
                                                            
                                                                            <input data-name='can_edit' data-id='<?= $role['id']; ?>' class="col-sm-2 model_builder_template_mapped_node_checkbox" type="checkbox" <?= ($can_edit == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_edit_<?= $role['id']; ?>">Can Sync</label>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <!-- template mapped node edit -->

                                            <!--model builder tag starts code -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Tag</b>
                                                        <input name="model_builder_all_tag_checkbox_value" id="model_builder_all_tag_checkbox_value" value='<?= ($roles_details[0]['mb_tag_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_tag_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_tag_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_tag_checkbox">Select all pages</label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php
                                                        if (!empty($model_builder_tag_page_data)) {
                                                            foreach ($model_builder_tag_page_data as $tag_role) {
                                                                $page_id = $tag_role['id'];

                                                                // Query role permissions for this page and role
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $page_id
                                                                ];
                                                                $result = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                // Default to 'N' if not found
                                                                $can_view = $result[0]['can_view'] ?? 'N';
                                                                $can_edit = $result[0]['can_edit'] ?? 'N';
                                                                $can_delete = $result[0]['can_delete'] ?? 'N';
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $tag_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <input name="model_builder_tag_checkbox_id[]" value='<?= $page_id; ?>' type="hidden">
                                                                    <input name="model_builder_tag_checkbox_view[]" id="checkbox_view_<?= $page_id; ?>" class='model_builder_tag_checkbox_value' value='<?= ($can_view == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_tag_checkbox_edit[]" id="checkbox_edit_<?= $page_id; ?>" class='model_builder_tag_checkbox_value' value='<?= ($can_edit == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_tag_checkbox_delete[]" id="checkbox_delete_<?= $page_id; ?>" class='model_builder_tag_checkbox_value' value='<?= ($can_delete == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <span class="checkbox model_builder_tag_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_tag_checkbox" type="checkbox" <?= ($can_view == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $page_id; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_tag_checkbox" type="checkbox" <?= ($can_edit == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $page_id; ?>">Can Edit</label>

                                                                        <?php if ($tag_role['page_name'] == "model_builder_tag_add_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_tag_checkbox" type="checkbox" <?= ($can_delete == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $page_id; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!--model builder tag ends code -->

                                            <!-- uom categories -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Uom category</b>
                                                        <input name="model_builder_all_uom_category_checkbox_value" id="model_builder_all_uom_category_checkbox_value" value='<?= ($roles_details[0]['mb_uom_categories_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_uom_category_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_uom_categories_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_uom_category_checkbox">Select all pages</label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php
                                                        if (!empty($model_builder_uom_category_page_data)) {
                                                            foreach ($model_builder_uom_category_page_data as $uom_role) {
                                                                $page_id = $uom_role['id'];

                                                                // Fetch role permissions from the DB
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $page_id
                                                                ];
                                                                $permissions = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                // Extract or default
                                                                $can_view = $permissions[0]['can_view'] ?? 'N';
                                                                $can_edit = $permissions[0]['can_edit'] ?? 'N';
                                                                $can_delete = $permissions[0]['can_delete'] ?? 'N';
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $uom_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <!-- Hidden values -->
                                                                    <input name="model_builder_uom_category_checkbox_id[]" value='<?= $page_id; ?>' type="hidden">
                                                                    <input name="model_builder_uom_category_checkbox_view[]" id="checkbox_view_<?= $page_id; ?>" class='model_builder_uom_category_checkbox_value' value='<?= ($can_view == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_uom_category_checkbox_edit[]" id="checkbox_edit_<?= $page_id; ?>" class='model_builder_uom_category_checkbox_value' value='<?= ($can_edit == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_uom_category_checkbox_delete[]" id="checkbox_delete_<?= $page_id; ?>" class='model_builder_uom_category_checkbox_value' value='<?= ($can_delete == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <!-- Visible checkboxes -->
                                                                      
                                                                    <span class="checkbox model_builder_uom_category_checkbox_div">
                                                                        <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_uom_category_checkbox" type="checkbox" <?= ($can_view == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $page_id; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_uom_category_checkbox" type="checkbox" <?= ($can_edit == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $page_id; ?>">Can Edit</label>

                                                                        <?php if ($uom_role['page_name'] == "model_builder_uom_category_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_uom_category_checkbox" type="checkbox" <?= ($can_delete == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $page_id; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- uom categories -->

                                            <!-- uom conversions -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Uom Conversion</b>
                                                        <input name="model_builder_all_uom_conversions_checkbox_value" id="model_builder_all_uom_conversions_checkbox_value" value='<?= ($roles_details[0]['mb_uom_conversions_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_uom_conversions_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_uom_conversions_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_uom_conversions_checkbox">Select all pages</label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php
                                                        if (!empty($model_builder_uom_conversions_page_data)) {
                                                            foreach ($model_builder_uom_conversions_page_data as $conversion_role) {
                                                                $page_id = $conversion_role['id'];

                                                                // Fetch existing permissions
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $page_id
                                                                ];
                                                                $permissions = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                // Fallbacks for undefined permissions
                                                                $can_view = $permissions[0]['can_view'] ?? 'N';
                                                                $can_edit = $permissions[0]['can_edit'] ?? 'N';
                                                                $can_delete = $permissions[0]['can_delete'] ?? 'N';
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $conversion_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <!-- Hidden permission values -->
                                                                    <input name="model_builder_uom_conversions_checkbox_id[]" value='<?= $page_id; ?>' type="hidden">
                                                                    <input name="model_builder_uom_conversions_checkbox_view[]" id="checkbox_view_<?= $page_id; ?>" class='model_builder_uom_conversions_checkbox_value' value='<?= ($can_view == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_uom_conversions_checkbox_edit[]" id="checkbox_edit_<?= $page_id; ?>" class='model_builder_uom_conversions_checkbox_value' value='<?= ($can_edit == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_uom_conversions_checkbox_delete[]" id="checkbox_delete_<?= $page_id; ?>" class='model_builder_uom_conversions_checkbox_value' value='<?= ($can_delete == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <!-- Visible checkboxes -->
                                                                    <span class="checkbox model_builder_uom_conversions_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_uom_conversions_checkbox" type="checkbox" <?= ($can_view == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $page_id; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_uom_conversions_checkbox" type="checkbox" <?= ($can_edit == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $page_id; ?>">Can Edit</label>

                                                                        <?php if ($conversion_role['page_name'] == "model_builder_uom_conversion_ed_&_de") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_uom_conversions_checkbox" type="checkbox" <?= ($can_delete == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $page_id; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- uom conversions -->

                                            <!-- group code starts here -->
                                            <?php if (in_array('model_builder', $subscription_roles_page_data)) { ?>
                                                <div class="col-lg-12">
                                                    <h5 class="m-b-15 m-t-0">
                                                        <b class="font-grey" style="font-size: 18px;">Group</b>
                                                        <input name="model_builder_all_group_checkbox_value" id="model_builder_all_group_checkbox_value" value='<?= ($roles_details[0]['mb_group_all_pages'] == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                        <span class="checkbox">
                                                            <input id="model_builder_all_group_checkbox" class="form-check-inline" type="checkbox" <?= ($roles_details[0]['mb_group_all_pages'] == 'Y') ? 'checked' : ''; ?>>
                                                            <label for="model_builder_all_group_checkbox">Select all pages</label>
                                                        </span>
                                                    </h5>

                                                    <div class="form-group row">
                                                        <?php
                                                        if (!empty($model_builder_group_page_data)) {
                                                            foreach ($model_builder_group_page_data as $group_role) {
                                                                $page_id = $group_role['id'];

                                                                // Fetch permission data from tbl_role_permissions
                                                                $conditions = [
                                                                    'role_id' => $roles_details[0]['id'],
                                                                    'page_id' => $page_id
                                                                ];
                                                                $permissions = $this->company_role_model->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $conditions);

                                                                // Set fallback defaults
                                                                $can_view = $permissions[0]['can_view'] ?? 'N';
                                                                $can_edit = $permissions[0]['can_edit'] ?? 'N';
                                                                $can_delete = $permissions[0]['can_delete'] ?? 'N';
                                                        ?>
                                                                <div class="col-sm-6 mb-3">
                                                                    <label class="col-sm-3 font-orange">
                                                                        <b><?= strtoupper(str_replace("_", " ", str_replace("model_builder", "", $group_role['page_name']))); ?></b>
                                                                    </label>

                                                                    <!-- Hidden permission fields -->
                                                                    <input name="model_builder_group_checkbox_id[]" value='<?= $page_id; ?>' type="hidden">
                                                                    <input name="model_builder_group_checkbox_view[]" id="checkbox_view_<?= $page_id; ?>" class='model_builder_group_checkbox_value' value='<?= ($can_view == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_group_checkbox_edit[]" id="checkbox_edit_<?= $page_id; ?>" class='model_builder_group_checkbox_value' value='<?= ($can_edit == 'Y') ? '1' : '0'; ?>' type="hidden">
                                                                    <input name="model_builder_group_checkbox_delete[]" id="checkbox_delete_<?= $page_id; ?>" class='model_builder_group_checkbox_value' value='<?= ($can_delete == 'Y') ? '1' : '0'; ?>' type="hidden">

                                                                    <!-- Visible checkboxes -->
                                                                     
                                                                    <span class="checkbox model_builder_group_checkbox_div">
                                                                         <!-- new line -->
                                                                     <div class="row">
                                                                    <!-- new line -->
                                                                        <input data-name='can_view' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_group_checkbox" type="checkbox" <?= ($can_view == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_view_<?= $page_id; ?>">Can View</label>

                                                                        <input data-name='can_edit' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_group_checkbox" type="checkbox" <?= ($can_edit == 'Y') ? 'checked' : ''; ?>>
                                                                        <label for="checkbox_edit_<?= $page_id; ?>">Can Edit</label>

                                                                        <?php if ($group_role['page_name'] == "model_builder_group_edit_&_delete") { ?>
                                                                            <input data-name='can_delete' data-id='<?= $page_id; ?>' class="col-sm-2 model_builder_group_checkbox" type="checkbox" <?= ($can_delete == 'Y') ? 'checked' : ''; ?>>
                                                                            <label for="checkbox_delete_<?= $page_id; ?>">Can Delete</label>
                                                                        <?php } ?>
                                                                        <!-- new line ends-->
                                                                     </div>
                                                                    <!-- new line ends-->
                                                                    </span>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- group code starts here -->
                                            <!-- model builder code starts  -->

                                        </div>
                                        <!--  Setting Role Display Code End -->

                                        <!-- Status Code Start -->
                                        <div class="form-group row d-flex justify-content-center">
                                            <label class="col-sm-2 control-label" for="role_name">Status<span>*</span></label>
                                            <div class="col-sm-3">
                                                <select name="status" class="form-control form-control-custom mb-3" id="status" required>
                                                    <option value="" readonly>Select</option>
                                                    <option value="active" <?= ($roles_details[0]['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                                    <option value="inactive" <?= ($roles_details[0]['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                </select>
                                                <div id='status-error-message'></div>
                                            </div>
                                        </div>
                                        <!-- Status Code End -->

                                        <!-- -->
                                        <div class="text-center">
                                            <button type="button" id="update_company_role" class="btn btn-primary waves-effect waves-light" <?= (session('roles_view_and_edit_edit') != '1') ? 'disabled' : ''; ?>>Update</button>
                                            <button type="button" class="btn btn-secondary waves-effect m-l-5" onclick="window.location='<?php echo $base_url . route_to('company_role_list'); ?>'">Cancel</button>
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
echo $customlibraries->versioning('\Modules\company_role\Controllers\company_role_controller', 'company_role'); // company_role Modules Custom Js File Included
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