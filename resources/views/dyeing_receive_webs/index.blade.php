@extends('layouts.app')

@section('title')
    {{__('الموديلات المرسلة من مصنع التفصيل')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-vest-patches"></i> الموديلات المرسلة من مصنع التفصيل</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('dyeingReceiveWebs.create') }}">
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
                @include('dyeing_receive_webs.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تفاصيل بيانات الاذن</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="readyForm" method="post" action="{{ URL('update_dyeingReceive') }}">
            @csrf <!-- Add CSRF token field if needed -->
        <div class="modal-body">
            <div class="row">
                <!-- Customer Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
                    <div id="customer_id-container">
                    <select name="customer_id" class="form-control item_id searchable" style="width: 100% !important;">
                        <option value="" disabled selected>اختر اسم العميل</option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('customer_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <span id="customer_id-error" class="error-message" style="color: red"></span>
                </div>

                {{-- <!-- Product Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('product_id', 'اسم الصنف: <span style="color: red">*</span>', [], false) !!}
                    <div id="product_id-container">
                    <select name="product_id" class="form-control item_id searchable" style="width: 100% !important;">
                        <option value="" disabled selected>اختر الصنف</option>
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
                    @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <span id="product_id-error" class="error-message" style="color: red"></span>
                </div> --}}

                <div class="form-group col-sm-12">
                    {!! Form::label('note_elsham1', 'ملحوظات:') !!}
                    {!! Form::textarea('note_elsham1', null, ['class' => 'form-control','maxlength' => 255, 'rows' => 3]) !!}
                </div>
                {{-- <input type="hidden" name="dyeing_requests_id" id="dyeing_requests_id"> --}}
                <input type="hidden" name="unique_key" id="unique_key">

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="submit" class="btn btn-primary">تأكيد</button>
        </div>
    </form>
      </div>
    </div>
  </div>


