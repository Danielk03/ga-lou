<?php
use Pecee\SimpleRouter\SimpleRouter;

//index
SimpleRouter::get('/', 'indexController@startIndex');

// ---------------- products --------------------
SimpleRouter::post('/products/', 'productsController@productIndex');
SimpleRouter::get('/products/', 'productsController@productIndex');
SimpleRouter::get('/products/user', 'productsController@userProduct');
SimpleRouter::get('/products/delete/{ProductId}', 'productsController@delete');
SimpleRouter::get('/products/details/{ProductId}', 'productsController@details');
SimpleRouter::post('/products/edit/{ProductId}', 'productsController@editProduct');
SimpleRouter::get('/products/edit/{ProductId}', 'productsController@editProduct');
SimpleRouter::post('/products/store/', 'productsController@storeProduct');
SimpleRouter::post('/products/update/{ProductId}', 'productsController@update');
SimpleRouter::get('/products/upload/', 'productsController@upload');
SimpleRouter::get('/products/image/', 'productsController@uploadImage');
SimpleRouter::post('/products/image/', 'productsController@uploadImage');
//----------------Auth---------------------------------
SimpleRouter::get('/authe/', 'authController@authIndex');
SimpleRouter::get('/authe/delete', 'authController@delete');
SimpleRouter::post('/authe/login/', 'authController@login');
SimpleRouter::get('/authe/login/', 'authController@login');
SimpleRouter::get('/authe/logout/', 'authController@logout');
SimpleRouter::post('/authe/register/', 'authController@registerUser');
SimpleRouter::get('/authe/register/', 'authController@registerUser');
SimpleRouter::get('/authe/edit/', 'authController@editUser');
SimpleRouter::post('/authe/edit/', 'authController@editUser');
SimpleRouter::post('/authe/update/', 'authController@update');
