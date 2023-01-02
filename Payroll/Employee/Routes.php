<?php
$routes->group("payrollemployee", ["namespace" => "\Payroll\Employee\Controllers"], function ($routes) {
	$routes->get("/", "Employee::index");
	$routes->post("get_data", "Employee::get_data");
	$routes->post("/", "Employee::create");
	$routes->put("(:num)", "Employee::update/$1");
	$routes->delete("(:num)", "Employee::delete/$1");
});