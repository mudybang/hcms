<?php
$routes->group("loan", ["namespace" => "\Modules\Loan\Controllers"], function ($routes) {
	$routes->get("/", "Loan::index");
	$routes->post("get_data", "Loan::get_data");
	$routes->post("/", "Loan::create");
	$routes->put("(:num)", "Loan::update/$1");
	$routes->delete("(:num)", "Loan::delete/$1");
});