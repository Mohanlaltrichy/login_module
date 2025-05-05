<?php

namespace Modules\group\Controllers;

use App\Controllers\BaseController;
use Modules\group\Models\group_model;
use App\Libraries\customlibraries;
use Ramsey\Uuid\Uuid;

class group_controller extends BaseController
{
    protected $group_model;
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;
    protected $error_log;

    public function __construct()
    {
        $this->group_model = new group_model();
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id');
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();
        $this->error_log = new customlibraries();  
    }

    //Group add View
    public function index()
    {
        try {

            if(session('group_add_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $group_modules_whereConditions = [
                'active' => 'Y',
            ];

            $modules = $this->group_model->GetTableValue('group_modules', 'modules_option_name,modules', $group_modules_whereConditions);

            $data = array(
                'modules' => $modules,
            );

            return view("\Modules\group\Views\group_add", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'index', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Group Save
    public function group_save()
    {
        try {

            if(session('group_add_edit') == '1')
            {
                $group_name = $this->request->getPost("group_name");
                $description = $this->request->getPost("description");
                $modules = $this->request->getPost("modules");
                $status = $this->request->getPost("status");

                $group_data_whereConditions = [
                    'grp_name' => $group_name,
                    'company_id' => $this->customer_id,
                ];

                $result = $this->group_model->GetTableValue('tbl_group', 'grp_name', $group_data_whereConditions);


                if (empty($result)) {

                    $data = array(
                        'company_id' => $this->customer_id,
                        'grp_name' => $group_name,
                        'grp_desc' => $description,
                        'active_status' => $status,
                        'utc_created_at' => date('Y-m-d H:i:s'),
                        'local_created_at' => $this->local_date_time,
                        'created_by' => $this->logged_user_id,
                    );

                    if (!empty($modules)) {
                        foreach ($modules as $m) {
                            $data[$m] = '1';
                        }
                    }

                    $group_add = $this->group_model->insertData('tbl_group', $data);

                    if ($group_add) {
                        session()->setFlashdata('success', 'Group Successfully Added.');
                    }
                } else {
                    session()->setFlashdata('duplicate_record_found', 'Group name already exists');
                }
            }
            else
            {
                session()->setFlashdata('duplicate_record_found', 'Data Not Updated Access Denied.');
            }

            return redirect()->route('group');

            exit();
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_save', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Get Group Name Available Check
    public function group_duplicate_check()
    {
        try {
            if ($this->request->isAJAX()) {

                $group_name = $this->request->getGet("group_name");

                $role_data_whereConditions = [
                    'grp_name' => $group_name,
                    'company_id' => $this->customer_id,
                ];

                $result = $this->group_model->GetTableValue('tbl_group', 'grp_name', $role_data_whereConditions);

                if (!empty($result)) {
                    $group_name = $result[0]['grp_name'];
                } else {
                    $group_name = '';
                }

                $data = array('group_name' => $group_name);

                return $this->response->setJSON($data);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_duplicate_check', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Company Group List View
    public function group_list()
    {
        try {

            if(session('group_view_and_edit_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $group_data_whereConditions = [
                'company_id' => $this->customer_id,
            ];

            $result = $this->group_model->GetTableValue('tbl_group', '*', $group_data_whereConditions, '', '', '', 'id', 'desc');

            $group_modules_whereConditions = [
                'active' => 'Y',
            ];

            $modules = $this->group_model->GetTableValue('group_modules', 'modules_option_name,modules', $group_modules_whereConditions);

            $data = array('result' => $result, 'modules' => $modules);

            return view("\Modules\group\Views\group_list", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_list', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function group_user_view($id = 0)
    {
        try {

            if(session('group_view_and_edit_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $group_whereConditions = [
                'id' => $id
            ];

            $group_details = $this->group_model->GetTableValue('tbl_group', 'grp_name,grp_desc', $group_whereConditions);

            $group_mapped_user_data_whereConditions = [
                'company_id' => $this->customer_id,
                'status' => 'active'
            ];
            $result = $this->group_model->GetTableValue('users', 'id,name,city,designation,mobile,email', $group_mapped_user_data_whereConditions, '', '', '', 'id', 'desc');

            $data = array('group_details' => $group_details, 'result' => $result, 'group_id' => $id);

            return view("\Modules\group\Views\group_user_view", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_user_view', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function group_user_edit($id = 0)
    {
        try {

            if(session('group_view_and_edit_edit') != '1') {
                return redirect()->route('forbidden_error');
            }

            $group_whereConditions = [
                'id' => $id
            ];

            $group_details = $this->group_model->GetTableValue('tbl_group', 'grp_name,grp_desc', $group_whereConditions);

            $group_mapped_user_data_whereConditions = [
                'company_id' => $this->customer_id,
                'status' => 'active'
            ];
            $result = $this->group_model->GetTableValue('users', 'id,name,city,department,designation,mobile,email', $group_mapped_user_data_whereConditions, '', '', '', 'id', 'desc');

            $data = array('group_details' => $group_details, 'result' => $result, 'group_id' => $id);

            return view("\Modules\group\Views\group_user_edit", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_user_edit', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Group Edit Code
    public function group_edit($id = 0)
    {
        try {

            if(session('group_view_and_edit_edit') != '1') {
                return redirect()->route('forbidden_error');
            }

            $group_edit_where = [
                'id' => $id,
            ];

            $group_details = $this->group_model->GetTableValue('tbl_group', '*', $group_edit_where);

            $group_modules_whereConditions = [
                'active' => 'Y',
            ];

            $modules = $this->group_model->GetTableValue('group_modules', 'modules_option_name,modules', $group_modules_whereConditions);

            $data = array(
                'group_details' => $group_details,
                'modules' => $modules,
            );

            return view("\Modules\group\Views\group_edit", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_edit', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Update Group
    public function group_update()
    {
        try {

            if(session('group_view_and_edit_edit') == '1')
            {
                $group_id = $this->request->getPost("group_id");
                $grp_name = $this->request->getPost("grp_name");
                $description = $this->request->getPost("description");
                $modules = $this->request->getPost("modules");
                $status = $this->request->getPost("status");

                $group_data_whereConditions = [
                    'id' => $group_id,
                    'grp_name' => $grp_name,
                    'company_id' => $this->customer_id,
                ];

                $result = $this->group_model->GetTableValue('tbl_group', 'grp_desc, active_status', $group_data_whereConditions);

                if (!empty($result)) {

                    $group_modules_whereConditions = [
                        'active' => 'Y',
                    ];

                    $modules_update = $this->group_model->GetTableValue('group_modules', 'modules_option_name', $group_modules_whereConditions);

                    $old_mu_where = [
                        'id' => $group_id,
                        'company_id' => $this->customer_id,
                    ];
                    
                    $old_mu_details = [];
                    foreach ($modules_update as $mu) {
                        $column_name = $mu['modules_option_name'];               
                        $condition = $old_mu_where;
                        $condition[$column_name] = '1';
                    
                        $old_details = $this->group_model->GetTableValue('tbl_group', $column_name, $condition);
                        if(!empty($old_details))
                        {
                            $old_mu_details[] = $column_name;
                        }                        
                    }
                    $old_mu_name = implode(',', $old_mu_details);
                    $new_mu_name = !empty($modules) ? implode(',', $modules) : '';
                    $old_grp_desc = $result[0]['grp_desc'];
                    $old_active_status = $result[0]['active_status'];

                    // Normalize arrays for comparison 
                    sort($old_mu_details);
                    sort($modules);                    

                    $update_whereConditions = [
                        'id' => $group_id,
                        'company_id' => $this->customer_id,
                    ];

                    foreach ($modules_update as $mu) {
                        $mu_update_data = array(
                            $mu['modules_option_name'] => '0'
                        );
                        $this->group_model->updateData('tbl_group', $update_whereConditions, $mu_update_data); //All Modules First '0' Set
                    }

                    //Update Audit Trail Code Start
                    $randomUid = $this->generateRandomUid();

                    $group_audit_data = [
                        'update_key' => $randomUid,
                        'customer_id' => session('Taguser_company'),
                        'config_type' => 'login_group',
                        'server_id' => $group_id,
                        'update_type' => 'edit',
                        'created_by' => session('Taguser_id'),
                        'utc_created_at' => date('Y-m-d H:i:s'),
                        'local_created_at' => $this->local_date_time,
                    ];

                    if (trim($old_grp_desc) != trim($description)) {
                        $group_audit_data['update_field'] = 'grp_desc';
                        $group_audit_data['old_value'] = ($old_grp_desc) ? $old_grp_desc : null;
                        $group_audit_data['new_value'] = ($description) ? $description : null;
                        $this->group_model->insert_data_postgresql('update_audit_trail', $group_audit_data);
                    }

                    if ($old_mu_details != $modules) {
                        $group_audit_data['update_field'] = 'modules';
                        $group_audit_data['old_value'] = ($old_mu_name) ? $old_mu_name : null;
                        $group_audit_data['new_value'] = ($new_mu_name) ? $new_mu_name : null;
                        $this->group_model->insert_data_postgresql('update_audit_trail', $group_audit_data);
                    }

                    if (trim($old_active_status) != trim($status)) {
                        $group_audit_data['update_field'] = 'active_status';
                        $group_audit_data['old_value'] = ($old_active_status) ? $old_active_status : null;
                        $group_audit_data['new_value'] = ($status) ? $status : null;
                        $this->group_model->insert_data_postgresql('update_audit_trail', $group_audit_data);
                    }
                    //Update Audit Trail Code End
                    
                    $data = array(
                        'company_id' => $this->customer_id,
                        'grp_desc' => $description,
                        'active_status' => $status,
                        'utc_updated_at' => date('Y-m-d H:i:s'),
                        'local_updated_at' => $this->local_date_time,
                        'updated_by' => $this->logged_user_id,
                    );

                    if (!empty($modules)) {
                        foreach ($modules as $m) {
                            $data[$m] = '1';
                        }
                    }

                    $group_update = $this->group_model->updateData('tbl_group', $update_whereConditions, $data);

                    session()->setFlashdata('success', 'Group Successfully Updated.');
                } else {
                    session()->setFlashdata('msg', 'Group Name Not Exists');
                }
            }
            else
            {
                session()->setFlashdata('duplicate_record_found', 'Data Not Updated Access Denied.');
            }

            return redirect()->route('group_list');
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'group_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Deleted Code
    public function groupdelete()
    {
        try {

            if ($this->request->isAJAX()) {

                if(session('group_view_and_edit_delete') == '1')
                {

                    $id = $this->request->getGet("id");

                    $group_whereConditions = [
                        'id' => $id,
                    ];

                    //Delete audit trail code start
                    $group_data = $this->group_model->GetTableValue('tbl_group', 'grp_name', $group_whereConditions);
        
                    if(!empty($group_data))
                    {
                        $randomUid = $this->generateRandomUid();
                        $users_delete_data = [
                            'update_key' => $randomUid,
                            'customer_id' => $this->customer_id,
                            'config_type' => 'login_group',
                            'server_id' => $id,                        
                            'created_by' => session('Taguser_id'),
                            'utc_created_at' => date('Y-m-d H:i:s'),
                            'local_created_at' => $this->local_date_time,
                        ];

                        $grp_name = $group_data[0]['grp_name'];
                        $users_delete_data['delete_type'] = 'grp_name';
                        $users_delete_data['deleted_value']  = ($grp_name) ? $grp_name : null;
                        $this->group_model->insert_data_postgresql('delete_audit_trail', $users_delete_data);                      
                    }
                    //Delete audit trail code end

                    $data = [
                        'active_status' => 'inactive',
                        'utc_updated_at' => date('Y-m-d H:i:s'),
                        'local_updated_at' => $this->local_date_time,
                        'updated_by' => $this->logged_user_id,
                    ];

                    $this->group_model->updateData('tbl_group', $group_whereConditions, $data);

                    session()->removeTempdata('group_deleted_success');
                    session()->setTempdata('group_deleted_success', 'group successfully deleted');
                }
                else
                {
                    session()->setFlashdata('msg', 'Group not deleted access denied.');
                }

                $result = array('success' => 'success');
                echo json_encode($result);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'groupdelete', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //User Update
    public function group_user_update()
    {
        try {

            if ($this->request->isAJAX()) {

                if(session('group_view_and_edit_delete') == '1')
                {
                    $group_id = $this->request->getGet("group_id");
                    $user_checkedIds = $this->request->getGet("user_checkedIds");

                    $old_group_user_whereConditions = [
                        'grpid' => $group_id,
                        'active' => 'Y',
                    ];

                    $old_group_user = $this->group_model->GetTableValue('tbl_user_mapping', 'user_id', $old_group_user_whereConditions);
                    $old_user_ids_array = array_column($old_group_user, 'user_id');
                    $old_user_ids = implode(',', $old_user_ids_array);

                    $group_user_mapped_delete_whereConditions = [
                        'grpid' => $group_id,
                    ];

                    $this->group_model->deleteData('tbl_user_mapping', $group_user_mapped_delete_whereConditions);

                    $data = [];
                    $new_user_ids_array = [];
                    if (!empty($user_checkedIds)) {
                        foreach ($user_checkedIds as $user_id) {
                            $data[] = array(
                                'grpid' => $group_id,
                                'user_id' => $user_id,
                                'active' => 'Y',
                            );

                            $new_user_ids_array[] = $user_id;
                        }
                    }
                    $new_user_ids = !empty($new_user_ids_array) ? implode(',', $new_user_ids_array) : '';

                    // Normalize arrays for comparison 
                    sort($old_user_ids_array);
                    sort($new_user_ids_array);

                    if ($old_user_ids_array != $new_user_ids_array) {

                        $randomUid = $this->generateRandomUid();

                        $group_user_update_audit_data = [
                            'update_key' => $randomUid,
                            'customer_id' => session('Taguser_company'),
                            'config_type' => 'login_group',
                            'server_id' => $group_id,
                            'update_field' => 'login_group_user',
                            'old_value' => $old_user_ids ?: null,
                            'new_value' => $new_user_ids ?: null,
                            'update_type' => 'edit',
                            'created_by' => session('Taguser_id'),
                            'utc_created_at' => date('Y-m-d H:i:s'),
                            'local_created_at' => $this->local_date_time,
                        ];
                        
                        $this->group_model->insert_data_postgresql('update_audit_trail', $group_user_update_audit_data);
                    }

                    $this->group_model->insertBatchData('tbl_user_mapping', $data);

                    session()->removeTempdata('group_user_success');
                    session()->setTempdata('group_user_success', 'Group User Successfully Updated');
                }
                else
                {
                    session()->setFlashdata('msg', 'Group user not deleted access denied.');
                }

                $result = array('success' => 'success');
                echo json_encode($result);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'groupdelete', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Random UID Gen
    function generateRandomUid() {

        try{

            $uuid = Uuid::uuid4();
            $randomId = str_replace('-', '',$uuid->toString());
            return $randomId;

        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('group\group_controller',$currentURL,'generateRandomUid',$e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');  
        }
    }

    //JS Vesrioning File Get
    public function versioning($page_type = '')
    {
        try
        {
            $data = [
                'page_type' => $page_type,
            ];

            return view('\Modules\group\Views\versioning', $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('group\group_controller', $currentURL, 'versioning', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
}
