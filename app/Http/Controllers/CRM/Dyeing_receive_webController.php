<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\Dyeing_receive_webDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateDyeing_receive_webRequest;
use App\Http\Requests\CRM\UpdateDyeing_receive_webRequest;
use App\Repositories\CRM\Dyeing_receive_webRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\CRM\Customer;
use App\Models\CRM\Product;
use App\Models\CRM\Dyeing_receive;

class Dyeing_receive_webController extends AppBaseController
{
    /** @var Dyeing_receive_webRepository $dyeingReceiveWebRepository*/
    private $dyeingReceiveWebRepository;

    public function __construct(Dyeing_receive_webRepository $dyeingReceiveWebRepo)
    {
        $this->dyeingReceiveWebRepository = $dyeingReceiveWebRepo;
    }

    /**
     * Display a listing of the Dyeing_receive_web.
     *
     * @param Dyeing_receive_webDataTable $dyeingReceiveWebDataTable
     *
     * @return Response
     */
    public function index(Dyeing_receive_webDataTable $dyeingReceiveWebDataTable)
    {
        $customers = Customer::select('name','id')->get();
        $products = Product::select('name','id')->get();
        return $dyeingReceiveWebDataTable->render('dyeing_receive_webs.index',['customers'=>$customers,'products'=>$products]);
    }

    /**
     * Show the form for creating a new Dyeing_receive_web.
     *
     * @return Response
     */
    public function create()
    {
        return view('dyeing_receive_webs.create');
    }

    /**
     * Store a newly created Dyeing_receive_web in storage.
     *
     * @param CreateDyeing_receive_webRequest $request
     *
     * @return Response
     */
    public function store(CreateDyeing_receive_webRequest $request)
    {
        $input = $request->all();

        $dyeingReceiveWeb = $this->dyeingReceiveWebRepository->create($input);

        Flash::success('Dyeing Receive Web saved successfully.');

        return redirect(route('dyeingReceiveWebs.index'));
    }

    /**
     * Display the specified Dyeing_receive_web.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dyeingReceiveWeb = $this->dyeingReceiveWebRepository->find($id);

        if (empty($dyeingReceiveWeb)) {
            Flash::error('Dyeing Receive Web not found');

            return redirect(route('dyeingReceiveWebs.index'));
        }

        return view('dyeing_receive_webs.show')->with('dyeingReceiveWeb', $dyeingReceiveWeb);
    }

    /**
     * Show the form for editing the specified Dyeing_receive_web.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $dyeingReceiveWeb = $this->dyeingReceiveWebRepository->find($id);

        if (empty($dyeingReceiveWeb)) {
            Flash::error('Dyeing Receive Web not found');

            return redirect(route('dyeingReceiveWebs.index'));
        }

        return view('dyeing_receive_webs.edit')->with('dyeingReceiveWeb', $dyeingReceiveWeb);
    }

    /**
     * Update the specified Dyeing_receive_web in storage.
     *
     * @param int $id
     * @param UpdateDyeing_receive_webRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDyeing_receive_webRequest $request)
    {
        $dyeingReceiveWeb = $this->dyeingReceiveWebRepository->find($id);

        if (empty($dyeingReceiveWeb)) {
            Flash::error('Dyeing Receive Web not found');

            return redirect(route('dyeingReceiveWebs.index'));
        }

        $dyeingReceiveWeb = $this->dyeingReceiveWebRepository->update($request->all(), $id);

        Flash::success('Dyeing Receive Web updated successfully.');

        return redirect(route('dyeingReceiveWebs.index'));
    }

    /**
     * Remove the specified Dyeing_receive_web from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dyeingReceiveWeb = $this->dyeingReceiveWebRepository->find($id);

        if (empty($dyeingReceiveWeb)) {
            Flash::error('Dyeing Receive Web not found');

            return redirect(route('dyeingReceiveWebs.index'));
        }

        $this->dyeingReceiveWebRepository->delete($id);

        Flash::success('Dyeing Receive Web deleted successfully.');

        return redirect(route('dyeingReceiveWebs.index'));
    }


    public function update_dyeingReceive(Request $request){

        Dyeing_receive::where('unique_key',$request->unique_key)->update([
            'customer_id'=>$request->customer_id,
           // 'product_id'=>$request->product_id,
            'note_elsham1' => $request->note_elsham1 ?? '',
            'status'=>'checked'
        ]);

        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://localhost:8000/api/dyeing_requests");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            if($server_output){
                Flash::success('تنبيه ... تم استلام الاذن بنجاح');

                return redirect(route('dyeingReceiveWebs.index'));
            }else{
                Flash::error('Dyeing Request saved successfully.');

                return redirect(route('dyeingReceiveWebs.index'));
            }

        // Flash::success('تنبيه ... تم استلام الاذن بنجاح');
        // return redirect(route('dyeingReceiveWebs.index'));
    }
}
