@extends('layouts.app')

@section('title')
    {{__('انشاء مكان التخزين')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 ><i class="fas fa-map"></i> انشاء مكان التخزين</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'places.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('places.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('places.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script>
    $( document ).ready(function() {
    $('#create').submit(function() {
                $('input[type=submit]', this).prop("disabled", true);
    });
    // ================================================
    $(document).on('keyup', function(e) {
        // f2
  if (e.key == "F2") $('.save').click();
});
});
    </script>
