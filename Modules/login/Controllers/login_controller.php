<?php

namespace Modules\login\Controllers;

use App\Controllers\BaseController;
use Modules\login\Models\login_model;

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
                        'key_valid_start_time' => $key_valid_start_time,
                        'key_expiry_time' => $key_expiry_time,
                        'login_time' => time(),
                    );

                    $this->loginModel->insertData('user_login_history',$data);
                    
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

    //Random UID Gen
    function generateRandomUid($length = 10) {

        try{

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $uid = '';
        
            for ($i = 0; $i < $length; $i++) {
                $uid .= $characters[rand(0, strlen($characters) - 1)];
            }
        
            return $uid;

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
