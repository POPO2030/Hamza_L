@extends('layouts.app')

@section('title')
    {{__('إنشاء اذن اضافة جديد')}}
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
 </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 ><i class="fas fa-receipt"></i> إنشاء اذن اضافة جديد</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'receiveReceipts.store','id'=>'create','enctype'=>'multipart/form-data']) !!}

            <div class="card-body">

                <div class="row">
                    @include('receive_receipts.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}

                <a href="{{ route('receiveReceipts.index') }}" class="btn btn-default">إلغاء</a>
            </div>
            <div class="col"></div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_recevie_receipts.js') }}"></script>
{{-- form validate --}}
<script src="{{ asset('js/views_js/recevie_receipts_validate.js') }}"></script>

<script>
  $(document).ready(function() {
// ----------------------------------------------------------------------------
// hide to element depend on Team ID
var teamId = {{ Auth::user()->team_id }};

if (teamId === 1||teamId === 2) {
    var element = document.getElementById('final_weight');
var final_count = document.getElementById('final_count');
if (element !== null && final_count !== null) {
  element.style.display = 'none';
  final_count.style.display = 'none';
}
}

        });
</script>

@endpush








  
