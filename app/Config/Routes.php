<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
//$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

$modules_paths = [];
$modules_paths[]= ROOTPATH . 'Company/';
$modules_paths[]= ROOTPATH . 'Auth/';
$modules_paths[]= ROOTPATH . 'Master/';
$modules_paths[]= ROOTPATH . 'Modules/';
$modules_paths[]= ROOTPATH . 'Payroll/';
foreach($modules_paths as $modules_path){
	$modules = scandir($modules_path);

	foreach ($modules as $module) {
		if ($module === '.' || $module === '..') {
			continue;
		}

		if (is_dir($modules_path) . '/' . $module) {
			$routes_path = $modules_path . $module . '/Routes.php';
			if (file_exists($routes_path)) {
				require $routes_path;
			} else {
				continue;
			}
		}
	}
}

$routes->resource('post');
// Equivalent to the following:
/*
$routes->get('post', 'Post::index');
$routes->get('post/new', 'Post::new');
$routes->post('post', 'Post::create');
$routes->get('post/(:segment)', 'Post::show/$1');
$routes->get('post/(:segment)/edit', 'Post::edit/$1');
$routes->put('post/(:segment)', 'Post::update/$1');
$routes->patch('post/(:segment)', 'Post::update/$1');
$routes->delete('post/(:segment)', 'Post::delete/$1');
*/