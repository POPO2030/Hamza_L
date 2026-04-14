@extends('layouts.app')

@section('title')
    {{__('البواقى')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> البواقى</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('residual_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
            
            <div class="form-group col-sm-4">
                {!! Form::label('model', ' الموديل:') !!}
                <select name="model" id="model" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($models as $model)
                        <option value="{{$model->model}}">{{$model->model}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-4">
                {!! Form::label('recepit_id', ' اذن اضافة:') !!}
                <select name="recepit_id" id="recepit_id" class="form-control searchable">
                    <option value="all">الكل</option>
                    @foreach($recepits as $recepit)
                        <option value="{{$recepit->id}}">{{$recepit->id}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-sm-4">
            {!! Form::label('customer_id', ' العميل:') !!}
                <select name="customer_id" id="customer_id" class="form-control searchable">
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
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from',null,['placeholder' => 'من','class'=> 'form-control','id'=>'from', 'data-placeholder'=>"من", 'style'=>"width: 100%"]) }}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to',null,['placeholder' => 'الى','class'=> 'form-control','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>
            
            <div class="form-group col-sm-4">
                
            </div>
            <div class="form-group col-sm-4">
                <input type="submit" value="بحث" class="btn btn-primary col-12" onclick="return validateForm()">
            </div>

           
              

                    </div>
                </div>
            </div>

        
        </div>
</form>
    </div>

@endsection

@push('third_party_scripts')
{{-- <script>

    document.getElementById('dosearch').addEventListener('submit', function(event) {
    var serviceSelect = document.getElementById('recepit_id');
    var selectedOptions = Array.from(serviceSelect.selectedOptions);

    if (selectedOptions.length === 0) {
      event.preventDefault(); // Prevent form submission
      document.getElementById('serviceError').textContent = 'من فضلك اختر خدمة واحدة على الأقل';
    }
  });
</script> --}}
    
<script>
    function validateForm() {
        var model = document.getElementById('model').value;
        var recepit_id = document.getElementById('recepit_id').value;
        var customer_id = document.getElementById('customer_id').value;

        var count = 0;
        if (model != 'all') count++;
        if (recepit_id != 'all') count++;
        if (customer_id != 'all') count++;

        if (count != 1) {
            alert('يرجى اختيار أحد الخيارات  (الموديل، اذن اضافة، العميل)');
            return false;
        }

        return true;
    }
</script>
@endpush
