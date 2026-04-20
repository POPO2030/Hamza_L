@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
<style>
    img {
        max-width: 100%;
        max-height: 100%;
        display: block;
        margin: 0 auto; 
    }
</style>
@endpush

@section('title')
    {{__('تقرير رصيد الاصناف')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقرير رصيد الاصناف</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('total_Products_report_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row justify-content-center">
               <!-- Category Id Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('store_id', 'المخزن :') !!}
                <select name="store_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($inv_stores as $inv_store)
                        <option value="{{$inv_store->id}}">{{$inv_store->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-sm-4">
                {!! Form::label('supplier_id', 'المورد:') !!}
                <select name="supplier_id" class="form-control searchable">
                <option value="all" selected>الكل</option>

                 @foreach($suppliers as $supplier)
                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                 @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('color_id', 'اللون :') !!}
                <select name="color_id" class="form-control searchable">
                    <option value="all" selected>الكل</option>
    
                     @foreach($colors as $color)
                     {{-- @if (!count($color->product_color_product))
                     @continue;
                     @else --}}
                    <option value="{{$color->id}}">{{$color->invcolor_category->name}}</option>
                    {{-- @endif  --}}
                    @endforeach
                    </select>

            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('category_id', 'مجموعه المنتج:') !!}
                <select name="category_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($cats as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}">{{ $categoryName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('product_id', 'الصنف:') !!}
                <select name="product_id" class="form-control searchable"  dir="rtl" >
                    <option value="all">الكل</option>
                    @foreach($products as $product)
                <option value="{{$product->id}}">

                {{ $product->get_product->manual_code }} - 
                {{ optional($product->get_product)->name ? $product->get_product->name  : '' }}
                @if($product->get_color->colorCategory_id !=1 && $product->get_color->color_code_id !=1)
                 ({{ $product->get_color->invcolor_category->name }} - {{ $product->get_color->get_color_code->name }} )
                @elseif($product->get_color->colorCategory_id !=1 && $product->get_color->color_code_id ==1)
                 ({{ $product->get_color->invcolor_category->name }})
                 @elseif($product->get_color->colorCategory_id ==1 && $product->get_color->color_code_id !=1)
                 ({{ $product->get_color->get_color_code->name }} )
                @endif

                </option>
                @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('balance', 'الرصيد:') !!}
                <select name="balance" class="form-control searchable">
                    <option value="all">الكل</option>
                    <option value="not1">الرصيد فقط</option>
                </select>
            </div>



            <div class="form-group col-sm-4">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>        


            <div class="form-group col-sm-4 text-center" style="margin-top:30px;">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
            </div>
        </form>

                </div>
                </div>
                <div>
                    <div> 
                            <img src="{{ asset('images/store_total.jpg') }}" />
                    </div>
                </div>
                
                
                

        </div>
    </div>


    </div>

@endsection

@push('third_party_scripts')
<script>

    document.getElementById('dosearch').addEventListener('submit', function(event) {
    var serviceSelect = document.getElementById('service_id');
    var selectedOptions = Array.from(serviceSelect.selectedOptions);

    if (selectedOptions.length === 0) {
      event.preventDefault(); // Prevent form submission
      document.getElementById('serviceError').textContent = 'من فضلك اختر خدمة واحدة على الأقل';
    }
  });
</script>
    
@endpush
