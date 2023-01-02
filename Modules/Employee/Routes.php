<?php
$routes->group("employee", ["namespace" => "\Modules\Employee\Controllers"], function ($routes) {
	$routes->get("/", "Employee::index");
	$routes->post("get_data", "Employee::get_data");
	$routes->post("/", "Employee::create");
	$routes->put("(:num)", "Employee::update/$1");
	$routes->delete("(:num)", "Employee::delete/$1");

	$routes->get("profile/(:num)", "EmployeeProfile::index/$1");
	$routes->post("profile/(:num)", "EmployeeProfile::update/$1");
	$routes->get("sibling/(:num)", "EmployeeSibling::index/$1");
	$routes->post("sibling/(:num)", "EmployeeSibling::update/$1");
	
	$routes->get("eduexp/(:num)", "EmployeeEduexp::index/$1");
	$routes->post("create_edu/(:num)", "EmployeeEduexp::create_edu/$1");
	$routes->post("delete_edu/(:num)", "EmployeeEduexp::delete_edu/$1");
	$routes->post("create_exp/(:num)", "EmployeeEduexp::create_exp/$1");
	$routes->post("delete_exp/(:num)", "EmployeeEduexp::delete_exp/$1");

	$routes->get("sdp/(:num)", "EmployeeSdp::index/$1");
	$routes->post("create_sdp/(:num)", "EmployeeSdp::create/$1");
	$routes->post("delete_sdp/(:num)", "EmployeeSdp::delete/$1");

	$routes->get("employment/(:num)", "EmployeeStatus::index/$1");
	$routes->post("employment/(:num)", "EmployeeStatus::update/$1");

	$routes->get("history/(:num)", "EmployeeHistory::index/$1");
	$routes->post("create_history/(:num)", "EmployeeHistory::create/$1");
	$routes->post("delete_history/(:num)", "EmployeeHistory::delete/$1");

	$routes->get("repun/(:num)", "EmployeeRepun::index/$1");
	$routes->post("create_reward/(:num)", "EmployeeRepun::create_reward/$1");
	$routes->post("delete_reward/(:num)", "EmployeeRepun::delete_reward/$1");
	$routes->post("create_punishment/(:num)", "EmployeeRepun::create_punishment/$1");
	$routes->post("delete_punishment/(:num)", "EmployeeRepun::delete_punishment/$1");

});