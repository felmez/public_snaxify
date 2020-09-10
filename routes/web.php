<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// enable direct log in page by login when going to home > /root
Route::get('/login', 'Auth\LoginController@showLoginForm');
// enable registration by register when going to /register
Route::get('/register', 'Auth\RegisterController@showRegisterForm');
// enable logging out by logout when going to /logout
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
// added to display welcome page not 404
Route::get('/', function () {
    return view('welcome');
});
// added to display home page not 404 after login
Route::get('/home', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

// new registration controller testing and failed lul :()
// Route::get('/register', '\App\Http\Controllers\RegistrationController@create');
// Route::post('register', '\App\Http\Controllers\RegistrationController@store');

// resource for roles testing
// Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'],
//     function () {
//         Route::match(['get', 'post'], '/adminOnlyPage/', 'HomeController@admin');
//     });

// resource for roles
// Route::group(['middleware' => 'App\Http\Middleware\OwnerMiddleware'],
//     function () {
//         Route::match(['get', 'post'], '/ownerOnlyPage/', 'HomeController@owner');
//     });

// resource for roles
// Route::group(['middleware' => 'App\Http\Middleware\CustomerMiddleware'],
//     function () {
//         Route::match(['get', 'post'], '/customerOnlyPage/', 'HomeController@customer');
//     });

// Auth::routes();

// Route::get('thread/search','ThreadController@search');
// Route::post('/thread/mark-as-solution','ThreadController@markAsSolution')->name('markAsSolution');
// Route::resource('/thread','ThreadController');
// Route::resource('comment','CommentController',['only'=>['update','destroy']]);
// Route::post('comment/create/{thread}','CommentController@addThreadComment')->name('threadcomment.store');
// Route::post('reply/create/{comment}','CommentController@addReplyComment')->name('replycomment.store');
// Route::post('comment/like','LikeController@toggleLike')->name('toggleLike');
// Route::get('/user/profile/{user}', 'UserProfileController@index')->name('user_profile')->middleware('auth');
// Route::get('/markAsRead',function(){
//     auth()->user()->unreadNotifications->markAsRead();
// });
