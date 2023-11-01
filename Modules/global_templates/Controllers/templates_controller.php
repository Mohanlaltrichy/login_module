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
        
        $user_details = $this->templates_model->GetTableValue('user_login_history', 'login_key', $user_whereConditions);

        if(!empty($user_details))
        {
            $data = array(
                'login_key' => ($user_details[0]['login_key']) ? $user_details[0]['login_key'] : '',
            );
        }
        else
        {
            $data = array(
                'login_key' => '',
            );
        }

        return view("\Modules\global_templates\Views\dashboard",$data);        
    } 
    
}
