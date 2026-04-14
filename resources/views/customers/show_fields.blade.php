
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

.small-box {
  border-radius: 0.25rem;
  box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
  display: block;
  margin-bottom: 20px;
  position: relative;
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

.small-box>.inner {
  padding: 10px;
}


    </style>

<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'الأسم:') !!}
    <p>{{ $customer->name }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-6">
    {!! Form::label('phone', 'التليفون:') !!}
    <p>{{ $customer->phone }}</p>
</div>

<!-- Mobile Field -->
<div class="col-sm-6">
    {!! Form::label('mobile', 'المحمول:') !!}
    <p>{{ $customer->mobile }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-6">
    {!! Form::label('address', 'العنوان:') !!}
    <p>{{ $customer->address }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-6">
    {!! Form::label('email', 'البريد الألكترونى:') !!}
    <p>{{ $customer->email }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', ' تم الإنشاء:') !!}
    <p>{{ $customer->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', ' تم التحديث:') !!}
    <p>{{ $customer->updated_at }}</p>
</div>

@if (isset($receiveReceipt))
    



 <!-- Small boxes (Stat box) -->
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">receipt</i>
              </div>
              <p class="card-category">اذون الاضافة</p>

              @php $row_count=0; $product_sum=0 ;@endphp
            
                @foreach($receiveReceipt as $item)
                    @php $row_count ++ ;$product_sum+=$item->initial_count @endphp
                @endforeach

              <h4 class="card-title">عدد &nbsp; {{ $row_count }}</h4>
              <h4 class="card-title">كمية &nbsp; {{ $product_sum }}</h4>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons text-info">info</i>
                <a href="{{ URL('get_receive_receipt', ['id' => $customer->id]) }}">معلومات أكثر <i class="fas fa-arrow-circle-left"></i> </a>
              </div>
            </div>
          </div>
        </div>
        

 <!-- Small boxes (Stat box) -->
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">timeline</i>
              </div>
              <p class="card-category">اومر الغسلات الحالية</p>

              @php $row_count_order=0; $product_sum_order=0 ;@endphp

                @foreach($workOrders as $orders)
                  @php $row_count_order ++ ;$product_sum_order+=$orders->product_count @endphp
                @endforeach

              <h4 class="card-title">عدد &nbsp; {{ $row_count_order }}</h4>
              <h4 class="card-title">كمية &nbsp; {{ $product_sum_order }}</h4>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons text-info">info</i>
                {{-- <a href="{{ URL('get_receive_receipt', ['id' => $customer->id]) }}">معلومات أكثر...</a> --}}
                <form method="post" action="{{ route('followup_report') }}" style="display: block; position: relative; padding: 3px 0;  text-align: center;  ">
                  @csrf
                  <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                  <input type="hidden" name="stage_id" value="all">
                  <input type="hidden" name="receivable_id" value="all">
                  <input type="hidden" name="workorder_id" value="all">
                  <input type="hidden" name="recepit_id" value="all">
                  <input type="hidden" name="place_id" value="all">
                  <input type="hidden" name="service_id[]" value="all">
                  <input type="hidden" name="is_production" value="all">
                  <input type="hidden" name="status" value="open">
                  <button type="submit" class="small-box-footer" style="background: none;border: none;text-align: center; color:#9c27b0;">
                    معلومات أكثر <i class="fas fa-arrow-circle-left"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        

 <!-- Small boxes (Stat box) -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">toc</i>
            </div>
            <p class="card-category">الغسلات المنتهية</p>

            @php $row_count_order_close=0; $product_sum_order_close=0 ;@endphp
              @foreach($workOrders_closed as $orders)

                @php $row_count_order_close ++ ;$product_sum_order_close+=$orders->product_count @endphp
              @endforeach

            <h4 class="card-title">عدد &nbsp; {{ $row_count_order_close }}</h4>
            <h4 class="card-title">كمية &nbsp; {{ $product_sum_order_close }}</h4>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons text-info">info</i>
              {{-- <a href="{{ URL('get_receive_receipt', ['id' => $customer->id]) }}">معلومات أكثر...</a> --}}
              <form method="post" action="{{ route('followup_report') }}" style="display: block; position: relative; padding: 3px 0;  text-align: center;">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <input type="hidden" name="stage_id" value="all">
                <input type="hidden" name="receivable_id" value="all">
                <input type="hidden" name="workorder_id" value="all">
                <input type="hidden" name="recepit_id" value="all">
                <input type="hidden" name="place_id" value="all">
                <input type="hidden" name="service_id[]" value="all">
                <input type="hidden" name="is_production" value="all">
                <input type="hidden" name="status" value="closed">
                <button type="submit" class="small-box-footer" style="background: none; border: none; text-align: center; color:#9c27b0; ">
                  معلومات أكثر <i class="fas fa-arrow-circle-left"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

        
 <!-- Small boxes (Stat box) -->
        {{-- <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
                <p>الجاهز</p>
                @php $total_package_p=0 @endphp                 <!------عدد الاكياس---------->
                @php $total_ready_p=0 @endphp
               @php $total_package=0 @endphp            <!------الكمية---------->
               @php $total_ready=0 @endphp
                @foreach ($ready_store as $details)
               
                                 <!------عدد الاكياس---------->
                            @foreach ($details->get_details as $count)
                                @php  $total_package_p += $count->package_number @endphp
                            @endforeach

                            @foreach ($details->get_final_deliver as $count)
                                @php  $total_ready_p += $count->package_number @endphp
                            @endforeach
                                 <!------الكمية---------->
                            @foreach ($details->get_details as $count)
                                @php  $total_package += $count->total @endphp
                            @endforeach

                           
                            @foreach ($details->get_final_deliver as $count)
                                @php  $total_ready += $count->total @endphp
                            @endforeach
                @endforeach

            <h3> عدد الاكياس &nbsp; {{ $total_package_p -  $total_ready_p }}</h3>
            <h3>كمية &nbsp; {{ $total_package -  $total_ready }}</h3>

            </div>
            <div class="icon">
              <i class="fas fa-shopping-bag"></i>
              
            </div>
            <form method="post" action="{{ route('readyfollowup_report') }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; background-color: rgba(0,0,0,.1);">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <input type="hidden" name="workorder_id" value="all">
                <input type="hidden" name="recepit_id" value="all">
                <input type="hidden" name="deliver_orders_id" value="all">
                <input type="hidden" name="receivable_id" value="all">
                <input type="hidden" name="residual" value="not_residual">
                <input type="hidden" name="status" value="open">
                <button type="submit" class="small-box-footer" style="background: none; border: none; text-align: center; color: rgb(255, 255, 255); ">
                  معلومات أكثر <i class="fas fa-arrow-circle-left"></i>
                </button>
              </form>  
        </div>
        </div> --}}
{{-- -----------------------------------------------------------------------------        --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">store</i>
          </div>
          <p class="card-category">مخزن الجاهز</p>

          @php $total_package_p=0 @endphp                 <!------عدد الاكياس---------->
                @php $total_ready_p=0 @endphp
               @php $total_package=0 @endphp            <!------الكمية---------->
               @php $total_ready=0 @endphp
                @foreach ($ready_store as $details)

                  <!------عدد الاكياس---------->
                  @foreach ($details->get_details as $count)
                    @php  $total_package_p += $count->package_number @endphp
                  @endforeach

                  @foreach ($details->get_final_deliver as $count)
                    @php  $total_ready_p += $count->package_number @endphp
                  @endforeach

                    <!------الكمية---------->
                  @foreach ($details->get_details as $count)
                    @php  $total_package += $count->total @endphp
                  @endforeach

                  @foreach ($details->get_final_deliver as $count)
                    @php  $total_ready += $count->total @endphp
                  @endforeach
                @endforeach

          <h4 class="card-title">اكياس &nbsp; {{ $total_package_p -  $total_ready_p }}</h4>
          <h4 class="card-title">كمية &nbsp; {{ $total_package -  $total_ready }}</h4>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons text-info">info</i>
            {{-- <a href="{{ URL('get_receive_receipt', ['id' => $customer->id]) }}">معلومات أكثر...</a> --}}
            <form method="post" action="{{ route('readyfollowup_report') }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; ">
              @csrf
              <input type="hidden" name="customer_id" value="{{ $customer->id }}">
              <input type="hidden" name="workorder_id" value="all">
              <input type="hidden" name="recepit_id" value="all">
              <input type="hidden" name="deliver_orders_id" value="all">
              <input type="hidden" name="receivable_id" value="all">
              <input type="hidden" name="residual" value="not_residual">
              <input type="hidden" name="status" value="open">
              <button type="submit" class="small-box-footer" style="background: none; border: none; text-align: center; color:#9c27b0; ">
                معلومات أكثر <i class="fas fa-arrow-circle-left"></i>
              </button>
            </form>  
          </div>
        </div>
      </div>
    </div>



        <div class="col-md-6">
          <div class="card card-primary card-outline" dir="ltr">
            <div class="card-header">
            <h6 class="card-title" style="text-align:right;">
              <i class="far fa-chart-bar"></i>
              هذا الاسبوع
            </h6>
            {{-- <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
            </button>
            </div> --}}
            </div>
            <div class="card-body">
            <div class="chart">
            <canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
            </div>
            
            </div>
            </div>


    @endif
    


    <script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('datatables_js/Chart.min.js') }}"></script>

    <script>
      jQuery(document).ready(function($) {
        // =============  barChart ==================================================

        var customerChartCanvas = $('#barChart').get(0).getContext('2d');

        // Calculate topTenCustomersData using $dataArray structure
        var customer_data_weekly = [{
            name: '{{ $dataArray['customer'] }}',
            counts: [
                { label: 'غسيل', value: {{ $dataArray['total_count_washing'] }} },
                { label: 'جينز', value: {{ $dataArray['total_count_jeans'] }} },
                { label: 'صباغة', value: {{ $dataArray['total_count_dyeing'] }} }
            ]
        }];

        var barChartData = {
            labels: customer_data_weekly[0].counts.map(item => item.label),
            datasets: customer_data_weekly.map(customer => {
                return {
                    label: customer.name,
                    backgroundColor: ['#A8A8A8', '#0073b7', '#00c0ef'],
                    borderColor: ['#A8A8A8', '#0073b7', '#00c0ef'],
                    borderWidth: 1,
                    data: customer.counts.map(item => item.value)
                };
            })
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{ stacked: true }],
                yAxes: [{ stacked: true, ticks: { beginAtZero: true } }]
            }
        };

        new Chart(customerChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });


        // ========================================================

    });
      
      
      </script>