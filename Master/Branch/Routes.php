<?php
$routes->group("branch", ["namespace" => "\Master\Branch\Controllers"], function ($routes) {
	$routes->get("/", "Branch::index");
	$routes->post("get_data", "Branch::get_data");
	$routes->post("/", "Branch::create");
	$routes->put("(:num)", "Branch::update/$1");
	$routes->delete("(:num)", "Branch::delete/$1");
});