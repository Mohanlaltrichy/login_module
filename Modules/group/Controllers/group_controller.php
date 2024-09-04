<?php

namespace Modules\group\Controllers;

use App\Controllers\BaseController;
use Modules\group\Models\group_model;
use App\Libraries\customlibraries;

class group_controller extends BaseController
{
    protected $group_model;
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;

    public function __construct()
    {
        $this->group_model = new group_model();
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id');
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();
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
            $this->group_model->error('group\group_controller', $currentURL, 'index', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'group_save', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'group_duplicate_check', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'group_list', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'group_user_view', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'group_user_edit', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'group_edit', $e->getMessage());
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

                $result = $this->group_model->GetTableValue('tbl_group', 'grp_name', $group_data_whereConditions);

                if (!empty($result)) {

                    $group_modules_whereConditions = [
                        'active' => 'Y',
                    ];

                    $modules_update = $this->group_model->GetTableValue('group_modules', 'modules_option_name', $group_modules_whereConditions);

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
            $this->group_model->error('group\group_controller', $currentURL, 'group_update', $e->getMessage());
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
            $this->group_model->error('group\group_controller', $currentURL, 'groupdelete', $e->getMessage());
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

                    $group_user_mapped_delete_whereConditions = [
                        'grpid' => $group_id,
                    ];

                    $this->group_model->deleteData('tbl_user_mapping', $group_user_mapped_delete_whereConditions);

                    $data = [];
                    if (!empty($user_checkedIds)) {
                        foreach ($user_checkedIds as $user_id) {
                            $data[] = array(
                                'grpid' => $group_id,
                                'user_id' => $user_id,
                                'active' => 'Y',
                            );
                        }
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
            $this->group_model->error('group\group_controller', $currentURL, 'groupdelete', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }



    //JS Vesrioning File Get
    public function versioning($page_type = '')
    {
        $data = [
            'page_type' => $page_type,
        ];

        return view('\Modules\group\Views\versioning', $data);
    }
}
