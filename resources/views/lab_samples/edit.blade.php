@extends('layouts.app')

@section('title')
    {{__('تعديل استلام العينات')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        <i class="fas fa-flask heart-beat"></i>
                        تعديل استلام العينات
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}
        
        <div class="card">

            {!! Form::model($labSample, ['route' => ['labSamples.update', $labSample->id], 'method' => 'patch' ,'enctype'=>'multipart/form-data','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('lab_samples.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('labSamples.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection


@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_lab_samples.js') }}"></script>
{{-- form validate --}}
<script src="{{ asset('js/views_js/lab_samples_validate.js') }}"></script>