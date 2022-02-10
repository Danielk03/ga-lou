<?php
use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::get('/', function () {
    require "../App/home.php";
});

// ---------------- products --------------------
SimpleRouter::get('/products/', 'productsController@index');
SimpleRouter::get('/products/upload', 'productsController@upload');
SimpleRouter::post('/products/store', 'productsController@store');
SimpleRouter::get('/products/delete/{ProductId}', 'productsController@delete');
SimpleRouter::get('/products/{ProductId}', 'productsController@showOne');
SimpleRouter::get('/products/edit/{ProductId}', 'productsController@edit');
SimpleRouter::post('/products/{ProductId}', 'productsController@update');
