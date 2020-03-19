<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
  Route::post('login', 'AuthController@login');
  Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

  Route::get('users', 'UserController@index');
  Route::post('users', 'UserController@create');
  Route::post('users/bulk', 'UserController@bulk');
  Route::get('users/{id}', 'UserController@show');
  Route::patch('users/{id}', 'UserController@update');
  Route::delete('users/{id}', 'UserController@delete');

  Route::get('merchants', 'MerchantController@index');
  Route::post('merchants', 'MerchantController@create');
  Route::post('merchants/bulk', 'MerchantController@bulk');
  Route::get('merchants/{id}', 'MerchantController@show');
  Route::patch('merchants/{id}', 'MerchantController@update');
  Route::delete('merchants/{id}', 'MerchantController@delete');

  Route::get('products', 'ProductController@index');
  Route::post('products', 'ProductController@create');
  Route::post('products/bulk', 'ProductController@bulk');
  Route::get('products/{id}', 'ProductController@show');
  Route::patch('products/{id}', 'ProductController@update');
  Route::delete('products/{id}', 'ProductController@delete');

  Route::get('stocks', 'StockController@index');
  Route::post('stocks', 'StockController@create');
  Route::post('stocks/bulk', 'StockController@bulk');
  Route::get('stocks/{id}', 'StockController@show');
  Route::patch('stocks/{id}', 'StockController@update');
  Route::patch('stocks/{id}/product', 'StockController@updateByproduct');
  Route::delete('stocks/{id}', 'StockController@delete');

  Route::get('transactions', 'TransactionController@index');
  Route::get('transactions/merchant', 'TransactionController@merchantTransaction');
  Route::post('transactions', 'TransactionController@create');
  Route::post('transactions/bulk', 'TransactionController@bulk');
  Route::get('transactions/{id}', 'TransactionController@show');
  Route::patch('transactions/{id}', 'TransactionController@update');
  Route::delete('transactions/{id}', 'TransactionController@delete');

  Route::get('rewardpoints', 'RewardPointController@index');
  Route::post('rewardpoints', 'RewardPointController@create');
  Route::post('rewardpoints/bulk', 'RewardPointController@bulk');
  Route::get('rewardpoints/{id}', 'RewardPointController@show');
  Route::patch('rewardpoints/{id}', 'RewardPointController@update');
  Route::delete('rewardpoints/{id}', 'RewardPointController@delete');

