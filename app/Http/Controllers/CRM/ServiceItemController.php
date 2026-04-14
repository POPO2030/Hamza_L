<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ServiceItemDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateServiceItemRequest;
use App\Http\Requests\CRM\UpdateServiceItemRequest;
use App\Repositories\CRM\ServiceItemRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\Service;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\Stage;
use App\Models\CRM\ServiceItemSatge;

class ServiceItemController extends AppBaseController
{
    /** @var ServiceItemRepository $serviceItemRepository*/
    private $serviceItemRepository;

    public function __construct(ServiceItemRepository $serviceItemRepo)
    {
        $this->serviceItemRepository = $serviceItemRepo;
    }

    /**
     * Display a listing of the ServiceItem.
     *
     * @param ServiceItemDataTable $serviceItemDataTable
     *
     * @return Response
     */
    public function index(ServiceItemDataTable $serviceItemDataTable)
    {
        return $serviceItemDataTable->render('service_items.index');
    }

    /**
     * Show the form for creating a new ServiceItem.
     *
     * @return Response
     */
    public function create()
    {

        $services = Service::pluck('name','id');
        $stages = Stage::all();
        return view('service_items.create')->with(['services'=>$services,'stages'=>$stages]);
    }

    /**
     * Store a newly created ServiceItem in storage.
     *
     * @param CreateServiceItemRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceItemRequest $request)
    {
        
        $input = $request->all();
        if($request->price > 0){
        $input['price'] = $request->price;
        }else
        {
         $input['price'] = '0';
        }
        // return  $input['price'];
        $serviceItem = $this->serviceItemRepository->create($input);
        $serviceItem->get_stage()->attach($request->stage_id);

        Flash::success('تم الحفظ');

        return redirect(route('serviceItems.index'));
    }

    /**
     * Display the specified ServiceItem.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceItem = $this->serviceItemRepository->find($id);

        if (empty($serviceItem)) {
            Flash::error('لا يوجد بيانات');

            return redirect(route('serviceItems.index'));
        }

        return view('service_items.show')->with('serviceItem', $serviceItem);
    }

    /**
     * Show the form for editing the specified ServiceItem.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {        
        

        $serviceItem = ServiceItem::with('get_stage:name,id')->find($id);
        
        $selectedStages_id = ServiceItemSatge::where('service_item_id',$id)->distinct()->pluck('satge_id')->toArray();
        $selectedStages = Stage::whereIn('id', $selectedStages_id)->orderByRaw('FIELD(id, ' . implode(',', $selectedStages_id) . ')')->pluck('name', 'id')->toArray();

        // $selectedStages = ServiceItemSatge::where('service_item_id',$id)->pluck('satge_id')->toArray();
        $services = Service::pluck('name','id');
        $stages = Stage::all();

        // return $selectedStages;
        if (empty($serviceItem)) {
            Flash::error('لا يوجد بيانات');

            return redirect(route('serviceItems.index'));
        }

        return view('service_items.edit')->with(['serviceItem'=> $serviceItem , 'services'=>$services , 'stages'=>$stages,'selectedStages'=>$selectedStages]);
    }

    /**
     * Update the specified ServiceItem in storage.
     *
     * @param int $id
     * @param UpdateServiceItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceItemRequest $request)
    {

        $serviceItem = $this->serviceItemRepository->find($id);
        
        if (empty($serviceItem)) {
            Flash::error('لا يوجد بيانات');

            return redirect(route('serviceItems.index'));
        }
        $serviceItem->get_stage()->sync($request->stage_id);
        $serviceItem = $this->serviceItemRepository->update($request->all(), $id);

        Flash::success('تم التعديل بنجاح');

        return redirect(route('serviceItems.index'));
    }

    /**
     * Remove the specified ServiceItem from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceItem = $this->serviceItemRepository->find($id);

        if (empty($serviceItem)) {
            Flash::error('لا يوجد بيانات');

            return redirect(route('serviceItems.index'));
        }

        $this->serviceItemRepository->delete($id);

        ServiceItemSatge::where('service_item_id',$id)->delete();

        Flash::success('تم الحذف');

        return redirect(route('serviceItems.index'));
    }
}
