<?php

namespace Modules\company_role\Controllers;

use App\Controllers\BaseController;
use Modules\company_role\Models\company_role_model;
use App\Libraries\customlibraries;

class company_role_controller extends BaseController
{
    protected $company_role_model;
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;
    
    public function __construct()
    {
        $this->company_role_model = new company_role_model();   
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id'); 
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();    
    }

    //company role add View
    public function index()
    {
        try 
        {
            if(session('roles_add_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $roles_module_like = [
                'tcp.page_name' => 'roles'
            ];

            $roles_module_data = $this->company_role_model->get_page_details($roles_module_like);

            $users_module_like = [
                'tcp.page_name' => 'users'
            ];

            $users_module_data = $this->company_role_model->get_page_details($users_module_like);

            $opc_module_like = [
                'tcp.page_name' => 'opc'
            ];

            $opc_module_data = $this->company_role_model->get_page_details($opc_module_like);            

            $mqtt_module_like = [
                'tcp.page_name' => 'mqtt'
            ];

            $mqtt_module_data = $this->company_role_model->get_page_details($mqtt_module_like);           

            $http_module_like = [
                'tcp.page_name' => 'http'
            ];

            $http_module_data = $this->company_role_model->get_page_details($http_module_like); 

            $tag_module_like = [
                'tcp.page_name' => 'historian'
            ];

            $tag_module_data = $this->company_role_model->get_page_details($tag_module_like);

            $bulk_import_status_module_like = [
                'tcp.page_name' => 'bulk_import_status'
            ];

            $bulk_import_list_module_data = $this->company_role_model->get_page_details($bulk_import_status_module_like);
            
            $data = array(
                'roles_module_data' => $roles_module_data,
                'users_module_data' => $users_module_data,
                'opc_module_data' => $opc_module_data,
                'mqtt_module_data' => $mqtt_module_data,
                'http_module_data' => $http_module_data,
                'tag_module_data' => $tag_module_data,               
                'bulk_import_list_module_data' => $bulk_import_list_module_data,
            );

            return view("\Modules\company_role\Views\company_role",$data);

        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'index', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    } 
    
    //Company Role Save
    public function company_role_save()
    {
        try 
        {
            if(session('roles_add_edit') == '1')
            {
                $role_name = $this->request->getPost("role_name");
                $description = $this->request->getPost("description");
                $status = $this->request->getPost("status");
                $roles_checkbox_id = $this->request->getPost("roles_checkbox_id");
                $roles_all_checkbox_value = $this->request->getPost("roles_all_checkbox_value");
                $roles_checkbox_view = $this->request->getPost("roles_checkbox_view");
                $roles_checkbox_edit = $this->request->getPost("roles_checkbox_edit");
                $roles_checkbox_delete = $this->request->getPost("roles_checkbox_delete"); 
                $users_checkbox_id = $this->request->getPost("users_checkbox_id");
                $users_all_checkbox_value = $this->request->getPost("users_all_checkbox_value");
                $users_checkbox_view = $this->request->getPost("users_checkbox_view");
                $users_checkbox_edit = $this->request->getPost("users_checkbox_edit");
                $users_checkbox_delete = $this->request->getPost("users_checkbox_delete");  
                $opc_checkbox_id = $this->request->getVar("opc_checkbox_id");  
                $opc_all_checkbox_value = $this->request->getPost("opc_all_checkbox_value");
                $opc_checkbox_view = $this->request->getVar("opc_checkbox_view");        
                $opc_checkbox_edit = $this->request->getVar("opc_checkbox_edit");           
                $opc_checkbox_delete = $this->request->getVar("opc_checkbox_delete");   
                $tag_checkbox_id = $this->request->getPost("tag_checkbox_id");
                $tag_all_checkbox_value = $this->request->getPost("tag_all_checkbox_value");        
                $tag_checkbox_view = $this->request->getPost("tag_checkbox_view");            
                $tag_checkbox_edit = $this->request->getPost("tag_checkbox_edit");          
                $tag_checkbox_delete = $this->request->getPost("tag_checkbox_delete");  
                $mqtt_checkbox_id = $this->request->getPost("mqtt_checkbox_id");  
                $mqtt_all_checkbox_value = $this->request->getPost("mqtt_all_checkbox_value");       
                $mqtt_checkbox_view = $this->request->getPost("mqtt_checkbox_view");            
                $mqtt_checkbox_edit = $this->request->getPost("mqtt_checkbox_edit");            
                $mqtt_checkbox_delete = $this->request->getPost("mqtt_checkbox_delete");
                $http_checkbox_id = $this->request->getVar("http_checkbox_id");  
                $http_all_checkbox_value = $this->request->getPost("http_all_checkbox_value");
                $http_checkbox_view = $this->request->getVar("http_checkbox_view");        
                $http_checkbox_edit = $this->request->getVar("http_checkbox_edit");           
                $http_checkbox_delete = $this->request->getVar("http_checkbox_delete");
                $bulk_checkbox_id = $this->request->getPost("bulk_checkbox_id");     
                $bulk_all_checkbox_value = $this->request->getPost("bulk_all_checkbox_value");
                $bulk_checkbox_view = $this->request->getPost("bulk_checkbox_view");          
                $bulk_checkbox_edit = $this->request->getPost("bulk_checkbox_edit");            
                $bulk_checkbox_delete = $this->request->getPost("bulk_checkbox_delete");

                $role_data_whereConditions = [
                    'role_name' => $role_name,                    
                    'company_id' => $this->customer_id,                                    
                ];

                $result = $this->company_role_model->GetTableValue('tbl_roles', 'role_name', $role_data_whereConditions); 

                if(empty($result))
                {
                    $roles_add = $this->company_role_model->add_page_roles_details($role_name, $description, $status,  $roles_checkbox_id, $roles_all_checkbox_value, $roles_checkbox_view, $roles_checkbox_edit, $roles_checkbox_delete, $users_checkbox_id, $users_all_checkbox_value, $users_checkbox_view, $users_checkbox_edit, $users_checkbox_delete, $opc_checkbox_id, $opc_all_checkbox_value, $opc_checkbox_view, $opc_checkbox_edit, $opc_checkbox_delete, $tag_checkbox_id, $tag_all_checkbox_value, $tag_checkbox_view, $tag_checkbox_edit, $tag_checkbox_delete, $mqtt_checkbox_id, $mqtt_all_checkbox_value, $mqtt_checkbox_view, $mqtt_checkbox_edit, $mqtt_checkbox_delete, $http_checkbox_id, $http_all_checkbox_value, $http_checkbox_view, $http_checkbox_edit, $http_checkbox_delete, $bulk_checkbox_id, $bulk_all_checkbox_value, $bulk_checkbox_view, $bulk_checkbox_edit, $bulk_checkbox_delete);

                    if($roles_add)
                    {
                        session()->setFlashdata('success', 'Roles Successfully Added.');
                    }
                }
                else
                {   
                    session()->setFlashdata('duplicate_record_found', 'Role name already exists');
                }

                return redirect()->route('company_role');

                exit();  
            }
            else
            {
                session()->setFlashdata('duplicate_record_found', 'Role Not Added Acess Denied');
                return redirect()->route('company_role');
                exit();
            }

        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'company_role_save', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Get Role Name Available Check
    public function company_role_duplicate_check(){
        try{
            if ($this->request->isAJAX()) {
                
                $role_name = $this->request->getGet("role_name");

                $role_data_whereConditions = [
                    'role_name' => $role_name,                    
                    'company_id' => $this->customer_id,                                    
                ];

                $result = $this->company_role_model->GetTableValue('tbl_roles', 'role_name', $role_data_whereConditions); 

                if(!empty($result))
                {
                    $role_name = $result[0]['role_name'];
                }
                else
                {
                    $role_name = '';
                }
                
                $data = array('role_name' => $role_name);

                return $this->response->setJSON($data);
            }
        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'company_role_duplicate_check', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Company Role List View
    public function company_role_list() {
        try{

            if(session('roles_view_and_edit_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $role_data_whereConditions = [                                  
                'company_id' => $this->customer_id,                                    
            ];

            $result = $this->company_role_model->GetTableValue('tbl_roles', 'id,role_name,description,status,utc_created_at', $role_data_whereConditions,'','','','id','desc');

            $data = array('result' => $result);

            return view("\Modules\company_role\Views\company_role_list", $data);

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'company_role_list', $e->getMessage());
            return redirect()->route('global_catch_error');
        }        
    }

    //Role Edit Code
    public function company_role_edit($id = 0)
    {
        try
        {
            $role_data_whereConditions = [
                'id' => $id,
                'company_id' => $this->customer_id,                                        
            ];

            $roles_details = $this->company_role_model->GetTableValue('tbl_roles', 'id,role_name,description,roles_all_pages,users_all_pages,opc_all_pages,mqtt_all_pages,http_all_pages,tag_all_pages,bulk_import_status_all_pages,status', $role_data_whereConditions);

            if(empty($roles_details))
            {
                return redirect()->route('company_role_list');
            }

            $roles_module_like = [
                'tcp.page_name' => 'roles'
            ];

            $roles_module_data = $this->company_role_model->get_page_details($roles_module_like);

            $users_module_like = [
                'tcp.page_name' => 'users'
            ];

            $users_module_data = $this->company_role_model->get_page_details($users_module_like);

            $opc_module_like = [
                'tcp.page_name' => 'opc'
            ];

            $opc_module_data = $this->company_role_model->get_page_details($opc_module_like);            

            $mqtt_module_like = [
                'tcp.page_name' => 'mqtt'
            ];

            $mqtt_module_data = $this->company_role_model->get_page_details($mqtt_module_like);

            $http_module_like = [
                'tcp.page_name' => 'http'
            ];

            $http_module_data = $this->company_role_model->get_page_details($http_module_like);

            $tag_module_like = [
                'tcp.page_name' => 'historian'
            ];

            $tag_module_data = $this->company_role_model->get_page_details($tag_module_like);

            $bulk_import_status_module_like = [
                'tcp.page_name' => 'bulk_import_status'
            ];

            $bulk_import_list_module_data = $this->company_role_model->get_page_details($bulk_import_status_module_like);
            
            $data = array(
                'roles_details' => $roles_details,
                'users_module_data' => $users_module_data,
                'roles_module_data' => $roles_module_data,
                'opc_module_data' => $opc_module_data,
                'mqtt_module_data' => $mqtt_module_data,
                'http_module_data' => $http_module_data,
                'tag_module_data' => $tag_module_data,             
                'bulk_import_list_module_data' => $bulk_import_list_module_data,
            );

            return view("\Modules\company_role\Views\company_role_edit",$data);

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'company_role_edit', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Update Company Role
    public function company_role_update()
    {
        try
        {
            if(session('roles_view_and_edit_edit') == '1'){

                $role_id = $this->request->getPost("role_id");
                $role_name = $this->request->getPost("role_name");
                $description = $this->request->getPost("description");
                $status = $this->request->getPost("status");
                $roles_checkbox_id = $this->request->getPost("roles_checkbox_id");
                $roles_all_checkbox_value = $this->request->getPost("roles_all_checkbox_value");
                $roles_checkbox_view = $this->request->getPost("roles_checkbox_view");
                $roles_checkbox_edit = $this->request->getPost("roles_checkbox_edit");
                $roles_checkbox_delete = $this->request->getPost("roles_checkbox_delete"); 
                $users_checkbox_id = $this->request->getPost("users_checkbox_id");
                $users_all_checkbox_value = $this->request->getPost("users_all_checkbox_value");
                $users_checkbox_view = $this->request->getPost("users_checkbox_view");
                $users_checkbox_edit = $this->request->getPost("users_checkbox_edit");
                $users_checkbox_delete = $this->request->getPost("users_checkbox_delete");  
                $opc_checkbox_id = $this->request->getVar("opc_checkbox_id");  
                $opc_all_checkbox_value = $this->request->getPost("opc_all_checkbox_value");
                $opc_checkbox_view = $this->request->getVar("opc_checkbox_view");        
                $opc_checkbox_edit = $this->request->getVar("opc_checkbox_edit");           
                $opc_checkbox_delete = $this->request->getVar("opc_checkbox_delete");   
                $tag_checkbox_id = $this->request->getPost("tag_checkbox_id");
                $tag_all_checkbox_value = $this->request->getPost("tag_all_checkbox_value");        
                $tag_checkbox_view = $this->request->getPost("tag_checkbox_view");            
                $tag_checkbox_edit = $this->request->getPost("tag_checkbox_edit");          
                $tag_checkbox_delete = $this->request->getPost("tag_checkbox_delete");  
                $mqtt_checkbox_id = $this->request->getPost("mqtt_checkbox_id");  
                $mqtt_all_checkbox_value = $this->request->getPost("mqtt_all_checkbox_value");       
                $mqtt_checkbox_view = $this->request->getPost("mqtt_checkbox_view");            
                $mqtt_checkbox_edit = $this->request->getPost("mqtt_checkbox_edit");            
                $mqtt_checkbox_delete = $this->request->getPost("mqtt_checkbox_delete");
                $http_checkbox_id = $this->request->getVar("http_checkbox_id");  
                $http_all_checkbox_value = $this->request->getPost("http_all_checkbox_value");
                $http_checkbox_view = $this->request->getVar("http_checkbox_view");        
                $http_checkbox_edit = $this->request->getVar("http_checkbox_edit");           
                $http_checkbox_delete = $this->request->getVar("http_checkbox_delete");  
                $bulk_checkbox_id = $this->request->getPost("bulk_checkbox_id");     
                $bulk_all_checkbox_value = $this->request->getPost("bulk_all_checkbox_value");
                $bulk_checkbox_view = $this->request->getPost("bulk_checkbox_view");          
                $bulk_checkbox_edit = $this->request->getPost("bulk_checkbox_edit");            
                $bulk_checkbox_delete = $this->request->getPost("bulk_checkbox_delete");

                $role_data_whereConditions = [
                    'id' => $role_id,
                    'role_name' => $role_name,                    
                    'company_id' => $this->customer_id,                                    
                ];

                $result = $this->company_role_model->GetTableValue('tbl_roles', 'role_name', $role_data_whereConditions); 

                if(!empty($result))
                {
                    $roles_update = $this->company_role_model->update_page_roles_details($role_id, $role_name, $description, $status,  $roles_checkbox_id, $roles_all_checkbox_value, $roles_checkbox_view, $roles_checkbox_edit, $roles_checkbox_delete, $users_checkbox_id, $users_all_checkbox_value, $users_checkbox_view, $users_checkbox_edit, $users_checkbox_delete, $opc_checkbox_id, $opc_all_checkbox_value, $opc_checkbox_view, $opc_checkbox_edit, $opc_checkbox_delete, $tag_checkbox_id, $tag_all_checkbox_value, $tag_checkbox_view, $tag_checkbox_edit, $tag_checkbox_delete, $mqtt_checkbox_id, $mqtt_all_checkbox_value, $mqtt_checkbox_view, $mqtt_checkbox_edit, $mqtt_checkbox_delete, $http_checkbox_id, $http_all_checkbox_value, $http_checkbox_view, $http_checkbox_edit, $http_checkbox_delete, $bulk_checkbox_id, $bulk_all_checkbox_value, $bulk_checkbox_view, $bulk_checkbox_edit, $bulk_checkbox_delete);
                
                    session()->setFlashdata('success', 'Roles Successfully Updated.');             
                }
                else
                {   
                    session()->setFlashdata('msg', 'Role name Not exists');
                }          

                return redirect()->route('company_role_list');
            }
            else
            {
                session()->setFlashdata('msg', 'Role Not Updated Access Denied');
                return redirect()->route('company_role_list');
            }

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'company_role_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
        
    }

    //Deleted Code
    public function roledelete()
    {
        try{

            if(session('roles_view_and_edit_delete') == '1'){

                if ($this->request->isAJAX()) {
                
                    $id = $this->request->getGet("id");

                    $role_whereConditions = [
                        'id' => $id,                                
                    ];
                            
                    $data = [
                        'status' => 'deleted',
                        'utc_updated_at' => date('Y-m-d H:i:s'), 
                        'local_updated_at' => $this->local_date_time, 
                        'updated_by' => $this->logged_user_id,               
                    ];

                    $this->company_role_model->updateData('tbl_roles', $role_whereConditions, $data);

                    session()->removeTempdata('company_role_deleted_success');     
                    session()->setTempdata('company_role_deleted_success', 'Role Successfully Deleted');

                    $result = array('success' => 'success');
                    echo json_encode($result);
                }
            }
            else
            {
                $result = array('failed' => 'failed');
                echo json_encode($result);
            }

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_role_model->error('company_role\company_role_controller', $currentURL, 'roledelete', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    } 
    

    //JS Vesrioning File Get
    public function versioning($page_type='')
	{
        $data = [
            'page_type' => $page_type,            
        ];

        return view('\Modules\company_role\Views\versioning',$data);
	}
}
