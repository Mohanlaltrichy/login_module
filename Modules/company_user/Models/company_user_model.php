<?php
namespace Modules\company_user\Models;
use App\Libraries\customlibraries;
use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class company_user_model extends Model
{
    public $mysqldb;   
    public $pgdb;
    protected $customer_id;
    protected $logged_user_id;
    protected $local_date_time;
    protected $error_log;    

    public function __construct()
    {
        parent::__construct();
        $this->mysqldb = \Config\Database::connect('mysqldb'); 
        $this->pgdb = \Config\Database::connect('default');      
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();       
        $this->customer_id = session('Taguser_company');
        $this->logged_user_id = session('Taguser_id');
        $this->error_log = new customlibraries();
    }


    public function saveUsersConfiguration(string $tablename, array $data){
        
        try{
            $this->mysqldb->transException(true)->transStart();

            $users_data_store = $this->insertData($tablename, $data);           
            
            $this->mysqldb->transComplete();

            return $users_data_store;

        }catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'saveUsersConfiguration',$e->getMessage());                      
        }

    }

    public function updateUsersConfiguration(array $data,$user_id){
        
        try{
            $this->mysqldb->transException(true)->transStart();
            

            $user_update_where = [
                'id' => $user_id,
                'company_id' => $this->customer_id,
            ]; 
            
            //Update audit trail code start
            $old_user_details = $this->GetTableValue('users', 'name,first_name,last_name,middle_name,phone,mobile,address,role_id,department,designation,status,notification_user,notification_user_id,password',$user_update_where); 

            if(!empty($old_user_details))
            {
                $old_name = $old_user_details[0]['name'];
                $old_first_name = $old_user_details[0]['first_name'];
                $old_last_name = $old_user_details[0]['last_name'];
                $old_middle_name = $old_user_details[0]['middle_name'];
                $old_phone = $old_user_details[0]['phone'];
                $old_mob = $old_user_details[0]['mobile'];
                $old_address = $old_user_details[0]['address'];
                $old_role_id = $old_user_details[0]['role_id'];
                $old_department = $old_user_details[0]['department'];
                $old_designation = $old_user_details[0]['designation'];
                $old_status = $old_user_details[0]['status'];
                $old_notification_user = $old_user_details[0]['notification_user'];
                $old_notification_user_id = $old_user_details[0]['notification_user_id'];
                $old_password = $old_user_details[0]['password'];
            }
            else
            {
                $old_name = '';
                $old_first_name = '';
                $old_last_name = '';
                $old_middle_name = '';
                $old_phone = '';
                $old_mob = '';
                $old_address = '';
                $old_role_id = '';
                $old_department = '';
                $old_designation = '';
                $old_status = '';
                $old_notification_user = '';
                $old_notification_user_id = '';
                $old_password = '';
            }

            $randomUid = $this->generateRandomUid();

            $company_user_update_audit_data = [
                'update_key' => $randomUid,
                'customer_id' => session('Taguser_company'),
                'config_type' => 'user',
                'server_id' => session('Taguser_company'),
                'update_type' => 'edit',
                'created_by' => session('Taguser_id'),
                'utc_created_at' => date('Y-m-d H:i:s'),
                'local_created_at' => $this->local_date_time,
            ];
            
            if (trim($data['name']) != trim($old_name)) {
                $company_user_update_audit_data['update_field'] = 'name';
                $company_user_update_audit_data['old_value'] = ($old_name) ? $old_name : null;
                $company_user_update_audit_data['new_value'] = ($data['name']) ? $data['name'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['first_name']) != trim($old_first_name)) {
                $company_user_update_audit_data['update_field'] = 'first_name';
                $company_user_update_audit_data['old_value'] = ($old_first_name) ? $old_first_name : null;
                $company_user_update_audit_data['new_value'] = ($data['first_name']) ? $data['first_name'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['last_name']) != trim($old_last_name)) {
                $company_user_update_audit_data['update_field'] = 'last_name';
                $company_user_update_audit_data['old_value'] = ($old_last_name) ? $old_last_name : null;
                $company_user_update_audit_data['new_value'] = ($data['last_name']) ? $data['last_name'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['middle_name']) != trim($old_middle_name)) {
                $company_user_update_audit_data['update_field'] = 'middle_name';
                $company_user_update_audit_data['old_value'] = ($old_middle_name) ? $old_middle_name : null;
                $company_user_update_audit_data['new_value'] = ($data['middle_name']) ? $data['middle_name'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['phone']) != trim($old_phone)) {
                $company_user_update_audit_data['update_field'] = 'phone';
                $company_user_update_audit_data['old_value'] = ($old_phone) ? $old_phone : null;
                $company_user_update_audit_data['new_value'] = ($data['phone']) ? $data['phone'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['mobile']) != trim($old_mob)) {
                $company_user_update_audit_data['update_field'] = 'mobile';
                $company_user_update_audit_data['old_value'] = ($old_mob) ? $old_mob : null;
                $company_user_update_audit_data['new_value'] = ($data['mobile']) ? $data['mobile'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['address']) != trim($old_address)) {
                $company_user_update_audit_data['update_field'] = 'address';
                $company_user_update_audit_data['old_value'] = ($old_address) ? $old_address : null;
                $company_user_update_audit_data['new_value'] = ($data['address']) ? $data['address'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['role_id']) != trim($old_role_id)) {
                $company_user_update_audit_data['update_field'] = 'role_id';
                $company_user_update_audit_data['old_value'] = ($old_role_id) ? $old_role_id : null;
                $company_user_update_audit_data['new_value'] = ($data['role_id']) ? $data['role_id'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['department']) != trim($old_department)) {
                $company_user_update_audit_data['update_field'] = 'department';
                $company_user_update_audit_data['old_value'] = ($old_department) ? $old_department : null;
                $company_user_update_audit_data['new_value'] = ($data['department']) ? $data['department'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['designation']) != trim($old_designation)) {
                $company_user_update_audit_data['update_field'] = 'designation';
                $company_user_update_audit_data['old_value'] = ($old_designation) ? $old_designation : null;
                $company_user_update_audit_data['new_value'] = ($data['designation']) ? $data['designation'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['status']) != trim($old_status)) {
                $company_user_update_audit_data['update_field'] = 'status';
                $company_user_update_audit_data['old_value'] = ($old_status) ? $old_status : null;
                $company_user_update_audit_data['new_value'] = ($data['status']) ? $data['status'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['notification_user']) != trim($old_notification_user)) {
                $company_user_update_audit_data['update_field'] = 'notification_user';
                $company_user_update_audit_data['old_value'] = ($old_notification_user) ? $old_notification_user : null;
                $company_user_update_audit_data['new_value'] = ($data['notification_user']) ? $data['notification_user'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }

            if (trim($data['notification_user_id']) != trim($old_notification_user_id)) {
                $company_user_update_audit_data['update_field'] = 'notification_user_id';
                $company_user_update_audit_data['old_value'] = ($old_notification_user_id) ? $old_notification_user_id : null;
                $company_user_update_audit_data['new_value'] = ($data['notification_user_id']) ? $data['notification_user_id'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }     
            
            if (isset($data['password']) && trim($data['password']) != trim($old_password)) {
                $company_user_update_audit_data['update_field'] = 'password';
                $company_user_update_audit_data['old_value'] = ($old_password) ? $old_password : null;
                $company_user_update_audit_data['new_value'] = ($data['password']) ? $data['password'] : null;
                $this->insert_data_postgresql('update_audit_trail', $company_user_update_audit_data);
            }            
            //Update audit trail code end

            $this->updateData('users', $user_update_where, $data);

            $this->mysqldb->transComplete();

            return true;

        }catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'updateUsersConfiguration',$e->getMessage());                      
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'get_data_using_join',$e->getMessage());
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'GetTableValue',$e->getMessage());
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'GetTableValue_whereIn',$e->getMessage());                       
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'getsearchvaluewithjoin',$e->getMessage());
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'insertData',$e->getMessage());            
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'insertBatchData',$e->getMessage());          
        }
    }

    //Insert Table Value postgresql
    public function insert_data_postgresql($table = '', $data = array())
    {
        try {
             $this->pgdb->transException(true)->transStart();
             $builder = $this->pgdb->table($table);
             $result = $builder->insert($data);
             $this->pgdb->transComplete();
             return $this->pgdb->insertID();
        } catch (\Exception $e) { 
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'insert_data_postgresql',$e->getMessage(),POSTGRESQL_ERROR);            
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
             $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'updateData',$e->getMessage());                      
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
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'deleteData',$e->getMessage());                       
        }
    }   

    //Random UID Gen
    function generateRandomUid() {

        try{

            $uuid = Uuid::uuid4();
            $randomId = str_replace('-', '',$uuid->toString());
            return $randomId;

        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_user\company_user_model',$currentURL,'generateRandomUid',$e->getMessage());
            return redirect()->route('global_catch_error');  
        }
    }
}
?>