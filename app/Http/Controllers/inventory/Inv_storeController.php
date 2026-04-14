<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_storeDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_storeRequest;
use App\Http\Requests\inventory\UpdateInv_storeRequest;
use App\Repositories\inventory\Inv_storeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\inventory\Inv_category;
use App\Models\inventory\Inv_importorder_details;
use App\Models\inventory\Inv_exportOrder_details;
use App\Models\inventory\Inv_stockInDetails;
use App\Models\inventory\Inv_stockOutDetails;
use Response;
use Auth;

class Inv_storeController extends AppBaseController
{
    /** @var Inv_storeRepository $invStoreRepository*/
    private $invStoreRepository;

    public function __construct(Inv_storeRepository $invStoreRepo)
    {
        $this->invStoreRepository = $invStoreRepo;
    }

    /**
     * Display a listing of the Inv_store.
     *
     * @param Inv_storeDataTable $invStoreDataTable
     *
     * @return Response
     */
    public function index(Inv_storeDataTable $invStoreDataTable)
    {
        return $invStoreDataTable->render('inv_stores.index');
    }

    /**
     * Show the form for creating a new Inv_store.
     *
     * @return Response
     */
    public function create()
    {
        $category_ids=Inv_category::pluck('name','id');

        return view('inv_stores.create')->with(['category_ids'=> $category_ids]);
    }

    /**
     * Store a newly created Inv_store in storage.
     *
     * @param CreateInv_storeRequest $request
     *
     * @return Response
     */
    public function store(CreateInv_storeRequest $request)
    {

        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $invStore = $this->invStoreRepository->create($input);

        return redirect(route('invStores.index'))->with('success', trans('تنبيه...تم حفظ المخزن بنجاح'));
    }

    /**
     * Display the specified Inv_store.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invStore = $this->invStoreRepository->find($id);

        if (empty($invStore)) {
            return redirect(route('invStores.index'))->with('error', trans('عفوآ...لم يتم العثور على المخزن')); 
        }

        return view('inv_stores.show')->with('invStore', $invStore);
    }

    /**
     * Show the form for editing the specified Inv_store.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invStore = $this->invStoreRepository->find($id);
        $category_ids=Inv_category::pluck('name','id');

        if (empty($invStore)) {
            return redirect(route('invStores.index'))->with('error', trans('عفوآ...لم يتم العثور على المخزن')); 
        }

        return view('inv_stores.edit')->with(['invStore'=>$invStore, 'category_ids'=> $category_ids]);
    }

    /**
     * Update the specified Inv_store in storage.
     *
     * @param int $id
     * @param UpdateInv_storeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInv_storeRequest $request)
    {
        $invStore = $this->invStoreRepository->find($id);

        if (empty($invStore)) {
            return redirect(route('invStores.index'))->with('error', trans('عفوآ...لم يتم العثور على المخزن')); 
        }

        $input = $request->all();
        $input['updated_by'] =Auth::user()->id;
        $invStore = $this->invStoreRepository->update($input, $id);

        return redirect(route('invStores.index'))->with('success', trans('تنبيه...تم تعديل المخزن بنجاح'));

    }

    /**
     * Remove the specified Inv_store from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invStore = $this->invStoreRepository->find($id);

        if (empty($invStore)) {
            return redirect(route('invStores.index'))->with('error', trans('عفوآ...لم يتم العثور على المخزن')); 
        }
// return "kkk";
 
        $import_order= Inv_importorder_details::where('store_id',$id)->get();
        $export_order= Inv_exportOrder_details::where('store_id',$id)->get();

        if(count($import_order)>0|| count($export_order)>0){
            return redirect(route('invStores.index'))->with('error', trans('لا يمكن حذف المخزن بسبب تنفيذ عمليات استلام و صرف عليه')); 
        }

        $this->invStoreRepository->delete($id);

        return redirect(route('invStores.index'))->with('success', trans('تنبيه...تم حذف المخزن بنجاح'));
    }
}
