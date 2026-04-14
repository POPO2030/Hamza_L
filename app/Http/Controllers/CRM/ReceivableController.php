<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ReceivableDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateReceivableRequest;
use App\Http\Requests\CRM\UpdateReceivableRequest;
use App\Repositories\CRM\ReceivableRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\WorkOrder;

class ReceivableController extends AppBaseController
{
    /** @var ReceivableRepository $receivableRepository*/
    private $receivableRepository;

    public function __construct(ReceivableRepository $receivableRepo)
    {
        $this->receivableRepository = $receivableRepo;
    }

    /**
     * Display a listing of the Receivable.
     *
     * @param ReceivableDataTable $receivableDataTable
     *
     * @return Response
     */
    public function index(ReceivableDataTable $receivableDataTable)
    {
        return $receivableDataTable->render('receivables.index');
    }

    /**
     * Show the form for creating a new Receivable.
     *
     * @return Response
     */
    public function create()
    {
        return view('receivables.create');
    }

    /**
     * Store a newly created Receivable in storage.
     *
     * @param CreateReceivableRequest $request
     *
     * @return Response
     */
    public function store(CreateReceivableRequest $request)
    {
        $input = $request->all();

        $receivable = $this->receivableRepository->create($input);

        Flash::success('تم إنشاء المستلم بنجاح');

        return redirect(route('receivables.index'));
    }

    /**
     * Display the specified Receivable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $receivable = $this->receivableRepository->find($id);

        if (empty($receivable)) {
            Flash::error('عفوا .. المستلم غير موجود');

            return redirect(route('receivables.index'));
        }

        return view('receivables.show')->with('receivable', $receivable);
    }

    /**
     * Show the form for editing the specified Receivable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $receivable = $this->receivableRepository->find($id);

        if (empty($receivable)) {
            Flash::error('عفوا .. المستلم غير موجود');

            return redirect(route('receivables.index'));
        }

        return view('receivables.edit')->with('receivable', $receivable);
    }

    /**
     * Update the specified Receivable in storage.
     *
     * @param int $id
     * @param UpdateReceivableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReceivableRequest $request)
    {
        $receivable = $this->receivableRepository->find($id);

        if (empty($receivable)) {
            Flash::error('عفوا .. المستلم غير موجود');

            return redirect(route('receivables.index'));
        }

        $receivable = $this->receivableRepository->update($request->all(), $id);

        Flash::success('تم تعديل المستلم بنجاح');

        return redirect(route('receivables.index'));
    }

    /**
     * Remove the specified Receivable from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $receivable = $this->receivableRepository->find($id);

        if (empty($receivable)) {
            Flash::error('عفوا .. المستلم غير موجود');

            return redirect(route('receivables.index'));
        }


        $check = WorkOrder::where('receivable_id',$id)->get();

        if(count($check)>0){
            Flash::error('  لا يمكن حذف جهة التسليم لوجود غسلة له   ');

            return redirect(route('receivables.index'));
        }else{
            $this->receivableRepository->delete($id);
            Flash::success('تم حذف المستلم بنجاح');

            return redirect(route('receivables.index'));
        }
    }
    

}

    

       