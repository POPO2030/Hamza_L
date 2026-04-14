<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\WeightDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateWeightRequest;
use App\Http\Requests\inventory\UpdateWeightRequest;
use App\Repositories\inventory\WeightRepository;
use App\Models\inventory\Inv_product;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

class WeightController extends AppBaseController
{
    /** @var WeightRepository $weightRepository*/
    private $weightRepository;

    public function __construct(WeightRepository $weightRepo)
    {
        $this->weightRepository = $weightRepo;
    }

    /**
     * Display a listing of the Weight.
     *
     * @param WeightDataTable $weightDataTable
     *
     * @return Response
     */
    public function index(WeightDataTable $weightDataTable)
    {
        return $weightDataTable->render('weights.index');
    }

    /**
     * Show the form for creating a new Weight.
     *
     * @return Response
     */
    public function create()
    {
        return view('weights.create');
    }

    /**
     * Store a newly created Weight in storage.
     *
     * @param CreateWeightRequest $request
     *
     * @return Response
     */
    public function store(CreateWeightRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $weight = $this->weightRepository->create($input);

        return redirect(route('weights.index'))->with('success', trans('تنبيه...تم حفظ السمك بنجاح'));
    }

    /**
     * Display the specified Weight.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $weight = $this->weightRepository->find($id);

        if (empty($weight)) {
            return redirect(route('weights.index'))->with('error', trans('عفوآ...لم يتم العثور على السمك')); 
        }

        return view('weights.show')->with('weight', $weight);
    }

    /**
     * Show the form for editing the specified Weight.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $weight = $this->weightRepository->find($id);
        if(Auth::user()->id == $weight->creator_id || Auth::user()->can('roles.store')){
        if (empty($weight)) {
            return redirect(route('weights.index'))->with('error', trans('عفوآ...لم يتم العثور على السمك')); 
        }

        return view('weights.edit')->with('weight', $weight);
    }else{
      return redirect()->back()->with('error', trans('عفوآ...ليس لديك صلاحية التعديل على هذا البند')); 
  }
}

    /**
     * Update the specified Weight in storage.
     *
     * @param int $id
     * @param UpdateWeightRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWeightRequest $request)
    {
        $weight = $this->weightRepository->find($id);

        if (empty($weight)) {
            return redirect(route('weights.index'))->with('error', trans('عفوآ...لم يتم العثور على السمك')); 
        }
        $check = Inv_product::where('weight_id',$id)->get();
    
        if(count($check)>0 && !Auth::user()->can('roles.store')){
    
            return redirect(route('weights.edit',['id'=>$id]))->with('error', trans('عفوآ...لا يمكن تعديل السمك لأرتباطه بمنتجات')); 
        }else{
        $input = $request->all();
        $input['updated_by']= Auth::user()->id;
        $weight = $this->weightRepository->update($input, $id);

        return redirect(route('weights.index'))->with('success', trans('تنبيه...تم تعديل السمك بنجاح'));
        }
    }

    /**
     * Remove the specified Weight from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $weight = $this->weightRepository->find($id);

        if (empty($weight)) {
            return redirect(route('weights.index'))->with('error', trans('عفوآ...لم يتم العثور على السمك')); 
        }

        $check = Inv_product::where('weight_id',$id)->get();
    
        if(count($check)>0){
            return redirect(route('weights.index'))->with('error', trans('عفوآ...لا يمكن حذف السمك لأرتباطه بمنتجات')); 
        }else{
        $this->weightRepository->delete($id);

        return redirect(route('weights.index'))->with('success', trans('تنبيه...تم حذف السمك بنجاح'));
        }
    }
}
