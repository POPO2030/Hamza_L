@extends('layouts.app')
@section('title')
    {{__('الصفحة الرئيسية')}}
@endsection

<style>
    #head {
    color: #ffffff !important;
}
.small-box p {
    font-size: 1.2rem !important;
}
.card{
  word-wrap:normal !important;
}
.progress {
  font-size: xx-small !important;
  font-weight:bolder;
}
</style>

<style>
  .small-box .icon>i {
   font-size: 90px !important;
   left: 15px !important;
   right: 70% !important;
   transition: transform .3s linear,-webkit-transform .3s linear;
 }
 
 .small-box:hover .icon>i, .small-box:hover .icon>i.fa, .small-box:hover .icon>i.fab, .small-box:hover .icon>i.fad, .small-box:hover .icon>i.fal, .small-box:hover .icon>i.far, .small-box:hover .icon>i.fas, .small-box:hover .icon>i.ion {
   -webkit-transform: scale(1.1);
   transform: scale(1.1);
 }
 
 .small-box .icon>i.fas, .small-box .icon>i.ion {
   font-size: 70px;
   top: 20px;
   color: rgba(0,0,0,.15);
   z-index: 0;
   float: left;
   position: absolute;
 }
 
 .small-box>.small-box-footer {
   background-color: rgba(0,0,0,.1);
   color: rgba(255,255,255,.8);
   display: block;
   padding: 3px 0;
   position: relative;
   text-align: center;
   text-decoration: none;
   z-index: 10;
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
   .bg-info1, .bg-info1>a {
   color: #fff!important;
 }
 
   .bg-warning1, .bg-warning1>a {
   color: #000!important;
 }
   .bg-danger1, .bg-danger1>a {
   color: #fff!important;
 }
   .bg-success1, .bg-success1>a {
   color: #fff!important;
 }
 
 .small-box {
   border-radius: 0.25rem;
   box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
   display: block;
   margin-bottom: 20px;
   position: relative;
 }
 .bg-info1 {
   background-color: #17a2b8!important;
 }
 
 .bg-warning1 {
   background-color: #ffc107!important;
 }
 .bg-danger1 {
   background-color: #dc3545!important;
 }
 .bg-success1 {
   background-color: #28a745!important;
 }
 
 .small-box>.inner1 {
   padding: 10px;
 }
 .inner{
  padding: 5px;
 }
 
 
     </style>

@section('content')

@include('flash::message')


<br>
 @can('result_balance')
  
         
{{-- ========================================================================================================= --}}
<?php

$table1 = '<table  border="1" width="100%" style="text-align: center;">';
$table2 = '<table  border="1" width="100%" style="text-align: center;">';

for ($i = 0; $i < 3; $i++) {
    $table1 .= '<tr style="background-color: #494f50;" id="head">';
    $table2 .= '<tr style="background-color: #494f50;" id="head">';

    if ($i == 0) {
        $table1 .= '<td style="width: calc(100% / 15);">المرحلة</td>';
        $table2 .= '<td style="width: calc(100% / 15);">المرحلة</td>';
    } elseif ($i == 1) {
        $table1 .= '<td style="width: calc(100% / 15);">صباحى</td>';
        $table2 .= '<td style="width: calc(100% / 15);">صباحى</td>';
    } else {
        $table1 .= '<td style="width: calc(100% / 15);">مسائى</td>';
        $table2 .= '<td style="width: calc(100% / 15);">مسائى</td>';
    }

    $start = 0;
    foreach ($result_day as $key_day => $value_day) {
        if ($i == 0) {
            if ($key_day == 'الميزان') {
                $trail = $value_day;
                $trail2 = $result_night[$key_day];
            }
            if ($key_day !== 'الميزان') {
                if($start < 14) {
                $table1 .= '<td style="width: calc(100% / 15);">' . $key_day . '</td>';
                } else {
                    $table2 .= '<td style="width: calc(100% / 15);">' . $key_day . '</td>';
                }
            }
        } elseif ($i == 1) {
            if ($key_day !== 'الميزان') {
                if ($start < 14) {
                    $table1 .= '<td style="width: calc(100% / 15);">' . $value_day . '</td>';
                } else {
                    $table2 .= '<td style="width: calc(100% / 15);">' . $value_day . '</td>';
                }
            }
        } else {
            if ($key_day !== 'الميزان') {
                if ($start < 14) {
                    $table1 .= '<td style="width: calc(100% / 15);">' . $result_night[$key_day] . '</td>';
                } else {
                    $table2 .= '<td style="width: calc(100% / 15);">' . $result_night[$key_day] . '</td>';
                }
            }
        }
        $start++;
    }

    $table1 .= '</tr>';
    $table2 .= '</tr>';
}

$table1 .= '</table>';
$table2 .= '</table>';

?>

<br>

  
{{-- ========================================================================================================= --}}
                    <div class="row">
                          
                      <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">balance</i>
                            </div>
                            <p class="card-category">انتاجية الميزان</p>
                            <h4 class="card-title">صباحى &nbsp; {{ $trail }}</h4>
                            <h4 class="card-title">مسائى &nbsp; {{ $trail2 }}</h4>
                          </div>
                          <div class="card-footer">
                            <div class="stats">
                              <i class="material-icons text-info">info</i>
                              <a href="{{ URL('result_balance') }}">معلومات أكثر...</a>
                            </div>
                          </div>
                        </div>
                      </div>

                          @endcan
         {{-- ------------------------------------------------------------------------------------------------------------------------------ --}}
         @if (Auth::user()->team_id == 1 || Auth::user()->team_id == 11 || Auth::user()->team_id == 13 || Auth::user()->team_id == 2 || Auth::user()->team_id == 8)                       <!--- id=11 it  , id=13 emad victor ,id=2 ayman nabil , id=8 محمد رياض----->
            

         <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">format_paint</i>
              </div>
              <p class="card-category">كمية الفاشون</p>
              @php
                    $price_day=0;                        // كمية الفاشون
                    $price_night=0;   
                                        
                    $count_workOrder_day=0;               //كمية الغسلة
                    $count_workOrder_night=0;
              @endphp
          
            @foreach($shift_day as $item)
              @if ($item->get_work_order)
                @php
                  $count_workOrder_day += $item->get_work_order->product_count;
                @endphp
              @endif
            @endforeach
        
            @foreach($fashion_shift_day as $items)
                @foreach ($items->get_work_order->get_stage as $details )
                    @foreach ($details->get_work_order_service as $work_order_service )
                        @php
                          $price_day += $items->get_work_order->product_count * $work_order_service->price;   // كمية الفاشون 
                        @endphp
                    @endforeach
                @endforeach
            @endforeach

            @foreach($shift_night as $item2)
              @if ($item2->get_work_order)
                  @php
                      $count_workOrder_night += $item2->get_work_order->product_count;
                  @endphp
              @endif
            @endforeach
        
            @foreach($fashion_shift_night as $items2)
                @foreach ($items2->get_work_order->get_stage as $details2 )
                    @foreach ($details2->get_work_order_service as $work_order_service2 )
                        @php
                        $price_night += $items2->get_work_order->product_count * $work_order_service2->price ;     // كمية الفاشون
                    @endphp
                    @endforeach
                @endforeach
            @endforeach
              <h4 class="card-title">صباحى &nbsp; {{ $price_day }}</h4>
              <h4 class="card-title">مسائى &nbsp; {{ $price_night }}</h4>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons text-info">info</i>
                <a href="#">معلومات أكثر...</a>
              </div>
            </div>
          </div>
        </div>
          
                           
  @endif
                      {{-- ----------------------------------------------------------------------------------------------------- --}}
  @if (Auth::user()->team_id == 1 || Auth::user()->team_id == 13 || Auth::user()->team_id == 2 || Auth::user()->team_id == 8)  
                        @php 
                            $total_details=0;                       //   كمية التغليف صباحا
                            $total_details_night=0;                 //   كمية التغليف مساءا

                            $fashion_day=0;                       //  كمية التغليف التى بها فاشون
                            $fashion_night=0;     
                       @endphp

                       @foreach ($day as $item)
                          @foreach ($item->get_details_dashboard as $details)
                              @php $total_details += $details->total; @endphp
                          @endforeach 
                       @endforeach
                       
                       @foreach ($fashionDeliver_ready_day as $items)
                            @foreach ($items->get_work_order_stage as $fashion_count)
                              @foreach ($items->get_details_dashboard as $total_fashion)
                              @if ($fashion_count->get_sevice_item_stage)
                                @php $fashion_day += $total_fashion->total * $fashion_count->get_sevice_item_stage->get_service_item->price; @endphp
                              @endif  
                              @endforeach
                            @endforeach    
                       @endforeach
       
                        @foreach ($night as $item)
                          @foreach ($item->get_details_dashboard as $details)
                              @php $total_details_night += $details->total; @endphp
                          @endforeach 
                        @endforeach
                           
                            @foreach ($fashionDeliver_ready_night as $items2)
                                @foreach ($items2->get_work_order_stage as $fashion_count_night)
                                  @foreach ($items2->get_details_dashboard as $total_with_fashion2 )
                                  @if ($fashion_count_night->get_sevice_item_stage)
                                    @php $fashion_night += $total_with_fashion2->total * $fashion_count_night->get_sevice_item_stage->get_service_item->price; @endphp
                                  @endif
                                  @endforeach
                                @endforeach
                            @endforeach  

                       
                              <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                  <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">
                                      <i class="material-icons">store</i>
                                    </div>
                                    <p class="card-category">كمية التغليف</p>
                                    <h4 class="card-title">صباحى &nbsp; {{ $total_details }}</h4>
                                    <h4 class="card-title">مسائى &nbsp; {{ $total_details_night }}</h4>
                                  </div>
                                  <div class="card-footer">
                                    <div class="stats">
                                      <i class="material-icons text-info">info</i>
                                      <a href="#">معلومات أكثر...</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                       
                        
             {{-- --------------------------------------------------------------------------------------------------------- --}}
                
                        @php 
                           $total_deliver=0;                                     //  كمية التسليم
                           $total_deliver_night=0;

                           $fashion_deliver_day=0;                                //  كمية التسليم التى بها فاشون
                           $fashion_deliver_night=0
                        @endphp

                      @foreach ($final_deliver_day as $item)
                             @php $total_deliver += $item->total; @endphp
                      @endforeach
                      
                      @foreach ($fashionDeliver_day as $items)
                           @foreach ($items->get_deliver_order->get_work_order_stage as $fashion_count)
                              @if ($fashion_count->get_sevice_item_stage)
                                 @php $fashion_deliver_day += $items->total * $fashion_count->get_sevice_item_stage->get_service_item->price; @endphp
                              @endif
                           @endforeach
                      @endforeach
      
                      @foreach ($final_deliver_night as $item)
                             @php $total_deliver_night += $item->total; @endphp
                      @endforeach  

                       @foreach ($fashionDeliver_night as $items)
                           @foreach ($items->get_deliver_order->get_work_order_stage as $fashion_count_night)
                              @if ($fashion_count_night->get_sevice_item_stage)
                                @php $fashion_deliver_night += $items->total * $fashion_count_night->get_sevice_item_stage->get_service_item->price; @endphp
                              @endif
                           @endforeach
                       @endforeach


                      <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                          <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                              <i class="material-icons">local_shipping</i>
                            </div>
                            <p class="card-category">كمية التسليم</p>
                            <h4 class="card-title">صباحى &nbsp; {{ $total_deliver }}</h4>
                            <h4 class="card-title">مسائى &nbsp; {{ $total_deliver_night }}</h4>
                          </div>
                          <div class="card-footer">
                            <div class="stats">
                              <i class="material-icons text-info">info</i>
                              <a href="#">معلومات أكثر...</a>
                            </div>
                          </div>
                        </div>
                      </div>


                        
                
@endif
@if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 8)  
<div class="card-body table-responsive ">

