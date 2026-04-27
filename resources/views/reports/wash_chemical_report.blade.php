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
    {{__('تقرير الكيماويات المصرفه للغسه')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقرير الكيماويات المصرفه للغسه</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('wash_chemical_report_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row justify-content-center">
               <!-- Category Id Field -->

            <div class="form-group col-sm-6">
                {!! Form::label('work_order_id', 'رقم السغله:') !!}
                <select name="work_order_id" class="form-control searchable" required>
                    <option value="">اختر رقم الغسله</option>
                    @foreach($workorder as $workorders)
                        <option value="{{ $workorders->id }}">غسله رقم {{ $workorders->id }} - العميل : {{ $workorders->get_customer->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-sm-6">
                {{-- {!! Form::label('balance', 'الرصيد:') !!}
                <select name="balance" class="form-control searchable">
                    <option value="all">الكل</option>
                    <option value="not1">الرصيد فقط</option>
                </select> --}}
            </div>



            <div class="form-group col-sm-6">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-6">
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
                            <img src="{{ asset('images/product_report.jpg') }}" />
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
