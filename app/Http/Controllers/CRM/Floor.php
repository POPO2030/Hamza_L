<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CRM\Stage;
use App\Models\CRM\Activity;
use App\Models\CRM\WorkOrder;

class Floor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages=Stage::pluck('name','id');
        return view('crm_views.floor')->with('stages',$stages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find_stage_activity(Request $request)
    {
       $result = Activity::where('owner_stage_id',$request->stage_id)->where('status','open')->get();
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function oreders_followup(){
        $work_oreder_id=WorkOrder::pluck('id','id');
        return view('crm_views.oreders_followup')->with('work_oreder_id',$work_oreder_id);
    }
    
    public function get_wo_followup(Request $request){
        $result = Activity::where('work_order_id',$request->id)->where('status','open')->get();
        return $result;
    }
}
