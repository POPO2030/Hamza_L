<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ServiceCategoryDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateServiceCategoryRequest;
use App\Http\Requests\CRM\UpdateServiceCategoryRequest;
use App\Repositories\CRM\ServiceCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\CRM\Service;
use Response;

class ServiceCategoryController extends AppBaseController
{
    /** @var ServiceCategoryRepository $serviceCategoryRepository*/
    private $serviceCategoryRepository;

    public function __construct(ServiceCategoryRepository $serviceCategoryRepo)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepo;
    }

    /**
     * Display a listing of the ServiceCategory.
     *
     * @param ServiceCategoryDataTable $serviceCategoryDataTable
     *
     * @return Response
     */
    public function index(ServiceCategoryDataTable $serviceCategoryDataTable)
    {
        return $serviceCategoryDataTable->render('service_categories.index');
    }

    /**
     * Show the form for creating a new ServiceCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_categories.create');
    }

    /**
     * Store a newly created ServiceCategory in storage.
     *
     * @param CreateServiceCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceCategoryRequest $request)
    {
        $input = $request->all();

        $serviceCategory = $this->serviceCategoryRepository->create($input);

        Flash::success('تم الحفظ بنجاح');

        return redirect(route('serviceCategories.index'));
    }

    /**
     * Display the specified ServiceCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);

        if (empty($serviceCategory)) {
            Flash::error('لم يتم العثور علي مجوعه الخدمات');

            return redirect(route('serviceCategories.index'));
        }

        return view('service_categories.show')->with('serviceCategory', $serviceCategory);
    }

    /**
     * Show the form for editing the specified ServiceCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);

        if (empty($serviceCategory)) {
            Flash::error('لا يوجد مجموعه خدمات');

            return redirect(route('serviceCategories.index'));
        }

        return view('service_categories.edit')->with('serviceCategory', $serviceCategory);
    }

    /**
     * Update the specified ServiceCategory in storage.
     *
     * @param int $id
     * @param UpdateServiceCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceCategoryRequest $request)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);

        if (empty($serviceCategory)) {
            Flash::error('لم يتم العثو علي بيانات');

            return redirect(route('serviceCategories.index'));
        }

        $serviceCategory = $this->serviceCategoryRepository->update($request->all(), $id);

        Flash::success('تم التعديل بنجاج');

        return redirect(route('serviceCategories.index'));
    }

    /**
     * Remove the specified ServiceCategory from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceCategory = $this->serviceCategoryRepository->find($id);

        if (empty($serviceCategory)) {
            Flash::error('مجموعه الخدمات غير موجوده');

            return redirect(route('serviceCategories.index'));
        }
        $check = Service::where('service_category_id',$id)->get();
        
        if(count($check)>0){
            Flash::error('لا يمكن الحذف  لاعتماده علي بيانات اخري في جدول الخدمات');
    
            return redirect(route('serviceCategories.index'));
        }else{

        $this->serviceCategoryRepository->delete($id);

        Flash::error('تم الحذف بنجاح');

        return redirect(route('serviceCategories.index'));
    }
}



        }