<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landing::index');
$routes->get('landing/media/(:any)', 'Landing::media/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('aset', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Aset::index');
    $routes->get('(:num)/modal', 'Aset::modal/$1');
    $routes->get('(:num)', 'Aset::show/$1');
});

$routes->group('aset', ['filter' => 'role:Admin,Pengelola Aset'], static function ($routes) {
    $routes->get('create', 'Aset::create');
    $routes->post('/', 'Aset::store');
    $routes->get('import', 'Aset::importForm');
    $routes->post('import', 'Aset::importProcess');
    $routes->get('export/csv', 'Aset::exportCsv');
    $routes->get('export/print', 'Aset::printReport');
    $routes->get('(:num)/edit', 'Aset::edit/$1');
    $routes->put('(:num)', 'Aset::update/$1');
    $routes->delete('(:num)', 'Aset::delete/$1');
});

$routes->group('proses', ['filter' => 'role:Admin,Pengelola Aset'], static function ($routes) {
    $routes->post('(:num)', 'Proses::store/$1');
    $routes->delete('(:num)', 'Proses::delete/$1');
});

$routes->group('dokumen', ['filter' => 'role:Admin,Pengelola Aset,Petugas Lapangan'], static function ($routes) {
    $routes->post('(:num)', 'Dokumen::store/$1');
    $routes->get('view/(:num)', 'Dokumen::view/$1');
    $routes->get('download/(:num)', 'Dokumen::download/$1');
    $routes->delete('(:num)', 'Dokumen::delete/$1');
});

$routes->group('pengamanan', ['filter' => 'role:Admin,Petugas Lapangan'], static function ($routes) {
    $routes->post('(:num)', 'Pengamanan::store/$1');
});

$routes->group('peta', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Peta::index');
});

$routes->group('surat', ['filter' => 'role:Admin,Pengelola Aset'], static function ($routes) {
    $routes->get('skpt', 'SuratTanah::skpt');
    $routes->post('skpt', 'SuratTanah::storeSkpt');
    $routes->get('skpt/(:num)', 'SuratTanah::showSkpt/$1');
    $routes->delete('skpt/(:num)', 'SuratTanah::deleteSkpt/$1');
    $routes->get('skpt/(:num)/print', 'SuratTanah::printSkpt/$1');
    $routes->get('skpt/(:num)/pdf', 'SuratTanah::pdfSkpt/$1');
    $routes->get('skpt/(:num)/word', 'SuratTanah::exportWordSkpt/$1');
    $routes->get('pernyataan-batas', 'SuratTanah::pernyataanBatas');
});

$routes->group('users', ['filter' => 'role:Admin'], static function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('create/modal', 'Users::modalCreate');
    $routes->get('create', 'Users::create');
    $routes->post('/', 'Users::store');
    $routes->get('(:num)/edit/modal', 'Users::modalEdit/$1');
    $routes->get('(:num)/edit', 'Users::edit/$1');
    $routes->put('(:num)', 'Users::update/$1');
    $routes->delete('(:num)', 'Users::delete/$1');
});

$routes->group('status', ['filter' => 'role:Admin'], static function ($routes) {
    $routes->get('/', 'Status::index');
    $routes->get('create/modal', 'Status::modalCreate');
    $routes->get('create', 'Status::create');
    $routes->post('/', 'Status::store');
    $routes->get('(:num)/edit/modal', 'Status::modalEdit/$1');
    $routes->get('(:num)/edit', 'Status::edit/$1');
    $routes->put('(:num)', 'Status::update/$1');
    $routes->delete('(:num)', 'Status::delete/$1');
});

$routes->group('landing-settings', ['filter' => 'role:Admin'], static function ($routes) {
    $routes->get('/', 'LandingSettings::index');
    $routes->post('/', 'LandingSettings::update');
});

$routes->group('master', ['filter' => 'role:Admin'], static function ($routes) {
    $routes->get('kecamatan', 'MasterData::kecamatan');
    $routes->get('kecamatan/(:num)/edit', 'MasterData::editKecamatan/$1');
    $routes->post('kecamatan', 'MasterData::storeKecamatan');
    $routes->post('kecamatan/(:num)', 'MasterData::updateKecamatan/$1');
    $routes->post('kecamatan/delete/(:num)', 'MasterData::deleteKecamatan/$1');

    $routes->get('desa', 'MasterData::desa');
    $routes->get('desa/(:num)/edit', 'MasterData::editDesa/$1');
    $routes->post('desa', 'MasterData::storeDesa');
    $routes->post('desa/bulk-kecamatan', 'MasterData::bulkUpdateDesaKecamatan');
    $routes->post('desa/(:num)', 'MasterData::updateDesa/$1');
    $routes->put('desa/(:num)', 'MasterData::updateDesa/$1');
    $routes->post('desa/delete/(:num)', 'MasterData::deleteDesa/$1');
    $routes->delete('desa/delete/(:num)', 'MasterData::deleteDesa/$1');

    $routes->get('kepala-desa', 'MasterData::kepalaDesa');
    $routes->get('kepala-desa/(:num)/edit', 'MasterData::editKepalaDesa/$1');
    $routes->post('kepala-desa', 'MasterData::storeKepalaDesa');
    $routes->post('kepala-desa/(:num)', 'MasterData::updateKepalaDesa/$1');
    $routes->post('kepala-desa/delete/(:num)', 'MasterData::deleteKepalaDesa/$1');

    $routes->get('camat', 'MasterData::camat');
    $routes->get('camat/(:num)/edit', 'MasterData::editCamat/$1');
    $routes->post('camat', 'MasterData::storeCamat');
    $routes->post('camat/bulk-kecamatan', 'MasterData::bulkUpdateCamatKecamatan');
    $routes->post('camat/(:num)', 'MasterData::updateCamat/$1');
    $routes->post('camat/delete/(:num)', 'MasterData::deleteCamat/$1');

    $routes->get('pemohon', 'MasterData::pemohon');
    $routes->get('pemohon/(:num)/edit', 'MasterData::editPemohon/$1');
    $routes->post('pemohon', 'MasterData::storePemohon');
    $routes->post('pemohon/(:num)', 'MasterData::updatePemohon/$1');
    $routes->post('pemohon/delete/(:num)', 'MasterData::deletePemohon/$1');
});
