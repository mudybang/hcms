<?php
$routes->group("history", ["namespace" => "\Modules\History\Controllers"], function ($routes) {
	$routes->get("/", "History::index");
	$routes->post("get_data", "History::get_data");
	$routes->post("/", "History::create");
	$routes->put("(:num)", "History::update/$1");
	$routes->delete("(:num)", "History::delete/$1");
	$routes->get("print/(:num)", "History::print/$1");
});