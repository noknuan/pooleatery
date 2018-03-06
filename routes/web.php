<?php

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
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
            Route::match(['get', 'post'], 'exchange-rate', 'HomeController@exchangeRate');
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
        Route::group(['prefix' => 'item'], function () {
            Route::get('/', 'ItemController@index');
            Route::get('unit/{item_id}', 'ItemController@unit');
            Route::match(['get', 'post'], 'create', 'ItemController@create');
            Route::match(['get', 'put'], 'update/{id}', 'ItemController@update');
            Route::delete('delete/{id}', 'ItemController@delete');
        });
        Route::group(['prefix' => 'item_category'], function () {
            Route::get('/', 'ItemCategoryController@index');
            Route::match(['get', 'post'], 'create', 'ItemCategoryController@create');
            Route::match(['get', 'put'], 'update/{id}', 'ItemCategoryController@update');
            Route::delete('delete/{id}', 'ItemCategoryController@delete');
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
        Route::group(['prefix' => 'recipe'], function () {
            Route::get('/', 'RecipeController@index');
            Route::match(['get', 'post'], 'create', 'RecipeController@create');
            Route::match(['get', 'put'], 'update/{id}', 'RecipeController@update');
            Route::delete('delete/{id}', 'RecipeController@delete');
        });
        Route::group(['prefix' => 'report'], function () {
            Route::get('stock-balance', 'ReportController@stockBalance');
            Route::get('print-stock-balance', 'ReportController@printStockBalance');
            Route::get('stock-in', 'ReportController@stockIn');
            Route::get('stock-adjustment', 'ReportController@stockAdjustment');
            Route::get('daily-summary', 'ReportController@dailySummary');
            Route::get('print-daily-summary', 'ReportController@printDailySummary');
            Route::get('sale-history', 'ReportController@saleHistory');
            Route::get('sale-deleted-report', 'ReportController@saleDeletedReport');
            Route::get('sale-detail', 'ReportController@saleDetail');
            Route::get('export-detail-report', 'ReportController@exportDetailReport');
            Route::get('sale-stock', 'ReportController@saleStock');
            Route::get('sale-discount', 'ReportController@saleDiscount');
            Route::get('sale-graph', 'ReportController@saleGraph');
            Route::get('view-detail/{id}', 'ReportController@viewDetail');
        });
    });
    Route::group(['prefix' => 'cashier', 'middleware' => 'cashier'], function () {
        Route::get('/', 'CashierController@index');
        Route::get('products', 'CashierController@products');
        Route::get('table', 'CashierController@table');
        Route::get('select-table/{id}', 'CashierController@selectTable');
        Route::get('change-table', 'CashierController@changeTable');
        Route::get('switch-table/{id}', 'CashierController@switchTable');
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