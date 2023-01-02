<?php
$routes->group("bpjs", ["namespace" => "\Modules\Bpjs\Controllers"], function ($routes) {
	$routes->get("/", "Bpjs::index");
	$routes->post("get_data", "Bpjs::get_data");
	$routes->post("/", "Bpjs::create");
	$routes->put("(:num)", "Bpjs::update/$1");
	$routes->delete("(:num)", "Bpjs::delete/$1");
	$routes->post("getsiblingfullname/(:num)", "Bpjs::getsiblingfullname/$1");
	$routes->post("getbpjstk/(:num)", "Bpjs::getsiblingfullname/$1");
});