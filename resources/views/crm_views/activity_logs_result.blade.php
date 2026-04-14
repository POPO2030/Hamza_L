@extends('layouts.app')

@section('title')
    {{__('تقرير سجل النشاطات')}}
@endsection

<style>
    .table.table-head-fixed thead tr:nth-child(1) th{
        background-color: #343a40 !important;
        color: #fff !important;
        text-align: center;
    }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-3">
                    <h1> <i class="fas fa-scroll"></i> تقرير سجل النشاطات</h1>
                   
                </div>
                
                    
                <div class="col-sm-4">
                  
                    <a class="btn btn-primary float-left"
                       href="{{ route('activity_logs') }}">
                        رجوع
                    </a>

                    <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
                        <i class="fas fa-print"></i> تصدير الى الاكسيل 
                      </button>
                      
                   
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card" >
   
          

            <div class="card-body table-responsive" style="height: 900px;">
            <table class="table table-bordered table-hover table-head-fixed table-bordered" id="tab">
            <thead>
                <tr>
                    <th>السجل</th>
                    <th>الحالة</th>
                    <th>موديول</th>
                    <th>المستخدم</th>
                    <th>الغسلة</th>
                    <th>الخصائص</th>
                    <th>تاريخ الإنشاء</th>
                </tr>
            </thead>
            @foreach ($activities as $activity)
            <tr>
                <td>{{ $activity->id }}</td>
                <td>
                    @if($activity->description == 'created')
                        انشاء
                    @elseif($activity->description == 'updated')
                        تعديل
                    @elseif($activity->description == 'deleted')
                        حذف
                    @else
                        {{ $activity->description }} <!-- In case there's any other event -->
                    @endif
                </td>
                <td>
                    @php
                        $subjects = [
                            'ReceiveReceipt' => 'اذن اضافة',
                            'WorkOrder' => 'غسلة',
                            'Work_order_stage' => 'خدمات',
                            'Note' => 'ملاحظات',
                            'Deliver_order' => 'اذن تغليف',
                            'FinalDeliver' => 'اذن تسليم',
                        ];
                        $subjectType = str_replace('App\Models\CRM\\', '', $activity->subject_type);
                    @endphp
                    {{ $subjects[$subjectType] ?? $subjectType }}
                </td>
            
                <td>{{ $activity->causer->name }}</td>

                <td>{{ $activity->subject_id }}</td>
                <td>
                    <div class="row">
                        <!-- Handling attributes (if they exist) -->
                        @if (isset($activity->properties['attributes']) && is_array($activity->properties['attributes']))
                            <div class="col-12">
                                <span class="badge badge-info">الخصائص:</span>
                                @foreach($activity->properties['attributes'] as $key => $value)
                                    <span class="badge badge-secondary">{{ $key }}:</span> {{ $value }} &nbsp;
                                @endforeach
                            </div>
                        @endif

                        <!-- Handling removed (if they exist) -->
                        @if (isset($activity->properties['removed']) && is_array($activity->properties['removed']))
                            <div class="col-12">
                                <span class="badge badge-danger">تم الإزالة:</span>
                                @foreach($activity->properties['removed'] as $key => $value)
                                    <span class="badge badge-warning">{{ $key }}: </span> {{ $value }} &nbsp;
                                @endforeach
                            </div>
                        @endif

                        <!-- Handling added (if they exist) -->
                        @if (isset($activity->properties['added']) && is_array($activity->properties['added']))
                            <div class="col-12">
                                <span class="badge badge-success">تم الإضافة:</span>
                                @foreach($activity->properties['added'] as $key => $value)
                                    <span class="badge badge-primary">{{ $key }}: </span> {{ $value }} &nbsp;
                                @endforeach
                            </div>
                        @endif

                        <!-- Handling current (if they exist) -->
                        @if (isset($activity->properties['current']) && is_array($activity->properties['current']))
                            <div class="col-12">
                                <span class="badge badge-info">الحالة الحالية:</span>
                                @foreach($activity->properties['current'] as $key => $value)
                                    <span class="badge badge-light">{{ $key }}:</span> {{ $value }} &nbsp;
                                @endforeach
                            </div>
                        @endif

                        <!-- Handling old (if they exist) -->
                        @if (isset($activity->properties['old']) && is_array($activity->properties['old']))
                            <div class="col-12">
                                <span class="badge badge-dark">الحالة السابقة:</span>
                                @foreach($activity->properties['old'] as $key => $value)
                                    <span class="badge badge-secondary">{{ $key }}:</span> {{ $value }} &nbsp;
                                @endforeach
                            </div>
                        @endif

                    </div>
                </td>
                <td>{{ $activity->created_at }}</td>
            </tr>
            @endforeach
        </table>
        </div>
        </div>

    </div>

    <div class="card-footer clearfix">
        <div class="float-right">      
        </div>
    </div>        
   
                           
@endsection



<!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('تقرير سجل النشاطات.' + (type || 'xlsx')));
    }

</script>

