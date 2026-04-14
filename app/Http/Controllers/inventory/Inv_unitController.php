<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_unitDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_unitRequest;
use App\Http\Requests\inventory\UpdateInv_unitRequest;
use App\Repositories\inventory\Inv_unitRepository;
use App\Models\inventory\Inv_ProductUnit;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

class Inv_unitController extends AppBaseController
{
    /** @var Inv_unitRepository $invUnitRepository*/
    private $invUnitRepository;

    public function __construct(Inv_unitRepository $invUnitRepo)
    {
        $this->invUnitRepository = $invUnitRepo;
    }

    /**
     * Display a listing of the Inv_unit.
     *
     * @param Inv_unitDataTable $invUnitDataTable
     *
     * @return Response
     */
    public function index(Inv_unitDataTable $invUnitDataTable)
    {
        return $invUnitDataTable->render('inv_units.index');
    }

    /**
     * Show the form for creating a new Inv_unit.
     *
     * @return Response
     */
    public function create()
    {
        return view('inv_units.create');
    }

    /**
     * Store a newly created Inv_unit in storage.
     *
     * @param CreateInv_unitRequest $request
     *
     * @return Response
     */
    public function store(CreateInv_unitRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $invUnit = $this->invUnitRepository->create($input);

        return redirect(route('invUnits.index'))->with('success', trans('تنبيه...تم حفظ وحده القياس بنجاح'));
    }

    /**
     * Display the specified Inv_unit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invUnit = $this->invUnitRepository->find($id);

        if (empty($invUnit)) {
            return redirect(route('invUnits.index'))->with('error', trans('عفوآ...لم يتم العثور على وحده القياس')); 
        }

        return view('inv_units.show')->with('invUnit', $invUnit);
    }

    /**
     * Show the form for editing the specified Inv_unit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $invUnit = $this->invUnitRepository->find($id);
    if(Auth::user()->id == $invUnit->creator_id || Auth::user()->can('roles.store')){
    
        if (empty($invUnit)) {
            return redirect(route('invUnits.index'))->with('error', trans('عفوآ...لم يتم العثور على وحده القياس')); 
        }

        return view('inv_units.edit')->with('invUnit', $invUnit);
    
    }else{
        Flash::error('عفوآ...ليس لديك صلاحية التعديل على هذا البند');
        return redirect()->back();
    }
}
    /**
     * Update the specified Inv_unit in storage.
     *
     * @param int $id
     * @param UpdateInv_unitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInv_unitRequest $request)
    {
        $invUnit = $this->invUnitRepository->find($id);

        if (empty($invUnit)) {
            return redirect(route('invUnits.index'))->with('error', trans('عفوآ...لم يتم العثور على وحده القياس')); 
        }
        $check = Inv_ProductUnit::where('unit_id',$id)->get();
        
        if(count($check)>0 && !Auth::user()->can('roles.store')){
            return redirect(route('invUnits.edit',['id'=>$id]))->with('error', trans('عفوآ...لا يمكن تعديل الوحده لأرتباطها بمنتجات')); 
        }else{
        $invUnit = $this->invUnitRepository->update($request->all(), $id);

        return redirect(route('invUnits.index'))->with('success', trans('تنبيه...تم تعديل وحده القياس بنجاح'));
    }
    }

    /**
     * Remove the specified Inv_unit from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invUnit = $this->invUnitRepository->find($id);

        if (empty($invUnit)) {
            return redirect(route('invUnits.index'))->with('error', trans('عفوآ...لم يتم العثور على وحده القياس')); 
        }
        $check = Inv_ProductUnit::where('unit_id',$id)->get();
        
        if(count($check)>0){
            return redirect(route('invUnits.index'))->with('error', trans('عفوآ...لا يمكن حذف الوحده لأرتباطها بمنتجات')); 
        }else{
        $this->invUnitRepository->delete($id);

        return redirect(route('invUnits.index'))->with('success', trans('تنبيه...تم حذف وحده القياس بنجاح'));
    }
    }
}
