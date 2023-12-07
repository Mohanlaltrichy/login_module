<?php

namespace Modules\login\Controllers;

use App\Controllers\BaseController;
use Modules\login\Models\login_model;
use Ramsey\Uuid\Uuid;

class login_controller extends BaseController
{
    protected $loginModel;
    
    public function __construct()
    {
        $this->loginModel = new login_model();        
    }

    //login 
    public function login()
    {
        return view("\Modules\login\Views\login");
    }  

    //JS Vesrioning File Get
    public function versioning($page_type='')
	{
        $data = [
            'page_type' => $page_type,            
        ];

        return view('\Modules\login\Views\versioning',$data);
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
                    'status' => 'active',          
                ];
                
                
                $userData = $this->loginModel->GetTableValue('users','*',$login_whereConditions);
                

                if(empty($userData)){
                    $session->setFlashdata('msg', 'Invalid credentials');
                    return redirect()->route('login');                    
                }

                $verify_pass = password_verify((string)$password, $userData['password']);

                if($verify_pass){

                    $randomUid = $this->generateRandomUid();
                    $key_valid_start_time = time();
                    $key_expiry_time = $key_valid_start_time + 2 * 3600;

                    $data = array(
                        'user_id' => $userData['id'],
                        'login_key' => $randomUid,
                        'key_valid_start_time' => date('Y-m-d H:m:s', $key_valid_start_time),
                        'key_expiry_time' => date('Y-m-d H:m:s',$key_expiry_time),
                        'login_time' => date('Y-m-d H:m:s',time()),
                    );

                    $this->loginModel->insertData('user_login_history',$data);

                    $this->user_roles_set($userData['role_id']); // User Roles Session Code
                    
                    $ses_data = [
                        'Taguser_id'       => $userData['id'],
                        'Taguser_name'     => $userData['name'],
                        'Taguser_email'    => $userData['email'],
                        'Taguser_company'  => $userData['company_id'],
                        'Taglogged_in'     => TRUE
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
            $this->loginModel->error('login\login_controller',$currentURL,'userValidation',$e->getMessage());
            return redirect()->route('global_catch_error');                     
        }
    }

    public function user_roles_set($role_id = 0)
    {
        try
        {        
            $user_roles_data = $this->loginModel->get_user_roles_details($role_id);
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
                else if($roles['page_id'] == '37')
                {
                    $login_module_dashboard_view = ($roles['can_view'] == 'Y') ? '1' : '0';
                    $login_module_dashboard_edit = ($roles['can_edit'] == 'Y') ? '1' : '0';
                    $login_module_dashboard_delete = ($roles['can_delete'] == 'Y') ? '1' : '0';

                    $roles_details[] = array(
                        'login_module_dashboard_view' => $login_module_dashboard_view,
                        'login_module_dashboard_edit' => $login_module_dashboard_edit,
                        'login_module_dashboard_delete' => $login_module_dashboard_delete
                    );
                }   
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
            $this->loginModel->error('login\login_controller',$currentURL,'user_roles_set',$e->getMessage());
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
            $this->loginModel->error('login\login_controller',$currentURL,'generateRandomUid',$e->getMessage());
            return redirect()->route('global_catch_error');  
        }
    }

    //User Logout Code
    public function logout()
    {
        // Destroy the user session on logout
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->route('login');
    }
}
