<?php

//role Modules Routes
$routes->group('company_role', ['namespace' => '\Modules\company_role\Controllers',"filter" => "loginfilter"], function ($routes) {

	// role
	$routes->get('/', 'company_role_controller::index', ['as' => 'company_role']);

	// role duplicate check
	$routes->get('company_role_duplicate_check', 'company_role_controller::company_role_duplicate_check', ['as' => 'company_role_duplicate_check']);

	//company role save
	$routes->post('company_role_save', 'company_role_controller::company_role_save', ['as' => 'company_role_save']);

	//role list view 
	$routes->get('company_role_list', 'company_role_controller::company_role_list', ['as' => 'company_role_list']); 

	//company role edit page
	$routes->get('company_role_edit/(:num)', 'company_role_controller::company_role_edit/$1', ['as' => 'company_role_edit']);

	//company role update 
	$routes->post('company_role_update', 'company_role_controller::company_role_update', ['as' => 'company_role_update']);

	//role delete
	$routes->get('roledelete', 'company_role_controller::roledelete', ['as' => 'roledelete']);
});


?>