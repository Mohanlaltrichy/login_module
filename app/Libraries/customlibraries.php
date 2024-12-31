<?php

namespace App\Libraries;
use Modules\global_templates\Models\templates_model;

class customlibraries
{
    public $mysqldb;

    public function __construct()
    {        
        $this->mysqldb = \Config\Database::connect('mysqldb');  
    }

    //Global JS Get 
    public function versioning($modules='',$page_type='')
    {
        $controller = new $modules;
        return $controller->versioning($page_type);     
    }

    //Global Success ALert Message
    public function global_alert_msg($type = '', $message = '', $message2 = '')
    {
        $modules = '\Modules\global_templates\Controllers\templates_controller';
        $controller = new $modules;

        $data = [
            'type' => $type,
            'message' => $message,
            'message2' => $message2
        ];
        return $controller->global_alert_msg($data);
    }

    //Global Success ALert Message
    public function global_error_alert($message = '')
    {
        $modules = '\Modules\global_templates\Controllers\templates_controller';
        $controller = new $modules;
        return $controller->global_error_alert($message);
    }

    //Local System User Date And Time Get
    public function local_date_time()
    {
        $D = exec('date /T');
        $T = exec('time /T');
        $DT = strtotime(str_replace("/","-",$D." ".$T));
        $local_date_time = (date("Y-m-d H:i:s",$DT));
        return $local_date_time;
    }

    //Number Of User Count Get
    public function number_of_user_count_get()
    {
        $company_feature_log_whereConditions = [
            'company_id' => session('Taguser_company'),              
            'module_id' => 8,                                   
        ];

        $templates_model = new templates_model();

        $company_user_feature_log_check = $templates_model->GetTableValue('tbl_company_feature_log', 'actual_value, user_add_count', $company_feature_log_whereConditions);
        
        $actual_value = array_column($company_user_feature_log_check,'actual_value');
        $user_add_count = array_column($company_user_feature_log_check,'user_add_count');

        $session = session();

        $session->remove('actual_value');
        $session->remove('user_add_count');

        $ses_data = [
            'actual_value'       => implode($actual_value),
            'user_add_count'     => implode($user_add_count)
        
        ];
        $session->set($ses_data); 

        return true;
    }

    //Number Of User Count Update    
    public function number_of_user_count_update(){        
           
        $number_of_user_whereConditions = [
            'company_id' => session('Taguser_company'),
            'status !=' => 'deleted'                     
        ];

        $templates_model = new templates_model();

        $active_user_check = $templates_model->GetTableValue('users', 'id', $number_of_user_whereConditions); 

        if(!empty(array_filter($active_user_check)))
        {
            $user_ids = array_column($active_user_check, 'id');
            $active_user_count = count($user_ids);
        }
        else
        {
            $active_user_count = '0';
        }      

        $company_feature_log_whereConditions = [
            'company_id' => session('Taguser_company'),              
            'module_id' => 8,
        ];

        $company_feature_log_check = $templates_model->GetTableValue('tbl_company_feature_log', 'id,actual_value', $company_feature_log_whereConditions);
        
        $company_feature_log_update_whereConditions = [
            'id' => $company_feature_log_check[0]['id'],                                   
        ];

        $company_feature_log_data = array(                
            'user_add_count' => $active_user_count,
        );

        $users_count_store = $templates_model->updateData('tbl_company_feature_log',$company_feature_log_update_whereConditions, $company_feature_log_data);

        $session = session();

        $session->remove('actual_value');
        $session->remove('user_add_count');

        $ses_data = [
            'actual_value'       => $company_feature_log_check[0]['actual_value'],
            'user_add_count'     => $active_user_count        
        ];
                
        $session->set($ses_data);       

        return true;
    }

    //Error Exception Stored Function
    public function error_exception_log($module_name = '',$current_url = '', $function_name ='', $error_msg = '', $error_source = MYSQL_ERROR)
    {
    
        $this->mysqldb->transException(true)->transStart();
        $data = [           
            'module_name' => $module_name,
            'current_url' => $current_url,
            'function_name' => $function_name,
            'error_msg' => $error_msg,   
            'error_source' => $error_source,
        ];         
                            
        $builder = $this->mysqldb->table('error_exception_log');
        $builder->insert($data);   
        
        $this->mysqldb->transComplete();

        if ($this->mysqldb->transStatus() === true) {
            return redirect()->route('global_catch_error');
        } 
    }
}

?>