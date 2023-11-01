<?php

//login Modules Routes

$routes->group('login', ['namespace' => '\Modules\login\Controllers'], function ($routes) {

	// login
	$routes->get('/', 'login_controller::login', ['as' => 'login',"filter" => "isloggedfilter"]); 

	// login User Check
	$routes->post('user_validation', 'login_controller::user_validation',['as' => 'user_validation',"filter" => "isloggedfilter"]);

	// User Logout
	$routes->get('logout', 'login_controller::logout',['as' => 'logout',"filter" => "loginfilter"]);

});


?>