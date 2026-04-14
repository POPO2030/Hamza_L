<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CRM\Deliver_order_details;
use App\Models\CRM\Security_deliver;
use Flash;

class SecurityDeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crm_views.security_deliver');
    }


    public function add_security_deliver(Request $request)
    {
        $data=Deliver_order_details::where('barcode',$request->barcode)->with('get_order')->first();
        return $data;
    }

    public function add_security_deliver_order(Request $request){
        $data=[];
        for ($i=0; $i <count($request->package_number) ; $i++) { 
            $data[$i]=[
                'deliver_order_id'=> $request->deliver_order_id[$i] ,
                'package_number'=>$request->package_number[$i] ,
                'count'=>$request->count[$i] ,
                'total'=>$request->total[$i],
                'barcode'=>$request->barcode[$i],
            ];
        }
        Security_deliver::insert($data);
        Flash::success('تنبيه تم تسليم الغسلة بنجاح');
        return redirect()->back();
    }


    public function show($id)
    {
        //
    }




    public function update(Request $request, $id)
    {
        //
    }


}
