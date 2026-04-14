<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\SizeDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateSizeRequest;
use App\Http\Requests\inventory\UpdateSizeRequest;
use App\Repositories\inventory\SizeRepository;
use App\Models\inventory\Inv_product;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

class SizeController extends AppBaseController
{
    /** @var SizeRepository $sizeRepository*/
    private $sizeRepository;

    public function __construct(SizeRepository $sizeRepo)
    {
        $this->sizeRepository = $sizeRepo;
    }

    /**
     * Display a listing of the Size.
     *
     * @param SizeDataTable $sizeDataTable
     *
     * @return Response
     */
    public function index(SizeDataTable $sizeDataTable)
    {
        return $sizeDataTable->render('sizes.index');
    }

    /**
     * Show the form for creating a new Size.
     *
     * @return Response
     */
    public function create()
    {
        return view('sizes.create');
    }

    /**
     * Store a newly created Size in storage.
     *
     * @param CreateSizeRequest $request
     *
     * @return Response
     */
    public function store(CreateSizeRequest $request)
    {
       
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $size = $this->sizeRepository->create($input);

        return redirect(route('sizes.index'))->with('success', trans('تنبيه...تم حفظ المقاس بنجاح'));
    }

    /**
     * Display the specified Size.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $size = $this->sizeRepository->find($id);

        if (empty($size)) {
            return redirect(route('sizes.index'))->with('error', trans('عفوآ...لم يتم العثور على المقاس')); 
        }

        return view('sizes.show')->with('size', $size);
    }


    public function edit($id)
    {
        $size = $this->sizeRepository->find($id);
        if(Auth::user()->id == $size->creator_id || Auth::user()->can('roles.store')){
        if (empty($size)) {
            return redirect(route('sizes.index'))->with('error', trans('عفوآ...لم يتم العثور على المقاس')); 
        }

        return view('sizes.edit')->with('size', $size);
    }else{
      return redirect()->back()->with('error', trans('عفوآ...ليس لديك صلاحية التعديل على هذا البند')); 
  }
}

    public function update($id, UpdateSizeRequest $request)
    {
        $size = $this->sizeRepository->find($id);

        if (empty($size)) {
            return redirect(route('sizes.index'))->with('error', trans('عفوآ...لم يتم العثور على المقاس')); 
        }

        $check = Inv_product::where('size_id',$id)->get();
    
        if(count($check)>0 && !Auth::user()->can('roles.store')){
            return redirect(route('sizes.index'))->with('error', trans('عفوآ...لا يمكن تعديل المقاس لأرتباطه بمنتجات')); 
        }else{
        $input = $request->all();
        $input['updated_by']= Auth::user()->id;
        $size = $this->sizeRepository->update( $input, $id);

        return redirect(route('sizes.index'))->with('success', trans('تنبيه...تم تعديل المقاس بنجاح'));
    }
    }

    /**
     * Remove the specified Size from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $size = $this->sizeRepository->find($id);

        if (empty($size)) {
            return redirect(route('sizes.index'))->with('error', trans('عفوآ...لم يتم العثور على المقاس')); 
        }

        $check = Inv_product::where('size_id',$id)->get();
    
        if(count($check)>0){
            return redirect(route('sizes.index'))->with('error', trans('عفوآ...لا يمكن حذف المقاس لأرتباطه بمنتجات')); 
        }else{
        $this->sizeRepository->delete($id);

        return redirect(route('sizes.index'))->with('success', trans('تنبيه...تم حذف المقاس بنجاح'));
        }
    }
}
