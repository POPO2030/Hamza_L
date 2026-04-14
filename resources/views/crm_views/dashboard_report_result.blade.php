@extends('layouts.app')
    @php
        use Carbon\Carbon;
    @endphp

@section('title')
    {{__('تقرير تحليل الاداء')}}
@endsection

<style>
    .info-box .info-box-icon {
        border-radius: .25rem;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 1.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
    }
    
    .info-box .info-box-text, .info-box .progress-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .info-box .info-box-content {
        -ms-flex: 1;
        flex: 1;
        padding: 5px 10px;
    }
    .info-box {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: .25rem;
        background: #fff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
    }
    
    .info-box .progress {
        background-color: rgba(0, 0, 0, .125);
        height: 2px;
        margin: 5px 0;
    }
    
    .progress {
        box-shadow: none;
        border-radius: 1px;
    }
    .progress {
        display: -ms-flexbox;
        display: flex;
        height: 1rem;
        overflow: hidden;
        font-size: .75rem;
        background-color: #e9ecef;
        border-radius: .25rem;
        box-shadow: inset 0 .1rem .1rem rgba(0, 0, 0, .1);
    }
    
    .fa, .fas {
      font-weight: 900;
    }
    
    .fa, .far, .fas {
      font-family: "Font Awesome 5 Free";
    }
    
    .fa, .fab, .fad, .fal, .far, .fas {
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      line-height: 1;
    }
      .bg-info, .bg-info>a {
      color: #fff!important;
    }
    
      .bg-warning, .bg-warning>a {
      color: #000!important;
    }
      .bg-danger, .bg-danger>a {
      color: #fff!important;
    }
      .bg-success, .bg-success>a {
      color: #fff!important;
    }
    
    
    .bg-info {
      background-color: #17a2b8!important;
    }
    
    .bg-warning {
      background-color: #ffc107!important;
    }
    .bg-danger {
      background-color: #dc3545!important;
    }
    .bg-success {
      background-color: #28a745!important;
    }
    
