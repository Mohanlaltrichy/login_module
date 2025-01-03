<?php

namespace Modules\company_user\Controllers;

use App\Controllers\BaseController;
use Modules\company_user\Models\company_user_model;
use App\Libraries\customlibraries;
use App\Validators\validationrules;
use Ramsey\Uuid\Uuid;
use CodeIgniter\HTTP\CURLRequest;
use Psr\Log\LoggerInterface;

class company_user_controller extends BaseController
{
    protected $company_user_model;
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;
    protected $number_of_user_update;
    protected $error_log;
   
    public function __construct()
    { 
        $this->company_user_model = new company_user_model();
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();
        $this->number_of_user_update = $customlibraries->number_of_user_count_update(); 
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id');
        $this->error_log = new customlibraries(); 
    }

      //company user -view
      public function index()
      {
          try 
          {

            if(session('user_add_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $role_data_whereConditions = [
                'company_id' => $this->customer_id,                                    
                'status' => 'active',                                    
            ];

            $role = $this->company_user_model->GetTableValue('tbl_roles', 'id,role_name', $role_data_whereConditions);         

            $data = ['role' => $role, 'actual_value' => session('actual_value'), 'user_add_count' => session('user_add_count')];

              return view("\Modules\company_user\Views\company_user",$data);
  
          } catch (\Exception $e) {
              $currentURL = current_url();
              $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'index', $e->getMessage());
              return redirect()->route('global_catch_error');
          }
      } 
      
