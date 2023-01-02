<?php
$routes->group("employmentstatus", ["namespace" => "\Master\Employmentstatus\Controllers"], function ($routes) {
	$routes->get("/", "Employmentstatus::index");
	$routes->post("get_data", "Employmentstatus::get_data");
	$routes->post("/", "Employmentstatus::create");
	$routes->put("(:num)", "Employmentstatus::update/$1");
	$routes->delete("(:num)", "Employmentstatus::delete/$1");
});