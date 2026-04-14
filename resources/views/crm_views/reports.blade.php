@extends('layouts.app')

@section('title')
    {{__('متابعة مراحل الانتاج')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> متابعة مراحل الانتاج</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('followup_report')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
               <!-- Category Id Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('stage_id', 'مراحل الانتاج:') !!}
                <select name="stage_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($stages as $stage)
                        <option value="{{$stage->id}}">{{$stage->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
            {!! Form::label('customer_id', ' العميل:') !!}
                <select name="customer_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-sm-4">
                {!! Form::label('receivable_id', 'المستلم:') !!}
                <select name="receivable_id" class="form-control searchable">
                <option value="all" selected>الكل</option>

                 @foreach($receivables as $receivable)
                <option value="{{$receivable->id}}">{{$receivable->name}}</option>
                 @endforeach
                </select>
            </div>


            
            <div class="form-group col-sm-4">
                {!! Form::label('workorder_id', 'الغسلة:') !!}
                <select name="workorder_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($work_orders as $work_order)
                        <option value="{{$work_order->id}}">{{$work_order->id}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('recepit_id', ' اذن اضافة:') !!}
                <select name="recepit_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($recepits as $recepit)
                        <option value="{{$recepit->id}}">{{$recepit->id}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('place_id', 'المكان:') !!}
                <select name="place_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($places as $place)
                        <option value="{{$place->id}}">{{$place->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('service_id', 'الخدمات:') !!}
                <select name="service_id[]" id="service_id" class="form-control searchable" multiple>
                    <option value="all" selected>الكل</option>
                    @foreach($services as $service)
                        <option value="{{$service->id}}">{{$service->name}}</option>
                    @endforeach
                </select>
                <span id="serviceError" style="color: red;"></span> 
            </div>



            <div class="form-group col-sm-4">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control searchable ','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control searchable ','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
            {!! Form::label('to', 'حالة التنفيذ:') !!}
                <select name="status" id="status" class="form-control searchable">
                    <option value="open">قيد التنفيذ</option>
                    <option value="closed">تم التنفيذ</option>
                </select>
            </div>

            <div class="form-group col-sm-4">
            {!! Form::label('to', 'حالة الانتاج:') !!}
                <select name="is_production" class="form-control searchable">
                    <option value="all" selected>الكل</option>
                    <option value="fales">على الارض</option>
                    <option value="true">داخل الانتاج</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                
            </div>
            <div class="form-group col-sm-4">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
            </div>

           
              

                    </div>
                </div>
            </div>

        
        </div>
</form>
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
