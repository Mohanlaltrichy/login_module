<?php

//templates Modules Routes

$routes->group('templates', ['namespace' => '\Modules\global_templates\Controllers'], function ($routes) {

	//Global 404 Error Page
	$routes->get('error', 'templates_controller::global_error_page', ['as' => 'global_error_page']);

	//Global Forbidden Page
	$routes->get('forbidden_error', 'templates_controller::global_forbidden_page', ['as' => 'forbidden_error']);

	//Global Catch Error Page
	$routes->get('error_catch', 'templates_controller::global_catch_error', ['as' => 'global_catch_error']);
	
	//Dashboard Page
	$routes->get('dashboard', 'templates_controller::dashboard', ['as' => 'dashboard',"filter" => "loginfilter"]);	

	//Get Notification Last 1hour Data 
	$routes->get('getnotification', 'templates_controller::getnotification', ['as' => 'getnotification',"filter" => "loginfilter"]);
	
	//Get All Notification Last 48hour Data
	$routes->get('get_all_notification', 'templates_controller::get_all_notification', ['as' => 'get_all_notification',"filter" => "loginfilter"]);	
	
	//edit_compant
	$routes->get('edit_company', 'templates_controller::edit_company', ['as' => 'edit_company',"filter" => "loginfilter"]);	
	$routes->get('get_states', 'templates_controller::get_states', ['as' => 'get_states']);	
	$routes->get('get_cities', 'templates_controller::get_cities', ['as' => 'get_cities']);	
	$routes->post('update_company', 'templates_controller::update_company', ['as' => 'update_company']);	

	//Ackowledge Notification Update
	$routes->post('acknowledge_notification', 'templates_controller::acknowledge_notification', ['as' => 'acknowledge_notification',"filter" => "loginfilter"]);

});

$routes->group('api', ['namespace' => '\Modules\global_templates\Controllers'], function ($routes) {
	//Number Of Tag Update
	$routes->post('number_of_tag_update', 'templates_controller::number_of_tag_update', ['as' => 'number_of_tag_update']);
	$routes->post('number_of_dashboard_template_update', 'templates_controller::number_of_dashboard_template_update', ['as' => 'number_of_dashboard_template_update']);
	$routes->post('number_of_historian_table_update', 'templates_controller::number_of_historian_table_update', ['as' => 'number_of_historian_table_update']);
	$routes->post('number_of_parameter_count_update','templates_controller::number_of_parameter_count_update', ['as' => 'number_of_parameter_count_update']);
	$routes->post('number_of_reports_count_update','templates_controller::number_of_reports_count_update', ['as' => 'number_of_reports_count_update']);
	$routes->post('number_of_email_sms_count_update','templates_controller::number_of_email_sms_count_update', ['as' => 'number_of_email_sms_count_update']);
	$routes->post('number_of_count_get', 'templates_controller::number_of_count_get', ['as' => 'number_of_count_get']);
	$routes->post('number_of_count_get_laravel', 'templates_controller::number_of_count_get_laravel', ['as' => 'number_of_count_get_laravel']);
});
?>