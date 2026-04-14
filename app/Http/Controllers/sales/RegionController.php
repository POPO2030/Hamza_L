<?php

namespace App\Http\Controllers\sales;

use App\DataTables\RegionDataTable;
use App\Http\Requests\sales;
use App\Http\Requests\sales\CreateRegionRequest;
use App\Http\Requests\sales\UpdateRegionRequest;
use App\Repositories\sales\RegionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use App\Models\sales\Customer_region;

class RegionController extends AppBaseController
{
    /** @var RegionRepository $regionRepository*/
    private $regionRepository;

    public function __construct(RegionRepository $regionRepo)
    {
        $this->regionRepository = $regionRepo;
    }

    /**
     * Display a listing of the Region.
     *
     * @param RegionDataTable $regionDataTable
     *
     * @return Response
     */
    public function index(RegionDataTable $regionDataTable)
    {
        return $regionDataTable->render('regions.index');
    }

    /**
     * Show the form for creating a new Region.
     *
     * @return Response
     */
    public function create()
    {
        return view('regions.create');
    }

    /**
     * Store a newly created Region in storage.
     *
     * @param CreateRegionRequest $request
     *
     * @return Response
     */
    public function store(CreateRegionRequest $request)
    {
        $input = $request->all();
        $input['creator_id'] = Auth::user()->id;

        $region = $this->regionRepository->create($input);


        return redirect(route('regions.index'))->with('success', trans('تنبيه ... تم انشاء المنطقة بنجاح'));
    }

    /**
     * Display the specified Region.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        return view('regions.show')->with('region', $region);
    }

    /**
     * Show the form for editing the specified Region.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $region = $this->regionRepository->find($id);

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        return view('regions.edit')->with('region', $region);
    }

    /**
     * Update the specified Region in storage.
     *
     * @param int $id
     * @param UpdateRegionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegionRequest $request)
    {
        $region = $this->regionRepository->find($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        if (empty($region)) {
            Flash::error('Region not found');

            return redirect(route('regions.index'));
        }

        $region = $this->regionRepository->update($input, $id);



        return redirect(route('regions.index'))->with('success', trans('تنبيه.... تم تعديل المنطقة بنجاح'));
    }

    /**
     * Remove the specified Region from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $region = $this->regionRepository->find($id);

        $check = Customer_region::where('region_id',$id)->get();
        if(count($check)>0){
    
            return redirect(route('regions.index'))->with('error', trans('عفوآ...لا يمكن حذف المنطقة لأرتباطها بعملاء اخرين'));
        }else{

        $this->regionRepository->delete($id);

        return redirect(route('regions.index'))->with('success', trans('تنبيه ... تم الحذف بنجاح'));
        }
    }
}
