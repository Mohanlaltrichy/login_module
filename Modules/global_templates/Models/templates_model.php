<?php
namespace Modules\global_templates\Models;

use CodeIgniter\Model;

class templates_model extends Model
{
    public $mysqldb;
    public $pgdb;

    public function __construct()
    {
        parent::__construct();
        $this->mysqldb = \Config\Database::connect('mysqldb');
        $this->pgdb = \Config\Database::connect('default');
    }

    //get notification Last 1 Hour Data
    public function get_notification($last_date_time = '')
    {
        try{   

            $company_id = session('Taguser_company');
            $user_id = session('Taguser_id');

            $notification_user_ids_whereConditions = [
                'login_user_id' => $user_id,   
                'login_user' =>  1,
                'active' => 'yes',
                'notify_sms' => 'active'
            ];            
            $notification_user_ids = $this->GetTableValue('tbl_notification_users', 'id', $notification_user_ids_whereConditions,'','','','id','desc');

            if(!empty($notification_user_ids))
            {
                $user_group_id_whereConditions = [
                    'active' => 1,
                    'user_id' => $notification_user_ids[0]['id']
                ];          
    
                $user_group_id = $this->GetTableValue('tbl_notification_user_mapping', 'grpid', $user_group_id_whereConditions,'','','','id','desc');
           
    
                if(!empty($user_group_id))
                {
                    $alert_notification_whereConditions = [
                        'customer_id' => $company_id,
                        'acknowledge' => 0,
                        'created_at >=' => $last_date_time,
                        'created_at <' => date('Y-m-d h:m:s'),
                        'parameter_name !=' => ''
                    ];

                    

                    if(session('company_admin') != 1)
                    {
                        $grp_id = [];
                        foreach($user_group_id as $grpid)
                        {
                            $grp_id[] = $grpid['grpid'];
                        }
        
                        $data = $this->GetTableValue_whereIn_pgsql('alert_notification', '*', $alert_notification_whereConditions,'user_group_id',$grp_id,'trigger_time','asc');
                       
                    }
                    else
                    {
                        $data = $this->GetTableValue_whereIn_pgsql('alert_notification', '*', $alert_notification_whereConditions,'','','trigger_time','asc');
                    }                   
                    
                }
                else
                {
                    $data = array();
                } 
            }
            else
            {
                $data = array();
            } 

            return $data; 

        } catch(\Exception $e){
            $currentURL = current_url();   
            $this->error('global_templates\templates_model',$currentURL,'get_notification',$e->getMessage());
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
            $this->error('global_templates\templates_model',$currentURL,'getsearchvaluewithjoin',$e->getMessage());
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
                    $builder->limit($limit, $other);
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
            $this->error('global_templates\templates_model',$currentURL,'GetTableValue',$e->getMessage());
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
            $this->error('global_templates\templates_model',$currentURL,'GetTableValue_whereIn',$e->getMessage());                       
       }
    }

    //Get Table Wherein Condition
    public function GetTableValue_whereIn_pgsql($table = '', $select_column = '', $whereConditions = array(), $whereINConditions_column = '', $whereINConditions_value = array(), $order_col = '', $filter = '', $groupBy = array(), $having = array())
    {
        
       try {
            
            $this->pgdb->transException(true)->transStart();

            $builder = $this->pgdb->table($table);
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

            $this->pgdb->transComplete();

            return $result; 
       } catch (\Exception $e) {            
            $currentURL = current_url();            
            $this->error('global_templates\templates_model',$currentURL,'GetTableValue_whereIn_pgsql',$e->getMessage());                       
       }
    }

    //Update Table Value
    public function updateData_whereIn($table = '',$column_name = '',$update_whereInValue = array(), $data = array())
    {
         try {
             $this->pgdb->transException(true)->transStart();
             $builder = $this->pgdb->table($table);
             $builder->whereIn($column_name,$update_whereInValue);
             $builder->update($data);
             $this->pgdb->transComplete();
         } catch (\Exception $e) {            
             $currentURL = current_url();            
             $this->error('global_templates\templates_model',$currentURL,'updateData_whereIn',$e->getMessage());                      
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
            $this->error('global_templates\templates_model',$currentURL,'insertData',$e->getMessage());            
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
             $this->error('global_templates\templates_model',$currentURL,'updateData',$e->getMessage());                      
         }
     }

    
}

?>