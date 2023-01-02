<?php
$routes->group("perm", ["namespace" => "\Auth\Perm\Controllers"], function ($routes) {
	$routes->get("(:num)", "PermController::index/$1");
	$routes->post("(:num)", "PermController::update/$1");
	$routes->get("test", "PermController::test");
});