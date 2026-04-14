<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\Create_sampleDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateCreate_sampleRequest;
use App\Http\Requests\CRM\UpdateCreate_sampleRequest;
use App\Repositories\CRM\Create_sampleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\LabSample;
use App\Models\CRM\LabActivity;
use App\Models\CRM\Stage;
use App\Models\CRM\Create_sample;
use App\Models\CRM\Service;
use App\Models\CRM\ServiceItem;
use App\Models\CRM\ServiceItemSatge;
use App\Models\CRM\Sample_stages;
use App\Models\CRM\Create_fashion_sample;
use Illuminate\Http\Request;
use App\Models\inventory\Inv_product;
use Illuminate\Support\Facades\DB;

class Create_sampleController extends AppBaseController
{
    /** @var Create_sampleRepository $createSampleRepository*/
    private $createSampleRepository;

    public function __construct(Create_sampleRepository $createSampleRepo)
    {
        $this->createSampleRepository = $createSampleRepo;
    }

    /**
     * Display a listing of the Create_sample.
     *
     * @param Create_sampleDataTable $createSampleDataTable
     *
     * @return Response
     */
    public function index(Create_sampleDataTable $createSampleDataTable)
    {
        $sample_id = LabSample::where('status','progressing')->pluck('serial','id');
        return $createSampleDataTable->render('create_samples.index',['sample_id'=>$sample_id]);
    }

    /**
     * Show the form for creating a new Create_sample.
     *
     * @return Response
     */
    public function create(Request $request)
    {
 
            $services = ServiceItem::pluck('name','id');

            $serviceCategory = Service::where('service_category_id',1)->pluck('id')->toArray();
            $services_ids = ServiceItem::whereIn('service_id',$serviceCategory)->pluck('id')->toArray();
            $stage_ids = ServiceItemSatge::whereIn('service_item_id',$services_ids)->select('satge_id')->distinct()->pluck('satge_id')->toArray();
            $stages = Stage::whereIn('id',$stage_ids)->select('id','name')->get();
        
            $sample_id = LabSample::where('id',$request->sample_id)->pluck('serial','id');
            $products = Inv_product::select('id','name')->get();
    
    
            // =================================fashion=========================
            $serviceCategory_fashion = Service::where('service_category_id',2)->pluck('id')->toArray();
            // $services_fashion__ids = ServiceItem::whereIn('service_id',$serviceCategory_fashion)->pluck('id')->toArray();
            // $stage_fashion_ids = ServiceItemSatge::whereIn('service_item_id',$services_fashion__ids)->select('satge_id')->distinct()->pluck('satge_id')->toArray();
            // $fashion_stages = Stage::whereIn('id',$stage_fashion_ids)->select('id','name')->get();
            $fashion_stages = Stage::select('id','name')->get();
         
            $fashion_products = Inv_product::select('id','name')->get();
       
            // =================================fashion=========================
            return view('create_samples.create')
            ->with([
                'fashion_stages'=>$fashion_stages,
                'fashion_products'=>$fashion_products,
                'sample_id'=>$sample_id ,
                 'stages'=>$stages,
                 'products'=>$products,
                 'services'=>$services
            ]);
        


    }





    public function create_redirect($sample_id)
    {
       
        $services = ServiceItem::pluck('name','id');

        $serviceCategory = Service::where('service_category_id',1)->pluck('id')->toArray();
        $services_ids = ServiceItem::whereIn('service_id',$serviceCategory)->pluck('id')->toArray();
        $stage_ids = ServiceItemSatge::whereIn('service_item_id',$services_ids)->select('satge_id')->distinct()->pluck('satge_id')->toArray();
        $stages = Stage::whereIn('id',$stage_ids)->select('id','name')->get();
    
        $sample_id = LabSample::where('id',$sample_id)->pluck('serial','id');
        $products = Inv_product::select('id','name')->get();


        // =================================fashion=========================
        $serviceCategory_fashion = Service::where('service_category_id',2)->pluck('id')->toArray();
        $services_fashion__ids = ServiceItem::whereIn('service_id',$serviceCategory_fashion)->pluck('id')->toArray();
        $stage_fashion_ids = ServiceItemSatge::whereIn('service_item_id',$services_fashion__ids)->select('satge_id')->distinct()->pluck('satge_id')->toArray();
        $fashion_stages = Stage::whereIn('id',$stage_fashion_ids)->select('id','name')->get();
        $fashion_products = Inv_product::select('id','name')->get();
   
        // =================================fashion=========================
        return view('create_samples.create')
        ->with([
            'fashion_stages'=>$fashion_stages,
            'fashion_products'=>$fashion_products,
            'sample_id'=>$sample_id ,
             'stages'=>$stages,
             'products'=>$products,
             'services'=>$services
        ]);


    }








