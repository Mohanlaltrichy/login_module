<?php

namespace Modules\company_user\Controllers;

use App\Controllers\BaseController;
use Modules\company_user\Models\company_user_model;
use App\Libraries\customlibraries;
use App\Validators\validationrules;
use Ramsey\Uuid\Uuid;

class company_user_controller extends BaseController
{
    protected $company_user_model;
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;

    public function __construct()
    {
        $this->company_user_model = new company_user_model();
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id');
    }

      //company user -view
      public function index()
      {
        //   try 
        //   {

            $role_data_whereConditions = [
                'company_id' => $this->customer_id,                                    
                'status' => 'active',                                    
            ];

            $role = $this->company_user_model->GetTableValue('tbl_roles', 'id,role_name', $role_data_whereConditions); 

            $data = ['role' => $role];

              return view("\Modules\company_user\Views\company_user",$data);
  
        //   } catch (\Exception $e) {
        //       $currentURL = current_url();
        //       $this->company_user_model->error('company_user\company_user_controller', $currentURL, 'index', $e->getMessage());
        //       return redirect()->route('global_catch_error');
        //   }
      } 
      
      //Company User Save
      public function save_company_user()
      {
          try 
          {
              $fullname = $this->request->getPost("fullname");
              $email = $this->request->getPost("email");
              $phone = $this->request->getPost("phone");
              $password = $this->request->getPost('password');
              $conf_password = $this->request->getPost("conf_password");
              $designation = $this->request->getPost("designation");
              $mobile = $this->request->getPost("mobile");
              $address = trim($this->request->getPost("address"));
              $role = $this->request->getPost("role");
              $status = $this->request->getPost("status");
              $phone_code = $this->request->getPost("phone_code");
              $mobile_code = $this->request->getPost("mobile_code");

   //   $validation =  \Config\Services::validation();

            //   $rules = [
            //     "fullname" => [
            //         "label" => "Name", 
            //         "rules" => "required"
            //     ],
            //     "email" => [
            //         "label" => "Email", 
            //         "rules" => "required"
            //     ],
            //     "role" => [
            //         "label" => "Role", 
            //         "rules" => "required"
            //     ]
            // ];
            
            // if (!$this->validate($rules) || $password !== $conf_password) {
            //     session()->setFlashdata('msg', $validation->getErrors());
            //     return redirect()->route('company_user_add');
            // }
            
              $user_email_whereConditions = [
                  'email' => $email,                    
              ];
              $user_or_whereConditions = [
                  'mobile' => $mobile_code,                    
              ];
  
              $email_check = $this->company_user_model->GetTableValue('users', 'id', $user_email_whereConditions); 
              $mob_check = $this->company_user_model->GetTableValue('users', 'id',$user_or_whereConditions); 
  
              if (!empty($email_check)) {
                session()->setFlashdata('duplicate_record_found', 'Email ID already exists');
                return redirect()->route('company_user_add');
            }
              if (!empty($mob_check)) {
                session()->setFlashdata('duplicate_record_found', 'Mobile Number already exists');
                return redirect()->route('company_user_add');
            }

            $hashed_password = ($password) ? password_hash((string)$password, PASSWORD_DEFAULT) : $password;
            $randomUid = $this->generateRandomUid();

            $data = [
                'uuid' => $randomUid,
                'name' => $fullname,
                'email' => $email,
                'address' => ($address != '') ? $address : null,
                'mobile' => ($mobile != '') ? $mobile : null,
                'phone' => ($phone != '') ? $phone : null,
                'designation' => ($designation != '') ? $designation : null,
                'role_id' => $role,
                'company_id' => $this->customer_id, //
                'email_verified_at' => null, //
                'password' => $hashed_password,
                'status' => $status,
                'remember_token' => null, //
                'utc_created_at' => date('Y-m-d H:i:s'),
                'local_created_at' => $this->local_date_time, //
                'created_by'  => $this->logged_user_id,
            ];
  
            $this->company_user_model->saveUsersConfiguration($data);
            session()->setFlashdata('success', 'Data Updated Successfully.');
            return redirect()->route('company_user_add');
            exit;
  
          } catch (\Exception $e) {
              $currentURL = current_url();
              $this->company_user_model->error('company_user\company_user_controller', $currentURL, 'company_user_save', $e->getMessage());
              return redirect()->route('global_catch_error');
          }
      }

