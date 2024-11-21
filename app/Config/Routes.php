<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/products', 'Product::index');
$routes->get('/produk/tampil', 'Product::tampil_products');
$routes->post('/produk/simpan', 'Product::simpan_produk');
$routes->get('/produk/edit', 'Product::edit_produk');
$routes->post('/produk/update', 'Product::perbarui');
$routes->delete('/produk/hapus/(:num)', 'product::delete/$1');

$routes->get('pelanggan', 'Pelanggan::index');
$routes->get('pelanggan/tampil', 'Pelanggan::tampil_pelanggan');
$routes->post('pelanggan/simpan', 'Pelanggan::simpan_pelanggan');
$routes->delete('/pelanggan/hapus/(:num)', 'Pelanggan::delete/$1');
$routes->post('pelanggan/simpan', 'Pelanggan::simpan_pelanggan');
$routes->get('/pelanggan/edit', 'Pelanggan::edit_pelanggan');
$routes->post('/pelanggan/update', 'Pelanggan::update_pelanggan');