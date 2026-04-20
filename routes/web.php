<?php


use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\API\Dyeing_receiveAPIController;
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

Route::get('/', function () {
      
    return view('auth.login');
});

Auth::routes();

// Route::namespace('API')->group(function () {
//     include base_path('routes/api.php');
// });

// Route::get('auth/register', [App\Http\Controllers\Auth::class, 'index'])->name('register.index');

// --------------------------------------------------------------------------------------------
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home_without_dashboard', [App\Http\Controllers\HomeController::class, 'index_without_dashboard'])->name('home_without_dashboard');

Route::get('result_balance', [App\Http\Controllers\HomeController::class, 'result_balance'])->name('result_balance')->middleware('can:result_balance');
Route::post('result_balance_all', [App\Http\Controllers\HomeController::class, 'result_balance_all'])->name('result_balance_all')->middleware('can:result_balance_all');

//-------------------------------------CRM Routes---------------------------------
Route::get('productCategories', ['as'=>'productCategories.index', 'uses'=>'CRM\ProductCategoryController@index'])->middleware('can:productCategories.index');
Route::get('productCategories/create', ['as'=>'productCategories.create', 'uses'=>'CRM\ProductCategoryController@create'])->middleware('can:productCategories.create');
Route::post('productCategories/', ['as'=>'productCategories.store', 'uses'=>'CRM\ProductCategoryController@store'])->middleware('can:productCategories.store');
Route::get('productCategories/{id}', ['as'=>'productCategories.show', 'uses'=>'CRM\ProductCategoryController@show'])->middleware('can:productCategories.show');
Route::get('productCategories/{id}/edit', ['as'=>'productCategories.edit', 'uses'=>'CRM\ProductCategoryController@edit'])->middleware('can:productCategories.edit');
Route::patch('productCategories/{id}', ['as'=>'productCategories.update', 'uses'=>'CRM\ProductCategoryController@update'])->middleware('can:productCategories.update');
Route::delete('productCategories/{id}', ['as'=>'productCategories.destroy', 'uses'=>'CRM\ProductCategoryController@destroy'])->middleware('can:productCategories.destroy');

Route::get('products', ['as'=>'products.index', 'uses'=>'CRM\ProductController@index'])->middleware('can:products');
Route::get('products/create', ['as'=>'products.create', 'uses'=>'CRM\ProductController@create'])->middleware('can:products.create');
Route::post('products/', ['as'=>'products.store', 'uses'=>'CRM\ProductController@store'])->middleware('can:products.store');
Route::get('products/{id}', ['as'=>'products.show', 'uses'=>'CRM\ProductController@show'])->middleware('can:products.show');
Route::get('products/{id}/edit', ['as'=>'products.edit', 'uses'=>'CRM\ProductController@edit'])->middleware('can:products.edit');
Route::patch('products/{id}', ['as'=>'products.update', 'uses'=>'CRM\ProductController@update'])->middleware('can:products.update');
Route::delete('products/{id}', ['as'=>'products.destroy', 'uses'=>'CRM\ProductController@destroy'])->middleware('can:products.destroy');

Route::get('serviceCategories', ['as'=>'serviceCategories.index', 'uses'=>'CRM\ServiceCategoryController@index'])->middleware('can:serviceCategories.index');
Route::get('serviceCategories/create', ['as'=>'serviceCategories.create', 'uses'=>'CRM\ServiceCategoryController@create'])->middleware('can:serviceCategories.create');
Route::post('serviceCategories/', ['as'=>'serviceCategories.store', 'uses'=>'CRM\ServiceCategoryController@store'])->middleware('can:serviceCategories.store');
Route::get('serviceCategories/{id}', ['as'=>'serviceCategories.show', 'uses'=>'CRM\ServiceCategoryController@show'])->middleware('can:serviceCategories.show');
Route::get('serviceCategories/{id}/edit', ['as'=>'serviceCategories.edit', 'uses'=>'CRM\ServiceCategoryController@edit'])->middleware('can:serviceCategories.edit');
Route::patch('serviceCategories/{id}', ['as'=>'serviceCategories.update', 'uses'=>'CRM\ServiceCategoryController@update'])->middleware('can:serviceCategories.update');
Route::delete('serviceCategories/{id}', ['as'=>'serviceCategories.destroy', 'uses'=>'CRM\ServiceCategoryController@destroy'])->middleware('can:serviceCategories.destroy');

Route::get('services', ['as'=>'services.index', 'uses'=>'CRM\ServiceController@index'])->middleware('can:services.index');
Route::get('services/create', ['as'=>'services.create', 'uses'=>'CRM\ServiceController@create'])->middleware('can:services.create');
Route::post('services/', ['as'=>'services.store', 'uses'=>'CRM\ServiceController@store'])->middleware('can:services.store');
Route::get('services/{id}', ['as'=>'services.show', 'uses'=>'CRM\ServiceController@show'])->middleware('can:services.show');
Route::get('services/{id}/edit', ['as'=>'services.edit', 'uses'=>'CRM\ServiceController@edit'])->middleware('can:services.edit');
Route::patch('services/{id}', ['as'=>'services.update', 'uses'=>'CRM\ServiceController@update'])->middleware('can:services.update');
Route::delete('services/{id}', ['as'=>'services.destroy', 'uses'=>'CRM\ServiceController@destroy'])->middleware('can:services.destroy');

Route::get('serviceItems', ['as'=>'serviceItems.index', 'uses'=>'CRM\ServiceItemController@index'])->middleware('can:serviceItems.index');
Route::get('serviceItems/create', ['as'=>'serviceItems.create', 'uses'=>'CRM\ServiceItemController@create'])->middleware('can:serviceItems.create');
Route::post('serviceItems/', ['as'=>'serviceItems.store', 'uses'=>'CRM\ServiceItemController@store'])->middleware('can:serviceItems.store');
Route::get('serviceItems/{id}', ['as'=>'serviceItems.show', 'uses'=>'CRM\ServiceItemController@show'])->middleware('can:serviceItems.show');
Route::get('serviceItems/{id}/edit', ['as'=>'serviceItems.edit', 'uses'=>'CRM\ServiceItemController@edit'])->middleware('can:serviceItems.edit');
Route::patch('serviceItems/{id}', ['as'=>'serviceItems.update', 'uses'=>'CRM\ServiceItemController@update'])->middleware('can:serviceItems.update');
Route::delete('serviceItems/{id}', ['as'=>'serviceItems.destroy', 'uses'=>'CRM\ServiceItemController@destroy'])->middleware('can:serviceItems.destroy');

Route::get('stages', ['as'=>'stages.index', 'uses'=>'CRM\StageController@index'])->middleware('can:stages.index');
Route::get('stages/create', ['as'=>'stages.create', 'uses'=>'CRM\StageController@create'])->middleware('can:stages.create');
Route::post('stages/', ['as'=>'stages.store', 'uses'=>'CRM\StageController@store'])->middleware('can:stages.store');
Route::get('stages/{id}', ['as'=>'stages.show', 'uses'=>'CRM\StageController@show'])->middleware('can:stages.show');
Route::get('stages/{id}/edit', ['as'=>'stages.edit', 'uses'=>'CRM\StageController@edit'])->middleware('can:stages.edit');
Route::patch('stages/{id}', ['as'=>'stages.update', 'uses'=>'CRM\StageController@update'])->middleware('can:stages.update');
Route::delete('stages/{id}', ['as'=>'stages.destroy', 'uses'=>'CRM\StageController@destroy'])->middleware('can:stages.destroy');

//Route::resource('satgeCategories', App\Http\Controllers\CRM\satge_categoryController::class);
Route::get('satgeCategories', ['as'=>'satgeCategories.index', 'uses'=>'CRM\satge_categoryController@index'])->middleware('can:satgeCategories.index');
Route::get('satgeCategories/create', ['as'=>'satgeCategories.create', 'uses'=>'CRM\satge_categoryController@create'])->middleware('can:satgeCategories.create');
Route::post('satgeCategories/', ['as'=>'satgeCategories.store', 'uses'=>'CRM\satge_categoryController@store'])->middleware('can:satgeCategories.store');
Route::get('satgeCategories/{id}', ['as'=>'satgeCategories.show', 'uses'=>'CRM\satge_categoryController@show'])->middleware('can:satgeCategories.show');
Route::get('satgeCategories/{id}/edit', ['as'=>'satgeCategories.edit', 'uses'=>'CRM\satge_categoryController@edit'])->middleware('can:satgeCategories.edit');
Route::patch('satgeCategories/{id}', ['as'=>'satgeCategories.update', 'uses'=>'CRM\satge_categoryController@update'])->middleware('can:satgeCategories.update');
Route::delete('satgeCategories/{id}', ['as'=>'satgeCategories.destroy', 'uses'=>'CRM\satge_categoryController@destroy'])->middleware('can:satgeCategories.destroy');


Route::get('customers', ['as'=>'customers.index', 'uses'=>'CRM\CustomerController@index'])->middleware('can:customers.index');
Route::get('customers/create', ['as'=>'customers.create', 'uses'=>'CRM\CustomerController@create'])->middleware('can:customers.create');
Route::post('customers/', ['as'=>'customers.store', 'uses'=>'CRM\CustomerController@store'])->middleware('can:customers.store');
Route::get('customers/{id}', ['as'=>'customers.show', 'uses'=>'CRM\CustomerController@show'])->middleware('can:customers.show');
Route::get('customers/{id}/edit', ['as'=>'customers.edit', 'uses'=>'CRM\CustomerController@edit'])->middleware('can:customers.edit');
Route::patch('customers/{id}', ['as'=>'customers.update', 'uses'=>'CRM\CustomerController@update'])->middleware('can:customers.update');
Route::delete('customers/{id}', ['as'=>'customers.destroy', 'uses'=>'CRM\CustomerController@destroy'])->middleware('can:customers.destroy');
Route::get('get_receive_receipt/{id}', 'CRM\CustomerController@get_receive_receipt')->name('get_receive_receipt')->middleware('can:get_receive_receipt');
Route::get('get_work_order/{receiveReceipt_id}/{customer_id}', 'CRM\CustomerController@get_work_order')->name('get_work_order')->middleware('can:get_work_order');


