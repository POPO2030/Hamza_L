<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\suppliersDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreatesuppliersRequest;
use App\Http\Requests\CRM\UpdatesuppliersRequest;
use App\Repositories\CRM\suppliersRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use App\Models\inventory\Inv_importOrder;
// use App\Models\inventory\Color;

class suppliersController extends AppBaseController
{
    /** @var suppliersRepository $suppliersRepository*/
    private $suppliersRepository;

    public function __construct(suppliersRepository $suppliersRepo)
    {
        $this->suppliersRepository = $suppliersRepo;
    }

    /**
     * Display a listing of the suppliers.
     *
     * @param suppliersDataTable $suppliersDataTable
     *
     * @return Response
     */
    public function index(suppliersDataTable $suppliersDataTable)
    {
        return $suppliersDataTable->render('suppliers.index');
    }

    /**
     * Show the form for creating a new suppliers.
     *
     * @return Response
     */
    public function create()
    {
      
        return view('suppliers.create');
    }

    /**
     * Store a newly created suppliers in storage.
     *
     * @param CreatesuppliersRequest $request
     *
     * @return Response
     */
    public function store(CreatesuppliersRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $suppliers = $this->suppliersRepository->create($input);

        Flash::success('تنبيه...تم حفظ المورد الجديد');

        return redirect(route('suppliers.index'));
    }

    /**
     * Display the specified suppliers.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $suppliers = $this->suppliersRepository->find($id);

        if (empty($suppliers)) {
            Flash::error('عفوآ... لم يتم العثور على بيانات المورد');

            return redirect(route('suppliers.index'));
        }

        return view('suppliers.show')->with('suppliers', $suppliers);
    }

    /**
     * Show the form for editing the specified suppliers.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $suppliers = $this->suppliersRepository->find($id);
        if(Auth::user()->id == $suppliers->creator_id || Auth::user()->can('roles.store')){
        if (empty($suppliers)) {
            Flash::error('عفوآ... لم يتم العثور على بيانات المورد');

            return redirect(route('suppliers.index'));
        }

        return view('suppliers.edit')->with('suppliers', $suppliers);
    }else{
        Flash::error('عفوآ...ليس لديك صلاحية التعديل على هذا البند');
      return redirect()->back();
  }
}

    public function update($id, UpdatesuppliersRequest $request)
    {
        $suppliers = $this->suppliersRepository->find($id);

        if (empty($suppliers)) {
            Flash::error('عفوآ... لم يتم العثور على بيانات المورد');

            return redirect(route('suppliers.index'));
        }

        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;
        $suppliers = $this->suppliersRepository->update($input, $id);

        Flash::success('تنبيه... تم تحديث بيانات المورد بنجاح');

        return redirect(route('suppliers.index'));
    }

    /**
     * Remove the specified suppliers from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $suppliers = $this->suppliersRepository->find($id);

        if (empty($suppliers)) {
            Flash::error('عفوآ... لم يتم العثور على بيانات المورد');

            return redirect(route('suppliers.index'));
        }
        $check = Inv_importOrder::where('supplier_id',$id)->get();
        if(count($check)>0){
            Flash::error(' عفوآ...لا يمكن حذف المورد لارتباطه بأذون استلام');
            return redirect(route('suppliers.index'));
        }
        $this->suppliersRepository->delete($id);

        Flash::success('تنبيه...تم حذف بيانات المورد بنجاح');

        return redirect(route('suppliers.index'));
    }
}
