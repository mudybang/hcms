<?php
$routes->group("sdpreport", ["namespace" => "\Modules\SdpReport\Controllers"], function ($routes) {
	$routes->get("/", "SdpReport::index");
	$routes->post("get_data", "SdpReport::get_data");
	$routes->post("/", "SdpReport::create");
	$routes->put("(:num)", "SdpReport::update/$1");
	$routes->delete("(:num)", "SdpReport::delete/$1");
});