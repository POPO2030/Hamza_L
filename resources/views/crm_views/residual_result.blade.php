@extends('layouts.app')

@section('title')
    {{__('تقرير البواقى')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-3">
                    <h1><i class="fas fa-scroll"></i> تقرير البواقى</h1>
                   
                </div>
                
                    
            
                <!-- <div class="col-sm-2">
                </div> -->
                <div class="col-sm-3" style="font-weight: bold;">
                @if (isset($row_count))
                    <h4> عدد اذونات الاضافة:  <span class="badge badge-primary">{{$row_count}}</span></h4>
                @else
                    <h4> عدد اذونات الاضافة:  <span class="badge badge-primary">{{0}}</span></h4>
                @endif
                </div>
                  {{-- <div class="col-sm-2" style="font-weight: bold;">
                     <h4>   الاجمالى:  <span class="badge badge-info">{{$total_qty_sum}}</span></h4>
                  </div> --}}
                  <div class="col-sm-2" style="font-weight: bold;">
                    @if (isset($resudial_sum))
                     <h4>   اجمالى البواقى:  <span class="badge badge-primary">{{$resudial_sum}}</span></h4>
                     @else
                     <h4>   اجمالى البواقى:  <span class="badge badge-primary">{{0}}</span></h4>
                     @endif
                  </div>
                
                <div class="col-sm-4">

                  
                    <a class="btn btn-primary float-left"
                       href="{{ route('residual') }}">
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

        <div class="card">
   
          

            <table class="table table-striped" id="tab">
                <tr id="head">
                    
                    <th>اذن اضافة</th>
                    <th> الغسلات</th>
                    <th>الوزن</th>
                    <th>العدد</th>

                    <th>الموديل</th>
                    <th>العميل</th>
                    <th>المستلم</th>
                    <th>المنتج</th>

                    <th>كميات تم الانتهاء</th>
                
                    <th>المتبقى</th>
                    <th>التاريخ</th>

                    <th>عرض</th>

                </tr>
                @if(isset($result))

                    @php $resudial_sum=0; @endphp

                @foreach($result as $item)
                  
                {{-- ==================================================================================================================== --}}
                
                {{-- ==================================================================================================================== --}}
                     <!-- ===========in & out production======= -->
                    <tr>
                        <td>{{$item->id}}</td>
                    
                        <td>
                            @php  $total_qty_sum=0;   @endphp
                            @foreach ($item->get_work_orders_for_deliver_for_details as $work_orders)
                                @php
                                    if(isset($work_orders->total_sum)){
                                        $total_qty_sum+=$work_orders->total_sum;
                                    }
                                @endphp
                                @if ($work_orders->product_count - $work_orders->total_sum <= 0)
                                    {{-- <!-- <span class="badge badge-danger">  {{ $work_orders->id }} </span> --> --}}
                                    <a href="{{ route('workOrders.show', $work_orders->id) }}" class='btn btn-danger btn-sm rounded'>
                                      <!-- <i class="fa fa-eye"></i> -->
                                      <span>  {{ $work_orders->id }} </span>
                                    </a>
                                    @else
                                    {{-- <!-- <span class="badge badge-success">  {{ $work_orders->id }} </span> --> --}}
                                    <a href="{{ route('workOrders.show', $work_orders->id) }}" class='btn btn-success btn-sm rounded'>
                                      <!-- <i class="fa fa-eye"></i> -->
                                      <span>  {{ $work_orders->id }} </span>
                                    </a>
                                @endif
                            
                                
                            @endforeach
                        </td>
                        <td>{{$item->final_weight}}</td>
                        <td>{{$item->final_count}}</td>
                    
                        <td>{{$item->model}}</td>
                        <td>{{$item->get_customer->name}}</td>
                        @if (isset($item->get_receivables))
                        <td>{{$item->get_receivables->name}}</td>
                        @endif
                        
                        <td>{{$item->get_product->name}} {{ $item->product_type ? ' (' . $item->product_type . ')' : '' }}</td>
                        
                        <td>{{ $total_qty_sum }}</td>

                        <td> {{  $item->final_count - $total_qty_sum }}</td>   <!-------  الباقى -------->

                        <td>{{$item->created_at}}</td>

                        <td>
                        <a href="{{ route('get_work_order', ['receiveReceipt_id' => $item->id, 'customer_id' => $item->customer_id]) }}" class="btn btn-link btn-default btn-just-icon">
                            <i class="fa fa-eye"></i>
                        </a>
                        </td>
                    
                    </tr>
                @endforeach
                    @endif



                
                {{-- <tr>
    <td style="font-weight: bold;"> عدد الوجبات:  <span class="badge badge-info">{{$row_count}}</span></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-weight: bold;"> الاجمالى:  <span class="badge badge-info">{{$product_sum}}</span></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr> --}}
            </table>
                    
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
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }

</script>