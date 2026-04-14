@extends('layouts.app')

@section('title')
    {{__('تحليل الاداء')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h3 class="fas fa-scroll" style="color:#17a2b8;"> تحليل الاداء</h3>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('dashboard_report_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
            
            <div class="form-group col-sm-6">
                {!! Form::label('from_month_year', 'شهر:') !!}
                {{-- {{ Form::selectMonth('from', now()->format('m'), ['placeholder' => 'من', 'class' => 'form-control searchable', 'id' => 'from', 'data-placeholder' => 'من', 'style' => 'width: 100%']) }} --}}
                {{ Form::select('from_month_year', $monthsYears, now()->format('M-Y'), [
                    'placeholder' => 'اختر الشهر',
                    'class' => 'form-control searchable',
                    'id' => 'from_month_year',
                    'data-placeholder' => 'اختر الشهر',
                    'style' => 'width: 100%'
                ]) }}
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


@endpush
