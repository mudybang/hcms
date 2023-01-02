<?php
$routes->group("company", ["namespace" => "\Company\Company\Controllers"], function ($routes) {
	$routes->get("/", "Company::index");
	$routes->post("get_data", "Company::get_data");
	$routes->post("/", "Company::create");
	$routes->put("(:num)", "Company::update/$1");
	$routes->delete("(:num)", "Company::delete/$1");

	$routes->get("profile/(:num)", "Profile::index/$1");
	$routes->post("profile/(:num)", "Profile::update/$1");
});