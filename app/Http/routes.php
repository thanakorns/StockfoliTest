<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use Illuminate\Http\Request;

//This group has web middleware - a collection of services that are provided by Laravel
//E.G. middleware handles session cookies for us - we don't need to create or verify cooki
Route::group(['middleware' => ['web']], function () {

    //This is a single route
    //The arguments to this route are: '/' - which is the query part of the URL being requested and the function() with specific return argument
    //The client or user is requesting to visit StockFoli.com/ - there's no 'auth' argument to the group so this route assumes the client is not logged in
    //the server calls the view function in response to this request with the argument auth/login - this will generate the HTML for the login page (login.blade)
    Route::get('/', function () {
        return view('auth/login');
    });
    Route::get('/test', function () {
        return view('graph_test');
    });

    //This route is different - it is a post - get routes use differing query parts of the URL as parameters, post routes use paremeters that are separate from a URL
    //The user is doing some action that is asking the server to return StockFoli/stockData. The return value is created by getStockPriceInfo
    Route::post('/stockData', 'HomeController@getStockPriceInfo');

    Route::post('/detailedInformation', 'HomeController@getDetailedStockInformation');
});
//Route::post('/detailedInformation', 'HomeController@getDetailedStockInformation');

Route::post('/ajax/stocks', 'HomeController@stocks');
Route::post('/user/watchlist', 'HomeController@addToWatchlist');

//gropu has web middleware like the group above but also has auth middleware which makes sure the user is logged in before executing any of these routes
Route::group(['middleware' => [ 'web','auth']], function () {

    Route::get('/', 'HomeController@index');
    Route::post('/user/getWatchlist', 'HomeController@returnWatchlistInfo');
    Route::post('/user/transaction', 'HomeController@transaction');


    // Route::get('/home', 'HomeController@index');
});


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //Route::get('/home', 'HomeController@index');
});


