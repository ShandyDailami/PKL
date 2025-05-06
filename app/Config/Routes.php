<?php

use App\Controllers\Inventaris;
use App\Controllers\Jenis;
use App\Controllers\User;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', function ($routes) {
  $routes->get('/', function () {
    return redirect()->to('/perangkat-jaringan');
  });
  $routes->get('/inventaris', [Inventaris::class, 'inventarisUser']);
  $routes->get('/perangkat-jaringan', [Inventaris::class, 'perangkatJaringanUser']);
  $routes->get('/devices', [Inventaris::class, 'get_devices']);
});

$routes->get('admin', function () {
  return redirect()->to('admin/login');
});

$routes->group('admin', function ($routes) {
  $routes->get('dashboard/', function () {
    return redirect()->to('/admin/dashboard/perangkat-jaringan');
  });
  $routes->get('login', [User::class, 'loginPage']);
  $routes->post('login', [User::class, 'login']);
  $routes->get('logout', [User::class, 'logout']);

  $routes->get('dashboard/inventaris/import', [Inventaris::class, 'halamanImport']);
  $routes->post('dashboard/inventaris/import', [Inventaris::class, 'importExcel']);
  $routes->get('dashboard/inventaris/tambah', [Inventaris::class, 'halamanTambah']);
  $routes->post('dashboard/inventaris/tambah', [Inventaris::class, 'tambah']);

  $routes->get('dashboard/inventaris/edit/(:num)', [Inventaris::class, 'halamanUpdate']);
  $routes->post('dashboard/inventaris/edit/(:num)', [Inventaris::class, 'update']);
  $routes->get('dashboard/inventaris/hapus/(:num)', [Inventaris::class, 'hapus']);

  $routes->post('dashboard/jenis-perangkat', [Jenis::class, 'tambah']);
  $routes->get('dashboard/jenis-perangkat/edit/(:num)', [Jenis::class, 'halamanUpdate']);
  $routes->post('dashboard/jenis-perangkat/edit/(:num)', [Jenis::class, 'update']);

  $routes->get('dashboard/inventaris', [Inventaris::class, 'inventarisAdmin']);
  $routes->get('dashboard/perangkat-jaringan', [Inventaris::class, 'perangkatJaringanAdmin']);
  $routes->get('dashboard/jenis-perangkat', [Jenis::class, 'index']);

  $routes->get('dashboard/perangkat-jaringan/pdf', [Inventaris::class, 'exportPerangkatPDF']);
  $routes->get('dashboard/inventaris/pdf', [Inventaris::class, 'exportInventarisPDF']);
  $routes->get('test', [Inventaris::class, 'test']);
});