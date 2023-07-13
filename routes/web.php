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


Route::group(['middleware' => ['auth']], function() {
    Route::get('/load-con-nocontract', 'App\Http\Controllers\DashbourdController@load_track_conclude')->name('load-con-nocontract');
    Route::get('/load-credit-report', 'App\Http\Controllers\DashbourdController@cust_credit')->name('load-credit-report');
    Route::get('/load-credit-report-bydate', 'App\Http\Controllers\DashbourdController@cust_credit_bydate')->name('load-credit-report-bydate');
    Route::get('/load-credit-report-bydate_cat', 'App\Http\Controllers\DashbourdController@cust_credit_bydate_category')->name('load-credit-report-bydate_cat');
    Route::get('/con-no-contract-customer', 'App\Http\Controllers\DashbourdController@con_noContract_customer')->name('con-no-contract-customer');
    Route::get('/cus-credit-dashboard', 'App\Http\Controllers\DashbourdController@report_cust_credit')->name('cus-credit-dashboard');
    //
    Route::get('/dashboard', 'App\Http\Controllers\DashbourdController@index')->name('dashboard');
    Route::get('/', 'App\Http\Controllers\DashbourdController@index');
    Route::get('/jq-load-employee', 'App\Http\Controllers\AjaxController@load_emp_jq')->name('jq-load-employee');
    Route::get('/test', 'App\Http\Controllers\MarketingReportController@test')->name('test');

    // route for session
    Route::get('/session-set-seller-report-movement', 'App\Http\Controllers\SessionController@set_report_movement_month_year')->name('session-set-seller-report-movement');

    Route::get('/session-set-seller-report-nocon', 'App\Http\Controllers\SessionController@set_report_nocon_month_year')->name('session-set-seller-report-nocon');

    Route::get('/session-set-seller-report-purchased', 'App\Http\Controllers\SessionController@set_report_purchased_month_year')->name('session-set-seller-report-purchased');
    Route::get('/set_creditreport', 'App\Http\Controllers\SessionController@set_startdate_enddate_creditreport')->name('set_creditreport');
    Route::get('/chose-base', 'App\Http\Controllers\SessionController@set_choose_base')->name('chose-base');

    Route::get('/session-set-marketing-report', 'App\Http\Controllers\SessionController@set_marketing_report_month_year')
    ->name('session-set-marketing-report');
    Route::get('/session-set-start-end-date', 'App\Http\Controllers\SessionController@set_startdate_enddate_report')
    ->name('session-set-start-end-date');
    Route::get('/session-set-search-track', 'App\Http\Controllers\SessionController@set_search_track_month_year')
    ->name('session-set-search-track');
    Route::get('/search-product-from-sml', 'App\Http\Controllers\ApiController@search_product_from_sml')
    ->name('search-product-from-sml');
    Route::get('/load-no-contract-report', 'App\Http\Controllers\MarketingReportController@load_no_contract_report')
    ->name('load-no-contract-report');

    Route::post('/seller-search-bill-sale', 'App\Http\Controllers\ApiController@seller_check_bill_sale_from_sml')
    ->name('seller-search-bill-sale');

    Route::get('/set-startdate-creditreport(', 'App\Http\Controllers\SessionController@set_startdate_enddate_creditreport')
    ->name('set-startdate-creditreport');
// });
 //route for marketing
// Route::group(['middleware' => ['auth', 'role:marketing']], function() {
    ///marketing reports
    Route::get('/report-effective-contract', 'App\Http\Controllers\MarketingReportController@report_effective_contract')->name('report-effective-contract');
    Route::get('/report-emp-con-bydate', 'App\Http\Controllers\MarketingReportController@report_emp_contract_bydate')->name('report-emp-con-bydate');
    Route::get('/load-emp-con-bydate', 'App\Http\Controllers\MarketingReportController@load_emp_con_bydate')
    ->name('load-emp-con-bydate');
    Route::get('/load-effective-bymonth', 'App\Http\Controllers\MarketingReportController@load_track_effective')
    ->name('load-effective-bymonth');

    Route::get('/report-marketing-track-all', 'App\Http\Controllers\MarketingReportController@load_track_all')
    ->name('report-marketing-track-all');

    Route::get('/report-marketing-track-amass', 'App\Http\Controllers\MarketingReportController@load_track_amass')
    ->name('report-marketing-track-amass');
    Route::get('/report-marketing-track-conclude', 'App\Http\Controllers\MarketingReportController@load_track_conclude')->name('report-marketing-track-conclude');
    Route::get('/report-marketing-compare-track', 'App\Http\Controllers\MarketingReportController@load_track_compare')->name('report-marketing-compare-track');
    Route::get('/report-marketing-compare-buy', 'App\Http\Controllers\MarketingReportController@load_buy_compare')->name('report-marketing-compare-buy');
    Route::get('/report-marketing-compare-nobuy', 'App\Http\Controllers\MarketingReportController@load_nobuy_compare')->name('report-marketing-compare-nobuy');
    Route::get('/report-marketing-compare-wait', 'App\Http\Controllers\MarketingReportController@load_wait_compare')->name('report-marketing-compare-wait');
    Route::get('/report-marketing-compare-nocontract', 'App\Http\Controllers\MarketingReportController@load_nocontract_compare')->name('report-marketing-compare-nocontract');
// });
//route for admin
// Route::group(['middleware' => ['auth', 'role:superadministrator']], function() {
    Route::get('/index', 'App\Http\Controllers\DashbourdController@test');

    //
    Route::get('fetch-emp-fb-odien', 'App\Http\Controllers\ApiController@fetch_emp_fb_odien')->name('fetch-emp-fb-odien');
    Route::get('fetch-emp-fb-pp', 'App\Http\Controllers\ApiController@fetch_emp_fb_pp')->name('fetch-emp-fb-pp');
    Route::get('fetch-group-fb-odien', 'App\Http\Controllers\ApiController@fetch_group_fb_odien')->name('fetch-group-fb-odien');
    Route::get('fetch-group-fb-pp', 'App\Http\Controllers\ApiController@fetch_group_fb_pp')->name('fetch-group-fb-pp');
    Route::get('fetch-cate-fb-odien', 'App\Http\Controllers\ApiController@fetch_cate_fb_odien')->name('fetch-cate-fb-odien');
    Route::get('fetch-cate-fb-pp', 'App\Http\Controllers\ApiController@fetch_cate_fb_pp')->name('fetch-cate-fb-pp');
    Route::get('fetch-brand-fb-odien', 'App\Http\Controllers\ApiController@fetch_brand_fb_odien')->name('fetch-brand-fb-odien');
    Route::get('fetch-brand-fb-pp', 'App\Http\Controllers\ApiController@fetch_brand_fb_pp')->name('fetch-brand-fb-pp');
    Route::get('fetch-warehouse-from-odien', 'App\Http\Controllers\ApiController@fetch_warehouse_from_odien')->name('fetch-warehouse-from-odien');

    /////admin Page Route
    Route::get('/report-track-movment-adminpage', 'App\Http\Controllers\AdminpageReportController@report_track_movement')->name('report-track-movment-adminpage');
    Route::get('/report-seller-nocontrack-adminpage', 'App\Http\Controllers\AdminpageReportController@report_seller_nocontrack')->name('report-seller-nocontrack-adminpage');
    Route::get('/report-cus-purchased-adminpage', 'App\Http\Controllers\AdminpageReportController@report_cus_purchased')->name('report-cus-purchased-adminpage');


    ///adminpage reports
    Route::get('/report-track-movment-admin', 'App\Http\Controllers\AdminpageReportController@report_track_movement')->name('report-track-movment-admin');
    Route::get('/report-seller-nocontrack-admin', 'App\Http\Controllers\AdminpageReportController@report_seller_nocontrack')->name('report-seller-nocontrack-admin');
    Route::get('/report-cus-purchased-admin', 'App\Http\Controllers\AdminpageReportController@report_cus_purchased')->name('report-cus-purchased-admin');
// });

//route for admin page and admin sell
// Route::group(['middleware' => ['auth', 'role:adminsell']], function() {
    ///adminpage reports
    Route::get('/report-track-movment-adminsell', 'App\Http\Controllers\AdminpageReportController@report_track_movement')->name('report-track-movment-adminsell');
    Route::get('/report-seller-nocontrack-adminsell', 'App\Http\Controllers\AdminpageReportController@report_seller_nocontrack')->name('report-seller-nocontrack-adminsell');
    Route::get('/report-cus-purchased-adminsell', 'App\Http\Controllers\AdminpageReportController@report_cus_purchased')->name('report-cus-purchased-adminsell');

// });
//route for admin page
// Route::group(['middleware' => ['auth', 'role:adminpage']], function() {
//     ///adminpage reports
//     Route::get('/report-track-movment-adminpage', 'App\Http\Controllers\AdminpageReportController@report_track_movement')->name('report-track-movment-adminpage');
//     Route::get('/report-seller-nocontrack-adminpage', 'App\Http\Controllers\AdminpageReportController@report_seller_nocontrack')->name('report-seller-nocontrack-adminpage');
//     Route::get('/report-cus-purchased-adminpage', 'App\Http\Controllers\AdminpageReportController@report_cus_purchased')->name('report-cus-purchased-adminpage');
// });
//route for seller
// Route::group(['middleware' => ['auth', 'role:seller']], function() {
    Route::resource('track-online', 'App\Http\Controllers\TrackOnlineController');
    Route::get('/admin-load-product-category', 'App\Http\Controllers\TrackOnlineController@load_product_category')->name('admin-load-product-category');
    Route::get('/set-date-search-tract', 'App\Http\Controllers\TrackOnlineController@set_date_search_tract')->name('set-date-search-tract');
    //
    Route::get('/seller-track-show', 'App\Http\Controllers\TrackOnlineController@load_seller_tract')->name('seller-track-show');
    Route::post('/sell-load-product-category', 'App\Http\Controllers\TrackOnlineController@load_product_category')->name('sell-load-product-category');
    Route::post('/customer-decides', 'App\Http\Controllers\TrackOnlineController@customer_decides')->name('customer-decides');
    Route::get('/contract-customer', 'App\Http\Controllers\TrackOnlineController@contract_customer')->name('contract-customer');

    Route::post('/save-contract-customer', 'App\Http\Controllers\TrackOnlineController@save_contract_customer')->name('save-contract-customer');
    Route::post('/save-customer-cancel', 'App\Http\Controllers\TrackOnlineController@save_customer_cancel')->name('save-customer-cancel');
    Route::post('/save-customer-waiting-decide', 'App\Http\Controllers\TrackOnlineController@save_customer_waiting_decide')->name('save-customer-waiting-decide');
    Route::get('/call-check-back', 'App\Http\Controllers\TrackOnlineController@call_check_customer')->name('call-check-back');
    Route::get('/customer-purchase', 'App\Http\Controllers\TrackOnlineController@customer_purchase')->name('customer-purchase');
    Route::post('/save-customer-purchased', 'App\Http\Controllers\TrackOnlineController@save_customer_purchased')->name('save-customer-purchased');

    ///seller reports
    Route::get('/report-track-movment', 'App\Http\Controllers\SellerReportController@report_track_movement')->name('report-track-movment');
    Route::get('/report-seller-nocontrack', 'App\Http\Controllers\SellerReportController@report_seller_nocontrack')->name('report-seller-nocontrack');
    Route::get('/report-cus-purchased', 'App\Http\Controllers\SellerReportController@report_cus_purchased')->name('report-cus-purchased');
    Route::get('/seller-search-track-by-customer', 'App\Http\Controllers\SellerReportController@search_track_bycustomer')
    ->name('seller-search-track-by-customer');
    Route::post('/load-credit-cus', 'App\Http\Controllers\SellerReportController@load_list_cus')->name('load-credit-cus');
    Route::get('/load-credit-cus-all', 'App\Http\Controllers\SellerReportController@load_list_cus_all')->name('load-credit-cus-all');
    Route::get('/Approve-confirm', 'App\Http\Controllers\SellerReportController@Approve_confirm')->name('Approve-confirm');
    Route::get('/load-list-noapprove', 'App\Http\Controllers\SellerReportController@load_list_noapprove')->name('load-list-noapprove');
    Route::post('/credit_no_approve', 'App\Http\Controllers\SellerReportController@credit_no_approve')->name('credit_no_approve');


});
require __DIR__.'/auth.php';
