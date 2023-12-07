<?php
namespace Modules\login\Models;

use CodeIgniter\Model;

class login_model extends Model
{
    public $mysqldb; 

    public function __construct()
    {
        parent::__construct();
        $this->mysqldb = \Config\Database::connect('mysqldb');       
    }
       
    //GetTableValue
    public function GetTableValue($table = '', $select_column = '', $whereConditions = array())
    {
       try {
            
            $builder = $this->mysqldb->table($table);
            $builder->select($select_column);

            if($whereConditions != '')
            {
                $builder->where($whereConditions);
            }

            $result = $builder->get()->getRowArray();

            return $result;

       } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error('login\login_Model',$currentURL,'GetTableValue',$e->getMessage());                       
       }
    }

    //Insert Table Value
    public function insertData($table = '', $data = array())
    {
        try {
            $this->mysqldb->transException(true)->transStart();
            $builder = $this->mysqldb->table($table);
            $result = $builder->insert($data);
            $this->mysqldb->transComplete();
            return $this->mysqldb->insertID();
        } catch (\Exception $e) { 
            $currentURL = current_url();            
            $this->error('login\login_Model',$currentURL,'insertData',$e->getMessage());            
        }
    }

    //User Session Details Get
    public function get_user_roles_details($role_id = 0)
    {
        try{
            $this->mysqldb->transException(true)->transStart();
 
            $builder = $this->mysqldb->table('tbl_roles as tr');    
            $builder->select('trp.page_id,trp.can_view,trp.can_edit,trp.can_delete');
            $builder->join('tbl_role_permissions as trp', 'trp.role_id = tr.id','inner'); 
            $builder->where('tr.id',$role_id);
            $builder->orderBy('tr.id','asc');         
            $result = $builder->get()->getResultArray();
            
            $this->mysqldb->transComplete();
 
            return $result; 
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('login\login_Model',$currentURL,'get_user_roles_details',$e->getMessage());
        }
    }

   //Error Exception Stored Function
   public function error($module_name = '',$current_url = '', $function_name ='', $error_msg = '')
   {
       $this->mysqldb->transException(true)->transStart();
       $data = [
           
           'module_name' => $module_name,
           'current_url' => $current_url,
           'function_name' => $function_name,
           'error_msg' => $error_msg,   
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