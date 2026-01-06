<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'landing';

// Frontend Pages
$route['menu'] = 'landing/menu';
$route['order'] = 'landing/order';
$route['order/submit'] = 'landing/submit_order';
$route['order/thanks'] = 'landing/thanks';
$route['track'] = 'landing/track';
$route['login'] = 'admin/auth/login';


// Admin Backend Routes
$route['admin'] = 'admin/dashboard';
$route['admin/login'] = 'admin/auth/login';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/dashboard'] = 'admin/dashboard/index';

// User Management
$route['admin/user'] = 'admin/user/index';
$route['admin/user/(:any)'] = 'admin/user/$1';

// Employee Management
$route['admin/karyawan'] = 'admin/karyawan/index';
$route['admin/karyawan/(:any)'] = 'admin/karyawan/$1';

// Menu Management
$route['admin/kategori'] = 'admin/kategori/index';
$route['admin/kategori/(:any)'] = 'admin/kategori/$1';
$route['admin/menu'] = 'admin/menu/index';
$route['admin/menu/(:any)'] = 'admin/menu/$1';

// Customer Management
$route['admin/konsumen'] = 'admin/konsumen/index';
$route['admin/konsumen/(:any)'] = 'admin/konsumen/$1';

// Stock & Inventory
$route['admin/bahan'] = 'admin/bahan/index';
$route['admin/bahan/(:any)'] = 'admin/bahan/$1';
$route['admin/inventaris'] = 'admin/inventaris/index';
$route['admin/inventaris/(:any)'] = 'admin/inventaris/$1';

// Supplier & Purchase
$route['admin/supplier'] = 'admin/supplier/index';
$route['admin/supplier/(:any)'] = 'admin/supplier/$1';
$route['admin/pembelian'] = 'admin/pembelian/index';
$route['admin/pembelian/(:any)'] = 'admin/pembelian/$1';

// POS & Transactions
$route['admin/pos'] = 'admin/pos/index';
$route['admin/pos/(:any)'] = 'admin/pos/$1';
$route['admin/transaksi'] = 'admin/transaksi/index';
$route['admin/transaksi/(:any)'] = 'admin/transaksi/$1';

// HR & Payroll
$route['admin/absensi'] = 'admin/absensi/index';
$route['admin/absensi/(:any)'] = 'admin/absensi/$1';
$route['admin/penggajian'] = 'admin/penggajian/index';
$route['admin/penggajian/(:any)'] = 'admin/penggajian/$1';

// Reports
$route['admin/laporan'] = 'admin/laporan/index';
$route['admin/laporan/(:any)'] = 'admin/laporan/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

