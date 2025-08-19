<?php

namespace Modules\login\Controllers;

use App\Controllers\BaseController;
use Modules\login\Models\login_model;
use Modules\global_templates\Models\templates_model;
use App\Libraries\customlibraries;
use Ramsey\Uuid\Uuid;

class login_controller extends BaseController
{
    protected $loginModel;
    protected $templates_model;
    protected $number_of_user;
    protected $error_log;
    
    public function __construct()
    {
        $this->loginModel = new login_model();  
        $this->templates_model = new templates_model();  
        $customlibraries = new customlibraries();
        $this->number_of_user = $customlibraries->number_of_user_count_get();  
        $this->error_log = new customlibraries();     
    }

    //login 
    public function login()
    {
        try
        {
            return view("\Modules\login\Views\login");
        }
        catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'login',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }  

    //JS Vesrioning File Get
    public function versioning($page_type='')
	{
        try
        {
            $data = [
                'page_type' => $page_type,            
            ];

            return view('\Modules\login\Views\versioning',$data);
        }
        catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'versioning',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
	}

    //User Validation Check Code 
    public function user_validation(){

        try
        {
            if ($this->request->getMethod() == "post") {
            
                $session = session();

                $email_address = $this->request->getPost("email");
                $password = $this->request->getPost("password");

                $login_whereConditions = [
                    'email' => $email_address, 
                    'company_id >' => 0,
                    'status' => 'active',          
                ];
                
                
                $userData = $this->loginModel->GetTableValue('users','*',$login_whereConditions);                

                if(empty($userData)){
                    $session->setFlashdata('msg', 'Invalid credentials');
                    return redirect()->route('login');                    
                }

                $verify_pass = password_verify((string)$password, $userData['password']);

                if($verify_pass){

                    $random_uid = $this->loginModel->user_login_key_check($userData['id']);

                    if(!empty($random_uid))
                    {
                        $randomUid = $random_uid['login_key'];
                    }
                    else
                    {
                        $update_whereConditions = array(
                            'logout_time' => null,
                            'user_id' => $userData['id']                           
                        );

                        $update_data = array(                           
                            'logout_time' => date('Y-m-d H:i:s')                                          
                        );

                        $this->loginModel->updateData('user_login_history',$update_whereConditions,$update_data);
                        
                        $randomUid = $this->generateRandomUid();
                        $key_valid_start_time = time();
                        $key_expiry_time = $key_valid_start_time + 3600;

                        $data = array(
                            'user_id' => $userData['id'],
                            'login_key' => $randomUid,
                            'key_valid_start_time' => date('Y-m-d H:i:s', $key_valid_start_time),
                            'key_expiry_time' => date('Y-m-d H:i:s',$key_expiry_time),
                            'login_time' => date('Y-m-d H:i:s',time()),
                        );

                        $this->loginModel->insertData('user_login_history',$data);
                    }

                    //Company Active Check Code Start
                    $userCompanyData = $this->loginModel->company_subscription_active_check($userData['company_id']);

                    if(empty($userCompanyData))
                    {
                        $redirect_url = OPEN_SUBSCRIPTION.$randomUid;

                        return redirect()->to($redirect_url);
                    }
                    //Company Active Check Code End

                    $this->user_roles_set($userData['role_id'], $userData['company_id']); // User Roles Session Code

                    $roles_whereConditions = [
                        'id' => $userData['role_id'],               
                    ];                   
                    
                    $rolesData = $this->loginModel->GetTableValue('tbl_roles','role_name',$roles_whereConditions);

                    if($rolesData['role_name'] == "Company Admin")
                    {
                        $company_admin = '1';
                    }
                    else
                    {
                        $company_admin = '0';
                    }


                    //Number Of User Count Set Libraries Class Call
                    $this->number_of_user;

                    $active_page_details = $this->loginModel->dashboard_subscription_active_page_details($userData['company_id']);
                    if($active_page_details)
                    {
                        $ses_active_page_data = [];
                        foreach($active_page_details as $active_page)
                        {       
                            if($active_page['feature_list'] == 'Cloud Connector')
                            {
                                $cloud_connector_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                                $ses_active_page_data[] = array(
                                    'cloud_connector_module_view' => $cloud_connector_module_view,                                    
                                );
                            }
                            else if($active_page['feature_list'] == 'Reports')
                            {
                                $reports_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                                $ses_active_page_data[] = array(
                                    'reports_module_view' => $reports_module_view,                                    
                                );
                            }
                            else if($active_page['feature_list'] == 'Dashboards')
                            {
                                $dashboard_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                                $ses_active_page_data[] = array(
                                    'dashboard_module_view' => $dashboard_module_view,                                    
                                );
                            }
                            else if($active_page['feature_list'] == 'Alert and Notification')
                            {
                                $alert_notification_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                                $ses_active_page_data[] = array(
                                    'alert_notification_module_view' => $alert_notification_module_view,                                    
                                );
                            }
                            else if($active_page['feature_list'] == 'AI Prediction')
                            {
                                $ai_prediction_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                                $ses_active_page_data[] = array(
                                    'ai_prediction_module_view' => $ai_prediction_module_view,                                    
                                );
                            }
                        }

                        $module_page_mergedArray = [];
                        foreach ($ses_active_page_data as $subArray) {
                            $module_page_mergedArray = array_merge($module_page_mergedArray, $subArray);
                        }

                        session()->set($module_page_mergedArray);
                    }                    
                    
                    $ses_data = [
                        'Taguser_id'       => $userData['id'],
                        'Taguser_name'     => $userData['name'],
                        'Taguser_email'    => $userData['email'],
                        'Taguser_company'  => $userData['company_id'],
                        'company_admin'    => $company_admin,
                        'Taglogged_in'     => TRUE,
                        'logo'     => $userCompanyData['company_logo'],
                        'company_name'     => $userCompanyData['company_name']
                    ];
                    $session->set($ses_data);
                    return redirect()->route('dashboard');
                    
                }else{
                    $session->setFlashdata('msg', 'Invalid credentials');
                    return redirect()->route('login');
                }

            }
        }
        catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'userValidation',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }

