<?php
$routes->group("jobtitle", ["namespace" => "\Master\Jobtitle\Controllers"], function ($routes) {
	$routes->get("/", "Jobtitle::index");
	$routes->post("get_data", "Jobtitle::get_data");
	$routes->post("/", "Jobtitle::create");
	$routes->put("(:num)", "Jobtitle::update/$1");
	$routes->delete("(:num)", "Jobtitle::delete/$1");
});