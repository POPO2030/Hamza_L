<?php

namespace App\Http\Controllers\inventory;

use App\DataTables\Color_codeDataTable;
use App\Http\Requests\inventory;
use App\Http\Requests\inventory\CreateColor_codeRequest;
use App\Http\Requests\inventory\UpdateColor_codeRequest;
use App\Repositories\inventory\Color_codeRepository;
use App\Models\inventory\Color;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class Color_codeController extends AppBaseController
{
    /** @var Color_codeRepository $colorCodeRepository*/
    private $colorCodeRepository;

    public function __construct(Color_codeRepository $colorCodeRepo)
    {
        $this->colorCodeRepository = $colorCodeRepo;
    }

    /**
     * Display a listing of the Color_code.
     *
     * @param Color_codeDataTable $colorCodeDataTable
     *
     * @return Response
     */
    public function index(Color_codeDataTable $colorCodeDataTable)
    {
        return $colorCodeDataTable->render('color_codes.index');
    }

    /**
     * Show the form for creating a new Color_code.
     *
     * @return Response
     */
    public function create()
    {
        return view('color_codes.create');
    }

    /**
     * Store a newly created Color_code in storage.
     *
     * @param CreateColor_codeRequest $request
     *
     * @return Response
     */
    public function store(CreateColor_codeRequest $request)
    {
        $input = $request->all();

        $colorCode = $this->colorCodeRepository->create($input);

        return redirect(route('colorCodes.index'))->with('success', trans('تنبيه...تم حفظ كود اللون بنجاح'));
    }

    /**
     * Display the specified Color_code.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $colorCode = $this->colorCodeRepository->find($id);

        if (empty($colorCode)) {
            return redirect(route('colorCodes.index'))->with('error', trans('عفوآ...لم يتم العثور على كود اللون'));
        }

        return view('color_codes.show')->with('colorCode', $colorCode);
    }

    /**
     * Show the form for editing the specified Color_code.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $colorCode = $this->colorCodeRepository->find($id);

        if (empty($colorCode)) {
            return redirect(route('colorCodes.index'))->with('error', trans('عفوآ...لم يتم العثور على كود اللون'));
        }

        return view('color_codes.edit')->with('colorCode', $colorCode);
    }

    /**
     * Update the specified Color_code in storage.
     *
     * @param int $id
     * @param UpdateColor_codeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateColor_codeRequest $request)
    {
        $colorCode = $this->colorCodeRepository->find($id);

        if (empty($colorCode)) {
            return redirect(route('colorCodes.index'))->with('error', trans('عفوآ...لم يتم العثور على كود اللون'));
        }

        $colorCode = $this->colorCodeRepository->update($request->all(), $id);

        return redirect(route('colorCodes.index'))->with('success', trans('تنبيه...تم تعديل كود اللون بنجاح'));
    }

    /**
     * Remove the specified Color_code from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $colorCode = $this->colorCodeRepository->find($id);

        if (empty($colorCode)) {
            return redirect(route('colorCodes.index'))->with('error', trans('عفوآ...لم يتم العثور على كود اللون'));
        }


        $check = Color::where('color_code_id',$id)->get();
    
        if(count($check)>0){
    
            return redirect(route('colorCodes.index'))->with('error', trans('عفوآ...لا يمكن حذف كود اللون لأرتباطه بلون محدد')); 
        }else{
            $this->colorCodeRepository->delete($id);
    
            return redirect(route('colorCodes.index'))->with('success', trans('تنبيه...تم حذف كود اللون بنجاح'));
        }
   
   
   
    }
}