    //User Login Key Validation
    public function user_login_key_validation($login_key = '')
    {
        try
        {    
            $session = session();        
            $login_key_verify_pass = '';
            if($login_key != '')
            {
                $login_key_whereConditions = [
                    'login_key' => $login_key,                            
                ];

                $user_login_key =  $this->loginModel->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
                
                if(!empty($user_login_key))
                {
                    if(date('Y-m-d H:i:s',time()) < $user_login_key['key_expiry_time'])
                    {                      
                        $user_login_whereConditions = [
                            'id' => $user_login_key['user_id'], 
                            'company_id >' => 0,
                            'status' => 'active',          
                        ];                        
                        
                        $userData = $this->loginModel->GetTableValue('users','*',$user_login_whereConditions);
                    
                        if(!empty($userData))
                        {
                            $login_key_verify_pass = $userData['id'];
                        }
                        else
                        {
                            $session->setFlashdata('msg', 'Invalid credentials');
                            return redirect()->route('login');
                        }
                    }
                    else
                    {
                        $session->setFlashdata('msg', 'Invalid credentials');
                        return redirect()->route('login');
                    }

                    $company_whereConditions = [
                        'id' => $userData['company_id'], 
                    ];                    
                    
                    $userCompanyData = $this->loginModel->GetTableValue('tbl_companies','company_name,company_logo',$company_whereConditions);

                
                }
            }         

            if($login_key_verify_pass != ''){     
                
            //Company Active Check Code Start
            $userCompanyData = $this->loginModel->company_subscription_active_check($userData['company_id']);

            if(empty($userCompanyData))
            {
                $redirect_url = OPEN_SUBSCRIPTION.$login_key;

                return redirect()->to($redirect_url);
            }
            //Company Active Check Code End

            $this->user_roles_set($userData['role_id'], $userData['company_id']); // User Roles Session Code 
            
            $this->dashboard($userData['company_id']); // Dashboard Box Session Set
                    
            $ses_data = [
                'Taguser_id'       => $userData['id'],
                'Taguser_name'     => $userData['name'],
                'Taguser_email'    => $userData['email'],
                'Taguser_company'  => $userData['company_id'],
                'login_key'        => $login_key,
                'Taglogged_in'     => TRUE,
                'logo'     => $userCompanyData['company_logo'],
                'company_name'     => $userCompanyData['company_name']
            ];
            $session->set($ses_data);
            return redirect()->route('dashboard');              
                
            }else{
                $session->setFlashdata('msg', 'Invalid credentials');
                return redirect()->route('login');
            }

        }
        catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'user_login_key_validation',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }

