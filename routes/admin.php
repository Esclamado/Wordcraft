<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/update', 'UpdateController@step0')->name('update');
Route::get('/update/step1', 'UpdateController@step1')->name('update.step1');
Route::get('/update/step2', 'UpdateController@step2')->name('update.step2');

Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin']], function(){
	//Update Routes

	Route::resource('categories','CategoryController');
	Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
	Route::get('/categories/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');
	Route::post('/categories/featured', 'CategoryController@updateFeatured')->name('categories.featured');

	Route::resource('/coupon-categories', 'CouponCategoryController');
	Route::get('/coupon-categories/destroy/{id}', 'CouponCategoryController@destroy')->name('coupon-categories.destroy');
	Route::post('/coupon-categories/update_status', 'CouponCategoryController@update_status')->name('coupon-categories.update_status');

	Route::resource('brands','BrandController');
	Route::get('/brands/edit/{id}', 'BrandController@edit')->name('brands.edit');
	Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('brands.destroy');

	Route::get('/products/admin','ProductController@admin_products')->name('products.admin');
	Route::get('/products/seller','ProductController@seller_products')->name('products.seller');
	Route::get('/products/all','ProductController@all_products')->name('products.all');
	Route::get('/products/create','ProductController@create')->name('products.create');
	Route::get('/products/admin/{id}/edit','ProductController@admin_product_edit')->name('products.admin.edit');
	Route::get('/products/seller/{id}/edit','ProductController@seller_product_edit')->name('products.seller.edit');
	Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');
	Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
	Route::post('/products/advance_order', 'ProductController@updateAdvanceOrder')->name('products.advance_order');
	Route::post('/products/get_products_by_subcategory', 'ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');

	Route::resource('sellers','SellerController');
	Route::get('sellers_ban/{id}','SellerController@ban')->name('sellers.ban');
	Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');
	Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');
	Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');
	Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');
	Route::get('/sellers/login/{id}', 'SellerController@login')->name('sellers.login');
	Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');
	Route::get('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');
	Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');

	Route::resource('customers','CustomerController');
	Route::get('/customers/{id}/show', 'UserController@customer_user_show')->name('customer_user_show');

	Route::get('customers_ban/{customer}','CustomerController@ban')->name('customers.ban');
	Route::get('/customers/login/{id}', 'CustomerController@login')->name('customers.login');
	Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');

	Route::get('/resellers/lists', 'UserController@resellers_list')->name('resellers_list.index');
	Route::get('/resellers/{id}/show', 'UserController@reseller_user_show')->name('reseller_user_show');

	Route::get('/resellers/{id}/verify', 'ResellerController@verify_reseller')->name('reseller_verify');

	Route::get('/employees/lists', 'UserController@employee_list')->name('employees_list.index');
	Route::get('/employees/{id}/show', 'UserController@employee_user_show')->name('employee_user_show');

	Route::get('/newsletter', 'NewsletterController@index')->name('newsletters.index');
	Route::post('/newsletter/send', 'NewsletterController@send')->name('newsletters.send');
	Route::post('/newsletter/test/smtp', 'NewsletterController@testEmail')->name('test.smtp');

	Route::resource('profile','ProfileController');

	Route::post('/business-settings/update', 'BusinessSettingsController@update')->name('business_settings.update');
	Route::post('/business-settings/update/activation', 'BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');
	Route::get('/general-setting', 'BusinessSettingsController@general_setting')->name('general_setting.index');
	Route::get('/activation', 'BusinessSettingsController@activation')->name('activation.index');

	Route::get('/payment-method', 'PaymentMethodListController@index')->name('payment_method.index');
	Route::get('/payment-methods/create', 'PaymentMethodListController@create')->name('payment_methods.create');
	Route::post('/payment-methods/create/store', 'PaymentMethodListController@store')->name('payment_methods.store');
	Route::post('/payment-methods/update_status', 'PaymentMethodListController@update_status')->name('payment_methods.update_status');

	Route::resource('/payment-channels', 'PaymentChannelController');
	Route::post('/payment-channels/update_status', 'PaymentChannelController@update_status')->name('payment_channels.update_status');

	Route::get('/file_system', 'BusinessSettingsController@file_system')->name('file_system.index');
	Route::get('/social-login', 'BusinessSettingsController@social_login')->name('social_login.index');
	Route::get('/smtp-settings', 'BusinessSettingsController@smtp_settings')->name('smtp_settings.index');
	Route::get('/google-analytics', 'BusinessSettingsController@google_analytics')->name('google_analytics.index');
	Route::get('/google-recaptcha', 'BusinessSettingsController@google_recaptcha')->name('google_recaptcha.index');
	Route::get('/facebook-chat', 'BusinessSettingsController@facebook_chat')->name('facebook_chat.index');
	Route::post('/env_key_update', 'BusinessSettingsController@env_key_update')->name('env_key_update.update');
	Route::post('/payment_method_update', 'BusinessSettingsController@payment_method_update')->name('payment_method.update');
	Route::post('/google_analytics', 'BusinessSettingsController@google_analytics_update')->name('google_analytics.update');
	Route::post('/google_recaptcha', 'BusinessSettingsController@google_recaptcha_update')->name('google_recaptcha.update');
	Route::post('/facebook_chat', 'BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');
	Route::post('/facebook_pixel', 'BusinessSettingsController@facebook_pixel_update')->name('facebook_pixel.update');
	Route::get('/currency', 'CurrencyController@currency')->name('currency.index');
    Route::post('/currency/update', 'CurrencyController@updateCurrency')->name('currency.update');
    Route::post('/your-currency/update', 'CurrencyController@updateYourCurrency')->name('your_currency.update');
	Route::get('/currency/create', 'CurrencyController@create')->name('currency.create');
	Route::post('/currency/store', 'CurrencyController@store')->name('currency.store');
	Route::post('/currency/currency_edit', 'CurrencyController@edit')->name('currency.edit');
	Route::post('/currency/update_status', 'CurrencyController@update_status')->name('currency.update_status');
	Route::get('/verification/form', 'BusinessSettingsController@seller_verification_form')->name('seller_verification_form.index');
	Route::post('/verification/form', 'BusinessSettingsController@seller_verification_form_update')->name('seller_verification_form.update');
	Route::get('/vendor_commission', 'BusinessSettingsController@vendor_commission')->name('business_settings.vendor_commission');
	Route::post('/vendor_commission_update', 'BusinessSettingsController@vendor_commission_update')->name('business_settings.vendor_commission.update');

	Route::resource('/languages', 'LanguageController');
	Route::post('/languages/{id}/update', 'LanguageController@update')->name('languages.update');
	Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
	Route::post('/languages/update_rtl_status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status');
	Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');

	// website setting
	Route::group(['prefix' => 'website'], function(){
		Route::view('/header', 'backend.website_settings.header')->name('website.header');
		Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
		Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
		Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
		Route::resource('custom-pages', 'PageController');
		Route::get('/custom-pages/edit/{id}', 'PageController@edit')->name('custom-pages.edit');
		Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');
	});

	Route::resource('roles','RoleController');
	Route::get('/roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');

    Route::resource('staffs','StaffController');
    Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');
	Route::get('/staffs/ban/{id}', 'StaffController@ban_employee')->name('staffs.ban');

	Route::resource('flash_deals','FlashDealController');
	Route::get('/flash_deals/edit/{id}', 'FlashDealController@edit')->name('flash_deals.edit');
  	Route::get('/flash_deals/destroy/{id}', 'FlashDealController@destroy')->name('flash_deals.destroy');
	Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');
	Route::post('/flash_deals/update_featured', 'FlashDealController@update_featured')->name('flash_deals.update_featured');
	Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');
	Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');

	//Subscribers
	Route::get('/subscribers', 'SubscriberController@index')->name('subscribers.index');
	Route::get('/subscribers/destroy/{id}', 'SubscriberController@destroy')->name('subscriber.destroy');

	// Route::get('/orders', 'OrderController@admin_orders')->name('orders.index.admin');
	// Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show');
	// Route::get('/sales/{id}/show', 'OrderController@sales_show')->name('sales.show');
	// Route::get('/sales', 'OrderController@sales')->name('sales.index');

	// All Orders
	Route::get('/all_orders', 'OrderController@all_orders')->name('all_orders.index');
	Route::get('/all_orders/{id}/show', 'OrderController@all_orders_show')->name('all_orders.show');
	Route::post('/all_orders/upload_cr_number', 'OrderController@cr_number')->name('cr_number.upload');

	Route::post('/all_orders/upload_cmg', 'OrderController@upload_cmg')->name('cmg.upload');

	Route::post('/all_orders/partial_release/{id}', 'OrderController@update_partial_release')->name('order.partial_release');

	// Inhouse Orders
	Route::get('/inhouse-orders', 'OrderController@admin_orders')->name('inhouse_orders.index');
	Route::get('/inhouse-orders/{id}/show', 'OrderController@show')->name('inhouse_orders.show');

	// Seller Orders
	Route::get('/seller_orders', 'OrderController@seller_orders')->name('seller_orders.index');
	Route::get('/seller_orders/{id}/show', 'OrderController@seller_orders_show')->name('seller_orders.show');

	Route::get('/declined-orders', 'OrderDeclinedController@index')->name('declined_orders_admin.index');
	Route::get('/declined-orders/{id}/show', 'OrderDeclinedController@show')->name('declined_orders_admin.show');

	// Pickup point orders
	Route::get('orders_by_pickup_point','OrderController@pickup_point_order_index')->name('pick_up_point.order_index');
	Route::get('/orders_by_pickup_point/{id}/show', 'OrderController@pickup_point_order_sales_show')->name('pick_up_point.order_show');

	Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
	Route::get('invoice/admin/{order_id}', 'InvoiceController@admin_invoice_download')->name('admin.invoice.download');

	Route::post('/pay_to_seller', 'CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

	//Reports
	Route::get('/all-users', 'ReportController@all_users')->name('all_users.index');
	Route::get('/stock_report', 'ReportController@stock_report')->name('stock_report.index');
	Route::get('/in_house_sale_report', 'ReportController@in_house_sale_report')->name('in_house_sale_report.index');
	Route::get('/seller_sale_report', 'ReportController@seller_sale_report')->name('seller_sale_report.index');
	Route::get('/wish_report', 'ReportController@wish_report')->name('wish_report.index');
	Route::get('/user_search_report', 'ReportController@user_search_report')->name('user_search_report.index');
	Route::get('/worldcraft/stocks', 'ReportController@worldcraft_stocks')->name('worldcraft_stocks.index');
	Route::get('/worldcraft/stocks-syncing', 'ReportController@worldcraft_syncing_report')->name('worldcraft_stocks_syncing.index');
	Route::get('/orders-report', 'ReportController@orders_report')->name('orders_report.index');
	Route::get('/products-report', 'ReportController@products_report')->name('products_report.index');
	Route::get('/revenue-report', 'ReportController@revenue_report')->name('revenue_report.index');
	Route::get('/variation-report', 'ReportController@variation_report')->name('variation_report.index');
	Route::get('/categories-report', 'ReportController@category_report')->name('category_report.index');
	Route::get('/coupon-report', 'ReportController@coupon_report')->name('coupon_report.index');
	Route::get('/tax-report', 'ReportController@tax_report')->name('tax_report.index');
	Route::get('/stock-report', 'ReportController@stocks_report')->name('stocks_report.index');
	Route::get('/download-report', 'ReportController@download_report')->name('download_report.index');
	Route::get('/overview-report', 'ReportController@overview_report')->name('overview_report.index');
	Route::get('/island-report', 'ReportController@island_report')->name('island_report.index');

	//Coupons
	Route::resource('coupon','CouponController');
	Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
	Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
	Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');
	Route::post('/coupon/bundle_products', 'CouponController@bundle_product')->name('coupon.bundle_product');
	Route::post('/coupon/bundle_products_edit', 'CouponController@bundle_product_edit')->name('coupon.bundle_product_edit');

	Route::post('/coupon/bundle_categories', 'CouponController@bundle_category')->name('coupon.bundle_category');
	Route::post('/coupon/bundle_categories_edit', 'CouponController@bundle_category_edit')->name('coupon.bundle_category_edit');

	//Reviews
	Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
	Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');

	//Support_Ticket
	Route::get('support_ticket/','SupportTicketController@admin_index')->name('support_ticket.admin_index');
	Route::get('support_ticket/{id}/show','SupportTicketController@admin_show')->name('support_ticket.admin_show');
	Route::post('support_ticket/reply','SupportTicketController@admin_store')->name('support_ticket.admin_store');

	//Pickup_Points
	Route::resource('pick_up_points','PickupPointController');
	Route::get('/pick_up_points/edit/{id}', 'PickupPointController@edit')->name('pick_up_points.edit');
	Route::get('/pick_up_points/destroy/{id}', 'PickupPointController@destroy')->name('pick_up_points.destroy');

	//conversation of seller customer
	Route::get('conversations','ConversationController@admin_index')->name('conversations.admin_index');
	Route::get('conversations/{id}/show','ConversationController@admin_show')->name('conversations.admin_show');

    Route::post('/sellers/profile_modal', 'SellerController@profile_modal')->name('sellers.profile_modal');
    Route::post('/sellers/approved', 'SellerController@updateApproved')->name('sellers.approved');

	Route::resource('attributes','AttributeController');
	Route::get('/attributes/edit/{id}', 'AttributeController@edit')->name('attributes.edit');
	Route::get('/attributes/destroy/{id}', 'AttributeController@destroy')->name('attributes.destroy');

	// Route::resource('addons','AddonController');
	// Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');

	Route::get('/customer-bulk-upload/index', 'CustomerBulkUploadController@index')->name('customer_bulk_upload.index');
	Route::post('/bulk-user-upload', 'CustomerBulkUploadController@user_bulk_upload')->name('bulk_user_upload');
	Route::post('/bulk-customer-upload', 'CustomerBulkUploadController@customer_bulk_file')->name('bulk_customer_upload');
	Route::get('/user', 'CustomerBulkUploadController@pdf_download_user')->name('pdf.download_user');
	//Customer Package

	Route::resource('customer_packages','CustomerPackageController');
	Route::get('/customer_packages/edit/{id}', 'CustomerPackageController@edit')->name('customer_packages.edit');
	Route::get('/customer_packages/destroy/{id}', 'CustomerPackageController@destroy')->name('customer_packages.destroy');

	//Classified Products
	Route::get('/classified_products', 'CustomerProductController@customer_product_index')->name('classified_products');
	Route::post('/classified_products/published', 'CustomerProductController@updatePublished')->name('classified_products.published');

	//Shipping Configuration
	Route::get('/shipping_configuration', 'BusinessSettingsController@shipping_configuration')->name('shipping_configuration.index');
	Route::post('/shipping_configuration/update', 'BusinessSettingsController@shipping_configuration_update')->name('shipping_configuration.update');

	// Route::resource('pages', 'PageController');
	// Route::get('/pages/destroy/{id}', 'PageController@destroy')->name('pages.destroy');

	Route::resource('countries','CountryController');
	Route::post('/countries/status', 'CountryController@updateStatus')->name('countries.status');

	Route::resource('cities', 'CityController');
	Route::get('/cities/edit/{id}', 'CityController@edit')->name('cities.edit');
	Route::get('/cities/destroy/{id}', 'CityController@destroy')->name('cities.destroy');

	Route::view('/system/update', 'backend.system.update')->name('system_update');
	Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

	// uploaded files
	Route::any('/uploaded-files/file-info', 'AizUploadController@file_info')->name('uploaded-files.info');
	Route::resource('/uploaded-files', 'AizUploadController');
	Route::get('/uploaded-files/destroy/{id}', 'AizUploadController@destroy')->name('uploaded-files.destroy');

	// Other payment options
	Route::resource('/other-payment-methods', 'OtherPaymentMethodController');
	Route::get('/other-payment-methods/destroy/{id}', 'OtherPaymentMethodController@destroy')->name('other_payment_methods.destroy');
	Route::post('/other-payment-methods/update_status', 'OtherPaymentMethodController@update_status')->name('other-payment-methods.update_status');
	Route::post('/other-payment-methods/update_follow_up_instruction_status', 'OtherPaymentMethodController@update_follow_up_instruction_status')->name('other-payment-methods.update_follow_up_instruction_status');
	Route::get('/other-payment-method/bank-lists', 'OtherPaymentMethodController@other_payment_method_bank_details')->name('bank_lists.index');
	Route::get('/other-payment-method/bank-create', 'OtherPaymentMethodController@other_payment_method_bank_details_create')->name('bank_lists.create');
	Route::post('/other-payment-method/bank-store', 'OtherPaymentMethodController@other_payment_method_bank_details_store')->name('bank_lists.store');
	Route::get('/other-payment-method/bank-edit/{id}', 'OtherPaymentMethodController@other_payment_method_bank_details_edit')->name('bank_lists.edit');
	Route::put('/other-payment-method/bank-edit/{id}/update', 'OtherPaymentMethodController@other_payment_method_bank_details_update')->name('bank_lists.update');
	Route::get('/other-payment-method/bank-destroy/{id}', 'OtherPaymentMethodController@other_payment_method_bank_details_delete')->name('bank_lists.destroy');
	Route::post('/other-payment-method/bank/update_status', 'OtherPaymentMethodController@update_bank_status')->name('bank_lists.update_bank_status');

	Route::resource('/store-locations', 'StoreLocationController');
	Route::post('/store-locations/update-status', 'StoreLocationController@update_status')->name('store-locations.update_status');
	Route::get('/store-locations/destroy/{id}', 'StoreLocationController@destroy')->name('store-locations.delete');

	Route::get('/contact-us/messages', 'ContactUsController@index')->name('contact_us.index');
	Route::post('/contact-us/messages/mark-as-answered', 'ContactUsController@mark_as_answered')->name('contact_us.mark_as_answered');

	Route::get('/contact-us/messages/{id}/show', 'ContactUsController@show')->name('contact_us.show');

	Route::post('/order_note/store', 'OrderNoteController@store')->name('order_note.store');

	Route::post('proof-of-payment/store', 'OrderPaymentController@store_admin')->name('proof-of-payment.store.admin');

	Route::get('/user/login/{id}', 'UserController@login')->name('user.login.admin');
	Route::get('/user/login/{id}/verification', 'UserController@verification')->name('user.login.verification');
	Route::post('/user/login/verify', 'UserController@verify')->name('user.login.verify');

	Route::get('/employees-bulk-upload', 'EmployeeBulkUploadController@index')->name('employees_bulk_upload');
	Route::post('/employees-bulk-upload/post', 'EmployeeBulkUploadController@bulk_upload')->name('employees_bulk_upload.post');

	Route::get('/download/revenue-table', 'ReportController@pdf_download_revenue_report')->name('pdf.download_revenue');
	Route::get('/download/worldcraft-stocks-report', 'ReportController@worldcraft_report')->name('pdf.download_worldcraft_report');
});
