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

// Auth::routes();
Auth::routes(['register' => false]);
// Route::get('/home', 'HomeController@index')->name('home')->middleware('check.credentials');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('auth.login');
});


Route::resource('sections', 'SectionsController');

Route::resource('products', 'ProductsController');

Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');

Route::resource('Archive', 'InvoiceAchiveController');


############################### Begin invoices route ##################
Route::resource('invoices', 'InvoicesController');
Route::get('/section/{id}', 'InvoicesController@getproducts');
Route::get('/InvoicesDetails/{id}', 'InvoicesDetailesController@edit');
Route::get('/View_file/{invoice_number}/{file_name}', 'InvoicesDetailesController@openfile');
Route::get('/download/{invoice_number}/{file_name}', 'InvoicesDetailesController@download');
Route::get('/View_file/{invoice_number}/{file_name}', 'InvoicesDetailesController@openfile');
Route::post('/delete_file', 'InvoicesDetailesController@delete')->name('delete_file');
Route::get('/editInvoice/{invoice_id}','InvoicesController@edit')->name('edit-invoice');
Route::post('/updateInvoice/{invoice_id}','InvoicesController@update')->name('invoices.update');
Route::get('/deleteInvoice/{invoice_id}','InvoicesController@destroy')->name('delete-invoice');
Route::get('/Status_show/{invoice_id}','InvoicesController@show')->name('Status_show');
Route::post('/updatestatus/{invoice_id}','InvoicesController@statusUpdate')->name('status.update');

Route::get('Invoice_Paid','InvoicesController@Invoice_Paid');
Route::get('Invoice_UnPaid','InvoicesController@Invoice_UnPaid');
Route::get('Invoice_Partial','InvoicesController@Invoice_Partial');
Route::post('/delete_Invoice','InvoicesController@softDelete')->name('invoices.softDelete');
Route::get('Print_invoice/{id}','InvoicesController@Print_invoice');

Route::get('invoices_export', 'InvoicesController@export');


############################### End invoices route ####################


############################### start roles route #####################
Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles','RoleController');

    Route::resource('users','UserController');

    });

############################### End roles route #######################

############################### start report route ####################
Route::get('invoices_report',  'invoices_Report@index');
Route::post('Search_invoices', 'Invoices_Report@Search_invoices');
Route::get('customers_report', 'Customers_ReportController@index');
Route::post('Search_customers', 'Customers_ReportController@Search_customers');

############################### End report route #######################

############################### start notification route ###############

Route::get('MarkAsRead_all','InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');

############################### end notification route #################



Route::get('/{page}', 'AdminController@index');

