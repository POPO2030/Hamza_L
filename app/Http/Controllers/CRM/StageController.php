<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\StageDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateStageRequest;
use App\Http\Requests\CRM\UpdateStageRequest;
use App\Repositories\CRM\StageRepository;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\satge_category;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class StageController extends AppBaseController
{
    /** @var StageRepository $stageRepository*/
    private $stageRepository;

    public function __construct(StageRepository $stageRepo)
    {
        $this->stageRepository = $stageRepo;
    }

    /**
     * Display a listing of the Stage.
     *
     * @param StageDataTable $stageDataTable
     *
     * @return Response
     */
    public function index(StageDataTable $stageDataTable)
    {
        return $stageDataTable->render('stages.index');
    }

    /**
     * Show the form for creating a new Stage.
     *
     * @return Response
     */
    public function create()
    {
        $cats=satge_category::pluck('name','id');
        return view('stages.create')->with(['cats'=>$cats]);
    }

    /**
     * Store a newly created Stage in storage.
     *
     * @param CreateStageRequest $request
     *
     * @return Response
     */
    public function store(CreateStageRequest $request)
    {
        $input = $request->all();

        $stage = $this->stageRepository->create($input);

        Flash::success('تنبيه...تم حفظ مرحله الانتاج بنجاح.');

        return redirect(route('stages.index'));
    }

    /**
     * Display the specified Stage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $stage = $this->stageRepository->find($id);

        if (empty($stage)) {
            Flash::error('عفوآ...لم يتم العثور على مرحله الانتاج');

            return redirect(route('stages.index'));
        }

        return view('stages.show')->with('stage', $stage);
    }

    /**
     * Show the form for editing the specified Stage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $stage = $this->stageRepository->find($id);
        $cats=satge_category::pluck('name','id');

        if (empty($stage)) {
            Flash::error('عفوآ...لم يتم العثور على مرحله الانتاج');

            return redirect(route('stages.index'));
        }

        return view('stages.edit')->with(['stage'=> $stage , 'cats'=>$cats]);
    }

    /**
     * Update the specified Stage in storage.
     *
     * @param int $id
     * @param UpdateStageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStageRequest $request)
    {
        $stage = $this->stageRepository->find($id);

        if (empty($stage)) {
            Flash::error('عفوآ...لم يتم العثور على مرحله الانتاج');

            return redirect(route('stages.index'));
        }

        $stage = $this->stageRepository->update($request->all(), $id);

        Flash::success('تنبيه...تم تعديل مرحله الانتاج.');

        return redirect(route('stages.index'));
    }

    /**
     * Remove the specified Stage from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

    $stage = $this->stageRepository->find($id);

    if (empty($stage)) {
        Flash::error('عفوآ...لم يتم العثور على مرحله الانتاج');

        return redirect(route('stages.index'));
    }

    $check = ServiceItemSatge::where('satge_id',$id)->get();
    
    if(count($check)>0){
        Flash::error('  لا يمكن الحذف لوجود بيانات مدرجه   ');

        return redirect(route('stages.index'));
    }else{
        $this->stageRepository->delete($id);

        Flash::success('تم الحذف مرحله الانتاج بنجاح');

        return redirect(route('stages.index'));
    }


}
}