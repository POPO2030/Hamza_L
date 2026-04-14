<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\BrandDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateBrandRequest;
use App\Http\Requests\inventory\UpdateBrandRequest;
use App\Repositories\inventory\BrandRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\inventory\Inv_product;
use Response;
use Auth;
use Illuminate\Support\Facades\View;


class BrandController extends AppBaseController
{
    /** @var BrandRepository $brandRepository*/
    private $brandRepository;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepository = $brandRepo;
    }

    /**
     * Display a listing of the Brand.
     *
     * @param BrandDataTable $brandDataTable
     *
     * @return Response
     */
    public function index(BrandDataTable $brandDataTable)
    {
        return $brandDataTable->render('brands.index');
    }

    /**
     * Show the form for creating a new Brand.
     *
     * @return Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created Brand in storage.
     *
     * @param CreateBrandRequest $request
     *
     * @return Response
     */
    public function store(CreateBrandRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $brand = $this->brandRepository->create($input);

       return redirect(route('brands.index'))->with('success', trans('تنبيه...تم حفظ الماركة بنجاح'));

    }

    /**
     * Display the specified Brand.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $brand = $this->brandRepository->find($id);

        if (empty($brand)) {
            return redirect(route('brands.index'))->with('error', trans('عفوآ...لم يتم العثور على الماركه'));  
        }

        return view('brands.show')->with('brand', $brand);
    }

    /**
     * Show the form for editing the specified Brand.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $brand = $this->brandRepository->find($id);

        if (empty($brand)) {
            return redirect(route('brands.index'))->with('error', trans('عفوآ...لم يتم العثور على الماركه'));  
        }

        return view('brands.edit')->with('brand', $brand);
    }

    /**
     * Update the specified Brand in storage.
     *
     * @param int $id
     * @param UpdateBrandRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBrandRequest $request)
    {
        $brand = $this->brandRepository->find($id);

        if (empty($brand)) {
            return redirect(route('brands.index'))->with('error', trans('عفوآ...لم يتم العثور على الماركه'));  
        }

        $input = $request->all();
        $input['updated_by']= Auth::user()->id;
        $brand = $this->brandRepository->update($input, $id);

        return redirect(route('brands.index'))->with('success', trans('تنبيه...تم تعديل الماركة بنجاح'));
    }

    /**
     * Remove the specified Brand from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $brand = $this->brandRepository->find($id);

        if (empty($brand)) {
            return redirect(route('brands.index'))->with('error', trans('عفوآ...لم يتم العثور على الماركه'));  
        }

        $check = Inv_product::where('brand_id',$id)->get();
    
        if(count($check)>0){
            return redirect(route('brands.index'))->with('error', trans('عفوآ...لا يمكن حذف الماركه لأرتباطها بمنتجات'));  
        }else{

        $this->brandRepository->delete($id);

        return redirect(route('brands.index'))->with('success', trans('تنبيه...تم حذف الماركه بنجاح'));  
        }
    }
}
