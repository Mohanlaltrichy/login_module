<?php

namespace Modules\global_templates\Controllers;
use Modules\global_templates\Models\templates_model;
use App\Helpers\Validationrules;
use App\Controllers\BaseController;
use PhpParser\Node\Expr\FuncCall;

class templates_controller extends BaseController
{
    protected $templates_model;

    public function __construct()
    {
        $this->templates_model = new templates_model();      
    }

    //Header 
    public function global_header()
    {
        return view("\Modules\global_templates\Views\global_header");
    }

    //Footer
    public function global_footer($type = '')
	{
        $data = [
            'type' => $type,                      
        ];
        
		return view("\Modules\global_templates\Views\global_footer",$data);
	}

    //Global Error Page
    public function global_error_page()
    {
        $data = [
            "error" => "404_error",
        ];
        return view("\Modules\global_templates\Views\global_error_page",$data);
    }

    //Global Forbidden Page
    public function global_forbidden_page()
    {        
        return view("\Modules\global_templates\Views\global_forbidden_page");
    }

    //Global Catch Error Page
    public function global_catch_error()
    {
        $data = [
            "error" => "catch_error",
        ];
        return view("\Modules\global_templates\Views\global_error_page",$data);
    }

    //Global CSS Files
    public function global_css_files()
    {
        return view("\Modules\global_templates\Views\global_css_files");
    }

    //Global JS Files
    public function global_js_files()
    {
        return view("\Modules\global_templates\Views\global_js_files");
    }  
    
    //Global Alert Msg
    public function global_alert_msg($data = array())
    {
        $data = [
            'message' => $data['message'],
            'message2' => $data['message2'],
            'type' => $data['type'],            
        ];

        return view("\Modules\global_templates\Views\global_alert_msg", $data);
    }

    //Dashboard
    public function dashboard() {
        if(empty(session('Taglogged_in')))
        {   
            return redirect()->route('login');
        }

        $user_whereConditions = [
            'user_id' => session('Taguser_id'),                             
        ];
        
        $user_details = $this->templates_model->GetTableValue('user_login_history', 'login_key', $user_whereConditions,'','','','id','desc');

        if(!empty($user_details))
        {
            $data = array(
                'login_key' => ($user_details[0]['login_key']) ? $user_details[0]['login_key'] : '',
                'user_id' => session('Taguser_id'), 
            );
        }
        else
        {
            $data = array(
                'login_key' => '',
                'user_id' => session('Taguser_id'), 
            );
        }

        return view("\Modules\global_templates\Views\dashboard",$data);        
    } 

