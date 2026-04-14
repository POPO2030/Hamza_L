@extends('layouts.app')

@section('title')
    {{__('انشاء مصدر القماش')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 ><i class="fas fa-stamp"></i> مصادر القماش</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'fabricSources.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('fabric_sources.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('fabricSources.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection


@push('third_party_scripts')

<script src="{{ asset('js/views_js/fabric_sources.js') }}"></script>