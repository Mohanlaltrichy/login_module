<?php
namespace Modules\company_user\Models;
use App\Libraries\customlibraries;
use CodeIgniter\Model;

class company_user_model extends Model
{
    public $mysqldb;   
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;

    public function __construct()
    {
        parent::__construct();
        $this->mysqldb = \Config\Database::connect('mysqldb');       
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id');
    }


    public function saveUsersConfiguration(array $data){
        
        try{
            $this->mysqldb->transException(true)->transStart();

            $users_data_store = $this->insertData('users', $data);
   
            $this->mysqldb->transComplete();

            return true;

        }catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'saveUsersConfiguration',$e->getMessage());                      
        }

    }

    public function updateUsersConfiguration(array $data,$user_id,$updt_password){
        
        try{
            $this->mysqldb->transException(true)->transStart();

            $user_update_where = [
                'id' => $user_id,
                'company_id' => $this->customer_id,
            ];         

            $this->updateData('users', $user_update_where, $data);
   
            $this->mysqldb->transComplete();

            return true;

        }catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'updateUsersConfiguration',$e->getMessage());                      
        }
    }

    public function get_data_using_join($customer_id)
    {
        try{
            $this->mysqldb->transException(true)->transStart();
               
                $query1 = $this->mysqldb->table('users')  
                ->join('tbl_roles', 'tbl_roles.id = users.role_id', 'left')            
                ->join('tbl_companies', 'tbl_companies.id = users.company_id', 'left')       
                ->select('users.*,tbl_roles.role_name,tbl_companies.company_name')
                ->where('users.status !=','deleted')
                ->where('users.company_id',$customer_id);

                // Combine the subqueries using UNION ALL
                $combinedQuery = $query1;               
                // Execute the combined query and get the result
                $result = $combinedQuery->get()->getResultArray();      
                            
            $this->mysqldb->transComplete();  

            return $result;

        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'get_data_using_join',$e->getMessage());
        }
    }

          //GetTableValue
    public function GetTableValue($table = '', $select_column = '', $whereConditions = array(), $or_whereConditions = array(), $groupBy = array(), $having = array(), $order_col = '', $filter = '', $limit ='', $other = '')
    {
        try{
            $this->mysqldb->transException(true)->transStart();

                $builder = $this->mysqldb->table($table);
                $builder->select($select_column);

                if($other == 'distinct')
                {
                    $builder->distinct();
                }

                if($whereConditions != '')
                {
                    $builder->where($whereConditions);
                }

                if($or_whereConditions != '')
                {
                    $builder->orWhere($or_whereConditions);
                }

                if($groupBy != '')
                {
                    $builder->groupBy($groupBy);
                }

                if($having != '')
                {
                    $builder->having($having);
                }
                
                if($limit != '')
                {
                    $builder->limit($limit);
                }

                if($order_col != '')
                {
                    $builder->orderBy($order_col, $filter);
                }
                            
                $result = $builder->get()->getResultArray();

            $this->mysqldb->transComplete();

            return $result; 
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'GetTableValue',$e->getMessage());
        }
    }
 
    //Get Table Wherein Condition
    public function GetTableValue_whereIn($table = '', $select_column = '', $whereConditions = array(), $whereINConditions_column = '', $whereINConditions_value = array(), $order_col = '', $filter = '', $groupBy = array(), $having = array())
    {
        
    try {
            
            $this->mysqldb->transException(true)->transStart();

            $builder = $this->mysqldb->table($table);
            $builder->select($select_column);
        
            if($whereConditions != '')
            {
                $builder->where($whereConditions);
            }

            if($whereINConditions_column != '')
            {
                $builder->whereIn($whereINConditions_column,$whereINConditions_value);
            }           

            if($order_col != '')
            {
                $builder->orderBy($order_col, $filter);
            }

            if($groupBy != '')
            {
                $builder->groupBy($groupBy);
            }

            if($having != '')
            {
                $builder->having($having);
            }
                        
            $result = $builder->get()->getResultArray();

            $this->mysqldb->transComplete();

            return $result; 
    } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'GetTableValue_whereIn',$e->getMessage());                       
    }
    }
 
    //GetTableValuewithjoin
    public function getsearchvaluewithjoin($from_table = '', $from_table_id = '', $select_column = '', $to_table = '', $to_table_id = '', $whereConditions = array(), $order_col = '', $filter = '', $like = '', $limit ='', $offset = '')
    {
        try{
            $this->mysqldb->transException(true)->transStart();

                $builder = $this->mysqldb->table($from_table);
                $builder->join($to_table, ''.$from_table.'.'.$from_table_id.' = '.$to_table.'.'.$to_table_id.'', 'left');
                $builder->select($select_column);

                if($whereConditions != '')
                {
                    $builder->where($whereConditions);
                }

                if($like != '')
                {
                    $builder->like($like);
                }

                if($limit != '')
                {
                    $builder->limit($limit);
                }

                if($offset != '')
                {
                    $builder->offset($offset);
                }                

                if($order_col != '')
                {
                    $builder->orderBy($order_col, $filter);
                }
                            
                $result = $builder->get()->getResultArray();

            $this->mysqldb->transComplete();

            return $result; 
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'getsearchvaluewithjoin',$e->getMessage());
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
            $this->error('company_user\company_user_model',$currentURL,'insertData',$e->getMessage());            
        }
    }   

    //insertBatch Table Value
    public function insertBatchData($table = '', $data = array())
    {
        try {
             $this->mysqldb->transException(true)->transStart();
             $builder = $this->mysqldb->table($table);
             $result = $builder->insertBatch($data);
             $this->mysqldb->transComplete();
             return $this->mysqldb->insertID();
        } catch (\Exception $e) { 
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'insertBatchData',$e->getMessage());          
        }
    }

    //Update Table Value
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
             $this->error('company_user\company_user_model',$currentURL,'updateData',$e->getMessage());                      
         }
     }

    //Delete Table Data
    public function deleteData($table, $delete_whereConditions = array()){
        try {
            $this->mysqldb->transException(true)->transStart();
            $builder = $this->mysqldb->table($table);
            $builder->where($delete_whereConditions);
            $builder->delete();
            $this->mysqldb->transComplete();
        } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error('company_user\company_user_model',$currentURL,'deleteData',$e->getMessage());                       
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