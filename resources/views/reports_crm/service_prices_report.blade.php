@extends('layouts.app')

@push('page_css')

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
    {{__('تقرير الخدمات المباعة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقرير الخدمات المباعة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('service_prices_report_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row justify-content-center">
               <!-- Category Id Field -->
  

            <div class="form-group col-sm-4">
                {!! Form::label('customer_id', 'العميل:') !!}
                <select name="customer_id" class="form-control searchable">
                <option value="all" selected>الكل</option>

                 @foreach($customers as $customer)
                <option value="{{$customer->id}}">{{$customer->name}}</option>
                 @endforeach
                </select>
            </div>

             

            {{-- <div class="form-group col-sm-4">
                {!! Form::label('branch', 'الفرع :') !!}
                <select name="branch" class="form-control searchable">
                    <option value="all">الكل</option>
                    <option value="1">جسر السويس</option>
                    <option value="2">بلقس</option>
                </select>
            </div> --}}


            {{-- <div class="form-group col-sm-4">
            </div> --}}

            <div class="form-group col-sm-4">
                {!! Form::label('service_item_id', 'الخدمات:') !!}
                <select name="service_item_id" id="service_item_id" class="form-control searchable">
                    <option value="all" selected>الكل</option>
                    @foreach($services as $service)
                        <option value="{{$service->id}}">{{$service->name}}</option>
                    @endforeach
                </select>
                <span id="serviceError" style="color: red;"></span> 
            </div>

              <div class="form-group col-sm-4">
            </div>
            
            <div class="form-group col-sm-4">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>        
            <div class="form-group col-sm-4">
            </div>

            <div class="form-group col-sm-4 text-center" style="margin-top:30px;">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
            </div>
        </form>

                </div>
                </div>
                <div>
                   
                </div>
                
                
                

        </div>
    </div>


    </div>

@endsection

@push('third_party_scripts')

    
@endpush
