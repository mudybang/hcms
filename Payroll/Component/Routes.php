<?php
$routes->group("allowance", ["namespace" => "\Payroll\Component\Controllers"], function ($routes) {
	$routes->get("/", "Allowance::index");
	$routes->post("get_data", "Allowance::get_data");
	$routes->post("/", "Allowance::create");
	$routes->put("(:num)", "Allowance::update/$1");
	$routes->delete("(:num)", "Allowance::delete/$1");
});
$routes->group("deduction", ["namespace" => "\Payroll\Component\Controllers"], function ($routes) {
	$routes->get("/", "Deduction::index");
	$routes->post("get_data", "Deduction::get_data");
	$routes->post("/", "Deduction::create");
	$routes->put("(:num)", "Deduction::update/$1");
	$routes->delete("(:num)", "Deduction::delete/$1");
});