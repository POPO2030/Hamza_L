@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    td , tr{
        text-align: center
    }
        .hover-image {
            width: 100px;
            height: 50px;
            position: relative;
        }

        .clone-image {
            display: none;
            position: absolute;
            width: 300px;
            height: 300px;
            border: 2px solid #ccc;
            background-color: #f9f9f9;
            z-index: 999;
        }
    .col-sm-12.printable.p-10{
            padding: 5 !important;
            text-align: center;
            display: none;
        }
        #head{
        background-color: #fdfdfd !important; 
        font-weight: bold;
       }
       #reporttitle {
            display: none;
        }
    @media print {
        @page {
        size: A4;
        margin: 10 !important;
        padding: 5 !important;
    }

        .header, .main-footer, .mb-2{
            display: none;
        }
        .content-wrapper{
        margin: 0 !important;
        background-color: white !important;
        transform: scale(0.81); /* 81% scaling */
        transform-origin: top right; 
         }
       .main-sidebar{
        display: none !important;
        }

        .content{
            background-color: white !important;
        }
      
        .col-sm-12.printable.p-10{
            padding: 5 !important;
            display: block;
            font-size: 24px;
            font-weight: bolder;
        }
        #reporttitle {
            display: none;
        }
        #tab1 {
            max-height: none !important;
            overflow-y: visible !important;
        }
        .hide_column{
            display: none;
        }
 
    }
</style>
@endpush

@section('title')
{{ __('اوراق تحت التحصيل') }}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            <i class="fas fa-text-height heart-beat"></i>
            اوراق تحت التحصيل
        </h1>
    </div>
    <div class="col-sm-6">

        <a class="btn btn-primary btn-sm float-left"
           href="{{ route('treasury_journal') }}">
            رجوع
        </a>
        <button class="btn btn-primary btn-sm float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
            <i class="fas fa-print"></i> تصدير الى الاكسيل 
          </button>
          <button class="btn btn-primary btn-sm float-left" onclick="window.print()" style="margin-left: 10px;"> 
            طباعه 
        </button>
    </div>
  </div>
