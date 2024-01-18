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

Route::get('/testmail', function () {
    return view('testmail');

});

Route::get('/invoice', function () {
    return view('invoice_attachment');

});



Route::group(['namespace' => 'App\Http\Controllers'],  function () {
        Route::get('login/', 'AuthController@login')->name('login');
        Route::post('login/', 'AuthController@postLogin')->name('login');

        Route::get('/register', 'AuthController@register')->name('register');
        Route::post('/register', 'AuthController@postregister')->name('post.register');





        Route::middleware(['checkRole:1'])->group(function () {
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');



            Route::group(['prefix' => '/job_order', 'as' => 'job_order.'], function () {
                //status
                Route::group(['prefix' => '/status', 'as' => 'status.'], function () {
                    Route::get('/pending', 'JobOrderController@pending')->name('pending');
                    Route::get('/designed', 'JobOrderController@designed')->name('designed');
                    Route::get('/binded', 'JobOrderController@binded')->name('binded');
                    Route::get('/completed', 'JobOrderController@completed')->name('completed');
                    Route::get('/customer_approved', 'JobOrderController@approved')->name('customer_approved');
                    Route::get('/delivered', 'JobOrderController@delivered')->name('delivered');
                    Route::get('/prepressed', 'JobOrderController@prepressed')->name('prepressed');
                    Route::get('/printed', 'JobOrderController@printed')->name('printed');
                    Route::get('/proof_read', 'JobOrderController@proof_read')->name('proof_read');
                });

                Route::get('/all_orders', 'JobOrderController@index')->name('all_orders');
                Route::get('/view_order/{job_title}/{id}', 'JobOrderController@view_order')->name('view_order');
                Route::post('/view_order/{job_title}/{id}', 'JobOrderController@changeJobStatus')->name('view_order');
                Route::post('/approved_design/{job_title}/{id}', 'JobOrderController@uploadApprovedDesign')->name('approved_design');
                Route::get('/delete_order/{id}', 'JobOrderController@delete_job_order')->name('delete_order');
                Route::get('/track_order/{job_title}/{id}', 'JobOrderController@track_job_order')->name('track_order');
                Route::get('/transaction_history/{job_title}/{id}', 'JobOrderController@transaction_history')->name('transaction_history');
                Route::post('/transaction_history/{job_title}/{id}', 'JobOrderController@updateJobPayment')->name('transaction_history');

                // Route::get('/order_invoice/{job_title}/{id}', 'JobOrderController@orderInvoice')->name('order_invoice');
                Route::get('/order_invoice_pdf/{order_no?}', 'JobOrderController@orderInvoicePdf')->name('order_invoice_pdf');


                Route::get('/higher_education', 'JobOrderController@higher_education')->name('higher_education');
                Route::post('/higher_education', 'JobOrderController@post_higher_education')->name('higher_education');
                Route::get('/edit_order/{job_title}/{id}', 'JobOrderController@edit_order')->name('edit_order');
                Route::post('/edit_order/{job_title}/{id}', 'JobOrderController@update_order')->name('edit_order');

                Route::get('/20_leaves_book', 'JobOrderController@twenty_leaves')->name('20_leaves_book');
                Route::post('/20_leaves_book', 'JobOrderController@post_twenty_leaves')->name('20_leaves_book');


                Route::get('/40_leaves_book', 'JobOrderController@forty_leaves')->name('40_leaves_book');
                Route::post('/40_leaves_book', 'JobOrderController@post_forty_leaves')->name('40_leaves_book');
                Route::get('/80_leaves_book', 'JobOrderController@eighty_leaves')->name('80_leaves_book');
                Route::post('/80_leaves_book', 'JobOrderController@post_eighty_leaves')->name('80_leaves_book');
                Route::get('/booklets', 'JobOrderController@booklets')->name('booklets');
                Route::post('/booklets', 'JobOrderController@post_booklets')->name('booklets');
                Route::get('/bronchures', 'JobOrderController@bronchures')->name('bronchures');
                Route::post('/bronchures', 'JobOrderController@post_bronchures')->name('bronchures');
                Route::get('/business_cards', 'JobOrderController@business_cards')->name('business_cards');
                Route::post('/business_cards', 'JobOrderController@post_business_cards')->name('business_cards');
                Route::get('/envelopes', 'JobOrderController@envelopes')->name('envelopes');
                Route::post('/envelopes', 'JobOrderController@post_envelopes')->name('envelopes');
                Route::get('/flyers', 'JobOrderController@flyers')->name('flyers');
                Route::post('/flyers', 'JobOrderController@post_flyers')->name('flyers');
                Route::get('/notepads', 'JobOrderController@notepads')->name('notepads');
                Route::post('/notepads', 'JobOrderController@post_notepads')->name('notepads');
                Route::get('/small_invoice', 'JobOrderController@small_invoice')->name('small_invoice');
                Route::post('/small_invoice', 'JobOrderController@post_small_invoice')->name('small_invoice');
                Route::get('/stickers', 'JobOrderController@stickers')->name('stickers');
                Route::post('/stickers', 'JobOrderController@post_stickers')->name('stickers');
                Route::get('/work_order_templates', 'JobOrderController@work_order_templates')->name('work_order_templates');

                Route::group(['prefix' => '/location', 'as' => 'location.'], function () {
                    Route::get('/add_location', 'JobOrderController@add_location')->name('add_location');
                    Route::post('/add_location', 'JobOrderController@post_location')->name('add_location');
                    Route::get('/all_locations', 'JobOrderController@all_location')->name('all_locations');
                    Route::get('/view_location/{id}', 'JobOrderController@view_location')->name('view_location');
                    Route::get('/edit_location/{id}', 'JobOrderController@edit_location')->name('edit_location');
                    Route::post('/edit_location/{id}', 'JobOrderController@update_location')->name('update_location');
                    Route::get('/delete_location/{id}', 'JobOrderController@delete_location')->name('delete_location');
                });
            });


            Route::group(['prefix' => '/external_job_order', 'as' => 'external_job_order.'], function () {
                //status
                Route::group(['prefix' => '/status', 'as' => 'status.'], function () {
                    Route::get('/pending', 'ExternalJobOrderController@pending')->name('pending');
                    Route::get('/designed', 'ExternalJobOrderController@designed')->name('designed');
                    Route::get('/binded', 'ExternalJobOrderController@binded')->name('binded');
                    Route::get('/completed', 'ExternalJobOrderController@completed')->name('completed');
                    Route::get('/customer_approved', 'ExternalJobOrderController@approved')->name('customer_approved');
                    Route::get('/delivered', 'ExternalJobOrderController@delivered')->name('delivered');
                    Route::get('/prepressed', 'ExternalJobOrderController@prepressed')->name('prepressed');
                    Route::get('/printed', 'ExternalJobOrderController@printed')->name('printed');
                    Route::get('/proof_read', 'ExternalJobOrderController@proof_read')->name('proof_read');
                });
                Route::get('/all_orders', 'ExternalJobOrderController@index')->name('all_orders');
                Route::get('/view_order/{id}', 'ExternalJobOrderController@view_order')->name('view_order');
                Route::post('/view_order/{id}', 'ExternalJobOrderController@changeJobStatus')->name('view_order');
                Route::post('/approved_design/{id}', 'ExternalJobOrderController@uploadApprovedDesign')->name('approved_design');
                Route::get('/edit_order/{id}', 'ExternalJobOrderController@edit_order')->name('edit_order');
                Route::post('/edit_order/{id}', 'ExternalJobOrderController@update_order')->name('edit_order');
                Route::get('/delete_order/{id}', 'ExternalJobOrderController@delete_job_order')->name('delete_order');
                Route::get('/track_order/{id}', 'ExternalJobOrderController@track_job_order')->name('track_order');
                Route::get('/transaction_history/{id}', 'ExternalJobOrderController@transaction_history')->name('transaction_history');
                Route::post('/transaction_history/{id}', 'ExternalJobOrderController@updateJobPayment')->name('transaction_history');
                Route::get('/order_invoice_pdf/{order_no?}', 'ExternalJobOrderController@orderInvoicePdf')->name('order_invoice_pdf');
            });


            Route::group(['prefix' => '/products', 'as' => 'products.'], function () {
                Route::get('/all_products', 'ProductController@index')->name('all_products');

                Route::get('/view/{job_title}/{id}', 'ProductController@show')->name('view');
                Route::get('/edit/{job_title}/{id}', 'ProductController@edit')->name('edit');
                Route::post('/edit/{job_title}/{id}', 'ProductController@update')->name('update');
                Route::get('/edit_pricing/{job_title}/{id}', 'ProductController@edit_pricing')->name('edit_pricing');
                Route::post('/edit_pricing/{job_title}/{id}', 'ProductController@update_pricing')->name('edit_pricing');
                Route::get('/delete_product/{id}', 'ProductController@delete_product')->name('delete_product');

                Route::get('/add_higher_education', 'ProductController@create_higher_education')->name('add_higher_education');
                Route::post('/add_higher_education', 'ProductController@store_higher_education')->name('add_higher_education');

                Route::get('/add_eighty_leaves', 'ProductController@create_eighty_leaves')->name('add_eighty_leaves');
                Route::post('/add_eighty_leaves', 'ProductController@store_eighty_leaves')->name('add_eighty_leaves');

                Route::get('/add_forty_leaves', 'ProductController@create_forty_leaves')->name('add_forty_leaves');
                Route::post('/add_forty_leaves', 'ProductController@store_forty_leaves')->name('add_forty_leaves');

                Route::get('/add_twenty_leaves', 'ProductController@create_twenty_leaves')->name('add_twenty_leaves');
                Route::post('/add_twenty_leaves', 'ProductController@store_twenty_leaves')->name('add_twenty_leaves');
            });


            Route::group(['prefix' => '/finance', 'as' => 'finance.'], function () {

                Route::group(['prefix' => '/requisitions', 'as' => 'requisitions.'], function () {
                    Route::get('/add_requisition', 'RequisitionController@create')->name('add_requisition');
                    Route::post('/add_requisition', 'RequisitionController@store')->name('add_requisition');
                    Route::get('/all_requisition', 'RequisitionController@index')->name('all_requisitions');
                    Route::get('/edit_requisition/{id}', 'RequisitionController@edit')->name('edit_requisition');
                    Route::post('/edit_requisition/{id}', 'RequisitionController@update')->name('edit_requisition');
                });

                Route::group(['prefix' => '/expenses', 'as' => 'expenses.'], function () {
                    Route::get('/all_expenses', 'FinanceController@all_expenses')->name('all_expenses');
                    Route::get('/add_expense', 'FinanceController@create_expense')->name('add_expense');
                    Route::post('/add_expense', 'FinanceController@store_expense')->name('add_expense');
                    Route::get('/view_expense/{id}', 'FinanceController@view_expense')->name('view_expense');
                    Route::get('/edit_expense/{id}', 'FinanceController@edit_expense')->name('edit_expense');
                    Route::post('/edit_expense/{id}', 'FinanceController@update_expense')->name('edit_expense');
                    Route::get('/delete_expense/{id}', 'FinanceController@delete_expense')->name('delete_expense');
                    Route::post('/update_expense_payment/{id}', 'FinanceController@update_expense_payment')->name('update_expense_payment');
                    Route::get('/payment_history/{id}', 'FinanceController@payment_history')->name('payment_history');

                });

                Route::group(['prefix' => '/transactions', 'as' => 'transactions.'], function () {
                    Route::get('/all_transactions', 'TransactionController@index')->name('all_transactions');
                });


                Route::group(['prefix' => '/debtors', 'as' => 'debtors.'], function () {
                    Route::get('/all_debtors', 'FinanceController@all_debtors')->name('all_debtors');
                });
                Route::group(['prefix' => '/creditors', 'as' => 'creditors.'], function () {
                    Route::get('/all_creditors', 'FinanceController@all_creditors')->name('all_creditors');
                });

            });


            Route::group(['prefix' => '/settings', 'as' => 'settings.'], function () {

                Route::group(['prefix' => '/category', 'as' => 'category.'], function () {
                    Route::get('/add_category', 'SettingController@create_category')->name('add_category');
                    Route::post('/add_category', 'SettingController@post_category')->name('add_category');
                    Route::get('/all_category', 'SettingController@index')->name('all__category');
                    Route::get('/edit_category/{id}', 'RequisitionController@edit')->name('edit_category');
                    Route::post('/edit_category/{id}', 'RequisitionController@update')->name('edit_category');
                });

            });


            Route::group(['prefix' => '/customers', 'as' => 'customers.'], function () {
                Route::get('/add_customer', 'CustomerController@create')->name('add_customer');
                Route::post('/add_customer', 'CustomerController@store')->name('add_customer');
                Route::get('/all_customers', 'CustomerController@index')->name('all_customers');
                Route::get('/edit_customer/{id}', 'CustomerController@edit')->name('edit_customer');
                Route::post('/edit_customer/{id}', 'CustomerController@update')->name('edit_customer');
                Route::get('/view_customer/{id}', 'CustomerController@show')->name('view_customer');
                Route::get('/customer_job_orders/{id}', 'CustomerController@customer_job_orders')->name('customer_job_orders');
                Route::get('/customer_cart/{id}', 'CustomerController@customer_cart')->name('customer_cart');
                Route::post('/customer_cart/{id}', 'CustomerController@checkout')->name('customer_cart');
                Route::get('/transaction_history/{id}', 'CustomerController@transaction_history')->name('transaction_history');
                Route::get('/delete_customer/{id}', 'CustomerController@destroy')->name('delete_customer');
            });




            Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
                Route::get('/add_user', 'UserController@create')->name('add_user');
                Route::post('/add_user', 'UserController@store')->name('add_user');
                Route::get('/all_users', 'UserController@index')->name('all_users');
                Route::get('/edit_user/{id}', 'UserController@edit')->name('edit_user');
                Route::post('/edit_user/{id}', 'UserController@update')->name('edit_user');
                Route::get('/view_user/{id}', 'UserController@show')->name('view_user');
                Route::get('/delete_user/{id}', 'UserController@destroy')->name('delete_user');

                Route::get('/view_profile', 'UserController@view_profile')->name('view_profile');
                Route::get('/edit_profile', 'UserController@edit_profile')->name('edit_profile');
                Route::post('/edit_profile', 'UserController@update_profile')->name('edit_profile');
                Route::get('/change_password', 'UserController@change_password')->name('change_password');
                Route::post('/change_password', 'UserController@update_change_password')->name('change_password');

            });



            Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {
                Route::get('/all_roles', 'RoleController@index')->name('all_roles');
                Route::get('/add_role', 'RoleController@create')->name('add_role');
                Route::post('/add_role', 'RoleController@store')->name('add_role');
                Route::get('/edit_role/{id}', 'RoleController@edit')->name('edit_role');
                Route::post('/edit_role/{id}', 'RoleController@update')->name('edit_role');
                Route::get('/delete_role/{id}', 'RoleController@destroy')->name('delete_role');
            });




            Route::group(['prefix' => '/suppliers', 'as' => 'suppliers.'], function () {

                Route::get('/add_supplier', 'SupplierController@create')->name('add_supplier');
                Route::post('/add_supplier', 'SupplierController@store')->name('add_supplier');
                Route::get('/all_suppliers', 'SupplierController@index')->name('all_suppliers');
                Route::get('/edit_supplier/{id}', 'SupplierController@edit')->name('edit_supplier');
                Route::post('/edit_supplier/{id}', 'SupplierController@update')->name('edit_supplier');
                Route::get('/view_supplier/{id}', 'SupplierController@show')->name('view_supplier');
                Route::get('/delete_supplier/{id}', 'SupplierController@destroy')->name('delete_supplier');
            });


    });
});