Route::get('receiveReceipts', ['as'=>'receiveReceipts.index', 'uses'=>'CRM\ReceiveReceiptController@index'])->middleware('can:receiveReceipts.index');
Route::get('receiveReceipts/create/{id?}', ['as'=>'receiveReceipts.create', 'uses'=>'CRM\ReceiveReceiptController@create'])->middleware('can:receiveReceipts.create');
Route::post('receiveReceipts/', ['as'=>'receiveReceipts.store', 'uses'=>'CRM\ReceiveReceiptController@store'])->middleware('can:receiveReceipts.store');
Route::get('receiveReceipts/{id}', ['as'=>'receiveReceipts.show', 'uses'=>'CRM\ReceiveReceiptController@show'])->middleware('can:receiveReceipts.show');
Route::get('receiveReceipts/{id}/edit', ['as'=>'receiveReceipts.edit', 'uses'=>'CRM\ReceiveReceiptController@edit'])->middleware('can:receiveReceipts.edit');
Route::patch('receiveReceipts/{id}', ['as'=>'receiveReceipts.update', 'uses'=>'CRM\ReceiveReceiptController@update'])->middleware('can:receiveReceipts.update');
Route::delete('receiveReceipts/{id}', ['as'=>'receiveReceipts.destroy', 'uses'=>'CRM\ReceiveReceiptController@destroy'])->middleware('can:receiveReceipts.destroy');


Route::get('returnReceipts', ['as'=>'returnReceipts.index', 'uses'=>'CRM\Return_receiptController@index'])->middleware('can:returnReceipts.index');
Route::get('returnReceipts/create/{id?}', ['as'=>'returnReceipts.create', 'uses'=>'CRM\Return_receiptController@create'])->middleware('can:returnReceipts.create');
Route::post('returnReceipts/', ['as'=>'returnReceipts.store', 'uses'=>'CRM\Return_receiptController@store'])->middleware('can:returnReceipts.store');
Route::get('returnReceipts/{id}', ['as'=>'returnReceipts.show', 'uses'=>'CRM\Return_receiptController@show'])->middleware('can:returnReceipts.show');
Route::get('returnReceipts/{id}/edit', ['as'=>'returnReceipts.edit', 'uses'=>'CRM\Return_receiptController@edit'])->middleware('can:returnReceipts.edit');
Route::patch('returnReceipts/{id}', ['as'=>'returnReceipts.update', 'uses'=>'CRM\Return_receiptController@update'])->middleware('can:returnReceipts.update');
Route::delete('returnReceipts/{id}', ['as'=>'returnReceipts.destroy', 'uses'=>'CRM\Return_receiptController@destroy'])->middleware('can:returnReceipts.destroy');

Route::get('teams', ['as'=>'teams.index', 'uses'=>'CRM\TeamController@index'])->middleware('can:teams.index');
Route::get('teams/create', ['as'=>'teams.create', 'uses'=>'CRM\TeamController@create'])->middleware('can:teams.create');
Route::post('teams/', ['as'=>'teams.store', 'uses'=>'CRM\TeamController@store'])->middleware('can:teams.store');
Route::get('teams/{id}', ['as'=>'teams.show', 'uses'=>'CRM\TeamController@show'])->middleware('can:teams.show');
Route::get('teams/{id}/edit', ['as'=>'teams.edit', 'uses'=>'CRM\TeamController@edit'])->middleware('can:teams.edit');
Route::patch('teams/{id}', ['as'=>'teams.update', 'uses'=>'CRM\TeamController@update'])->middleware('can:teams.update');
Route::delete('teams/{id}', ['as'=>'teams.destroy', 'uses'=>'CRM\TeamController@destroy'])->middleware('can:teams.destroy');


Route::get('workOrders', ['as'=>'workOrders.index', 'uses'=>'CRM\WorkOrderController@index'])->middleware('can:workOrders.index');
Route::get('workOrders/create/{receiveReceipt_id?}/{customer_id?}/{product_id?}', ['as'=>'workOrders.create', 'uses'=>'CRM\WorkOrderController@create'])
->middleware('can:workOrders.create');
Route::post('workOrders/', ['as'=>'workOrders.store', 'uses'=>'CRM\WorkOrderController@store'])->middleware('can:workOrders.store');
Route::get('workOrders/{id}', ['as'=>'workOrders.show', 'uses'=>'CRM\WorkOrderController@show'])->middleware('can:workOrders.show');
Route::get('workOrders/{id}/edit', ['as'=>'workOrders.edit', 'uses'=>'CRM\WorkOrderController@edit'])->middleware('can:workOrders.edit');
Route::patch('workOrders/{id}', ['as'=>'workOrders.update', 'uses'=>'CRM\WorkOrderController@update'])->middleware('can:workOrders.update');
Route::delete('workOrders/{id}', ['as'=>'workOrders.destroy', 'uses'=>'CRM\WorkOrderController@destroy'])->middleware('can:workOrders.destroy');
Route::get('workOrders_print/{id}', 'CRM\WorkOrderController@workOrders_print')->name('workOrders.print')->middleware('can:workOrders.print');
Route::get('workOrders_print_cs/{id}', 'CRM\WorkOrderController@workOrders_print')->name('workOrders.print_cs')->middleware('can:workOrders.print_cs');
Route::get('/oreders_followup','CRM\Floor@oreders_followup')->name('oreders_followup');

Route::get('/get_wo_followup','CRM\Floor@get_wo_followup');


Route::post('/add_activity', 'CRM\WorkOrderController@add_activity')->name('add_activity')->middleware('can:add_activity');
Route::post('/add_not','CRM\WorkOrderController@add_not')->name('add_not')->middleware('can:add_not');
Route::get('/close_work_order/{id}', 'CRM\WorkOrderController@close_work_order')->name('close_work_order')->middleware('can:close_work_order');
Route::get('/open_work_order/{id}', 'CRM\WorkOrderController@open_work_order')->name('open_work_order')->middleware('can:open_work_order');
Route::get('/close_activity/{id}/{owner_stage_id}/{work_order_id}', 'CRM\WorkOrderController@close_activity')->name('close_activity')->middleware('can:close_activity');
Route::get('/delete_activity/{id}/{owner_stage_id}/{work_order_id}', 'CRM\WorkOrderController@delete_activity')->name('delete_activity')->middleware('can:delete_activity');
Route::get('/find_stage_activity','CRM\Floor@find_stage_activity');

// Route::resource('labSamples', App\Http\Controllers\CRM\LabSampleController::class);
Route::get('labSamples', ['as'=>'labSamples.index', 'uses'=>'CRM\LabSampleController@index'])->middleware('can:labSamples.index');
Route::get('return_sample_to_lab/{id}', ['as'=>'return_sample_to_lab', 'uses'=>'CRM\LabSampleController@return_sample_to_lab'])->middleware('can:return_sample_to_lab');    //زرار عودة العنية الى المعمل

Route::get('labSamples_lab_view','CRM\LabSampleController@index2')->name('labSamples_lab_view')->middleware('can:labSamples_lab_view');

Route::get('labReadySample_view','CRM\LabSampleController@index3')->name('labReadySample_view')->middleware('can:labReadySample_view');

Route::get('labSamples/create', ['as'=>'labSamples.create', 'uses'=>'CRM\LabSampleController@create'])->middleware('can:labSamples.create');
Route::post('labSamples/', ['as'=>'labSamples.store', 'uses'=>'CRM\LabSampleController@store'])->middleware('can:labSamples.store');
Route::get('lab_samples_show/{id}', ['as'=>'lab_samples.show', 'uses'=>'CRM\LabSampleController@lab_samples_show'])->middleware('can:lab_samples.show');

Route::get('labSamples/{id}', ['as'=>'labSamples.print', 'uses'=>'CRM\LabSampleController@print'])->middleware('can:labSamples.print');
Route::get('labSamples/{id}/edit', ['as'=>'labSamples.edit', 'uses'=>'CRM\LabSampleController@edit'])->middleware('can:labSamples.edit');
Route::patch('labSamples/{id}', ['as'=>'labSamples.update', 'uses'=>'CRM\LabSampleController@update'])->middleware('can:labSamples.update');
Route::delete('labSamples/{id}', ['as'=>'labSamples.destroy', 'uses'=>'CRM\LabSampleController@destroy'])->middleware('can:labSamples.destroy');

Route::get('lab_view', 'CRM\LabSampleController@lab_view')->name('lab_view')->middleware('can:lab_view');
Route::post('labViewfollow', 'CRM\LabSampleController@labViewfollow')->name('labViewfollow')->middleware('can:labViewfollow');                                // يفتح مرحلة المعمل




//Route::post('labReadySample', 'CRM\LabSampleController@labReadySample')->name('labReadySample')->middleware('can:labReadySample');                           // يفتح تشغيل العينة فى المعمل
Route::post('labReadySample','CRM\LabSampleController@labReadySample');





Route::post('labRecieveCheck', 'CRM\LabSampleController@labRecieveCheck')->name('labRecieveCheck')->middleware('can:labRecieveCheck');                       // المعمل يستلم من خدمة العملاء
Route::post('labCloseSample', 'CRM\LabSampleController@labCloseSample')->name('labCloseSample')->middleware('can:labCloseSample');                          // يفتح مرحلة تسليم العينة
Route::post('labConfirmSample', 'CRM\LabSampleController@labConfirmSample')->name('labConfirmSample')->middleware('can:labConfirmSample');                  // يأكد استلام العينة من خدمة العملاء
Route::get('labReadySampleView', 'CRM\LabSampleController@labReadySampleView')->name('labReadySampleView')->middleware('can:labReadySampleView');           //عينات جاهزة للتسليم
Route::post('labDeliverSample', 'CRM\LabSampleController@labDeliverSample')->name('labDeliverSample')->middleware('can:labDeliverSample');           //تسليم للعميل
Route::get('tab_index', 'CRM\LabSampleController@tab_index')->name('tab_index')->middleware('can:tab_index');                                             // كل العينات
Route::get('tab_all', 'CRM\LabSampleController@tab_all')->name('tab_all')->middleware('can:tab_all');                                                    // فلتر لكل العينات

