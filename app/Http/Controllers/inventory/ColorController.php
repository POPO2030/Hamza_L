<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\ColorDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateColorRequest;
use App\Http\Requests\inventory\UpdateColorRequest;
use App\Repositories\inventory\ColorRepository;
use App\Models\inventory\product_color;
use App\Models\CRM\suppliers;
use App\Models\inventory\Color_category;
use App\Models\inventory\Color;
use App\Models\inventory\Color_code;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;
use Response;
use Auth;

class ColorController extends AppBaseController
{
    /** @var ColorRepository $colorRepository*/
    private $colorRepository;

    public function __construct(ColorRepository $colorRepo)
    {
        $this->colorRepository = $colorRepo;
    }

    /**
     * Display a listing of the Color.
     *
     * @param ColorDataTable $colorDataTable
     *
     * @return Response
     */
    public function index(ColorDataTable $colorDataTable)
    {
        return $colorDataTable->render('colors.index');
    }

    /**
     * Show the form for creating a new Color.
     *
     * @return Response
     */
    public function create()
    {
        $cats=Color_category::pluck('name','id');
        $color_code=Color_code::pluck('name','id');
        return view('colors.create')->with([
        'cats'=>$cats,
        'color_code'=>$color_code
    ]);

    }

    public function store(CreateColorRequest $request)
    {

$input = $request->validate([
    'color_code_id' => 'required|unique:colors,color_code_id,NULL,id,colorCategory_id,' . $request->input('colorCategory_id'),
], [
    'color_code_id.unique' => 'عفوآ...كود اللون موجود من قبل',
]);
// ==============================================================================

        $input = $request->all();

        $color = $this->colorRepository->create($input);

        return redirect(route('colors.index'))->with('success', trans('تنبيه...تم حفظ اللون بنجاح'));
    }


    public function show($id)
    {
        $color = $this->colorRepository->find($id);

        if (empty($color)) {
            return redirect(route('colors.index'))->with('error', trans('عفوآ...لم يتم العثور على اللون'));  
        }

        return view('colors.show')->with('color', $color);
    }


    public function edit($id)
    {
        $cats=Color_category::pluck('name','id');
        $color_code=Color_code::pluck('name','id');
        $color = $this->colorRepository->find($id);
        if(Auth::user()->id == $color->creator_id || Auth::user()->can('roles.store')){
        if (empty($color)) {
            return redirect(route('colors.index'))->with('error', trans('عفوآ...لم يتم العثور على اللون'));  
        }

        return view('colors.edit')->with(['color'=> $color,'cats'=> $cats,'color_code'=> $color_code]);
    }else{
        return redirect()->back()->with('error', trans('عفوآ...ليس لديك صلاحية التعديل على هذا البند')); 
  }
}


    public function update($id, UpdateColorRequest $request)
    {
        $color = $this->colorRepository->find($id);

        if (empty($color)) {
            return redirect(route('colors.index'))->with('error', trans('عفوآ...لم يتم العثور على اللون'));  
        }
        $check = product_color::where('color_id',$id)->get();
        

        if(count($check)>0 && !Auth::user()->can('roles.store')){
            return redirect(route('colors.edit',['id'=>$id]))->with('error', trans('عفوآ...لا يمكن تعديل اللون لأرتباطه بمنتجات'));  
        }else{
        $color = $this->colorRepository->update($request->all(), $id);

        return redirect(route('colors.index'))->with('success', trans('تنبيه...تم تعديل اللون بنجاح'));
        }
    }


    public function destroy($id)
    {
        $color = $this->colorRepository->find($id);

        if (empty($color)) {
            return redirect(route('colors.index'))->with('error', trans('عفوآ...لم يتم العثور على اللون'));  
        }

        $check = product_color::where('color_id',$id)->get();
    
        if(count($check)>0){
    
            return redirect(route('colors.index'))->with('error', trans('عفوآ...لا يمكن حذف اللون لأرتباطه بمنتجات')); 
        }else{
            $this->colorRepository->delete($id);
    
            return redirect(route('colors.index'))->with('success', trans('تنبيه...تم حذف اللون بنجاح'));
        }

    }
}
