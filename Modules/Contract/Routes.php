<?php
$routes->group("contract", ["namespace" => "\Modules\Contract\Controllers"], function ($routes) {
	$routes->get("/", "Contract::index");
	$routes->post("get_data", "Contract::get_data");
	$routes->post("/", "Contract::create");
	$routes->put("(:num)", "Contract::update/$1");
	$routes->delete("(:num)", "Contract::delete/$1");
	$routes->get("print/(:num)", "Contract::print/$1");
});