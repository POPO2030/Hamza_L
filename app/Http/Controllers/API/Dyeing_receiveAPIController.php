<?php

namespace App\Http\Controllers\API;

use App\DataTables\Dyeing_receiveDataTable;
use App\Http\Requests\API\CreateDyeing_receiveAPIRequest;
use App\Http\Requests\API\UpdateDyeing_receiveAPIRequest;
use App\Models\CRM\Dyeing_receive;
use App\Repositories\CRM\Dyeing_receiveRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Dyeing_receiveController
 * @package App\Http\Controllers\API
 */

class Dyeing_receiveAPIController extends AppBaseController
{
    /** @var  Dyeing_receiveRepository */
    private $dyeingReceiveRepository;

    public function __construct(Dyeing_receiveRepository $dyeingReceiveRepo)
    {
        $this->dyeingReceiveRepository = $dyeingReceiveRepo;
    }

    /**
     * Display a listing of the Dyeing_receive.
     * GET|HEAD /dyeingReceives
     *
     * @param Request $request
     * @return Response
     */
    // public function index(Request $request)
    // {
    //     $dyeingReceives = $this->dyeingReceiveRepository->all(
    //         $request->except(['skip', 'limit']),
    //         $request->get('skip'),
    //         $request->get('limit')
    //     );

    //     return $this->sendResponse($dyeingReceives->toArray(), 'Dyeing Receives retrieved successfully');
    // }

    public function index(Dyeing_receiveDataTable $dyeingReceiveDataTable)
    {
        return $dyeingReceiveDataTable->render('dyeing_receives.index');
    }
 
    /**
     * Store a newly created Dyeing_receive in storage.
     * POST /dyeingReceives
     *
     * @param CreateDyeing_receiveAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDyeing_receiveAPIRequest $request)
    {

        //  return $request;
        $data = json_decode($request->getContent(), true);

        // Extract the request data and dyeing_requests_ids from the decoded JSON
        $request_data = $data['request'];
        $dyeing_requests_ids = $data['dyeing_requests_id'];
       
        // Process and store the received data
        $result = [];
        $product_count = count($request_data['product_id']);
        for ($i = 0; $i < $product_count; $i++) {
            $result[] = [
                'unique_key' => $request_data['unique_key'],
                'customer_name' => $request_data['customer_name'],
                'model' => $request_data['model_code'],
                'cloth_name' => $request_data['product_name'][$i],
                'product_name' => $request_data['finalproduct_name'],
                'product_color_id' => $request_data['product_id'][$i],//
                'quantity' => $request_data['quantity_out'][$i],
                'note_elsham2' => $request_data['note_elsham2'] ?? '',
                'created_at' => now(),
                'dyeing_requests_id' => $dyeing_requests_ids[$i]
            ];
        }

       $check= Dyeing_receive::insert($result);

        if($check){
            return $this->sendResponse(['success'=>true],'Dyeing Receive retrieved successfully');
        }else{
            return $this->sendResponse(['success'=>false,'message'=>'not done']);
        }
        
    }

    /**
     * Display the specified Dyeing_receive.
     * GET|HEAD /dyeingReceives/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Dyeing_receive $dyeingReceive */
        $dyeingReceive = $this->dyeingReceiveRepository->find($id);

        if (empty($dyeingReceive)) {
            return $this->sendError('Dyeing Receive not found');
        }

        return $this->sendResponse($dyeingReceive->toArray(), 'Dyeing Receive retrieved successfully');
    }

    /**
     * Update the specified Dyeing_receive in storage.
     * PUT/PATCH /dyeingReceives/{id}
     *
     * @param int $id
     * @param UpdateDyeing_receiveAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDyeing_receiveAPIRequest $request)
    {
        // $input = $request->all();

        // /** @var Dyeing_receive $dyeingReceive */
        // $dyeingReceive = $this->dyeingReceiveRepository->find($id);

        // if (empty($dyeingReceive)) {
        //     return $this->sendError('Dyeing Receive not found');
        // }

        // $dyeingReceive = $this->dyeingReceiveRepository->update($input, $id);
        Dyeing_receive::where('unique_key',$id)->delete();

        $result=[];
        for ($i=0; $i <count($request->product_name) ; $i++) { 


        $result[]=[
            'unique_key'=>$request->unique_key,
            'customer_name'=>$request->customer_name,
            'model'=>$request->model_code,
            'cloth_name'=>$request->product_name[$i],
            'product_name'=>$request->finalproduct_name,
            'quantity'=>$request->quantity_out[$i],
            'note_elsham2' => $request->note_elsham2 ?? '',
            'created_at'=>now(),
        ];

 
        }

       $check= Dyeing_receive::insert($result);
       if($check){
        return $this->sendResponse(['success'=>true],'تنبيه... تم تعديل الاذن بنجاح');
    }else{
        return $this->sendResponse(['success'=>false,'message'=>'not done']);
    }

        // return $this->sendResponse($dyeingReceive->toArray(), 'Dyeing_receive updated successfully');
    }

    /**
     * Remove the specified Dyeing_receive from storage.
     * DELETE /dyeingReceives/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Dyeing_receive $dyeingReceive */
       // $dyeingReceive = $this->dyeingReceiveRepository->find($id);
        
    
        // if (empty($dyeingReceive)) {
        //     return $this->sendError('Dyeing Receive not found');
        // }

        //$dyeingReceive->delete();

        Dyeing_receive::where('unique_key',$id)->delete();

        return $this->sendSuccess('Dyeing Receive deleted successfully');
    }
}
