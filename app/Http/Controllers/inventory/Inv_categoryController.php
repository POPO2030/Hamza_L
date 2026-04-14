<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_categoryDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_categoryRequest;
use App\Http\Requests\inventory\UpdateInv_categoryRequest;
use App\Repositories\inventory\Inv_categoryRepository;
use App\Models\inventory\Inv_product;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

class Inv_categoryController extends AppBaseController
{
    /** @var Inv_categoryRepository $invCategoryRepository*/
    private $invCategoryRepository;

    public function __construct(Inv_categoryRepository $invCategoryRepo)
    {
        $this->invCategoryRepository = $invCategoryRepo;
    }

    /**
     * Display a listing of the Inv_category.
     *
     * @param Inv_categoryDataTable $invCategoryDataTable
     *
     * @return Response
     */
    public function index(Inv_categoryDataTable $invCategoryDataTable)
    {
        return $invCategoryDataTable->render('inv_categories.index');
    }

    /**
     * Show the form for creating a new Inv_category.
     *
     * @return Response
     */
    public function create()
    {
        return view('inv_categories.create');
    }

    /**
     * Store a newly created Inv_category in storage.
     *
     * @param CreateInv_categoryRequest $request
     *
     * @return Response
     */
    public function store(CreateInv_categoryRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $invCategory = $this->invCategoryRepository->create($input);

        return redirect(route('invCategories.index'))->with('success', trans('تنبيه...تم حفظ مجموعه المنتجات بنجاح'));
    }

    /**
     * Display the specified Inv_category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invCategory = $this->invCategoryRepository->find($id);

        if (empty($invCategory)) {
            return redirect(route('invCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه المنتجات')); 
        }

        return view('inv_categories.show')->with('invCategory', $invCategory);
    }

    /**
     * Show the form for editing the specified Inv_category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invCategory = $this->invCategoryRepository->find($id);
        if(Auth::user()->id == $invCategory->creator_id || Auth::user()->can('roles.store')){

        if (empty($invCategory)) {
            return redirect(route('invCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه المنتجات')); 
        }

        return view('inv_categories.edit')->with('invCategory', $invCategory);
    }else{
        Flash::error('عفوآ...ليس لديك صلاحية التعديل على هذا البند');
      return redirect()->back();
  }
}


    /**
     * Update the specified Inv_category in storage.
     *
     * @param int $id
     * @param UpdateInv_categoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInv_categoryRequest $request)
    {
        $invCategory = $this->invCategoryRepository->find($id);

        if (empty($invCategory)) {
            return redirect(route('invCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه المنتجات')); 
        }

        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;
        $invCategory = $this->invCategoryRepository->update($input, $id);

        return redirect(route('invCategories.index'))->with('success', trans('تنبيه...تم تعديل مجموعه المنتجات بنجاح'));
    }

    /**
     * Remove the specified Inv_category from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invCategory = $this->invCategoryRepository->find($id);

        if (empty($invCategory)) {
            return redirect(route('invCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه المنتجات')); 
        }
        $check = Inv_product::where('category_id',$id)->get();
        
        if(count($check)>0){
            return redirect(route('invCategories.index'))->with('error', trans('عفوآ...لا يمكن حذف مجموعه المنتجات لأرتباطها بمنتجات')); 
        }
        $this->invCategoryRepository->delete($id);

        return redirect(route('invCategories.index'))->with('success', trans('تنبيه...تم حذف مجموعه المنتجات بنجاح'));
    }
}
