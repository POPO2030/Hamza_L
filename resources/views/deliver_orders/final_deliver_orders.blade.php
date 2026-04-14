
@extends('layouts.app')

@section('title')
    {{__('اذونات تسليم العملاء')}}
@endsection

{{-- @push('third_party_stylesheets')
    @include('deliver_orders.css')
    <style>
        .btn-info:hover{
            font-size: 14px;
            font-weight: bold;
        }
    </style>
@endpush --}}


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users"></i> اذونات تسليم العملاء</h1>
                </div>
                {{-- @can('receiveReceipts.create')
                <div style="margin:1rem 0">
                    <a class="btn btn-primary buttons-create" href="{{ URL('receiveReceipts/create', $customer_id) }}"
                    style="float: left;margin-left:10px">اضافة اذن اضافة</a>
                    </div>
                    @endcan --}}
            </div>
        </div>
    </section>


    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
              @include('deliver_orders.table')
              {{-- <table id="table1" class="table table-striped custom-table-width" style="width: 100%;">
                <thead>
                  <tr>
                    <th scope="col" style="text-align: inherit;">م</th>
                    <th scope="col" style="text-align: inherit;">رقم الاذن</th>
                    <th scope="col" style="text-align: inherit;"> الغسلة</th>
                    <th scope="col" style="text-align: inherit;">ايصال-الاضافة</th>
                    <th scope="col" style="text-align: inherit;">العميل</th>
                    <th scope="col" style="text-align: inherit;">الصنف </th>
                    <th scope="col" style="text-align: inherit;">التاريخ</th>
                    <th scope="col" style="text-align: inherit;"> طباعة الاذن</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table> --}}
              <div class="card-footer clearfix">
                <div class="float-right">
                </div>
              </div>
            </div>
          </div>
          
    </div>

@endsection

{{-- @push('third_party_scripts')
    @include('deliver_orders.script')
    
@endpush --}}

    {{-- <script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
    <script>
      $( document ).ready(function() {
    $(document).on('keyup', function(e) {
        // save "F2"
  if (e.key == "+") $('.buttons-create').get(0).click();
});
    });
        </script> --}}