Route::group(['namespace' => 'App\Http\Controllers'],  function () {
    Route::get('/', 'FrontPageController@index')->name('index');
    Route::get('product_details/{title?}/{id?}', 'FrontPageController@product_details')->name('product_details');
    Route::post('product_details/{title?}/{id?}', 'FrontPageController@addCart')->name('product_details');
    Route::get('/{title}/product_categories', 'FrontPageController@product_categories')->name('product_categories');
    Route::post('get_price', 'FrontPageController@getPrice')->name('get_price');

    Route::group(['prefix' => '/track_orders', 'as' => 'track_orders.'], function () {
        Route::get('/', 'FrontPageController@track_orders')->name('index');
        Route::get('/view/{id}', 'FrontPageController@vieworder')->name('view');
        Route::get('/', 'FrontPageController@track_orders')->name('index');
        Route::get('/order_invoice_pdf/{order_no?}', 'FrontPageController@orderInvoicePdf')->name('order_invoice_pdf');

    });

    Route::group(['prefix' => '/cart', 'as' => 'cart.'], function () {
        Route::get('/', 'FrontPageController@cart')->name('index');
        Route::get('edit/{title?}/{id}/{job_id}', 'FrontPageController@edit_cart')->name('edit');
        Route::post('edit/{title}/{id}/{job_id}', 'FrontPageController@update_cart')->name('edit');
        Route::post('/', 'FrontPageController@checkout')->name('checkout');
    });

    Route::group(['prefix' => '/contact', 'as' => 'contact.'], function () {
        Route::get('/', 'FrontPageController@contact')->name('index');
        Route::post('/', 'FrontPageController@postContact')->name('post');
    });
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});




