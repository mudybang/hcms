<?php
$routes->group("warning", ["namespace" => "\Modules\Warning\Controllers"], function ($routes) {
	$routes->get("/", "Warning::index");
	$routes->post("get_data", "Warning::get_data");
	$routes->post("/", "Warning::create");
	$routes->put("(:num)", "Warning::update/$1");
	$routes->delete("(:num)", "Warning::delete/$1");
});