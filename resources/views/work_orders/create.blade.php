@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}">

@section('title')
    {{__('انشاء الغسلة جديد')}}
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
  .btn {
    margin: 0 !important;
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
        direction: ltr
    }
    .container_div{
        display: flex
    }
    #selected2Options{
        display: flex
    }
    .close_btn{
        border: none;padding:0;background:transparent;color: #999;margin: 0 5px
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
             انشاء الغسلة جديد
            </h1>
                </div>
                <div class="col-sm-6">
                    <span   style="float: left;margin-left:10px">
                    {!! Form::label('remaining', ' المتبقى من اذن الاضافة:') !!}
           
                    <span class="badge badge-danger" id="remaining" style="font-size: large">{{ $remaining }}</span>
                </span>
                </div>
            </div>
        </div>
       
    </section>
  
    <div class="content px-3">
    
   
        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'workOrders.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('work_orders.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary', 'id' => 'onlysave']) !!}
             
                {!! Form::submit('حفظ و طباعة', ['class' => 'btn btn-primary save', 'id' => 'save_print']) !!}
           
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

    if (teamId === 1 ||teamId === 2 || teamId === 4) {
        document.getElementById('places').readOnly   = true;
        document.getElementById('div_place_id').style.display="none";
        document.getElementById('div_product_count').style.display="none";
        document.getElementById('div_product_weight').style.display="none";
        document.getElementById('product_count').readOnly = true;
        document.getElementById('product_weight').readOnly = true;
    }
// ==================================================================

//     $('#copy-button').click(function(e) {
//         e.preventDefault(); 

//         var selectedItems = $('#service_item_id option:selected').toArray();
//         var selectedItemsText = selectedItems.map(function(option) {
//             return $(option).text();
//         }).join('  /  ');

//         $('#note').val(selectedItemsText);
        
//     });

// $('#service_item_id').change(function() {
//     var selectedItems = $(this).find('option:selected').toArray();
//     var selectedItemsText = selectedItems.map(function(option) {
//         return $(option).text();
//     }).join('  /  ');

//     $('#note').val(selectedItemsText);
// });

});
</script>
    
@endpush