// Route::resource('createSamples', App\Http\Controllers\CRM\Create_sampleController::class);
Route::get('createSamples', ['as'=>'createSamples.index', 'uses'=>'CRM\Create_sampleController@index'])->middleware('can:createSamples.index');
Route::post('createSamples/create', ['as'=>'createSamples.create', 'uses'=>'CRM\Create_sampleController@create'])->middleware('can:createSamples.create');
Route::post('createSamples/', ['as'=>'createSamples.store', 'uses'=>'CRM\Create_sampleController@store'])->middleware('can:createSamples.store');
Route::get('createSamples/{id}', ['as'=>'createSamples.show', 'uses'=>'CRM\Create_sampleController@show'])->middleware('can:createSamples.show');
Route::get('createSamples/{id}/edit', ['as'=>'createSamples.edit', 'uses'=>'CRM\Create_sampleController@edit'])->middleware('can:createSamples.edit');
Route::patch('createSamples/{id}', ['as'=>'createSamples.update', 'uses'=>'CRM\Create_sampleController@update'])->middleware('can:createSamples.update');
Route::delete('createSamples/{id}', ['as'=>'createSamples.destroy', 'uses'=>'CRM\Create_sampleController@destroy'])->middleware('can:createSamples.destroy');
Route::post('update_sample/{id}', 'CRM\Create_sampleController@update');
Route::post('update_service_item/{id}', 'CRM\Create_sampleController@update_service_item');

Route::get('create_redirect/{sample_id}','CRM\Create_sampleController@create_redirect');

// Route::get('createFashionSamples', ['as'=>'createFashionSamples.index', 'uses'=>'CRM\Create_fashion_sampleController@index'])->middleware('can:createFashionSamples.index');
// Route::post('createFashionSamples/create', ['as'=>'createFashionSamples.create', 'uses'=>'CRM\Create_fashion_sampleController@create'])->middleware('can:createFashionSamples.create');
// Route::post('createFashionSamples/', ['as'=>'createFashionSamples.store', 'uses'=>'CRM\Create_fashion_sampleController@store'])->middleware('can:createFashionSamples.store');
// Route::get('createFashionSamples/{id}', ['as'=>'createFashionSamples.show', 'uses'=>'CRM\Create_fashion_sampleController@show'])->middleware('can:createFashionSamples.show');
// Route::get('createFashionSamples/{id}/edit', ['as'=>'createFashionSamples.edit', 'uses'=>'CRM\Create_fashion_sampleController@edit'])->middleware('can:createFashionSamples.edit');
// Route::patch('createFashionSamples/{id}', ['as'=>'createFashionSamples.update', 'uses'=>'CRM\Create_fashion_sampleController@update'])->middleware('can:createFashionSamples.update');
// Route::delete('createFashionSamples/{id}', ['as'=>'createFashionSamples.destroy', 'uses'=>'CRM\Create_fashion_sampleController@destroy'])->middleware('can:createFashionSamples.destroy');
// Route::post('update_fashion_sample/{id}', 'CRM\Create_fashion_sampleController@update');
// Route::post('update_service_items/{id}', 'CRM\Create_fashion_sampleController@update_service_items');


Route::get('places', ['as'=>'places.index', 'uses'=>'CRM\PlaceController@index'])->middleware('can:places.index');
Route::get('places/create', ['as'=>'places.create', 'uses'=>'CRM\PlaceController@create'])->middleware('can:places.create');
Route::post('places/', ['as'=>'places.store', 'uses'=>'CRM\PlaceController@store'])->middleware('can:places.store');
Route::get('places/{id}', ['as'=>'places.show', 'uses'=>'CRM\PlaceController@show'])->middleware('can:places.show');
Route::get('places/{id}/edit', ['as'=>'places.edit', 'uses'=>'CRM\PlaceController@edit'])->middleware('can:places.edit');
Route::patch('places/{id}', ['as'=>'places.update', 'uses'=>'CRM\PlaceController@update'])->middleware('can:places.update');
Route::delete('places/{id}', ['as'=>'places.destroy', 'uses'=>'CRM\PlaceController@destroy'])->middleware('can:places.destroy');



Route::get('receivables', ['as'=>'receivables.index', 'uses'=>'CRM\ReceivableController@index'])->middleware('can:receivables.index');
Route::get('receivables/create', ['as'=>'receivables.create', 'uses'=>'CRM\ReceivableController@create'])->middleware('can:receivables.create');
Route::post('receivables/', ['as'=>'receivables.store', 'uses'=>'CRM\ReceivableController@store'])->middleware('can:receivables.store');
Route::get('receivables/{id}', ['as'=>'receivables.show', 'uses'=>'CRM\ReceivableController@show'])->middleware('can:receivables.show');
Route::get('receivables/{id}/edit', ['as'=>'receivables.edit', 'uses'=>'CRM\ReceivableController@edit'])->middleware('can:receivables.edit');
Route::patch('receivables/{id}', ['as'=>'receivables.update', 'uses'=>'CRM\ReceivableController@update'])->middleware('can:receivables.update');
Route::delete('receivables/{id}', ['as'=>'receivables.destroy', 'uses'=>'CRM\ReceivableController@destroy'])->middleware('can:receivables.destroy');

//Route::resource('deliverOrders', App\Http\Controllers\CRM\Deliver_orderController::class);
Route::get('deliverOrders', ['as'=>'deliverOrders.index', 'uses'=>'CRM\Deliver_orderController@index'])->middleware('can:deliverOrders.index');
Route::get('deliverOrders/create/{receipt_id?}/{workOrder_id?}/{customer_id?}/{products_id?}/{receive_id?}', ['as'=>'deliverOrders.create', 'uses'=>'CRM\Deliver_orderController@create'])->middleware('can:deliverOrders.create');
Route::post('deliverOrders/', ['as'=>'deliverOrders.store', 'uses'=>'CRM\Deliver_orderController@store'])->middleware('can:deliverOrders.store');
Route::get('deliverOrders/{id}', ['as'=>'deliverOrders.show', 'uses'=>'CRM\Deliver_orderController@show'])->middleware('can:deliverOrders.show');
Route::get('deliverOrders/{id}/edit', ['as'=>'deliverOrders.edit', 'uses'=>'CRM\Deliver_orderController@edit'])->middleware('can:deliverOrders.edit');
Route::patch('deliverOrders/{id}', ['as'=>'deliverOrders.update', 'uses'=>'CRM\Deliver_orderController@update'])->middleware('can:deliverOrders.update');
Route::delete('deliverOrders/{id}', ['as'=>'deliverOrders.destroy', 'uses'=>'CRM\Deliver_orderController@destroy'])->middleware('can:deliverOrders.destroy');
Route::get('print_barcode/{id}', 'CRM\Deliver_orderController@print_barcode')->name('print_barcode')->middleware('can:print_barcode');
Route::get('deliverOrders_finance/{receipt_id?}/{workOrder_id?}/{customer_id?}/{products_id?}/{receive_id?}', ['as'=>'deliverOrders_finance', 'uses'=>'CRM\Deliver_orderController@deliverOrders_finance'])->middleware('can:deliverOrders_finance');
Route::post('update_delivered_package','CRM\Deliver_orderController@update_delivered_package')->name('update_delivered_package')->middleware('can:update_delivered_package');

Route::post('deliverOrders_finance_customers/{id}', ['as'=>'deliverOrders_finance_customers', 'uses'=>'CRM\Deliver_orderController@deliverOrders_finance_customers'])->name('deliverOrders_finance_customers')->middleware('can:deliverOrders_finance_customers');
Route::post('update_delivered_package_all','CRM\Deliver_orderController@update_delivered_package_all')->name('update_delivered_package_all')->middleware('can:update_delivered_package_all');

Route::get('edit_final_deliver/{finalDeliver_id}','CRM\Deliver_orderController@edit_final_deliver')->name('edit_final_deliver')->middleware('can:edit_final_deliver');
Route::post('update_final_deliver_all','CRM\Deliver_orderController@update_final_deliver_all')->name('update_final_deliver_all');
Route::get('show_final_deliver/{finalDeliver_id}','CRM\Deliver_orderController@show_final_deliver')->name('show_final_deliver');
Route::post('delete_final_deliver_all/{finalDeliver_id}','CRM\Deliver_orderController@delete_final_deliver_all')->name('delete_final_deliver_all')->middleware('can:delete_final_deliver_all');
Route::get('final_deliver_orders', 'CRM\Deliver_orderController@final_deliver_orders')->name('final_deliver_orders');

//Route::resource('reservations', App\Http\Controllers\CRM\ReservationController::class);
Route::get('reservations', ['as'=>'reservations.index', 'uses'=>'CRM\ReservationController@index'])->middleware('can:reservations.index');
Route::get('reservations/create', ['as'=>'reservations.create', 'uses'=>'CRM\ReservationController@create'])->middleware('can:reservations.create');
Route::post('reservations/', ['as'=>'reservations.store', 'uses'=>'CRM\ReservationController@store'])->middleware('can:reservations.store');
Route::get('reservations/{id}', ['as'=>'reservations.show', 'uses'=>'CRM\ReservationController@show'])->middleware('can:reservations.show');
Route::get('reservations/{id}/edit', ['as'=>'reservations.edit', 'uses'=>'CRM\ReservationController@edit'])->middleware('can:reservations.edit');
Route::patch('reservations/{id}', ['as'=>'reservations.update', 'uses'=>'CRM\ReservationController@update'])->middleware('can:reservations.update');
Route::delete('reservations/{id}', ['as'=>'reservations.destroy', 'uses'=>'CRM\ReservationController@destroy'])->middleware('can:reservations.destroy');
Route::get('reservation_print/{id}', 'CRM\ReservationController@reservation_print');




Route::get('security_deliver','CRM\SecurityDeliverController@index')->name('security_deliver')->middleware('can:security_deliver');
Route::get('add_security_deliver','CRM\SecurityDeliverController@add_security_deliver')->name('add_security_deliver')->middleware('can:add_security_deliver');
Route::post('add_security_deliver_order','CRM\SecurityDeliverController@add_security_deliver_order')->name('add_security_deliver_order')->middleware('can:add_security_deliver_order');



