<?php
namespace Modules\login\Models;

use CodeIgniter\Model;

class login_model extends Model
{
    public $mysqldb;
    public $pgdb;

    public function __construct()
    {
        parent::__construct();
        $this->mysqldb = \Config\Database::connect('mysqldb');
        $this->pgdb = \Config\Database::connect('default');
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

   //Error Exception Stored Function
   public function error($module_name = '',$current_url = '', $function_name ='', $error_msg = '')
   {
       $this->pgdb->transException(true)->transStart();
       $data = [
           
           'module_name' => $module_name,
           'current_url' => $current_url,
           'function_name' => $function_name,
           'error_msg' => $error_msg,   
       ];         
                         
       $builder = $this->pgdb->table('error_exception_log');
       $builder->insert($data);
       $this->pgdb->transComplete();

       if ($this->pgdb->transStatus() === true) {
           return redirect()->route('global_catch_error');
       } 
   }
}
?>