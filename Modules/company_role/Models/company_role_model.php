<?php
namespace Modules\company_role\Models;
use App\Libraries\customlibraries;

use CodeIgniter\Model;

class company_role_model extends Model
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

    //get page details
    public function get_page_details($like = array())
    {
        try{
            $this->mysqldb->transException(true)->transStart();

                $builder = $this->mysqldb->table('tbl_cms_pages as tcp');                              
                $builder->select('tcp.id,tcp.page_name');
                $builder->where('tcp.status','active');      

                if(!empty($like))
                {
                    $builder->like($like);
                }
               
                $builder->orderBy('tcp.id', 'asc');                
                            
                $result = $builder->get()->getResultArray();

            $this->mysqldb->transComplete();

            return $result; 
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('company_role\company_role_model',$currentURL,'get_page_details',$e->getMessage());
        }
    }

    //Add Tag Data Configuration
    public function add_page_roles_details($role_name = '', $description = '', $status = '', $roles_checkbox_id = array(), $roles_all_checkbox_value = '', $roles_checkbox_view = array(), $roles_checkbox_edit = array(), $roles_checkbox_delete = array(), $users_checkbox_id = array(), $users_all_checkbox_value = '', $users_checkbox_view = array(), $users_checkbox_edit = array(), $users_checkbox_delete = array(),$opc_checkbox_id = array(), $opc_all_checkbox_value = '', $opc_checkbox_view = array(), $opc_checkbox_edit = array(), $opc_checkbox_delete = array(), $tag_checkbox_id = array(), $tag_all_checkbox_value = '', $tag_checkbox_view = array(), $tag_checkbox_edit = array(), $tag_checkbox_delete = array(), $mqtt_checkbox_id = array(), $mqtt_all_checkbox_value = '', $mqtt_checkbox_view = array(), $mqtt_checkbox_edit = array(), $mqtt_checkbox_delete = array(), $http_checkbox_id = array(), $http_all_checkbox_value = '', $http_checkbox_view = array(), $http_checkbox_edit = array(), $http_checkbox_delete = array(), $bulk_checkbox_id = array(), $bulk_all_checkbox_value = '', $bulk_checkbox_view = array(), $bulk_checkbox_edit = array(), $bulk_checkbox_delete = array())
    {
        try {

            $this->mysqldb->transException(true)->transStart();

            $role_data_insert = [
            'role_name' => $role_name,
            'description' => $description,
            'company_id' => $this->customer_id,
            'roles_all_pages' => ($roles_all_checkbox_value == '1') ? 'Y' : 'N',
            'users_all_pages' => ($users_all_checkbox_value == '1') ? 'Y' : 'N',
            'opc_all_pages' => ($opc_all_checkbox_value == '1') ? 'Y' : 'N',
            'tag_all_pages' => ($tag_all_checkbox_value == '1') ? 'Y' : 'N',
            'mqtt_all_pages' => ($mqtt_all_checkbox_value == '1') ? 'Y' : 'N',
            'http_all_pages' => ($http_all_checkbox_value == '1') ? 'Y' : 'N',
            'bulk_import_status_all_pages' => ($bulk_all_checkbox_value == '1') ? 'Y' : 'N',
            'status' => $status,
            'utc_created_at' => date('Y-m-d H:i:s'),
            'local_created_at' => $this->local_date_time,
            'created_by' => $this->logged_user_id,
            ];

            $role_id = $this->insertData('tbl_roles', $role_data_insert); 
             
            $roles_data_insert_data[] = '';
            if(!empty($roles_checkbox_id))
            {
                for($i=0; $i < count($roles_checkbox_id); $i++)
                {
                    $roles_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $roles_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($roles_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($roles_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($roles_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $users_data_insert_data[] = '';
            if(!empty($users_checkbox_id))
            {
                for($i=0; $i < count($users_checkbox_id); $i++)
                {
                    $users_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $users_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($users_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($users_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($users_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $opc_data_insert_data[] = '';
            if(!empty($opc_checkbox_id))
            {
                for($i=0; $i < count($opc_checkbox_id); $i++)
                {
                    $opc_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $opc_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($opc_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($opc_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($opc_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $tag_data_insert_data[] = '';
            if(!empty($tag_checkbox_id))
            {
                for($i=0; $i < count($tag_checkbox_id); $i++)
                {
                    $tag_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $tag_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($tag_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($tag_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($tag_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $mqtt_data_insert_data[] = '';
            if(!empty($mqtt_checkbox_id))
            {
                for($i=0; $i < count($mqtt_checkbox_id); $i++)
                {
                    $mqtt_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $mqtt_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mqtt_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mqtt_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mqtt_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $http_data_insert_data[] = '';
            if(!empty($http_checkbox_id))
            {
                for($i=0; $i < count($http_checkbox_id); $i++)
                {
                    $http_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $http_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($http_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($http_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($http_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $bulk_data_insert_data[] = '';
            if(!empty($bulk_checkbox_id))
            {
                for($i=0; $i < count($bulk_checkbox_id); $i++)
                {
                    $bulk_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $bulk_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($bulk_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($bulk_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($bulk_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }
            
            $roles_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($roles_data_insert_data));
            $users_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($users_data_insert_data));
            $opc_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($opc_data_insert_data));
            $tag_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($tag_data_insert_data));
            $mqtt_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mqtt_data_insert_data));
            $http_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($http_data_insert_data));
            $bulk_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($bulk_data_insert_data));         
             
            $this->mysqldb->transComplete();

            if($roles_data_insert_data_id || $users_data_insert_data_id || $opc_data_insert_data_id || $tag_data_insert_data_id ||  $mqtt_data_insert_data_id || $http_data_insert_data_id || $bulk_data_insert_data_id)
            {
                return true;
            }            

        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('company_role\company_role_model',$currentURL,'add_page_roles_details',$e->getMessage());
        }
    }

    //Update Tag Data Configuration
    public function update_page_roles_details($role_id = 0, $role_name = '', $description = '', $status = '', $roles_checkbox_id = array(), $roles_all_checkbox_value = '', $roles_checkbox_view = array(), $roles_checkbox_edit = array(), $roles_checkbox_delete = array(), $users_checkbox_id = array(), $users_all_checkbox_value = '', $users_checkbox_view = array(), $users_checkbox_edit = array(), $users_checkbox_delete = array(), $opc_checkbox_id = array(), $opc_all_checkbox_value = '', $opc_checkbox_view = array(), $opc_checkbox_edit = array(), $opc_checkbox_delete = array(), $tag_checkbox_id = array(), $tag_all_checkbox_value = '', $tag_checkbox_view = array(), $tag_checkbox_edit = array(), $tag_checkbox_delete = array(), $mqtt_checkbox_id = array(), $mqtt_all_checkbox_value = '', $mqtt_checkbox_view = array(), $mqtt_checkbox_edit = array(), $mqtt_checkbox_delete = array(), $http_checkbox_id = array(), $http_all_checkbox_value = '', $http_checkbox_view = array(), $http_checkbox_edit = array(), $http_checkbox_delete = array(), $bulk_checkbox_id = array(), $bulk_all_checkbox_value = '', $bulk_checkbox_view = array(), $bulk_checkbox_edit = array(), $bulk_checkbox_delete = array())
    {
        try {

            $this->mysqldb->transException(true)->transStart();

            $role_update_where = [
                'id' => $role_id,
                'role_name' => $role_name,
                'company_id' => $this->customer_id,
            ];         

            $role_data_update = [
            'description' => $description,           
            'roles_all_pages' => ($roles_all_checkbox_value == '1') ? 'Y' : 'N',
            'users_all_pages' => ($users_all_checkbox_value == '1') ? 'Y' : 'N',
            'opc_all_pages' => ($opc_all_checkbox_value == '1') ? 'Y' : 'N',
            'tag_all_pages' => ($tag_all_checkbox_value == '1') ? 'Y' : 'N',
            'mqtt_all_pages' => ($mqtt_all_checkbox_value == '1') ? 'Y' : 'N',
            'http_all_pages' => ($http_all_checkbox_value == '1') ? 'Y' : 'N',
            'bulk_import_status_all_pages' => ($bulk_all_checkbox_value == '1') ? 'Y' : 'N',
            'status' => $status,
            'utc_updated_at' => date('Y-m-d H:i:s'),
            'local_updated_at' => $this->local_date_time,
            'updated_by' => $this->logged_user_id,
            ];           

            $this->updateData('tbl_roles', $role_update_where,  $role_data_update);

            $role_permissions_del_where = [
                'role_id' => $role_id,
            ];            
            
            $this->deleteData('tbl_role_permissions',$role_permissions_del_where);       
            
            $roles_data_insert_data[] = '';
            if(!empty($roles_checkbox_id))
            {
                for($i=0; $i < count($roles_checkbox_id); $i++)
                {
                    $roles_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $roles_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($roles_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($roles_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($roles_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $users_data_insert_data[] = '';
            if(!empty($users_checkbox_id))
            {
                for($i=0; $i < count($users_checkbox_id); $i++)
                {
                    $users_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $users_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($users_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($users_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($users_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $opc_data_insert_data[] = '';
            if(!empty($opc_checkbox_id))
            {
                for($i=0; $i < count($opc_checkbox_id); $i++)
                {
                    $opc_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $opc_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($opc_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($opc_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($opc_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $tag_data_insert_data[] = '';
            if(!empty($tag_checkbox_id))
            {
                for($i=0; $i < count($tag_checkbox_id); $i++)
                {
                    $tag_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $tag_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($tag_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($tag_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($tag_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $mqtt_data_insert_data[] = '';
            if(!empty($mqtt_checkbox_id))
            {
                for($i=0; $i < count($mqtt_checkbox_id); $i++)
                {
                    $mqtt_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $mqtt_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mqtt_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mqtt_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mqtt_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $http_data_insert_data[] = '';
            if(!empty($http_checkbox_id))
            {
                for($i=0; $i < count($http_checkbox_id); $i++)
                {
                    $http_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $http_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($http_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($http_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($http_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $bulk_data_insert_data[] = '';
            if(!empty($bulk_checkbox_id))
            {
                for($i=0; $i < count($bulk_checkbox_id); $i++)
                {
                    $bulk_data_insert_data[] = array(
                        'role_id'=> $role_id,
                        'page_id' => $bulk_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($bulk_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($bulk_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($bulk_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }
            
            $roles_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($roles_data_insert_data));
            $users_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($users_data_insert_data));
            $opc_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($opc_data_insert_data));
            $tag_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($tag_data_insert_data));
            $mqtt_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mqtt_data_insert_data));
            $http_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($http_data_insert_data));
            $bulk_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($bulk_data_insert_data));         
            
            $this->mysqldb->transComplete();

            if($roles_data_insert_data_id || $users_data_insert_data_id || $opc_data_insert_data_id || $tag_data_insert_data_id ||  $mqtt_data_insert_data_id || $http_data_insert_data_id || $bulk_data_insert_data_id)
            {
                return true;
            }            

        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error('company_role\company_role_model',$currentURL,'update_page_roles_details',$e->getMessage());
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
            $this->error('company_role\company_role_model',$currentURL,'GetTableValue',$e->getMessage());
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
            $this->error('company_role\company_role_model',$currentURL,'GetTableValue_whereIn',$e->getMessage());                       
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
            $this->error('company_role\company_role_model',$currentURL,'getsearchvaluewithjoin',$e->getMessage());
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
            $this->error('company_role\company_role_model',$currentURL,'insertData',$e->getMessage());            
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
            $this->error('company_role\company_role_model',$currentURL,'insertBatchData',$e->getMessage());          
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
             $this->error('company_role\company_role_model',$currentURL,'updateData',$e->getMessage());                      
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
            $this->error('company_role\company_role_model',$currentURL,'deleteData',$e->getMessage());                       
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