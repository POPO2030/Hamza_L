<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\LabSampleDataTable;
use App\DataTables\LabSampleDataTable_lab_view;
use App\DataTables\LabSampleDataTable_lab_ReadySample;
use App\DataTables\LabSampleDataTable_tab_index;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateLabSampleRequest;
use App\Http\Requests\CRM\UpdateLabSampleRequest;
use App\Repositories\CRM\LabSampleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\CRM\Customer;
use App\Models\CRM\Product;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\LabActivity;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\Sample_stages;
use App\Models\CRM\LabSample;
use App\Models\CRM\FinalDeliver;
use App\Models\CRM\Fabric;
use App\Models\CRM\Fabric_source;
use Illuminate\Support\Facades\DB;
use Auth;

class LabSampleController extends AppBaseController
{
    use UploadTrait;
    /** @var LabSampleRepository $labSampleRepository*/
    private $labSampleRepository;

    public function __construct(LabSampleRepository $labSampleRepo)
    {
        $this->labSampleRepository = $labSampleRepo;
        
    }

    /**
     * Display a listing of the LabSample.
     *
     * @param LabSampleDataTable $labSampleDataTable
     *
     * @return Response
     */
    public function index(LabSampleDataTable $labSampleDataTable)
    {
      //  $data=LabSample::all();
      //  return $data;
        return $labSampleDataTable->render('lab_samples.index');
    }

    // للمعمل
    public function index2(LabSampleDataTable_lab_view $labSampleDataTable_lab_view)
    {

        return $labSampleDataTable_lab_view->render('lab_samples.lab_view');
    }

    // عينات جاهزة للتسليم
    public function index3(LabSampleDataTable_lab_ReadySample $labSampleDataTable_ReadySample)
    {

        return $labSampleDataTable_ReadySample->render('lab_samples.labReadySample');
    }

    // حركة العينات
    public function tab_index(LabSampleDataTable_tab_index $labSampleDataTable_tab_index)
    {

        return $labSampleDataTable_tab_index->render('lab_samples.tab_index');
    }

    // // حركة العينات
    // public function tab_index ()
    // {
    //     $result = LabSample::with(['get_activity_for_tab_index','get_customer:name,id','get_products:name,id'])->get();

    //     // return $result;
    //     return view('lab_samples.tab_index')->with(['result'=>$result]);
    // }

    /**
     * Show the form for creating a new LabSample.
     *
     * @return Response
     */
    public function create()
    {
    
        $customers = Customer::pluck('name','id');
        $products = Product::pluck('name','id');
        $service_items=ServiceItem::select('id','name')->get();

        $fabric_sources =Fabric_source::pluck('name','id');
        $fabrics =Fabric::pluck('name','id');
        return view('lab_samples.create')->with(['customers'=>$customers,'products'=>$products,'service_items'=>$service_items,'fabric_sources'=>$fabric_sources,
        'fabrics'=>$fabrics]);
    }

    /**
     * Store a newly created LabSample in storage.
     *
     * @param CreateLabSampleRequest $request
     *
     * @return Response
     */
    public function store(CreateLabSampleRequest $request)
    {
       
    $currentDate = date('y-m-d');
    $latestSerial = LabSample::latest()->first();
    $serialParts = explode('/', optional($latestSerial)->serial);

    $datePart = $serialParts[0] ?? '';
    $incPart = intval($serialParts[1] ?? 0);

    if ($datePart == $currentDate) {
        $incPart++; // Increment the counter if it's the same day.
    } else {
        $incPart = 1; // Reset the counter for a new day.
    }

    $serial = $currentDate . '/' . $incPart;

    $creator_id = Auth::user()->id;
    $creator_team_id = Auth::user()->team_id;
    $input = $request->all();

    // Upload file
    if ($request->img) {
        $imgs = [];
        for ($i = 0; $i < count($request->img); $i++) {
            $file_name = $this->upload_file($request->img[$i], 'uploads/lab_samples/', $i);
            array_push($imgs, 'uploads/lab_samples/' . $file_name);
        }
        $input['img'] = json_encode($imgs);
    }

    $input['creator_team_id'] = $creator_team_id;
    $input['creator_id'] = $creator_id;
    $input['status'] = 'open';
    $input['serial'] = $serial;

    $labSample = $this->labSampleRepository->create($input);

    if ($request->service_item_id) {
        $serviceItemSatges = ServiceItemSatge::whereIn('service_item_id', $request->service_item_id)->pluck('id')->toArray();
        $labSample->get_samples_stage()->attach($serviceItemSatges);
    }
  
   // ========================

        Flash::success('تم استلام العينات بنجاح');

        // return redirect(route('labSamples.index'));
        return redirect('labSamples/'. $labSample->id);
    }

