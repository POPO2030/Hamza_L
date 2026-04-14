@extends('layouts.app')

@section('title')
    {{__('تعديل عناصر الخدمات')}}
@endsection

<style>
    .input_holder{
        /* background-color: rgb(160, 157, 157);
        color: white;
        border: 1px solid white; */
        background-color: #e4e4e4;
        color: #0a0000;
        border: 1px solid #aaa;
        margin: 0 2px;
        border-radius: 4px;
        cursor: default;
        height: 30px;
        padding: 2px;
        direction: ltr
    }
    .container_div{
        display: flex
    }
    #selected2Options{
        display: flex
    }
    .close_btn{
        border: none;padding:0;background:transparent;color: #999;margin: 0 5px
    }
    .close_btn:hover {
        color: #000000;
    }
 </style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="fas fa-eye-dropper"> تعديل عناصر الخدمات</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($serviceItem, ['route' => ['serviceItems.update', $serviceItem->id], 'method' => 'patch','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('service_items.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('serviceItems.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
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
