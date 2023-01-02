<?php
$routes->group("education", ["namespace" => "\Master\Education\Controllers"], function ($routes) {
	$routes->get("/", "Education::index");
	$routes->post("get_data", "Education::get_data");
	$routes->post("/", "Education::create");
	$routes->put("(:num)", "Education::update/$1");
	$routes->delete("(:num)", "Education::delete/$1");
});