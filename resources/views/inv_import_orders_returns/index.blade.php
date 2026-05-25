@extends('layouts.app')

@push('page_css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}">
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

               {{-- <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#myModal">
                    <i class="fas fa-plus"></i> اضافة مرتجع
                </button> --}}
                @include('inv_import_orders_returns.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
{{-- ================================================modal fade=============================== --}}
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
    <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 24px 64px rgba(0,0,0,0.18);">

      {{-- Header --}}
      <div class="modal-header" style="border-bottom: 1px solid #f0f0f0; padding: 18px 24px; align-items: center;">
        <div class="d-flex align-items-center gap-2">
          <div style="width:36px; height:36px; border-radius:8px; background:#EFF6FF; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <i class="fas fa-boxes" style="color:#3B82F6; font-size:16px;"></i>
          </div>
          <div style="margin-right: 10px;">
            <h6 class="modal-title mb-0" id="myModalLabel" style="font-size:15px; font-weight:600; color:#111;">تحديد اذن مرتجع بضاعه</h6>
            <p class="mb-0" style="font-size:12px; color:#9CA3AF;">اختر اذن استلام لإنشاء المرتجع</p>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق"
          style="background:#F9FAFB; border:1px solid #E5E7EB; border-radius:6px; opacity:1; padding:4px 8px; font-size:14px; color:#6B7280; margin-right: auto; margin-left: 0;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      {{-- Body --}}
      {!! Form::open(['route' => 'invImportOrdersReturns.create', 'method' => 'get', 'id' => 'create']) !!}
      <div class="modal-body" style="padding: 22px 24px 8px;">
        <div class="form-group mb-4">
          <label for="myselect2" style="font-size:13px; font-weight:500; color:#374151; margin-bottom:6px; display:block;">
            كود اذن اضافة بضاعه <span style="color:#EF4444;">*</span>
          </label>
          <div style="position:relative;">
            <span style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#9CA3AF; pointer-events:none;">
              <i class="fas fa-chevron-down" style="font-size:11px;"></i>
            </span>
            <select class="form-control searchable" name="invimport_id" id="myselect2"
              style="padding: 10px 36px 10px 14px; border-radius:8px; border:1px solid #E5E7EB; background:#F9FAFB; font-size:14px; color:#111; appearance:none; height:auto;width:100%;">
              <option value="" disabled selected>اختر الاذن</option>
              @foreach($importorders_suppliers as $importorder)
                <option value="{{ $importorder->id }}">
                  {{ $importorder->get_supplier->name . ' - ' . $importorder->id }}
                </option>
              @endforeach
            </select>
          </div>
          <small style="font-size:11.5px; color:#9CA3AF; margin-top:5px; display:block;">
            سيتم تحميل بيانات الاذن بعد الاختيار
          </small>
        </div>
      </div>

      {{-- Footer --}}
      <div class="modal-footer" style="border-top:1px solid #f0f0f0; padding:14px 24px 18px; justify-content:flex-start; gap:10px;">
        {!! Form::submit('بحث', ['class' => 'btn btn-sm', 'style' => 'background:#3B82F6; color:#fff; border:none; border-radius:8px; padding:9px 22px; font-size:14px; font-weight:500; display:inline-flex; align-items:center; gap:6px;']) !!}
        <button type="button" class="btn btn-sm" data-dismiss="modal"
          style="background:transparent; border:1px solid #E5E7EB; border-radius:8px; color:#6B7280; padding:9px 18px; font-size:14px;">
          الغاء
        </button>
      </div>
      {!! Form::close() !!}

    </div>
  </div>
</div>

@endsection