    /**
     * Display the specified LabSample.
     *
     * @param int $id
     *
     * @return Response
     */
    public function lab_samples_show($id)
    {
        $labSample = $this->labSampleRepository->find($id);

        if (empty($labSample)) {
            Flash::error('Lab Sample not found');

            return redirect(route('labSamples.index'));
        }

        $temp=json_decode($labSample->img);

        return view('lab_samples.show')->with(['labSample'=> $labSample ,'temp'=>$temp]);
    }

    /**
     * Show the form for editing the specified LabSample.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $labSample = $this->labSampleRepository->find($id);
// return $labSample;
        if($labSample->status =='open' || $labSample->status =='pre_checked'){
            
        $customers = Customer::pluck('name','id');
        $products = Product::pluck('name','id');
        $service_items=ServiceItem::select('id','name')->get();
        $service_item_ids = Sample_stages::where('sample_id',$id)->pluck('service_item_satge_id')->toArray();
        $selectedservice = ServiceItemSatge::whereIn('id',$service_item_ids)->distinct()->pluck('service_item_id')->toArray();
        
        $fabric_sources =Fabric_source::pluck('name','id');
        $fabrics =Fabric::pluck('name','id');
        // $labSample = $this->labSampleRepository->find($id);

            if($labSample->sample_original_count != Null)
                    $selectedsample= true;
            else
            $selectedsample= null;

        if (empty($labSample)) {
            Flash::error('Lab Sample not found');

            return redirect(route('labSamples.index'));
        }
// return $labSample;
            $temp=json_decode($labSample->img);

        } else{
            Flash::error('عفوا .... لايمكن التعديل حيث ان العينة / العينات تم تشغيلها');
            return redirect(route('labSamples.index'));
            }
            
        return view('lab_samples.edit')->with(['labSample'=>$labSample,
            'customers'=>$customers,
            'products'=>$products,
            'service_items'=>$service_items,
            'selectedservice'=>$selectedservice,
            'selectedsample'=>$selectedsample,
            'temp'=>$temp,
            'fabric_sources'=>$fabric_sources,
            'fabrics'=>$fabrics
        ]);
    }

    /**
     * Update the specified LabSample in storage.
     *
     * @param int $id
     * @param UpdateLabSampleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabSampleRequest $request)
    {
        $labSample = $this->labSampleRepository->find($id);

        if (empty($labSample)) {
            Flash::error('Lab Sample not found');

            return redirect(route('labSamples.index'));
        }

        if(!empty($request->service_item_id)) {
            $serviceItemSatges=ServiceItemSatge::whereIn('service_item_id',$request->service_item_id)->pluck('id')->toArray();
            $labSample->get_samples_stage()->sync($serviceItemSatges);
        }    
        if($request->img){
            $imgs=[];
            for ($i=0; $i <count($request->img) ; $i++) { 
                $file_name=$this->upload_file($request->img[$i],'uploads/lab_samples/',$i);
                array_push($imgs,'uploads/lab_samples/'.$file_name);
            }
        // --------------uplaod file-------
        $input=$request->all();
        $input['img'] = json_encode($imgs);
        $labSample = $this->labSampleRepository->update($input, $id);

    }else{
        $input=$request->all();
        $input['img']=$labSample->img;
        $labSample = $this->labSampleRepository->update($input, $id);
    }
        Flash::success('تم تعديل العينات بنجاح');

        return redirect(route('labSamples.index'));
    }

    /**
     * Remove the specified LabSample from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $labSample = $this->labSampleRepository->find($id);

        if($labSample->status =='open' || $labSample->status =='pre_checked'){

        $this->labSampleRepository->delete($id);

        } else{
            Flash::error('عفوا .... لايمكن الحذف حيث ان العينة / العينات تم تشغيلها');
            return redirect(route('labSamples.index'));
        }

        Flash::success('تم حذف العينات بنجاح');

        return redirect(route('labSamples.index'));
    }

    // للمعمل




//زرار يفتح مرحلة على المعمل
    public function labViewfollow(Request $request){
// return $request;
        // ========================
        $input=[];
        $input['creator_id']= Auth::user()->id;
        $input['creator_team_id']= Auth::user()->team_id;
        $input['status']= 'open';
        $input['sample_stage_id']= 52;
        $input['sample_id']=$request->sample_id;
        LabActivity::create($input);
        LabSample::where('id',$request->sample_id)->update([  'status'=>'pre_checked']);
        return redirect()->back();

    }

// استلام العينات المرسلة من خدمة العملاء
    public function labRecieveCheck(Request $request){
        
        LabActivity::where('sample_id',$request->sample_id)->where('sample_stage_id',52)->update([  'status'=>'checked']);
     
        LabSample::where('id',$request->sample_id)->update([  'status'=>'checked']);
        Flash::success('تنبيه...تم التحقق من استلام العينة بنجاح');
        return redirect()->route('labSamples_lab_view');
    }

// بدء تشغيل العينة
    public function labCloseSample(Request $request){
        
        LabActivity::where('sample_id',$request->sample_id)->where('sample_stage_id',52)->update([  'status'=>'progressing']);
     
        LabSample::where('id',$request->sample_id)->update([  'status'=>'progressing','date_progressing'=> now()]);
        Flash::success('تنبيه...تم بدء تشغيل العينة بنجاح');
        return redirect()->route('labSamples_lab_view');
    }


//انهاء تشغيل العينة من المعمل
public function labReadySample(Request $request) {
    //  return $request;
         DB::beginTransaction();
    try {
        
        // Update the LabActivity for the current sample
        LabActivity::where('sample_id', $request->sample_id)
            ->where('sample_stage_id', 52)
            ->update([
                'status' => 'closed',
                'closed_by_id' => Auth::user()->id,
                'closed_team_id' => Auth::user()->team_id,
                'receive_name' => $request->receive_name,
                'note' => $request->note,
            ]);

        // Create a new LabActivity for the next stage
        $newLabActivity = [
            'creator_id' => Auth::user()->id,
            'creator_team_id' => Auth::user()->team_id,
            'status' => 'open',
            'sample_stage_id' => 53,
            'sample_id' => $request->sample_id,
        ];
        LabActivity::create($newLabActivity);

        // Update the LabSample status
        LabSample::where('id', $request->sample_id)->update(['status' => 'pre_finish','date_finish'=> now()]);

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }
        // Flash message and redirection
        Flash::success('تنبيه.. تم الانتهاء من العينة بنجاح');
        return redirect()->route('labSamples_lab_view');
   
}

    //تأكيد الاستلام من خدمة العملاء
    public function labConfirmSample(Request $request) {
        try {
            // Update the LabActivity for the current sample
            LabActivity::where('sample_id', $request->sample_id)
                ->where('sample_stage_id', 53)
                ->update([
                    'status' => 'finish',
                    'closed_by_id' => Auth::user()->id,
                    'closed_team_id' => Auth::user()->team_id,
                ]);
    
            // Update the LabSample status
            LabSample::where('id', $request->sample_id)->update(['status' => 'finish']);
    
            // Flash message and redirection
            Flash::success('تنبيه.. تم تأكيد استلام العينة بنجاح');
            return redirect()->back();
        } catch (Exception $e) {
            // Handle the exception here (log it, show an error message, etc.)
            Flash::error('حدث خطأ أثناء معالجة البيانات');
            return back(); // Redirect back to the previous page
        }
    }
//عينات جاهزة للتسليم
//     public function labReadySampleView(){
        

//         $lab = LabSample::with(['get_activity_for_deliver','get_customer:name,id','get_products:name,id'])
//                   ->where(function ($query) {
//                       $query->where('status', 'pre_finish')
//                                  ->orWhere('status', 'finish');
//                   })->get();

// // return $lab;
//          return view('lab_samples.labReadySample')->with(['lab'=>$lab]);
//      }
     


    

     public function labDeliverSample(Request $request) {
        // return $request;
            DB::beginTransaction();
        try {
            // Update the LabActivity for the current sample
            LabActivity::where('sample_id', $request->sample_id)
                ->where('sample_stage_id', 53)
                ->where('status','finish')
                ->update([
                    'status' => 'closed',
                    'closed_by_id' => Auth::user()->id,
                    'closed_team_id' => Auth::user()->team_id,
                ]);
    
            // Update the LabSample status and receivable name
            LabSample::where('id', $request->sample_id)->update([
                'receivable_name' => $request->receivable_name,
                'status' => 'closed',
                'date_deliver'=> now()
            ]);
    
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
            // Flash message and redirection
            Flash::success('تنبيه...تم تسليم العينة بنجاح');
            return redirect()->back();
        
    }


//------------------------------------------------------------
//-----زراير tabs---------------------
        public function tab_all(Request $request){

        $result = LabSample::with(['get_activity_for_tab_index','get_customer:name,id','get_products:name,id']);
    
                if($request->status =='open'){
                     $result=$result->where('status',$request->status)->get();

                }elseif($request->status =='pre_checked'){
                    $result=$result->where('status',$request->status)->get();
                }elseif($request->status =='checked'){
                    $result=$result->where('status',$request->status)->get();
                }elseif($request->status =='progressing'){
                    $result=$result->where('status',$request->status)->get();
                }elseif($request->status =='pre_finish'){
                    $result=$result->where('status',$request->status)->get();
                }elseif($request->status =='finish'){
                    $result=$result->where('status',$request->status)->get();
                }elseif($request->status =='closed'){
                    $result=$result->where('status',$request->status)->get();
                }else

                $result=$result->get();
                
            return view('lab_samples.tab_index')->with(['result'=>$result]);
        }

        public function print($id){

            $labSample = LabSample::with(['get_customer:name,id','get_products:name,id','get_samples_stage.get_service_item'])->find($id);
            $temp = json_decode($labSample->img);
            // return $labSample;
            return view('lab_samples.print')->with(['labSample'=>$labSample, 'temp'=>$temp]);
        }



//   ===================================   رجوع العينة الى المعمل تانى ====================================
        public function return_sample_to_lab($id){
            
            LabActivity::where('sample_id', $id)
            ->where('sample_stage_id', 52)
            ->update([
                'status' => 'progressing',
                'closed_by_id' => null,
                'closed_team_id' => null,
                'receive_name' => null,
                'note' => null,
            ]);
            LabActivity::where('sample_id', $id)->where('sample_stage_id', 53)->delete();

            LabSample::where('id', $id)->update(['status' => 'progressing','date_finish'=> null]);

            Flash::success('تنبيه...تم عودة العينة للمعمل بنجاح');
            return redirect()->back();
        }
// ==============================================================================================================


       
}