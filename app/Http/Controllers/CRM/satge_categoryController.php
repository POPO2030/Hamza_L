<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\satge_categoryDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\Createsatge_categoryRequest;
use App\Http\Requests\CRM\Updatesatge_categoryRequest;
use App\Repositories\CRM\satge_categoryRepository;
use App\Models\CRM\Stage;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class satge_categoryController extends AppBaseController
{
    /** @var satge_categoryRepository $satgeCategoryRepository*/
    private $satgeCategoryRepository;

    public function __construct(satge_categoryRepository $satgeCategoryRepo)
    {
        $this->satgeCategoryRepository = $satgeCategoryRepo;
    }

    /**
     * Display a listing of the satge_category.
     *
     * @param satge_categoryDataTable $satgeCategoryDataTable
     *
     * @return Response
     */
    public function index(satge_categoryDataTable $satgeCategoryDataTable)
    {
        return $satgeCategoryDataTable->render('satge_categories.index');
    }

    /**
     * Show the form for creating a new satge_category.
     *
     * @return Response
     */
    public function create()
    {
        return view('satge_categories.create');
    }

    /**
     * Store a newly created satge_category in storage.
     *
     * @param Createsatge_categoryRequest $request
     *
     * @return Response
     */
    public function store(Createsatge_categoryRequest $request)
    {
        $input = $request->all();

        $satgeCategory = $this->satgeCategoryRepository->create($input);

        Flash::success('تنبيه...تم حفظ مجموعه المراحل بنجاح.');

        return redirect(route('satgeCategories.index'));
    }

    /**
     * Display the specified satge_category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $satgeCategory = $this->satgeCategoryRepository->find($id);

        if (empty($satgeCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه المراحل');

            return redirect(route('satgeCategories.index'));
        }

        return view('satge_categories.show')->with('satgeCategory', $satgeCategory);
    }

    /**
     * Show the form for editing the specified satge_category.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $satgeCategory = $this->satgeCategoryRepository->find($id);

        if (empty($satgeCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه المراحل');

            return redirect(route('satgeCategories.index'));
        }

        return view('satge_categories.edit')->with('satgeCategory', $satgeCategory);
    }

    /**
     * Update the specified satge_category in storage.
     *
     * @param int $id
     * @param Updatesatge_categoryRequest $request
     *
     * @return Response
     */
    public function update($id, Updatesatge_categoryRequest $request)
    {
        $satgeCategory = $this->satgeCategoryRepository->find($id);

        if (empty($satgeCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه المراحل');

            return redirect(route('satgeCategories.index'));
        }

        $satgeCategory = $this->satgeCategoryRepository->update($request->all(), $id);

        Flash::success('تنبيه...تم تعديل مجموعه المراحل بنجاح.');

        return redirect(route('satgeCategories.index'));
    }

    /**
     * Remove the specified satge_category from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $satgeCategory = $this->satgeCategoryRepository->find($id);

        if (empty($satgeCategory)) {
            Flash::error('عفوآ...لم يتم العثور على مجموعه المراحل');

            return redirect(route('satgeCategories.index'));
        }
        $check = Stage::where('stage_category_id',$id)->get();

        if(count($check)>0){
            Flash::error('  لا يمكن حذف مجموعة المراحل لوجود بيانات مدرجه   ');
    
            return redirect(route('satgeCategories.index'));
        }else{

        $this->satgeCategoryRepository->delete($id);

        Flash::success('تم الحذف مجموعه المراحل بنجاح');

        return redirect(route('satgeCategories.index'));
        }
    }
}
