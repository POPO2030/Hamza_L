@extends('layouts.app')

@section('title')
    {{__('مصادر القماش')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 ><i class="fas fa-stamp"></i> مصادر القماش</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('fabricSources.create') }}">
                        Add New
                    </a>
                </div> --}}
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                @include('fabric_sources.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

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