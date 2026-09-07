@extends('layouts.app')

@section('title')
    {{__('نتائج تقرير Logs مخزن الجاهز')}}
@endsection

<style>
    .table.table-head-fixed thead tr:nth-child(1) th{
        background-color: #343a40 !important;
        color: #fff !important;
        text-align: center;
    }
    .stats-card {
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .stats-number {
        font-size: 2rem;
        font-weight: bold;
    }
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    .badge-created { background-color: #28a745; }
    .badge-updated { background-color: #ffc107; color: #000; }
    .badge-deleted { background-color: #dc3545; }
    
    tr.deleted-row { 
        background-color: #ffebee !important; 
        text-decoration: line-through;
        opacity: 0.7;
    }
    tr.updated-row { 
        background-color: #fff8e1 !important; 
    }
</style>

@section('content')
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
            
            <div class="col-sm-6">
                <h1><i class="fas fa-scroll"></i> نتائج تقرير مخزن الجاهز عن فترة</h1>
            </div>

            <div class="col-sm-6">
                <a class="btn btn-primary float-left" href="{{ route('ready_store_logs') }}">
                    رجوع
                </a>

                <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;">
                    <i class="fas fa-print"></i> تصدير الى الاكسيل
                </button>
            </div>
        </div>

        <!-- إحصائيات -->
        {{-- <div class="row mb-3">
            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);">
                    <div class="stats-number">{{ number_format($total_pieces) }}</div>
                    <div class="stats-label">إجمالي القطع المتغلفة</div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                    <div class="stats-number">{{ number_format($total_packages) }}</div>
                    <div class="stats-label">إجمالي عدد الأكياس</div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(135deg, #20c997 0%, #1ba87e 100%);">
                    <div class="stats-number">{{ number_format($jeans_total) }}</div>
                    <div class="stats-label">إجمالي الجينز</div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);">
                    <div class="stats-number">{{ number_format($washing_total) }}</div>
                    <div class="stats-label">إجمالي الغسيل (بدون فاشون)</div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(135deg, #fd7e14 0%, #e56b0a 100%);">
                    <div class="stats-number">{{ number_format($dyeing_total) }}</div>
                    <div class="stats-label">إجمالي الصباغة (بدون فاشون)</div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="stats-card text-center" style="background: linear-gradient(135deg, #e83e8c 0%, #d12a7a 100%);">
                    <div class="stats-number">{{ number_format($fashion_total) }}</div>
                    <div class="stats-label">إجمالي الفاشون</div>
                </div>
            </div>
        </div> --}}
         <small class="align-content center" style="color: #9c27b0; font-size: 0.9rem;">
             الفترة من {{ \Carbon\Carbon::parse($from)->format('Y-m-d h:i A') }}
             إلى {{ \Carbon\Carbon::parse($to)->format('Y-m-d h:i A') }}
        </small>
    </div>
</section>

    <div class="content px-3">
        <div class="clearfix"></div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle text-center" id="tab">
                    <thead>
                        <tr>
                            <th>رقم اذن التغليف</th>
                            <th>رقم أمر الشغل</th>
                            <th>العميل</th>
                            <th>الصنف</th>
                            <th>اللون</th>
                            <th>ملاحظات</th>
                            <th>عدد الأكياس</th>
                            <th>الإجمالي</th>
                            <th>عدد الفاشون</th>  <!-- زي ما كان: مجموع أسعار الفاشون -->
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($result as $item)
                            @php
                                $count_pieces = 0;
                                $count_bags = 0;
                                $count_fashion = 0;
                                $serviceNames = [];

                                foreach ($item->get_details as $detail) {
                                    $count_bags += $detail->package_number;
                                    $count_pieces += $detail->total;
                                }

                                foreach($item->get_work_order->get_work_order_stage as $stage) {
                                    if(!in_array($stage->get_service_item->name, $serviceNames)) {
                                        $serviceNames[] = $stage->get_service_item->name;
                                    }
                                  $count_fashion += (float)$stage->get_service_item->price;
                                }
                            @endphp
                        
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->work_order_id }}</td>
                                <td>{{ $item->get_customer->name ?? 'N/A' }}</td>
                                <td>{{ $item->get_products->name ?? 'N/A' }}</td>
                                <td style="text-align: right;">
                                   
                                    @foreach($serviceNames as $service)
                                        <span class="badge badge-light text-dark"
                                            style="margin:2px; border:1px solid #dee2e6; display:inline-block;">
                                            {{ $service }}
                                        </span>
                                    @endforeach
                                    
                                </td>
                                <td>
                                    @if(isset($item->notes) && $item->notes->isNotEmpty())
                                        @foreach($item->notes as $note)
                                           <span class="badge badge-light text-dark" style="margin: 2px; padding: 5px; border: 1px solid #ccc; display:inline-block; border-radius: 4px;">
                                                {{ $note->note }}
                                            </span>
                                        @endforeach
                                    @endif
                                <td>{{ number_format($count_bags) }}</td>
                                <td>{{ number_format($count_pieces) }}</td>
                                <td>{{ number_format($count_fashion) }}</td> 
                            </tr>
                           
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            {{-- @if(isset($from) && isset($to))
                <small class="text-muted">
                    الفترة من {{ \Carbon\Carbon::parse($from)->format('Y-m-d h:i A') }}
                    إلى {{ \Carbon\Carbon::parse($to)->format('Y-m-d h:i A') }}
                </small>
            @endif --}}
        </div>
    </div>        
@endsection

<script type="text/javascript" src="{{ asset('datatables_js/xlsx.full.min.js') }}"></script>
<script>
function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('tab');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
        XLSX.writeFile(wb, fn || ('تقرير Logs مخزن الجاهز.' + (type || 'xlsx')));
}
</script>