// ------------------------------------------------------------Start fabricSources ------------------------------------------------------------------------------------------
// Route::resource('fabricSources', App\Http\Controllers\CRM\Fabric_sourceController::class);
Route::get('fabricSources', ['as'=>'fabricSources.index', 'uses'=>'CRM\Fabric_sourceController@index'])->middleware('can:fabricSources.index');
Route::get('fabricSources/create', ['as'=>'fabricSources.create', 'uses'=>'CRM\Fabric_sourceController@create'])->middleware('can:fabricSources.create');
Route::post('fabricSources/', ['as'=>'fabricSources.store', 'uses'=>'CRM\Fabric_sourceController@store'])->middleware('can:fabricSources.store');
Route::get('fabricSources/{id}', ['as'=>'fabricSources.show', 'uses'=>'CRM\Fabric_sourceController@show'])->middleware('can:fabricSources.show');
Route::get('fabricSources/{id}/edit', ['as'=>'fabricSources.edit', 'uses'=>'CRM\Fabric_sourceController@edit'])->middleware('can:fabricSources.edit');
Route::patch('fabricSources/{id}', ['as'=>'fabricSources.update', 'uses'=>'CRM\Fabric_sourceController@update'])->middleware('can:fabricSources.update');
Route::delete('fabricSources/{id}', ['as'=>'fabricSources.destroy', 'uses'=>'CRM\Fabric_sourceController@destroy'])->middleware('can:fabricSources.destroy');
// ------------------------------------------------------------End fabricSources ------------------------------------------------------------------------------------------
// ------------------------------------------------------------Start fabrics ------------------------------------------------------------------------------------------
// Route::resource('fabrics', App\Http\Controllers\CRM\FabricController::class);
Route::get('fabrics', ['as'=>'fabrics.index', 'uses'=>'CRM\FabricController@index'])->middleware('can:fabrics.index');
Route::get('fabrics/create', ['as'=>'fabrics.create', 'uses'=>'CRM\FabricController@create'])->middleware('can:fabrics.create');
Route::post('fabrics/', ['as'=>'fabrics.store', 'uses'=>'CRM\FabricController@store'])->middleware('can:fabrics.store');
Route::get('fabrics/{id}', ['as'=>'fabrics.show', 'uses'=>'CRM\FabricController@show'])->middleware('can:fabrics.show');
Route::get('fabrics/{id}/edit', ['as'=>'fabrics.edit', 'uses'=>'CRM\FabricController@edit'])->middleware('can:fabrics.edit');
Route::patch('fabrics/{id}', ['as'=>'fabrics.update', 'uses'=>'CRM\FabricController@update'])->middleware('can:fabrics.update');
Route::delete('fabrics/{id}', ['as'=>'fabrics.destroy', 'uses'=>'CRM\FabricController@destroy'])->middleware('can:fabrics.destroy');
// ------------------------------------------------------------End fabrics ------------------------------------------------------------------------------------------

//-------------------------------------CRM Routes---------------------------------


Route::get('roles', ['as'=>'roles.index', 'uses'=>'RoleController@index'])->middleware('can:roles.index');
Route::get('roles/create', ['as'=>'roles.create', 'uses'=>'RoleController@create'])->middleware('can:roles.create');
Route::post('roles/', ['as'=>'roles.store', 'uses'=>'RoleController@store'])->middleware('can:roles.store');
Route::get('roles/{id}', ['as'=>'roles.show', 'uses'=>'RoleController@show'])->middleware('can:roles.show');
Route::get('roles/{id}/edit', ['as'=>'roles.edit', 'uses'=>'RoleController@edit'])->middleware('can:roles.edit');
Route::patch('roles/{id}', ['as'=>'roles.update', 'uses'=>'RoleController@update'])->middleware('can:roles.update');
Route::delete('roles/{id}', ['as'=>'roles.destroy', 'uses'=>'RoleController@destroy'])->middleware('can:roles.destroy');

// Route::get('roles', ['as'=>'roles.index', 'uses'=>'RoleController@index']);
// Route::get('roles/create', ['as'=>'roles.create', 'uses'=>'RoleController@create']);
// Route::post('roles/', ['as'=>'roles.store', 'uses'=>'RoleController@store']);
// Route::get('roles/{id}', ['as'=>'roles.show', 'uses'=>'RoleController@show']);
// Route::get('roles/{id}/edit', ['as'=>'roles.edit', 'uses'=>'RoleController@edit']);
// Route::patch('roles/{id}', ['as'=>'roles.update', 'uses'=>'RoleController@update']);
// Route::delete('roles/{id}', ['as'=>'roles.destroy', 'uses'=>'RoleController@destroy']);




// Route::resource('users', App\Http\Controllers\UserController::class);
Route::get('users', ['as'=>'users.index', 'uses'=>'UserController@index'])->middleware('can:users.index');
Route::get('users/create', ['as'=>'users.create', 'uses'=>'UserController@create'])->middleware('can:users.create');
Route::post('users/', ['as'=>'users.store', 'uses'=>'UserController@store'])->middleware('can:users.store');
Route::get('users/{id}', ['as'=>'users.show', 'uses'=>'UserController@show'])->middleware('can:users.show');
Route::get('users/{id}/edit', ['as'=>'users.edit', 'uses'=>'UserController@edit'])->middleware('can:users.edit');
Route::patch('users/{id}', ['as'=>'users.update', 'uses'=>'UserController@update'])->middleware('can:users.update');
Route::delete('users/{id}', ['as'=>'users.destroy', 'uses'=>'UserController@destroy'])->middleware('can:users.destroy');

Route::post('followup_report/','CRM\ReportsController@work_order_report')->name('followup_report')->middleware('can:followup_report');
Route::get('/reports', 'CRM\ReportsController@index')->name('reports')->middleware('can:reports.index');


Route::post('accfollowup_report/','CRM\ReportAccController@work_order_report')->name('accfollowup_report')->middleware('can:accfollowup_report');
Route::get('/accreports', 'CRM\ReportAccController@index')->name('accreports')->middleware('can:accreports.index');


Route::post('readyfollowup_report/','CRM\ReportsController@readyreports_result')->name('readyfollowup_report')->middleware('can:readyfollowup_report');
Route::get('/readyreports', 'CRM\ReportsController@readyreports_view')->name('readyreports')->middleware('can:readyreports.index');

Route::post('reports_stages_result/','CRM\ReportsController@reports_stages_result')->name('reports_stages_result')->middleware('can:reports_stages_result');
Route::get('/reports_stages', 'CRM\ReportsController@reports_stages')->name('reports_stages')->middleware('can:reports_stages');

Route::post('receive_receipt_open_result/','CRM\ReportsController@receive_receipt_open_result')->name('receive_receipt_open_result')->middleware('can:receive_receipt_open_result');
Route::get('/receive_receipt_open', 'CRM\ReportsController@receive_receipt_open')->name('receive_receipt_open')->middleware('can:receive_receipt_open');

Route::post('models_report_result/','CRM\ReportsController@models_report_result')->name('models_report_result')->middleware('can:models_report_result');
Route::get('/models_report', 'CRM\ReportsController@models_report')->name('models_report')->middleware('can:models_report');

Route::post('residual_result/','CRM\ReportsController@residual_result')->name('residual_result')->middleware('can:residual_result');
Route::get('/residual', 'CRM\ReportsController@residual')->name('residual')->middleware('can:residual');

Route::post('dashboard_report_result/','CRM\ReportsController@dashboard_report_result')->name('dashboard_report_result')->middleware('can:dashboard_report_result');
Route::get('/dashboard_report', 'CRM\ReportsController@dashboard_report')->name('dashboard_report')->middleware('can:dashboard_report');

Route::post('activity_logs_result/','CRM\ReportsController@activity_logs_result')->name('activity_logs_result')->middleware('can:activity_logs_result');
Route::get('/activity_logs', 'CRM\ReportsController@activity_logs')->name('activity_logs')->middleware('can:activity_logs');

Route::post('final_delivers_result/','CRM\ReportsController@final_delivers_result')->name('final_delivers_result')->middleware('can:final_delivers_result');
Route::get('/final_delivers_report', 'CRM\ReportsController@final_delivers_report')->name('final_delivers_report')->middleware('can:final_delivers_report');

// Route::resource('suppliers', App\Http\Controllers\inventory\suppliersController::class);
Route::get('suppliers', ['as'=>'suppliers.index', 'uses'=>'CRM\suppliersController@index'])->middleware('can:suppliers.index');
Route::get('suppliers/create', ['as'=>'suppliers.create', 'uses'=>'CRM\suppliersController@create'])->middleware('can:suppliers.create');
Route::post('suppliers/', ['as'=>'suppliers.store', 'uses'=>'CRM\suppliersController@store'])->middleware('can:suppliers.store');
Route::get('suppliers/{id}', ['as'=>'suppliers.show', 'uses'=>'CRM\suppliersController@show'])->middleware('can:suppliers.show');
Route::get('suppliers/{id}/edit', ['as'=>'suppliers.edit', 'uses'=>'CRM\suppliersController@edit'])->middleware('can:suppliers.edit');
Route::patch('suppliers/{id}', ['as'=>'suppliers.update', 'uses'=>'CRM\suppliersController@update'])->middleware('can:suppliers.update');
Route::delete('suppliers/{id}', ['as'=>'suppliers.destroy', 'uses'=>'CRM\suppliersController@destroy'])->middleware('can:suppliers.destroy');


// ========================================Inventory=======================
//Route::resource('invUnits', App\Http\Controllers\inventory\InvUnitController::class);
Route::get('invUnits', ['as'=>'invUnits.index', 'uses'=>'inventory\Inv_unitController@index'])->middleware('can:invUnits.index');
Route::get('invUnits/create', ['as'=>'invUnits.create', 'uses'=>'inventory\Inv_unitController@create'])->middleware('can:invUnits.create');
Route::post('invUnits/', ['as'=>'invUnits.store', 'uses'=>'inventory\Inv_unitController@store'])->middleware('can:invUnits.store');
Route::get('invUnits/{id}', ['as'=>'invUnits.show', 'uses'=>'inventory\Inv_unitController@show'])->middleware('can:invUnits.show');
Route::get('invUnits/{id}/edit', ['as'=>'invUnits.edit', 'uses'=>'inventory\Inv_unitController@edit'])->middleware('can:invUnits.edit');
Route::patch('invUnits/{id}', ['as'=>'invUnits.update', 'uses'=>'inventory\Inv_unitController@update'])->middleware('can:invUnits.update');
Route::delete('invUnits/{id}', ['as'=>'invUnits.destroy', 'uses'=>'inventory\Inv_unitController@destroy'])->middleware('can:invUnits.destroy');

