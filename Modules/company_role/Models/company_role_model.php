<?php
namespace Modules\company_role\Models;
use App\Libraries\customlibraries;
use Ramsey\Uuid\Uuid;

use CodeIgniter\Model;

class company_role_model extends Model
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'get_page_details',$e->getMessage());
        }
    }

    //Subscription roles page details
    public function get_subscription_page_details()
    {
        try{

            $this->mysqldb->transException(true)->transStart();

            $company_data_whereConditions = [
                'id' => $this->customer_id,                                    
            ];

            $company_details = $this->GetTableValue('tbl_companies', 'subscription_id', $company_data_whereConditions);

            $subscription_data_whereConditions = [
                'id' => $company_details[0]['subscription_id'],                                    
            ];

            $subscription_details = $this->GetTableValue('tbl_subscriptions', 'subscription_name, currency', $subscription_data_whereConditions);

            $query = $this->mysqldb->table('modules_feature_list as mfl')  
                ->join('tbl_company_page_access_log as cpa', 'cpa.module_id = mfl.id', 'inner')            
                ->select('mfl.page_name')
                ->where('mfl.page_name <>','')
                ->where('mfl.status','Y') 
                ->where('cpa.company_id',$this->customer_id)
                ->where('cpa.subscription_plan_type',$subscription_details[0]['subscription_name']) 
                ->where('cpa.subscription_plan_value','Y') 
                ->where('cpa.currency',$subscription_details[0]['currency'])
                ->where('cpa.status','Y');
                              
            // Execute the combined query and get the result
            $result = $query->get()->getResultArray();   

            $this->mysqldb->transComplete();  

            $page_names = array_column($result, 'page_name');

            return $page_names;

        }catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'get_subscription_page_details',$e->getMessage());
        }
    }

    //Add Tag Data Configuration
    public function add_page_roles_details($role_name = '', $description = '', $status = '', $roles_checkbox_id = array(), $roles_all_checkbox_value = '', $roles_checkbox_view = array(), $roles_checkbox_edit = array(), $roles_checkbox_delete = array(), $users_checkbox_id = array(), $users_all_checkbox_value = '', $users_checkbox_view = array(), $users_checkbox_edit = array(), $users_checkbox_delete = array(), $groups_checkbox_id = array(), $groups_all_checkbox_value = '', $groups_checkbox_view = array(), $groups_checkbox_edit = array(), $groups_checkbox_delete = array(), $opc_checkbox_id = array(), $opc_all_checkbox_value = '', $opc_checkbox_view = array(), $opc_checkbox_edit = array(), $opc_checkbox_delete = array(), $tag_checkbox_id = array(), $tag_all_checkbox_value = '', $tag_checkbox_view = array(), $tag_checkbox_edit = array(), $tag_checkbox_delete = array(), $aggregation_checkbox_id = array(), $aggregation_all_checkbox_value = '', $aggregation_checkbox_view = array(), $aggregation_checkbox_edit = array(), $aggregation_checkbox_delete = array(), $mqtt_checkbox_id = array(), $mqtt_all_checkbox_value = '', $mqtt_checkbox_view = array(), $mqtt_checkbox_edit = array(), $mqtt_checkbox_delete = array(), $http_checkbox_id = array(), $http_all_checkbox_value = '', $http_checkbox_view = array(), $http_checkbox_edit = array(), $http_checkbox_delete = array(), $bulk_checkbox_id = array(), $bulk_all_checkbox_value = '', $bulk_checkbox_view = array(), $bulk_checkbox_edit = array(), $bulk_checkbox_delete = array(), $dashboard_checkbox_id = array(), $dashboard_all_checkbox_value = '', $dashboard_checkbox_view = array(), $dashboard_checkbox_edit = array(), $dashboard_checkbox_delete = array(), $reports_checkbox_id = array(), $reports_all_checkbox_value = '', $reports_checkbox_view = array(), $reports_checkbox_edit = array(), $reports_checkbox_delete = array(), $notification_checkbox_id = array(), $notification_all_checkbox_value = '', $notification_checkbox_view = array(), $notification_checkbox_edit = array(), $notification_checkbox_delete = array(), $subscription_checkbox_id = array(), $subscription_all_checkbox_value = '', $subscription_checkbox_view = array(), $subscription_checkbox_edit = array(), $subscription_checkbox_delete = array(), $ai_prediction_checkbox_id = array(), $ai_prediction_all_checkbox_value = '', $ai_prediction_checkbox_view = array(), $ai_prediction_checkbox_edit = array(), $ai_prediction_checkbox_delete = array(),$mb_dataroot_checkbox_id = array(), $mb_dataroot_all_checkbox_value = '', $mb_dataroot_checkbox_view = array(), $mb_dataroot_checkbox_edit = array(), $mb_dataroot_checkbox_delete = array(),$mb_project_checkbox_id=array(),$mb_project_all_checkbox_value="",$mb_project_checkbox_view=array(),$mb_project_checkbox_edit=array(),$mb_project_checkbox_delete=array(),$mb_node_checkbox_id=array(),$mb_node_all_checkbox_value="",$mb_node_checkbox_view=array(),$mb_node_checkbox_edit=array(),$mb_node_checkbox_delete=array(),$mb_node_parameter_checkbox_id=array(),$mb_node_parameter_all_checkbox_value="",$mb_node_parameter_checkbox_view=array(),$mb_node_parameter_checkbox_edit=array(),$mb_node_parameter_checkbox_delete=array(),$mb_node_calculation_checkbox_id=array(),$mb_node_calculation_all_checkbox_value="",$mb_node_calculation_checkbox_view=array(),$mb_node_calculation_checkbox_edit=array(),$mb_node_calculation_checkbox_delete=array(),$mb_node_expression_checkbox_id=array(),$mb_node_expression_all_checkbox_value="",$mb_node_expression_checkbox_view=array(),$mb_node_expression_checkbox_edit=array(),$mb_node_expression_checkbox_delete=array(),$mb_search_checkbox_id=array(),$mb_search_all_checkbox_value="",$mb_search_checkbox_view=array(),$mb_search_checkbox_edit=array(),$mb_search_checkbox_delete=array(),$mb_template_checkbox_id=array(),$mb_template_all_checkbox_value="",$mb_template_checkbox_view=array(),$mb_template_checkbox_edit=array(),$mb_template_checkbox_delete=array(),$mb_template_param_checkbox_id=array(),$mb_template_param_all_checkbox_value="",$mb_template_param_checkbox_view=array(),$mb_template_param_checkbox_edit=array(),$mb_template_param_checkbox_delete=array(),$mb_template_calc_checkbox_id=array(),$mb_template_calc_all_checkbox_value="",$mb_template_calc_checkbox_view=array(),$mb_template_calc_checkbox_edit=array(),$mb_template_calc_checkbox_delete=array(),$mb_template_expr_checkbox_id=array(),$mb_template_expr_all_checkbox_value="",$mb_template_expr_checkbox_view=array(),$mb_template_expr_checkbox_edit=array(),$mb_template_expr_checkbox_delete=array(),$mb_tag_checkbox_id=array(),$mb_tag_all_checkbox_value="",$mb_tag_checkbox_view=array(),$mb_tag_checkbox_edit=array(),$mb_tag_checkbox_delete=array(),$mb_uom_category_checkbox_id=array(),$mb_uom_category_all_checkbox_value="",$mb_uom_category_checkbox_view=array(),$mb_uom_category_checkbox_edit=array(),$mb_uom_category_checkbox_delete=array(),$mb_uom_conversions_checkbox_id=array(),$mb_uom_conversions_all_checkbox_value="",$mb_uom_conversions_checkbox_view=array(),$mb_uom_conversions_checkbox_edit=array(),$mb_uom_conversions_checkbox_delete=array(),$mb_group_checkbox_id=array(),$mb_group_all_checkbox_value="",$mb_group_checkbox_view=array(),$mb_group_checkbox_edit=array(),$mb_group_checkbox_delete=array(),$mb_template_mapped_node_checkbox_id = array(),$mb_template_mapped_node_all_checkbox_value = "",$mb_template_mapped_node_checkbox_view = array(),$mb_template_mapped_node_checkbox_edit = array())
    {
        try {

            $this->mysqldb->transException(true)->transStart();

            $role_data_insert = [
            'role_name' => $role_name,
            'description' => $description,
            'company_id' => $this->customer_id,
            'roles_all_pages' => ($roles_all_checkbox_value == '1') ? 'Y' : 'N',
            'users_all_pages' => ($users_all_checkbox_value == '1') ? 'Y' : 'N',
            'groups_all_pages' => ($groups_all_checkbox_value == '1') ? 'Y' : 'N',
            'opc_all_pages' => ($opc_all_checkbox_value == '1') ? 'Y' : 'N',
            'tag_all_pages' => ($tag_all_checkbox_value == '1') ? 'Y' : 'N',
            'data_aggregation_all_pages' => ($aggregation_all_checkbox_value == '1') ? 'Y' : 'N',
            'mqtt_all_pages' => ($mqtt_all_checkbox_value == '1') ? 'Y' : 'N',
            'http_all_pages' => ($http_all_checkbox_value == '1') ? 'Y' : 'N',
            'bulk_import_status_all_pages' => ($bulk_all_checkbox_value == '1') ? 'Y' : 'N',
            'dashboard_status_all_pages' => ($dashboard_all_checkbox_value == '1') ? 'Y' : 'N',
            'reports_status_all_pages' => ($reports_all_checkbox_value == '1') ? 'Y' : 'N',
            'notify_all_checkbox_value' => ($notification_all_checkbox_value == '1') ? 'Y' : 'N',
            'subscription_all_pages' => ($subscription_all_checkbox_value == '1') ? 'Y' : 'N',
            'ai_prediction_all_pages' => ($ai_prediction_all_checkbox_value == '1') ? 'Y' : 'N',
            // model buulder code starts here
            'mb_dataroot_all_pages' => ($mb_dataroot_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_project_all_pages' => ($mb_project_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_node_all_pages' => ($mb_node_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_node_parameter_all_pages' => ($mb_node_parameter_all_checkbox_value  == '1') ? 'Y' : 'N',
            'mb_node_calculation_all_pages' => ($mb_node_calculation_all_checkbox_value  == '1') ? 'Y' : 'N',
            'mb_node_expression_all_pages' => ($mb_node_expression_all_checkbox_value  == '1') ? 'Y' : 'N',
            'mb_search_all_pages' => ($mb_search_all_checkbox_value  == '1') ? 'Y' : 'N',
            'mb_template_all_pages' => ($mb_template_all_checkbox_value  == '1') ? 'Y' : 'N',
            'mb_template_parameter_all_pages' => ($mb_template_param_all_checkbox_value   == '1') ? 'Y' : 'N',
            'mb_template_calculation_all_pages' => ($mb_template_calc_all_checkbox_value   == '1') ? 'Y' : 'N',
            'mb_template_expression_all_pages' => ($mb_template_expr_all_checkbox_value   == '1') ? 'Y' : 'N',
            'mb_template_mapped_node_all_pages' => ($mb_template_mapped_node_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_tag_all_pages' => ($mb_tag_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_uom_categories_all_pages' => ($mb_uom_category_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_uom_conversions_all_pages' => ($mb_uom_conversions_all_checkbox_value == '1') ? 'Y' : 'N',
            'mb_group_all_pages' => ($mb_group_all_checkbox_value == '1') ? 'Y' : 'N',
            // model builder code ends here
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
                        'company_id' => $this->customer_id,
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
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $users_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($users_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($users_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($users_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $groups_data_insert_data[] = '';
            if(!empty($groups_checkbox_id))
            {
                for($i=0; $i < count($groups_checkbox_id); $i++)
                {
                    $groups_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $groups_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($groups_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($groups_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($groups_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $opc_data_insert_data[] = '';
            if(!empty($opc_checkbox_id))
            {
                for($i=0; $i < count($opc_checkbox_id); $i++)
                {
                    $opc_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
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
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $tag_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($tag_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($tag_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($tag_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $aggregation_data_insert_data[] = '';
            if(!empty($aggregation_checkbox_id))
            {
                for($i=0; $i < count($aggregation_checkbox_id); $i++)
                {
                    $aggregation_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $aggregation_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($aggregation_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($aggregation_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($aggregation_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $mqtt_data_insert_data[] = '';
            if(!empty($mqtt_checkbox_id))
            {
                for($i=0; $i < count($mqtt_checkbox_id); $i++)
                {
                    $mqtt_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
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
                        'company_id' => $this->customer_id,
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
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $bulk_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($bulk_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($bulk_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($bulk_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $dashboard_data_insert_data[] = '';
            if(!empty($dashboard_checkbox_id))
            {
                for($i=0; $i < count($dashboard_checkbox_id); $i++)
                {
                    $dashboard_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $dashboard_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($dashboard_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($dashboard_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($dashboard_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $reports_data_insert_data[] = '';
            if(!empty($reports_checkbox_id))
            {
                for($i=0; $i < count($reports_checkbox_id); $i++)
                {
                    $reports_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $reports_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($reports_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($reports_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($reports_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $notification_data_insert_data[] = '';
            if(!empty($notification_checkbox_id))
            {
                for($i=0; $i < count($notification_checkbox_id); $i++)
                {
                    $notification_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $notification_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($notification_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($notification_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($notification_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $subscription_data_insert_data[] = '';
            if(!empty($subscription_checkbox_id))
            {
                for($i=0; $i < count($subscription_checkbox_id); $i++)
                {
                    $subscription_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $subscription_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($subscription_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($subscription_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($subscription_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $ai_prediction_data_insert_data[] = '';
            if(!empty($ai_prediction_checkbox_id))
            {
                for($i=0; $i < count($ai_prediction_checkbox_id); $i++)
                {
                    $ai_prediction_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $ai_prediction_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($ai_prediction_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($ai_prediction_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($ai_prediction_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            // model builder code strats here
            // dataroot
            $mb_dataroot_data_insert_data = [];
            if (!empty($mb_dataroot_checkbox_id)) {
                for ($i = 0; $i < count($mb_dataroot_checkbox_id); $i++) {
                    $mb_dataroot_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_dataroot_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_dataroot_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_dataroot_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_dataroot_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // dataroot

            // project
            $mb_project_data_insert_data = [];
            if (!empty($mb_project_checkbox_id)) {
                for ($i = 0; $i < count($mb_project_checkbox_id); $i++) {
                    $mb_project_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_project_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_project_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_project_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_project_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // project

            // node
            $mb_node_data_insert_data = [];
            if (!empty($mb_node_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_checkbox_id); $i++) {
                    $mb_node_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node

            // node parameter
            $mb_node_parameter_data_insert_data = [];
            if (!empty($mb_node_parameter_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_parameter_checkbox_id); $i++) {
                    $mb_node_parameter_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_parameter_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_parameter_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_parameter_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_parameter_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node parameter

            // node calculation
            $mb_node_calculation_data_insert_data = [];
            if (!empty($mb_node_calculation_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_calculation_checkbox_id); $i++) {
                    $mb_node_calculation_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_calculation_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_calculation_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_calculation_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_calculation_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node calculation

            // node expression 
            $mb_node_expression_data_insert_data = [];
            if (!empty($mb_node_expression_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_expression_checkbox_id); $i++) {
                    $mb_node_expression_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_expression_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_expression_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_expression_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_expression_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node expression 

            // mb_search
            $mb_search_data_insert_data = [];
            if (!empty($mb_search_checkbox_id)) {
                for ($i = 0; $i < count($mb_search_checkbox_id); $i++) {
                    $mb_search_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_search_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_search_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_search_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_search_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // mb_search

            // template
            $mb_template_data_insert_data = [];
            if (!empty($mb_template_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_checkbox_id); $i++) {
                    $mb_template_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template

            // template parameters
            $mb_template_param_data_insert_data = [];
            if (!empty($mb_template_param_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_param_checkbox_id); $i++) {
                    $mb_template_param_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_param_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_param_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_param_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_param_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template parameters

            // template calculation
            $mb_template_calc_data_insert_data = [];
            if (!empty($mb_template_calc_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_calc_checkbox_id); $i++) {
                    $mb_template_calc_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_calc_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_calc_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_calc_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_calc_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template calculation

            // template expression
            $mb_template_expr_data_insert_data = [];
            if (!empty($mb_template_expr_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_expr_checkbox_id); $i++) {
                    $mb_template_expr_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_expr_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_expr_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_expr_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_expr_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template expression

            // tag
            $mb_tag_data_insert_data = [];
            if (!empty($mb_tag_checkbox_id)) {
                for ($i = 0; $i < count($mb_tag_checkbox_id); $i++) {
                    $mb_tag_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_tag_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_tag_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_tag_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_tag_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // tag

            // uom category
            $mb_uom_category_data_insert_data = [];
            if (!empty($mb_uom_category_checkbox_id)) {
                for ($i = 0; $i < count($mb_uom_category_checkbox_id); $i++) {
                    $mb_uom_category_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_uom_category_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_uom_category_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_uom_category_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_uom_category_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // uom category
            $mb_uom_conversions_data_insert_data = [];
            if (!empty($mb_uom_conversions_checkbox_id)) {
                for ($i = 0; $i < count($mb_uom_conversions_checkbox_id); $i++) {
                    $mb_uom_conversions_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_uom_conversions_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_uom_conversions_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_uom_conversions_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_uom_conversions_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // uom conversions

            // group
            $mb_group_data_insert_data = [];
            if (!empty($mb_group_checkbox_id)) {
                for ($i = 0; $i < count($mb_group_checkbox_id); $i++) {
                    $mb_group_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_group_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_group_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_group_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_group_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // group

            // for template mapped node
            $mb_template_mapped_node_data_insert_data = [];
            if (!empty($mb_template_mapped_node_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_mapped_node_checkbox_id); $i++) {
                    $mb_template_mapped_node_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_mapped_node_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_mapped_node_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_mapped_node_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        // 'can_delete' => ($mb_template_mapped_node_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // for template mapped node
            // uom conversions
            // model builder code strats here

            if(!empty(array_filter($roles_data_insert_data)))
            {
                $roles_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($roles_data_insert_data));
            }

            if(!empty(array_filter($users_data_insert_data)))
            {
                $users_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($users_data_insert_data));
            }

            if(!empty(array_filter($groups_data_insert_data)))
            {
                $groups_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($groups_data_insert_data));
            }

            if(!empty(array_filter($opc_data_insert_data)))
            {
                $opc_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($opc_data_insert_data));
            }

            if(!empty(array_filter($tag_data_insert_data)))
            {
                $tag_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($tag_data_insert_data));
            } 

            if(!empty(array_filter($aggregation_data_insert_data)))
            {
                $aggregation_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($aggregation_data_insert_data));
            } 
            
            if(!empty(array_filter($mqtt_data_insert_data)))
            {
                $mqtt_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mqtt_data_insert_data));
            }

            if(!empty(array_filter($http_data_insert_data)))
            {
                $http_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($http_data_insert_data));
            }

            if(!empty(array_filter($bulk_data_insert_data)))
            {
                $bulk_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($bulk_data_insert_data));  
            }

            if(!empty(array_filter($dashboard_data_insert_data)))
            {
                $dashboard_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($dashboard_data_insert_data));
            }

            if(!empty(array_filter($reports_data_insert_data)))
            {
                $reports_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($reports_data_insert_data));  
            }

            if(!empty(array_filter($notification_data_insert_data)))
            {
                $notification_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($notification_data_insert_data));
            } 
            
            if(!empty(array_filter($subscription_data_insert_data)))
            {
                $subscription_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($subscription_data_insert_data));
            } 

            if(!empty(array_filter($ai_prediction_data_insert_data)))
            {
                $ai_prediction_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($ai_prediction_data_insert_data));
            }

            // model builder code starts here
            // dataroot
            if (!empty(array_filter($mb_dataroot_data_insert_data))) {
                $mb_dataroot_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_dataroot_data_insert_data));
            }
            // dataroot

            // project
            if (!empty(array_filter($mb_project_data_insert_data))) {
                $mb_project_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_project_data_insert_data));
            }
            // project

            // node

            if (!empty(array_filter($mb_node_data_insert_data))) {
                $mb_node_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_data_insert_data));
            }
            // node

            // node parameter
            if (!empty(array_filter($mb_node_parameter_data_insert_data))) {
                $mb_node_parameter_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_parameter_data_insert_data));
            }
            // node parameter

            //ndoe calculation
            if (!empty(array_filter($mb_node_calculation_data_insert_data))) {
                $mb_node_calculation_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_calculation_data_insert_data));
            }
            //ndoe calculation 

            // node expression
            if (!empty(array_filter($mb_node_expression_data_insert_data))) {
                $mb_node_expression_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_expression_data_insert_data));
            }
            // node expression

            // search
            if (!empty(array_filter($mb_search_data_insert_data))) {
                $mb_search_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_search_data_insert_data));
            }
            // search

            // template
            if (!empty(array_filter($mb_template_data_insert_data))) {
                $mb_template_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_data_insert_data));
            }
            // template

            // template parameters
            if (!empty(array_filter($mb_template_param_data_insert_data))) {
                $mb_template_param_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_param_data_insert_data));
            }
            // template parameters

            // template calculations
            if (!empty(array_filter($mb_template_calc_data_insert_data))) {
                $mb_template_calc_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_calc_data_insert_data));
            }
            // template calculations

            // template expression
            if (!empty(array_filter($mb_template_expr_data_insert_data))) {
                $mb_template_expr_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_expr_data_insert_data));
            }
            // template expression

            // tag
            if (!empty(array_filter($mb_tag_data_insert_data))) {
                $mb_tag_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_tag_data_insert_data));
            }
            // tag

            // uom categories
            if (!empty(array_filter($mb_uom_category_data_insert_data))) {
                $mb_uom_category_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_uom_category_data_insert_data));
            }
            // uom categories

            // uom conversions 
            if (!empty(array_filter($mb_uom_conversions_data_insert_data))) {
                $mb_uom_conversions_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_uom_conversions_data_insert_data));
            }
            // uom conversions 

            // group
            if (!empty(array_filter($mb_group_data_insert_data))) {
                $mb_group_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_group_data_insert_data));
            }
            // group

            // for template mapped node
            if (!empty(array_filter($mb_template_mapped_node_data_insert_data))) {
                $mb_template_mapped_node_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_mapped_node_data_insert_data));
            }
            // for template mapped node

            // model builder code ends here

            $this->mysqldb->transComplete();

            if ($roles_data_insert_data_id || $users_data_insert_data_id || $groups_data_insert_data_id || $opc_data_insert_data_id || $tag_data_insert_data_id || $aggregation_data_insert_data_id ||  $mqtt_data_insert_data_id || $http_data_insert_data_id || $bulk_data_insert_data_id || $dashboard_data_insert_data_id || $reports_data_insert_data_id || $notification_data_insert_data_id || $subscription_data_insert_data_id || $ai_prediction_data_insert_data_id || $mb_dataroot_data_insert_data_id || $mb_project_data_insert_data_id || $mb_node_data_insert_data_id || $mb_node_parameter_data_insert_data_id || $mb_node_calculation_data_insert_data_id || $mb_node_expression_data_insert_data_id || $mb_search_data_insert_data_id || $mb_template_data_insert_data_id || $mb_template_param_data_insert_data_id || $mb_template_calc_data_insert_data_id || $mb_template_expr_data_insert_data_id || $mb_tag_data_insert_data_id || $mb_uom_category_data_insert_data_id || $mb_uom_conversions_data_insert_data_id || $mb_group_data_insert_data_id || $mb_template_mapped_node_data_insert_data_id ) {
                return true;
            }
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'add_page_roles_details',$e->getMessage());
        }
    }

    //Update Tag Data Configuration
    public function update_page_roles_details($role_id = 0, $role_name = '', $description = '', $status = '', $roles_checkbox_id = array(), $roles_all_checkbox_value = '', $roles_checkbox_view = array(), $roles_checkbox_edit = array(), $roles_checkbox_delete = array(), $users_checkbox_id = array(), $users_all_checkbox_value = '', $users_checkbox_view = array(), $users_checkbox_edit = array(), $users_checkbox_delete = array(), $groups_checkbox_id = array(), $groups_all_checkbox_value = '', $groups_checkbox_view = array(), $groups_checkbox_edit = array(), $groups_checkbox_delete = array(), $opc_checkbox_id = array(), $opc_all_checkbox_value = '', $opc_checkbox_view = array(), $opc_checkbox_edit = array(), $opc_checkbox_delete = array(), $tag_checkbox_id = array(), $tag_all_checkbox_value = '', $tag_checkbox_view = array(), $tag_checkbox_edit = array(), $tag_checkbox_delete = array(), $aggregation_checkbox_id = array(), $aggregation_all_checkbox_value = '', $aggregation_checkbox_view = array(), $aggregation_checkbox_edit = array(), $aggregation_checkbox_delete = array(),$mqtt_checkbox_id = array(), $mqtt_all_checkbox_value = '', $mqtt_checkbox_view = array(), $mqtt_checkbox_edit = array(), $mqtt_checkbox_delete = array(), $http_checkbox_id = array(), $http_all_checkbox_value = '', $http_checkbox_view = array(), $http_checkbox_edit = array(), $http_checkbox_delete = array(), $bulk_checkbox_id = array(), $bulk_all_checkbox_value = '', $bulk_checkbox_view = array(), $bulk_checkbox_edit = array(), $bulk_checkbox_delete = array(), $dashboard_checkbox_id = array(), $dashboard_all_checkbox_value = '', $dashboard_checkbox_view = array(), $dashboard_checkbox_edit = array(), $dashboard_checkbox_delete = array(), $reports_checkbox_id = array(), $reports_all_checkbox_value = '', $reports_checkbox_view = array(), $reports_checkbox_edit = array(), $reports_checkbox_delete = array(), $notification_checkbox_id = array(), $notification_all_checkbox_value = '', $notification_checkbox_view = array(), $notification_checkbox_edit = array(), $notification_checkbox_delete = array(), $subscription_checkbox_id = array(), $subscription_all_checkbox_value = '', $subscription_checkbox_view = array(), $subscription_checkbox_edit = array(), $subscription_checkbox_delete = array(),$ai_prediction_checkbox_id = array(), $ai_prediction_all_checkbox_value = '', $ai_prediction_checkbox_view = array(), $ai_prediction_checkbox_edit = array(), $ai_prediction_checkbox_delete = array(),$mb_dataroot_checkbox_id = array(), $mb_dataroot_all_checkbox_value = '', $mb_dataroot_checkbox_view = array(), $mb_dataroot_checkbox_edit = array(), $mb_dataroot_checkbox_delete = array(),$mb_project_checkbox_id=array(),$mb_project_all_checkbox_value="",$mb_project_checkbox_view=array(),$mb_project_checkbox_edit=array(),$mb_project_checkbox_delete=array(),$mb_node_checkbox_id=array(),$mb_node_all_checkbox_value="",$mb_node_checkbox_view=array(),$mb_node_checkbox_edit=array(),$mb_node_checkbox_delete=array(),$mb_node_parameter_checkbox_id=array(),$mb_node_parameter_all_checkbox_value="",$mb_node_parameter_checkbox_view=array(),$mb_node_parameter_checkbox_edit=array(),$mb_node_parameter_checkbox_delete=array(),$mb_node_calculation_checkbox_id=array(),$mb_node_calculation_all_checkbox_value="",$mb_node_calculation_checkbox_view=array(),$mb_node_calculation_checkbox_edit=array(),$mb_node_calculation_checkbox_delete=array(),$mb_node_expression_checkbox_id=array(),$mb_node_expression_all_checkbox_value="",$mb_node_expression_checkbox_view=array(),$mb_node_expression_checkbox_edit=array(),$mb_node_expression_checkbox_delete=array(),$mb_search_checkbox_id=array(),$mb_search_all_checkbox_value="",$mb_search_checkbox_view=array(),$mb_search_checkbox_edit=array(),$mb_search_checkbox_delete=array(),$mb_template_checkbox_id=array(),$mb_template_all_checkbox_value="",$mb_template_checkbox_view=array(),$mb_template_checkbox_edit=array(),$mb_template_checkbox_delete=array(),$mb_template_param_checkbox_id=array(),$mb_template_param_all_checkbox_value="",$mb_template_param_checkbox_view=array(),$mb_template_param_checkbox_edit=array(),$mb_template_param_checkbox_delete=array(),$mb_template_calc_checkbox_id=array(),$mb_template_calc_all_checkbox_value="",$mb_template_calc_checkbox_view=array(),$mb_template_calc_checkbox_edit=array(),$mb_template_calc_checkbox_delete=array(),$mb_template_expr_checkbox_id=array(),$mb_template_expr_all_checkbox_value="",$mb_template_expr_checkbox_view=array(),$mb_template_expr_checkbox_edit=array(),$mb_template_expr_checkbox_delete=array(),$mb_tag_checkbox_id=array(),$mb_tag_all_checkbox_value="",$mb_tag_checkbox_view=array(),$mb_tag_checkbox_edit=array(),$mb_tag_checkbox_delete=array(),$mb_uom_category_checkbox_id=array(),$mb_uom_category_all_checkbox_value="",$mb_uom_category_checkbox_view=array(),$mb_uom_category_checkbox_edit=array(),$mb_uom_category_checkbox_delete=array(),$mb_uom_conversions_checkbox_id=array(),$mb_uom_conversions_all_checkbox_value="",$mb_uom_conversions_checkbox_view=array(),$mb_uom_conversions_checkbox_edit=array(),$mb_uom_conversions_checkbox_delete=array(),$mb_group_checkbox_id=array(),$mb_group_all_checkbox_value="",$mb_group_checkbox_view=array(),$mb_group_checkbox_edit=array(),$mb_group_checkbox_delete=array(),$mb_template_mapped_node_checkbox_id = array(),$mb_template_mapped_node_all_checkbox_value = "",$mb_template_mapped_node_checkbox_view = array(),$mb_template_mapped_node_checkbox_edit = array())
    {
        try {

            $this->mysqldb->transException(true)->transStart();

            $role_update_where = [
                'id' => $role_id,
                'role_name' => $role_name,
                'company_id' => $this->customer_id,
            ];     
            
            //Update audit trail code start
            $old_role_data = $this->GetTableValue('tbl_roles', 'description,roles_all_pages,users_all_pages,groups_all_pages,opc_all_pages,tag_all_pages,data_aggregation_all_pages,mqtt_all_pages,http_all_pages,bulk_import_status_all_pages,dashboard_status_all_pages,reports_status_all_pages,notify_all_checkbox_value,subscription_all_pages,ai_prediction_all_pages,mb_dataroot_all_pages,mb_project_all_pages,mb_node_all_pages,mb_node_parameter_all_pages,mb_node_calculation_all_pages,mb_node_expression_all_pages,mb_search_all_pages,mb_template_all_pages,mb_template_parameter_all_pages,mb_template_calculation_all_pages,mb_template_expression_all_pages,mb_tag_all_pages,mb_uom_categories_all_pages,mb_uom_conversions_all_pages,mb_group_all_pages,mb_template_mapped_node_all_pages,status,', $role_update_where); 

            if(!empty($old_role_data))
            {
                $old_description = $old_role_data[0]['description'];
                $old_roles_all_pages = $old_role_data[0]['roles_all_pages'];
                $old_users_all_pages = $old_role_data[0]['users_all_pages'];
                $old_groups_all_pages = $old_role_data[0]['groups_all_pages'];
                $old_opc_all_pages = $old_role_data[0]['opc_all_pages'];
                $old_tag_all_pages = $old_role_data[0]['tag_all_pages'];
                $old_data_aggregation_all_pages = $old_role_data[0]['data_aggregation_all_pages'];
                $old_mqtt_all_pages = $old_role_data[0]['mqtt_all_pages'];
                $old_http_all_pages = $old_role_data[0]['http_all_pages'];
                $old_bulk_import_status_all_pages = $old_role_data[0]['bulk_import_status_all_pages'];
                $old_dashboard_status_all_pages = $old_role_data[0]['dashboard_status_all_pages'];
                $old_reports_status_all_pages = $old_role_data[0]['reports_status_all_pages'];
                $old_notify_all_checkbox_value = $old_role_data[0]['notify_all_checkbox_value'];
                $old_subscription_all_pages = $old_role_data[0]['subscription_all_pages'];
                $old_ai_prediction_all_pages = $old_role_data[0]['ai_prediction_all_pages'];                
                $old_status = $old_role_data[0]['status'];

                // codes for model builder
                $old_mb_dataroot_all_pages = $old_role_data[0]['mb_dataroot_all_pages'];
                $old_mb_project_all_pages = $old_role_data[0]['mb_project_all_pages'];
                $old_mb_node_all_pages = $old_role_data[0]['mb_node_all_pages'];
                $old_mb_node_parameter_all_pages = $old_role_data[0]['mb_node_parameter_all_pages'];
                $old_mb_node_calculation_all_pages = $old_role_data[0]['mb_node_calculation_all_pages'];
                $old_mb_node_expression_all_pages = $old_role_data[0]['mb_node_expression_all_pages'];
                $old_mb_search_all_pages = $old_role_data[0]['mb_search_all_pages'];
                $old_mb_template_all_pages = $old_role_data[0]['mb_template_all_pages'];
                $old_mb_template_parameter_all_pages = $old_role_data[0]['mb_template_parameter_all_pages'];
                $old_mb_template_calculation_all_pages = $old_role_data[0]['mb_template_calculation_all_pages'];
                $old_mb_template_expression_all_pages = $old_role_data[0]['mb_template_expression_all_pages'];
                $old_mb_tag_all_pages = $old_role_data[0]['mb_tag_all_pages'];
                $old_mb_uom_categories_all_pages = $old_role_data[0]['mb_uom_categories_all_pages'];
                $old_mb_uom_conversions_all_pages = $old_role_data[0]['mb_uom_conversions_all_pages'];
                $old_mb_group_all_pages = $old_role_data[0]['mb_group_all_pages'];
                $old_mb_template_mapped_node_all_pages = $old_role_data[0]['mb_template_mapped_node_all_pages'];

                // codes for model builder
            }
            else
            {
                $old_description = '';
                $old_roles_all_pages = '';
                $old_users_all_pages = '';
                $old_groups_all_pages = '';
                $old_opc_all_pages = '';
                $old_tag_all_pages =  '';
                $old_data_aggregation_all_pages = '';
                $old_mqtt_all_pages = '';
                $old_http_all_pages = '';
                $old_bulk_import_status_all_pages = '';
                $old_dashboard_status_all_pages = '';
                $old_reports_status_all_pages = '';
                $old_notify_all_checkbox_value = '';
                $old_subscription_all_pages = '';
                $old_ai_prediction_all_pages = '';
                $old_status = '';

                // model builder codes
                $old_mb_dataroot_all_pages = '';
                $old_mb_project_all_pages = '';
                $old_mb_node_all_pages = '';
                $old_mb_node_parameter_all_pages = '';
                $old_mb_node_calculation_all_pages = '';
                $old_mb_node_expression_all_pages = '';
                $old_mb_search_all_pages = '';
                $old_mb_template_all_pages = '';
                $old_mb_template_parameter_all_pages = '';
                $old_mb_template_calculation_all_pages = '';
                $old_mb_template_expression_all_pages = '';
                $old_mb_tag_all_pages = '';
                $old_mb_uom_categories_all_pages = '';
                $old_mb_uom_conversions_all_pages = '';
                $old_mb_group_all_pages = '';
                $old_mb_template_mapped_node_all_pages = '';

                // model builder codes
            }

            $randomUid = $this->generateRandomUid();

            $role_update_audit_data = [
                'update_key' => $randomUid,
                'customer_id' => session('Taguser_company'),
                'config_type' => 'roles',
                'server_id' => session('Taguser_company'),
                'update_type' => 'edit',
                'created_by' => session('Taguser_id'),
                'utc_created_at' => date('Y-m-d H:i:s'),
                'local_created_at' => $this->local_date_time,
            ];  

            // print_r($role_update_audit_data);exit;

            if (trim($description) != trim($old_description)) {
                $role_update_audit_data['update_field'] = 'description';
                $role_update_audit_data['old_value'] = ($old_description) ? $old_description : null;
                $role_update_audit_data['new_value'] = ($description) ? $description : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_roles_all_pages = ($roles_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_roles_all_pages) != trim($old_roles_all_pages)) {
                $role_update_audit_data['update_field'] = 'roles_all_pages';
                $role_update_audit_data['old_value'] = ($old_roles_all_pages) ? $old_roles_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_roles_all_pages) ? $new_roles_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_users_all_pages = ($users_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_users_all_pages) != trim($old_users_all_pages)) {
                $role_update_audit_data['update_field'] = 'users_all_pages';
                $role_update_audit_data['old_value'] = ($old_users_all_pages) ? $old_users_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_users_all_pages) ? $new_users_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_groups_all_pages = ($groups_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_groups_all_pages) != trim($old_groups_all_pages)) {
                $role_update_audit_data['update_field'] = 'groups_all_pages';
                $role_update_audit_data['old_value'] = ($old_groups_all_pages) ? $old_groups_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_groups_all_pages) ? $new_groups_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_opc_all_pages = ($opc_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_opc_all_pages) != trim($old_opc_all_pages)) {
                $role_update_audit_data['update_field'] = 'opc_all_pages';
                $role_update_audit_data['old_value'] = ($old_opc_all_pages) ? $old_opc_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_opc_all_pages) ? $new_opc_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_tag_all_pages = ($tag_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_tag_all_pages) != trim($old_tag_all_pages)) {
                $role_update_audit_data['update_field'] = 'tag_all_pages';
                $role_update_audit_data['old_value'] = ($old_tag_all_pages) ? $old_tag_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_tag_all_pages) ? $new_tag_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_data_aggregation_all_pages = ($aggregation_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_data_aggregation_all_pages) != trim($old_data_aggregation_all_pages)) {
                $role_update_audit_data['update_field'] = 'data_aggregation_all_pages';
                $role_update_audit_data['old_value'] = ($old_data_aggregation_all_pages) ? $old_data_aggregation_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_data_aggregation_all_pages) ? $new_data_aggregation_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mqtt_all_pages = ($mqtt_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mqtt_all_pages) != trim($old_mqtt_all_pages)) {
                $role_update_audit_data['update_field'] = 'mqtt_all_pages';
                $role_update_audit_data['old_value'] = ($old_mqtt_all_pages) ? $old_mqtt_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mqtt_all_pages) ? $new_mqtt_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_http_all_pages = ($http_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_http_all_pages) != trim($old_http_all_pages)) {
                $role_update_audit_data['update_field'] = 'http_all_pages';
                $role_update_audit_data['old_value'] = ($old_http_all_pages) ? $old_http_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_http_all_pages) ? $new_http_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_bulk_import_status_all_pages = ($bulk_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_bulk_import_status_all_pages) != trim($old_bulk_import_status_all_pages)) {
                $role_update_audit_data['update_field'] = 'bulk_import_status_all_pages';
                $role_update_audit_data['old_value'] = ($old_bulk_import_status_all_pages) ? $old_bulk_import_status_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_bulk_import_status_all_pages) ? $new_bulk_import_status_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_dashboard_status_all_pages = ($dashboard_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_dashboard_status_all_pages) != trim($old_dashboard_status_all_pages)) {
                $role_update_audit_data['update_field'] = 'dashboard_status_all_pages';
                $role_update_audit_data['old_value'] = ($old_dashboard_status_all_pages) ? $old_dashboard_status_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_dashboard_status_all_pages) ? $new_dashboard_status_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_reports_status_all_pages = ($reports_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_reports_status_all_pages) != trim($old_reports_status_all_pages)) {
                $role_update_audit_data['update_field'] = 'reports_status_all_pages';
                $role_update_audit_data['old_value'] = ($old_reports_status_all_pages) ? $old_reports_status_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_reports_status_all_pages) ? $new_reports_status_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_notify_all_checkbox_value = ($notification_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_notify_all_checkbox_value) != trim($old_notify_all_checkbox_value)) {
                $role_update_audit_data['update_field'] = 'notify_all_checkbox_value';
                $role_update_audit_data['old_value'] = ($old_notify_all_checkbox_value) ? $old_notify_all_checkbox_value : null;
                $role_update_audit_data['new_value'] = ($new_notify_all_checkbox_value) ? $new_notify_all_checkbox_value : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_subscription_all_pages = ($subscription_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_subscription_all_pages) != trim($old_subscription_all_pages)) {
                $role_update_audit_data['update_field'] = 'subscription_all_pages';
                $role_update_audit_data['old_value'] = ($old_subscription_all_pages) ? $old_subscription_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_subscription_all_pages) ? $new_subscription_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_ai_prediction_all_pages = ($ai_prediction_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_ai_prediction_all_pages) != trim($old_ai_prediction_all_pages)) {
                $role_update_audit_data['update_field'] = 'ai_prediction_all_pages';
                $role_update_audit_data['old_value'] = ($old_ai_prediction_all_pages) ? $old_ai_prediction_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_ai_prediction_all_pages) ? $new_ai_prediction_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            if (trim($status) != trim($old_status)) {
                $role_update_audit_data['update_field'] = 'status';
                $role_update_audit_data['old_value'] = ($old_status) ? $old_status : null;
                $role_update_audit_data['new_value'] = ($status) ? $status : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            // model buukder code starts here
            $new_mb_dataroot_all_pages = ($mb_dataroot_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_dataroot_all_pages) != trim($old_mb_dataroot_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_dataroot_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_dataroot_all_pages) ? $old_mb_dataroot_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_dataroot_all_pages) ? $new_mb_dataroot_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_project_all_pages = ($mb_project_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_project_all_pages) != trim($old_mb_project_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_project_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_project_all_pages) ? $old_mb_project_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_project_all_pages) ? $new_mb_project_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_node_all_pages = ($mb_node_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_node_all_pages) != trim($old_mb_node_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_node_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_node_all_pages) ? $old_mb_node_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_node_all_pages) ? $new_mb_node_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_node_parameter_all_pages = ($mb_node_parameter_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_node_parameter_all_pages) != trim($old_mb_node_parameter_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_node_parameter_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_node_parameter_all_pages) ? $old_mb_node_parameter_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_node_parameter_all_pages) ? $new_mb_node_parameter_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_node_calculation_all_pages = ($mb_node_calculation_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_node_calculation_all_pages) != trim($old_mb_node_calculation_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_node_calculation_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_node_calculation_all_pages) ? $old_mb_node_calculation_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_node_calculation_all_pages) ? $new_mb_node_calculation_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_node_expression_all_pages = ($mb_node_expression_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_node_expression_all_pages) != trim($old_mb_node_expression_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_node_expression_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_node_expression_all_pages) ? $old_mb_node_expression_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_node_expression_all_pages) ? $new_mb_node_expression_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_search_all_pages = ($mb_search_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_search_all_pages) != trim($old_mb_search_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_search_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_search_all_pages) ? $old_mb_search_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_search_all_pages) ? $new_mb_search_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_template_all_pages = ($mb_template_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_template_all_pages) != trim($old_mb_template_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_template_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_template_all_pages) ? $old_mb_template_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_template_all_pages) ? $new_mb_template_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_template_parameter_all_pages = ($mb_template_param_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_template_parameter_all_pages) != trim($old_mb_template_parameter_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_template_parameter_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_template_parameter_all_pages) ? $old_mb_template_parameter_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_template_parameter_all_pages) ? $new_mb_template_parameter_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_template_calculation_all_pages = ($mb_template_calc_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_template_calculation_all_pages) != trim($old_mb_template_calculation_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_template_calculation_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_template_calculation_all_pages) ? $old_mb_template_calculation_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_template_calculation_all_pages) ? $new_mb_template_calculation_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_template_expression_all_pages = ($mb_template_expr_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_template_expression_all_pages) != trim($old_mb_template_expression_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_template_expression_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_template_expression_all_pages) ? $old_mb_template_expression_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_template_expression_all_pages) ? $new_mb_template_expression_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_tag_all_pages = ($mb_tag_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_tag_all_pages) != trim($old_mb_tag_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_tag_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_tag_all_pages) ? $old_mb_tag_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_tag_all_pages) ? $new_mb_tag_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_uom_categories_all_pages = ($mb_uom_category_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_uom_categories_all_pages) != trim($old_mb_uom_categories_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_uom_categories_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_uom_categories_all_pages) ? $old_mb_uom_categories_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_uom_categories_all_pages) ? $new_mb_uom_categories_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_uom_conversions_all_pages = ($mb_uom_conversions_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_uom_conversions_all_pages) != trim($old_mb_uom_conversions_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_uom_conversions_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_uom_conversions_all_pages) ? $old_mb_uom_conversions_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_uom_conversions_all_pages) ? $new_mb_uom_conversions_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_group_all_pages = ($mb_group_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_group_all_pages) != trim($old_mb_group_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_group_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_group_all_pages) ? $old_mb_group_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_group_all_pages) ? $new_mb_group_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }

            $new_mb_template_mapped_node_all_pages = ($mb_template_mapped_node_all_checkbox_value == '1') ? 'Y' : 'N';
            if (trim($new_mb_template_mapped_node_all_pages) != trim($old_mb_template_mapped_node_all_pages)) {
                $role_update_audit_data['update_field'] = 'mb_template_mapped_node_all_pages';
                $role_update_audit_data['old_value'] = ($old_mb_template_mapped_node_all_pages) ? $old_mb_template_mapped_node_all_pages : null;
                $role_update_audit_data['new_value'] = ($new_mb_template_mapped_node_all_pages) ? $new_mb_template_mapped_node_all_pages : null;
                $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
            }


            // model buukder code ends here
            //Update audit trail code end

            $role_data_update = [
            'description' => $description,           
            'roles_all_pages' => ($roles_all_checkbox_value == '1') ? 'Y' : 'N',
            'users_all_pages' => ($users_all_checkbox_value == '1') ? 'Y' : 'N',
            'groups_all_pages' => ($groups_all_checkbox_value == '1') ? 'Y' : 'N',
            'opc_all_pages' => ($opc_all_checkbox_value == '1') ? 'Y' : 'N',
            'tag_all_pages' => ($tag_all_checkbox_value == '1') ? 'Y' : 'N',
            'data_aggregation_all_pages' => ($aggregation_all_checkbox_value == '1') ? 'Y' : 'N',
            'mqtt_all_pages' => ($mqtt_all_checkbox_value == '1') ? 'Y' : 'N',
            'http_all_pages' => ($http_all_checkbox_value == '1') ? 'Y' : 'N',
            'bulk_import_status_all_pages' => ($bulk_all_checkbox_value == '1') ? 'Y' : 'N',
            'dashboard_status_all_pages' => ($dashboard_all_checkbox_value == '1') ? 'Y' : 'N',
            'reports_status_all_pages' => ($reports_all_checkbox_value == '1') ? 'Y' : 'N',
            'notify_all_checkbox_value' => ($notification_all_checkbox_value == '1') ? 'Y' : 'N',
            'subscription_all_pages' => ($subscription_all_checkbox_value == '1') ? 'Y' : 'N',
            'ai_prediction_all_pages' => ($ai_prediction_all_checkbox_value == '1') ? 'Y' : 'N',
                // model builder code
                'mb_dataroot_all_pages' => ($mb_dataroot_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_project_all_pages' => ($mb_project_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_node_all_pages' => ($mb_node_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_node_parameter_all_pages' => ($mb_node_parameter_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_node_calculation_all_pages' => ($mb_node_calculation_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_node_expression_all_pages' => ($mb_node_expression_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_search_all_pages' => ($mb_search_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_template_all_pages' => ($mb_template_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_template_parameter_all_pages' => ($mb_template_param_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_template_calculation_all_pages' => ($mb_template_calc_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_template_expression_all_pages' => ($mb_template_expr_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_tag_all_pages' => ($mb_tag_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_uom_categories_all_pages' => ($mb_uom_category_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_uom_conversions_all_pages' => ($mb_uom_conversions_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_group_all_pages' => ($mb_group_all_checkbox_value == '1') ? 'Y' : 'N',
                'mb_template_mapped_node_all_pages' => ($mb_template_mapped_node_all_checkbox_value == '1') ? 'Y' : 'N',
                // model builder code
                'status' => $status,
            'utc_updated_at' => date('Y-m-d H:i:s'),
            'local_updated_at' => $this->local_date_time,
            'updated_by' => $this->logged_user_id,
            ];           

            $this->updateData('tbl_roles', $role_update_where,  $role_data_update);

            $roles_data_insert_data[] = '';
            if(!empty($roles_checkbox_id))
            {
                for($i=0; $i < count($roles_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $roles_checkbox_id[$i], $roles_checkbox_view[$i], $roles_checkbox_edit[$i], $roles_checkbox_delete[$i], $role_update_audit_data);

                    $roles_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
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
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $users_checkbox_id[$i], $users_checkbox_view[$i], $users_checkbox_edit[$i], $users_checkbox_delete[$i], $role_update_audit_data);

                    $users_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $users_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($users_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($users_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($users_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $groups_data_insert_data[] = '';
            if(!empty($groups_checkbox_id))
            {
                for($i=0; $i < count($groups_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $groups_checkbox_id[$i], $groups_checkbox_view[$i], $groups_checkbox_edit[$i], $groups_checkbox_delete[$i], $role_update_audit_data);

                    $groups_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $groups_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($groups_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($groups_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($groups_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $opc_data_insert_data[] = '';
            if(!empty($opc_checkbox_id))
            {
                for($i=0; $i < count($opc_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $opc_checkbox_id[$i], $opc_checkbox_view[$i], $opc_checkbox_edit[$i], $opc_checkbox_delete[$i], $role_update_audit_data);

                    $opc_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
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
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $tag_checkbox_id[$i], $tag_checkbox_view[$i], $tag_checkbox_edit[$i], $tag_checkbox_delete[$i], $role_update_audit_data);

                    $tag_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $tag_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($tag_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($tag_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($tag_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $aggregation_data_insert_data[] = '';
            if(!empty($aggregation_checkbox_id))
            {
                for($i=0; $i < count($aggregation_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $aggregation_checkbox_id[$i], $aggregation_checkbox_view[$i], $aggregation_checkbox_edit[$i], $aggregation_checkbox_delete[$i], $role_update_audit_data);

                    $aggregation_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $aggregation_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($aggregation_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($aggregation_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($aggregation_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $mqtt_data_insert_data[] = '';
            if(!empty($mqtt_checkbox_id))
            {
                for($i=0; $i < count($mqtt_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $mqtt_checkbox_id[$i], $mqtt_checkbox_view[$i], $mqtt_checkbox_edit[$i], $mqtt_checkbox_delete[$i], $role_update_audit_data);

                    $mqtt_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
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
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $http_checkbox_id[$i], $http_checkbox_view[$i], $http_checkbox_edit[$i], $http_checkbox_delete[$i], $role_update_audit_data);

                    $http_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
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
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $bulk_checkbox_id[$i], $bulk_checkbox_view[$i], $bulk_checkbox_edit[$i], $bulk_checkbox_delete[$i], $role_update_audit_data);

                    $bulk_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $bulk_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($bulk_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($bulk_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($bulk_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $dashboard_data_insert_data[] = '';
            if(!empty($dashboard_checkbox_id))
            {
                for($i=0; $i < count($dashboard_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $dashboard_checkbox_id[$i], $dashboard_checkbox_view[$i], $dashboard_checkbox_edit[$i], $dashboard_checkbox_delete[$i], $role_update_audit_data);

                    $dashboard_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $dashboard_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($dashboard_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($dashboard_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($dashboard_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $reports_data_insert_data[] = '';
            if(!empty($reports_checkbox_id))
            {
                for($i=0; $i < count($reports_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $reports_checkbox_id[$i], $reports_checkbox_view[$i], $reports_checkbox_edit[$i], $reports_checkbox_delete[$i], $role_update_audit_data);

                    $reports_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $reports_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($reports_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($reports_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($reports_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $notification_data_insert_data[] = '';
            if(!empty($notification_checkbox_id))
            {
                for($i=0; $i < count($notification_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $notification_checkbox_id[$i], $notification_checkbox_view[$i], $notification_checkbox_edit[$i], $notification_checkbox_delete[$i], $role_update_audit_data);

                    $notification_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $notification_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($notification_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($notification_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($notification_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $subscription_data_insert_data[] = '';
            if(!empty($subscription_checkbox_id))
            {
                for($i=0; $i < count($subscription_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $subscription_checkbox_id[$i], $subscription_checkbox_view[$i], $subscription_checkbox_edit[$i], $subscription_checkbox_delete[$i], $role_update_audit_data);

                    $subscription_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $subscription_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($subscription_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($subscription_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($subscription_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            $ai_prediction_data_insert_data[] = '';
            if(!empty($ai_prediction_checkbox_id))
            {
                for($i=0; $i < count($ai_prediction_checkbox_id); $i++)
                {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $ai_prediction_checkbox_id[$i], $ai_prediction_checkbox_view[$i], $ai_prediction_checkbox_edit[$i], $ai_prediction_checkbox_delete[$i], $role_update_audit_data);
                    
                    $ai_prediction_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id'=> $role_id,
                        'page_id' => $ai_prediction_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($ai_prediction_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($ai_prediction_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($ai_prediction_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }             
            }

            // model builder code starts here
            // dataroot
            $mb_dataroot_data_insert_data[] = '';
            if (!empty($mb_dataroot_checkbox_id)) {
                for ($i = 0; $i < count($mb_dataroot_checkbox_id); $i++) {
                    //Update Audit Trail   
                    $this->roles_permission_update_audit_trail($role_id, $mb_dataroot_checkbox_id[$i], $mb_dataroot_checkbox_view[$i], $mb_dataroot_checkbox_edit[$i], $mb_dataroot_checkbox_delete[$i], $role_update_audit_data);

                    $mb_dataroot_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_dataroot_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_dataroot_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_dataroot_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_dataroot_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // dataroot

            // project
            $mb_project_data_insert_data[] = '';
            if (!empty($mb_project_checkbox_id)) {
                for ($i = 0; $i < count($mb_project_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_project_checkbox_id[$i], $mb_project_checkbox_view[$i], $mb_project_checkbox_edit[$i], $mb_project_checkbox_delete[$i], $role_update_audit_data);

                    $mb_project_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_project_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_project_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_project_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_project_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // project

            // node
            $mb_node_data_insert_data[] = '';
            if (!empty($mb_node_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_node_checkbox_id[$i], $mb_node_checkbox_view[$i], $mb_node_checkbox_edit[$i], $mb_node_checkbox_delete[$i], $role_update_audit_data);

                    $mb_node_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node

            // node parameter
            $mb_node_parameter_data_insert_data[] = '';
            if (!empty($mb_node_parameter_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_parameter_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_node_parameter_checkbox_id[$i], $mb_node_parameter_checkbox_view[$i], $mb_node_parameter_checkbox_edit[$i], $mb_node_parameter_checkbox_delete[$i], $role_update_audit_data);

                    $mb_node_parameter_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_parameter_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_parameter_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_parameter_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_parameter_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node parameter

            // node calculation 
            $mb_node_calculation_data_insert_data[] = '';
            if (!empty($mb_node_calculation_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_calculation_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_node_calculation_checkbox_id[$i], $mb_node_calculation_checkbox_view[$i], $mb_node_calculation_checkbox_edit[$i], $mb_node_calculation_checkbox_delete[$i], $role_update_audit_data);

                    $mb_node_calculation_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_calculation_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_calculation_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_calculation_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_calculation_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node calculation 

            // node expression
            $mb_node_expression_data_insert_data[] = '';
            if (!empty($mb_node_expression_checkbox_id)) {
                for ($i = 0; $i < count($mb_node_expression_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_node_expression_checkbox_id[$i], $mb_node_expression_checkbox_view[$i], $mb_node_expression_checkbox_edit[$i], $mb_node_expression_checkbox_delete[$i], $role_update_audit_data);

                    $mb_node_expression_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_node_expression_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_node_expression_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_node_expression_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_node_expression_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // node expression

            // search
            $mb_search_data_insert_data[] = '';
            if (!empty($mb_search_checkbox_id)) {
                for ($i = 0; $i < count($mb_search_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_search_checkbox_id[$i], $mb_search_checkbox_view[$i], $mb_search_checkbox_edit[$i], $mb_search_checkbox_delete[$i], $role_update_audit_data);

                    $mb_search_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_search_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_search_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_search_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_search_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // search

            // template
            $mb_template_data_insert_data[] = '';
            if (!empty($mb_template_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_template_checkbox_id[$i], $mb_template_checkbox_view[$i], $mb_template_checkbox_edit[$i], $mb_template_checkbox_delete[$i], $role_update_audit_data);

                    $mb_template_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template

            // template parameter
            $mb_template_param_data_insert_data[] = '';
            if (!empty($mb_template_param_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_param_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_template_param_checkbox_id[$i], $mb_template_param_checkbox_view[$i], $mb_template_param_checkbox_edit[$i], $mb_template_param_checkbox_delete[$i], $role_update_audit_data);

                    $mb_template_param_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_param_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_param_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_param_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_param_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template parameter

            // template calculations
            $mb_template_calc_data_insert_data[] = '';
            if (!empty($mb_template_calc_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_calc_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail($role_id, $mb_template_calc_checkbox_id[$i], $mb_template_calc_checkbox_view[$i], $mb_template_calc_checkbox_edit[$i], $mb_template_calc_checkbox_delete[$i], $role_update_audit_data);

                    $mb_template_calc_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_calc_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_calc_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_calc_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_calc_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template calculations

            // template expression
            $mb_template_expr_data_insert_data[] = '';
            if (!empty($mb_template_expr_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_expr_checkbox_id); $i++) {
                    // Update Audit Trail
                    $this->roles_permission_update_audit_trail($role_id, $mb_template_expr_checkbox_id[$i], $mb_template_expr_checkbox_view[$i], $mb_template_expr_checkbox_edit[$i], $mb_template_expr_checkbox_delete[$i], $role_update_audit_data);

                    $mb_template_expr_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_expr_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_expr_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_expr_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_template_expr_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // template expression

            // tag
            $mb_tag_data_insert_data[] = '';
            if (!empty($mb_tag_checkbox_id)) {
                for ($i = 0; $i < count($mb_tag_checkbox_id); $i++) {
                    // Update Audit Trail
                    $this->roles_permission_update_audit_trail($role_id, $mb_tag_checkbox_id[$i], $mb_tag_checkbox_view[$i], $mb_tag_checkbox_edit[$i], $mb_tag_checkbox_delete[$i], $role_update_audit_data);

                    $mb_tag_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_tag_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_tag_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_tag_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_tag_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // tag

            // uom categories
            $mb_uom_category_data_insert_data[] = '';
            if (!empty($mb_uom_category_checkbox_id)) {
                for ($i = 0; $i < count($mb_uom_category_checkbox_id); $i++) {
                    // Update Audit Trail
                    $this->roles_permission_update_audit_trail($role_id, $mb_uom_category_checkbox_id[$i], $mb_uom_category_checkbox_view[$i], $mb_uom_category_checkbox_edit[$i], $mb_uom_category_checkbox_delete[$i], $role_update_audit_data);

                    $mb_uom_category_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_uom_category_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_uom_category_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_uom_category_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_uom_category_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // uom categories

            // uom conversions
            $mb_uom_conversions_data_insert_data[] = '';
            if (!empty($mb_uom_conversions_checkbox_id)) {
                for ($i = 0; $i < count($mb_uom_conversions_checkbox_id); $i++) {
                    // Update Audit Trail
                    $this->roles_permission_update_audit_trail($role_id, $mb_uom_conversions_checkbox_id[$i], $mb_uom_conversions_checkbox_view[$i], $mb_uom_conversions_checkbox_edit[$i], $mb_uom_conversions_checkbox_delete[$i], $role_update_audit_data);

                    $mb_uom_conversions_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_uom_conversions_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_uom_conversions_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_uom_conversions_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_uom_conversions_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // uom conversions

            // group
            $mb_group_data_insert_data[] = '';
            if (!empty($mb_group_checkbox_id)) {
                for ($i = 0; $i < count($mb_group_checkbox_id); $i++) {
                    // Update Audit Trail
                    $this->roles_permission_update_audit_trail($role_id, $mb_group_checkbox_id[$i], $mb_group_checkbox_view[$i], $mb_group_checkbox_edit[$i], $mb_group_checkbox_delete[$i], $role_update_audit_data);

                    $mb_group_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_group_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_group_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_group_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                        'can_delete' => ($mb_group_checkbox_delete[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }
            // group

            // for template mapped node
            $mb_template_mapped_node_data_insert_data = [];
            if (!empty($mb_template_mapped_node_checkbox_id)) {
                for ($i = 0; $i < count($mb_template_mapped_node_checkbox_id); $i++) {
                    $this->roles_permission_update_audit_trail( $role_id,$mb_template_mapped_node_checkbox_id[$i],$mb_template_mapped_node_checkbox_view[$i],$mb_template_mapped_node_checkbox_edit[$i],$role_update_audit_data);
                    $mb_template_mapped_node_data_insert_data[] = array(
                        'company_id' => $this->customer_id,
                        'role_id' => $role_id,
                        'page_id' => $mb_template_mapped_node_checkbox_id[$i],
                        'type' => 'page',
                        'can_view' => ($mb_template_mapped_node_checkbox_view[$i] == '1') ? 'Y' : 'N',
                        'can_edit' => ($mb_template_mapped_node_checkbox_edit[$i] == '1') ? 'Y' : 'N',
                    );
                }
            }

            // for template mapped node

            // model builder code ends here

            $role_permissions_del_where = [
                'role_id' => $role_id,
            ];            
            
            $this->deleteData('tbl_role_permissions',$role_permissions_del_where);  
            
            if(!empty(array_filter($roles_data_insert_data)))
            {
                $roles_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($roles_data_insert_data));
            }

            if(!empty(array_filter($users_data_insert_data)))
            {
                $users_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($users_data_insert_data));
            }

            if(!empty(array_filter($groups_data_insert_data)))
            {
                $groups_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($groups_data_insert_data));
            }

            if(!empty(array_filter($opc_data_insert_data)))
            {
                $opc_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($opc_data_insert_data));
            }

            if(!empty(array_filter($tag_data_insert_data)))
            {
                $tag_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($tag_data_insert_data));
            } 

            if(!empty(array_filter($aggregation_data_insert_data)))
            {
                $aggregation_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($aggregation_data_insert_data));
            }
            
            if(!empty(array_filter($mqtt_data_insert_data)))
            {
                $mqtt_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mqtt_data_insert_data));
            }

            if(!empty(array_filter($http_data_insert_data)))
            {
                $http_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($http_data_insert_data));
            }

            if(!empty(array_filter($bulk_data_insert_data)))
            {
                $bulk_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($bulk_data_insert_data));  
            }

            if(!empty(array_filter($dashboard_data_insert_data)))
            {
                $dashboard_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($dashboard_data_insert_data));
            }

            if(!empty(array_filter($reports_data_insert_data)))
            {
                $reports_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($reports_data_insert_data));  
            }

            if(!empty(array_filter($notification_data_insert_data)))
            {
                $notification_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($notification_data_insert_data));
            }    

            if(!empty(array_filter($subscription_data_insert_data)))
            {
                $subscription_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($subscription_data_insert_data));
            } 

            if(!empty(array_filter($ai_prediction_data_insert_data)))
            {
                $ai_prediction_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($ai_prediction_data_insert_data));
            } 

            // model builder code starts here
            if (!empty(array_filter($mb_dataroot_data_insert_data))) {
                $mb_dataroot_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_dataroot_data_insert_data));
            }

            if (!empty(array_filter($mb_project_data_insert_data))) {
                $mb_project_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_project_data_insert_data));
            }

            if (!empty(array_filter($mb_node_data_insert_data))) {
                $mb_node_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_data_insert_data));
            }

            if (!empty(array_filter($mb_node_parameter_data_insert_data))) {
                $mb_node_parameter_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_parameter_data_insert_data));
            }

            if (!empty(array_filter($mb_node_calculation_data_insert_data))) {
                $mb_node_calculation_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_calculation_data_insert_data));
            }

            if (!empty(array_filter($mb_node_expression_data_insert_data))) {
                $mb_node_expression_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_node_expression_data_insert_data));
            }

            if (!empty(array_filter($mb_search_data_insert_data))) {
                $mb_search_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_search_data_insert_data));
            }

            if (!empty(array_filter($mb_template_data_insert_data))) {
                $mb_template_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_data_insert_data));
            }

            if (!empty(array_filter($mb_template_param_data_insert_data))) {
                $mb_template_param_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_param_data_insert_data));
            }

            if (!empty(array_filter($mb_template_calc_data_insert_data))) {
                $mb_template_calc_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_calc_data_insert_data));
            }

            if (!empty(array_filter($mb_template_expr_data_insert_data))) {
                $mb_template_expr_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_expr_data_insert_data));
            }

            if (!empty(array_filter($mb_tag_data_insert_data))) {
                $mb_tag_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_tag_data_insert_data));
            }

            if (!empty(array_filter($mb_uom_category_data_insert_data))) {
                $mb_uom_category_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_uom_category_data_insert_data));
            }

            if (!empty(array_filter($mb_uom_conversions_data_insert_data))) {
                $mb_uom_conversions_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_uom_conversions_data_insert_data));
            }

            if (!empty(array_filter($mb_group_data_insert_data))) {
                $mb_group_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_group_data_insert_data));
            }

            if (!empty(array_filter($mb_template_mapped_node_data_insert_data))) {
                $mb_template_mapped_node_data_insert_data_id = $this->insertBatchData('tbl_role_permissions', array_filter($mb_template_mapped_node_data_insert_data));
            }


            // model builder code ends here

            $this->mysqldb->transComplete();

            if($roles_data_insert_data_id || $users_data_insert_data_id || $groups_data_insert_data_id || $opc_data_insert_data_id || $tag_data_insert_data_id || $aggregation_data_insert_data_id || $mqtt_data_insert_data_id || $http_data_insert_data_id || $bulk_data_insert_data_id || $dashboard_data_insert_data_id || $reports_data_insert_data_id || $notification_data_insert_data_id || $subscription_data_insert_data_id || $ai_prediction_data_insert_data_id ||$mb_dataroot_data_insert_data_id || $mb_project_data_insert_data_id || $mb_node_data_insert_data_id || $mb_node_parameter_data_insert_data_id || $mb_node_calculation_data_insert_data_id || $mb_node_expression_data_insert_data_id || $mb_search_data_insert_data_id || $mb_template_data_insert_data_id || $mb_template_param_data_insert_data_id || $mb_template_calc_data_insert_data_id || $mb_template_expr_data_insert_data_id || $mb_tag_data_insert_data_id || $mb_uom_category_data_insert_data_id || $mb_uom_conversions_data_insert_data_id || $mb_group_data_insert_data_id || $mb_template_mapped_node_data_insert_data_id)
            {
                return true;
            }            

        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'update_page_roles_details',$e->getMessage());
        }
    }

    public function roles_permission_update_audit_trail($role_id = 0, $page_id = 0, $new_roles_can_view = '', $new_roles_can_edit = '', $new_roles_can_delete = '', $role_update_audit_data = array())
    {
        try
        {
            $role_permission_update_where = [
                'company_id' => $this->customer_id,
                'role_id' => $role_id,
                'page_id' => $page_id
            ];     
            
            $old_role_per_data = $this->GetTableValue('tbl_role_permissions', 'can_view,can_edit,can_delete', $role_permission_update_where); 

            $role_page_update_where = [
                'id' => $page_id
            ];     
            
            $role_page_data = $this->GetTableValue('tbl_cms_pages', 'page_name', $role_page_update_where);

            if(!empty($role_page_data))
            {
                $page_name = $role_page_data[0]['page_name'];
            }
            else
            {
                $page_name = null;
            }

            if(!empty($old_role_per_data))
            {
                $new_roles_can_view = ($new_roles_can_view == '1') ? 'Y' : 'N';
                $old_roles_can_view = $old_role_per_data[0]['can_view'];
                if (trim($new_roles_can_view) != trim($old_roles_can_view)) {
                    $role_update_audit_data['update_field'] = $page_name.'_can_view';
                    $role_update_audit_data['old_value'] = ($old_roles_can_view) ? $old_roles_can_view : null;
                    $role_update_audit_data['new_value'] = $new_roles_can_view;
                    $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
                }

                $new_roles_can_edit = ($new_roles_can_edit == '1') ? 'Y' : 'N';
                $old_roles_can_edit = $old_role_per_data[0]['can_edit'];
                if (trim($new_roles_can_edit) != trim($old_roles_can_edit)) {
                    $role_update_audit_data['update_field'] = $page_name.'_can_edit';
                    $role_update_audit_data['old_value'] = ($old_roles_can_edit) ? $old_roles_can_edit : null;
                    $role_update_audit_data['new_value'] = $new_roles_can_edit;
                    $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
                }

                $new_roles_can_delete = ($new_roles_can_delete == '1') ? 'Y' : 'N';
                $old_roles_can_delete = $old_role_per_data[0]['can_delete'];
                if (trim($new_roles_can_delete) != trim($old_roles_can_delete)) {
                    $role_update_audit_data['update_field'] = $page_name.'_can_delete';
                    $role_update_audit_data['old_value'] = ($old_roles_can_delete) ? $old_roles_can_delete : null;
                    $role_update_audit_data['new_value'] = $new_roles_can_delete;
                    $this->insert_data_postgresql('update_audit_trail', $role_update_audit_data);
                }
            }
            
            return;
            
        } catch(\Exception $e){
            $currentURL = current_url();            
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'roles_permission_update_audit_trail',$e->getMessage());
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'GetTableValue',$e->getMessage());
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'GetTableValue_whereIn',$e->getMessage());                       
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'getsearchvaluewithjoin',$e->getMessage());
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'insertData',$e->getMessage());            
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'insertBatchData',$e->getMessage());          
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'insert_data_postgresql',$e->getMessage(),POSTGRESQL_ERROR);            
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
             $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'updateData',$e->getMessage());                      
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'deleteData',$e->getMessage());                       
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
            $this->error_log->error_exception_log('company_role\company_role_model',$currentURL,'generateRandomUid',$e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');  
        }
    }
}
?>