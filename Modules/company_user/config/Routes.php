<?php

//role Modules Routes
$routes->group('company_user', ['namespace' => '\Modules\company_user\Controllers',"filter" => "loginfilter"], function ($routes) {

	// role
	$routes->get('company_user_add', 'company_user_controller::index', ['as' => 'company_user_add']);

	//company role save
	$routes->post('save_company_user', 'company_user_controller::save_company_user', ['as' => 'save_company_user']);

	//role list view 
	$routes->get('company_user_list', 'company_user_controller::company_user_list', ['as' => 'company_user_list']); 

	// //company role edit page
	$routes->get('company_user_edit/(:num)', 'company_user_controller::company_user_edit/$1', ['as' => 'company_user_edit']);

	// //company role update 
	$routes->post('update_company_user', 'company_user_controller::update_company_user', ['as' => 'update_company_user']);

	// //role delete
	$routes->get('userdelete', 'company_user_controller::userdelete', ['as' => 'userdelete']);
});


?>