</style>
    

    @php
        
        $carbonDate = Carbon::createFromFormat('M-Y', $request->from_month_year);
        $arabicMonth = $carbonDate->translatedFormat('F');
        $arabicYear = $carbonDate->year;
        $arabicDate = $arabicMonth . ' ' . $arabicYear;
    @endphp
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-3">
                    <h3 class="fas fa-scroll" style="color:#17a2b8;"> تقرير تحليل الاداء {{ $arabicDate }}</h3>
                   
                </div>
           
                    
                
                <div class="col-sm-4">

                  
                    <a class="btn btn-primary float-left"
                       href="{{ route('dashboard_report') }}">
                        رجوع
                    </a>

                    {{-- <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> 
                        <i class="fas fa-print"></i> تصدير الى الاكسيل 
                      </button> --}}
                      
                   
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="row" style="justify-content: center;">

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success"> <i class="fas fa-space-shuttle"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">اسرع غسلة فى هذا الشهر  <span class="badge badge-info" style="font-size: 1rem"> {{$faster['work_order_id']}} </span> </span>
                <span class="info-box-number">
                    @if($faster['days'] != 0)
                        @if($faster['days'] >= 3 && $faster['days'] <= 10)
                            {{ $faster['days'] }} ايام
                        @else
                            {{ $faster['days'] }} يوم
                        @endif
                    @endif
                    @if($faster['hours'] != 0)
                        @if($faster['hours'] >= 3 && $faster['hours'] <= 10)
                            {{ $faster['hours'] }} ساعات
                        @else
                            {{ $faster['hours'] }} ساعة
                        @endif
                    @endif
                    @if($faster['minutes'] != 0)
                        @if($faster['minutes'] >= 3 && $faster['minutes'] <= 10)
                            {{ $faster['minutes'] }} دقائق
                        @else
                            {{ $faster['minutes'] }} دقيقة
                        @endif
                    @endif
                </span>
            </div>
           </div>
           </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger"> <i class="fas fa-biking"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">ابطء غسلة فى هذا الشهر <span class="badge badge-info" style="font-size: 1rem"> {{$slower['work_order_id']}} </span> </span>
                <span class="info-box-number">
                    @if($slower['days'] != 0)
                        @if($slower['days'] >= 3 && $slower['days'] <= 10)
                            {{ $slower['days'] }} ايام
                        @else
                            {{ $slower['days'] }} يوم
                        @endif
                    @endif
                    @if($slower['hours'] != 0)
                        @if($slower['hours'] >= 3 && $slower['hours'] <= 10)
                            {{ $slower['hours'] }} ساعات
                        @else
                            {{ $slower['hours'] }} ساعة
                        @endif
                    @endif
                    @if($slower['minutes'] != 0)
                        @if($slower['minutes'] >= 3 && $slower['minutes'] <= 10)
                            {{ $slower['minutes'] }} دقائق
                        @else
                            {{ $slower['minutes'] }} دقيقة
                        @endif
                    @endif
                </span>
            </div>
           </div>
            </div>



           </div>

        <div class="card">
            
   

    {{-- --------------------------------------------------------------------------------------------------- --}}
            <h5 class="mt-4 mb-2">متوسط مدة التشغيل </h5>
            <div class="row" style="justify-content:center;">
            <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-info">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">مجموعة الفاشون من 1 الى 3</span>
            {{-- <span class="info-box-number">{{"$average_1_3[days] أيام, $average_1_3[hours] ساعة"}}</span> --}}
            <span class="info-box-number">
                @if($average_1_3['days'] != 0)
                    @if($average_1_3['days'] >= 3 && $average_1_3['days'] <= 10)
                        {{ $average_1_3['days'] }} ايام
                    @else
                        {{ $average_1_3['days'] }} يوم
                    @endif
                @endif
                @if($average_1_3['hours'] != 0)
                    @if($average_1_3['hours'] >= 3 && $average_1_3['hours'] <= 10)
                        {{ $average_1_3['hours'] }} ساعات
                    @else
                        {{ $average_1_3['hours'] }} ساعة
                    @endif
                @endif
            </span>
            <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
            </div>
            <span class="progress-description">
            {{-- 70% Increase in 30 Days --}}
            <i class="fas fa-space-shuttle"></i>
            @if($faster_1_3['days'] != 0)
                @if($faster_1_3['days'] >= 3 && $faster_1_3['days'] <= 10)
                    {{ $faster_1_3['days'] }} ايام
                @else
                    {{ $faster_1_3['days'] }} يوم
                @endif
            @endif
            @if($faster_1_3['hours'] != 0)
                @if($faster_1_3['hours'] >= 3 && $faster_1_3['hours'] <= 10)
                    {{ $faster_1_3['hours'] }} ساعات
                @else
                    {{ $faster_1_3['hours'] }} ساعة
                @endif
            @endif
            <br>
            <i class="fas fa-biking"></i>

            @if($slower_1_3['days'] != 0)
                @if($slower_1_3['days'] >= 3 && $slower_1_3['days'] <= 10)
                    {{ $slower_1_3['days'] }} ايام
                @else
                    {{ $slower_1_3['days'] }} يوم
                @endif
            @endif
            @if($slower_1_3['hours'] != 0)
                @if($slower_1_3['hours'] >= 3 && $slower_1_3['hours'] <= 10)
                    {{ $slower_1_3['hours'] }} ساعات
                @else
                    {{ $slower_1_3['hours'] }} ساعة
                @endif
            @endif
            </span>
            </div>
            
            </div>
            
            </div>
    {{-- --------------------------------------------------------------------------------------------------- --}}
    {{-- --------------------------------------------------------------------------------------------------- --}}
            <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-info">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">مجموعة الفاشون من 4 الى 6</span>
            {{-- <span class="info-box-number">{{"$average_4_6[days] أيام, $average_4_6[hours] ساعة"}}</span> --}}
            <span class="info-box-number">
                @if($average_4_6['days'] != 0)
                    @if($average_4_6['days'] >= 3 && $average_4_6['days'] <= 10)
                        {{ $average_4_6['days'] }} ايام
                    @else
                        {{ $average_4_6['days'] }} يوم
                    @endif
                @endif
                @if($average_4_6['hours'] != 0)
                    @if($average_4_6['hours'] >= 3 && $average_4_6['hours'] <= 10)
                        {{ $average_4_6['hours'] }} ساعات
                    @else
                        {{ $average_4_6['hours'] }} ساعة
                    @endif
                @endif
            </span>
            <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
            </div>
            <span class="progress-description">
            {{-- 70% Increase in 30 Days --}}
            <i class="fas fa-space-shuttle"></i>
            @if($faster_4_6['days'] != 0)
                @if($faster_4_6['days'] >= 3 && $faster_4_6['days'] <= 10)
                    {{ $faster_4_6['days'] }} ايام
                @else
                    {{ $faster_4_6['days'] }} يوم
                @endif
            @endif
            @if($faster_4_6['hours'] != 0)
                @if($faster_4_6['hours'] >= 3 && $faster_4_6['hours'] <= 10)
                    {{ $faster_4_6['hours'] }} ساعات
                @else
                    {{ $faster_4_6['hours'] }} ساعة
                @endif
            @endif
            <br>
            <i class="fas fa-biking"></i>

            @if($slower_4_6['days'] != 0)
                @if($slower_4_6['days'] >= 3 && $slower_4_6['days'] <= 10)
                    {{ $slower_4_6['days'] }} ايام
                @else
                    {{ $slower_4_6['days'] }} يوم
                @endif
            @endif
            @if($slower_4_6['hours'] != 0)
                @if($slower_4_6['hours'] >= 3 && $slower_4_6['hours'] <= 10)
                    {{ $slower_4_6['hours'] }} ساعات
                @else
                    {{ $slower_4_6['hours'] }} ساعة
                @endif
            @endif
            </span>
            </div>
            
            </div>
            
            </div>
    {{-- --------------------------------------------------------------------------------------------------- --}}
    {{-- --------------------------------------------------------------------------------------------------- --}}
            <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-info">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">مجموعة الفاشون من 6 الى 10</span>
            {{-- <span class="info-box-number">{{"$average_6_10[days] أيام, $average_6_10[hours] ساعة"}}</span> --}}
            <span class="info-box-number">
                @if($average_6_10['days'] != 0)
                    @if($average_6_10['days'] >= 3 && $average_6_10['days'] <= 10)
                        {{ $average_6_10['days'] }} ايام
                    @else
                        {{ $average_6_10['days'] }} يوم
                    @endif
                @endif
                @if($average_6_10['hours'] != 0)
                    @if($average_6_10['hours'] >= 3 && $average_6_10['hours'] <= 10)
                        {{ $average_6_10['hours'] }} ساعات
                    @else
                        {{ $average_6_10['hours'] }} ساعة
                    @endif
                @endif
            </span>
            <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
            </div>
            <span class="progress-description">
            {{-- 70% Increase in 30 Days --}}
            <i class="fas fa-space-shuttle"></i>
            @if($faster_6_10['days'] != 0)
                @if($faster_6_10['days'] >= 3 && $faster_6_10['days'] <= 10)
                    {{ $faster_6_10['days'] }} ايام
                @else
                    {{ $faster_6_10['days'] }} يوم
                @endif
            @endif
            @if($faster_6_10['hours'] != 0)
                @if($faster_6_10['hours'] >= 3 && $faster_6_10['hours'] <= 10)
                    {{ $faster_6_10['hours'] }} ساعات
                @else
                    {{ $faster_6_10['hours'] }} ساعة
                @endif
            @endif
            <br>
            <i class="fas fa-biking"></i>

            @if($slower_6_10['days'] != 0)
                @if($slower_6_10['days'] >= 3 && $slower_6_10['days'] <= 10)
                    {{ $slower_6_10['days'] }} ايام
                @else
                    {{ $slower_6_10['days'] }} يوم
                @endif
            @endif
            @if($slower_6_10['hours'] != 0)
                @if($slower_6_10['hours'] >= 3 && $slower_6_10['hours'] <= 10)
                    {{ $slower_6_10['hours'] }} ساعات
                @else
                    {{ $slower_6_10['hours'] }} ساعة
                @endif
            @endif
            </span>
            </div>
            
            </div>
            
            </div>
    {{-- --------------------------------------------------------------------------------------------------- --}}
    {{-- --------------------------------------------------------------------------------------------------- --}}
            <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-info">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">مجموعة الفاشون من 10 الى 15</span>
            {{-- <span class="info-box-number">{{"$average_10_15[days] أيام, $average_10_15[hours] ساعة"}}</span> --}}
            <span class="info-box-number">
                @if($average_10_15['days'] != 0)
                    @if($average_10_15['days'] >= 3 && $average_10_15['days'] <= 10)
                        {{ $average_10_15['days'] }} ايام
                    @else
                        {{ $average_10_15['days'] }} يوم
                    @endif
                @endif
                @if($average_10_15['hours'] != 0)
                    @if($average_10_15['hours'] >= 3 && $average_10_15['hours'] <= 10)
                        {{ $average_10_15['hours'] }} ساعات
                    @else
                        {{ $average_10_15['hours'] }} ساعة
                    @endif
                @endif
            </span>
            <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
            </div>
            <span class="progress-description">
            {{-- 70% Increase in 30 Days --}}
            <i class="fas fa-space-shuttle"></i>
            @if($faster_10_15['days'] != 0)
                @if($faster_10_15['days'] >= 3 && $faster_10_15['days'] <= 10)
                    {{ $faster_10_15['days'] }} ايام
                @else
                    {{ $faster_10_15['days'] }} يوم
                @endif
            @endif
            @if($faster_10_15['hours'] != 0)
                @if($faster_10_15['hours'] >= 3 && $faster_10_15['hours'] <= 10)
                    {{ $faster_10_15['hours'] }} ساعات
                @else
                    {{ $faster_10_15['hours'] }} ساعة
                @endif
            @endif
            <br>
            <i class="fas fa-biking"></i>

            @if($slower_10_15['days'] != 0)
                @if($slower_10_15['days'] >= 3 && $slower_10_15['days'] <= 10)
                    {{ $slower_10_15['days'] }} ايام
                @else
                    {{ $slower_10_15['days'] }} يوم
                @endif
            @endif
            @if($slower_10_15['hours'] != 0)
                @if($slower_10_15['hours'] >= 3 && $slower_10_15['hours'] <= 10)
                    {{ $slower_10_15['hours'] }} ساعات
                @else
                    {{ $slower_10_15['hours'] }} ساعة
                @endif
            @endif
            </span>
            </div>
            
            </div>
            
            </div>
    {{-- --------------------------------------------------------------------------------------------------- --}}
    {{-- --------------------------------------------------------------------------------------------------- --}}
            <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-info">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">مجموعة الفاشون من 15 فيما فوق</span>
            {{-- <span class="info-box-number">{{"$average_15_00[days] أيام, $average_15_00[hours] ساعة"}}</span> --}}
            <span class="info-box-number">
                @if($average_15_00['days'] != 0)
                    @if($average_15_00['days'] >= 3 && $average_15_00['days'] <= 10)
                        {{ $average_15_00['days'] }} ايام
                    @else
                        {{ $average_15_00['days'] }} يوم
                    @endif
                @endif
                @if($average_15_00['hours'] != 0)
                    @if($average_15_00['hours'] >= 3 && $average_15_00['hours'] <= 10)
                        {{ $average_15_00['hours'] }} ساعات
                    @else
                        {{ $average_15_00['hours'] }} ساعة
                    @endif
                @endif
            </span>
            <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
            </div>
            <span class="progress-description">
            {{-- 70% Increase in 30 Days --}}
            <i class="fas fa-space-shuttle"></i>
            @if($faster_15_00['days'] != 0)
                @if($faster_15_00['days'] >= 3 && $faster_15_00['days'] <= 10)
                    {{ $faster_15_00['days'] }} ايام
                @else
                    {{ $faster_15_00['days'] }} يوم
                @endif
            @endif
            @if($faster_15_00['hours'] != 0)
                @if($faster_15_00['hours'] >= 3 && $faster_15_00['hours'] <= 10)
                    {{ $faster_15_00['hours'] }} ساعات
                @else
                    {{ $faster_15_00['hours'] }} ساعة
                @endif
            @endif
            <br>
            <i class="fas fa-biking"></i>

            @if($slower_15_00['days'] != 0)
                @if($slower_15_00['days'] >= 3 && $slower_15_00['days'] <= 10)
                    {{ $slower_15_00['days'] }} ايام
                @else
                    {{ $slower_15_00['days'] }} يوم
                @endif
            @endif
            @if($slower_15_00['hours'] != 0)
                @if($slower_15_00['hours'] >= 3 && $slower_15_00['hours'] <= 10)
                    {{ $slower_15_00['hours'] }} ساعات
                @else
                    {{ $slower_15_00['hours'] }} ساعة
                @endif
            @endif
            </span>
            </div>
            
            </div>
            
            </div>
    {{-- --------------------------------------------------------------------------------------------------- --}}
          
           
    <div class="col-md-6">
        <div class="card card-primary card-outline" dir="ltr">
          <div class="card-header">
          <h3 class="card-title" style="text-align:left;">
            <i class="far fa-chart-bar"></i>
            الرسم البيانى
          </h3>
          <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
          </button>
          </div>
          </div>
          <div class="card-body">
          <div class="chart">
          <canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
          </div>
          </div>
          
          </div>
          </div>





                    
            </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">

               
            </div>

    </div>        
   
                           
@endsection

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('datatables_js/Chart.min.js') }}"></script>

{{-- <!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }

</script> --}}

<script>
jQuery(document).ready(function($) {
    // =============  barChart ==================================================

    var chartData = {!! json_encode($data) !!};
    var translations = {!! json_encode($translations) !!};

    // Extracting data for chart labels and values
    var labels = Object.keys(chartData).map(function(key) {
        return translations[key];
    });
    var values = Object.values(chartData).map(function(value) {
        return value; 
    });

    // Create the chart
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'عدد القطع',
                data: values,
                backgroundColor: '#0073b7', // Bar color
                borderColor: '#0073b7', // Border color
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // ========================================================

});
</script>