    /**
     * Store a newly created Create_sample in storage.
     *
     * @param CreateCreate_sampleRequest $request
     *
     * @return Response
     */
    public function store(CreateCreate_sampleRequest $request)
    {
        // return $request;
        
        $successFlag = false; // Initialize a flag to track success

         if ($request->stage_id && $request->input('product_id_' . $request->stage_id[0])) {
                for ($i=0; $i <count($request->stage_id) ; $i++) { 
                    for ($x=0; $x <count($request->input('product_id_'.$request->stage_id[$i])) ; $x++) { 
                        Create_sample::create([
                            'sample_id'=>$request->sample_id,
                            'rec_index'=>$request->wash_rec_index[$i],
                            'stage_id'=>$request->stage_id[$i],
                            'product_id'=>$request->input('product_id_'.$request->stage_id[$i])[$x],
                            'ratio'=>$request->input('ratio_'.$request->stage_id[$i])[$x],
                            'degree'=>$request->input('degree_'.$request->stage_id[$i])[$x],
                            'water'=>$request->input('water_'.$request->stage_id[$i])[$x],
                            'time'=>$request->input('time_'.$request->stage_id[$i])[$x],
                            'ph'=>$request->input('ph_'.$request->stage_id[$i])[$x],
                            'note'=>1,
                            'flag'=>1,
                        ]);
                    }
                
            }
            $successFlag = true;
        }
             // ======================fashion=================
             if ($request->stage_fashion_id && $request->input('product_fashion_id_' . $request->stage_fashion_id[0])) {
                   
                    for ($i=0; $i <count($request->stage_fashion_id) ; $i++) { 
                    for ($x=0; $x <count($request->input('product_fashion_id_'.$request->stage_fashion_id[$i])) ; $x++) { 
                        Create_fashion_sample::create([
                            'sample_id'=>$request->sample_id,
                            'stage_id'=>$request->stage_fashion_id[$i],
                            'rec_index'=>$request->fashion_rec_index[$i],
                            'product_id'=>$request->input('product_fashion_id_'.$request->stage_fashion_id[$i])[$x],
                            'ratio'=>$request->input('ratio_fashion_'.$request->stage_fashion_id[$i])[$x],
                            'resolution'=>$request->input('resolution_fashion_'.$request->stage_fashion_id[$i])[$x],
                            'power'=>$request->input('power_fashion_'.$request->stage_fashion_id[$i])[$x],
                            'time'=>$request->input('time_fashion_'.$request->stage_fashion_id[$i])[$x],
                            'note'=>$request->input('note_fashion_'.$request->stage_fashion_id[$i])[$x],
                            'flag'=>2,
                        ]);
                    }
                
                   
               }
               $successFlag = true;
            }
            

            if ($successFlag) {
        Flash::success('تنبيه...تم إنشاء رسب العينة بنجاح');
        return redirect(route('createSamples.index'));
    } else {
        Flash::error('لم يتم اختيار مرحلة أو إضافة منتج للمرحلة');
        return redirect('create_redirect/' . $request->sample_id);
    }
    }

