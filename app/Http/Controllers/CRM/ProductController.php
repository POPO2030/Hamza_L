<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ProductDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateProductRequest;
use App\Http\Requests\CRM\UpdateProductRequest;
use App\Repositories\CRM\ProductRepository;
use App\Models\CRM\ReceiveReceipt;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\ProductCategory;

class ProductController extends AppBaseController
{
    /** @var ProductRepository $productRepository*/
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param ProductDataTable $productDataTable
     *
     * @return Response
     */
    public function index(ProductDataTable $productDataTable)
    {
        return $productDataTable->render('products.index');
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $cats=ProductCategory::pluck('name','id');
        return view('products.create')->with('cats',$cats);
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->create($input);

        Flash::success('تنبيه...تم حفظ الصنف بنجاح.');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('عفوآ...لم يتم العثور على الصنف');

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        $cats=ProductCategory::pluck('name','id');

        if (empty($product)) {
            Flash::error('عفوآ...لم يتم العثور على الصنف');

            return redirect(route('products.index'));
        }

        return view('products.edit')->with(['product'=> $product , 'cats'=>$cats]);
    }

    /**
     * Update the specified Product in storage.
     *
     * @param int $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error('عفوآ...لم يتم العثور على الصنف');

            return redirect(route('products.index'));
        }

        $product = $this->productRepository->update($request->all(), $id);

        Flash::success('تنبيه...تم تعديل الصنف بنجاح.');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

    $product = $this->productRepository->find($id);
    
    if (empty($product)) {
        Flash::error('عفوآ...لم يتم العثور على مجموعه الاصناف');

        return redirect(route('products.index'));
    }

    $check = ReceiveReceipt::where('product_id',$id)->get();
    
    if(count($check)>0){
        Flash::error('  لا يمكن الحذف لوجود بيانات مدرجه   ');

        return redirect(route('products.index'));
    }else{
        $this->productRepository->delete($id);

        Flash::success('تم الحذف الصنف بنجاح');

        return redirect(route('products.index'));
    }



    }
}
