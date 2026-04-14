@extends('layouts.app')

@section('title')
    {{__('كل العينات')}}
@endsection

@php
    $currentStatus = request('status'); 
@endphp

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
<style>

.step-container {
    display: flex; /* or use 'grid' for grid layout */
    justify-content: space-around; /* Adjust as needed */
    flex-wrap: wrap; /* Items wrap to next line if there's not enough space */
}

.step {
    flex: 1; /* Flex-grow: Each step takes equal space */
    max-width: 300px; /* Adjust max width as needed */
    margin: 10px; /* Add margin between steps */
    text-align: center; /* Center the content */
}

/* Add media queries to adjust the layout for smaller screens */
@media screen and (max-width: 768px) {
    .step-container {
        flex-direction: column; /* Stack steps vertically on smaller screens */
    }
}

    .clearfix:after {
    clear: both;
    content: "";
    display: block;
    height: 0;
}

.container {
	font-family: 'Lato', sans-serif;
	width: 1000px;
	margin: 0 auto;
}

/* .wrapper {
	display: table-cell;
	height: 400px;
	vertical-align: middle;
} */

.nav {
	margin-top: 40px;
}

.pull-right {
	float: right;
}

a, a:active {
	color: #333;
	text-decoration: none;
}

a:hover {
	color: #999;
}

/* Breadcrups CSS */

.arrow-steps .step {
	font-size: 15px;
	text-align: center;
	color: #fff;
	cursor: pointer;
	margin: 0 3px;
	/* padding: 6px 8px 0px 29px; */
	min-width: 180px;
	float: left;
	position: relative;
	background-color: #666;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none; 
  transition: background-color 0.2s ease;
}

.arrow-steps .step:after,
.arrow-steps .step:before {
	content: " ";
	position: absolute;
	top: 0;
	right: -17px;
	width: 0;
	height: 0;
	border-top: 19px solid transparent;
	border-bottom: 17px solid transparent;
	border-left: 17px solid #666;	
	z-index: 2;
  transition: border-color 0.2s ease;
}

.arrow-steps .step:before {
	right: auto;
	left: 0;
	border-left: 17px solid #fff;	
	z-index: 0;
}

.arrow-steps .step:first-child:before {
	border: none;
}

.arrow-steps .step:first-child {
	border-top-left-radius: 4px;
	border-bottom-left-radius: 4px;
}

.arrow-steps .step span {
	position: relative;
}

.arrow-steps .step span:before {
	opacity: 0;
	content: "✔";
	position: absolute;
	top: -2px;
	left: -20px;
}

.arrow-steps .step.done span:before {
	opacity: 1;
	-webkit-transition: opacity 0.3s ease 0.5s;
	-moz-transition: opacity 0.3s ease 0.5s;
	-ms-transition: opacity 0.3s ease 0.5s;
	transition: opacity 0.3s ease 0.5s;
}

.arrow-steps .step.current {
	color: black;
	background-color: #9c27b0;
}

