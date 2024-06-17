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
}
