<!-- Work Order Id Field -->
<div class="col-sm-6">
    {!! Form::label('work_order_id', ' الغسلة:') !!}
    {{-- <p>{{ $accountingCost->work_order_id }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $accountingCost->work_order_id }}</span>
</div>

<!-- total_contract_quantity Field -->
<div class="col-sm-6">
    {!! Form::label('total_contract_quantity', ' كمية الغسلة:') !!}
    {{-- <p>{{ $accountingCost->total_contract_quantity }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $accountingCost->total_contract_quantity }}</span>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تم الانشاء:') !!}
    {{-- <p>{{ $accountingCost->created_at }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $accountingCost->created_at }}</span>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تم التعديل:') !!}
    {{-- <p>{{ $accountingCost->updated_at }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $accountingCost->updated_at }}</span>
</div>

{{-- <div class="row" id="adding" style="width: 100%"> --}}
    @if(isset($accountingCost->get_details))
  <table id="empTable" class="table table-border" style="text-align: center;">
      <tr>
          <td >البيان</td>
          <td >الوحده</td>
          <td >الكميه</td>
          <td >متوسط سعر التكلفة</td>
          <td >اجمالى</td>
      </tr>
    
      @foreach($accountingCost->get_details as $row)

      <tr>
        <td>
            <input type="text" value="{{$row->product_color->get_product->name}}"  class="form-control product_id" readonly style="text-align: center;">
        </td>

        <td>
            <input type="text" value="{{$row->get_unit->name}}" class="form-control unit_id" readonly style="text-align: center;">
        </td>
        <td>
            <input type="number" value="{{$row->product_quantity}}"  class="form-control product_quantity" readonly style="text-align: center;">
        </td>
        <td>
            <input type="text" value="{{$row->average_cost}}" class="form-control average_cost" readonly style="text-align: center;">
        </td>
        <td>
            <input type="text" value="{{$row->average_cost * $row->product_quantity}}" class="form-control average_cost" readonly style="text-align: center;">
        </td>

      </tr>
      
      @endforeach
   
  </table>
  @endif
  {{-- <span id="validationMessage" style="color: red;"></span> --}}
{{-- </div> --}}

<!-- operating_expenses Field -->
<div class="col-sm-4">
    {!! Form::label('operating_expenses', ' مصاريف التشغيل:') !!}
    {{-- <p>{{ $accountingCost->operating_expenses }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;">{{ $accountingCost->operating_expenses }}</span>
</div>

<!-- model_price Field -->
<div class="col-sm-4">
    {!! Form::label('model_price', ' اجمالي تكلفة الغسلة:') !!}
    {{-- <p>{{ $accountingCost->model_price }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;" >{{ $accountingCost->model_price }}</span>
</div>
<div class="col-sm-4">
    {!! Form::label('model_price', 'تكلفة القطعة:') !!}
    {{-- <p>{{ $accountingCost->model_price }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;font-weight: bold;" >{{ $accountingCost->model_price / $accountingCost->total_contract_quantity }}</span>
</div>

