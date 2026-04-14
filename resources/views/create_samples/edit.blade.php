@extends('layouts.app')

@section('title')
    {{__('تعديل رسبى عينة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تعديل رسبى عينة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        
        @include('flash::message')
        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($createSample, ['route' => ['createSamples.update', $id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="">
                    @include('create_samples.edit_fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary lg save']) !!}
                <a href="{{ route('createSamples.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
