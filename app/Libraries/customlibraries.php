<?php

namespace App\Libraries;

class customlibraries
{
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
}

?>