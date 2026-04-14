@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('تعديل الغسلة')}}
@endsection

@push('third_party_stylesheets')
 <style>
  input[type="text"],
  input[type="number"],
  input[type="file"],
  select {
    height: 38px;
    font-size: medium;
  }
  #copy-button {
      display: none;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        height: 30px;
}
.input_holder{
       /* background-color: rgb(160, 157, 157);
        color: white;
        border: 1px solid white; */
        background-color: #e4e4e4;
        color: #0a0000;
        border: 1px solid #aaa;
        margin: 0 2px;
        border-radius: 4px;
        cursor: default;
        height: 30px;
        padding: 2px;
        direction: ltr;
    }
    .container_div{
        display: flex
    }
    #selected2Options{
        display: flex
    }
    .close_btn{
        border: none;padding:0;background:transparent;color: #999;cursor: pointer;margin: 0 5px;
    }
    .close_btn:hover {
        color: #000000;
    }
 </style>
@endpush
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fab fa-first-order heart-beat"></i>
                      تعديل الغسلة
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($workOrder, ['route' => ['workOrders.update', $workOrder->id], 'method' => 'patch','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('work_orders.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary', 'id' => 'onlysave']) !!}
                @if(Auth::user()->team_id != 8)
                {!! Form::submit('حفظ و طباعة', ['class' => 'btn btn-primary save', 'id' => 'save_print']) !!}
                @endif
                <a href="{{ route('workOrders.index') }}" class="btn btn-default">إلغاء</a>
            </div>
            <div class="col"></div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('third_party_scripts')


<script>
    var auth = {!! json_encode(Auth::user()) !!};
  </script>
  {{-- form validate --}}
<script src="{{ asset('js/views_js/workOrder_validate.js') }}"></script>

<script>
      $(document).ready(function () {
    var teamId = {{ Auth::user()->team_id }};
    console.log(product_weight.value);
    if (teamId === 3 ||teamId === 8 ||teamId === 15) {                              //team_id = 15  متابعة انتاج وتغليف وتقارير (محمد السيد)
        document.getElementById('customer_id').readOnly   = true;
        document.getElementById('receipts').readOnly   = true;
        document.getElementById('products').readOnly   = true;
        document.getElementById('colorthread').readOnly = true;
        document.getElementById('initial_product_count').readOnly = true;
        document.getElementById('service_item_id').disabled   = true;
        document.getElementById('fabric_id').disabled = true;
        document.getElementById('fabric_source_id').disabled = true;

        
        
    }
    if (teamId === 1 ||teamId === 2 || teamId === 4) {
        document.getElementById('places').readOnly   = true;
        document.getElementById('product_count').readOnly = true;
        document.getElementById('product_weight').readOnly = true;
    }
    // ------------------------------------------------------------------------------------------------------------
    // يوزر محمد السيد شوف بس مكان الوجبة ويعدله             team_id = 5 متابعة انتاج
    if (teamId === 5 ) {
        document.getElementById('customer_id').readOnly   = true;
        document.getElementById('receipts').readOnly   = true;
        document.getElementById('products').readOnly   = true;
        document.getElementById('colorthread').readOnly = true;
        document.getElementById('initial_product_count').readOnly = true;
        document.getElementById('service_item_id').disabled   = true;
        document.getElementById('product_count').readOnly = true;
        document.getElementById('product_weight').readOnly = true;
        document.getElementById('fabric_id').disabled = true;
        document.getElementById('fabric_source_id').disabled = true;
        
    }
//  -----------------------------------------------------------------------------------------------------------------------------
    // صلاحية المدير المالى
    if (teamId === 13 ) {                                           
        document.getElementById('customer_id').readOnly   = true;
        document.getElementById('receipts').readOnly   = true;
        document.getElementById('products').readOnly   = true;
        document.getElementById('colorthread').readOnly = true;
        document.getElementById('initial_product_count').readOnly = true;
        document.getElementById('product_count').readOnly = true;
        document.getElementById('product_weight').readOnly = true;
        document.getElementById('fabric_id').disabled = true;
        document.getElementById('fabric_source_id').disabled = true;
        document.getElementById('places').readOnly = true;

    }
});
</script>
@endpush
