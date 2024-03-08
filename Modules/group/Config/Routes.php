<?php

//group Modules Routes
$routes->group('group', ['namespace' => '\Modules\group\Controllers', "filter" => "loginfilter"], function ($routes) {

	// group
	$routes->get('/', 'group_controller::index', ['as' => 'group']);

	// group duplicate check
	$routes->get('group_duplicate_check', 'group_controller::group_duplicate_check', ['as' => 'group_duplicate_check']);

	//group save
	$routes->post('group_save', 'group_controller::group_save', ['as' => 'group_save']);

	//group list view 
	$routes->get('group_list', 'group_controller::group_list', ['as' => 'group_list']);

	//group user view
	$routes->get('group_user_view/(:num)', 'group_controller::group_user_view/$1', ['as' => 'group_user_view']);

	//group user view
	$routes->get('group_user_edit/(:num)', 'group_controller::group_user_edit/$1', ['as' => 'group_user_edit']);

	//Group edit page
	$routes->get('group_edit/(:num)', 'group_controller::group_edit/$1', ['as' => 'group_edit']);

	//group update 
	$routes->post('group_update', 'group_controller::group_update', ['as' => 'group_update']);

	//group delete
	$routes->get('groupdelete', 'group_controller::groupdelete', ['as' => 'groupdelete']);

	//group user update
	$routes->get('group_user_update', 'group_controller::group_user_update', ['as' => 'group_user_update']);
});
