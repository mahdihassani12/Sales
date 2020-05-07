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
Auth::routes();
Route::group(['middleware' => 'auth'], function() {
	Route::get('/admincheck', function () {
		
		if(Auth::user()->is_deleted==1 || Auth::user()->is_active==0){
	        auth()->logout();
	        return redirect('/login')->with('delete_message', 'Your ID is no longer available');
	    }
	    else{
	    	return redirect('/dashboard');
		}
	});
	
	Route::get('/salesmancheck', function () {
		
		if(Auth::user()->is_deleted==1 || Auth::user()->is_active==0){
	        auth()->logout();
	        return redirect('/login')->with('delete_message', 'Your ID is no longer available');
	    }
	    else{
	    	return redirect('/');
		}
	});
});

Route::group(['middleware' => ['auth', 'active']], function() {
        Route::get('test', 'HomeController@importProduct');
	
	
	Route::get('dashboard/', 'HomeController@showAllStore');
	//Route::get('dashboard/', 'HomeController@index');
	//Route::get('dashboard/store/{id}', 'HomeController@showAllStore');

	Route::get('nindex/', 'HomeController@index1');
	Route::get('/dashboard-filter/{start_date}/{end_date}', 'HomeController@dashboardFilter');

	Route::get('language_switch/{locale}', 'LanguageController@switchLanguage');

	Route::get('role/permission/{id}', 'RoleController@permission')->name('role.permission');
	Route::post('role/set_permission', 'RoleController@setPermission')->name('role.setPermission');
	Route::resource('role', 'RoleController');

	Route::post('category/import', 'CategoryController@import')->name('category.import');
	Route::resource('category', 'CategoryController');
	Route::get('category.sub_category', 'CategoryController@subCategory');

	Route::get('brand/ezpos_brand_search', 'BrandController@ezposBrandSearch')->name('brand.search');
	Route::resource('brand', 'BrandController');

	Route::resource('supplier', 'SupplierController');

	Route::resource('store', 'StoreController');
	Route::resource('store_category', 'StoreCategoryController');
    Route::post('store/create','StoreController@store')->name('store.newstore');
		
	Route::resource('tax', 'TaxController');
	//box activity routes
    Route::get('box_activity/accounting_tree','BoxactivityController@AccountingTree');
    Route::post('box_activity/create_box','BoxactivityController@CreateBox');
	
	// Route::get('products/createQuick','ProductController@createQuick');
	// Route::post('products/quickstore','ProductController@storeQuick');
        Route::get('products/quick_add_product','ProductController@quickAddProduct')->name('quick_add_product');
        Route::get('product/save_excel_data','ProductController@saveExcelData');
        Route::match(['get', 'post'], 'products/change_product_image', 'ImageController@ajaxImage');

        Route::post('products/quickaddimages','ProductController@quickAddImages');
        Route::post('products/quickaddimagesUpdate','ProductController@updateProductImages');

	Route::post('products/updateproduct','ProductController@updateQuick');
	Route::get('products/searchPro/{id}','ProductController@selectProducts');
	Route::get('products/searchProduct/{id}','ProductController@searchSpecificProducts');
	Route::post('products/add_image_gallery','ProductController@add_image_gallery');
	Route::get('getProductImages/{id}','ProductController@get_product_images');
	Route::get('products/delete_image/{id}','ProductController@delete_image');
	Route::get('variation','ProductController@variationsList');
	Route::post('variations/create_variation','ProductController@createVariation');
	Route::get('variations/delete_variation/{id}','ProductController@deleteVariation');
	Route::get('variation/edit/{id}','ProductController@editVariation');
	Route::post('variations/update_variation','ProductController@updateVariation');
	Route::get('getProductVariations/{id}','ProductController@showProductVariation');

	Route::get('products/gencode', 'ProductController@generateCode');
	Route::get('products/view/{id}', 'ProductController@product_view');
	Route::get('products/saleunit/{id}', 'ProductController@saleUnit');
	Route::post('products/demo', 'ProductController@demo');
	Route::get('products/product_store/{id}', 'ProductController@productstoreData');
	Route::post('importproduct', 'ProductController@importProduct')->name('product.import');
	Route::post('exportproduct', 'ProductController@exportProduct')->name('product.export');
	Route::get('products/print_barcode','ProductController@printBarcode')->name('product.printBarcode');
	Route::get('products/ezpos_product_search', 'ProductController@ezposProductSearch')->name('product.search');
	Route::get('prices', 'ProductController@prices');
	Route::get('products/changes_product_category/{category}/{product}', 'ProductController@changeProductCategory');
	
	Route::resource('products', 'ProductController');
	Route::get('order/product_qty', 'ProductController@productQty');
  

	//Route::get('offers','ProductController@offers');
	Route::get('offers/all_item','SaleController@all_item');
	Route::get('offers/promotion_item','SaleController@promotionItem');
	Route::get('offers/category_item/{id}','SaleController@item_percategory');
	Route::get('offers/search_product/{id}','SaleController@offer_search');
	Route::get('offers/add_to_cart/{id}/{qty}','ProductController@add_to_cart');

	Route::get('request/change_paid_amount/{amount}/{req_id}','RequestController@changePaidAmount');
	Route::get('requests','RequestController@index');
        Route::get('requests/rejected','RequestController@rejectedRequests');
	Route::get('request_details/{id}','RequestController@request_details');
	Route::get('request/change_status/{id}/{from_status}/{to_status}','RequestController@change_status');
        Route::get('request/change_rejected_status/{id}/{from_status}/{to_status}','RequestController@change_rejected_status');
	Route::get('changeRejectedOredersStatus/{ids}/{tostatus}','RequestController@chageRejectedOrders');
	Route::get('request/process_status/{id}','RequestController@process_status');
	Route::post('request/change_status_to_process/','RequestController@change_status_to_process')->name('request.change_status_to_process');
	Route::get('show_orders/{status}','RequestController@showOrders');
	Route::get('show_orders/{status}/{user_id}','RequestController@showOrders');
    Route::get('changeOredersStatus/{ids}/{from_status}/{to_status}/{paid_amount}','RequestController@changeOredersStatus')->name('request.change_status_to_process');
    Route::get('selec_request/{id}','RequestController@selec_request');
    Route::get('request/delete_current_request/{id}','RequestController@deleteOnlineRequest');
    Route::get('online_order/print/{id}','RequestController@PrintOnlineOrder');

	Route::get('invoice/details/{id}','ProductController@get_all_invoice');
	
	Route::get('offers', 'SaleController@offers');
	Route::post('sale/storeoffer', 'SaleController@storeoffers');
    Route::get('sale/allproduct/{cat_id}/{brand}', 'SaleController@allproduct');
    Route::get('setting/zero_balance/{id}', 'SettingController@zero_balance');
    Route::post('setting/offerpage', 'SettingController@offersPageSetting');
    Route::post('customer/add_customer', 'CustomerController@add_customer');
	
	
	Route::get('offers1', 'SaleController@new_offers');
	Route::post('sale/storemyoffer', 'SaleController@storemyoffer');
	Route::get('sales/is_print/{id}', 'SaleController@makePrinted');
	
	Route::resource('customer_group', 'CustomerGroupController');

	Route::get('customer/getDeposit/{id}', 'CustomerController@getDeposit');
	Route::post('customer/add_deposit', 'CustomerController@addDeposit')->name('customer.addDeposit');
	Route::post('customer/update_deposit', 'CustomerController@updateDeposit')->name('customer.updateDeposit');
	Route::post('customer/deleteDeposit', 'CustomerController@deleteDeposit')->name('customer.deleteDeposit');
	Route::resource('customer', 'CustomerController');
    
    Route::get('company/create','CompanyController@createCompany'); 
    Route::get('company/store','CompanyController@add_company'); 
    Route::get('company/all','CompanyController@all_company'); 
    Route::delete('company/delete/{id}','CompanyController@delete_company'); 
    Route::get('company/edit/{id}','CompanyController@edit_company'); 
    Route::post('company/update','CompanyController@update_company'); 
    
	//cobuns routes
	Route::get('cobuns/cobun_list','CobunsController@index'); 
	Route::get('cobuns/create_cobon','CobunsController@create'); 
	Route::delete('cobun/delete/{id}','CobunsController@delete'); 
	Route::get('cobun/edit/{id}','CobunsController@edit'); 
	Route::get('cobuns/update_cobon','CobunsController@update'); 
        Route::get('coupon/check_auto_cobun_no/{no}','CobunsController@checkGeneratedCoupon'); 
	//Route::get('cobun/check_cobun/{id}','CobunsController@checkCobun'); 
	
	
	Route::get('country/create','CountryController@createCountry'); 
	Route::get('country/store','CountryController@add_country'); 
    Route::get('country/all','CountryController@all_country'); 
    Route::delete('country/delete/{id}','CountryController@delete_country'); 
    Route::get('country/edit/{id}','CountryController@edit_country'); 
    Route::post('country/update','CountryController@update_country'); 
    
	
	Route::post('pincode/create','PincodeController@createPincode')->name('pincode.create');
	Route::post('pincode/update','PincodeController@updatePincode')->name('pincode.update');
	Route::get('pincode/list','PincodeController@PincodeList');
	Route::get('pincode/delete/{id}','PincodeController@deletePincode');
	Route::get('pincode/edit/{id}','PincodeController@edit');
	Route::get('pincode/change_status','PincodeController@changePinStatus');

	Route::get('sale/product_sale/{id}','SaleController@productSaleData');
	Route::get('pos', 'SaleController@posSale')->name('sale.pos');
	Route::get('sale/ezpos_sale_search', 'SaleController@ezposSaleSearch')->name('sale.search');
	Route::get('sale/ezpos_product_search', 'SaleController@ezposProductSearch')->name('product_sale.search');
	Route::get('sale/getcustomergroup/{id}', 'SaleController@getCustomerGroup')->name('sale.getcustomergroup');
	Route::get('sale/getproduct/{id}', 'SaleController@getProduct')->name('sale.getproduct');
	Route::get('sale/getproduct/{category_id}/{brand_id}', 'SaleController@getProductByFilter');
	Route::get('sale/get_gift_card', 'SaleController@getGiftCard');
	Route::get('sale/paypalSuccess', 'SaleController@paypalSuccess');
	Route::get('sale/paypalPaymentSuccess/{id}', 'SaleController@paypalPaymentSuccess');
	Route::get('sale/gen_invoice/{id}', 'SaleController@genInvoice')->name('sale.invoice');
	Route::post('sale/add_payment', 'SaleController@addPayment')->name('sale.add-payment');
	Route::get('sale/getpayment/{id}', 'SaleController@getPayment')->name('sale.get-payment');
	Route::post('sale/updatepayment', 'SaleController@updatePayment')->name('sale.update-payment');
	Route::post('sale/deletepayment', 'SaleController@deletePayment')->name('sale.delete-payment');
	Route::get('sale/{id}/create', 'SaleController@createSale');
    Route::get('sale/items_sales','SaleController@soldItems');
	Route::get('sale/group_items','SaleController@soldItemsGroup');
    Route::get('sale/marketer_orders','RequestController@MarketerOrders');
    Route::get('sale/marketer_orders/edit/{id}','RequestController@editMarketerRequest');
    Route::get('sale/marketer_orders/getproduct','RequestController@getProduct');
    Route::get('sale/marketer_orders/ezpos_product_search','RequestController@ezposProductSearch');
    Route::post('marketer_order/update/{id}','RequestController@updateMarketerRequest');
    Route::delete('marketer_order/destroy/{id}','RequestController@deleteMarketerRequest');
        
	Route::get('order/order_archive','RequestController@OrderArchive');
	Route::get('stores/not_sales','RequestController@notSalesStore');
	Route::get('change_adjustment_checked/{id}','RequestController@OrderChangeStatsu');
	Route::get('order_archive/detail','RequestController@OrderArchiveDetails');
	
	Route::resource('sale', 'SaleController');
	Route::resource('branch', 'BranchController');
	Route::post('branch/update', 'BranchController@update');
        

	Route::get('delivery', 'DeliveryController@index')->name('delivery.index');
	Route::get('delivery/create/{id}', 'DeliveryController@create');
	Route::post('delivery/store', 'DeliveryController@store')->name('delivery.store');
	Route::get('delivery/{id}/edit', 'DeliveryController@edit');
	Route::post('delivery/update', 'DeliveryController@update')->name('delivery.update');
	Route::post('delivery/delete/{id}', 'DeliveryController@delete')->name('delivery.delete');

	Route::get('purchase/product_purchase/{id}','PurchaseController@productPurchaseData');
	Route::get('purchase/ezpos_product_search', 'PurchaseController@ezposProductSearch')->name('product_purchase.search');
	Route::post('purchase/add_payment', 'PurchaseController@addPayment')->name('purchase.add-payment');
	Route::get('purchase/getpayment/{id}', 'PurchaseController@getPayment')->name('purchase.get-payment');
	Route::post('purchase/updatepayment', 'PurchaseController@updatePayment')->name('purchase.update-payment');
	Route::post('purchase/deletepayment', 'PurchaseController@deletePayment')->name('purchase.delete-payment');
	Route::resource('purchase', 'PurchaseController');

	Route::get('transfers/product_transfer/{id}','TransferController@productTransferData');
	Route::get('transfers/getproduct/{id}', 'TransferController@getProduct')->name('transfer.getproduct');
	Route::get('transfers/ezpos_product_search', 'TransferController@ezposProductSearch')->name('product_transfer.search');
	Route::resource('transfers', 'TransferController');

	Route::get('qty_adjustment/getproduct/{id}', 'AdjustmentController@getProduct')->name('adjustment.getproduct');
	Route::get('qty_adjustment/ezpos_product_search', 'AdjustmentController@ezposProductSearch')->name('product_adjustment.search');
	Route::get('qty_adjustment/store_out', 'AdjustmentController@out_store')->name('qty_adjustment.out_store');
	Route::get('adjustment/view/{id}/{type}/{status}', 'AdjustmentController@adjustmentInvoice');
	Route::resource('qty_adjustment', 'AdjustmentController');
	Route::get('qty_adjustment/re_insert/{id}', 'AdjustmentController@re_insert');
	Route::post('qty_adjustment/re_insert_data', 'AdjustmentController@insertNew')->name('qty_adjustment.insertNew');

	Route::get('return/getcustomergroup/{id}', 'ReturnController@getCustomerGroup')->name('return.getcustomergroup');
	Route::get('return/getproduct/{id}', 'ReturnController@getProduct')->name('return.getproduct');
	Route::get('return/ezpos_product_search', 'ReturnController@ezposProductSearch')->name('product_return.search');
	Route::get('return/product_return/{id}','ReturnController@productReturnData');
	Route::resource('return', 'ReturnController');

	Route::get('report/movements', 'ReportController@movementReport')->name('report.movement');
	Route::get('report/product_quantity_alert', 'ReportController@productQuantityAlert')->name('report.qtyAlert');
	Route::get('report/store_stock', 'ReportController@storeStock')->name('report.storeStock');
	Route::post('report/store_stock', 'ReportController@storeStockById')->name('report.storeStock');
	Route::get('report/daily_sale/{year}/{month}', 'ReportController@dailySale');
	Route::post('report/daily_sale/{year}/{month}', 'ReportController@dailySaleByStore')->name('report.dailySaleByStore');
	Route::get('report/monthly_sale/{year}', 'ReportController@monthlySale');
	Route::post('report/monthly_sale/{year}', 'ReportController@monthlySaleByStore')->name('report.monthlySaleByStore');
	Route::get('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchase');
	Route::post('report/daily_purchase/{year}/{month}', 'ReportController@dailyPurchaseByStore')->name('report.dailyPurchaseByStore');
	Route::get('report/monthly_purchase/{year}', 'ReportController@monthlyPurchase');
	Route::post('report/monthly_purchase/{year}', 'ReportController@monthlyPurchaseByStore')->name('report.monthlyPurchaseByStore');
	Route::get('report/best_seller', 'ReportController@bestSeller');
	Route::post('report/best_seller', 'ReportController@bestSellerByStore')->name('report.bestSellerByStore');
	Route::post('report/profit_loss', 'ReportController@profitLoss')->name('report.profitLoss');
	Route::post('report/product_report', 'ReportController@productReport')->name('report.product');
	Route::post('report/purchase', 'ReportController@purchaseReport')->name('report.purchase');
	Route::post('report/sale_report', 'ReportController@saleReport')->name('report.sale');
	Route::post('report/payment_report_by_date', 'ReportController@paymentReportByDate')->name('report.paymentByDate');
	Route::post('report/customer_report', 'ReportController@customerReport')->name('report.customer');
	Route::post('report/supplier', 'ReportController@supplierReport')->name('report.supplier');
	Route::post('report/due_report_by_date', 'ReportController@dueReportByDate')->name('report.dueByDate');
	Route::get('report/store_qty', 'ReportController@store_qty');
	Route::get('report/store_item/{id}', 'ReportController@store_item');
	Route::get('store_qty/export/{id}', 'ReportController@ExportItemsQTY');

	Route::get('user/profile/{id}', 'UserController@profile')->name('user.profile');
	Route::put('user/update_profile/{id}', 'UserController@profileUpdate')->name('user.profileUpdate');
	Route::put('user/changepass/{id}', 'UserController@changePassword')->name('user.password');
	Route::get('user/genpass', 'UserController@generatePassword');
	Route::resource('user','UserController');

	Route::get('setting/general_setting', 'SettingController@generalSetting')->name('setting.general');
	Route::post('setting/changeDefaultColor', 'SettingController@changeDefaultColor');
	Route::post('setting/general_setting_store', 'SettingController@generalSettingStore')->name('setting.generalStore');
	Route::get('setting/mail_setting', 'SettingController@mailSetting')->name('setting.mail');
	Route::post('setting/mail_setting_store', 'SettingController@mailSettingStore')->name('setting.mailStore');
	Route::get('setting/pos_setting', 'SettingController@posSetting')->name('setting.pos');
	Route::post('setting/pos_setting_store', 'SettingController@posSettingStore')->name('setting.posStore');
        Route::get('setting/siteSetting', 'SettingController@siteSetting')->name('setting.siteSetting');
	Route::post('setting/updateSiteSetting', 'SettingController@updateSiteSetting')->name('setting.updateSiteSetting');

	Route::get('expense_categories/gencode', 'ExpenseCategoryController@generateCode');
	Route::post('expense_categories/import', 'ExpenseCategoryController@import')->name('expense_category.import');
	Route::resource('expense_categories', 'ExpenseCategoryController');

	Route::resource('expenses', 'ExpenseController');

	Route::get('gift_cards/gencode', 'GiftCardController@generateCode');
	Route::post('gift_cards/recharge/{id}', 'GiftCardController@recharge')->name('gift_cards.recharge');
	Route::resource('gift_cards', 'GiftCardController');

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('search/products/{word}', 'HomeController@search_product');
	Route::get('select/specific_products/{id}', 'HomeController@selectProduct');
	
	Route::get('dashboard/orders/{id}', 'HomeController@OrderList');
	Route::get('dashboard/store_movement/{id}', 'HomeController@ProductMovementList');
       Route::get('order/detail', 'HomeController@OrderDetails');
       Route::get('orders/change_status', 'HomeController@changerOrderStatus');

Route::get('/', 'FrontedController@select_store');
Route::get('fronted/changes_user_default_store/{store_id}/{user_id}', 'FrontedController@changeDefaultStore');
Route::get('web', 'FrontedController@index');
//Route::get('web/{id}', 'FrontedController@index');

Route::get('fronted/load_more', 'FrontedController@load_more');
Route::get('fronted/load_more_cat_item', 'FrontedController@load_more_cat_item');
Route::get('fronted/selectProduct/{id}', 'FrontedController@selectProduct');
Route::get('fronted/product/{id}', 'FrontedController@productDetail');
Route::get('fronted/selectCategory/{id}', 'FrontedController@selectCategory');
Route::get('fronted/searchProduct/{word}', 'FrontedController@searchProduct');
Route::get('cart', 'FrontedController@cart');
Route::get('cart/{id}', 'FrontedController@cart');
Route::get('fronted/check_coupon/{cpn}', 'FrontedController@checkCouponNumber');
Route::get('fronted/calculate_coupon/{cp}','FrontedController@calculateCoupon'); 
Route::post('fronted/change_user_store','FrontedController@changeUserStore'); 

Route::get('add_to_cart/{id}/{coupon}/{currency}', 'FrontedController@add_to_cart');
Route::get('add_to_cart_search/{id}/{coupon}/{currency}', 'FrontedController@add_to_cart_search');
Route::get('cart_items', 'FrontedController@cart_items');
Route::get('cart_items/{id}', 'FrontedController@cart_items');
Route::get('removeItem/{id}', 'FrontedController@remove_item');
Route::get('increaseItem/{id}', 'FrontedController@increaseItem');
Route::get('decreaseItem/{id}', 'FrontedController@decreaseItem');
Route::post('sendRequest', 'FrontedController@sendRequest');
Route::get('orders/requestSent', 'FrontedController@requestSent');
Route::get('changeQty/{item_id}/{qty}', 'FrontedController@changeQty');
Route::get('orders/print/{id}/{ref}', 'FrontedController@requestPrint');
Route::get('fronted/changeCartItem', 'FrontedController@changeCartItem');
Route::get('fronted/sortProduct', 'FrontedController@getSortedProdcut');
Route::get('currency/changeCurrency/{currency}', 'FrontedController@changeCurrncy');
	});

Route::get('commands_rout', function() {
    Artisan::call('php artisan make:controller TestController');
    // return what you want
});	

