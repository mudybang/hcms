<?php
$routes->group("sdp", ["namespace" => "\Master\Sdp\Controllers"], function ($routes) {
	$routes->get("/", "Sdp::index");
	$routes->post("get_data", "Sdp::get_data");
	$routes->post("/", "Sdp::create");
	$routes->put("(:num)", "Sdp::update/$1");
	$routes->delete("(:num)", "Sdp::delete/$1");
});