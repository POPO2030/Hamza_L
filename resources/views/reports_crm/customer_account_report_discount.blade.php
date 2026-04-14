@extends('layouts.app')

@push('page_css')
<style>
        .hover-image {
            width: 50px;
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
        tr,th,td{
            text-align: center;
        }

       @media print {
        @page {
            size: A4;
            /* margin: 10 !important; */
            /* padding: 5 !important; */
        }

        #title {
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        
        #tab {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        body, html {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
@endpush

@section('title')
    {{__('كشف خصومات العملاء')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
<h1>
    <i class="fas fa-scroll"></i> كشف خصومات العميل
    @if(isset($customer_name) && $customer_name)
        <span class="badge badge-info" style="font-size: 20px;">
            {{ $customer_name->name }}
        </span>
    @elseif(isset($request->from) && isset($request->to))
        <span class="badge badge-info" style="font-size: 18px;">
            من {{ \Carbon\Carbon::parse($request->from)->format('Y-m-d') }}
            إلى {{ \Carbon\Carbon::parse($request->to)->format('Y-m-d') }}
        </span>
    @endif
</h1>
            
            </div>

                <div class="col-sm-6">
                    <a class="btn btn-primary btn-sm float-left"
                       href="{{ route('customer_account_report') }}">
                        رجوع
                    </a>
                    {{-- <button class="btn btn-primary btn-sm float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
                        <i class="fas fa-file-excel"></i> تصدير الى الاكسيل 
                    </button> --}}
<button class="btn btn-primary btn-sm float-left" onclick="printFullReport()" style="margin-left: 10px;">
    <i class="fas fa-print"></i> طباعه
</button>
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card">
   <div id="title">
            <div class="col-sm-12 printable p-10">
                <p>كشف خصومات العملاء</p>
            </div>
<table class="table table-bordered" id="tab1">
    <tr class="table-active" style="font-weight:bold;">
        <th>اسم العميل</th>
        <th>التاريخ</th>
        <th>البيان</th>
        <th>الخصم</th>
    </tr>

@if($request->customer_id && $request->customer_id !== 'all')
    {{-- عرض العميل المحدد --}}
    @forelse ($discounts as $item)
        <tr style="font-weight:bold;">
            <td>{{ $item->get_customer->name }}</td>
            <td>{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
            <td>{{ $item->note }}</td>
            <td>{{ number_format($item->cash_balance_credit, 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center" style="font-size:22px; font-weight:bold; color:#ff0800;">
                لا توجد خصومات
            </td>
        </tr>
    @endforelse

    <tr style="background:#747474; font-weight:bold; color:#000;">
        <td colspan="3" class="text-center">إجمالي الخصم للعميل</td>
        <td class="text-center">{{ number_format($discounts->sum('cash_balance_credit'), 2) }}</td>
    </tr>

@else
    {{-- عرض كل العملاء --}}
    @foreach($discounts as $customerId => $customerDiscounts)
        @php $customerName = $customerDiscounts->first()->get_customer->name; @endphp
        @foreach($customerDiscounts as $item)
            <tr style="font-weight:bold;">
                <td>{{ $customerName }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
                <td>{{ $item->note }}</td>
                <td>{{ number_format($item->cash_balance_credit, 2) }}</td>
            </tr>
        @endforeach
        {{-- إجمالي لكل عميل --}}
        <tr style="background:#747474; font-weight:bold; color:#000;">
            <td colspan="3" class="text-center">إجمالي خصم {{ $customerName }}</td>
            <td class="text-center">{{ number_format($customerDiscounts->sum('cash_balance_credit'), 2) }}</td>
        </tr>
    @endforeach
@endif
</table>



        </div>
            </div>
                </div>      

@endsection

@push('page_scripts')
<script>
function printFullReport() {
    // ناخد محتوى الـ div اللي فيه الجدول
    var printContents = document.getElementById('title').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // نعيد تحميل الصفحة بعد الطباعة
}
</script>

@endpush
