@extends('layouts.app')

@section('title')
    {{__('الاصناف')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 > <i class="fas fa-vest"></i> الاصناف</h1>
                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                @include('products.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
<script>
    $( document ).ready(function() {
    // =======================================
    $(document).on('keyup', function(e) {
        // save "+"
  if (e.key == "+") $('.buttons-create').click();
});
    });
    </script>