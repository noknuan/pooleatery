<?php

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        if (Auth::user()->role == 'Admin' or Auth::user()->role == 'SuperAdmin')
            return view('layouts.app');
        elseif (Auth::user()->role == 'Cashier')
            return redirect('cashier');
        else
            return redirect('error');
    });
    Route::get('error', function () {
        return "Sorry, you are unauthorized to access this page.";
    });
    Route::group(['prefix' => 'user', 'middleware' => 'super_admin'], function () {
        Route::get('/', 'UserController@index');
        Route::match(['get', 'post'], 'create', 'UserController@create');
        Route::match(['get', 'put'], 'update/{id}', 'UserController@update');
        Route::delete('delete/{id}', 'UserController@delete');
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::match(['get', 'put'], 'change-password', 'UserController@changePassword');
        Route::group(['prefix' => 'home'], function () {
            Route::get('/', 'HomeController@index');
        });
        Route::group(['prefix' => 'table'], function () {
            Route::get('/', 'TableController@index');
            Route::match(['get', 'post'], 'create', 'TableController@create');
            Route::match(['get', 'put'], 'update/{id}', 'TableController@update');
            Route::delete('delete/{id}', 'TableController@delete');
        });
        Route::group(['prefix' => 'customer'], function () {
            Route::get('/', 'CustomerController@index');
            Route::match(['get', 'post'], 'create', 'CustomerController@create');
            Route::match(['get', 'put'], 'update/{id}', 'CustomerController@update');
            Route::delete('delete/{id}', 'CustomerController@delete');
        });
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'ProductController@index');
            Route::get('print', 'ProductController@printProducts');
            Route::match(['get', 'post'], 'create', 'ProductController@create');
            Route::match(['get', 'put'], 'update/{id}', 'ProductController@update');
            Route::delete('delete/{id}', 'ProductController@delete');
        });
        Route::group(['prefix' => 'product_category'], function () {
            Route::get('/', 'ProductCategoryController@index');
            Route::match(['get', 'post'], 'create', 'ProductCategoryController@create');
            Route::match(['get', 'put'], 'update/{id}', 'ProductCategoryController@update');
            Route::delete('delete/{id}', 'ProductCategoryController@delete');
        });

        Route::group(['prefix' => 'report'], function () {
            Route::get('daily-summary', 'ReportController@dailySummary');
            Route::get('print-daily-summary', 'ReportController@printDailySummary');
        });
    });
    Route::group(['prefix' => 'cashier', 'middleware' => 'cashier'], function () {
        Route::get('/', 'CashierController@index');
        Route::get('products', 'CashierController@products');
        Route::get('table', 'CashierController@table');
        Route::get('select-table/{id}', 'CashierController@selectTable');
        Route::get('order/{id}', 'CashierController@order');
        Route::get('update-description/{id}/{value}', 'CashierController@updateDescription');
        Route::get('update-quantity/{id}/{value}', 'CashierController@updateQuantity');
        Route::get('update-price/{id}/{value}', 'CashierController@updatePrice');
        Route::get('update-discount-detail/{id}/{value}', 'CashierController@updateDiscountDetail');
        Route::get('update-customer/{id}/{value}', 'CashierController@updateCustomer');
        Route::get('update-discount/{id}/{value}', 'CashierController@updateDiscount');
        Route::delete('delete/{id}', 'CashierController@delete');
        Route::match(['get', 'post'], 'open', 'CashierController@open');
        Route::match(['get', 'post'], 'pay', 'CashierController@pay');
        Route::get('return-order', 'CashierController@returnOrder');
        Route::get('print-payment', 'CashierController@printPayment');
        Route::get('print', 'CashierController@getPrint');
        Route::get('reload-order', 'CashierController@reloadOrder');
    });

});