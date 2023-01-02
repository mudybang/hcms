<?php
$routes->group("department", ["namespace" => "\Master\Department\Controllers"], function ($routes) {
	$routes->get("/", "Department::index");
	$routes->post("get_data", "Department::get_data");
	$routes->post("/", "Department::create");
	$routes->put("(:num)", "Department::update/$1");
	$routes->delete("(:num)", "Department::delete/$1");
});