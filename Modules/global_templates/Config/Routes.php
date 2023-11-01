<?php

//templates Modules Routes

$routes->group('templates', ['namespace' => '\Modules\global_templates\Controllers'], function ($routes) {

	//Global 404 Error Page
	$routes->get('error', 'templates_controller::global_error_page', ['as' => 'global_error_page']);

	//Global Catch Error Page
	$routes->get('error_catch', 'templates_controller::global_catch_error', ['as' => 'global_catch_error']);
	
	//Dashboard Page
	$routes->get('dashboard', 'templates_controller::dashboard', ['as' => 'dashboard',"filter" => "loginfilter"]);	

});


?>