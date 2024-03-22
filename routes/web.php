<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'],  function () {

    Route::get('login/', 'AuthController@login')->name('login');
    Route::post('login/', 'AuthController@postLogin')->name('login');

    Route::get('/register', 'AuthController@register')->name('register');
    Route::post('/register', 'AuthController@postregister')->name('post.register');

});

Route::group(['namespace' => 'App\Http\Controllers\Admin'],  function () {
    Route::get('/get-member-cooperative-loans/{member_id}', 'CooperativeController@getMemberLoans')->name('get-member-loans');
    Route::get('/get-member-savings-loans/{member_id}', 'SavingController@getMemberLoans')->name('get-member-loans');


    Route::middleware(['checkRole:1'])->group(function () {
        Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function () {

            Route::group(['prefix' => '/admin', 'as' => 'admin.'], function () {

                Route::get('/', 'DashboardController@index')->name('index');

                Route::group(['prefix' => '/parties', 'as' => 'parties.'], function () {
                    Route::group(['prefix' => '/customer', 'as' => 'customer.'], function () {
                        Route::get('/', 'CustomerController@index')->name('index');
                        Route::get('/add', 'CustomerController@create')->name('add');
                        Route::post('/add', 'CustomerController@store')->name('add');
                        Route::get('/view/{id}', 'CustomerController@view')->name('view');
                    });
                    Route::group(['prefix' => '/staff', 'as' => 'staff.'], function () {
                        Route::get('/', 'StaffController@index')->name('index');
                        Route::get('/add', 'StaffController@create')->name('add');
                        Route::post('/add', 'StaffController@store')->name('add');
                    });
                });

                Route::group(['prefix' => '/cooperative', 'as' => 'cooperative.'], function () {
                    Route::group(['prefix' => '/contributions', 'as' => 'contributions.'], function () {

                        Route::group(['prefix' => '/payments', 'as' => 'payments.'], function () {
                            Route::get('/', 'CooperativeController@listContributionsPayments')->name('index');
                            Route::get('/add', 'CooperativeController@addContributionsPayments')->name('add');
                            Route::post('/post', 'CooperativeController@storeContributionsPayments')->name('post');
                        });

                        Route::group(['prefix' => '/payouts', 'as' => 'payouts.'], function () {
                            Route::get('/', 'CooperativeController@listContributionsPayouts')->name('index');
                            Route::get('/add', 'CooperativeController@addContributionsPayouts')->name('add');
                            Route::post('/post', 'CooperativeController@storeContributionsPayouts')->name('post');
                        });

                    });


                    Route::group(['prefix' => '/loans', 'as' => 'loans.'], function () {

                        Route::group(['prefix' => '/repayments', 'as' => 'repayments.'], function () {
                            Route::get('/', 'CooperativeController@listLoansPayments')->name('index');
                            Route::get('/add', 'CooperativeController@addLoansPayments')->name('add');
                            Route::post('/post', 'CooperativeController@storeLoansRepayments')->name('post');
                        });

                        Route::group(['prefix' => '/payouts', 'as' => 'payouts.'], function () {
                            Route::get('/', 'CooperativeController@listLoansPayouts')->name('index');
                            Route::get('/add', 'CooperativeController@addLoansPayouts')->name('add');
                            Route::post('/post', 'CooperativeController@storeLoansPayouts')->name('post');
                        });

                    });
                });


                Route::group(['prefix' => '/savings', 'as' => 'savings.'], function () {

                    Route::group(['prefix' => '/contributions', 'as' => 'contributions.'], function () {

                        Route::group(['prefix' => '/payments', 'as' => 'payments.'], function () {
                            Route::get('/', 'SavingController@listContributionsPayments')->name('index');
                            Route::get('/add', 'SavingController@addContributionsPayments')->name('add');
                            Route::post('/post', 'SavingController@storeContributionsPayments')->name('post');
                        });

                        Route::group(['prefix' => '/payouts', 'as' => 'payouts.'], function () {
                            Route::get('/', 'SavingController@listContributionsPayouts')->name('index');
                            Route::get('/add', 'SavingController@addContributionsPayouts')->name('add');
                            Route::post('/post', 'SavingController@storeContributionsPayouts')->name('post');
                        });

                    });


                    Route::group(['prefix' => '/loans', 'as' => 'loans.'], function () {



                        Route::group(['prefix' => '/repayments', 'as' => 'repayments.'], function () {
                            Route::get('/', 'SavingController@listLoansPayments')->name('index');
                            Route::get('/add', 'SavingController@addLoansPayments')->name('add');
                            Route::post('/post', 'SavingController@storeLoansRepayments')->name('post');
                        });

                        Route::group(['prefix' => '/payouts', 'as' => 'payouts.'], function () {
                            Route::get('/', 'SavingController@listLoansPayouts')->name('index');
                            Route::get('/add', 'SavingController@addLoansPayouts')->name('add');
                            Route::post('/post', 'SavingController@storeLoansPayouts')->name('post');
                        });

                    });
                });
            });

        });


        Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {
            Route::get('/all_roles', 'RoleController@index')->name('all_roles');
            Route::get('/add_role', 'RoleController@create')->name('add_role');
            Route::post('/add_role', 'RoleController@store')->name('add_role');
            Route::get('/edit_role/{id}', 'RoleController@edit')->name('edit_role');
            Route::post('/edit_role/{id}', 'RoleController@update')->name('edit_role');
            Route::get('/delete_role/{id}', 'RoleController@destroy')->name('delete_role');
        });
    });
});

Route::group(['namespace' => 'App\Http\Controllers'],  function () {
    Route::get('/', 'FrontPageController@index')->name('index');
    Route::get('/contact', 'ContactController@index')->name('contact');
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});




