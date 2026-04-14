<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\FabricDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateFabricRequest;
use App\Http\Requests\CRM\UpdateFabricRequest;
use App\Repositories\CRM\FabricRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use App\Models\CRM\Fabric_source;
use App\Models\CRM\Fabric;
use App\Models\CRM\WorkOrder;

class FabricController extends AppBaseController
{
    /** @var FabricRepository $fabricRepository*/
    private $fabricRepository;

    public function __construct(FabricRepository $fabricRepo)
    {
        $this->fabricRepository = $fabricRepo;
    }

    /**
     * Display a listing of the Fabric.
     *
     * @param FabricDataTable $fabricDataTable
     *
     * @return Response
     */
    public function index(FabricDataTable $fabricDataTable)
    {
        return $fabricDataTable->render('fabrics.index');
    }

    /**
     * Show the form for creating a new Fabric.
     *
     * @return Response
     */
    public function create()
    {
        $fabric_sources =Fabric_source::pluck('name','id');
        return view('fabrics.create')->with(['fabric_sources'=>$fabric_sources]);
    }

    /**
     * Store a newly created Fabric in storage.
     *
     * @param CreateFabricRequest $request
     *
     * @return Response
     */
    public function store(CreateFabricRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;

        $fabric = $this->fabricRepository->create($input);

        Flash::success('تنبيه .... تم انشاء القماشة بنجاح');

        return redirect(route('fabrics.index'));
    }

    /**
     * Display the specified Fabric.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fabric = $this->fabricRepository->find($id);

        if (empty($fabric)) {
            Flash::error('Fabric not found');

            return redirect(route('fabrics.index'));
        }

        return view('fabrics.show')->with('fabric', $fabric);
    }

    /**
     * Show the form for editing the specified Fabric.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fabric = $this->fabricRepository->find($id);

        if (empty($fabric)) {
            Flash::error('Fabric not found');

            return redirect(route('fabrics.index'));
        }

        return view('fabrics.edit')->with('fabric', $fabric);
    }

    /**
     * Update the specified Fabric in storage.
     *
     * @param int $id
     * @param UpdateFabricRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFabricRequest $request)
    {
        $fabric = $this->fabricRepository->find($id);

        if (empty($fabric)) {
            Flash::error('Fabric not found');

            return redirect(route('fabrics.index'));
        }

        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        $fabric = $this->fabricRepository->update($input, $id);

        Flash::success('تنبيه .... تم تعديل القماشة بنجاح');

        return redirect(route('fabrics.index'));
    }

    /**
     * Remove the specified Fabric from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fabric = $this->fabricRepository->find($id);


        $check = WorkOrder::where('fabric_id',$id)->get();

        if(count($check)>0){
            Flash::error('لا يمكن الحذف لوجود بيانات مدرجه');
    
            return redirect(route('fabrics.index'));
        }else{

            $this->fabricRepository->delete($id);
    
            Flash::success('تنبيه .... تم حذف القماشة بنجاح');

            return redirect(route('fabrics.index'));
        }




        

    }
}
