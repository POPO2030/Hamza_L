<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\PlaceDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreatePlaceRequest;
use App\Http\Requests\CRM\UpdatePlaceRequest;
use App\Repositories\CRM\PlaceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\WorkOrder;

class PlaceController extends AppBaseController
{
    /** @var PlaceRepository $placeRepository*/
    private $placeRepository;

    public function __construct(PlaceRepository $placeRepo)
    {
        $this->placeRepository = $placeRepo;
    }

    /**
     * Display a listing of the Place.
     *
     * @param PlaceDataTable $placeDataTable
     *
     * @return Response
     */
    public function index(PlaceDataTable $placeDataTable)
    {
        return $placeDataTable->render('places.index');
    }

    /**
     * Show the form for creating a new Place.
     *
     * @return Response
     */
    public function create()
    {
        return view('places.create');
    }

    /**
     * Store a newly created Place in storage.
     *
     * @param CreatePlaceRequest $request
     *
     * @return Response
     */
    public function store(CreatePlaceRequest $request)
    {
        $input = $request->all();

        $place = $this->placeRepository->create($input);

        Flash::success('تم إنشاء المكان بنجاح');

        return redirect(route('places.index'));
    }

    /**
     * Display the specified Place.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $place = $this->placeRepository->find($id);

        if (empty($place)) {
            Flash::error('عفوآ...المكان غير موجود');

            return redirect(route('places.index'));
        }

        return view('places.show')->with('place', $place);
    }

    /**
     * Show the form for editing the specified Place.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $place = $this->placeRepository->find($id);

        if (empty($place)) {
            Flash::error('عفوآ...المكان غير موجود');

            return redirect(route('places.index'));
        }

        return view('places.edit')->with('place', $place);
    }

    /**
     * Update the specified Place in storage.
     *
     * @param int $id
     * @param UpdatePlaceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlaceRequest $request)
    {
        $place = $this->placeRepository->find($id);

        if (empty($place)) {
            Flash::error('عفوآ...المكان غير موجود');

            return redirect(route('places.index'));
        }

        $place = $this->placeRepository->update($request->all(), $id);

        Flash::success('تم تحديث المكان بنجاح');

        return redirect(route('places.index'));
    }

    /**
     * Remove the specified Place from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $place = $this->placeRepository->find($id);

        if (empty($place)) {
            Flash::error('عفوآ...المكان غير موجود');

            return redirect(route('places.index'));
        }

        $check = WorkOrder::where('place_id',$id)->get();

        if(count($check)>0){
            Flash::error('  لا يمكن حذف المكان لوجود غسلة له   ');

            return redirect(route('places.index'));
        }else{
            $this->placeRepository->delete($id);

            Flash::success('تم حذف المكان بنجاح');

            return redirect(route('places.index'));
        }
    }
}
