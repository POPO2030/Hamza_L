<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ProductCategoryDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateProductCategoryRequest;
use App\Http\Requests\CRM\UpdateProductCategoryRequest;
use App\Repositories\CRM\ProductCategoryRepository;
use App\Models\CRM\Product;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ProductCategoryController extends AppBaseController
{
    /** @var ProductCategoryRepository $productCategoryRepository*/
    private $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepo)
    {
        $this->productCategoryRepository = $productCategoryRepo;
    }

    /**
     * Display a listing of the ProductCategory.
     *
     * @param ProductCategoryDataTable $productCategoryDataTable
     *
     * @return Response
     */
    public function index(ProductCategoryDataTable $productCategoryDataTable)
    {
        return $productCategoryDataTable->render('product_categories.index');
    }

    /**
     * Show the form for creating a new ProductCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_categories.create');
    }

    /**
     * Store a newly created ProductCategory in storage.
     *
     * @param CreateProductCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateProductCategoryRequest $request)
    {
        $input = $request->all();

        $productCategory = $this->productCategoryRepository->create($input);

        Flash::success('تنبيه...تم حفظ مجموعه الاصناف بنجاح.');

        return redirect(route('productCategories.index'));
    }

    /**
     * Display the specified ProductCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productCategory = $this->productCategoryRepository->find($id);

        if (empty($productCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه الاصناف');

            return redirect(route('productCategories.index'));
        }

        return view('product_categories.show')->with('productCategory', $productCategory);
    }

    /**
     * Show the form for editing the specified ProductCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productCategory = $this->productCategoryRepository->find($id);

        if (empty($productCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه الاصناف');

            return redirect(route('productCategories.index'));
        }

        return view('product_categories.edit')->with('productCategory', $productCategory);
    }

    /**
     * Update the specified ProductCategory in storage.
     *
     * @param int $id
     * @param UpdateProductCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductCategoryRequest $request)
    {
        $productCategory = $this->productCategoryRepository->find($id);

        if (empty($productCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه الاصناف');

            return redirect(route('productCategories.index'));
        }

        $productCategory = $this->productCategoryRepository->update($request->all(), $id);

        Flash::success('تنبيه...تم تعديل مجموعه الاصناف بنجاح.');

        return redirect(route('productCategories.index'));
    }

    /**
     * Remove the specified ProductCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

        $productCategory = $this->productCategoryRepository->find($id);
    
        if (empty($productCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه الاصناف');
    
            return redirect(route('productCategories.index'));
        }
    
        $check = Product::where('category_id',$id)->get();
        
        if(count($check)>0){
            Flash::error('  لا يمكن الحذف لوجود بيانات مدرجه   ');
    
            return redirect(route('productCategories.index'));
        }else{
            $this->productCategoryRepository->delete($id);
    
            Flash::success('تم الحذف مجموعه الاصناف بنجاح');
    
            return redirect(route('productCategories.index'));
        }
    
    
    }
}
