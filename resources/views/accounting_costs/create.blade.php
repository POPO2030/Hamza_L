@extends('layouts.app')

@section('title')
    {{__('انشاء تكلفة الغسلة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>انشاء تكلفة الغسلة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'accountingCosts.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('accounting_costs.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('accountingCosts.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection


<script src="{{ asset('js/jquery-3.6.0.min.js') }}" ></script>
<script src="{{ asset('js/views_js/accounting_costs.js') }}"></script>