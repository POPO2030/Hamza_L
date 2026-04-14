@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        <i class="fas fa-link heart-beat"></i>
                        تعديل كود اللون
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($colorCode, ['route' => ['colorCodes.update', $colorCode->id], 'method' => 'patch','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('color_codes.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('colorCodes.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection


<!--script blongs to hold submit button from multi submit -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/views_js/color_code.js') }}"></script>
