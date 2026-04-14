<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\ReservationDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateReservationRequest;
use App\Http\Requests\CRM\UpdateReservationRequest;
use App\Repositories\CRM\ReservationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\Customer;
use App\Models\CRM\Product;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\reservation_stage;
use App\Models\CRM\ReceiveReceipt;
use App\Models\CRM\Reservation;
use App\Models\CRM\Place;
use App\Models\CRM\Receivable;
use App\Models\CRM\WorkOrder;

class ReservationController extends AppBaseController
{
    /** @var ReservationRepository $reservationRepository*/
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepo)
    {
        $this->reservationRepository = $reservationRepo;
    }

    /**
     * Display a listing of the Reservation.
     *
     * @param ReservationDataTable $reservationDataTable
     *
     * @return Response
     */
    public function index(ReservationDataTable $reservationDataTable)
    {
        return $reservationDataTable->render('reservations.index');
    }

    /**
     * Show the form for creating a new Reservation.
     *
     * @return Response
     */
    public function create()
    {
        $customers = Customer::pluck('name','id');
        $products = Product::pluck('name','id');
        $service_items=ServiceItem::select('id','name')->get();
        $receivables = Receivable::pluck('name','id');
        $old_work_orders= WorkOrder::pluck('id','id');
        return view('reservations.create')->with(['customers'=>$customers,'products'=>$products,'service_items'=>$service_items,'receivables'=>$receivables ,'old_work_orders'=>$old_work_orders]);
    }

    /**
     * Store a newly created Reservation in storage.
     *
     * @param CreateReservationRequest $request
     *
     * @return Response
     */
    public function store(CreateReservationRequest $request)
    {
        $input = $request->all();

        $reservation = $this->reservationRepository->create($input);


        $serviceItemSatges=ServiceItemSatge::whereIn('service_item_id',$request->service_item_id)->pluck('id')->toArray();
        $reservation->get_reservation_stage()->attach($serviceItemSatges);

        Flash::success('تنبيه تم حجز الغسلة بنجاح');

        return redirect(route('reservations.index'));
    }

    /**
     * Display the specified Reservation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reservation = $this->reservationRepository->find($id);

        if (empty($reservation)) {
            Flash::error('عفوآ...لم يتم العثور على الغسلة المحجوزة ');

            return redirect(route('reservations.index'));
        }
        $customers = Customer::pluck('name','id');
        $products = Product::pluck('name','id');
        $service_items=ServiceItem::select('id','name')->get();
        $receipts = ReceiveReceipt::where('customer_id',$reservation->customer_id)->where('status','open')->pluck('id','id');
        $places = Place::pluck('name','id');
        $receivables = Receivable::pluck('name','id');

        $service_item_ids = reservation_stage::where('reservation_id',$id)->pluck('service_item_satge_id')->toArray();
        $selectedservice = ServiceItemSatge::whereIn('id',$service_item_ids)->distinct()->pluck('service_item_id')->toArray();

        return view('reservations.show') ->with([
            'reservation'=> $reservation,
            'customers'=>$customers,
            'products'=>$products,
            'service_items'=>$service_items,
            'selectedservice'=>$selectedservice,
            'receipts'=>$receipts,
            'places'=>$places,
            'receivables'=>$receivables
        ]);
    }

    /**
     * Show the form for editing the specified Reservation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reservation = $this->reservationRepository->find($id);
        if (empty($reservation)) {
            Flash::error('عفوآ...لم يتم العثور على الغسلة المحجوزة ');

            return redirect(route('reservations.index'));
        }
        
        $customers = Customer::pluck('name','id');
        $products = Product::pluck('name','id');
        $service_items=ServiceItem::select('id','name')->get();
        $receivables = Receivable::pluck('name','id');
        $old_work_orders= WorkOrder::pluck('id','id');

    
        $service_item_ids = reservation_stage::where('reservation_id',$id)->pluck('service_item_satge_id')->toArray();
        $selectedservice = ServiceItemSatge::whereIn('id',$service_item_ids)->distinct()->pluck('service_item_id')->toArray();


        return view('reservations.edit')
        ->with([
            'reservation'=> $reservation,
            'customers'=>$customers,
            'products'=>$products,
            'service_items'=>$service_items,
            'selectedservice'=>$selectedservice,
            'receivables'=>$receivables,
            'old_work_orders'=>$old_work_orders
        ]);
    }

    /**
     * Update the specified Reservation in storage.
     *
     * @param int $id
     * @param UpdateReservationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReservationRequest $request)
    {
        $reservation = $this->reservationRepository->find($id);

        if (empty($reservation)) {
            Flash::error('عفوآ...لم يتم العثور على الغسلة المحجوزة ');

            return redirect(route('reservations.index'));
        }


        $serviceItemSatges=ServiceItemSatge::whereIn('service_item_id',$request->service_item_id)->pluck('id')->toArray();
        $reservation->get_reservation_stage()->sync($serviceItemSatges);

        $reservation = $this->reservationRepository->update($request->all(), $id);
        Flash::success('تنبيه..تم تحديث الحجز بنجاح.');

        return redirect(route('reservations.index'));
    }

    /**
     * Remove the specified Reservation from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reservation = $this->reservationRepository->find($id);

        if (empty($reservation)) {
            Flash::error('عفوآ...لم يتم العثور على الغسلة المحجوزة ');

            return redirect(route('reservations.index'));
        }

        $this->reservationRepository->delete($id);
        reservation_stage::where('reservation_id',$id)->delete();

        Flash::success('تنبيه...تم حذف الحجز بنجاح');

        return redirect(route('reservations.index'));
    }


    public function reservation_print($id){
        
        $reservation = Reservation::with(['get_customer:name,id','get_products:name,id','get_receivables:name,id','get_reservation_stage.get_service_item.get_category.get_category'])->find($id);
        // $work_order_services = Work_order_stage::with(['get_work_order_stage:name,id','get_work_order_service.get_category.get_category'])->where('work_order_id', $id)->get();
// return $reservation;

    $price = 0;
    $check=[];
  
    foreach($reservation->get_reservation_stage as $service) {
            
            if(in_array($service->get_service_item->id,$check)){

            }else{
                array_push($check , $service->get_service_item->id);
                $price += $service->get_service_item->price;
            }
        }
      
    
        return view('reservations.print')->with(['reservation'=> $reservation , 'price'=> $price]);
    }
}
