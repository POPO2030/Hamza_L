@extends('layouts.app')

@section('title')
    {{__('تقارير مخزن الجاهز')}}
@endsection

<style>
       /* Custom style for the modal dialog */
   .custom-modal-dialog {
    top: -50%;
    transform: translateY(-50%);
  }
 .modal-header{
    background-color: #d1d0d093
  }
 .modal-body{
  background-color: rgba(0,0,0,0)!important;
  }
</style>




  
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">

                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i>  تقارير مخزن الجاهز </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-left" href="{{ route('readyreports') }}">
                      رجوع
                    </a>
                
                    <button class="btn btn-primary float-left" onclick="ExportToExcel('xlsx')" style="margin-left: 10px;"> تصدير الى الاكسيل
                      <i class="fas fa-print"></i>
                    </button>
                    @can("deliverOrders_finance_customers")
                    @if(count($receive_name)>0)
                        <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#modal-default" style="margin-left: 10px;">  تسليم 
                            <i class="fas fa-truck"></i>
                        </button>
                    @endif
                    @endcan
                  </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <div class="card">




            <table class="table table-bordered table-striped table-hover" id="tab">
                <tr>
                    <th> الغسلة</th>
                    <th>اذن اضافة</th>
                    <th>الموديل</th>
                    <th>العميل</th>
                    <th>تسليم الى</th>
                    <th>المنتج</th>
                    <th>كمية الغسلة</th>
                    <th>الكمية</th>
                    <th>الوزن</th>
                    <th>عدد الاكياس</th>
                    <th>المتبقى</th>
                    <th>عرض</th>
                </tr>
                @if(isset($result))
                @foreach($result as $item)
                        @php $total_package=0; $total_weight=0; @endphp
                    @foreach ($item->get_details as $count)
                        @php  
                            $total_package += $count->total; 
                            $total_weight += $count->weight; 
                        @endphp
                    @endforeach

                        @php $total_ready=0; $total_weight_ready=0; @endphp
                    @foreach ($item->get_final_deliver as $count)
                        @php  
                            $total_ready += $count->total; 
                            $total_weight_ready += $count->weight; 
                        @endphp
                    @endforeach
                {{-- @if ($item->get_count_product->product_count -  $total_package == 0 && $item->status== 'closed' )
                    @continue;
                @else --}}
                        {{--  --------حساب عدد الاكياس الجاهزه من اللى تم التسليم--------  --}}
                            @php $total_package_p=0; @endphp
                            @foreach ($item->get_details as $count)
                                @php  $total_package_p += $count->package_number; @endphp
                            @endforeach

                            @php $total_ready_p=0; @endphp
                            @foreach ($item->get_final_deliver as $count)
                                @php  $total_ready_p += $count->package_number; @endphp
                            @endforeach


                    <tr>
                        <td>{{$item->work_order_id}}</td>
                        <td>{{$item->receipt_id}}</td>
                        <td>{{$item->get_receive_receipt->model}}</td>
                        <td>{{ $item->get_customer->name }}</td>
                        <td>{{ $item->get_receivable->name }}</td>
                        <td>{{ $item->get_products->name }}{{ $item->product_type ? ' (' . $item->product_type . ')' : '' }}</td>
                        <td>{{ $item->get_count_product->product_count }}</td>

                        <td>                                               <!------- الكمية الجاهزة ------>
                           
                            @if ($item->status == 'open')
                            {{ $total_package -  $total_ready}}
                            @else
                            {{ $total_ready }}  
                            @endif
                            
                        </td>

                        <td>                                                <!------- الوزن ------>
                            @if ($item->status == 'open')
                            {{ $total_weight -  $total_weight_ready}}
                            @else
                            {{ $total_weight_ready }}  
                            @endif
                        </td>
                                                                            <!------- عدد الاكياس ------>
                        <td>                                              

                            @if ($item->status == 'open')
                            {{ $total_package_p -  $total_ready_p}}
                            @else
                            {{ $total_ready_p }}  
                            @endif
                        </td>
                   
                        <td>
                            {{ $item->get_count_product->product_count -  $total_package}}
                        </td>
                        
                        
                        <td> 
                            <a href="{{ URL('workOrders', $item->work_order_id) }}" class="btn btn-link btn-default btn-just-icon" >
                                <i class="fa fa-eye"></i>
                              </a>
                              
                        </td>

                    </tr>
                {{-- @endif --}}
                @endforeach
                @endif
            </table>


        </div>
    </div>



    <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اختر جهة التسليم</h5>
        {{-- <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
        </button> --}}
        </div>
        <div class="modal-body">
            @foreach($result as $item)
          <form method="post" action="{{ URL('deliverOrders_finance_customers/'.$item->customer_id) }}" style="display: block; position: relative; padding: 3px 0;  text-align: center; background-color: rgba(0,0,0,0);">
            @endforeach
          @csrf
            <div class="form-group col-sm-12">
            {!! Form::label('receive_name', 'جهة التسليم:') !!}
            {{ Form::select('receive_name', $receive_name, null, ['class' => 'form-control searchable', 'data-placeholder' => 'اختر جهة التسليم', 'style' => 'width: 100%']) }}
        </div>
        </div>
        <div class="modal-footer" style="direction: ltr;">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">إلغاء</button> &nbsp; &nbsp;
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
        </div>
        </div>
      </form>


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