<?php echo $table1 ?>
<?php echo '<br>' ?>
<?php echo $table2 ?>

</div>
  </div>
  @endif
   @if (Auth::user()->team_id == 1 )
     

  {{-- <div class="col-md-6">
    <!-- DONUT CHART -->
    <div class="card card-danger" dir="ltr">
      <div class="card-header">
        <h3 class="card-title" style="color: #ffffff; text-align:left;" >المتوسط الاسبوعى</h3>

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
        <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
      <!-- /.card-body -->
    </div>
  </div> --}}
  <div class="row">

  <div class="col-md-6">
  <div class="card card-primary card-outline" dir="ltr">
    <div class="card-header">
    <h6 class="card-title" style="text-align:center;">
    <i class="far fa-chart-bar"></i>
   المتوسط الاسبوعى
    </h6>
    
    </div>
    <div class="card-body">
    <div id="donut-chart" style="height: 300px;"></div>
    </div>


    </div>
    </div>



      <div class="col-md-6">
        <div class="card card-primary card-outline" dir="ltr">
            <div class="container-fluid">
                <div class="card-header">
                    {{-- <div class="d-flex justify-content-between"> --}}
                        <h6 class="card-title" style="text-align:center;">
                          <i class="far fa-chart-bar"></i>
                          TOP TEN
                        </h6>
                       
                    {{-- </div> --}}
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <canvas id="visitors-chart" height="250"></canvas>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            <i class="fas fa-square" style="color: #00c0ef"></i> صباغة
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-square" style="color: #0073b7"></i> جينز
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-square" style="color: #A8A8A8"></i> غسيل
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


      {{-- <div class="col-md-6">
      <div class="card" dir="ltr">
        <div class="card-header border-transparent">
        <h6 class="card-title"  style="text-align:center;">TOP TEN</h6>
        
        </div>
        
        <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table m-0">
        <thead>
        <tr>
        <th>العميل</th>
        <th>الكمية</th>
        <th>النسبة</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($top_ten_customer as $customer )
            @php
              $ratio = $ratios_customers[$customer->get_customer->name] ?? 0;
              $progressBarClass = 'bg-danger'; // Default to bg-danger
                if ($ratio >= 60) {
                  $progressBarClass = 'bg-success';
                } elseif ($ratio >= 50) {
                  $progressBarClass = 'bg-info';
                } elseif ($ratio >= 30) {
                  $progressBarClass = 'bg-warning';
                }
            @endphp
          <tr>
            <td><a href={{"customers/" .$customer->customer_id}}>{{$customer->get_customer->name}}</a></td>
            <td>{{$customer->total_count}}</td>
            <td>
              <div class="progress">
                <div class="progress-bar progress-bar-striped {{ $progressBarClass }}" role="progressbar" style="width: {{ $ratio }}%" aria-valuenow="{{ $ratio }}" aria-valuemin="0" aria-valuemax="100">
                  {{ $ratio }}%
                </div>
              </div>


          </td>
    
          </tr> 
          @endforeach
  
        </tbody>
        </table>
        </div>
        
        </div>
        
        <div class="card-footer clearfix">

        </div>
        
        </div>
        </div> --}}
        
     

  </div>
 @endif   
