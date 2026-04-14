<?php

namespace App\Http\Controllers\sales;

use App\DataTables\ShopDataTable;
use App\Http\Requests\sales;
use App\Http\Requests\sales\CreateShopRequest;
use App\Http\Requests\sales\UpdateShopRequest;
use App\Repositories\sales\ShopRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\sales\Region;
use App\Models\sales\Customer_shop;
use Auth;

class ShopController extends AppBaseController
{
    /** @var ShopRepository $shopRepository*/
    private $shopRepository;

    public function __construct(ShopRepository $shopRepo)
    {
        $this->shopRepository = $shopRepo;
    }

    /**
     * Display a listing of the Shop.
     *
     * @param ShopDataTable $shopDataTable
     *
     * @return Response
     */
    public function index(ShopDataTable $shopDataTable)
    {
        return $shopDataTable->render('shops.index');
    }

    /**
     * Show the form for creating a new Shop.
     *
     * @return Response
     */
    public function create()
    {
        $regions=Region::pluck('name','id');

        return view('shops.create')->with([
            'regions'=>$regions,
        ]);
    }

    /**
     * Store a newly created Shop in storage.
     *
     * @param CreateShopRequest $request
     *
     * @return Response
     */
    public function store(CreateShopRequest $request)
    {
        $input = $request->validate([
            'name' => 'required|unique:shops,name,NULL,id,address,' . $request->input('address'),
        ], [
            'name.unique' => 'عفوآ...اسم المحل  موجود من قبل في نفس العنوان',
        ]);
        
        $input = $request->all();
        $input['creator_id'] = Auth::user()->id;

        $shop = $this->shopRepository->create($input);

        return redirect(route('shops.index'))->with('success', trans('تنبيه .... تم انشاء المحل بنجاح'));
    }

    public function show($id)
    {
        $shop = $this->shopRepository->find($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('shops.index'));
        }

        return view('shops.show')->with('shop', $shop);
    }

    /**
     * Show the form for editing the specified Shop.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $regions=Region::pluck('name','id');

        $shop = $this->shopRepository->find($id);

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('shops.index'));
        }

        return view('shops.edit')->with(['shop'=> $shop,'regions'=> $regions]);
    }

    /**
     * Update the specified Shop in storage.
     *
     * @param int $id
     * @param UpdateShopRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShopRequest $request)
    {
        $input = $request->validate([
            'name' => 'required|unique:shops,name,NULL,id,address,' . $request->input('address'),
        ], [
            'name.unique' => 'عفوآ...اسم المحل  موجود من قبل في نفس العنوان',
        ]);
        $shop = $this->shopRepository->find($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        if (empty($shop)) {
            Flash::error('Shop not found');

            return redirect(route('shops.index'));
        }

        $shop = $this->shopRepository->update($input, $id);


        return redirect(route('shops.index'))->with('success', trans('تنبيه .... تم تعديل بيانات المحل بنجاح'));
    }

    /**
     * Remove the specified Shop from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shop = $this->shopRepository->find($id);

        $check = Customer_shop::where('shop_id',$id)->get();
        if(count($check)>0){
    
            return redirect(route('shops.index'))->with('error', trans('عفوآ...لا يمكن حذف المحل لأرتباطه بعملاء اخرين'));
        }else{

        $this->shopRepository->delete($id);

        return redirect(route('shops.index'))->with('success', trans('تنبيه .... تم حذف المحل بنجاح '));
        }
    }
}