    public function user_roles_set($role_id = 0, $company_id = 0)
    {
        try
        {        
            $user_roles_data = $this->loginModel->get_user_roles_details($role_id, $company_id);
            $roles_details = [];        
            foreach($user_roles_data as $roles)
            {       
                if($roles['page_id'] == '28')
                {
                    $roles_add_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $roles_add_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $roles_add_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'roles_add_view' => $roles_add_view,
                        'roles_add_edit' => $roles_add_edit,
                        'roles_add_delete' => $roles_add_delete
                    );
                }
                else if($roles['page_id'] == '34')
                {
                    $user_add_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $user_add_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $user_add_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'user_add_view' => $user_add_view,
                        'user_add_edit' => $user_add_edit,
                        'user_add_delete' => $user_add_delete
                    );
                } 
                else if($roles['page_id'] == '35')
                {
                    $user_view_and_edit_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $user_view_and_edit_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $user_view_and_edit_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'user_view_and_edit_view' => $user_view_and_edit_view,
                        'user_view_and_edit_edit' => $user_view_and_edit_edit,
                        'user_view_and_edit_delete' => $user_view_and_edit_delete
                    );
                } 
                else if($roles['page_id'] == '36')
                {
                    $roles_view_and_edit_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $roles_view_and_edit_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $roles_view_and_edit_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'roles_view_and_edit_view' => $roles_view_and_edit_view,
                        'roles_view_and_edit_edit' => $roles_view_and_edit_edit,
                        'roles_view_and_edit_delete' => $roles_view_and_edit_delete
                    );
                } 
                else if($roles['page_id'] == '41')
                {                    
                    $user_list_add_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $roles_details[] = array(
                        'user_list_add_edit' => $user_list_add_edit,                        
                    );
                }
                else if($roles['page_id'] == '48')
                {
                    $alert_notification_add_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $alert_notification_add_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'alert_notification_add_view' => $alert_notification_add_view,
                        'alert_notification_add_edit' => $alert_notification_add_edit                        
                    );
                }
                else if($roles['page_id'] == '49')
                {
                    $group_add_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $group_add_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $group_add_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'group_add_view' => $group_add_view,
                        'group_add_edit' => $group_add_edit,
                        'group_add_delete' => $group_add_delete
                    );
                }
                else if($roles['page_id'] == '50')
                {
                    $group_view_and_edit_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $group_view_and_edit_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $group_view_and_edit_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'group_view_and_edit_view' => $group_view_and_edit_view,
                        'group_view_and_edit_edit' => $group_view_and_edit_edit,
                        'group_view_and_edit_delete' => $group_view_and_edit_delete
                    );
                }
                else if($roles['page_id'] == '55')
                {
                    $subscription_module_view = ($roles['can_view'] == 'Y') ? '1' : '0';                    

                    $roles_details[] = array(
                        'subscription_module_view' => $subscription_module_view,                        
                    );
                }  
                // else if($roles['page_id'] == '37')
                // {
                //     $login_module_dashboard_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                //     $login_module_dashboard_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                //     $login_module_dashboard_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                //     $roles_details[] = array(
                //         'login_module_dashboard_view' => $login_module_dashboard_view,
                //         'login_module_dashboard_edit' => $login_module_dashboard_edit,
                //         'login_module_dashboard_delete' => $login_module_dashboard_delete
                //     );
                // }   
            }

            $roles_mergedArray = [];

            foreach ($roles_details as $subArray) {
                $roles_mergedArray = array_merge($roles_mergedArray, $subArray);
            }                   

            session()->set($roles_mergedArray);

            return true;
        }
        catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'user_roles_set',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }

    public function dashboard($company_id = 0)
    {
        try
        {
            $active_page_details = $this->loginModel->dashboard_subscription_active_page_details($company_id);
            if($active_page_details)
            {
                $ses_active_page_data = [];
                foreach($active_page_details as $active_page)
                {    
                    if($active_page['feature_list'] == 'Cloud Connector')
                    {
                        $cloud_connector_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                        $ses_active_page_data[] = array(
                            'cloud_connector_module_view' => $cloud_connector_module_view,                                    
                        );
                    }   
                    else if($active_page['feature_list'] == 'Reports')
                    {
                        $reports_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                        $ses_active_page_data[] = array(
                            'reports_module_view' => $reports_module_view,                                    
                        );
                    }
                    else if($active_page['feature_list'] == 'Dashboards')
                    {
                        $dashboard_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                        $ses_active_page_data[] = array(
                            'dashboard_module_view' => $dashboard_module_view,                                    
                        );
                    }
                    else if($active_page['feature_list'] == 'Alert and Notification')
                    {
                        $alert_notification_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                        $ses_active_page_data[] = array(
                            'alert_notification_module_view' => $alert_notification_module_view,                                    
                        );
                    }
                    else if($active_page['feature_list'] == 'AI Prediction')
                    {
                        $ai_prediction_module_view = ($active_page['subscription_plan_value'] == 'Y') ? '1' : '0';
                        $ses_active_page_data[] = array(
                            'ai_prediction_module_view' => $ai_prediction_module_view,                                    
                        );
                    }
                }

                $module_page_mergedArray = [];
                foreach ($ses_active_page_data as $subArray) {
                    $module_page_mergedArray = array_merge($module_page_mergedArray, $subArray);
                }

                session()->set($module_page_mergedArray);
            }
        }
        catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'dashboard',$e->getMessage());
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
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'generateRandomUid',$e->getMessage());
            return redirect()->route('global_catch_error');  
        }
    }

    public function password_change()
    {
        try
        {
            return view('\Modules\login\Views\password_change');
        }catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'password_change',$e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');                     
        }
    }

    public function check_old_password()
    {
        try
        {
            $old_pass = $this->request->getGet('old_pass');

            $login_whereConditions = [
                'id' => session('Taguser_id'),
            ]; 
            
            $userData = $this->loginModel->GetTableValue('users','password',$login_whereConditions);                

            $verify_pass = password_verify((string)$old_pass, $userData['password']);
        
                if ($verify_pass) {
                    return $this->response->setJSON(['status' => 'success']);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Incorrect old password']);
                }
        }catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'check_old_password',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }
    
    public function update_pwd()
    {
        try
        {
            if ($this->request->getMethod() == "post") {

                $session = session();
                $new_pass = $this->request->getPost("new_pass");
                $conf_pass = $this->request->getPost("conf_pass");

                if($new_pass == $conf_pass){

                    $company_data = [
                        'password' => password_hash((string)$new_pass, PASSWORD_DEFAULT)
                    ];

                    $comp_update_where = [
                        'id' => session('Taguser_id'),
                    ];
    
                    $this->templates_model->updateData('users', $comp_update_where, $company_data);
                }
                session()->setFlashdata('success', 'Password Updated successfully');
                return redirect()->route('password_change');
            }

        }catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'update_pwd',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }

    //User Logout Code
    public function logout()
    {
        try
        {
            // Destroy the user session on logout
            $session = \Config\Services::session();
            $session->destroy();
            return redirect()->route('login');
        }catch (\Exception $e) {
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_controller',$currentURL,'logout',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }
}