      public function company_user_list()
      {
          try 
          {

          $result = $this->company_user_model->get_data_using_join($this->customer_id);

            $data = array('result' => $result);

            return view("\Modules\company_user\Views\company_user_list", $data);

          } catch (\Exception $e) {
              $currentURL = current_url();
              $this->company_user_model->error('company_user\company_user_controller', $currentURL, 'company_user_list', $e->getMessage());
              return redirect()->route('global_catch_error');
          }
      } 

       //user Edit Code
    public function company_user_edit($id = 0)
    {
        try
        {
            $user_data_whereConditions = [
                'id' => $id,  
            ];
            
            $user_data = $this->company_user_model->GetTableValue('users', '*', $user_data_whereConditions);
      
            $role_data_whereConditions = [
                'company_id' => $this->customer_id,                                    
                'status' => 'active',                                    
            ];

            $role_data = $this->company_user_model->GetTableValue('tbl_roles', 'id,role_name', $role_data_whereConditions); 
                      
            $data = array(
                'user_details' => $user_data,
                'role_details' => $role_data,
            );

            return view("\Modules\company_user\Views\company_user_edit",$data);

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_user_model->error('company_user\company_user_controller', $currentURL, 'company_user_edit', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function update_company_user()
    {
        // try 
        // {
            $user_id = $this->request->getPost("user_id");
            $fullname = $this->request->getPost("fullname");
            $email = $this->request->getPost("email");
            $phone = $this->request->getPost("phone");
            $password = $this->request->getPost('password');
            $conf_password = $this->request->getPost("conf_password");
            $designation = $this->request->getPost("designation");
            $mobile = $this->request->getPost("mobile");
            $address = trim($this->request->getPost("address"));
            $role = $this->request->getPost("role");
            $status = $this->request->getPost("status");
            $phone_code = $this->request->getPost("phone_code");
            $mobile_code = $this->request->getPost("mobile_code");

                $user_email_whereConditions = [
                    'email' => $email,  
                    'id !=' => $user_id                  
                ];

                $email_check = $this->company_user_model->GetTableValue('users', 'id', $user_email_whereConditions); 

                if (!empty($email_check)) {
                session()->setFlashdata('duplicate_record_found', 'Email ID already exists');
                return redirect()->route('company_user_edit',array($user_id));
            }

            $updt_password = '';
            if($password != ''){
            $hashed_password = ($password) ? password_hash((string)$password, PASSWORD_DEFAULT) : $password;
            
           $updt_password = $hashed_password;
        }

          $data = [
              'name' => $fullname,
              'email' => $email,
              'phone' => ($phone != '') ? $phone : null,
              'mobile' => ($mobile != '') ? $mobile : null,
              'address' => ($address != '') ? $address : null,
              'role_id' => $role,
              'designation' => ($designation != '') ? $designation : null,
              'password' => ($updt_password != '') ? $updt_password : null,
              'status' => $status,
              'utc_updated_at' => date('Y-m-d H:i:s'),
              'local_updated_at' => $this->local_date_time,
              'updated_by'  => $this->logged_user_id,
          ];

          $this->company_user_model->updateUsersConfiguration($data,$user_id,$updt_password);
          session()->setFlashdata('success', 'Data Updated Successfully.');
          return redirect()->route('company_user_list');
          exit;

        // } catch (\Exception $e) {
        //     $currentURL = current_url();
        //     $this->company_user_model->error('company_user\company_user_controller', $currentURL, 'update_company_user', $e->getMessage());
        //     return redirect()->route('global_catch_error');
        // }
    }

    //Deleted Code
    public function userdelete()
    {
        try{
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

                $this->company_user_model->updateData('users', $role_whereConditions, $data);

                session()->removeTempdata('company_user_deleted_success');     
                session()->setTempdata('company_user_deleted_success', 'User Deleted Successfully');

                $result = array('success' => 'success');

                echo json_encode($result);
            }

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->company_user_model->error('company_user\company_user_controller', $currentURL, 'userdelete', $e->getMessage());
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
                $this->company_user_model->error('company_user\company_user_controller',$currentURL,'generateRandomUid',$e->getMessage());
                return redirect()->route('global_catch_error');  
            }
        }

    //JS Vesrioning File Get
    public function versioning($page_type = '')
    {
        $data = [
            'page_type' => $page_type,
        ];

        return view('\Modules\company_user\Views\versioning', $data);
    }    

}
