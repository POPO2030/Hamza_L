@extends('layouts.app')

@section('title')
    {{__('حجز غسلة جديدة')}}
@endsection

@push('third_party_stylesheets')
 <style>
  input[type="text"],
  input[type="number"],
  input[type="file"],
  input[type="date"],
  select {
    height: 38px;
    font-size: medium;
  }
  .btn {
    margin: 0 !important;
  }
 </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-check-circle"></i> حجز غسلة جديدة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'reservations.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('reservations.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('reservations.index') }}" class="btn btn-default">الغاء</a>
            </div>
            <div class="col"></div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

  <script>
    var auth = {!! json_encode(Auth::user()) !!};
  </script>
  {{-- form validate --}}
  <script src="{{ asset('js/views_js/reservations_validate.js') }}"></script>
  <script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
  
    <script>
        $(document).ready(function() {
        $('#copy-button').click(function(e) {
            e.preventDefault(); 

            var selectedItems = $('#service_item_id option:selected').toArray();
            var selectedItemsText = selectedItems.map(function(option) {
                return $(option).text();
            }).join('  /  ');

            $('#note').val(selectedItemsText);
            
        });

    $('#service_item_id').change(function() {
        var selectedItems = $(this).find('option:selected').toArray();
        var selectedItemsText = selectedItems.map(function(option) {
            return $(option).text();
        }).join('  /  ');

        $('#note').val(selectedItemsText);
    });
});

</script>