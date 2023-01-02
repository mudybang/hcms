<?php
$routes->group("grade", ["namespace" => "\Payroll\Grade\Controllers"], function ($routes) {
	$routes->get("/", "Grade::index");
	$routes->post("get_data", "Grade::get_data");
	$routes->post("/", "Grade::create");
	$routes->put("(:num)", "Grade::update/$1");
	$routes->delete("(:num)", "Grade::delete/$1");
});