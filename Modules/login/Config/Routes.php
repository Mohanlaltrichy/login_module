<?php

//login Modules Routes

$routes->group('login', ['namespace' => '\Modules\login\Controllers'], function ($routes) {

	// login
	$routes->get('/', 'login_controller::login', ['as' => 'login',"filter" => "isloggedfilter"]); 

	$routes->get('password_change', 'login_controller::password_change',['as' => 'password_change']);
	$routes->get('check_old_password', 'login_controller::check_old_password',['as' => 'check_old_password']);
	$routes->post('update_pwd', 'login_controller::update_pwd',['as' => 'update_pwd']);
	// login User Check
	$routes->post('user_validation', 'login_controller::user_validation',['as' => 'user_validation',"filter" => "isloggedfilter"]);

	// login key User Check
	$routes->get('user_login_key_validation/(:any)', 'login_controller::user_login_key_validation/$1',['as' => 'user_login_key_validation']);

	// User Logout
	$routes->get('logout', 'login_controller::logout',['as' => 'logout',"filter" => "loginfilter"]);

});


?>