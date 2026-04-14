@extends('layouts.app')


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>اضافه في اليوميه</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'treasuryDetails.store','id'=>'create','enctype'=>'multipart/form-data']) !!}
            

            <div class="card-body">

                <div class="row">
                    @include('treasury_details.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('treasuryDetails.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_checks.js') }}"></script>
{{-- form validate --}}
{{-- <script src="{{ asset('js/views_js/recevie_receipts_validate.js') }}"></script> --}}



@endpush


