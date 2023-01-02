<?php
$routes->group("project", ["namespace" => "\Master\Project\Controllers"], function ($routes) {
	$routes->get("/", "Project::index");
	$routes->post("get_data", "Project::get_data");
	$routes->post("/", "Project::create");
	$routes->put("(:num)", "Project::update/$1");
	$routes->delete("(:num)", "Project::delete/$1");
});