.arrow-steps .step.current:after {
	border-left: 17px solid #9c27b0;	
}
.current {
        background-color: #9c27b0;
        
    }
   
  
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل العينات</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
            @include('flash::message')

         <div class="clearfix"></div>
        <div class="card">
            <div class="card-body">
                <div class="step-container">
                    <div class="arrow-steps clearfix">
                        <div class="step @if($currentStatus == null ) current  @endif">
                            {!! Form::open(['route' => ['tab_index'], 'method' => 'get', 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                            {{-- <input type="hidden" name="status" value="open"> --}}
                                {!! Form::button(' <h6 style="color: #fff;"> <i class="fas fa-home" ></i> الكل</h6>', [
                                   'type' => 'submit',
                                    'style' => 'background-color: transparent; border: none; ',
                        
                                ]) !!}
                            {!! Form::close() !!} 
                        </div>
                            <div class="step @if($currentStatus === 'open') current @endif">
                                {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                <input type="hidden" name="status" value="open">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-paper-plane" ></i> العينات المستلمة</h6>', [
                                       'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none; ',
                            
                                    ]) !!}
                                {!! Form::close() !!} 
                            </div>

                            <div class="step @if($currentStatus === 'pre_checked') current @endif">
                                    {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                    <input type="hidden" name="status" value="pre_checked">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-check" ></i> على تأكيد استلام المعمل</h6>', [
                                        'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none;',
                                     
                                    ]) !!}
                                    {!! Form::close() !!}
                            </div>
                            <div class="step @if($currentStatus === 'checked') current @endif">
                                    {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                    <input type="hidden" name="status" value="checked">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-flask" ></i> انتظار التشغيل</h6>', [
                                        'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none;',
                                     
                                    ]) !!}
                                    {!! Form::close() !!}
                            </div>
                            <div class="step @if($currentStatus === 'progressing') current @endif"> 
                                    {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                     <input type="hidden" name="status" value="progressing">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-flask" ></i> فى التشغيل</h6>', [
                                        'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none;',
                                     
                                    ]) !!}
                                     {!! Form::close() !!}
                            </div>
                            <div class="step @if($currentStatus === 'pre_finish') current @endif">  
                                    {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                    <input type="hidden" name="status" value="pre_finish">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-check" ></i> انتظار تأكيد خدمة العملاء</h6>', [
                                        'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none;',
                                       
                                    ]) !!}
                                     {!! Form::close() !!} 
                            </div>
                            <div class="step @if($currentStatus === 'finish') current @endif"> 
                                    {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                    <input type="hidden" name="status" value="finish">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-store" ></i> مخزن العينات</h6>', [
                                        'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none;',
                                    
                                    ]) !!}
                                    {!! Form::close() !!} 
                            </div>
                            <div class="step @if($currentStatus === 'closed') current @endif">
                                    {!! Form::open(['route' => ['tab_index'], 'method' => 'get' , 'style'=>'text-align:center; padding-top: 4px;margin-top: 2px;margin-bottom: 0px;']) !!}
                                    <input type="hidden" name="status" value="closed">
                                    {!! Form::button('<h6 style="color: #fff;"> <i class="fas fa-check" ></i> تم التسليم</h6>', [
                                        'type' => 'submit',
                                        'style' => 'background-color: transparent; border: none;',
                                      
                                    ]) !!}
                                    {!! Form::close() !!}
                            </div>
                    </div> 
                </div>    
                    <br>
                    @include('lab_samples.table')
{{--            
                    <table id="table1" class="table table-striped custom-table-width" style="width: 100%;">
                        <thead>
                          <tr>
                            <th scope="col" style="text-align: inherit;">رقم العينة</th>
                            <th scope="col" style="text-align: inherit;">العميل</th>
                            <th scope="col" style="text-align: inherit;">الصنف</th>
                            <th scope="col" style="text-align: inherit;">عدد القطع</th>
                            <th scope="col" style="text-align: inherit;">عدد القطع الاصلية</th>
                            <th scope="col" style="text-align: inherit;">التاريخ</th>
                            <th scope="col" style="text-align: inherit;">تاريخ تشغيل العينة</th>
                            <th scope="col" style="text-align: inherit;">تاريخ الاستلام من المعمل</th>
                            <th scope="col" style="text-align: inherit;">ملاحظات التشغيل</th>
                            <th scope="col" style="text-align: inherit;">تم التسليم</th>
                            <th scope="col" style="text-align: inherit;">تاريخ التسليم</th>

                          </tr>
                        </thead>
                        
                        @if (isset($result))
                        @foreach ($result as $sample)
            
                    <tr>
                        <td>{{$sample->serial}}</td>
                        <td>{{$sample->get_customer->name}}</td>
                        <td>{{$sample->get_products->name}}</td>
                        <td>{{$sample->count}}</td>
                        <td>{{$sample->sample_original_count}}</td>
                        <td>{{$sample->created_at}}</td>
                        <td>{{ $sample->date_progressing }}</td>
                        <td>{{ $sample->date_finish }}</td>
                        <td>
                            @if ($sample->get_activity_for_tab_index)
                            @foreach ($sample->get_activity_for_tab_index as $activity)
                                {{ $activity->note }}
                            @endforeach
                            @endif
                        </td> 
                        <td>
                            @if ($sample->status == 'pre_finish'||$sample->status == 'finish')
                                @if ($sample->get_activity_for_tab_index)
                                    @foreach ($sample->get_activity_for_tab_index as $activity)
                                    {{ $activity->receive_name }}
                                    @endforeach
                                @endif
                            @else
                              {{ $sample->receivable_name }}
                            @endif
                        </td> 
                        <td>{{ $sample->date_deliver }}</td>
                    </tr>
                        
                    @endforeach
                    @endif
                   </table>
            --}}
        
    

            <div class="card-footer clearfix">
                <div class="float-right">
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('third_party_scripts')
    {{-- @include('lab_samples.script')
    <script>
        $(document).ready(function () {
            // Assuming you have jQuery included and DataTables initialized
        var table = $('#table1').DataTable();

        // When you need to reinitialize
        if ($.fn.DataTable.isDataTable('#table1')) {
            table.destroy();
        }

        table = $('#table1').DataTable({
            // DataTable initialization options
            order: [[0, 'desc']]
        });
        // Check if the DataTable already exists before initializing
        if (!$.fn.DataTable.isDataTable('#table1')) {
            $('#table1').DataTable({
                // DataTable initialization options

            });
            
        }

        });
        
    </script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const steps = document.querySelectorAll(".step");
        
        // Load active step from local storage
        const activeStepIndex = localStorage.getItem("activeStepIndex");
        if (activeStepIndex !== null) {
            steps[activeStepIndex].classList.add("current");
        }
        
        steps.forEach((step, index) => {
            step.addEventListener("click", function () {
                // Remove "current" class from all steps
                steps.forEach((s) => s.classList.remove("current"));
                
                // Add "current" class to clicked step
                step.classList.add("current");
                
                // Store active step index in local storage
                localStorage.setItem("activeStepIndex", index);
                
                // Submit the form
                step.querySelector("form").submit();
            });
        });
    });
</script>
@endpush