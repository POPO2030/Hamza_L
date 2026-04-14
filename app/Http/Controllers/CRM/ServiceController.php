<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ServiceDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateServiceRequest;
use App\Http\Requests\CRM\UpdateServiceRequest;
use App\Repositories\CRM\ServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\ServiceCategory;
use App\Models\CRM\ServiceItem;

class ServiceController extends AppBaseController
{
    /** @var ServiceRepository $serviceRepository*/
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the Service.
     *
     * @param ServiceDataTable $serviceDataTable
     *
     * @return Response
     */
    public function index(ServiceDataTable $serviceDataTable)
    {
        return $serviceDataTable->render('services.index');
    }

    /**
     * Show the form for creating a new Service.
     *
     * @return Response
     */
    public function create()
    {
        $cats = ServiceCategory::pluck('name','id');
        return view('services.create')->with('cats',$cats);
        
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param CreateServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceRequest $request)
    {
        $input = $request->all();

        $service = $this->serviceRepository->create($input);

        Flash::success('تم الحفظ بنجاح');

        return redirect(route('services.index'));
    }

    /**
     * Display the specified Service.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('البيانات غير موجوده');

            return redirect(route('services.index'));
        }

        return view('services.show')->with('service', $service);
    }

    /**
     * Show the form for editing the specified Service.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->find($id);
        $cats = ServiceCategory::pluck('name','id');

        if (empty($service)) {
            Flash::error('البيانات غير موجوده');

            return redirect(route('services.index'));
        }

        return view('services.edit')->with(['service'=> $service , 'cats'=>$cats]);
    }

    /**
     * Update the specified Service in storage.
     *
     * @param int $id
     * @param UpdateServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceRequest $request)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('البيانات غير موجوده');

            return redirect(route('services.index'));
        }

        $service = $this->serviceRepository->update($request->all(), $id);

        Flash::success('تم التعديل بنجاح');

        return redirect(route('services.index'));
    }

    /**
     * Remove the specified Service from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('البيانات غير موجوده');

            return redirect(route('services.index'));
        }
        $check = ServiceItem::where('service_id',$id)->get();
        
        if(count($check)>0){
            Flash::error('لا يمكن الحذف  لاعتماده علي بيانات اخري في جدول عناصر الخدمات');
    
            return redirect(route('services.index'));
        }else{

        $this->serviceRepository->delete($id);

        Flash::success('تم الحذف بنجاح');

        return redirect(route('services.index'));
    }
}
}