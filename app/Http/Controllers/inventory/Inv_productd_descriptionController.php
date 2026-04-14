<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Inv_productd_descriptionDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateInv_productd_descriptionRequest;
use App\Http\Requests\inventory\UpdateInv_productd_descriptionRequest;
use App\Repositories\inventory\Inv_productd_descriptionRepository;
use App\Models\inventory\Inv_product;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

class Inv_productd_descriptionController extends AppBaseController
{
    /** @var Inv_productd_descriptionRepository $invProductdDescriptionRepository*/
    private $invProductdDescriptionRepository;

    public function __construct(Inv_productd_descriptionRepository $invProductdDescriptionRepo)
    {
        $this->invProductdDescriptionRepository = $invProductdDescriptionRepo;
    }

    /**
     * Display a listing of the Inv_productd_description.
     *
     * @param Inv_productd_descriptionDataTable $invProductdDescriptionDataTable
     *
     * @return Response
     */
    public function index(Inv_productd_descriptionDataTable $invProductdDescriptionDataTable)
    {
        return $invProductdDescriptionDataTable->render('inv_productd_descriptions.index');
    }

    /**
     * Show the form for creating a new Inv_productd_description.
     *
     * @return Response
     */
    public function create()
    {
        return view('inv_productd_descriptions.create');
    }

    /**
     * Store a newly created Inv_productd_description in storage.
     *
     * @param CreateInv_productd_descriptionRequest $request
     *
     * @return Response
     */
    public function store(CreateInv_productd_descriptionRequest $request)
    {
        $input = $request->all();
        $input['creator_id']= Auth::user()->id;
        $invProductdDescription = $this->invProductdDescriptionRepository->create($input);

        return redirect(route('invProductdDescriptions.index'))->with('success', trans('تنبيه...تم حفظ وصف المنتج بنجاح'));
    }

    /**
     * Display the specified Inv_productd_description.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $invProductdDescription = $this->invProductdDescriptionRepository->find($id);

        if (empty($invProductdDescription)) {
            return redirect(route('invProductdDescriptions.index'))->with('error', trans('عفوآ...لم يتم العثور على وصف المنتج')); 
        }

        return view('inv_productd_descriptions.show')->with('invProductdDescription', $invProductdDescription);
    }

    /**
     * Show the form for editing the specified Inv_productd_description.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $invProductdDescription = $this->invProductdDescriptionRepository->find($id);

        if (empty($invProductdDescription)) {
            return redirect(route('invProductdDescriptions.index'))->with('error', trans('عفوآ...لم يتم العثور على وصف المنتج')); 
        }

        return view('inv_productd_descriptions.edit')->with('invProductdDescription', $invProductdDescription);
    }

    /**
     * Update the specified Inv_productd_description in storage.
     *
     * @param int $id
     * @param UpdateInv_productd_descriptionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInv_productd_descriptionRequest $request)
    {
        $invProductdDescription = $this->invProductdDescriptionRepository->find($id);

        $input = $request->all();
        $input['updated_by']= Auth::user()->id;
        $invProductdDescription = $this->invProductdDescriptionRepository->update($input, $id);

        return redirect(route('invProductdDescriptions.index'))->with('success', trans('تنبيه...تم تعديل وصف المنتج بنجاح'));
    }

    /**
     * Remove the specified Inv_productd_description from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invProductdDescription = $this->invProductdDescriptionRepository->find($id);

        if (empty($invProductdDescription)) {

            return redirect(route('invProductdDescriptions.index'))->with('error', trans('عفوآ...لم يتم العثور على وصف المنتج')); 
        }
        $check = Inv_product::where('description_id',$id)->get();
        
        if(count($check)>0){

            return redirect(route('invProductdDescriptions.index'))->with('error', trans('عفوآ...لا يمكن حذف وصف المنتج لأرتباطها بمنتجات')); 
        }
        $this->invProductdDescriptionRepository->delete($id);

        return redirect(route('invProductdDescriptions.index'))->with('success', trans('تنبيه...تم حذف وصف المنتج بنجاح'));
    }
}
