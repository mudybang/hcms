<?php
$routes->group("group", ["namespace" => "\Auth\Group\Controllers"], function ($routes) {
	$routes->get("/", "GroupController::index");
	$routes->post("get_data", "GroupController::get_data");
	$routes->post("/", "GroupController::create");
	$routes->put("(:num)", "GroupController::update/$1");
	$routes->delete("(:num)", "GroupController::delete/$1");
});