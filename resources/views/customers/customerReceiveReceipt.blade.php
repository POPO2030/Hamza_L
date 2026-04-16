
@extends('layouts.app')

@section('title')
    {{__('اذونات الاضافة من العميل')}}
@endsection

@push('third_party_stylesheets')
    @include('customers.css')
    <style>
        .btn-info:hover{
            font-size: 14px;
            font-weight: bold;
        }
        .row{
          flex-wrap:nowrap;
        }
    </style>
@endpush


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users"></i> اذونات الاضافة من العميل &nbsp; &nbsp; ( {{ $customer_name }} )</h1>
                    
                </div>
                <div class="col-12 col-sm-6" style="display: flex; justify-content: left; align-items: center;">
                @can('receiveReceipts.create')
                    <a class="btn btn-primary buttons-create" href="{{ URL('receiveReceipts/create', $customer_id) }}"
                    style="margin-right: 10px;">اضافة اذن اضافة</a>
                    @endcan
                    <a class="btn btn-primary" style="margin-right: 10px;"
                    href="{{ route('customers.index') }}">
                     رجوع
                 </a>
                </div>
            </div>
        </div>
    </section>


    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
              <table id="table1" class="table table-striped custom-table-width" style="width: 100%;">
                <thead>
                  <tr>
                    <th scope="col" style="text-align: inherit;">م</th>
                    <th scope="col" style="text-align: inherit;">رقم الاذن</th>
                    <th scope="col" style="text-align: inherit;">الصنف</th>
                    <th scope="col" style="text-align: inherit;">رقم الموديل</th>
                    <th scope="col" style="text-align: inherit;">العدد المبدئى</th>
                    <th scope="col" style="text-align: inherit;">الوزن الفعلى</th>
                    <th scope="col" style="text-align: inherit;">العدد الفعلى</th>
                    <th scope="col" style="text-align: inherit;">التاريخ</th>
                    {{-- <th scope="col" style="text-align: inherit;">الفرع</th> --}}
                    <th scope="col" style="text-align: inherit;"> الغسلات</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <div class="card-footer clearfix">
                <div class="float-right">
                </div>
              </div>
            </div>
          </div>
          
    </div>

@endsection

@push('third_party_scripts')
    @include('customers.script')
    
@endpush

    <!--script blongs to hold submit button from multi submit -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
  <script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
  <script>
    $( document ).ready(function() {
      $(document).on('keyup', function(e) {
          // save "F2"
        if (e.key == "+") $('.buttons-create').get(0).click();
      });
    });
  </script>