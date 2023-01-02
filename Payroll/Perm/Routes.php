<?php
$routes->group("gradeview", ["namespace" => "\Payroll\Perm\Controllers"], function ($routes) {
	$routes->get("/", "Perm::index/0");
	$routes->get("(:num)", "Perm::index/$1");
	$routes->post("(:num)", "Perm::update/$1");
});