</div>
</section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="card-body d-flex align-items-center col-sm-3"> 
                <label for="statusFilter" class="mr-2">الحاله:  </label> &nbsp;&nbsp;
                <select id="statusFilter" class="form-control" style="margin-bottom: 10px;">
                    <option value="">الكل</option>
                    <option value="pending">تحت التحصيل</option>
                    <option value="approved">تم التحصيل</option>
                    <option value="reject">تم رفض الشيك</option>
                </select>
            </div>
            
        </div>
        
        <div class="card">
            <div class="card-body">
                <div id="tab1">
                    <table class="table table-border" id="tab">

                        <tr class="table-active" style="position: sticky;top: 0;background-color: rgb(0 0 0 / 75%);color: #fff;">
                            <th style="vertical-align: middle;">البنك</th>

                            <th style="vertical-align: middle;">تحت حساب</th>
                            <th style="vertical-align: middle;">رقم الشيك</th>
                            
                            <th style="vertical-align: middle;">المبلغ</th>
                            <th style="vertical-align: middle;">تاريخ استلام الشيك</th>
                            <th style="vertical-align: middle;">تاريخ استحقاق الشيك</th>
                            <th style="vertical-align: middle;">الحاله</th>
                            <th style="vertical-align: middle;">صورة الشيك</th>
                            <th style="vertical-align: middle;">العمليات</th>
                        </tr>
                                {{-- @php
                                    $count = 0;
                                    $sum = 0;
                                @endphp --}}
                                <tbody id="collectionTableBody">
                                    @foreach ($under_collection as $item)
                                        <tr data-status="{{ $item->status }}">
                                            <td>{{ $item->get_bank->name }}</td>
                                            <td>
                                                @if (isset($item->get_customer))
                                                    <span class="badge badge-secondary">عميل </span>  {{ $item->get_customer->name }} 
                                                @endif
                                                @if (isset($item->get_supplier))
                                                    <span class="badge badge-secondary">مورد </span>   {{ $item->get_supplier->name }} 
                                                @endif
                                                
                                            </td>
                                            <td>{{ $item->check_no }}</td>
                                            <td>
                                                @if ($item->deposit > 0)
                                                    <span class="badge badge-success"> ايداع</span> {{ number_format($item->deposit, 2) }}
                                                @endif

                                                @if ($item->spend > 0)
                                                    <span class="badge badge-danger"> سحب</span> {{ number_format($item->spend, 2) }}
                                                @endif
                                                
                                            </td>
                                            <td>{{ $item->date_in }}</td>
                                            <td>{{ $item->date_entitlment }}</td>
                                            <td>
                                                @if ($item->status == "pending")
                                                    <span class="badge badge-warning">{{ 'تحت التحصيل' }}</span>
                                                @elseif ($item->status == "approved")
                                                    <span class="badge badge-success">{{ 'تم التحصيل' }}</span>
                                                @elseif ($item->status == "reject")
                                                    <span class="badge badge-danger">{{ 'تم رفض الشيك' }}</span>
                                                @endif
                                            </td>
                                            <td class="preview">
                                                @if (isset($item->img))
                                                    @php
                                                        $image = json_decode($item->img)
                                                    @endphp
                                                    @foreach ($image as $imgs)
                                                        <div class="col-sm-10">
                                                            <img class="img-thumbnail hover-image" src="{{ asset($imgs) }}" alt="preview" >
                                                            <div id="clone-container" class="clone-image"></div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @if ($item->status == "pending")
                                                    @can('treasuryDetails.check_approved')
                                                        {!! Form::open(['route' => ['check_approved'], 'method' => 'post']) !!}
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        {!! Form::button('<i class="fas fa-thumbs-up"></i>', [
                                                            'type' => 'submit',
                                                            'class' => 'btn btn-link btn-primary btn-just-icon',
                                                            'title' => 'تحصيل الشيك',
                                                            'onclick' => "return confirm('سيتم تحصيل الشيك')"
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif
                                
                                                @if ($item->status == "pending")
                                                    @can('treasuryDetails.check_reject')
                                                        {!! Form::open(['route' => ['check_reject'], 'method' => 'post']) !!}
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        {!! Form::button('<i class="fas fa-ban"></i>', [
                                                            'type' => 'submit',
                                                            'class' => 'btn btn-link btn-danger btn-just-icon',
                                                            'title' => 'رفض الشيك',
                                                            'onclick' => "return confirm('سيتم رفض الشيك')"
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
            </div>
                <div class="card-footer text-center">
                    <div class="row">
                       
                    </div>
                </div>
                

            </div>
        </div>
        
    </div>

@endsection

@push('page_scripts')
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script>

<script>
    document.getElementById('statusFilter').addEventListener('change', function() {
        var selectedStatus = this.value;
        var rows = document.querySelectorAll('#collectionTableBody tr');

        rows.forEach(function(row) {
            if (selectedStatus === "" || row.dataset.status === selectedStatus) {
                row.style.display = ""; // Show the row
            } else {
                row.style.display = "none"; // Hide the row
            }
        });
    });
</script>

<script>
// =========================clone image===================
document.addEventListener('DOMContentLoaded', function() {
    var hoverImages = document.querySelectorAll('.hover-image');
    var cloneContainer = document.createElement('div');
    cloneContainer.classList.add('clone-image');

    document.body.appendChild(cloneContainer);

    for (var i = 0; i < hoverImages.length; i++) {
        hoverImages[i].addEventListener('mousemove', function(event) {
            var src = this.getAttribute('src');

            cloneContainer.style.backgroundImage = 'url(' + src + ')';
            cloneContainer.style.backgroundSize = '100% 100%';

            cloneContainer.style.left = event.pageX + 60 + 'px'; 
            cloneContainer.style.top = event.pageY + -230 + 'px';

            cloneContainer.style.display = 'block';
        });

        hoverImages[i].addEventListener('mouseleave', function() {
            cloneContainer.style.display = 'none';
        });
    }
});
</script>
@endpush