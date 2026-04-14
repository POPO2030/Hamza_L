<?php

namespace App\Http\Controllers\accounting;

use App\DataTables\Payment_typeDataTable;
use App\Http\Requests\accounting;
use App\Http\Requests\accounting\CreatePayment_typeRequest;
use App\Http\Requests\accounting\UpdatePayment_typeRequest;
use App\Repositories\accounting\Payment_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class Payment_typeController extends AppBaseController
{
    /** @var Payment_typeRepository $paymentTypeRepository*/
    private $paymentTypeRepository;

    public function __construct(Payment_typeRepository $paymentTypeRepo)
    {
        $this->paymentTypeRepository = $paymentTypeRepo;
    }

    /**
     * Display a listing of the Payment_type.
     *
     * @param Payment_typeDataTable $paymentTypeDataTable
     *
     * @return Response
     */
    public function index(Payment_typeDataTable $paymentTypeDataTable)
    {
        return $paymentTypeDataTable->render('payment_types.index');
    }

    /**
     * Show the form for creating a new Payment_type.
     *
     * @return Response
     */
    public function create()
    {
        return view('payment_types.create');
    }

    /**
     * Store a newly created Payment_type in storage.
     *
     * @param CreatePayment_typeRequest $request
     *
     * @return Response
     */
    public function store(CreatePayment_typeRequest $request)
    {
        $input = $request->all();

        $paymentType = $this->paymentTypeRepository->create($input);

        Flash::success('Payment Type saved successfully.');

        return redirect(route('paymentTypes.index'));
    }

    /**
     * Display the specified Payment_type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            Flash::error('Payment Type not found');

            return redirect(route('paymentTypes.index'));
        }

        return view('payment_types.show')->with('paymentType', $paymentType);
    }

    /**
     * Show the form for editing the specified Payment_type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            Flash::error('Payment Type not found');

            return redirect(route('paymentTypes.index'));
        }

        return view('payment_types.edit')->with('paymentType', $paymentType);
    }

    /**
     * Update the specified Payment_type in storage.
     *
     * @param int $id
     * @param UpdatePayment_typeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayment_typeRequest $request)
    {
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            Flash::error('Payment Type not found');

            return redirect(route('paymentTypes.index'));
        }

        $paymentType = $this->paymentTypeRepository->update($request->all(), $id);

        Flash::success('Payment Type updated successfully.');

        return redirect(route('paymentTypes.index'));
    }

    /**
     * Remove the specified Payment_type from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $paymentType = $this->paymentTypeRepository->find($id);

        if (empty($paymentType)) {
            Flash::error('Payment Type not found');

            return redirect(route('paymentTypes.index'));
        }

        $this->paymentTypeRepository->delete($id);

        Flash::success('Payment Type deleted successfully.');

        return redirect(route('paymentTypes.index'));
    }
}
