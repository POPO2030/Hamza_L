@extends('layouts.app')


<style>
    img {
        max-width: 100%;
        max-height: 100%;
        display: block;
        margin: 0 auto; 
    }
</style>

@section('title')
{{ __('تقارير يوميه خزينه ') }}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h3 class="fas fa-scroll" style="color:#17a2b8;"> تقارير يوميه خزينه </h3>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('treasuries_report_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row">

            <div class="form-group col-sm-6">
                {!! Form::label('from', 'من:') !!}
                {{ Form::date('from', now(), ['placeholder' => 'من', 'class' => 'form-control searchable', 'id' => 'from', 'data-placeholder' => 'من', 'style' => 'width: 100%']) }}            
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('to', 'الى:') !!}
                {{ Form::date('to', date('Y-m-d', strtotime('+1 day')), ['placeholder' => 'الى','class'=> 'form-control searchable','id'=>'to', 'data-placeholder'=>"الى", 'style'=>"width: 100%"]) }}
            </div>


            <div class="form-group col-sm-4" style="margin-top:30px;">

            </div>
            <div class="form-group col-sm-4" style="margin-top:30px;">
                <input type="submit" value="بحث" class="btn btn-primary col-12">
            </div>
            <div class="form-group col-sm-4" style="margin-top:30px;">

            </div>
        </form>
   
                    </div>
                </div>
                <div>
                    <div>
                        <img style="height: 35%" src="{{ asset('images/treasuries-bg.jpg') }}">
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
