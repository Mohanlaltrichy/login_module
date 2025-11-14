<?php

namespace Modules\global_templates\Controllers;

use Modules\global_templates\Models\templates_model;
use App\Libraries\customlibraries;
use App\Helpers\Validationrules;
use App\Controllers\BaseController;
use PhpParser\Node\Expr\FuncCall;
use DateTime;
use DateTimeZone;
use Ramsey\Uuid\Uuid;
use App\Libraries\ses_secret_manager;

class templates_controller extends BaseController
{
    protected $templates_model;
    protected $error_log;
    protected $local_date_time;

    public function __construct()
    {
        $this->templates_model = new templates_model();
        $customlibraries = new customlibraries();
        $this->local_date_time = $customlibraries->local_date_time();
        $this->error_log = new customlibraries();
    }

    //Header 
    public function global_header()
    {
        try {
            return view("\Modules\global_templates\Views\global_header");
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_header', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Footer
    public function global_footer($type = '')
    {
        try {
            $data = [
                'type' => $type,
            ];

            return view("\Modules\global_templates\Views\global_footer", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_footer', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Global Error Page
    public function global_error_page()
    {
        try {
            $data = [
                "error" => "404_error",
            ];
            return view("\Modules\global_templates\Views\global_error_page", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_error_page', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Global Forbidden Page
    public function global_forbidden_page()
    {
        try {
            return view("\Modules\global_templates\Views\global_forbidden_page");
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_forbidden_page', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Global Catch Error Page
    public function global_catch_error()
    {
        try {
            $data = [
                "error" => "catch_error",
            ];
            return view("\Modules\global_templates\Views\global_error_page", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_catch_error', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Global CSS Files
    public function global_css_files()
    {
        try {
            return view("\Modules\global_templates\Views\global_css_files");
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_css_files', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Global JS Files
    public function global_js_files()
    {
        try {
            return view("\Modules\global_templates\Views\global_js_files");
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_js_files', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Global Alert Msg
    public function global_alert_msg($data = array())
    {
        try {
            $data = [
                'message' => $data['message'],
                'message2' => $data['message2'],
                'type' => $data['type'],
            ];

            return view("\Modules\global_templates\Views\global_alert_msg", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'global_alert_msg', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }

    //Dashboard
    public function dashboard()
    {

        try {
            if (empty(session('Taglogged_in'))) {
                return redirect()->route('login');
            }

            $user_whereConditions = [
                'user_id' => session('Taguser_id'),
            ];

            $user_details = $this->templates_model->GetTableValue('user_login_history', 'login_key', $user_whereConditions, '', '', '', 'id', 'desc');

            if (!empty($user_details)) {
                $data = array(
                    'login_key' => ($user_details[0]['login_key']) ? $user_details[0]['login_key'] : '',
                    'user_id' => session('Taguser_id'),
                );
            } else {
                $data = array(
                    'login_key' => '',
                    'user_id' => session('Taguser_id'),
                );
            }

            return view("\Modules\global_templates\Views\dashboard", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'dashboard', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function getnotification()
    {
        try {
            if ($this->request->isAJAX()) {

                $last_date_time = date('Y-m-d h:m:s', strtotime('-1 hour'));

                $data = $this->templates_model->get_notification($last_date_time);

                return $this->response->setJSON($data);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'getnotification', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function get_all_notification()
    {
        try {
            if (session('alert_notification_add_view') != '1') {
                return redirect()->route('forbidden_error');
            }

            $last_date_time = date('Y-m-d h:m:s', strtotime('-48 hour'));

            $all_notification = $this->templates_model->get_notification($last_date_time);

            $data = array(
                'all_notification' => $all_notification,
            );

            return view("\Modules\global_templates\Views\all_notification", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'get_all_notification', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    public function edit_company()
    {
        try {
            $comp_where = [
                'id' => session('Taguser_company'),
            ];

            $comp_data = $this->templates_model->GetTableValue('tbl_companies', '*', $comp_where);

            $user_where = [
                'company_id' => session('Taguser_company'),
            ];

            $user_data = $this->templates_model->GetTableValue('users', 'first_name,last_name,email,mobile', $user_where);
            $countries = $this->templates_model->GetTableValue('countries', 'id,name', [], [], 'id,name', '', 'name');

            $data = array(
                'comp_data' => $comp_data,
                'user_data' => $user_data,
                'countries' => $countries,
            );

            return view("\Modules\global_templates\Views/edit_company", $data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'edit_company', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function get_states()
    {
        try {
            $country_id = $this->request->getGet('country_id');
            $country_name = $this->request->getGet('country_name');

            $state_where = [
                'country_id' => $country_id,
            ];

            $states = $this->templates_model->GetTableValue('states', 'id,name', $state_where, [], 'id,name', '', 'name');

            $zone_where = [
                'country' => $country_name,
            ];

            $zones = $this->templates_model->GetTableValue('timezone', 'time_zone', $zone_where,  $zone_where, [], ['time_zone'], 'time_zone', 'asc');

            $data = array('states' => $states, 'zones' => $zones);
            return response()->setJSON($data);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'get_states', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    public function get_cities()
    {
        try {
            $stat_name = $this->request->getGet('state_id');

            $state_where = [
                'name' => $stat_name,
            ];

            $states = $this->templates_model->GetTableValue(
                'states',
                'id',
                $state_where
            );
            $city_where = [
                'state_id' => $states[0]['id'],
            ];

            $cities = $this->templates_model->GetTableValue('cities', 'id,name', $city_where, [], 'id,name', '', 'name');

            return response()->setJSON(['cities' => $cities]);
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'get_cities', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function update_company()
    {
        try {
            
            if ($this->request->getMethod() == "post") {

                $session = session();

                $company_name = $this->request->getPost("company_name");
                $email_address = $this->request->getPost("company_email");
                $gstn = $this->request->getPost("gstn");
                $phone = $this->request->getPost("phone");
                $website = $this->request->getPost("website");
                $address = $this->request->getPost("address");
                $city = $this->request->getPost("city");
                $state = $this->request->getPost("state");
                $country = $this->request->getPost("country");
                $zone = $this->request->getPost("zone");
                $pincode = $this->request->getPost("pincode");
                $firstname = $this->request->getPost("firstname");
                $middlename = $this->request->getPost("middlename");
                $lastname = $this->request->getPost("lastname");
                $useremail = $this->request->getPost("useremail");
                $mobile = $this->request->getPost("mobile");
                $old_mobile = $this->request->getPost("old_mobile");
                $logo = $this->request->getFile('logo');
                $api_key = $this->request->getPost('api_key');

                $validation = \Config\Services::validation();
                $rules = [
                    "company_name" => [
                        "label" => "Company name",
                        "rules" => "required"
                    ],
                    "gstn" => [
                        "label" => "GSTN",
                        "rules" => "required"
                    ],
                    "company_email" => [
                        "label" => "Email",
                        'rules' => 'required|valid_email',
                    ],
                    "firstname" => [
                        "label" => "Firstname",
                        "rules" => "required"
                    ]
                ];

                $countries = $this->templates_model->GetTableValue('countries', 'id,name', [], [], 'id,name', '', 'name');

                $comp_data[0] = array(
                    'company_name' => $company_name,
                    'company_email' => $email_address,
                    'gstn' => $gstn,
                    'company_phone' => $phone,
                    'company_website' => $phone,
                    'company_address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'time_zone' => $zone,
                    'zipcode' => $pincode,
                    'logo' => $logo ?? null,
                    'firstname' => $firstname,
                    'middle_name' => $middlename,
                    'lastname' => $lastname,
                    'mobile' => $mobile,
                );

                $user_data[0] = array(
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'email' => $useremail,
                    'mobile' => $mobile,
                );

                $data = array(
                    'comp_data' => $comp_data,
                    'countries' => $countries,
                    'user_data' => $user_data,
                );

                // if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
                if (!$this->validate($rules)) {
                    if ($logo->isValid()) {
                        $imageData = $logo->getTempName();
                        $file = file_get_contents($imageData);
                        $base64Image = base64_encode($file);

                        $set_logo = [
                            'firstlogo'     => $base64Image
                        ];
                        $session->set($set_logo);
                    }
                    $session->setFlashdata('msg', $validation->getErrors());
                    return view("\Modules\global_templates\Views/edit_company", $data);
                }

                $company_name_check = [
                    'company_name' => $company_name
                ];

                $or_where = [
                    'company_email' => $email_address
                ];

                $comp_data_check = $this->templates_model->GetTableValue('tbl_companies', 'id', $company_name_check, $or_where);

                $user_where = [
                    'mobile' => $mobile
                ];

                $user_email_check = $this->templates_model->GetTableValue('users', 'id', $user_where);

                if (count($comp_data_check) > 1) {
                    if ($logo->isValid()) {
                        $imageData = $logo->getTempName();
                        $file = file_get_contents($imageData);
                        $base64Image = base64_encode($file);

                        $set_logo = [
                            'firstlogo'     => $base64Image
                        ];
                        $session->set($set_logo);
                    }
                    $session->setFlashdata('msg', 'Company name or Email already found');
                    return view("\Modules\global_templates\Views/edit_company", $data);
                }
                if (count($user_email_check) > 1 && $mobile != $old_mobile) {
                    if ($logo->isValid()) {
                        $imageData = $logo->getTempName();
                        $file = file_get_contents($imageData);
                        $base64Image = base64_encode($file);

                        $set_logo = [
                            'firstlogo'     => $base64Image
                        ];
                        $session->set($set_logo);
                    }
                    $session->setFlashdata('msg', 'Contact mobile number already found');
                    return view("\Modules\global_templates\Views/edit_company", $data);
                }

                $company_data = [
                    'company_name' => $company_name,
                    'first_name' => $firstname,
                    'middle_name' => ($middlename != '') ? $middlename : null,
                    'last_name' => $lastname,
                    'company_address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'time_zone' => $zone,
                    'zipcode' => $pincode,
                    'company_email' => $email_address,
                    'company_phone' => ($phone != '') ? $phone : null,
                    'contact_mobile' => $mobile,
                    'company_website' => ($website != '') ? $website : null,
                    'gstn' => $gstn,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => session('Taguser_id'),
                ];
                

                $set_companyname = [
                    'company_name'     => $company_name,
                    'Taguser_name'     => $firstname,
                    'Taguser_email'     => $useremail,
                ];
                $session->set($set_companyname);

                $company_logo_path = null;
                if ($logo->isValid()) {
                    $imageData = $logo->getTempName();
                    $file = file_get_contents($imageData);
                    $base64Image = base64_encode($file);

                    $set_logo = [
                        'logo'     => $base64Image
                    ];
                    $session->set($set_logo);
                    $company_data['company_logo'] = $base64Image;
                    $company_logo_path = $base64Image;
                } elseif (session('firstlogo')) {
                    $firstlogo = session('firstlogo');

                    $set_logo = [
                        'logo'     => $firstlogo
                    ];
                    $session->set($set_logo);
                    $company_data['company_logo'] = $firstlogo;
                    $company_logo_path = $firstlogo;
                }

                $session->remove('firstlogo');

                $comp_update_where = [
                    'id' => session('Taguser_company'),
                ];


                //Update Audit Trail Code Start
                $old_comp_data = $this->templates_model->GetTableValue('tbl_companies', 'company_name, first_name, middle_name, last_name, company_address, city, state, country, time_zone, zipcode, company_email, company_phone, contact_mobile, company_website, gstn, company_logo, api_key', $comp_update_where);

                if (!empty($old_comp_data)) {
                    $old_company_name = ($old_comp_data[0]['company_name']) ? $old_comp_data[0]['company_name'] : null;
                    $old_first_name = ($old_comp_data[0]['first_name']) ? $old_comp_data[0]['first_name'] : null;
                    $old_middle_name = ($old_comp_data[0]['middle_name']) ? $old_comp_data[0]['middle_name'] : null;
                    $old_last_name = ($old_comp_data[0]['last_name']) ? $old_comp_data[0]['last_name'] : null;
                    $old_company_address = ($old_comp_data[0]['company_address']) ? $old_comp_data[0]['company_address'] : null;
                    $old_city = ($old_comp_data[0]['city']) ? $old_comp_data[0]['city'] : null;
                    $old_state = ($old_comp_data[0]['state']) ? $old_comp_data[0]['state'] : null;
                    $old_country = ($old_comp_data[0]['country']) ? $old_comp_data[0]['country'] : null;
                    $old_time_zone = ($old_comp_data[0]['time_zone']) ? $old_comp_data[0]['time_zone'] : null;
                    $old_zipcode = ($old_comp_data[0]['zipcode']) ? $old_comp_data[0]['zipcode'] : null;
                    $old_company_email = ($old_comp_data[0]['company_email']) ? $old_comp_data[0]['company_email'] : null;
                    $old_company_phone = ($old_comp_data[0]['company_phone']) ? $old_comp_data[0]['company_phone'] : null;
                    $old_contact_mobile = ($old_comp_data[0]['contact_mobile']) ? $old_comp_data[0]['contact_mobile'] : null;
                    $old_company_website = $old_comp_data[0]['company_website'];
                    $old_gstn = ($old_comp_data[0]['gstn']) ? $old_comp_data[0]['gstn'] : null;
                    $old_company_logo = ($old_comp_data[0]['company_logo']) ? $old_comp_data[0]['company_logo'] : null;
                    $old_api_key = ($old_comp_data[0]['api_key']) ? $old_comp_data[0]['api_key'] : null;
                } else {
                    $old_company_name = '';
                    $old_first_name = '';
                    $old_middle_name = '';
                    $old_last_name = '';
                    $old_company_address = '';
                    $old_city = '';
                    $old_state =  '';
                    $old_country =  '';
                    $old_time_zone = '';
                    $old_zipcode =  '';
                    $old_company_email = '';
                    $old_company_phone = '';
                    $old_contact_mobile = '';
                    $old_company_website = '';
                    $old_gstn = '';
                    $old_company_logo = '';
                     $old_api_key = '';
                }

                if(trim($old_api_key) != trim($api_key))
                {
                    $company_data['api_key'] = $api_key;
                }

                $randomUid = $this->generateRandomUid();

                $company_update_audit_data = [
                    'update_key' => $randomUid,
                    'customer_id' => session('Taguser_company'),
                    'config_type' => 'company',
                    'server_id' => session('Taguser_company'),
                    'update_type' => 'edit',
                    'created_by' => session('Taguser_id'),
                    'utc_created_at' => date('Y-m-d H:i:s'),
                    'local_created_at' => $this->local_date_time,
                ];

                if (trim($company_name) != trim($old_company_name)) {
                    $company_update_audit_data['update_field'] = 'company_name';
                    $company_update_audit_data['old_value'] = ($old_company_name) ? $old_company_name : null;
                    $company_update_audit_data['new_value'] = ($company_name) ? $company_name : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($firstname) != trim($old_first_name)) {
                    $company_update_audit_data['update_field'] = 'first_name';
                    $company_update_audit_data['old_value'] = ($old_first_name) ? $old_first_name : null;
                    $company_update_audit_data['new_value'] = ($firstname) ? $firstname : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($middlename) != trim($old_middle_name)) {
                    $company_update_audit_data['update_field'] = 'middle_name';
                    $company_update_audit_data['old_value'] = ($old_middle_name) ? $old_middle_name : null;
                    $company_update_audit_data['new_value'] = ($middlename) ? $middlename : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($lastname) != trim($old_last_name)) {
                    $company_update_audit_data['update_field'] = 'last_name';
                    $company_update_audit_data['old_value'] = ($old_last_name) ? $old_last_name : null;
                    $company_update_audit_data['new_value'] = ($lastname) ? $lastname : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($address) != trim($old_company_address)) {
                    $company_update_audit_data['update_field'] = 'company_address';
                    $company_update_audit_data['old_value'] = ($old_company_address) ? $old_company_address : null;
                    $company_update_audit_data['new_value'] = ($address) ? $address : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($city) != trim($old_city)) {
                    $company_update_audit_data['update_field'] = 'city';
                    $company_update_audit_data['old_value'] = ($old_city) ? $old_city : null;
                    $company_update_audit_data['new_value'] = ($city) ? $city : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($state) != trim($old_state)) {
                    $company_update_audit_data['update_field'] = 'state';
                    $company_update_audit_data['old_value'] = ($old_state) ? $old_state : null;
                    $company_update_audit_data['new_value'] = ($state) ? $state : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($country) != trim($old_country)) {
                    $company_update_audit_data['update_field'] = 'state';
                    $company_update_audit_data['old_value'] = ($old_country) ? $old_country : null;
                    $company_update_audit_data['new_value'] = ($country) ? $country : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($zone) != trim($old_time_zone)) {
                    $company_update_audit_data['update_field'] = 'time_zone';
                    $company_update_audit_data['old_value'] = ($old_time_zone) ? $old_time_zone : null;
                    $company_update_audit_data['new_value'] = ($zone) ? $zone : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($pincode) != trim($old_zipcode)) {
                    $company_update_audit_data['update_field'] = 'zipcode';
                    $company_update_audit_data['old_value'] = ($old_zipcode) ? $old_zipcode : null;
                    $company_update_audit_data['new_value'] = ($pincode) ? $pincode : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($email_address) != trim($old_company_email)) {
                    $company_update_audit_data['update_field'] = 'company_email';
                    $company_update_audit_data['old_value'] = ($old_company_email) ? $old_company_email : null;
                    $company_update_audit_data['new_value'] = ($email_address) ? $email_address : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($phone) != trim($old_company_phone)) {
                    $company_update_audit_data['update_field'] = 'company_phone';
                    $company_update_audit_data['old_value'] = ($old_company_phone) ? $old_company_phone : null;
                    $company_update_audit_data['new_value'] = ($phone) ? $phone : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($mobile) != trim($old_contact_mobile)) {
                    $company_update_audit_data['update_field'] = 'contact_mobile';
                    $company_update_audit_data['old_value'] = ($old_contact_mobile) ? $old_contact_mobile : null;
                    $company_update_audit_data['new_value'] = ($mobile) ? $mobile : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($website) != trim($old_company_website)) {
                    $company_update_audit_data['update_field'] = 'company_website';
                    $company_update_audit_data['old_value'] = ($old_company_website) ? $old_company_website : null;
                    $company_update_audit_data['new_value'] = ($website) ? $website : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($gstn) != trim($old_gstn)) {
                    $company_update_audit_data['update_field'] = 'gstn';
                    $company_update_audit_data['old_value'] = ($old_gstn) ? $old_gstn : null;
                    $company_update_audit_data['new_value'] = ($gstn) ? $gstn : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if (trim($company_logo_path) != '' && trim($company_logo_path) != trim($old_company_logo)) {
                    $company_update_audit_data['update_field'] = 'company_logo';
                    $company_update_audit_data['old_value'] = ($old_company_logo) ? $old_company_logo : null;
                    $company_update_audit_data['new_value'] = ($company_logo_path) ? $company_logo_path : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }

                if(trim($old_api_key) != trim($api_key))
                {
                    $company_data['api_key'] = $api_key;
                    $company_update_audit_data['update_field'] = 'api_key';
                    $company_update_audit_data['old_value'] = ($old_api_key) ? $old_api_key : null;
                    $company_update_audit_data['new_value'] = ($api_key) ? $api_key : null;
                    $this->templates_model->insert_data_postgresql('update_audit_trail', $company_update_audit_data);
                }
                //Update Audit Trail Code End

                $this->templates_model->updateData('tbl_companies', $comp_update_where, $company_data);

                $users_data = [
                    'name' => $firstname,
                    'company_name' => $company_name,
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'phone' => ($phone != '') ? $phone : null,
                    'mobile' => $mobile,
                    'utc_updated_at' => date('Y-m-d H:i:s'),
                    'local_updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => session('Taguser_id'),
                ];

                $user_update_where = [
                    'company_id' => session('Taguser_company'),
                ];

                $this->templates_model->updateData('users', $user_update_where, $users_data);

                session()->setFlashdata('success', 'Data Updated successfully');
                return redirect()->route('edit_company');
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_template\templates_controller', $currentURL, 'update_company', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    public function acknowledge_notification()
    {
        try {

            if ($this->request->isAJAX()) {

                $selectedIds = $this->request->getPost("selectedIds");

                $update_data = array(
                    "acknowledge" => 1
                );

                $this->templates_model->updateData_whereIn('alert_notification', 'id', $selectedIds, $update_data);

                $result = array(
                    "status" => 'success',
                    "status_msg" => 'Update Successfully',
                );
                return $this->response->setJSON($result);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'acknowledge_notification', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    //Number Of Tag Added Count Update Code Start
    public function number_of_tag_update()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }


            if ($login_key_verify_pass != '') {

                $cutomer_whereConditions = [
                    'customer_id' => $company_id,
                ];

                $opc_nodes_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('opc_nodes', 'id', $cutomer_whereConditions);
                $opc_events_property_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('events_sub_property', 'id', $cutomer_whereConditions);
                $opc_history_data_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('opc_history_data', 'id', $cutomer_whereConditions);
                $opc_history_event_property_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('history_event_property', 'id', $cutomer_whereConditions);

                $mqtt_device_node_mapping_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('mqtt_device_node_mapping', 'id', $cutomer_whereConditions);
                $mqtt_device_event_mapping_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('mqtt_device_event_mapping', 'id', $cutomer_whereConditions);

                $http_node_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('http_node', 'id', $cutomer_whereConditions);
                $http_event_count_check =  $this->templates_model->GetTableValue_whereIn_pgsql('http_event', 'id', $cutomer_whereConditions);

                if (!empty(array_filter($opc_nodes_count_check))) {
                    $opc_nodes_ids = array_column($opc_nodes_count_check, 'id');
                    $opc_nodes_count = count($opc_nodes_ids);
                } else {
                    $opc_nodes_count = 0;
                }

                if (!empty(array_filter($opc_events_property_count_check))) {
                    $opc_events_ids = array_column($opc_events_property_count_check, 'id');
                    $opc_events_count = count($opc_events_ids);
                } else {
                    $opc_events_count = 0;
                }

                if (!empty(array_filter($opc_history_data_count_check))) {
                    $opc_history_data_ids = array_column($opc_history_data_count_check, 'id');
                    $opc_history_data_count = count($opc_history_data_ids);
                } else {
                    $opc_history_data_count = 0;
                }

                if (!empty(array_filter($opc_history_event_property_count_check))) {
                    $opc_history_event_ids = array_column($opc_history_event_property_count_check, 'id');
                    $opc_history_event_count = count($opc_history_event_ids);
                } else {
                    $opc_history_event_count = 0;
                }

                if (!empty(array_filter($mqtt_device_node_mapping_count_check))) {
                    $mqtt_device_node_ids = array_column($mqtt_device_node_mapping_count_check, 'id');
                    $mqtt_device_node_count = count($mqtt_device_node_ids);
                } else {
                    $mqtt_device_node_count = 0;
                }

                if (!empty(array_filter($mqtt_device_event_mapping_count_check))) {
                    $mqtt_device_event_ids = array_column($mqtt_device_event_mapping_count_check, 'id');
                    $mqtt_device_event_count = count($mqtt_device_event_ids);
                } else {
                    $mqtt_device_event_count = 0;
                }

                if (!empty(array_filter($http_node_count_check))) {
                    $http_node_ids = array_column($http_node_count_check, 'id');
                    $http_node_count = count($http_node_ids);
                } else {
                    $http_node_count = 0;
                }

                if (!empty(array_filter($http_event_count_check))) {
                    $http_event_ids = array_column($http_event_count_check, 'id');
                    $http_event_count = count($http_event_ids);
                } else {
                    $http_event_count = 0;
                }

                $tag_added_count = $opc_nodes_count + $opc_events_count + $opc_history_data_count + $opc_history_event_count + $mqtt_device_node_count + $mqtt_device_event_count + $http_node_count + $http_event_count;

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 14,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);

                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $tag_added_count,
                );

                $tag_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $tag_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_tag_update', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Tag Added Count Update Code End   

    //Number Of Historian Table Count Add/Update Code Start
    public function number_of_historian_table_update()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {

                $customer_tabledata_whereConditions = [
                    'customer_id' => $company_id,
                    'status' => 'Y'
                ];

                $customer_table_name = $this->templates_model->GetTableValue_whereIn_pgsql('tag_config', 'id', $customer_tabledata_whereConditions);

                if (!empty(array_filter($customer_table_name))) {
                    $table_ids = array_column($customer_table_name, 'id');
                    $historian_table_count = count($table_ids);
                } else {
                    $historian_table_count = 0;
                }

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 15,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);


                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $historian_table_count,
                );

                $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $dashboard_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_historian_table_update', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Historian Table Count Add/Update Code End

    //Number Of Aggregator Count Add/Update Code Start
    public function number_of_aggregator_update()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {

                $aggregator_whereConditions = [
                    'customer_id' => $company_id,
                ];

                $aggregator_ids = $this->templates_model->GetTableValue_whereIn_pgsql('cont_aggre_config', 'id', $aggregator_whereConditions);

                if (!empty(array_filter($aggregator_ids))) {
                    $agg_ids = array_column($aggregator_ids, 'id');
                    $aggregator_count = count($agg_ids);
                } else {
                    $aggregator_count = 0;
                }

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 34,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);


                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $aggregator_count,
                );

                $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $dashboard_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_aggregator_update', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Aggregator Count Add/Update Code End

    //Number Of AI Template Count Add/Update Code Start
    public function number_of_ai_template_update()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {

                $ai_template_whereConditions = [
                    'customer_id' => $company_id,
                ];

                $ai_template_ids = $this->templates_model->GetTableValue_whereIn_pgsql('ai_create_model', 'id', $ai_template_whereConditions);

                if (!empty(array_filter($ai_template_ids))) {
                    $ai_ids = array_column($ai_template_ids, 'id');
                    $ai_template_count = count($ai_ids);
                } else {
                    $ai_template_count = 0;
                }

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 31,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);

                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $ai_template_count,
                );

                $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $dashboard_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_ai_template_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of AI Template Count Add/Update Code End

    //Number Of AI Prediction Count Add/Update Code Start
    public function number_of_ai_prediction_update()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 32,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);

                if (!empty(array_filter($company_feature_log_check))) {
                    $ai_ids = array_column($company_feature_log_check, 'id');
                    $ai_prediction_count = count($ai_ids);
                } else {
                    $ai_prediction_count = 0;
                }


                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $ai_prediction_count + 1,
                );

                $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $dashboard_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_ai_prediction_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of AI Prediction Count Add/Update Code End

    //Number Of Dashboard Template Count Add/Update Code Start
    public function number_of_dashboard_template_update()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            }


            if ($login_key_verify_pass != '') {

                $dashboard_where = [
                    'status !=' => 'D',
                    'customer_id' => $company_id,
                ];

                $dashboard_data = $this->templates_model->GetTableValue('tbl_dashboard', 'id', $dashboard_where);

                if (!empty(array_filter($dashboard_data))) {
                    $dashboard_data_ids = array_column($dashboard_data, 'id');
                    $dashboard_data_count = count($dashboard_data_ids);
                } else {
                    $dashboard_data_count = 0;
                }

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 26,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);

                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $dashboard_data_count,
                );

                $dashboard_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $dashboard_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_dashboard_template_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Dashboard Template Count Add/Update Code End

    //Number Of Parameter Count Update Code Start
    public function number_of_parameter_count_update()
    {
        try {
            $data_get = $this->request->getPost();

            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {

                $parameter_where = [
                    'company_id' => $company_id,
                ];

                $parameter_data = $this->templates_model->GetTableValue('tbl_notification_trigger', 'id', $parameter_where);

                if (!empty(array_filter($parameter_data))) {
                    $parameter_data_ids = array_column($parameter_data, 'id');
                    $parameter_data_count = count($parameter_data_ids);
                } else {
                    $parameter_data_count = 0;
                }

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 27,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);

                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $parameter_data_count,
                );

                $parameter_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $parameter_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_parameter_count_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Parameter Count Update Code End

    //Number Of Reports Count Update Code Start   
    public function number_of_reports_count_update()
    {
        try {
            $data_get = $this->request->getPost();

            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id'];
            }

            if ($login_key_verify_pass != '') {

                $reports_where = [
                    'company_id' => $company_id,
                ];

                $reports_data = $this->templates_model->GetTableValue('report_configurations', 'id', $reports_where);

                if (!empty(array_filter($reports_data))) {
                    $reports_data_ids = array_column($reports_data, 'id');
                    $reports_data_count = count($reports_data_ids);
                } else {
                    $reports_data_count = 0;
                }

                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 25,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $company_feature_log_whereConditions);

                $company_feature_log_update_whereConditions = [
                    'id' => $company_feature_log_check[0]['id'],
                ];

                $company_feature_log_data = array(
                    'user_add_count' => $reports_data_count,
                );

                $reports_count_store = $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => $reports_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_reports_count_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Reports Count Update Code End

    //Number Of Email & SMS For Month Count Update Code Start
    public function number_of_email_sms_count_update()
    {
        try {
            $data_get = $this->request->getPost();

            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array        

            $company_id = $data['company_id'];

            if ($company_id != '') {

                //Email Count Update
                $email_success_where = [
                    'tbl_notification_trigger.company_id' => $company_id,
                    'tbl_notification_history.email_notification_status' => 1,
                ];

                $select_column = 'tbl_notification_history.id';

                $email_success = $this->templates_model->getsearchvaluewithjoin('tbl_notification_trigger',  'id', $select_column, 'tbl_notification_history', 'trigger_id', $email_success_where);

                if (!empty(array_filter($email_success))) {
                    $email_data_ids = array_column($email_success, 'id');
                    $email_data_count = count($email_data_ids);
                } else {
                    $email_data_count = 0;
                }

                $email_company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 28,
                ];

                $email_company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $email_company_feature_log_whereConditions);

                $email_company_feature_log_update_whereConditions = [
                    'id' => $email_company_feature_log_check[0]['id'],
                ];

                $email_company_feature_log_data = array(
                    'user_add_count' => $email_data_count,
                );

                $email_count_store = $this->templates_model->updateData('tbl_company_feature_log', $email_company_feature_log_update_whereConditions, $email_company_feature_log_data);

                //SMS Count Update
                $sms_success_where = [
                    'tbl_notification_trigger.company_id' => $company_id,
                    'tbl_notification_history.sms_notification_status' => 1,
                ];

                $select_column = 'tbl_notification_history.id';

                $sms_success = $this->templates_model->getsearchvaluewithjoin('tbl_notification_trigger',  'id', $select_column, 'tbl_notification_history', 'trigger_id', $sms_success_where);

                if (!empty(array_filter($sms_success))) {
                    $sms_data_ids = array_column($sms_success, 'id');
                    $sms_data_count = count($sms_data_ids);
                } else {
                    $sms_data_count = 0;
                }

                $sms_company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => 29,
                ];

                $sms_company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'id', $sms_company_feature_log_whereConditions);

                $sms_company_feature_log_update_whereConditions = [
                    'id' => $sms_company_feature_log_check[0]['id'],
                ];

                $sms_company_feature_log_data = array(
                    'user_add_count' => $sms_data_count,
                );

                $sms_count_store = $this->templates_model->updateData('tbl_company_feature_log', $sms_company_feature_log_update_whereConditions, $sms_company_feature_log_data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'receivedData' => true,
                    'email_count_store' => $email_count_store,
                    'sms_count_store' => $sms_count_store
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'receivedData' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_email_sms_count_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Email & SMS For Month Count Update Code End

    //Number Of Count Get Code Start  
    public function number_of_count_get()
    {
        try {
            $data = $this->request->getPost();

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {
                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'actual_value, user_add_count, start_month, end_month', $company_feature_log_whereConditions);

                return $this->response->setJSON([
                    'status' => 'success',
                    'actual_value' => $company_feature_log_check[0]['actual_value'],
                    'user_add_count' => $company_feature_log_check[0]['user_add_count'],
                    'start_month' => $company_feature_log_check[0]['start_month'],
                    'end_month' => $company_feature_log_check[0]['end_month'],
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'actual_value' => '',
                    'user_add_count' => '',
                    'start_month' => "",
                    'end_month' => "",
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_count_get', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Count Get Code End   

    //Number Of Count Get Laravel Code Start  
    public function number_of_count_get_laravel()
    {
        try {
            $data_get = $this->request->getPost();

            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array     

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {
                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                ];

                $company_feature_log_check = $this->templates_model->GetTableValue('tbl_company_feature_log', 'actual_value, user_add_count, start_month, end_month', $company_feature_log_whereConditions);

                return $this->response->setJSON([
                    'status' => 'success',
                    'actual_value' => $company_feature_log_check[0]['actual_value'],
                    'user_add_count' => $company_feature_log_check[0]['user_add_count'],
                    'start_month' => $company_feature_log_check[0]['start_month'],
                    'end_month' => $company_feature_log_check[0]['end_month']
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'actual_value' => '',
                    'user_add_count' => '',
                    'start_month' => '',
                    'end_month' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'number_of_count_get_laravel', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Number Of Count Get Laravel Code End 

    //Company Page Access Log Get Laravel Code Start
    public function company_page_access_log_laravel()
    {
        try {
            $data_get = $this->request->getPost();

            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array     

            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id']; //Bulk Import Data Logic Set
            }

            if ($login_key_verify_pass != '') {
                $company_page_access_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                    'status' => 'Y'
                ];

                $company_page_access_check = $this->templates_model->GetTableValue('tbl_company_page_access_log', 'subscription_plan_value', $company_page_access_log_whereConditions);

                if (!empty($company_page_access_check)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'subscription_plan_value' => $company_page_access_check[0]['subscription_plan_value']
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'failed',
                        'subscription_plan_value' => '',
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'subscription_plan_value' => '',
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'company_page_access_log_laravel', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Company Page Access Log Get Laravel Code End

    //Mysql Error Message Send Code Start
    public function mysql_error_alert_send_email()
    {
        try {
            $mysql_error_alert_check = $this->templates_model->mysql_error_alert_check();

            if (!empty($mysql_error_alert_check)) {
                $formattedData = [];
                $i = 1;
                foreach ($mysql_error_alert_check as $item) {

                    $utcTime = $item["utc_created_at"];
                    $utcTimezone = new DateTimeZone('UTC');
                    $kolkataTimezone = new DateTimeZone('Asia/Kolkata');

                    // Create a DateTime object with UTC timezone
                    $dateTime = new DateTime($utcTime, $utcTimezone);

                    // Convert to Asia/Kolkata timezone
                    $dateTime->setTimezone($kolkataTimezone);

                    $formattedData[] = [
                        "Error Number" => $i,
                        "Table Row ID" => $item['id'],
                        "Data Base" => 'MySQL',
                        "Module Name" => $item["module_name"],
                        "Current Url" => $item["current_url"],
                        "Function Name" => $item["function_name"],
                        "Error Message" => $item["error_msg"],
                        "UTC created at" => $item["utc_created_at"],
                        "local created at" => $dateTime->format('Y-m-d H:i:s'),
                    ];

                    $i++;
                }

                $message = json_encode($formattedData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                ses_secret_manager::getCredentials();
                $email = \Config\Services::email();

                $email->setFrom(ERROR_MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
                $email->setTo(SUPPORT_MAIL_TO_ADDRESS);
                $email->setSubject(MAIL_SUBJECT);
                $email->setMessage($message);

                if ($email->send()) {

                    $mail_status_whereConditions = [
                        'mail_status' => 0,
                    ];

                    $data = [
                        'mail_status' => 1,
                    ];

                    $this->templates_model->updateData('error_exception_log', $mail_status_whereConditions, $data);
                    return true;
                } else {
                    return false;
                    // return $email->printDebugger(['headers']);
                }
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'mysql_error_alert_send_email', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
    //Mysql Error Message Send Code End   

    //Random UID Gen
    function generateRandomUid()
    {

        try {

            $uuid = Uuid::uuid4();
            $randomId = str_replace('-', '', $uuid->toString());
            return $randomId;
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'generateRandomUid', $e->getMessage(), CODE_ERROR);
            return redirect()->route('global_catch_error');
        }
    }



    // for updating the count of nodes
    public function node_count_update()
    {
        try {
            $data_get = $this->request->getPost();
            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array     
            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = '';
            }

            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];

                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);

                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];

                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);

                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id'];
            }

            if ($login_key_verify_pass != '') {
                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                ];

                $current_plan_node_count = $this->templates_model->GetTableValue('tbl_company_feature_log', 'actual_value', $company_feature_log_whereConditions);


                if ($current_plan_node_count != '') {
                    $company_node_whereConditions = [
                        'company_id' => $company_id,
                        'status' => 'active'
                    ];
                    $nodecount = $this->templates_model->GetTableValueDbTwo('tbl_nodes', 'node_name', $company_node_whereConditions);
                }

                $existing_node_count = ['user_add_count' => count($nodecount)];

                $company_feature_log_update_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                ];

                $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $existing_node_count);

                $used_nodes = $this->templates_model->GetTableValue('tbl_company_feature_log', 'user_add_count', $company_feature_log_update_whereConditions);

                if (!empty($current_plan_node_count)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'current_node_count' => $used_nodes,
                        'total_node_count' => $current_plan_node_count
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'failed',
                        'current_node_count' => '',
                        'total_node_count' => ''
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'current_node_count' => '',
                    'total_node_count' => ''
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'node_count_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }

    // for updating the count of calc_expressions
    public function calc_expression_count_update()
    {
        try {
            $data_get = $this->request->getPost();
            $jsonKey = key($data_get); // Get the key of the JSON string
            $data = json_decode($jsonKey, true); // Decode the JSON string into an array     
            if (isset($data['company_id']) && isset($data['login_key'])) {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = $data['login_key'];
            } else {
                $company_id = $data['company_id'];
                $module_id  = $data['module_id'];
                $login_key  = '';
            }
            $login_key_verify_pass = '';
            if ($login_key != '') {
                $login_key_whereConditions = [
                    'login_key' => $login_key,
                ];
                $user_login_key =  $this->templates_model->GetTableValue('user_login_history ', 'user_id,key_expiry_time', $login_key_whereConditions);
                if (!empty($user_login_key)) {
                    $user_login_whereConditions = [
                        'id' => $user_login_key[0]['user_id'],
                        'status' => 'active',
                    ];
                    $userData = $this->templates_model->GetTableValue('users', '*', $user_login_whereConditions);
                    if (!empty($userData)) {
                        $login_key_verify_pass = $userData[0]['id'];
                    }
                }
            } else {
                $login_key_verify_pass = $data['company_id'];
            }
            if ($login_key_verify_pass != '') {
                $company_feature_log_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                ];
                $current_plan_calc_expression_count = $this->templates_model->GetTableValue('tbl_company_feature_log', 'actual_value', $company_feature_log_whereConditions);
                if ($current_plan_calc_expression_count != '') {
                    $company_node_whereConditions = [
                        'scheduler_id' => $company_id,
                        'status' => 'active'
                    ];
                    $calc_expression_count = $this->templates_model->GetTableValueDbTwo('tbl_function_expression', 'expression', $company_node_whereConditions);
                }
                $calc_expression_count = ['user_add_count' => count($calc_expression_count)];
                // $calc_expression_count = ['user_add_count' => 2000];
                $company_feature_log_update_whereConditions = [
                    'company_id' => $company_id,
                    'module_id' => $module_id,
                ];
                $this->templates_model->updateData('tbl_company_feature_log', $company_feature_log_update_whereConditions, $calc_expression_count);
                $used_calc_expression_count = $this->templates_model->GetTableValue('tbl_company_feature_log', 'user_add_count', $company_feature_log_update_whereConditions);
                if (!empty($current_plan_calc_expression_count)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'current_calc_expression_count' => $used_calc_expression_count,
                        'total_calc_expression_count' => $current_plan_calc_expression_count
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'failed',
                        'current_calc_expression_count' => "",
                        'total_calc_expression_count' => ""
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status' => 'failed',
                    'current_calc_expression_count' => "",
                    'total_calc_expression_count' => ""
                ]);
            }
        } catch (\Exception $e) {
            $currentURL = current_url();
            $this->error_log->error_exception_log('global_templates\templates_controller', $currentURL, 'calc_expression_count_update', $e->getMessage());
            return redirect()->route('global_catch_error');
        }
    }
}
