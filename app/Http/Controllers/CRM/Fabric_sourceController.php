<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\Fabric_sourceDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateFabric_sourceRequest;
use App\Http\Requests\CRM\UpdateFabric_sourceRequest;
use App\Repositories\CRM\Fabric_sourceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use App\Models\CRM\WorkOrder;

class Fabric_sourceController extends AppBaseController
{
    /** @var Fabric_sourceRepository $fabricSourceRepository*/
    private $fabricSourceRepository;

    public function __construct(Fabric_sourceRepository $fabricSourceRepo)
    {
        $this->fabricSourceRepository = $fabricSourceRepo;
    }

    /**
     * Display a listing of the Fabric_source.
     *
     * @param Fabric_sourceDataTable $fabricSourceDataTable
     *
     * @return Response
     */
    public function index(Fabric_sourceDataTable $fabricSourceDataTable)
    {
        return $fabricSourceDataTable->render('fabric_sources.index');
    }

    /**
     * Show the form for creating a new Fabric_source.
     *
     * @return Response
     */
    public function create()
    {
        return view('fabric_sources.create');
    }

    /**
     * Store a newly created Fabric_source in storage.
     *
     * @param CreateFabric_sourceRequest $request
     *
     * @return Response
     */
    public function store(CreateFabric_sourceRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;

        $fabricSource = $this->fabricSourceRepository->create($input);

        Flash::success('تنبية .... تم انشاء مصدر القماش بنجاح');

        return redirect(route('fabricSources.index'));
    }

    /**
     * Display the specified Fabric_source.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fabricSource = $this->fabricSourceRepository->find($id);

        if (empty($fabricSource)) {
            Flash::error('Fabric Source not found');

            return redirect(route('fabricSources.index'));
        }

        return view('fabric_sources.show')->with('fabricSource', $fabricSource);
    }

    /**
     * Show the form for editing the specified Fabric_source.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fabricSource = $this->fabricSourceRepository->find($id);

        if (empty($fabricSource)) {
            Flash::error('Fabric Source not found');

            return redirect(route('fabricSources.index'));
        }

        return view('fabric_sources.edit')->with('fabricSource', $fabricSource);
    }

    /**
     * Update the specified Fabric_source in storage.
     *
     * @param int $id
     * @param UpdateFabric_sourceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFabric_sourceRequest $request)
    {
        $fabricSource = $this->fabricSourceRepository->find($id);

        if (empty($fabricSource)) {
            Flash::error('Fabric Source not found');

            return redirect(route('fabricSources.index'));
        }

        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        $fabricSource = $this->fabricSourceRepository->update($input, $id);

        Flash::success('تنبيه.... تم تعديل مصدر القماش بنجاح');

        return redirect(route('fabricSources.index'));
    }

    /**
     * Remove the specified Fabric_source from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fabricSource = $this->fabricSourceRepository->find($id);

        $check = WorkOrder::where('fabric_source_id',$id)->get();

        if(count($check)>0){
            Flash::error('لا يمكن الحذف لوجود بيانات مدرجه');
    
            return redirect(route('fabricSources.index'));
        }else{

            $this->fabricSourceRepository->delete($id);
    
            Flash::success('تنبيه.... تم حذف مصدر القماش بنجاح');

            return redirect(route('fabricSources.index'));
        }
    }
}
