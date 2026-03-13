<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('category/(:segment)', 'Home::category/$1');
$routes->get('feed', 'Home::feed');
$routes->get('portfolio', 'Portfolio::index');
// Store Routes
$routes->get('store', 'Store::index');
$routes->get('store/(:segment)', 'Store::show/$1');

// Contact Route
$routes->post('contact/send', 'Contact::send');

$routes->post('comments/store/(:num)', 'Home::storeComment/$1');
$routes->get('(:segment)', 'Home::show/$1');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Posts CRUD
    $routes->get('posts', 'Posts::index');
    $routes->get('posts/create', 'Posts::create');
    $routes->post('posts/store', 'Posts::store');
    $routes->post('posts/generateText', 'Posts::generateText'); // Gemini AI Route
    $routes->get('posts/show/(:num)', 'Posts::show/$1');
    $routes->get('posts/comments/(:num)', 'Posts::comments/$1');
    $routes->post('posts/replyComment/(:num)', 'Posts::replyComment/$1');
    $routes->get('posts/edit/(:num)', 'Posts::edit/$1');
    $routes->post('posts/update/(:num)', 'Posts::update/$1');
    // Categories CRUD
    $routes->get('categories', 'Categories::index');
    $routes->post('categories/store', 'Categories::store');
    $routes->get('categories/edit/(:num)', 'Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Categories::delete/$1');
    // Media Library
    $routes->get('media', 'Media::index');
    $routes->post('media/upload', 'Media::upload');
    $routes->get('media/delete/(:num)', 'Media::delete/$1');

    // Portfolios CRUD
    $routes->get('portfolios', 'Portfolios::index');
    $routes->get('portfolios/create', 'Portfolios::create');
    $routes->post('portfolios/store', 'Portfolios::store');
    $routes->get('portfolios/show/(:num)', 'Portfolios::show/$1');
    $routes->get('portfolios/edit/(:num)', 'Portfolios::edit/$1');
    $routes->post('portfolios/update/(:num)', 'Portfolios::update/$1');
    $routes->get('portfolios/delete/(:num)', 'Portfolios::delete/$1');

    // Products CRUD
    $routes->get('products', 'Products::index');
    $routes->get('products/create', 'Products::create');
    $routes->post('products/store', 'Products::store');
    $routes->get('products/show/(:num)', 'Products::show/$1');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->get('products/delete/(:num)', 'Products::delete/$1');

    // Messages
    $routes->get('messages', 'Messages::index');
    $routes->get('messages/show/(:num)', 'Messages::show/$1');
    $routes->get('messages/delete/(:num)', 'Messages::delete/$1');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('auth', 'Auth::index');
    $routes->post('auth/login', 'Auth::login');
    $routes->get('auth/logout', 'Auth::logout');
});
