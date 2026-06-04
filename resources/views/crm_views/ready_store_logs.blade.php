@extends('layouts.app')

@section('title')
    {{__('تقرير Logs مخزن الجاهز')}}
@endsection

@section('content')
     <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div class="col-sm-4">
                    <h1><i class="fas fa-scroll"></i> تقارير مخزن الجاهز عن فترة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

       

        <div class="clearfix"></div>
<Form method="post" id="dosearch" action="{{URL('ready_store_logs_result')}}">
    @csrf
        <div class="card">
            <div class="card-body row">
            


            <div class="form-group col-sm-6">
                <label for="from">من:</label>
                {{-- <input type="date" name="from" placeholder="من" class="form-control" id="from" data-placeholder="من" style="width: 100%"> --}}
                <input type="datetime-local" name="from" class="form-control" id="from" value="{{ now()->subDay()->setTime(7, 0)->format('Y-m-d\TH:i') }}" style="width: 100%">
            </div>
            <div class="form-group col-sm-6">
                <label for="to">الى:</label>
                {{-- <input type="date" name="to" placeholder="الى" class="form-control" id="to" data-placeholder="الى" style="width: 100%"> --}}
                <input type="datetime-local" name="to" class="form-control" id="to" value="{{ now()->subDay()->setTime(19, 0)->format('Y-m-d\TH:i') }}" style="width: 100%">
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
{{-- 
<form action="{{ route('activity_logs_result') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="causer_id"> المستخدم:</label>
            <select name="causer_id" class="form-control searchable">
                <option value="">-- اختر مستخدم --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"> {{ $user->name }} </option>
                @endforeach
            </select>
        </div>

        <!-- Filter by Work Order -->
        <div class="col-md-4">
            <label for="work_order_id"> أمر الشغل:</label>
            <select name="work_order_id" class="form-control searchable">
                <option value="">-- اختر أمر الشغل --</option>
                @foreach($work_orders as $workOrder)
                    <option value="{{ $workOrder->id }}" > {{ $workOrder->id }} </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary d-block w-100">بحث</button>
        </div>
    </div>
</form> --}}





</div>
    {{-- </div> --}}

@endsection