//Route::resource('invCategories', App\Http\Controllers\inventory\InvCategoryController::class);
Route::get('invCategories', ['as'=>'invCategories.index', 'uses'=>'inventory\Inv_categoryController@index'])->middleware('can:invCategories.index');
Route::get('invCategories/create', ['as'=>'invCategories.create', 'uses'=>'inventory\Inv_categoryController@create'])->middleware('can:invCategories.create');
Route::post('invCategories/', ['as'=>'invCategories.store', 'uses'=>'inventory\Inv_categoryController@store'])->middleware('can:invCategories.store');
Route::get('invCategories/{id}', ['as'=>'invCategories.show', 'uses'=>'inventory\Inv_categoryController@show'])->middleware('can:invCategories.show');
Route::get('invCategories/{id}/edit', ['as'=>'invCategories.edit', 'uses'=>'inventory\Inv_categoryController@edit'])->middleware('can:invCategories.edit');
Route::patch('invCategories/{id}', ['as'=>'invCategories.update', 'uses'=>'inventory\Inv_categoryController@update'])->middleware('can:invCategories.update');
Route::delete('invCategories/{id}', ['as'=>'invCategories.destroy', 'uses'=>'inventory\Inv_categoryController@destroy'])->middleware('can:invCategories.destroy');


//Route::resource('invProducts', App\Http\Controllers\inventory\InvProductController::class);
Route::get('invProducts', ['as'=>'invProducts.index', 'uses'=>'inventory\Inv_productController@index'])->middleware('can:invProducts.index');
Route::get('invProducts/create', ['as'=>'invProducts.create', 'uses'=>'inventory\Inv_productController@create'])->middleware('can:invProducts.create');
Route::post('invProducts/', ['as'=>'invProducts.store', 'uses'=>'inventory\Inv_productController@store'])->middleware('can:invProducts.store');
Route::get('invProducts/{id}', ['as'=>'invProducts.show', 'uses'=>'inventory\Inv_productController@show'])->middleware('can:invProducts.show');
Route::get('invProducts/{id}/edit', ['as'=>'invProducts.edit', 'uses'=>'inventory\Inv_productController@edit'])->middleware('can:invProducts.edit');
Route::patch('invProducts/{id}', ['as'=>'invProducts.update', 'uses'=>'inventory\Inv_productController@update'])->middleware('can:invProducts.update');
Route::delete('invProducts/{id}', ['as'=>'invProducts.destroy', 'uses'=>'inventory\Inv_productController@destroy'])->middleware('can:invProducts.destroy');
Route::patch('invProducts_imageupdate/{id}', ['as'=>'invProducts.updateimage', 'uses'=>'inventory\Inv_productController@updateimage']);


//Route::resource('invStores', App\Http\Controllers\inventory\Inv_storeController::class);
Route::get('invStores', ['as'=>'invStores.index', 'uses'=>'inventory\Inv_storeController@index'])->middleware('can:invStores.index');
Route::get('invStores/create', ['as'=>'invStores.create', 'uses'=>'inventory\Inv_storeController@create'])->middleware('can:invStores.create');
Route::post('invStores/', ['as'=>'invStores.store', 'uses'=>'inventory\Inv_storeController@store'])->middleware('can:invStores.store');
Route::get('invStores/{id}', ['as'=>'invStores.show', 'uses'=>'inventory\Inv_storeController@show'])->middleware('can:invStores.show');
Route::get('invStores/{id}/edit', ['as'=>'invStores.edit', 'uses'=>'inventory\Inv_storeController@edit'])->middleware('can:invStores.edit');
Route::patch('invStores/{id}', ['as'=>'invStores.update', 'uses'=>'inventory\Inv_storeController@update'])->middleware('can:invStores.update');
Route::delete('invStores/{id}', ['as'=>'invStores.destroy', 'uses'=>'inventory\Inv_storeController@destroy'])->middleware('can:invStores.destroy');


//Route::resource('invStockIns', App\Http\Controllers\inventory\Inv_StockInController::class);
// Route::get('invStockIns', ['as'=>'invStockIns.index', 'uses'=>'inventory\Inv_stockInController@index'])->middleware('can:invStockIns.index');
// Route::get('invStockIns/create', ['as'=>'invStockIns.create', 'uses'=>'inventory\Inv_stockInController@create'])->middleware('can:invStockIns.create');
// Route::post('invStockIns/', ['as'=>'invStockIns.store', 'uses'=>'inventory\Inv_stockInController@store'])->middleware('can:invStockIns.store');
// Route::get('invStockIns/{id}', ['as'=>'invStockIns.show', 'uses'=>'inventory\Inv_stockInController@show'])->middleware('can:invStockIns.show');
// Route::get('invStockIns/{id}/edit', ['as'=>'invStockIns.edit', 'uses'=>'inventory\Inv_stockInController@edit'])->middleware('can:invStockIns.edit');
// Route::patch('invStockIns/{id}', ['as'=>'invStockIns.update', 'uses'=>'inventory\Inv_stockInController@update'])->middleware('can:invStockIns.update');
// Route::delete('invStockIns/{id}', ['as'=>'invStockIns.destroy', 'uses'=>'inventory\Inv_stockInController@destroy'])->middleware('can:invStockIns.destroy');
// Route::get('invStockIns_print/{id}', 'inventory\Inv_stockInController@invStockIns_print')->name('invStockIns.print')->middleware('can:invStockIns.print');
// Route::get('invStockIns_deleteProductid/{id}', 'inventory\Inv_stockInController@deleteProductid')->name('invStockIns.deleteProductid');
// Route::get('get_stock_details', 'inventory\Inv_stockInController@get_stock_details');
// Route::post('update_product_details', 'inventory\Inv_stockInController@update_product_details');

// --------------------------------ابراهيم2-----------------------------------
// Route::get('invStockReturns', ['as'=>'invStockReturns.index', 'uses'=>'inventory\Inv_stock_returnController@index'])->middleware('can:invStockReturns.index');
// Route::get('invStockReturns/select_import_orders', ['as'=>'invStockReturns.select_import_orders', 'uses'=>'inventory\Inv_stock_returnController@show_import_orders'])->middleware('can:invStockReturns.select_import_orders');
// Route::get('invStockReturns/create/{id?}', 'inventory\Inv_stock_returnController@create')->name('invStockReturns.create')->middleware('can:invStockReturns.create');
// Route::get('/remove_product_stockreturn', 'inventory\Inv_stock_returnController@remove_product_stockreturn');
// -------------------------------------ابراهيم2-----------------------------------------------------

// Route::post('invStockReturns/', ['as'=>'invStockReturns.store', 'uses'=>'inventory\Inv_stock_returnController@store'])->middleware('can:invStockReturns.store');
// Route::get('invStockReturns/{id}', ['as'=>'invStockReturns.show', 'uses'=>'inventory\Inv_stock_returnController@show'])->middleware('can:invStockReturns.show');
// Route::get('invStockReturns/{id}/edit', ['as'=>'invStockReturns.edit', 'uses'=>'inventory\Inv_stock_returnController@edit'])->middleware('can:invStockReturns.edit');
// Route::patch('invStockReturns/{id}', ['as'=>'invStockReturns.update', 'uses'=>'inventory\Inv_stock_returnController@update'])->middleware('can:invStockReturns.update');
// Route::delete('invStockReturns/{id}', ['as'=>'invStockReturns.destroy', 'uses'=>'inventory\Inv_stock_returnController@destroy'])->middleware('can:invStockReturns.destroy');
// Route::get('get_stock_details_return', 'inventory\Inv_stock_returnController@get_stock_details_return');

// Route::resource('invProductdDescriptions', App\Http\Controllers\inventory\Inv_productd_descriptionController::class);
Route::get('invProductdDescriptions', ['as'=>'invProductdDescriptions.index', 'uses'=>'inventory\Inv_productd_descriptionController@index'])->middleware('can:invProductdDescriptions.index');
Route::get('invProductdDescriptions/create/{id?}', ['as'=>'invProductdDescriptions.create', 'uses'=>'inventory\Inv_productd_descriptionController@create'])->middleware('can:invProductdDescriptions.create');
Route::post('invProductdDescriptions/', ['as'=>'invProductdDescriptions.store', 'uses'=>'inventory\Inv_productd_descriptionController@store'])->middleware('can:invProductdDescriptions.store');
Route::get('invProductdDescriptions/{id}', ['as'=>'invProductdDescriptions.show', 'uses'=>'inventory\Inv_productd_descriptionController@show'])->middleware('can:invProductdDescriptions.show');
Route::get('invProductdDescriptions/{id}/edit', ['as'=>'invProductdDescriptions.edit', 'uses'=>'inventory\Inv_productd_descriptionController@edit'])->middleware('can:invProductdDescriptions.edit');
Route::patch('invProductdDescriptions/{id}', ['as'=>'invProductdDescriptions.update', 'uses'=>'inventory\Inv_productd_descriptionController@update'])->middleware('can:invProductdDescriptions.update');
Route::delete('invProductdDescriptions/{id}', ['as'=>'invProductdDescriptions.destroy', 'uses'=>'inventory\Inv_productd_descriptionController@destroy'])->middleware('can:invProductdDescriptions.destroy');

