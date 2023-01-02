<?php
$routes->group("user", ["namespace" => "\Auth\User\Controllers"], function ($routes) {
	$routes->get("/", "UserController::index");
	$routes->post("get_data", "UserController::get_data");
	$routes->post("/", "UserController::create");
	$routes->put("(:num)", "UserController::update/$1");
	$routes->delete("(:num)", "UserController::delete/$1");
	$routes->get("test", "UserController::test");
});