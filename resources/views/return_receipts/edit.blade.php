@extends('layouts.app')

@section('title')
    {{__('تعديل على إذن استلام مرتجع')}}
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
                    <h1><i class="fas fa-receipt"></i> تعديل على إذن استلام مرتجع</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($returnReceipt, ['route' => ['returnReceipts.update', $returnReceipt->id], 'method' => 'patch','enctype'=>'multipart/form-data','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('return_receipts.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('returnReceipts.index') }}"class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_return_receipts.js') }}"></script>
{{-- form validate --}}
<script src="{{ asset('js/views_js/return_receipts_validate.js') }}"></script>
<script>
  $(document).ready(function() {
// ----------------------------------------------------------------------------
            var teamId = {{ Auth::user()->team_id }};

if (teamId === 1 || teamId === 3 ) {
    document.getElementById('final_nweight').removeAttribute('readonly');
    document.getElementById('final_ncount').removeAttribute('readonly');
}

        });
</script>
    
@endpush