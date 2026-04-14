@extends('layouts.app')

@section('title')
    {{__('تقارير اذون التسليم')}}
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2" style="background-color: #f2f2f2; height: 50px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">

                <div class="col-sm-6">
                   
                    <h1>
                        <i class="fas fa-scroll"></i>
                        تقرير اذون التسليم 
                    </h1> 
                </div>

            </div>
        </div>
    </section>

    

    <div class="content px-3">

       

        <div class="clearfix"></div>

        <Form method="post" id="dosearch" action="{{URL('final_delivers_result')}}">
        @csrf
        <div class="card">

            <div class="card-body row">

                <div class="form-group col-sm-4">
                    {!! Form::label('final_deliver_order_id', 'اذن التسليم:') !!}
                    <select name="final_deliver_order_id" class="form-control searchable">
                        <option value="all">الكل</option>
                        @foreach($final_deliver_order_ids as $final_deliver)
                            <option value="{{$final_deliver->final_deliver_order_id}}">{{$final_deliver->final_deliver_order_id}}</option>
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
                    {!! Form::label('work_order_id', 'الغسلة:') !!}
                    <select name="work_order_id" class="form-control searchable">
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
                    {!! Form::label('model', ' الموديل:') !!}
                    <select name="model" id="model" class="form-control searchable">
                        <option value="all">الكل</option>
                        @foreach($models as $model)
                            <option value="{{$model->model}}">{{$model->model}}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- <div class="form-group col-sm-4">
                    {!! Form::label('receivable_id', 'المستلم:') !!}
                    <select name="receivable_id" class="form-control searchable">
                        <option value="all" selected>الكل</option>
                        @foreach($receivables as $receivable)
                            <option value="{{$receivable->id}}">{{$receivable->name}}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="form-group col-sm-4">
                    {!! Form::label('flag_inovice', 'الحالة:') !!}
                        <select name="flag_inovice" id="flag_inovice" class="form-control searchable">
                            {{-- <option value="all">الكل</option> --}}
                            <option value="1">له فاتورة</option>
                            <option value="0">ليس له فاتورة</option>
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
                    <input type="submit" value="بحث" class="btn btn-primary col-12">
                </div>

            </div>
        </div>
        </Form>
    </div>
    


    














@endsection

<!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->
<script type="text/javascript"  src="{{ asset('datatables_js/xlsx.full.min.js') }}" ></script>
{{-- <script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script> --}}

<script>
    function ExportToExcel(type, fn, dl) {
        var elt = document.createElement('div');
        
        // Clone and append the morning table
        var table1 = document.getElementById('tab').cloneNode(true);
        elt.appendChild(table1);
    
        // Add a line break between the tables
        elt.appendChild(document.createElement('br'));
    
        // Clone and append the evening table
        var table2 = document.getElementById('tab1').cloneNode(true);
        elt.appendChild(table2);
    
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    
        if (dl) {
            var wbout = XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' });
            saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), fn || ('انتاجية الميزان.' + (type || 'xlsx')));
        } else {
            XLSX.writeFile(wb, fn || ('انتاجية الميزان.' + (type || 'xlsx')));
        }
    }
    
    // Convert data to array buffer
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    </script>