//Route::resource('invStockOuts', App\Http\Controllers\inventory\Inv_stockOutController::class);
// Route::get('invStockOuts', ['as'=>'invStockOuts.index', 'uses'=>'inventory\Inv_stockOutController@index'])->middleware('can:invStockOuts.index');
// Route::get('invStockOuts/create', ['as'=>'invStockOuts.create', 'uses'=>'inventory\Inv_stockOutController@create'])->middleware('can:invStockOuts.create');
// Route::post('invStockOuts/', ['as'=>'invStockOuts.store', 'uses'=>'inventory\Inv_stockOutController@store'])->middleware('can:invStockOuts.store');
// Route::get('invStockOuts/{id}', ['as'=>'invStockOuts.show', 'uses'=>'inventory\Inv_stockOutController@show'])->middleware('can:invStockOuts.show');
// Route::get('invStockOuts/{id}/edit', ['as'=>'invStockOuts.edit', 'uses'=>'inventory\Inv_stockOutController@edit'])->middleware('can:invStockOuts.edit');
// Route::patch('invStockOuts/{id}', ['as'=>'invStockOuts.update', 'uses'=>'inventory\Inv_stockOutController@update'])->middleware('can:invStockOuts.update');
// Route::delete('invStockOuts/{id}', ['as'=>'invStockOuts.destroy', 'uses'=>'inventory\Inv_stockOutController@destroy'])->middleware('can:invStockOuts.destroy');

// Route::get('/get_stock', 'inventory\Inv_stockOutController@get_stock');
// Route::get('/get_product_data', 'inventory\Inv_stockOutController@get_product_data');


//Route::resource('invStockTransfers', App\Http\Controllers\inventory\Inv_StockTransferController::class);
Route::get('invStockTransfers', ['as'=>'invStockTransfers.index', 'uses'=>'inventory\Inv_StockTransferController@index'])->middleware('can:invStockTransfers.index');
Route::get('invStockTransfers/create', ['as'=>'invStockTransfers.create', 'uses'=>'inventory\Inv_StockTransferController@create'])->middleware('can:invStockTransfers.create');
Route::post('invStockTransfers/', ['as'=>'invStockTransfers.store', 'uses'=>'inventory\Inv_StockTransferController@store'])->middleware('can:invStockTransfers.store');
Route::get('invStockTransfers/{id}', ['as'=>'invStockTransfers.show', 'uses'=>'inventory\Inv_StockTransferController@show'])->middleware('can:invStockTransfers.show');
Route::get('invStockTransfers/{id}/edit', ['as'=>'invStockTransfers.edit', 'uses'=>'inventory\Inv_StockTransferController@edit'])->middleware('can:invStockTransfers.edit');
Route::patch('invStockTransfers/{id}', ['as'=>'invStockTransfers.update', 'uses'=>'inventory\Inv_StockTransferController@update'])->middleware('can:invStockTransfers.update');
Route::delete('invStockTransfers/{id}', ['as'=>'invStockTransfers.destroy', 'uses'=>'inventory\Inv_StockTransferController@destroy'])->middleware('can:invStockTransfers.destroy');
Route::get('/find_stockTransfer', 'inventory\Inv_StockTransferController@find_stockTransfer');
Route::get('/get_supplier_stock', 'inventory\Inv_StockTransferController@get_supplier_stock');
Route::get('/get_store_in_data', 'inventory\Inv_StockTransferController@get_store_in_data');
Route::post('/confirm_transfer', 'inventory\Inv_StockTransferController@confirm_transfer')->name('invStockTransfers.confirm_transfer')->middleware('can:invStockTransfers.confirm_transfer');
// ========================================Inventory=======================
//====================================================== Start Inv_reports  ============================================================
// Route::get('product_report', 'inventory\Inv_Reportscontroller@product_report')->name('product_report')->middleware('can:product_report');
// Route::post('product_report_result', 'inventory\Inv_Reportscontroller@product_report_result')->middleware('can:product_report_result');

//====================================================== Start reports   ============================================================
Route::get('product_report', 'ReportsController@product_report')->name('product_report')->middleware('can:report2.product_report');
Route::post('product_report_result', 'ReportsController@product_report_result')->name('product_report_result')->middleware('can:report2.product_report');

Route::get('total_Products_report/','ReportsController@total_Products_report')->name('total_Products_report')->middleware('can:report2.total_Products_report');
Route::post('total_Products_report_result/','ReportsController@total_Products_report_result')->middleware('can:report2.total_Products_report');

Route::get('wash_chemical_report/','ReportsController@wash_chemical_report')->name('wash_chemical_report')->middleware('can:report2.wash_chemical_report');
Route::post('wash_chemical_report_result/','ReportsController@wash_chemical_report_result')->middleware('can:report2.wash_chemical_report');

Route::get('treasuries_report', ['as'=>'treasuries_report', 'uses'=>'Reports_crmController@treasuries_report'])->middleware('can:report1.treasuries_report');
Route::post('treasuries_report_result', ['as'=>'treasuries_report_result', 'uses'=>'Reports_crmController@treasuries_report_result'])->middleware('can:report1.treasuries_report');

Route::get('supplier_account_report', ['as'=>'supplier_account_report', 'uses'=>'Reports_crmController@supplier_account_report'])->middleware('can:report1.supplier_account_report');
Route::post('supplier_account_result', ['as'=>'supplier_account_result', 'uses'=>'Reports_crmController@supplier_account_result'])->middleware('can:report1.supplier_account_report');

Route::get('customer_account_report', ['as'=>'customer_account_report', 'uses'=>'Reports_crmController@customer_account_report'])->middleware('can:report1.customer_account_report');
Route::post('customer_account_result', ['as'=>'customer_account_result', 'uses'=>'Reports_crmController@customer_account_result'])->middleware('can:report1.customer_account_report');
Route::post('customer_statement_result', ['as'=>'customer_statement_result', 'uses'=>'Reports_crmController@customer_statement_result'])->middleware('can:report1.customer_account_report');
Route::get('customer_account_client_payments_result/{id}', ['as'=>'customer_account_client_payments_result', 'uses'=>'Reports_crmController@customer_account_client_payments_result'])->middleware('can:report1.customer_account_report');
Route::post('customer_account_report_detail', ['as'=>'customer_account_report_detail', 'uses'=>'Reports_crmController@customer_account_report_detail'])->middleware('can:report1.customer_account_report');
Route::post('customer_account_report_discount', ['as'=>'customer_account_report_discount', 'uses'=>'Reports_crmController@customer_account_report_discount'])->middleware('can:report1.customer_account_report');

Route::get('invoice_report', ['as'=>'invoice_report', 'uses'=>'Reports_crmController@invoice_report'])->middleware('can:report1.invoice_report');
Route::post('invoice_report_result', ['as'=>'invoice_report_result', 'uses'=>'Reports_crmController@invoice_report_result'])->middleware('can:report1.invoice_report');

Route::get('service_prices_report', ['as'=>'service_prices_report', 'uses'=>'Reports_crmController@service_prices_report'])->middleware('can:report1.service_prices_report');
Route::post('service_prices_report_result', ['as'=>'service_prices_report_result', 'uses'=>'Reports_crmController@service_prices_report_result'])->middleware('can:report1.service_prices_report');

// =======================================Ajax==============================
Route::get('/findunits','inventory\Inv_StockInController@findunits');
Route::get('/get_old_order_stages','CRM\WorkOrderController@get_old_order_stages');
Route::get('/get_sample_stages','CRM\WorkOrderController@get_sample_stages');
Route::get('/find_stock','inventory\Inv_stockOutController@find_stock');
Route::get('/important_workOrders/{id}','CRM\WorkOrderController@important_workOrders')->name('important_workOrders')->middleware('can:important_workOrders');
Route::get('/get_important','CRM\WorkOrderController@get_important');
Route::get('/get_customers_for_model','CRM\ReportsController@get_customers_for_model');
Route::get('/get_customers_for_recepit_id','CRM\ReportsController@get_customers_for_recepit_id');
Route::get('/get_customer_orders','CRM\ReceiveReceiptController@get_customer_orders');

// =======================================Ajax==============================

// ====================================invImportOrders======================================
Route::get('invImportOrders', ['as'=>'invImportOrders.index', 'uses'=>'inventory\Inv_importOrderController@index'])->middleware('can:invImportOrders.index');
Route::get('invImportOrders/create', ['as'=>'invImportOrders.create', 'uses'=>'inventory\Inv_importOrderController@create'])->middleware('can:invImportOrders.create');
Route::post('invImportOrders/', ['as'=>'invImportOrders.store', 'uses'=>'inventory\Inv_importOrderController@store'])->middleware('can:invImportOrders.store');
Route::get('invImportOrders/{id}', ['as'=>'invImportOrders.show', 'uses'=>'inventory\Inv_importOrderController@show'])->middleware('can:invImportOrders.show');

Route::get('invImportOrders/{id}/edit', ['as'=>'invImportOrders.edit', 'uses'=>'inventory\Inv_importOrderController@edit'])->middleware('can:invImportOrders.edit');
Route::patch('invImportOrders/{id}', ['as'=>'invImportOrders.update', 'uses'=>'inventory\Inv_importOrderController@update']);

Route::get('invImportOrders/{id}/edit_product_pricing', ['as'=>'invImportOrders.edit_product_pricing', 'uses'=>'inventory\Inv_importOrderController@edit_product_pricing'])->middleware('can:product_price.edit_final_product_price');
Route::patch('invImportOrders/{id}/update_product_pricing', ['as' => 'invImportOrders.update_product_pricing', 'uses' => 'inventory\Inv_importOrderController@update_product_pricing'])->middleware('can:product_price.edit_final_product_price');


Route::delete('invImportOrders/{id}', ['as'=>'invImportOrders.destroy', 'uses'=>'inventory\Inv_importOrderController@destroy'])->middleware('can:invImportOrders.destroy');
Route::get('/get_imp_products', 'inventory\Inv_importOrderController@get_imp_products'); // 24/3/2024
Route::get('/findunits', 'inventory\Inv_importOrderController@findunits');  // 24/3/2024
Route::post('/insert_into_stores', 'inventory\Inv_importOrderController@insert_into_stores')->name('insert_into_stores')->middleware('can:insert_into_stores');
// =========================================================================================

