<?php

namespace App\Http\Controllers\sales;

use App\DataTables\TreasuryDataTable;
use App\Http\Requests\sales;
use App\Http\Requests\sales\CreateTreasuryRequest;
use App\Http\Requests\sales\UpdateTreasuryRequest;
use App\Repositories\sales\TreasuryRepository;
use App\Models\sales\Treasury_details;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TreasuryController extends AppBaseController
{
    /** @var TreasuryRepository $treasuryRepository*/
    private $treasuryRepository;

    public function __construct(TreasuryRepository $treasuryRepo)
    {
        $this->treasuryRepository = $treasuryRepo;
    }


    public function index(TreasuryDataTable $treasuryDataTable)
    {
        return $treasuryDataTable->render('treasuries.index');
    }

    public function create()
    {
        return view('treasuries.create');
    }


    public function store(CreateTreasuryRequest $request)
    {
        $input = $request->all();

        $treasury = $this->treasuryRepository->create($input);


        return redirect(route('treasuries.index'))->with('success', trans('تم الحفظ'));
    }


    public function show($id)
    {
        $treasury = $this->treasuryRepository->find($id);

        if (empty($treasury)) {
            Flash::error('Treasury not found');

            return redirect(route('treasuries.index'));
        }

        return view('treasuries.show')->with('treasury', $treasury);
    }

    public function edit($id)
    {
        $treasury = $this->treasuryRepository->find($id);

        if (empty($treasury)) {
            Flash::error('Treasury not found');

            return redirect(route('treasuries.index'));
        }

        return view('treasuries.edit')->with('treasury', $treasury);
    }


    public function update($id, UpdateTreasuryRequest $request)
    {
        $treasury = $this->treasuryRepository->find($id);

        if (empty($treasury)) {
            Flash::error('Treasury not found');

            return redirect(route('treasuries.index'));
        }

        $treasury = $this->treasuryRepository->update($request->all(), $id);


        return redirect(route('treasuries.index'))->with('success', trans('تم التعديل'));
    }


    public function destroy($id)
    {
        $treasury = $this->treasuryRepository->find($id);

        if (empty($treasury)) {
            return redirect(route('treasuries.index'))->with('error', trans('عفوآ...الخزينة غير موجود'));
        }

        $check = Treasury_details::where('treasury_id',$id)->get();
        if(count($check)>0){
            Flash::error('عفوآ...لا يمكن حذف الخزينة لأرتباطه بعمليات');
    
            return redirect(route('treasuries.index'));
        }else{
        $this->treasuryRepository->delete($id);

        return redirect(route('treasuries.index'))->with('success', trans('تم الحذف'));
    }
}
}


