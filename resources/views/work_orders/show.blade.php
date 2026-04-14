@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{__('تفاصيل الغسلة')}}
@endsection

<style>
      #datatable {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
    background-color: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  #datatable th {
    background-color: #00bcd4;
    color: #ffffff;
    text-align: center;
    padding: 12px;
    font-size: 1rem;
  }

  #datatable td {
    padding: 15px;
    text-align: center;
    font-weight: bold;
    color: #343a40;
  }

  /* Status Badges */
  .badge {
    padding: 8px 12px;
    font-size: 0.9rem;
    border-radius: 12px;
    display: inline-block;
  }

  .badge-warning {
    background-color: #ffc107;
    color: #212529;
  }

  .badge-success {
    background-color: #28a745;
    color: #ffffff;
  }

  /* Hover effect */
  #datatable tbody tr:hover {
    background-color: #e9f4ff;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    #datatable th, #datatable td {
      display: block;
      width: 100%;
      text-align: left;
      padding-left: 20px;
      border-bottom: 1px solid #e0e0e0;
    }

    #datatable th {
      background-color: #00bcd4;
      color: #ffffff;
      font-weight: bold;
    }
  }

    .boxx{
        border: 1px solid;
        padding: 10px;
        box-shadow: 3px 5px #888888;
    }
    .note{
        border:1px solid gray;
        border-radius:10px 0 10px 0;
        margin:1rem 0;
        padding:1rem
    }
    .btn-info:hover,.btn-primary:hover{
            font-size: 14px;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
    /* Styles for screens with a maximum width of 768px */
    table {
      font-size: 12px;
    }
  }

  @media screen and (max-width: 576px) {
    /* Styles for screens with a maximum width of 576px */
    table {
      font-size: 10px;
    }
  }

</style>


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @if($errors->any())
                <div class="col-12 bg-danger" style="height: 30px; font-size:18px; color:#ffffff; text-align:center;" >{{$errors->first()}}</div>
                @endif
            
                <div class="col-sm-6">
                    <h1 style="line-height: 50px;">
                        <i class="fab fa-first-order heart-beat"></i>
                    تفاصيل الغسلة
                </h1>
                </div>
            
                <div class="col-12 col-sm-6" style="display: flex; justify-content: left; align-items: center;">

                <ul class='nav nav-pills' style="padding:0">
                          <li>
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="color: #ffffff">عرض صورة الموديل</a>

                        </li>
                </ul>
                        
                    @if($workOrder->status == 'open' && $workOrder->product_count > 0)
                    <!-- Button trigger modal -->
                    @can('add_activity')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                        style="margin-right: 10px;">
                        ارسال الى قسم
                    </button>
                    @endcan
            
                    <!-- Button trigger modal -->
                    @can('add_not')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2"
                        style="margin-right: 10px;">
                        اضافة ملاحظة
                    </button>
                    @endcan

                    @can('close_work_order')
                    <a href="{{URL('close_work_order/'.$workOrder->id)}}" onclick="return confirm('هل ترغب فى اغلاق الغسلة');"
                        class="btn btn-primary" style="margin-right: 10px;">
                        اغلاق الغسلة
                    </a>
                     @endcan
                    @elseif($workOrder->status == 'closed' && $workOrder->product_count > 0)
                    @can('deliverOrders.create')
                    <a href="{{URL('deliverOrders/create',[$workOrder->receive_receipt_id ,$workOrder->id,$workOrder->get_customer->id, $workOrder->get_products->id, $workOrder->get_receivables->id])}}"
                        class="btn btn-primary" style="margin-right: 10px;">
                    التغليف
                    </a>
                    @endcan
                    @can('final_deliver_orders')
                    <a href="{{URL('deliverOrders_finance',[$workOrder->receive_receipt_id ,$workOrder->id,$workOrder->get_customer->id, $workOrder->get_products->id, $workOrder->get_receivables->id])}}"
                        class="btn btn-primary" style="margin-right: 10px;">
                    طباعة إذن التسليم
                    </a>
                    @endcan

                    @can('open_work_order')
                    <a href="{{URL('open_work_order/'.$workOrder->id)}}" onclick="return confirm('هل ترغب فى اعادة فتح الغسلة من جديد؟');"
                        class="btn btn-primary" style="margin-right: 10px;">
                        إعادة فتح الغسلة
                    </a>
                     @endcan
                    @endif
            
                   

                    <a class="btn btn-primary" style="margin-right: 10px;" href="{{ route('workOrders.index') }}">
                        رجوع
                    </a>
                </div>
            </div>
    
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('work_orders.show_fields')
                </div>
            </div>
        </div>
    </div>

@endsection
