<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Color_categoryDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateColor_categoryRequest;
use App\Http\Requests\inventory\UpdateColor_categoryRequest;
use App\Repositories\inventory\Color_categoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\inventory\Color;
use Response;
use Auth;

class Color_categoryController extends AppBaseController
{
    /** @var Color_categoryRepository $colorCategoryRepository*/
    private $colorCategoryRepository;

    public function __construct(Color_categoryRepository $colorCategoryRepo)
    {
        $this->colorCategoryRepository = $colorCategoryRepo;
    }

    /**
     * Display a listing of the Color_category.
     *
     * @param Color_categoryDataTable $colorCategoryDataTable
     *
     * @return Response
     */
    public function index(Color_categoryDataTable $colorCategoryDataTable)
    {
        return $colorCategoryDataTable->render('color_categories.index');
    }

    /**
     * Show the form for creating a new Color_category.
     *
     * @return Response
     */
    public function create()
    {
        return view('color_categories.create');
    }

    /**
     * Store a newly created Color_category in storage.
     *
     * @param CreateColor_categoryRequest $request
     *
     * @return Response
     */
    public function store(CreateColor_categoryRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $colorCategory = $this->colorCategoryRepository->create($input);

        return redirect(route('colorCategories.index'))->with('success', trans('تنبيه تم حفظ مجموعه الالوان'));
    }

    /**
     * Display the specified Color_category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $colorCategory = $this->colorCategoryRepository->find($id);

        if (empty($colorCategory)) {
            return redirect(route('colorCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه الالوان'));  
        }

        return view('color_categories.show')->with('colorCategory', $colorCategory);
    }

    /**
     * Show the form for editing the specified Color_category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $colorCategory = $this->colorCategoryRepository->find($id);
        if(Auth::user()->id == $colorCategory->creator_id || Auth::user()->can('roles.store')){

        if (empty($colorCategory)) {
            return redirect(route('colorCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه الالوان')); 
        }

        return view('color_categories.edit')->with('colorCategory', $colorCategory);
    }else{
        return redirect()->back()->with('error', trans('عفوآ...ليس لديك صلاحية التعديل على هذا البند')); 
  }
}

    /**
     * Update the specified Color_category in storage.
     *
     * @param int $id
     * @param UpdateColor_categoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateColor_categoryRequest $request)
    {
        $colorCategory = $this->colorCategoryRepository->find($id);

        if (empty($colorCategory)) {
            return redirect(route('colorCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه الالوان')); 
        }
        $input = $request->all();
        $input['updated_by']= Auth::user()->id;
        $colorCategory = $this->colorCategoryRepository->update($input, $id);

        return redirect(route('colorCategories.index'))->with('success', trans('تنبيه تم تعديل مجموعه الالوان'));
    }

    /**
     * Remove the specified Color_category from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $colorCategory = $this->colorCategoryRepository->find($id);

        if (empty($colorCategory)) {
            return redirect(route('colorCategories.index'))->with('error', trans('عفوآ...لم يتم العثور على مجموعه الالوان')); 
        }

        $check = Color::where('colorCategory_id',$id)->get();
    
        if(count($check)>0){
            return redirect(route('colorCategories.index'))->with('error', trans('عفوآ...لا يمكن حذف مجموعه الالوان لأرتباطه بلون محدد')); 
        }else{
        $this->colorCategoryRepository->delete($id);

        return redirect(route('colorCategories.index'))->with('success', trans('تنبيه تم حذف مجموعه الالوان'));
    }
    }
}