      //Company User Save
      public function save_company_user()
      {
          try 
          {
              if(session('user_add_edit') == '1')
              {
                $first_name = $this->request->getPost("first_name");
                $last_name = $this->request->getPost("last_name");
                $middle_name = $this->request->getPost("middle_name");                
                $email = $this->request->getPost("email");
                $phone = $this->request->getPost("phone");
                $password = $this->request->getPost('password');
                $conf_password = $this->request->getPost("conf_password");
                $designation = $this->request->getPost("designation");
                $mobile = $this->request->getPost("mobile");
                $address = trim((string)$this->request->getPost("address"));
                $role = $this->request->getPost("role");
                $status = $this->request->getPost("status");
                $phone_code = $this->request->getPost("phone_code");
                $mobile_code = $this->request->getPost("mobile_code");
                $user_department = $this->request->getPost("user_department");


                $notification_user = $this->request->getPost("notification_user");             
                $location = $this->request->getPost("location");
                $department = $this->request->getPost("department");
               

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
                    'status !=' => 'deleted'                    
                ];
                $user_or_whereConditions = [
                    'mobile' => $mobile_code,
                    'status !=' => 'deleted'                     
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

                if($middle_name != '')
                {
                    $fullname = $first_name.' '.$middle_name.' '.$last_name;
                }
                else
                {
                    $fullname = $first_name.' '.$last_name;
                }                

                $hashed_password = ($password) ? password_hash((string)$password, PASSWORD_DEFAULT) : $password;
                $randomUid = $this->generateRandomUid();

                $notification_email_whereConditions = [
                    'user_email' => $email,
                    'company_id' => $this->customer_id, 
                    'active' => 'yes'                    
                ];
               
                $notification_email_check = $this->company_user_model->GetTableValue('tbl_notification_users', 'id', $notification_email_whereConditions);

                if(!empty($notification_email_check))
                {
                    $notification_user_id = $notification_email_check[0]['id'];
                }
                else
                {
                    $notification_user_id = '';
                }                

                $data = [
                    'uuid' => $randomUid,
                    'name' => $fullname,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'middle_name' => $middle_name,
                    'email' => $email,
                    'address' => ($address != '') ? $address : null,
                    'mobile' => ($mobile_code != '') ? $mobile_code : null,
                    'phone' => ($phone_code != '') ? $phone_code : null,
                    'department' => ($user_department != '') ? $user_department : null,
                    'designation' => ($designation != '') ? $designation : null,
                    'role_id' => $role,
                    'company_id' => $this->customer_id, //
                    'email_verified_at' => null, //
                    'password' => $hashed_password,
                    'status' => $status,
                    'remember_token' => null, //
                    'notification_user' => ($notification_user == '1' || $notification_user_id > 0) ? 1 : 0,
                    'notification_user_id' => ($notification_user_id > 0) ? $notification_user_id : 0,
                    'utc_created_at' => date('Y-m-d H:i:s'),
                    'local_created_at' => $this->local_date_time, //
                    'created_by'  => $this->logged_user_id,
                ];
    
                $user_id = $this->company_user_model->saveUsersConfiguration('users', $data);

                if($user_id)
                {
                    //Number Of User Count Update Libraries
                    $this->number_of_user_update;
                }

                if($notification_user == '1' || $notification_user_id > 0)
                {
                    if($notification_user_id > 0)
                    {
                        $notification_update_data = [
                        'company_id' => $this->customer_id,
                        'name' => $fullname,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'middle_name' => $middle_name,
                        'location' => $location,
                        'department' => $department,
                        'mobile_no' => ($mobile_code != '') ? $mobile_code : null,
                        'user_email' => $email,                        
                        'national_flag' => '1',
                        'login_user' =>  1,
                        'login_user_id' => $user_id,
                        'login_user_role' => $role,
                        'active' => 'yes', 
                        'updated_by' => $this->logged_user_id
                        ];

                        $notification_user_update_where = [
                            'id' => $notification_user_id,
                        ]; 
                        
                        $this->company_user_model->updateData('tbl_notification_users', $notification_user_update_where, $notification_update_data);
                    }
                    else 
                    {
                        $data = [
                        'company_id' => $this->customer_id,
                        'name' => $fullname,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'middle_name' => $middle_name,
                        'location' => $location,
                        'department' => $department,
                        'mobile_no' => ($mobile_code != '') ? $mobile_code : null,
                        'user_email' => $email,
                        'notify_email' => 'inactive',
                        'notify_sms' => 'inactive',
                        'national_flag' => '1',
                        'login_user' =>  1,
                        'login_user_id' => $user_id,
                        'login_user_role' => $role,
                        'active' => 'yes', 
                        'created_by' => $this->logged_user_id
                        ];

                        $notification_user_id = $this->company_user_model->saveUsersConfiguration('tbl_notification_users', $data);                    

                        $user_update_where = [
                            'id' => $user_id,
                        ];

                        $user_update_data = [
                            'notification_user_id' => $notification_user_id,
                        ];

                        $this->company_user_model->updateData('users', $user_update_where, $user_update_data); 
                    }                  
                }
                

                session()->setFlashdata('success', 'Data Updated Successfully.');
                return redirect()->route('company_user_add');
                exit;
            }
            else
            {
                session()->setFlashdata('duplicate_record_found', 'Data Not Updated Access Denied.');
                return redirect()->route('company_user_add');
                exit;
            }
  
          } catch (\Exception $e) {
              $currentURL = current_url();
              $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'company_user_save', $e->getMessage());
              return redirect()->route('global_catch_error');
          }
      }

      public function company_user_list()
      {
          try 
          {

            if(session('user_view_and_edit_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $result = $this->company_user_model->get_data_using_join($this->customer_id);

            $data = array('result' => $result);

            return view("\Modules\company_user\Views\company_user_list", $data);

          } catch (\Exception $e) {
              $currentURL = current_url();
              $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'company_user_list', $e->getMessage());
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
            
            $notification_user_data_whereConditions = [
                'user_email' => $user_data[0]['email'],
                'company_id' => $this->customer_id,
                'active' => 'yes',  
            ];

            $notification_user_data = $this->company_user_model->GetTableValue('tbl_notification_users', 'id,location,department', $notification_user_data_whereConditions);
        
            $data = array(
                'user_details' => $user_data,
                'role_details' => $role_data,
                'notification_user_data' => $notification_user_data
            );           

            return view("\Modules\company_user\Views\company_user_edit",$data);

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'company_user_edit', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function update_company_user()
    {
        try 
        {
            if(session('user_view_and_edit_edit') == '1') {

                $user_id = $this->request->getPost("user_id");
                $first_name = $this->request->getPost("first_name");
                $last_name = $this->request->getPost("last_name");
                $middle_name = $this->request->getPost("middle_name");
                $email = $this->request->getPost("email");
                $old_email = $this->request->getPost("old_email");
                $phone = $this->request->getPost("phone");
                $password = $this->request->getPost('password');
                $conf_password = $this->request->getPost("conf_password");
                $user_department = $this->request->getPost("user_department");
                $designation = $this->request->getPost("designation");
                $mobile = $this->request->getPost("mobile");
                $old_mobile = $this->request->getPost("old_mobile");
                $address = trim((string)$this->request->getPost("address"));
                $role = $this->request->getPost("role");
                $status = $this->request->getPost("status");
                $phone_code = $this->request->getPost("phone_code");
                $mobile_code = $this->request->getPost("mobile_code");                

                $notification_user = $this->request->getPost("notification_user");
                $location = $this->request->getPost("location");
                $department = $this->request->getPost("department");
                $notification_user_id = $this->request->getPost("notification_user_id");                               

                if($old_mobile != $mobile_code)
                {
                    $user_whereConditions = [
                        'mobile' => $mobile_code,
                        'id !=' => $user_id,
                        'status' => 'active'                     
                    ];                   

                    $mob_check = $this->company_user_model->GetTableValue('users', 'id',$user_whereConditions); 

                    if (!empty($mob_check)) {
                        session()->setFlashdata('duplicate_record_found', 'Mobile Number already exists');
                        return redirect()->route('company_user_edit',array($user_id));
                    }  
                }     
                
                if($middle_name != '')
                {
                    $fullname = $first_name.' '.$middle_name.' '.$last_name;
                }
                else
                {
                    $fullname = $first_name.' '.$last_name;
                }

                $data = [
                    'name' => $fullname,
                    'phone' => ($phone != '') ? $phone_code : null,
                    'mobile' => ($mobile != '') ? $mobile_code : null,
                    'address' => ($address != '') ? $address : null,
                    'role_id' => $role,
                    'department' => ($department != '') ? $department : null,
                    'designation' => ($designation != '') ? $designation : null,
                    'status' => $status,
                    'notification_user' => ($notification_user == '1' || $notification_user_id > 0) ? 1 : 0,
                    'notification_user_id' => ($notification_user_id > 0) ? $notification_user_id : 0,
                    'utc_updated_at' => date('Y-m-d H:i:s'),
                    'local_updated_at' => $this->local_date_time,
                    'updated_by'  => $this->logged_user_id,
                ];

                if($password != ''){
                $hashed_password = ($password) ? password_hash((string)$password, PASSWORD_DEFAULT) : $password;
                
                $data['password'] = $hashed_password;
                }

                $this->company_user_model->updateUsersConfiguration($data,$user_id);

                if($notification_user == '1' || $notification_user_id > 0)
                {

                    if($notification_user_id > 0)
                    {
                        $notification_update_data = [
                        'company_id' => $this->customer_id,
                        'name' => $fullname,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'middle_name' => $middle_name,
                        'location' => $location,
                        'department' => $department,
                        'mobile_no' => ($mobile_code != '') ? $mobile_code : null,
                        'user_email' => $old_email,                        
                        'national_flag' => '1',
                        'login_user' =>  1,
                        'login_user_id' => $user_id,
                        'login_user_role' => $role,
                        'active' => 'yes', 
                        'updated_by' => $this->logged_user_id
                        ];

                        $notification_user_update_where = [
                            'id' => $notification_user_id,
                        ]; 
                        
                        $this->company_user_model->updateData('tbl_notification_users', $notification_user_update_where, $notification_update_data);
                    }
                    else 
                    {
                        $data = [
                            'company_id' => $this->customer_id,
                            'name' => $fullname,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'middle_name' => $middle_name,
                            'location' => $location,
                            'department' => $department,
                            'mobile_no' => ($mobile_code != '') ? $mobile_code : null,
                            'user_email' => $old_email,
                            'notify_email' => 'inactive',
                            'notify_sms' => 'inactive',
                            'national_flag' => '1',
                            'login_user' =>  1,
                            'login_user_id' => $user_id,
                            'login_user_role' => $role,
                            'active' => 'yes', 
                            'created_by' => $this->logged_user_id
                            ];
        
                            $notification_user_id = $this->company_user_model->saveUsersConfiguration('tbl_notification_users', $data);                    
        
                            $user_update_where = [
                                'id' => $user_id,
                            ];
        
                            $user_update_data = [
                                'notification_user_id' => $notification_user_id,
                            ];
        
                            $this->company_user_model->updateData('users', $user_update_where, $user_update_data);
                    }                                       
                }

                
                session()->setFlashdata('success', 'Data Updated Successfully.');
                return redirect()->route('company_user_list');
                exit;
        }
        else
        {
            session()->setFlashdata('msg', 'Data Not Updated Access Denied.');
            return redirect()->route('company_user_list');
            exit;
        }

        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'update_company_user', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Deleted Code
    public function userdelete()
    {
        try{
            if ($this->request->isAJAX()) {

                if(session('user_view_and_edit_delete') == '1') {
               
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
                    
                    //Number Of User Count Update Libraries
                    $this->number_of_user_update;   

                    session()->removeTempdata('company_user_deleted_success');     
                    session()->setTempdata('company_user_deleted_success', 'User Deleted Successfully');

                    $result = array('success' => 'success');
                    echo json_encode($result);
                }
                else
                {
                    $result = array('failed' => 'failed');
                    echo json_encode($result);
                }
            }

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'userdelete', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    

    //notify_user_email_check
    public function notify_user_email_check()
    {
        try{
            if ($this->request->isAJAX()) {               
               
                    $email = $this->request->getGet("email");

                    $notification_user_data_whereConditions = [
                        'user_email' => $email,
                        'company_id' => $this->customer_id,
                        'active' => 'yes',  
                    ];

                    $notification_user_data = $this->company_user_model->GetTableValue('tbl_notification_users', 'id', $notification_user_data_whereConditions);
                            
                    if(!empty($notification_user_data))
                    {
                        $notify_user_available = "yes";
                    }
                    else
                    {
                        $notify_user_available = "no";
                    }                   

                    $result = array('success' => 'success', 'notify_user_available' => $notify_user_available);
                    echo json_encode($result);
                
            }

        }catch(\Exception $e){
            $currentURL = current_url();
            $this->error_log->error_exception_log('company_user\company_user_controller', $currentURL, 'userdelete', $e->getMessage());
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
            $this->error_log->error_exception_log('company_user\company_user_controller',$currentURL,'generateRandomUid',$e->getMessage());
            return redirect()->route('global_catch_error');  
        }
    }

    //JS Vesrioning File Get
    public function versioning($page_type = '')
    {
        try{
            $data = [
                'page_type' => $page_type,
            ];

            return view('\Modules\company_user\Views\versioning', $data);
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_user\company_user_controller',$currentURL,'versioning',$e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');  
        }
    }    

}
