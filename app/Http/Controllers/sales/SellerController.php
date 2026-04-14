<?php

namespace App\Http\Controllers\sales;

use App\DataTables\SellerDataTable;
use App\Http\Requests\sales;
use App\Http\Requests\sales\CreateSellerRequest;
use App\Http\Requests\sales\UpdateSellerRequest;
use App\Repositories\sales\SellerRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use App\Models\sales\Final_product_requset;

class SellerController extends AppBaseController
{
    /** @var SellerRepository $sellerRepository*/
    private $sellerRepository;

    public function __construct(SellerRepository $sellerRepo)
    {
        $this->sellerRepository = $sellerRepo;
    }

    /**
     * Display a listing of the Seller.
     *
     * @param SellerDataTable $sellerDataTable
     *
     * @return Response
     */
    public function index(SellerDataTable $sellerDataTable)
    {
        return $sellerDataTable->render('sellers.index');
    }

    /**
     * Show the form for creating a new Seller.
     *
     * @return Response
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created Seller in storage.
     *
     * @param CreateSellerRequest $request
     *
     * @return Response
     */
    public function store(CreateSellerRequest $request)
    {
        $input = $request->all();
        $input['creator_id'] = Auth::user()->id;

        $seller = $this->sellerRepository->create($input);

        // Flash::success('تنبيه ... تم انشاء البائع بنجاح');

        return redirect(route('sellers.index'))->with('success', trans('تنبيه ... تم انشاء البائع بنجاح'));
    }

    /**
     * Display the specified Seller.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $seller = $this->sellerRepository->find($id);

        if (empty($seller)) {
            Flash::error('Seller not found');

            return redirect(route('sellers.index'));
        }

        return view('sellers.show')->with('seller', $seller);
    }

    /**
     * Show the form for editing the specified Seller.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $seller = $this->sellerRepository->find($id);

        if (empty($seller)) {
            Flash::error('Seller not found');

            return redirect(route('sellers.index'));
        }

        return view('sellers.edit')->with('seller', $seller);
    }

    /**
     * Update the specified Seller in storage.
     *
     * @param int $id
     * @param UpdateSellerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSellerRequest $request)
    {
        $seller = $this->sellerRepository->find($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;
        // if (empty($seller)) {
        //     Flash::error('Seller not found');

        //     return redirect(route('sellers.index'));
        // }

        $seller = $this->sellerRepository->update($input, $id);

        // Flash::success('تنبيه ... تم تعديل البائع بنجاح');

        return redirect(route('sellers.index'))->with('success', trans('تنبيه ... تم تعديل البائع بنجاح'));
    }

    /**
     * Remove the specified Seller from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $seller = $this->sellerRepository->find($id);

        $check = Final_product_requset::where('seller_id',$id)->get();
        if(count($check)>0){
    
            return redirect(route('sellers.index'))->with('error', trans('عفوآ...لا يمكن حذف البائع لأرتباطه بطلبات صرف اخرى'));
        }else{
       

        $this->sellerRepository->delete($id);

        // Flash::success('تنبيه ... تم حذف البائع بنجاح');

        return redirect(route('sellers.index'))->with('success', trans('تنبيه ... تم حذف البائع بنجاح'));
        }
    }
}