// Route::resource('invExportOrders', inventory\Inv_exportOrderController::class);
Route::get('invExportOrders', ['as'=>'invExportOrders.index', 'uses'=>'inventory\Inv_exportOrderController@index'])->middleware('can:invExportOrders.index');
Route::get('invExportOrders/create', ['as'=>'invExportOrders.create', 'uses'=>'inventory\Inv_exportOrderController@create'])->middleware('can:invExportOrders.create');
Route::post('invExportOrders/', ['as'=>'invExportOrders.store', 'uses'=>'inventory\Inv_exportOrderController@store'])->middleware('can:invExportOrders.store');
Route::get('invExportOrders/{id}', ['as'=>'invExportOrders.show', 'uses'=>'inventory\Inv_exportOrderController@show'])->middleware('can:invExportOrders.show');
Route::get('invExportOrders/{id}/edit', ['as'=>'invExportOrders.edit', 'uses'=>'inventory\Inv_exportOrderController@edit'])->middleware('can:invExportOrders.edit');
Route::patch('invExportOrders/{id}', ['as'=>'invExportOrders.update', 'uses'=>'inventory\Inv_exportOrderController@update'])->middleware('can:invExportOrders.update');
Route::delete('invExportOrders/{id}', ['as'=>'invExportOrders.destroy', 'uses'=>'inventory\Inv_exportOrderController@destroy'])->middleware('can:invExportOrders.destroy');

Route::get('/find_stock', 'inventory\Inv_exportOrderController@find_stock');
Route::get('/find_supplier_stock', 'inventory\Inv_exportOrderController@find_supplier_stock');

Route::get('/findunits1', 'inventory\Inv_exportOrderController@findunits');

Route::get('/find_supplier', 'inventory\Inv_exportOrderController@find_supplier');

Route::get('/final_product_requset_ids', 'inventory\Inv_exportOrderController@final_product_requset_ids');
Route::get('/final_product_requset', 'inventory\Inv_exportOrderController@final_product_requset');
// =========================================================================================

// Route::resource('colorCategories', App\Http\Controllers\inventory\Color_categoryController::class);
Route::get('colorCategories', ['as'=>'colorCategories.index', 'uses'=>'inventory\Color_categoryController@index'])->middleware('can:colorCategories.index');
Route::get('colorCategories/create', ['as'=>'colorCategories.create', 'uses'=>'inventory\Color_categoryController@create'])->middleware('can:colorCategories.create');
Route::post('colorCategories/', ['as'=>'colorCategories.store', 'uses'=>'inventory\Color_categoryController@store'])->middleware('can:colorCategories.store');
Route::get('colorCategories/{id}', ['as'=>'colorCategories.show', 'uses'=>'inventory\Color_categoryController@show'])->middleware('can:colorCategories.show');
Route::get('colorCategories/{id}/edit', ['as'=>'colorCategories.edit', 'uses'=>'inventory\Color_categoryController@edit'])->middleware('can:colorCategories.edit');
Route::patch('colorCategories/{id}', ['as'=>'colorCategories.update', 'uses'=>'inventory\Color_categoryController@update'])->middleware('can:colorCategories.update');
Route::delete('colorCategories/{id}', ['as'=>'colorCategories.destroy', 'uses'=>'inventory\Color_categoryController@destroy'])->middleware('can:colorCategories.destroy');

// Route::resource('colors', inventory\ColorController::class);
Route::get('colors', ['as'=>'colors.index', 'uses'=>'inventory\ColorController@index'])->middleware('can:colors.index');
Route::get('colors/create', ['as'=>'colors.create', 'uses'=>'inventory\ColorController@create'])->middleware('can:colors.create');
Route::post('colors/', ['as'=>'colors.store', 'uses'=>'inventory\ColorController@store'])->middleware('can:colors.store');
Route::get('colors/{id}', ['as'=>'colors.show', 'uses'=>'inventory\ColorController@show'])->middleware('can:colors.show');
Route::get('colors/{id}/edit', ['as'=>'colors.edit', 'uses'=>'inventory\ColorController@edit'])->middleware('can:colors.edit');
Route::patch('colors/{id}', ['as'=>'colors.update', 'uses'=>'inventory\ColorController@update'])->middleware('can:colors.update');
Route::delete('colors/{id}', ['as'=>'colors.destroy', 'uses'=>'inventory\ColorController@destroy'])->middleware('can:colors.destroy');

// =======================================Start colorCodes=======================

Route::get('colorCodes', ['as'=>'colorCodes.index', 'uses'=>'inventory\Color_codeController@index'])->middleware('can:colorCodes.index');
Route::get('colorCodes/create/{id?}', ['as'=>'colorCodes.create', 'uses'=>'inventory\Color_codeController@create'])->middleware('can:colorCodes.create');
Route::post('colorCodes/', ['as'=>'colorCodes.store', 'uses'=>'inventory\Color_codeController@store'])->middleware('can:colorCodes.store');
Route::get('colorCodes/{id}', ['as'=>'colorCodes.show', 'uses'=>'inventory\Color_codeController@show'])->middleware('can:colorCodes.show');
Route::get('colorCodes/{id}/edit', ['as'=>'colorCodes.edit', 'uses'=>'inventory\Color_codeController@edit'])->middleware('can:colorCodes.edit');
Route::patch('colorCodes/{id}', ['as'=>'colorCodes.update', 'uses'=>'inventory\Color_codeController@update'])->middleware('can:colorCodes.update');
Route::delete('colorCodes/{id}', ['as'=>'colorCodes.destroy', 'uses'=>'inventory\Color_codeController@destroy'])->middleware('can:colorCodes.destroy');
// =======================================End colorCodes=======================

// Route::resource('invImportOrdersReturns', App\Http\Controllers\inventory\invImportOrders_returnsController::class);
Route::get('invImportOrdersReturns', ['as'=>'invImportOrders_Returns.index', 'uses'=>'inventory\invImportOrders_returnsController@index'])->middleware('can:invImportOrders_Returns.index');
Route::get('invImportOrdersReturns/select_import_orders', ['as'=>'invImportOrdersReturns.select_import_orders', 'uses'=>'inventory\invImportOrders_returnsController@show_import_orders'])->middleware('can:invImportOrdersReturns.select_import_orders');
Route::get('invImportOrdersReturns/create/{id?}', ['as'=>'invImportOrdersReturns.create', 'uses'=>'inventory\invImportOrders_returnsController@create'])->middleware('can:invImportOrdersReturns.create');
Route::post('invImportOrdersReturns/', ['as'=>'invImportOrdersReturns.store', 'uses'=>'inventory\invImportOrders_returnsController@store'])->middleware('can:invImportOrdersReturns.store');
Route::get('invImportOrdersReturns/{id}', ['as'=>'invImportOrdersReturns.show', 'uses'=>'inventory\invImportOrders_returnsController@show'])->middleware('can:invImportOrdersReturns.show');
Route::get('invImportOrdersReturns/{id}/edit', ['as'=>'invImportOrdersReturns.edit', 'uses'=>'inventory\invImportOrders_returnsController@edit'])->middleware('can:invImportOrdersReturns.edit');
Route::patch('invImportOrdersReturns/{id}', ['as'=>'invImportOrdersReturns.update', 'uses'=>'inventory\invImportOrders_returnsController@update'])->middleware('can:invImportOrdersReturns.update');
Route::delete('invImportOrdersReturns/{id}', ['as'=>'invImportOrdersReturns.destroy', 'uses'=>'inventory\invImportOrders_returnsController@destroy'])->middleware('can:invImportOrdersReturns.destroy');







// Route::get('/dyeing_receives', [Dyeing_receiveAPIController::class, 'index'])->name('dyeing_receives.index');
// Route::post('/dyeing_receives', [Dyeing_receiveAPIController::class, 'store'])->name('dyeing_receives.store');
// Route::get('/dyeing_receives/{id}', [Dyeing_receiveAPIController::class, 'show'])->name('dyeing_receives.show');
// Route::patch('/dyeing_receives/{id}', [Dyeing_receiveAPIController::class, 'update'])->name('dyeing_receives.update');
// Route::delete('/dyeing_receives/{id}', [Dyeing_receiveAPIController::class, 'destroy'])->name('dyeing_receives.destroy');


// Route::resource('dyeing_receives', API\Dyeing_receiveAPIController::class);

// Route::resource('dyeingReceiveWebs', App\Http\Controllers\CRM\Dyeing_receive_webController::class);
Route::get('dyeingReceiveWebs', ['as'=>'dyeingReceiveWebs.index', 'uses'=>'CRM\Dyeing_receive_webController@index']);
Route::get('dyeingReceiveWebs/create', ['as'=>'dyeingReceiveWebs.create', 'uses'=>'CRM\Dyeing_receive_webController@create']);
Route::post('dyeingReceiveWebs/', ['as'=>'dyeingReceiveWebs.store', 'uses'=>'CRM\Dyeing_receive_webController@store']);
Route::get('dyeingReceiveWebs/{id}', ['as'=>'dyeingReceiveWebs.show', 'uses'=>'CRM\Dyeing_receive_webController@show']);
Route::get('dyeingReceiveWebs/{id}/edit', ['as'=>'dyeingReceiveWebs.edit', 'uses'=>'CRM\Dyeing_receive_webController@edit']);
Route::patch('dyeingReceiveWebs/{id}', ['as'=>'dyeingReceiveWebs.update', 'uses'=>'CRM\Dyeing_receive_webController@update']);
Route::delete('dyeingReceiveWebs/{id}', ['as'=>'dyeingReceiveWebs.destroy', 'uses'=>'CRM\Dyeing_receive_webController@destroy']);

Route::post('update_dyeingReceive/','CRM\Dyeing_receive_webController@update_dyeingReceive')->name('update_dyeingReceive');

// =======================================Start treasuries=======================