    /**
     * Display the specified Create_sample.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

//         $row = $this->createSampleRepository->find($id);
// return $row;
        // $createSample=Create_sample::where('sample_id',$id)->with('get_service_item')->get();
        $data1=Create_sample::where('sample_id',$id)->with('get_service_item')->get()->toArray();
        $data2=Create_fashion_sample::where('sample_id',$id)->with('get_service_item')->get()->toArray();

        $createSample=array_merge($data1,$data2);

        usort($createSample, function ($a, $b) {
            return $a['rec_index'] - $b['rec_index'];
        });
        // return $createSample;
        $stage_ids=Create_sample::where('sample_id',$id)->select('stage_id')->distinct()->pluck('stage_id');
        $services = ServiceItem::select('id','name')->get();
        // return $services;
        $stages = Stage::select('id','name')->get();
        $fashion_stages = Stage::select('id','name')->get();
        $sample_id = LabSample::where('id',$id)->pluck('serial','id');
        $products = Inv_product::select('id','name')->get();
        $fashion_products = Inv_product::select('id','name')->get();
        $serviceItem = sample_stages::where('sample_id', $id)
        ->with('get_samples_service')
        ->get();
    // return $serviceItem;
    $serviceItemsArray = []; 

    foreach ($serviceItem as $item) {
        $relatedServices = $item->get_samples_service->toArray();
        
        foreach ($relatedServices as $service) {
            $serviceId = $service['id'];
            if (!in_array($serviceId, array_column($serviceItemsArray, 'id'))) {
                $serviceItemsArray[] = $service;
            }
        }
    }
  

        return view('create_samples.show')->with([
            'id'=>$id,
            'createSample'=> $createSample,
            'sample_id'=>$sample_id ,
            'stages'=>$stages,
            'products'=>$products,
            'services'=>$services,
            'stage_ids'=>$stage_ids,
            'serviceItemsArray'=>$serviceItemsArray,
            'fashion_stages'=>$fashion_stages,
            'fashion_products'=>$fashion_products,
        ]);

    }

    /**
     * Show the form for editing the specified Create_sample.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $data1=Create_sample::where('sample_id',$id)->get()->toArray();
        $data2=Create_fashion_sample::where('sample_id',$id)->get()->toArray();

        $createSample=array_merge($data1,$data2);

        usort($createSample, function ($a, $b) {
            return $a['rec_index'] - $b['rec_index'];
        });

        // return $createSample;

        $stage_ids=Create_sample::where('sample_id',$id)->select('stage_id')->distinct()->pluck('stage_id');
        $services = ServiceItem::select('name','id')->get();
        $stages = Stage::select('id','name')->get();
        $fashion_stages = Stage::select('id','name')->get();
        $sample_id = LabSample::where('id',$id)->pluck('serial','id');
        $products = Inv_product::select('id','name')->get();
        $fashion_products = Inv_product::select('id','name')->get();

        return view('create_samples.edit')
        ->with([
            'id'=>$id,
            'createSample'=> $createSample,
            'sample_id'=>$sample_id ,
            'stages'=>$stages,
            'products'=>$products,
            'services'=>$services,
            'stage_ids'=>$stage_ids,
            'fashion_stages'=>$fashion_stages,
            'fashion_products'=>$fashion_products,

        ]);
    }

    /**
     * Update the specified Create_sample in storage.
     *
     * @param int $id
     * @param UpdateCreate_sampleRequest $request
     *
     * @return Response
     */
    public function update(Request $request , $id)
    {
        // return $request;
        // $createSample = Create_sample::where('sample_id', $id)->first();

        $successFlag = false; // Initialize a flag to track success


        $data1=Create_sample::where('sample_id',$id)->get()->toArray();
        $data2=Create_fashion_sample::where('sample_id',$id)->get()->toArray();

        $createSample=array_merge($data1,$data2);

        usort($createSample, function ($a, $b) {
            return $a['rec_index'] - $b['rec_index'];
        });

        $sampleModel = Create_sample::find($createSample[0]['id']);

        if (!empty($request->service_item_id)) {
            $serviceItemSatges = ServiceItemSatge::whereIn('service_item_id', $request->service_item_id)->pluck('id')->toArray(); 

            for ($i=0; $i <count($serviceItemSatges) ; $i++) {
                // Attach each record with the sample_id
                $sampleModel->get_sample_stage()->attach($serviceItemSatges[$i], ['sample_id' => $sampleModel['sample_id'] ]);
            }

        }else{
            DB::beginTransaction();
            try {
                $createSample = Create_sample::where('sample_id', $id)->delete();

                if ($request->stage_id && $request->input('product_id_' . $request->stage_id[0])) {
                        for ($i=0; $i <count($request->stage_id) ; $i++) { 
                            for ($x=0; $x <count($request->input('product_id_'.$request->stage_id[$i])) ; $x++) { 
                                Create_sample::create([
                                    'sample_id'=>$request->sample_id,
                                    'rec_index'=>$request->wash_rec_index[$i],
                                    'stage_id'=>$request->stage_id[$i],
                                    'product_id'=>$request->input('product_id_'.$request->stage_id[$i])[$x],
                                    'ratio'=>$request->input('ratio_'.$request->stage_id[$i])[$x],
                                    'degree'=>$request->input('degree_'.$request->stage_id[$i])[$x],
                                    'water'=>$request->input('water_'.$request->stage_id[$i])[$x],
                                    'time'=>$request->input('time_'.$request->stage_id[$i])[$x],
                                    'ph'=>$request->input('ph_'.$request->stage_id[$i])[$x],
                                    'note'=>1,
                                    'flag'=>1,
                                ]);
                            }
                        
                    }
                    $successFlag = true;
                }
            //     }else{
            //         Flash::error('لم يتم اختيار مرحل او اضافة رسبى للمرحلة');
            //        return redirect('create_redirect/'.$request->sample_id);
            //     }
            // }else{
            //     Flash::error('لم يتم اضافة مرحلة');
            //   return redirect('create_redirect/'.$request->sample_id);
            // }
                     // ======================fashion=================

                     $createFashionSample = Create_fashion_sample::where('sample_id', $id)->delete();

                     if ($request->stage_fashion_id && $request->input('product_fashion_id_' . $request->stage_fashion_id[0])) {
                           
                            for ($i=0; $i <count($request->stage_fashion_id) ; $i++) { 
                            for ($x=0; $x <count($request->input('product_fashion_id_'.$request->stage_fashion_id[$i])) ; $x++) { 
                                Create_fashion_sample::create([
                                    'sample_id'=>$request->sample_id,
                                    'stage_id'=>$request->stage_fashion_id[$i],
                                    'rec_index'=>$request->fashion_rec_index[$i],
                                    'product_id'=>$request->input('product_fashion_id_'.$request->stage_fashion_id[$i])[$x],
                                    'ratio'=>$request->input('ratio_fashion_'.$request->stage_fashion_id[$i])[$x],
                                    'resolution'=>$request->input('resolution_fashion_'.$request->stage_fashion_id[$i])[$x],
                                    'power'=>$request->input('power_fashion_'.$request->stage_fashion_id[$i])[$x],
                                    'time'=>$request->input('time_fashion_'.$request->stage_fashion_id[$i])[$x],
                                    'note'=>$request->input('note_fashion_'.$request->stage_fashion_id[$i])[$x],
                                    'flag'=>2,
                                ]);
                            }
                        
                           
                       }
                       $successFlag = true;
                    }
                //     }else{
                //         Flash::error('لم يتم اختيار مرحل او اضافة رسبى للمرحلة');
                //         return redirect('create_redirect/'.$request->sample_id);
                //     }
                // }else{
                //     Flash::error('لم يتم اضافة مرحلة');
                //     return redirect('create_redirect/'.$request->sample_id);
                // }
          
            // $createSample = $this->createSampleRepository->update($request->all(), $id);
    
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        }
        if ($successFlag) {
            Flash::success('تنبيه...تم إنشاء رسب العينة بنجاح');
            return redirect(route('createSamples.index'));
        } else {
            Flash::error('لم يتم اختيار مرحلة أو إضافة منتج للمرحلة');
            return redirect('create_redirect/' . $request->sample_id);
        }

        
    }

    /**
     * Remove the specified Create_sample from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        // $createSample = $this->createSampleRepository->find($id);

      $check= LabActivity::where('sample_id', $id)->where('sample_stage_id', 52)->where('status','closed')->get();
      if(count($check)>0){
        Flash::error('لايمكن حذف الرسبى بعد تسليم العينة لخدمة العملاء');
        return redirect()->back();
      }
        $createSample=Create_sample::where('sample_id',$id)->delete();
        $createFashionSample=Create_fashion_sample::where('sample_id',$id)->delete();

        Flash::success('تنبيه...تم حذف رسبى العينة بنجاح');

        return redirect(route('createSamples.index'));
    }


    public function update_service_item(Request $request , $id){

        Sample_stages::where('sample_id', $id)->delete();

        $data1=Create_sample::where('sample_id',$id)->get()->toArray();
        $data2=Create_fashion_sample::where('sample_id',$id)->get()->toArray();

        $createSample=array_merge($data1,$data2);

        usort($createSample, function ($a, $b) {
            return $a['rec_index'] - $b['rec_index'];
        });

        $sampleModel = Create_sample::find($createSample[0]['id']);
    
            $serviceItemSatges = ServiceItemSatge::whereIn('service_item_id', $request->service_item_id)->pluck('id')->toArray(); 
            for ($i=0; $i <count($serviceItemSatges) ; $i++) {
                // Attach each record with the sample_id
                $sampleModel->get_sample_stage()->attach($serviceItemSatges[$i], ['sample_id' => $sampleModel['sample_id'] ]);
            }
            Flash::success('تنبيه...تم تعديل رسبى العينة بنجاح');


            return redirect(route('createSamples.index'));
    }
}