@endsection



<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('datatables_js/Chart.min.js') }}"></script>
<script src="{{ asset('datatables_js/jquery.flot.js') }}"></script>
<script src="{{ asset('datatables_js/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('datatables_js/jquery.flot.pie.js') }}"></script>

<script>
jQuery(document).ready(function($) {

  var dyeingQuantity = {!! json_encode($averageQuantity_dyeing) !!};
  var jeansQuantity = {!! json_encode($averageQuantity_jeans) !!};
  var washingQuantity = {!! json_encode($averageQuantity_washing) !!};


  var donutData = [
      {
          label: 'غسيل',
          data: washingQuantity,
          color: '#3c8dbc'
      },
      {
          label: 'جينز',
          data: jeansQuantity,
          color: '#0073b7'
      },
      {
          label: 'صباغة',
          data: dyeingQuantity,
          color: '#00c0ef'
      }
  ];

  $.plot('#donut-chart', donutData, {
      series: {
          pie: {
              show: true,
              radius: 1,
              innerRadius: 0.5,
              label: {
                  show: true,
                  radius: 2 / 3,
                  formatter: labelFormatter,
                  threshold: 0.1
              }
          }
      },
      legend: {
          show: false
      }
  });

  function labelFormatter(label, series) {
      return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
          label +
          '<br>' +
          Math.round(series.percent) + '%' +
          '</div>';
  }


// =============  barChart ==================================================

  // var topTenCustomersDyeing = {!! json_encode($top_ten_customer_dyeing) !!};
  // var topTenCustomersJeans = {!! json_encode($top_ten_customer_jeans) !!};
  // var topTenCustomersWashing = {!! json_encode($top_ten_customer_washing) !!};

  // var customerChartCanvas = $('#barChart').get(0).getContext('2d');

  //   // Combine all customer data into one array
  //   var allCustomers = topTenCustomersDyeing.concat(topTenCustomersJeans, topTenCustomersWashing);

  //   // Create a map to store the total count for each customer
  //   var customerCounts = {};

  //   // Calculate the total count for each customer
  //   allCustomers.forEach(customer => {
  //       var name = customer.get_customer.name;
  //       if (!customerCounts[name]) {
  //           customerCounts[name] = 0;
  //       }
  //       customerCounts[name] += customer.count;
  //   });

  //   // Sort customers by their total count in descending order
  //   var sortedCustomers = Object.keys(customerCounts)
  //       .sort((a, b) => customerCounts[b] - customerCounts[a])
  //       .slice(0, 10); // Take the top 10 customers

  //   // Get the count for each category for the top 10 customers
  //   var topTenCustomersData = sortedCustomers.map(name => {
  //       var dyeingCount = topTenCustomersDyeing.find(c => c.get_customer.name === name)?.total_count || 0;
  //       var jeansCount = topTenCustomersJeans.find(c => c.get_customer.name === name)?.total_count || 0;
  //       var washingCount = topTenCustomersWashing.find(c => c.get_customer.name === name)?.total_count || 0;
  //       return {
  //           name: name,
  //           dyeing: dyeingCount,
  //           jeans: jeansCount,
  //           washing: washingCount
  //       };
  //   });

  //   var barChartData = {
  //     labels: topTenCustomersData.map(item => item.name),
  //     datasets: [
  //       {
  //         label: 'غسيل',
  //         backgroundColor: '#A8A8A8',
  //         borderColor: '#A8A8A8',
  //         borderWidth: 1,
  //         data: topTenCustomersData.map(item => item.washing)
  //       },
  //       {
  //         label: 'جينز',
  //         backgroundColor: '#0073b7',
  //         borderColor: '#0073b7',
  //         borderWidth: 1,
  //         data: topTenCustomersData.map(item => item.jeans)
  //       },
  //       {
  //         label: 'صباغة',
  //         backgroundColor: '#00c0ef',
  //         borderColor: '#00c0ef',
  //         borderWidth: 1,
  //         data: topTenCustomersData.map(item => item.dyeing)
  //       }
  //     ]
  //   };

  //   var barChartOptions = {
  //     responsive: true,
  //     maintainAspectRatio: false,
  //     scales: {
  //       xAxes: [{ stacked: true }],
  //       yAxes: [{ stacked: true, ticks: { beginAtZero: true } }]
  //     }
  //   };

  //   new Chart(customerChartCanvas, {
  //     type: 'bar',
  //     data: barChartData,
  //     options: barChartOptions
  //   });

  var ticksStyle = { fontColor: '#495057', fontStyle: 'bold' };
    var mode = 'index';
    var intersect = true;

    // Combine all customer data into one array
    var topTenCustomersDyeing = {!! json_encode($top_ten_customer_dyeing) !!};
    var topTenCustomersJeans = {!! json_encode($top_ten_customer_jeans) !!};
    var topTenCustomersWashing = {!! json_encode($top_ten_customer_washing) !!};
    var allCustomers = topTenCustomersDyeing.concat(topTenCustomersJeans, topTenCustomersWashing);

    // Create a map to store the total count for each customer
    var customerCounts = {};

    // Calculate the total count for each customer
    allCustomers.forEach(customer => {
        var name = customer.get_customer.name;
        if (!customerCounts[name]) {
            customerCounts[name] = 0;
        }
        customerCounts[name] += customer.count;
    });

    // Sort customers by their total count in descending order and get top 10
    var sortedCustomers = Object.keys(customerCounts)
        .sort((a, b) => customerCounts[b] - customerCounts[a])
        .slice(0, 10);

    // Get the count for each category for the top 10 customers
    var topTenCustomersData = sortedCustomers.map(name => {
        var dyeingCount = topTenCustomersDyeing.find(c => c.get_customer.name === name)?.total_count || 0;
        var jeansCount = topTenCustomersJeans.find(c => c.get_customer.name === name)?.total_count || 0;
        var washingCount = topTenCustomersWashing.find(c => c.get_customer.name === name)?.total_count || 0;
        return {
            name: name,
            dyeing: dyeingCount,
            jeans: jeansCount,
            washing: washingCount
        };
    });

    // Extract labels and data for the chart
    var labels = topTenCustomersData.map(item => item.name);
    var dyeingData = topTenCustomersData.map(item => item.dyeing);
    var jeansData = topTenCustomersData.map(item => item.jeans);
    var washingData = topTenCustomersData.map(item => item.washing);

    var maxCount = Math.max(...dyeingData, ...jeansData, ...washingData);

    var customerChartCanvas = $('#visitors-chart').get(0).getContext('2d');

    var customersLineChart = new Chart(customerChartCanvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'صباغة',
                    data: dyeingData,
                    borderColor: '#00c0ef',
                    backgroundColor: 'transparent',
                    pointBorderColor: '#00c0ef',
                    pointBackgroundColor: '#00c0ef',
                    fill: false,
                },
                {
                    label: 'جينز',
                    data: jeansData,
                    borderColor: '#0073b7',
                    backgroundColor: 'transparent',
                    pointBorderColor: '#0073b7',
                    pointBackgroundColor: '#0073b7',
                    fill: false,
                },
                {
                    label: 'غسيل',
                    data: washingData,
                    borderColor: '#A8A8A8',
                    backgroundColor: 'transparent',
                    pointBorderColor: '#A8A8A8',
                    pointBackgroundColor: '#A8A8A8',
                    fill: false,
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect,
                callbacks: {
                    label: function (tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += tooltipItem.yLabel + ' قطعة';
                        return label;
                    }
                }
            },
            hover: { mode: mode, intersect: intersect },
            legend: { display: true },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: maxCount,
                        ...ticksStyle
                    }
                }],
                xAxes: [{
                    display: true,
                    gridLines: { display: false },
                    ticks: ticksStyle
                }]
            }
        }
    });
// ========================================================

});



</script>