Route::get('treasuries', ['as'=>'treasuries.index', 'uses'=>'sales\TreasuryController@index'])->middleware('can:treasuries.index');
Route::get('treasuries/create/{id?}', ['as'=>'treasuries.create', 'uses'=>'sales\TreasuryController@create'])->middleware('can:treasuries.create');
Route::post('treasuries/', ['as'=>'treasuries.store', 'uses'=>'sales\TreasuryController@store'])->middleware('can:treasuries.store');
Route::get('treasuries/{id}', ['as'=>'treasuries.show', 'uses'=>'sales\TreasuryController@show'])->middleware('can:treasuries.show');
Route::get('treasuries/{id}/edit', ['as'=>'treasuries.edit', 'uses'=>'sales\TreasuryController@edit'])->middleware('can:treasuries.edit');
Route::patch('treasuries/{id}', ['as'=>'treasuries.update', 'uses'=>'sales\TreasuryController@update'])->middleware('can:treasuries.update');
Route::delete('treasuries/{id}', ['as'=>'treasuries.destroy', 'uses'=>'sales\TreasuryController@destroy'])->middleware('can:treasuries.destroy');

// =======================================End treasuries=======================
// =======================================Start treasuryDetails=======================

Route::get('treasuryDetails', ['as'=>'treasuryDetails.index', 'uses'=>'sales\Treasury_detailsController@index'])->middleware('can:treasuryDetails.index');
Route::get('treasuryDetails/create/{id?}', ['as'=>'treasuryDetails.create', 'uses'=>'sales\Treasury_detailsController@create'])->middleware('can:treasuryDetails.create');
Route::post('treasuryDetails/', ['as'=>'treasuryDetails.store', 'uses'=>'sales\Treasury_detailsController@store'])->middleware('can:treasuryDetails.store');
Route::get('treasuryDetails/{id}', ['as'=>'treasuryDetails.show', 'uses'=>'sales\Treasury_detailsController@show'])->middleware('can:treasuryDetails.show');
Route::get('treasuryDetails/{id}/edit', ['as'=>'treasuryDetails.edit', 'uses'=>'sales\Treasury_detailsController@edit'])->middleware('can:treasuryDetails.edit');
Route::patch('treasuryDetails/{id}', ['as'=>'treasuryDetails.update', 'uses'=>'sales\Treasury_detailsController@update'])->middleware('can:treasuryDetails.update');
Route::delete('treasuryDetails/{id}', ['as'=>'treasuryDetails.destroy', 'uses'=>'sales\Treasury_detailsController@destroy'])->middleware('can:treasuryDetails.destroy');

Route::get('treasury_journal', ['as'=>'treasury_journal', 'uses'=>'sales\Treasury_detailsController@treasury_journal'])->middleware('can:treasuryDetails.treasury_journal');
Route::get('under_collection', ['as'=>'under_collection', 'uses'=>'sales\Treasury_detailsController@under_collection'])->middleware('can:treasuryDetails.under_collection');
Route::post('check_approved', ['as'=>'check_approved', 'uses'=>'sales\Treasury_detailsController@check_approved'])->middleware('can:treasuryDetails.check_approved');
Route::post('check_reject', ['as'=>'check_reject', 'uses'=>'sales\Treasury_detailsController@check_reject'])->middleware('can:treasuryDetails.check_reject');


Route::post('add_discount_customer/{customer_id}', ['as'=>'add_discount_customer', 'uses'=>'sales\Treasury_detailsController@add_discount_customer'])->middleware('can:treasuryDetails.add_discount_customer');
Route::post('edit_discount_customer/{id}', ['as'=>'edit_discount_customer', 'uses'=>'sales\Treasury_detailsController@edit_discount_customer'])->middleware('can:treasuryDetails.edit_discount_customer');
Route::post('delete_discount/{id}', ['as'=>'delete_discount', 'uses'=>'sales\Treasury_detailsController@delete_discount'])->middleware('can:treasuryDetails.delete_discount');
Route::post('add_account_settlement_customer/{customer_id}', ['as'=>'add_account_settlement_customer', 'uses'=>'sales\Treasury_detailsController@add_account_settlement_customer'])->middleware('can:treasuryDetails.add_account_settlement_customer');
Route::post('edit_account_settlement_customer/{id}', ['as'=>'edit_account_settlement_customer', 'uses'=>'sales\Treasury_detailsController@edit_account_settlement_customer'])->middleware('can:treasuryDetails.edit_account_settlement_customer');
Route::post('delete_settlement/{id}', ['as'=>'delete_settlement', 'uses'=>'sales\Treasury_detailsController@delete_settlement'])->middleware('can:treasuryDetails.delete_settlement');

Route::get('redirect_customer_account_result/{customer_id}/{from?}/{to?}', ['as'=>'redirect_customer_account_result', 'uses'=>'Reports_crmController@redirect_customer_account_result']);


// =======================================End treasuryDetails=======================
// =======================================End Accounting_cost=======================
Route::get('accountingCosts', ['as'=>'accountingCosts.index', 'uses'=>'accounting\Accounting_costController@index'])->middleware('can:accountingCosts.index');
Route::get('accountingCosts/create/{id?}', ['as'=>'accountingCosts.create', 'uses'=>'accounting\Accounting_costController@create'])->middleware('can:accountingCosts.create');
Route::post('accountingCosts/', ['as'=>'accountingCosts.store', 'uses'=>'accounting\Accounting_costController@store'])->middleware('can:accountingCosts.store');
Route::get('accountingCosts/{id}', ['as'=>'accountingCosts.show', 'uses'=>'accounting\Accounting_costController@show'])->middleware('can:accountingCosts.show');
Route::get('accountingCosts/{id}/edit', ['as'=>'accountingCosts.edit', 'uses'=>'accounting\Accounting_costController@edit'])->middleware('can:accountingCosts.edit');
Route::patch('accountingCosts/{id}', ['as'=>'accountingCosts.update', 'uses'=>'accounting\Accounting_costController@update'])->middleware('can:accountingCosts.update');
Route::delete('accountingCosts/{id}', ['as'=>'accountingCosts.destroy', 'uses'=>'accounting\Accounting_costController@destroy'])->middleware('can:accountingCosts.destroy');

Route::get('get_costs_model_quantity','accounting\Accounting_costController@get_costs_model_quantity');
// =======================================End Accounting_cost=======================
// =======================================End Payment_type=======================
Route::get('paymentTypes', ['as'=>'paymentTypes.index', 'uses'=>'accounting\Payment_typeController@index'])->middleware('can:paymentTypes.index');
Route::get('paymentTypes/create/{id?}', ['as'=>'paymentTypes.create', 'uses'=>'accounting\Payment_typeController@create'])->middleware('can:paymentTypes.create');
Route::post('paymentTypes/', ['as'=>'paymentTypes.store', 'uses'=>'accounting\Payment_typeController@store'])->middleware('can:paymentTypes.store');
Route::get('paymentTypes/{id}', ['as'=>'paymentTypes.show', 'uses'=>'accounting\Payment_typeController@show'])->middleware('can:paymentTypes.show');
Route::get('paymentTypes/{id}/edit', ['as'=>'paymentTypes.edit', 'uses'=>'accounting\Payment_typeController@edit'])->middleware('can:paymentTypes.edit');
Route::patch('paymentTypes/{id}', ['as'=>'paymentTypes.update', 'uses'=>'accounting\Payment_typeController@update'])->middleware('can:paymentTypes.update');
Route::delete('paymentTypes/{id}', ['as'=>'paymentTypes.destroy', 'uses'=>'accounting\Payment_typeController@destroy'])->middleware('can:paymentTypes.destroy');
// =======================================End Payment_type=======================

//-----------------------------------------Bank--------------------------------------
Route::get('Bankpayment/{id}', ['as' => 'Bankpayment', 'uses' => 'sales\Treasury_detailsController@bankpayment']);
//-----------------------------------------Enad Bank--------------------------------------


// Route::resource('banks', App\Http\Controllers\accounting\BankController::class);
Route::get('banks', ['as'=>'banks.index', 'uses'=>'accounting\BankController@index'])->middleware('can:banks.index');
Route::get('banks/create/{id?}', ['as'=>'banks.create', 'uses'=>'accounting\BankController@create'])->middleware('can:banks.create');
Route::post('banks/', ['as'=>'banks.store', 'uses'=>'accounting\BankController@store'])->middleware('can:banks.store');
Route::get('banks/{id}', ['as'=>'banks.show', 'uses'=>'accounting\BankController@show'])->middleware('can:banks.show');
Route::get('banks/{id}/edit', ['as'=>'banks.edit', 'uses'=>'accounting\BankController@edit'])->middleware('can:banks.edit');
Route::patch('banks/{id}', ['as'=>'banks.update', 'uses'=>'accounting\BankController@update'])->middleware('can:banks.update');
Route::delete('banks/{id}', ['as'=>'banks.destroy', 'uses'=>'accounting\BankController@destroy'])->middleware('can:banks.destroy');




// =======================================End invoices=======================
// Route::resource('invoices', App\Http\Controllers\accounting\InvoiceController::class);
Route::get('invoices', ['as'=>'invoices.index', 'uses'=>'accounting\InvoiceController@index'])->middleware('can:invoices.index');
Route::get('invoices/create/{id?}', ['as'=>'invoices.create', 'uses'=>'accounting\InvoiceController@create'])->middleware('can:invoices.create');
Route::post('invoices/', ['as'=>'invoices.store', 'uses'=>'accounting\InvoiceController@store'])->middleware('can:invoices.store');
Route::get('invoices/{id}', ['as'=>'invoices.show', 'uses'=>'accounting\InvoiceController@show'])->middleware('can:invoices.show');
Route::get('origenal_invoices/{id}', ['as'=>'invoices.origenal_invoices', 'uses'=>'accounting\InvoiceController@origenal_invoices'])->middleware('can:invoices.show');
Route::get('invoices/{id}/edit', ['as'=>'invoices.edit', 'uses'=>'accounting\InvoiceController@edit'])->middleware('can:invoices.edit');
Route::patch('invoices/{id}', ['as'=>'invoices.update', 'uses'=>'accounting\InvoiceController@update'])->middleware('can:invoices.update');
Route::delete('invoices/{id}', ['as'=>'invoices.destroy', 'uses'=>'accounting\InvoiceController@destroy'])->middleware('can:invoices.destroy');

Route::get('get-deliver-orders', ['as'=>'getDeliverOrders', 'uses'=>'accounting\InvoiceController@getDeliverOrders']);
Route::get('check_date_available', ['as'=>'check_date_available', 'uses'=>'accounting\InvoiceController@check_date_available']);

// =======================================End invoices=======================
