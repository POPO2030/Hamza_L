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

    @media print {
    @page {
        size: A4 !important;
        margin: 0 !important; 
    }
    body {
        background-color: white !important;
    }
    body * {
        visibility: hidden !important;
    }

    .content.px-3 {
        visibility: visible !important;
    }


    .content.px-3 * {
        visibility: visible !important;
    }

    .content.px-3 {
        position: absolute;
        top: 0;
        left: 20% !important;
        /* right: -100% !important; */
        width: 80% !important;
        margin: 0 !important;
        background-color: white !important;
        padding: 5px !important;
    }
    /* Hide header, footer, sidebar, etc. */
    .header, .main-footer, .footer, .sidebar, .fixed-plugin, .navbar {
        display: none !important;
    }

.col-sm-12.printable.p-10{
    padding: 5 !important;
    display: block;
    font-size: 24px;
    font-weight: bolder;
    margin-bottom: 10px;
}
.hide_column{
            display: none;
        }

             /* Add this to make background graphics visible */
      * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
        }
}
</style>
@endpush

@section('title')
    {{__(' تقرير رصيد الاصناف')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i>  تقرير رصيد الاصناف  </h1>
                </div>

                <div class="col-sm-6">
                    <a class="btn btn-primary btn-sm float-left"
                       href="{{ route('total_Products_report') }}">
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

       

        <div class="clearfix"></div>

        <div class="card">
   
            <div class="col-sm-12 printable p-10" id="title">
                <p>تقرير رصيد الاصناف</p>
            </div>

            <table class="table table-striped" id="tab">
                @if(!empty($request->from) && !empty($request->to))
                    <tr>
                    <td colspan="8" class="text-center">
                        <span class="badge badge-primary rounded" style="font-size: 18px; border: none;">
                            من : {{ $request->from }}
                        </span>

                        <span class="badge badge-primary rounded" style="font-size: 18px; border: none;">
                            الى : {{ $request->to}}
                        </span>
                    </td>
                    </tr>
               @endif
                <tr id="head">
                    <th>المخزن</th>
                    <th>المورد</th>
                    <th>الكود</th>
                    <th>الصنف</th>

                    <th>الوحده</th>

                    <th>الرصيد الحالي</th>
                    <th>صوره الصنف</th>
                      
                    {{-- <th>
                    @can('product_price')    
                    السعر
                    @endcan
                    </th> --}}
                    <th class="hide_column"> كارته الصنف</th>

                </tr>
                    <tbody>
                          {{-- عرض  المنتجات --}}
                        @if(isset($result))
                        @foreach($result as $item)
                     
                                <tr> 	
                                    <td>{{$item->get_store->name}}</td>
                                    <td>
                                    @if(isset($item->get_supplier))
                                        {{$item->get_supplier->name}}
                                    @endif
                                    </td>
                                    <td>
                                        {{ $item->get_product_color->get_product->manual_code }}  
                                        {{-- {{ $item->get_product_color->get_product->system_code }} --}}
                                    </td>
                                    <td>
                                
                                {{ optional($item->get_product_color->get_product)->name ? $item->get_product_color->get_product->name  : '' }}
                                @if($item->get_product_color->get_color->colorCategory_id !=1 && $item->get_product_color->get_color->color_code_id !=1)
                                 ({{ $item->get_product_color->get_color->invcolor_category->name }} - {{ $item->get_product_color->get_color->get_color_code->name }} )
                                @elseif($item->get_product_color->get_color->colorCategory_id !=1 && $item->get_product_color->get_color->color_code_id ==1)
                                 ({{ $item->get_product_color->get_color->invcolor_category->name }})
                                 @elseif($item->get_product_color->get_color->colorCategory_id ==1 && $item->get_product_color->get_color->color_code_id !=1)
                                 ({{ $item->get_product_color->get_color->get_color_code->name }} )
                                @endif
                                    </td>
                                    <td>
                                        @foreach ($item->get_unit_content as $units)
                                        @if ( $units->unitcontent == 1)  {{$units->get_unit->name}} @endif
                                        {{-- {{$item->get_unit->name}}  --}}
                                        @endforeach
                                    </td>

                                    <td>
                                        <span class="badge badge-info" style="font-size: 14px ; width: 80px;">{{ (float) $item->sum }}</span>
                                    </td>

        

                                    <td>
                                        @foreach($item->get_product_color->images as $data)
                                            <img src="{{ asset('uploads/products/' . $data->img) }}" class="hover-image"  alt="">
                                            @endforeach
                                            <div id="clone-container" class="clone-image"></div>
                                    </td>
                                    <td class="hide_column">
                                     
                                        <form method="post" action="{{ route('product_report_result') }}" style="text-align: center;">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                            <input type="hidden" name="from" value="{{ $request->from  }}"> 
                                            <input type="hidden" name="to" value="{{ $request->to  }}">    
                                            <input type="hidden" name="store_id" value="{{ $request->store_id  }}">    
                                            <input type="hidden" name="supplier_id" value="{{ $request->supplier_id  }}">    
                                            <input type="hidden" name="color_id" value="{{ $request->color_id  }}">    
                                            <input type="hidden" name="category_id" value="{{ $request->category_id  }}">    
                                            
                                            <button type="submit" style="background: none; border: none; text-align: center;">
                                                <i class="fa fa-eye"></i> 
                                            </button>
                                        </form>
                                        
                                    </td>
                                    
                                </tr>

                        @endforeach
                        @endif

                    </tbody>
                </table>
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