    public function getnotification()
    {
        try
        {
            if ($this->request->isAJAX()) {             

                $last_date_time = date('Y-m-d h:m:s', strtotime('-1 hour'));

                $data = $this->templates_model->get_notification($last_date_time);       
        
                return $this->response->setJSON($data);
            }
        }catch(\Exception $e){
            $currentURL = current_url();
            $this->templates_model->error('global_templates\getnotification', $currentURL, 'getnotification', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }  
    
    public function get_all_notification()
    {
        try
        {        
            if(session('alert_notification_add_view') != '1') {
                return redirect()->route('forbidden_error');
            }               

            $last_date_time = date('Y-m-d h:m:s', strtotime('-48 hour'));

            $all_notification = $this->templates_model->get_notification($last_date_time);   

            $data = array(
                'all_notification' => $all_notification,
            );
           
            return view("\Modules\global_templates\Views\all_notification",$data); 
            
        }catch(\Exception $e){
            $currentURL = current_url();
            $this->templates_model->error('global_templates\get_all_notification', $currentURL, 'get_all_notification', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    public function edit_company()
    {
        $comp_where = [
            'id' => session('Taguser_company'), 
        ];

        $comp_data = $this->templates_model->GetTableValue('tbl_companies', '*', $comp_where);
        
        $user_where = [
            'company_id' => session('Taguser_company'), 
        ];

        $user_data = $this->templates_model->GetTableValue('users', 'first_name,last_name,email,mobile', $user_where);
        $countries = $this->templates_model->GetTableValue('countries', 'id,name', [], [], 'name');

        $data = array(
            'comp_data' => $comp_data,
            'user_data' => $user_data,
            'countries' => $countries,
        );
        
            return view("\Modules\global_templates\Views/edit_company",$data); 
    }

    public function get_states()
    {
        $country_id = $this->request->getGet('country_id');

        $state_where = [
            'country_id' => $country_id,
        ];

        $states = $this->templates_model->GetTableValue('states', 'id,name', $state_where, [], 'name');

        return response()->setJSON(['states' => $states]);

    }
    public function get_cities()
    {
        $stat_name = $this->request->getGet('state_id');

        $state_where = [
            'name' => $stat_name,
        ];

        $states = $this->templates_model->GetTableValue(
            'states',
            'id',
            $state_where
        );
        $city_where = [
            'state_id' => $states[0]['id'],
        ];

        $cities = $this->templates_model->GetTableValue('cities', 'id,name', $city_where, [], 'name');

        return response()->setJSON(['cities' => $cities]);
    }

    public function update_company()
    {
        try {

            if ($this->request->getMethod() == "post") {

                $session = session();

                $company_name = $this->request->getPost("company_name");
                $email_address = $this->request->getPost("company_email");
                $gstn = $this->request->getPost("gstn");
                $phone = $this->request->getPost("phone");
                $website = $this->request->getPost("website");
                $address = $this->request->getPost("address");
                $city = $this->request->getPost("city");
                $state = $this->request->getPost("state");
                $country = $this->request->getPost("country");
                $pincode = $this->request->getPost("pincode");
                $firstname = $this->request->getPost("firstname");
                $middlename = $this->request->getPost("middlename");
                $lastname = $this->request->getPost("lastname");
                $useremail = $this->request->getPost("useremail");
                $mobile = $this->request->getPost("mobile");
                $logo = $this->request->getFile('logo');

                if ($logo->isValid()) {
                  $filename = $logo->getClientName();
                  $random_name = $logo->getRandomName();
                  $uploadPath = WRITEPATH . 'uploads/logo';
                  $logo->move($uploadPath, $random_name);
                  $path = 'uploads/logo/' . $random_name;
                }

                $validation = \Config\Services::validation();
                $rules = [
                    "company_name" => [
                        "label" => "Company name",
                        "rules" => "required"
                    ],
                    "gstn" => [
                        "label" => "GSTN",
                        "rules" => "required"
                    ],
                    "company_email" => [
                        "label" => "Email",
                        'rules' => 'required|valid_email',
                    ],
                    "firstname" => [
                        "label" => "Firstname",
                        "rules" => "required"
                    ]
                ];

                $countries = $this->templates_model->GetTableValue('countries', 'id,name', [], [], 'name');

                $comp_data[0] = array(
                    'company_name' => $company_name,
                    'company_email' => $email_address,
                    'gstn' => $gstn,
                    'company_phone' => $phone,
                    'company_website' => $phone,
                    'company_address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'zipcode' => $pincode,
                    'logo' => $filename ?? null,
                    'firstname' => $firstname,
                    'middle_name' => $middlename,
                    'lastname' => $lastname,
                    'mobile' => $mobile,
                );

                $user_data[0] = array(
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'email' => $useremail,
                    'mobile' => $mobile,
                );

                $data = array(
                    'comp_data' => $comp_data,
                    'countries' => $countries,
                    'user_data' => $user_data,
                );

                // if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
                if (!$this->validate($rules)) {
                    $session->setFlashdata('msg', $validation->getErrors());
                    return view("\Modules\global_templates\Views/edit_company",$data); 
                }

                $company_name_check = [
                    'company_name' => $company_name
                ];

                $or_where = [
                    'company_email' => $email_address
                ];

                $comp_data = $this->templates_model->GetTableValue('tbl_companies', 'id', $company_name_check, $or_where);
      
                $user_where = [
                    'mobile' => $mobile
                ];

                $user_email_check = $this->templates_model->GetTableValue('users', 'id', $user_where);

                if (count($comp_data) > 1) {
                    $session->setFlashdata('msg', 'Company name or Email already found');
                    return view("\Modules\global_templates\Views/edit_company",$data); 
                }
                if (count($user_email_check) > 1) {
                    $session->setFlashdata('msg', 'Contact mobile number already found');
                    return view("\Modules\global_templates\Views/edit_company",$data); 
                }

                $company_data = [
                    'company_name' => $company_name,
                    'first_name' => $firstname,
                    'middle_name' => ($middlename != '') ? $middlename : null,
                    'last_name' => $lastname,
                    'company_address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'zipcode' => $pincode,
                    'company_email' => $email_address,
                    'company_phone' => ($phone != '') ? $phone : null,
                    'contact_mobile' => $mobile,
                    'company_website' => ($website != '') ? $website : null,
                    'gstn' => $gstn,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => session('Taguser_id'),
                ];
               
                $set_companyname = [
                    'company_name'     => $company_name,
                    'Taguser_name'     => $firstname,
                    'Taguser_email'     => $useremail,
                ];
                $session->set($set_companyname);

                if (isset($path)) {
                    $company_data['company_logo'] = $path;
                        $imagePath = (WRITEPATH . $path);
                        $imageData = file_get_contents($imagePath);
                        $base64Image = base64_encode($imageData);

                        $set_logo = [
                            'logo'     => $base64Image
                        ];
                        $session->set($set_logo);
                }

                $comp_update_where = [
                    'id' => session('Taguser_company'),
                ];

                $this->templates_model->updateData('tbl_companies', $comp_update_where, $company_data);

                $users_data = [
                    'name' => $firstname,
                    'company_name' => $company_name,
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'phone' => ($phone != '') ? $phone : null,
                    'mobile' => $mobile,
                    'utc_updated_at' => date('Y-m-d H:i:s'),
                    'local_updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => '0',
                ];
                
                $user_update_where = [
                    'company_id' => session('Taguser_company'),
                ];

                $this->templates_model->updateData('users', $user_update_where, $users_data);

                session()->setFlashdata('success', 'Data Updated successfully');
                return redirect()->route('edit_company');
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->templates_model->error('global_template\templates_controller', $currentURL, 'update_company', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function acknowledge_notification()
    {
        try{

            if ($this->request->isAJAX()) { 

                $selectedIds = $this->request->getPost("selectedIds");

                $update_data = array(
                    "acknowledge" => 1
                );

                $this->templates_model->updateData_whereIn('alert_notification','id',$selectedIds, $update_data);

                $result = array( 
                    "status" => 'success', 
                    "status_msg" => 'Update Successfully', 
                );  
                return $this->response->setJSON($result);
            }
        }
        catch(\Exception $e){
            $currentURL = current_url();
            $this->templates_model->error('global_templates\acknowledge_notification', $currentURL, 'acknowledge_notification', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Number Of Tag Added Count Update Code Start
    public function number_of_tag_update()
    {
        $data = $this->request->getPost();       

        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $login_key  = $data['login_key'];
           
        } else {
            $company_id = $data['company_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }
        else
        {
            $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
        }    
        

        if($login_key_verify_pass != ''){ 

            $cutomer_whereConditions = [
                'customer_id' => $company_id,                            
            ];

            $opc_nodes_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('opc_nodes','id',$cutomer_whereConditions);
            $opc_events_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('opc_events','id',$cutomer_whereConditions);
            $opc_history_data_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('opc_history_data','id',$cutomer_whereConditions);
            $opc_history_event_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('opc_history_event','id',$cutomer_whereConditions);

            $mqtt_device_node_mapping_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('mqtt_device_node_mapping','id',$cutomer_whereConditions);
            $mqtt_device_event_mapping_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('mqtt_device_event_mapping','id',$cutomer_whereConditions);

            $http_node_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('http_node','id',$cutomer_whereConditions);
            $http_event_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('http_event','id',$cutomer_whereConditions);

            if(!empty(array_filter($opc_nodes_count_check)))
            {
                $opc_nodes_ids = array_column($opc_nodes_count_check, 'id');
                $opc_nodes_count = count($opc_nodes_ids);
            }
            else
            {
                $opc_nodes_count = 0;
            } 

            if(!empty(array_filter($opc_events_count_check)))
            {
                $opc_events_ids = array_column($opc_events_count_check, 'id');
                $opc_events_count = count($opc_events_ids);
            }
            else
            {
                $opc_events_count = 0;
            } 

            if(!empty(array_filter($opc_history_data_count_check)))
            {
                $opc_history_data_ids = array_column($opc_history_data_count_check, 'id');
                $opc_history_data_count = count($opc_history_data_ids);
            }
            else
            {
                $opc_history_data_count = 0;
            }

            if(!empty(array_filter($opc_history_event_count_check)))
            {
                $opc_history_event_ids = array_column($opc_history_event_count_check, 'id');
                $opc_history_event_count = count($opc_history_event_ids);
            }
            else
            {
                $opc_history_event_count = 0;
            }

            if(!empty(array_filter($mqtt_device_node_mapping_count_check)))
            {
                $mqtt_device_node_ids = array_column($mqtt_device_node_mapping_count_check, 'id');
                $mqtt_device_node_count = count($mqtt_device_node_ids);
            }
            else
            {
                $mqtt_device_node_count = 0;
            }

            if(!empty(array_filter($mqtt_device_event_mapping_count_check)))
            {
                $mqtt_device_event_ids = array_column($mqtt_device_event_mapping_count_check, 'id');
                $mqtt_device_event_count = count($mqtt_device_event_ids);
            }
            else
            {
                $mqtt_device_event_count = 0;
            }

            if(!empty(array_filter($http_node_count_check)))
            {
                $http_node_ids = array_column($http_node_count_check, 'id');
                $http_node_count = count($http_node_ids);
            }
            else
            {
                $http_node_count = 0;
            }

            if(!empty(array_filter($http_event_count_check)))
            {
                $http_event_ids = array_column($http_event_count_check, 'id');
                $http_event_count = count($http_event_ids);
            }
            else
            {
                $http_event_count = 0;
            }            

            $tag_added_count = $opc_nodes_count+$opc_events_count+$opc_history_data_count+$opc_history_event_count+$mqtt_device_node_count+$mqtt_device_event_count+$http_node_count+$http_event_count;

            $company_feature_log_whereConditions = [
                'company_id' => $company_id,                
                'module_id' => 14,                                   
            ];

            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions); 
            
            $company_feature_log_update_whereConditions = [
                'id' => $company_feature_log_check[0]['id'],                                   
            ];                

            $company_feature_log_data = array(
                'user_add_count' => $tag_added_count,
            );

            $tag_count_store = $this->templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);            
            
            return $this->response->setJSON([
                'status' => 'success',
                'receivedData' => $tag_count_store
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'receivedData' => ''
            ]);
        }        
    }
    //Number Of Tag Added Count Update Code End   

    //Number Of Historian Table Count Add/Update Code Start
    public function number_of_historian_table_update()
    {
        $data = $this->request->getPost();       

        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $login_key  = $data['login_key'];
           
        } else {
            $company_id = $data['company_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }
        else
        {
            $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
        }

        if($login_key_verify_pass != ''){

            $customer_tabledata_whereConditions = [
                'customer_id' =>$company_id,  
                'status' => 'Y'         
            ];   

            $customer_table_name = $this->templates_model->GetTableValue_whereIn_pgsql('tag_config', 'id', $customer_tabledata_whereConditions);

            if(!empty(array_filter($customer_table_name)))
            {
                $table_ids = array_column($customer_table_name, 'id');
                $historian_table_count = count($table_ids);
            }
            else
            {
                $historian_table_count = 0;
            }                        

            $company_feature_log_whereConditions = [
                'company_id' => $company_id,
                'module_id' => 15,                                   
            ];

            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions); 

           
            $company_feature_log_update_whereConditions = [
                'id' => $company_feature_log_check[0]['id'],                                   
            ];                

            $company_feature_log_data = array(
                'user_add_count' => $historian_table_count,
            );

            $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);
            
            return $this->response->setJSON([
                'status' => 'success',
                'receivedData' => $dashboard_count_store
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'receivedData' => ''
            ]);
        }
    }
    //Number Of Historian Table Count Add/Update Code End

    //Number Of Dashboard Template Count Add/Update Code Start
    public function number_of_dashboard_template_update()
    {
        $data = $this->request->getPost();       

        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $login_key  = $data['login_key'];
           
        } else {
            $company_id = $data['company_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }          
        

        if($login_key_verify_pass != ''){ 

            $dashboard_where = [
                'status !=' => 'D',
                'customer_id' => $company_id,
            ];
    
            $dashboard_data = $this->templates_model->GetTableValue('tbl_dashboard', 'id', $dashboard_where);

            if(!empty(array_filter($dashboard_data)))
            {
                $dashboard_data_ids = array_column($dashboard_data, 'id');
                $dashboard_data_count = count($dashboard_data_ids);
            }
            else
            {
                $dashboard_data_count = 0;
            }                        

            $company_feature_log_whereConditions = [
                'company_id' => $company_id,                
                'module_id' => 26,                                   
            ];

            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions); 
           
            $company_feature_log_update_whereConditions = [
                'id' => $company_feature_log_check[0]['id'],                                   
            ];                

            $company_feature_log_data = array(
                'user_add_count' => $dashboard_data_count,
            );

            $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);
            
            return $this->response->setJSON([
                'status' => 'success',
                'receivedData' => $dashboard_count_store
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'receivedData' => ''
            ]);
        }        
    }
    //Number Of Dashboard Template Count Add/Update Code End

    //Number Of Parameter Count Update Code Start
    public function number_of_parameter_count_update()
    {
        $data_get = $this->request->getPost();

        $jsonKey = key($data_get); // Get the key of the JSON string
        $data = json_decode($jsonKey, true); // Decode the JSON string into an array
        
        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $login_key  = $data['login_key'];
           
        } else {
            $company_id = $data['company_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }
        else
        {
            $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
        }

        if($login_key_verify_pass != ''){ 

            $parameter_where = [
                'company_id' => $company_id,
            ];
    
            $parameter_data = $this->templates_model->GetTableValue('tbl_notification_trigger', 'id', $parameter_where);

            if(!empty(array_filter($parameter_data)))
            {
                $parameter_data_ids = array_column($parameter_data, 'id');
                $parameter_data_count = count($parameter_data_ids);
            }
            else
            {
                $parameter_data_count = 0;
            }                        

            $company_feature_log_whereConditions = [
                'company_id' => $company_id,                
                'module_id' => 27,                                   
            ];

            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions); 
           
            $company_feature_log_update_whereConditions = [
                'id' => $company_feature_log_check[0]['id'],                                   
            ];                

            $company_feature_log_data = array(
                'user_add_count' => $parameter_data_count,
            );

            $parameter_count_store = $this->templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);
            
            return $this->response->setJSON([
                'status' => 'success',
                'receivedData' => $parameter_count_store
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'receivedData' => ''
            ]);
        }       
    }
    //Number Of Parameter Count Update Code End
  
    //Number Of Reports Count Update Code Start   
    public function number_of_reports_count_update()
    {
        $data_get = $this->request->getPost();

        $jsonKey = key($data_get); // Get the key of the JSON string
        $data = json_decode($jsonKey, true); // Decode the JSON string into an array
       
        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $login_key  = $data['login_key'];
           
        } else {
            $company_id = $data['company_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }
        else
        {
            $login_key_verify_pass = $data['company_id']; 
        }

        if($login_key_verify_pass != ''){ 

            $reports_where = [
                'company_id' => $company_id,
            ];
    
            $reports_data = $this->templates_model->GetTableValue('report_configurations', 'id', $reports_where);

            if(!empty(array_filter($reports_data)))
            {
                $reports_data_ids = array_column($reports_data, 'id');
                $reports_data_count = count($reports_data_ids);
            }
            else
            {
                $reports_data_count = 0;
            }                        

            $company_feature_log_whereConditions = [
                'company_id' => $company_id,                
                'module_id' => 25,                                   
            ];

            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions); 
           
            $company_feature_log_update_whereConditions = [
                'id' => $company_feature_log_check[0]['id'],                                   
            ];                

            $company_feature_log_data = array(
                'user_add_count' => $reports_data_count,
            );

            $reports_count_store = $this->templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);
            
            return $this->response->setJSON([
                'status' => 'success',
                'receivedData' => $reports_count_store
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'receivedData' => ''
            ]);
        }       
    }
    //Number Of Reports Count Update Code End

    //Number Of Email & SMS For Month Count Update Code Start
    public function number_of_email_sms_count_update()
    {
        $data_get = $this->request->getPost();

        $jsonKey = key($data_get); // Get the key of the JSON string
        $data = json_decode($jsonKey, true); // Decode the JSON string into an array        
       
        $company_id = $data['company_id'];
        
        if($company_id != ''){ 

            //Email Count Update
            $email_success_where = [
                'tbl_notification_trigger.company_id' => $company_id,
                'tbl_notification_history.email_notification_status' => 1,
            ];

            $select_column = 'tbl_notification_history.id';
    
            $email_success = $this->templates_model->getsearchvaluewithjoin('tbl_notification_trigger',  'id', $select_column, 'tbl_notification_history', 'trigger_id', $email_success_where);
           
            if(!empty(array_filter($email_success)))
            {
                $email_data_ids = array_column($email_success, 'id');
                $email_data_count = count($email_data_ids);
            }
            else
            {
                $email_data_count = 0;
            }

            $email_company_feature_log_whereConditions = [
                'company_id' => $company_id,                
                'module_id' => 28,                                   
            ];

            $email_company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $email_company_feature_log_whereConditions); 
           
            $email_company_feature_log_update_whereConditions = [
                'id' => $email_company_feature_log_check[0]['id'],                                   
            ];                

            $email_company_feature_log_data = array(
                'user_add_count' => $email_data_count,
            );

            $email_count_store = $this->templates_model->updateData('tbl_company_feature_log',$email_company_feature_log_update_whereConditions, $email_company_feature_log_data);

            //SMS Count Update
            $sms_success_where = [
                'tbl_notification_trigger.company_id' => $company_id,
                'tbl_notification_history.sms_notification_status' => 1,
            ];

            $select_column = 'tbl_notification_history.id';
    
            $sms_success = $this->templates_model->getsearchvaluewithjoin('tbl_notification_trigger',  'id', $select_column, 'tbl_notification_history', 'trigger_id', $sms_success_where);
           
            if(!empty(array_filter($sms_success)))
            {
                $sms_data_ids = array_column($sms_success, 'id');
                $sms_data_count = count($sms_data_ids);
            }
            else
            {
                $sms_data_count = 0;
            }

            $sms_company_feature_log_whereConditions = [
                'company_id' => $company_id,                
                'module_id' => 29,                                   
            ];

            $sms_company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $sms_company_feature_log_whereConditions); 
           
            $sms_company_feature_log_update_whereConditions = [
                'id' => $sms_company_feature_log_check[0]['id'],                                   
            ];                

            $sms_company_feature_log_data = array(
                'user_add_count' => $sms_data_count,
            );

            $sms_count_store = $this->templates_model->updateData('tbl_company_feature_log',$sms_company_feature_log_update_whereConditions, $sms_company_feature_log_data);
            
            return $this->response->setJSON([
                'status' => 'success',
                'receivedData' => true,
                'email_count_store' => $email_count_store,
                'sms_count_store' => $sms_count_store
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'receivedData' => ''
            ]);
        }   
    }
    //Number Of Email & SMS For Month Count Update Code End

    //Number Of Count Get Code Start  
    public function number_of_count_get()
    {
        $data = $this->request->getPost();       

        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $module_id  = $data['module_id'];
            $login_key  = $data['login_key'];            
           
        } else {
            $company_id = $data['company_id'];
            $module_id  = $data['module_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }
        else
        {
            $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
        } 

        if($login_key_verify_pass != '')
        {
            $company_feature_log_whereConditions = [
                'company_id' => $company_id,
                'module_id' => $module_id,                                   
            ];
    
            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'actual_value, user_add_count', $company_feature_log_whereConditions);

            return $this->response->setJSON([
                'status' => 'success',
                'actual_value' => $company_feature_log_check[0]['actual_value'],
                'user_add_count' => $company_feature_log_check[0]['user_add_count']
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'actual_value' => '',
                'user_add_count' => ''
            ]);
        }           
    }  
    //Number Of Count Get Code End   
    
    //Number Of Count Get Laravel Code Start  
    public function number_of_count_get_laravel()
    {
        $data_get = $this->request->getPost();

        $jsonKey = key($data_get); // Get the key of the JSON string
        $data = json_decode($jsonKey, true); // Decode the JSON string into an array     

        if (isset($data['company_id']) && isset($data['login_key'])) {
            $company_id = $data['company_id'];
            $module_id  = $data['module_id'];
            $login_key  = $data['login_key'];            
           
        } else {
            $company_id = $data['company_id'];
            $module_id  = $data['module_id'];
            $login_key  = '';
        }

        $login_key_verify_pass = '';
        if($login_key != '')
        {
            $login_key_whereConditions = [
                'login_key' => $login_key,                            
            ];

            $user_login_key =  $this->templates_model->GetTableValue('user_login_history ','user_id,key_expiry_time',$login_key_whereConditions);
            
            if(!empty($user_login_key))
            {
                $user_login_whereConditions = [
                    'id' => $user_login_key[0]['user_id'], 
                    'status' => 'active',          
                ];           
                
                $userData = $this->templates_model->GetTableValue('users','*',$user_login_whereConditions);
                
                if(!empty($userData))
                {
                    $login_key_verify_pass = $userData[0]['id'];
                }                               
            }
        }
        else
        {
            $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
        } 

        if($login_key_verify_pass != '')
        {
            $company_feature_log_whereConditions = [
                'company_id' => $company_id,
                'module_id' => $module_id,                                   
            ];
    
            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'actual_value, user_add_count, start_month, end_month', $company_feature_log_whereConditions);

            return $this->response->setJSON([
                'status' => 'success',
                'actual_value' => $company_feature_log_check[0]['actual_value'],
                'user_add_count' => $company_feature_log_check[0]['user_add_count'],
                'start_month' => $company_feature_log_check[0]['start_month'],
                'end_month' => $company_feature_log_check[0]['end_month']
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'status' => 'failed',
                'actual_value' => '',
                'user_add_count' => '',
                'start_month' => '',
                'end_month' => ''
            ]);
        }           
    }  
    //Number Of Count Get Laravel Code End 
}
