@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/datatables_colors.css') }}"> --}}
@endpush

@section('title')
    {{__('اذن مرتجع بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-pallet"></i>
             اذن مرتجع بضاعه
        </h1>
    </div>
  </div>
</div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                @include('inv_import_orders_returns.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
{{-- ================================================modal fade=============================== --}}
<div id="myModal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" style=" align-items: flex-start;display: flex; justify-content: center; margin-top: 50px;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" style="color: #000">تحديد اذن مرتجع بضاعه</h5>
            </div>
            <div class="modal-body" id="mod">
         
                        {!! Form::open(['route' => 'invImportOrdersReturns.create','method' => 'get','id'=>'create']) !!}
                        <div class="card-body">
                            <div class="row">
                          
                                <!-- Name Field -->
                <div class="form-group col-sm-12">
                    {!! Form::label('name', 'كود اذن اضافة بضاعه: <span style="color: red">*</span>', ['style' => 'color: #000;'], false) !!}
                                <select class="form-control searchable" name="invimport_id" id="myselect2" >
                                  <option value="" disabled> اختر العميل
                                </option>
                                  @foreach($importorders_customers as $importorder)
                                        <option value="{{$importorder->id}}">
                                            {{$importorder->id}}
                                        </option>
                                    @endforeach
                                </select>
                               
                </div>
                
                            </div>
                        </div>
             
            </div>
            <div class="modal-footer">
                {!! Form::submit('بحث', ['class' => 'btn btn-primary btn-sm save']) !!}
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">الغاء</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>

@endsection





