<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_productDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_productRequest;
use App\Http\Requests\inventory\UpdateInv_productRequest;
use App\Repositories\inventory\Inv_productRepository;
use App\Models\inventory\Inv_category;
use App\Models\inventory\Inv_unit;
use App\Models\inventory\Inv_ProductUnit;
use App\Models\inventory\Color;
use App\Models\inventory\product_color;
use App\Models\inventory\image;
use App\Models\inventory\Inv_product;
use App\Models\inventory\Inv_importorder_details;
use App\Models\inventory\Inv_exportOrder_details;
use App\Models\inventory\Inv_controlStock;
use App\Models\inventory\Color_code;
use App\Models\CRM\Cartila_details;
use App\Models\CRM\Product;
use App\Models\CRM\Size_finalproduct;
use App\Models\sales\Final_product_requset;
use App\Models\sales\Final_product_request_detail;
use App\Traits\UploadTrait;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Inv_productController extends AppBaseController
{
    use UploadTrait;
    /** @var Inv_productRepository $invProductRepository*/
    private $invProductRepository;

    public function __construct(Inv_productRepository $invProductRepo)
    {
        $this->invProductRepository = $invProductRepo;
    }

    /**
     * Display a listing of the Inv_product.
     *
     * @param Inv_productDataTable $invProductDataTable
     *
     * @return Response
     */
    public function index(Inv_productDataTable $invProductDataTable)
    {
        $inv_category = Inv_category::select('id','name')->get();
        return $invProductDataTable->render('inv_products.index',['inv_category'=> $inv_category]);
    }

    /**
     * Show the form for creating a new Inv_product.
     *
     * @return Response
     */
    public function create()
    {
        $colors=Color::with('invcolor_category:name,id','get_color_code:name,id')->get();
        $units=Inv_unit::all();
        $cats=Inv_category::pluck('name','id');
        $color_code=Color_code::pluck('name','id');

        return view('inv_products.create')
        ->with(['cats'=>$cats,
        'units'=>$units,
        'color_code'=>$color_code,
        'colors'=>$colors]);
    }


    public function store(CreateInv_productRequest $request)
    {
        
// return $request;
            $input = $request->validate([
                'name' => 'required|unique:inv_products,name,NULL,id,manual_code,' . $request->input('manual_code'),
                'manual_code' => 'required|unique:inv_products,manual_code,NULL,id,name,' . $request->input('name'),
            ], [
                'name.unique' => 'عفوآ... اسم المنتج موجود من قبل',
                'manual_code.unique' => 'عفوآ... كود المنتج موجود من قبل',
            ]);

        // ========================================================================
        if(isset($request->img)){
        $total = 0;

        foreach ($request->img as $file) {
            $total += $file->getSize();
        }

        if ($total > 1024 * 1024) {
            return redirect()->back()->withErrors(['img.*' => 'عفوآ...مجموع حجم الصور تجاوز الحد الأقصى المسموح به (1024 كيلوبايت).']);
        }

        $input = $request->validate([
            'img.*' => 'image|mimes:jpeg,png,gif,jpg|max:1024', 
        ], [
            'img.*.image' => 'عفوآ...يسمح باختيار صور فقط',
            'img.*.mimes' => 'عفوأ...صيغ الصور المتاح اختيارها هي (jpeg, png, gif, jpg).',
            'img.*.max' => 'عفوآ...يجب ان لا تزيد مساحة الصورة عن 1024 كيلو بايت',
        ]);
        }
        // =================================validtion===========================================
        try {
            DB::beginTransaction();

            $lastRecord = Inv_product::where('category_id', $request->category_id)->latest()->first();

            $input = $request->all();
            if($request->product_price !=null){
                $input['product_price']= $request->product_price;
            }else{
                $input['product_price']="0";
            }
            $input['creator_id']= Auth::user()->id;
            $input['manual_code']= $request->manual_code ?? null;
            $invProduct = $this->invProductRepository->create($input);
    
            $data2=[];
            
                $data2=[
                    'product_id'=> $invProduct->id,
                    'unit_id'=>$request->unit_id,
                    'unitcontent'=>1,
                ];
            

            Inv_ProductUnit::insert($data2);
    
    
            // for ($x = 0; $x < count($request->color_id); $x++) {
                $product = product_color::create([
                    'product_id' => $invProduct->id,
                    'color_id' => $request->color_id,
                ]);
            
                // $id = $product->color_id;
            
                // if (isset($_FILES['img_' . $id]['name']) && is_array($_FILES['img_' . $id]['name'])) {
                //     for ($z = 0; $z < count($_FILES['img_' . $id]['name']); $z++) {
                //         if ($_FILES['img_' . $id]['error'][$z] === UPLOAD_ERR_OK) {
                //             $file_name = $this->upload_file($request->file('img_' . $id)[$z], 'uploads/products/', $x . $z);
                //             image::create([
                //                 'img' => $file_name,
                //                 'product_colors_id' => $product->id,
                //             ]);
                //         }
                //     }
                // }
            // }
            if ($request->hasFile('img')) {

                foreach ($request->file('img') as $index => $file) {
                    $file_name = $this->upload_file($file, 'uploads/products/', $index);
                    Image::create([
                        'img' => $file_name,
                        'product_colors_id' => $product->id,
                    ]);
                }
            }


            if(empty($lastRecord->system_code)){
                $start_value = 1;
                $system_code = $request->category_id . $start_value;

            }else{
                $system_code = $lastRecord->system_code+1;
            }
            

            
            Inv_product::where('id', $invProduct->id)->update(['system_code' => $system_code]);

            // --------------------------------Start opening_balance--------------------------------------------
           if(isset($request->opening_balance)){
            $data5 = [
                'invimport_export_id' => 0,
                'product_id' => $product->id,
                'supplier_id' => 1,
                'unit_id' => $request->unit_id,
                'store_id' => 1,
                'created_at' => now(),
                'flag' => 5,
                'quantity_in' => $request->opening_balance,
            ];
            Inv_controlStock::create($data5);
           }
           
            // --------------------------------End opening_balance--------------------------------------------
            DB::commit();
      
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect(route('invProducts.index'))->with('success', trans('تنبيه...تم حفظ المنتج بنجاح'));
    }


    public function show($id)
    {
        $invProduct = Inv_product::with(['product_color.invcolor_category:name,id'])->find($id);
      
        if (empty($invProduct)) {
            return redirect(route('invProducts.index'))->with('error', trans('عفوآ...لم يتم العثور على المنتج'));
       }
       $colors=Color::with('invcolor_category:name,id')->get();
        $table_color_body = product_color::where('product_id',$id)
        ->with('get_color.invcolor_category:name,id')->with('images:img,product_colors_id')->get();

        //   return $table_color_body;

        return view('inv_products.show')->with(['invProduct'=> $invProduct,
        'table_color_body'=>$table_color_body,
        'colors'=>$colors]);
    }

    /**
     * Show the form for editing the specified Inv_product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // return $id;
        $invProduct = $this->invProductRepository->find($id);

            if (empty($invProduct)) {
                return redirect(route('invProducts.index'))->with('error', trans('عفوآ...لم يتم العثور على المنتج'));
            }

            $productID_search = product_color::where('product_id', $id)->pluck('id')->toArray();

            $importorder_details = Inv_importorder_details::whereIn('product_id', $productID_search)->get();
            $exportOrder_details = Inv_exportOrder_details::whereIn('product_id', $productID_search)->get();      

            $colors=Color::with('invcolor_category:name,id')->get();
            $units=Inv_unit::all();
            $cats=Inv_category::pluck('name','id');

            $opening_balance=Inv_controlStock::where('product_id',$productID_search)->where('flag',5)->first(); /////////////////
                
            if ($opening_balance) {
                    $opening_balance = $opening_balance->quantity_in;
            }else{
                    $opening_balance = 0 ;
            }

            $table_color_body = product_color::where('product_id',$id)
            ->with('get_color.invcolor_category:name,id')->with('images:img,product_colors_id')->first();

            // return $opening_balance;
            $table_body = Inv_ProductUnit::where('product_id',$id)->with('get_product:name,id')
            ->with('get_unit:name,id')->first();
            // return $table_color_body;
            if(count( $importorder_details)> 0 || count($exportOrder_details)> 0){
                return view('inv_products.image_fields')
                ->with([
                    'invProduct'=> $invProduct ,
                    'cats'=> $cats ,
                    'units'=>$units,
                    'table_body'=>$table_body,
                    'table_color_body'=>$table_color_body,
                    'colors'=>$colors,
                    'opening_balance'=>$opening_balance,
                    ]);
    

            }else{
                

                return view('inv_products.edit')->with([
                    'invProduct'=> $invProduct ,
                    'cats'=> $cats ,
                    'units'=>$units,
                    'table_body'=>$table_body,
                    'table_color_body'=>$table_color_body,
                    'colors'=>$colors,
                    'opening_balance'=>$opening_balance,
                ]);
                       
            }
}


    public function update($id, UpdateInv_productRequest $request)
    {
        // return $request;
        $invProduct = $this->invProductRepository->find($id);

        if (empty($invProduct)) {
            return redirect(route('invProducts.index'))->with('error', trans('عفوآ...لم يتم العثور على المنتج'));
        }
        
        // if( $request->category_id != 2 && $request->category_id != 3 && (empty($request->size_id)) && (empty($request->weight_id))){
        //     return redirect(route('invProducts.index'))->with('error', trans('عفوآ...مع مجموعه الخيوط يجب ادخال المقاس والسمك'));
        // }
// ==============================================================
if(isset($request->img)){
$total = 0;

foreach ($request->img as $file) {
    $total += $file->getSize();
}

if ($total > 1024 * 1024) {
    return redirect()->back()->withErrors(['img.*' => 'عفوآ...مجموع حجم الصور تجاوز الحد الأقصى المسموح به (1024 كيلوبايت).']);
}

$input = $request->validate([
    'img.*' => 'image|mimes:jpeg,png,gif,jpg|max:1024', 
], [
    'img.*.image' => 'عفوآ...يسمح باختيار صور فقط',
    'img.*.mimes' => 'عفوأ...صيغ الصور المتاح اختيارها هي (jpeg, png, gif, jpg).',
    'img.*.max' => 'عفوآ...يجب ان لا تزيد مساحة الصورة عن 1024 كيلو بايت',
]);
}
// =================================validtion===========================================
// return $request;
        try {
            DB::beginTransaction();

            $lastRecord = Inv_product::where('final_product_id', $request->final_product_id)->latest()->first();

            $input = $request->all();
            if($request->product_price !=null){
                $input['product_price']= $request->product_price;
            }else{
                $input['product_price']="0";
            }
        $input['updated_by'] = Auth::user()->id;
        $invProduct = $this->invProductRepository->update($input, $id);


        Inv_ProductUnit::where('product_id',$id)->delete();
        $data2=[];
      
            $data2=[
                'product_id'=> $id,
                'unit_id'=>$request->unit_id,
                'unitcontent'=>1,
            ];
        
        Inv_ProductUnit::insert($data2);

        $product_color_id = product_color::where('product_id', $id)->select('id')->first();

    // product_color::where('product_id', $invProduct->id)->delete();
 
    // for ($x = 0; $x < count($request->color_id); $x++) {

        // $product = product_color::create([
        //     'product_id' => $invProduct->id,
        //     'color_id' => $request->color_id,
        // ]);
        if($request->color_id){
            $product_color_id->update([
                'color_id' => $request->color_id,
            ]);
        }
       
            if ($request->hasFile('img')) {
                    image::where('product_colors_id', $product_color_id->id)->delete();

                foreach ($request->file('img') as $index => $file) {
                    $file_name = $this->upload_file($file, 'uploads/products/', $index);
                    Image::create([
                        'img' => $file_name,
                        'product_colors_id' => $product_color_id->id,
                    ]);
                }
            }

            // if($request->imgs){

            //     image::where('product_colors_id',$product_color_delete)->delete();
            //     foreach ($request->imgs as $img) {
            //         Image::create([
            //             'img' => $img,
            //             'product_colors_id' => $product->id,
            //         ]);
            //     }
                
            // }
            


    // --------------------------------Start opening_balance--------------------------------------------
        if(isset($request->opening_balance)){
            $product_in_stock=Inv_controlStock::where('product_id',$product_color_id->id)->where('flag',5)->first();
            if($product_in_stock){
                $product_in_stock->update([
                    'quantity_in'=>$request->opening_balance,
                    'product_id'=>$product_color_id->id,
                ]);
            }else{
                $data5 = [
                    'invimport_export_id' => 0,
                    'product_id' => $product_color_id->id,
                    'supplier_id' => 1,
                    'unit_id' => $request->unit_id,
                    'store_id' => 1,
                    'created_at' => now(),
                    'flag' => 5,
                    'quantity_in' => $request->opening_balance,
                ];
                Inv_controlStock::create($data5);
            }
        }
        // --------------------------------End opening_balance--------------------------------------------

    
    if(empty($lastRecord->system_code)){
        $start_value = 1;
        $system_code = $request->final_product_id . $start_value;

    }else{
        $system_code = $lastRecord->system_code+1;
    }
    

    
    Inv_product::where('id', $invProduct->id)->update(['system_code' => $system_code]);


        DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
        

        return redirect(route('invProducts.index'))->with('success', trans('تنبيه...تم تعديل المنتج بنجاح'));
    }


    public function updateimage($id,Request $request)
    {
        // return $request;
        $invProduct = $this->invProductRepository->find($id);
    //    return $invProduct;
        if (empty($invProduct)) {
            return redirect(route('invProducts.index'))->with('error', trans('عفوآ...لم يتم العثور على المنتج'));
        }
        
// ==============================================================
if(isset($request->img)){
$total = 0;

foreach ($request->img as $file) {
    $total += $file->getSize();
}

if ($total > 1024 * 1024) {
    return redirect()->back()->withErrors(['img.*' => 'عفوآ...مجموع حجم الصور تجاوز الحد الأقصى المسموح به (1024 كيلوبايت).']);
}

$input = $request->validate([
    'img.*' => 'image|mimes:jpeg,png,gif,jpg|max:1024', 
], [
    'img.*.image' => 'عفوآ...يسمح باختيار صور فقط',
    'img.*.mimes' => 'عفوأ...صيغ الصور المتاح اختيارها هي (jpeg, png, gif, jpg).',
    'img.*.max' => 'عفوآ...يجب ان لا تزيد مساحة الصورة عن 1024 كيلو بايت',
]);
}
// =================================validtion===========================================
try {
    DB::beginTransaction();

    $input = $request->all();
    $input['updated_by'] = Auth::user()->id;
    $invProduct = $this->invProductRepository->update($input, $id);

    $product_color_id = product_color::where('product_id', $id)->select('id')->first();
// return $product_color_id->id;
    // product_color::where('product_id', $invProduct->id)->delete();
 
        // $product = product_color::create([
        //     'product_id' => $invProduct->id,
        //     'color_id' => $request->color_id,
        // ]);

        if ($request->hasFile('img')) {
            image::where('product_colors_id', $product_color_id->id)->delete();

        foreach ($request->file('img') as $index => $file) {
            $file_name = $this->upload_file($file, 'uploads/products/', $index);
            Image::create([
                'img' => $file_name,
                'product_colors_id' => $product_color_id->id,
            ]);
        }
    }

    // if($request->imgs){

    //     image::where('product_colors_id',$product_color_id->id)->delete();
    //     foreach ($request->imgs as $img) {
    //         Image::create([
    //             'img' => $img,
    //             'product_colors_id' => $product_color_id->id,
    //         ]);
    //     }
        
    // }

DB::commit();
} catch (\Throwable $th) {
    throw $th;
    DB::rollBack();
}


return redirect(route('invProducts.index'))->with('success', trans('تنبيه...تم تعديل المنتج بنجاح'));


    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
        
        $invProduct = $this->invProductRepository->find($id);

        if (empty($invProduct)) {

            return redirect(route('invProducts.index'))->with('error', trans('عفوآ...لم يتم العثور على المنتج'));
        }

        $ids=product_color::where('product_id',$id)->pluck('id')->toArray();
        $import_order= Inv_importorder_details::whereIn('product_id',$ids)->get();
        $export_order= Inv_exportOrder_details::whereIn('product_id',$ids)->get();

        if(count($import_order)>0||count($export_order)>0){

            return redirect(route('invProducts.index'))->with('error', trans('لا يمكن حذف المنتج بسبب تنفيذ عمليات استلام و صرف عليه'));
        }

        $this->invProductRepository->delete($id);
        Inv_ProductUnit::where('product_id',$id)->delete();
        product_color::where('product_id',$id)->delete();
        image::where('product_colors_id',$id)->delete();

DB::commit();
} catch (\Throwable $th) {
    throw $th;
    DB::rollBack();
}

     return redirect(route('invProducts.index'))->with('success', trans('تنبيه...تم حذف المنتج بنجاح'));
    }
}
