<?php
$routes->group("insurance", ["namespace" => "\Modules\Insurance\Controllers"], function ($routes) {
	$routes->get("/", "Insurance::index");
	$routes->post("get_data", "Insurance::get_data");
	$routes->post("/", "Insurance::create");
	$routes->put("(:num)", "Insurance::update/$1");
	$routes->delete("(:num)", "Insurance::delete/$1");
	$routes->post("getsiblingfullname/(:num)", "Insurance::getsiblingfullname/$1");
});