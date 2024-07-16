<?php

namespace Modules\global_templates\Controllers;
use Modules\global_templates\Models\templates_model;

use App\Controllers\BaseController;

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

            $sub_number_of_user_whereConditions = [
                'company_id' => $company_id,
                'module_id' => '14',
                'status' => 'Y'                     
            ];

            $sub_user_check = $this->templates_model->GetTableValue('tbl_company_page_access_log', 'subscription_plan_value,feature_list', $sub_number_of_user_whereConditions); 

            if(!empty(array_filter($sub_user_check)))
            {
                $actual_value = $sub_user_check[0]['subscription_plan_value'];
            }
            else
            {
                $actual_value = '0';
            }            

            $user_company_whereConditions = [
                'id' => $company_id,                                   
            ];

            $user_company_check = $this->templates_model->GetTableValue('tbl_companies', 'subscription_id', $user_company_whereConditions); 

            $company_feature_log_whereConditions = [
                'company_id' => $company_id,
                'subscription_id' => $user_company_check[0]['subscription_id'],
                'module_id' => 14,                                   
            ];

            $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions); 

            if(!empty(array_filter($company_feature_log_check)))
            {
                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],                                   
                ];                

                $company_feature_log_data = array(
                    'actual_value' => $actual_value,
                    'user_add_count' => $tag_added_count,
                );

                $tag_count_store = $this->templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);
            }
            else
            {
                $number_user_count_update = array(
                    'company_id' => $company_id,
                    'subscription_id' => $user_company_check[0]['subscription_id'],
                    'module_id' => 14,
                    'feature_name' => $sub_user_check[0]['feature_list'],
                    'actual_value' => $actual_value,
                    'user_add_count' => $tag_added_count,
                );                
    
                $tag_count_store = $this->templates_model->insertData('tbl_company_feature_log', $number_user_count_update);
            }

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

    public function number_of_tag_count_get()
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

        if($login_key_verify_pass != '')
        {
            $user_company_whereConditions = [
                'id' => $company_id,                                   
            ];
    
            $user_company_check = $this->templates_model->GetTableValue('tbl_companies', 'subscription_id', $user_company_whereConditions); 
    
            $company_feature_log_whereConditions = [
                'company_id' => $company_id,
                'subscription_id' => $user_company_check[0]['subscription_id'],
                'module_id' => 14,                                   
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
}
