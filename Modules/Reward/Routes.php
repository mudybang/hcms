<?php
$routes->group("reward", ["namespace" => "\Modules\Reward\Controllers"], function ($routes) {
	$routes->get("/", "Reward::index");
	$routes->post("get_data", "Reward::get_data");
	$routes->post("/", "Reward::create");
	$routes->put("(:num)", "Reward::update/$1");
	$routes->delete("(:num)", "Reward::delete/$1");
});