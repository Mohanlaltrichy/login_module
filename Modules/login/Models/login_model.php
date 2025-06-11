<?php
namespace Modules\login\Models;
use App\Libraries\customlibraries;

use CodeIgniter\Model;

class login_model extends Model
{
    public $mysqldb; 
    protected $error_log;

    public function __construct()
    {
        parent::__construct();
        $this->mysqldb = \Config\Database::connect('mysqldb'); 
        $this->error_log = new customlibraries();       
    }

    public function user_login_key_check($user_id = 0)
    {
        try {

            $builder = $this->mysqldb->table('user_login_history');
            $builder->select('login_key');      
            $builder->where('user_id', $user_id);
            $builder->where('logout_time', null);
            $builder->where('key_expiry_time >', date('Y-m-d H:i:s'));
            $result = $builder->get()->getRowArray();

            return $result;

       } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'user_login_key_check',$e->getMessage(), MYSQL_ERROR);                       
       }
    }

    public function company_subscription_active_check($company_id = 0)
    {
        try {
            
            $builder = $this->mysqldb->table('tbl_companies');
            $builder->select('id,company_logo,company_name');      
            $builder->where('id',$company_id);   
            $builder->where('status','active');  
            $builder->where('DATE(subscription_end) >=', date('Y-m-d'));
            $result = $builder->get()->getRowArray();

            return $result;

       } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'company_subscription_active_check',$e->getMessage());                       
       }
    }

    public function dashboard_subscription_active_page_details($company_id = 0)
    {
        try {
            
            $builder = $this->mysqldb->table('tbl_company_page_access_log');
            $builder->select('feature_list,subscription_plan_value');      
            $builder->where('company_id',$company_id);   
            $builder->where('status','Y');       
            $builder->whereIn('feature_list',array('Cloud Connector','Reports','Dashboards','Alert and Notification','AI Prediction'));     
            $result = $builder->get()->getResultArray();
            return $result;

       } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'dashboard_subscription_active_page_details',$e->getMessage());                       
       }
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
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'GetTableValue',$e->getMessage());                       
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
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'insertData',$e->getMessage());            
        }
    }

    //User Session Details Get
    public function get_user_roles_details($role_id = 0, $company_id = 0)
    {
        try{
            $this->mysqldb->transException(true)->transStart();
 
            $builder = $this->mysqldb->table('tbl_roles as tr');    
            $builder->select('trp.page_id,trp.can_view,trp.can_edit,trp.can_delete');
            $builder->join('tbl_role_permissions as trp', 'trp.role_id = tr.id','inner'); 
            $builder->where('trp.company_id',$company_id);
            $builder->where('tr.id',$role_id);
            $builder->orderBy('tr.id','asc');         
            $result = $builder->get()->getResultArray();
            
            $this->mysqldb->transComplete();
 
            return $result; 
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'get_user_roles_details',$e->getMessage());
        }
    } 
    
    public function updateData($table = '',$update_whereConditions = array(), $data = array())
    {
        try {
            $this->mysqldb->transException(true)->transStart();
            $builder = $this->mysqldb->table($table);
            $builder->where($update_whereConditions);
            $builder->update($data);
            $this->mysqldb->transComplete();
        } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error_log->error_exception_log('login\login_Model',$currentURL,'updateData',$e->getMessage(),MYSQL_ERROR);                      
        }
    }
}
?>