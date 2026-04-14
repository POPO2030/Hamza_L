<div class="form-group col-sm-4">
    {!! Form::label('sample_id', ' العينة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('sample_id', $sample_id, null, ['class' => 'form-control searchable','id'=>'sample_id', 'data-placeholder' => 'اختر رقم العينة', 'style' => 'width: 100%'],['option'=>'sample_id']) }}
</div>
<div id="table-holder">
    {{-- <div class="form-group col-sm-4">
        {!! Form::label('service_item_id', ' اسم الخدمة: <span style="color: red">*</span>', [], false) !!}
        <select name="service_item_id" id="service_item_id" class="form-control searchable">
            @foreach ($services as $service)
            @if ($service->id == $row->service_item_id)
            <option value="{{ $service->id }}" selected>{{ $service->name }}</option>
            @else
            <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endif
                
            @endforeach
        </select>
    </div> --}}
    <button type="button" class="btn btn-primary" onclick="add_satge()">اضافة مرحلة</button>
    <br>
    <?php $ids = []; $unique_id=[];?>
@for ($i=0; $i<count($stage_ids) ; $i++)
@php array_push($ids , $stage_ids[$i])  @endphp
<div>



<select name="stage_id[]" id="">
    @foreach ($stages as $stage)
        @if ($stage_ids[$i] == $stage->id)
        <option value="{{ $stage->id }}" selected>{{ $stage->name }}</option>
        @else
        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
        @endif
    @endforeach
</select>

<button class="btn btn-primary" onclick="add_row(this)" type="button"><i class="fa fa-plus"></i></button>
<button class="btn btn-danger" onclick="remove_stage(this)" type="button"><i class="fa fa-trash"></i></button>






<table class="table table-boder">
    <tr>
        <td>المواد الكميائية</td>
        <td>النسبة / لتر</td>
        <td>الدقة / التركيز</td>
        <td>الباور</td>
        <td>زمن	</td>
        <td>ملاحظات</td>
        <td>حذف</td>
    </tr>
    @foreach ($createFashionSample as $sample)
    @php
        
        if (!in_array($sample->stage_id, $ids)){
            break;
        }
        if (in_array($sample->id, $unique_id)){
            continue;
        }
        
        
    @endphp
        <tr>
            <td>
                <select name="product_id_{{$sample->stage_id}}[]" id="">
                @foreach ($products as $product)
                    @if ($sample->product_id == $product->id)
                    <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                    @else
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endif
                @endforeach
            </select>
            </td>
            <td><input type="text" value="{{ $sample->ratio }}" name="ratio_{{$sample->stage_id}}[]"></td>
            <td><input type="text" value="{{ $sample->resolution }}" name="resolution_{{$sample->stage_id}}[]"></td>
            <td><input type="text" value="{{ $sample->power }}" name="power_{{$sample->stage_id}}[]"></td>
            <td><input type="text" value="{{ $sample->time }}" name="time_{{$sample->stage_id}}[]"></td>
            <td><input type="text" value="{{ $sample->note }}" name="note_{{$sample->stage_id}}[]"></td>
            <td><button class="btn btn-danger" onclick="remove_row(this)"><i class="fa fa-trash"></i></button></td>
        </tr>
@php 

array_push($unique_id , $sample->id);


@endphp
    @endforeach
</table>  

</div>
@endfor

</div>



<script>
            function add_satge(){
        var stages = {!! json_encode($stages) !!};
        var container = document.createElement("div");
        var header_div = document.createElement("div");
        container.classList.add('div_style')
        var select = document.createElement("select");
        select.setAttribute('name','stage_id[]')
        select.classList.add('stage_id','form-control','searchable')
        place_holder=document.createElement("option");
        place_holder.innerText="اختر مرحلة"
        place_holder.value=""
        select.appendChild(place_holder)
        for (let i = 0; i < stages.length; i++) {
            option = document.createElement("option");
            option.value=stages[i].id
            option.innerText=stages[i].name
            select.appendChild(option)
        }
        var add_btn = document.createElement("button");
        add_btn.innerText="اضافة"
        add_btn.classList.add('btn' , 'btn-primary');
        add_btn.setAttribute("type", "button");
        add_btn.setAttribute("onclick", "add_row(this,2)");

        var remove_stage = document.createElement("button");
        remove_stage.innerText="حذف"
        remove_stage.classList.add('btn' , 'btn-danger');
        remove_stage.setAttribute("type", "button");
        remove_stage.setAttribute("onclick", "remove_row(this)");

        var table = document.createElement("table");
        table.classList.add('table','table-border')
        var row = document.createElement("tr");

        var td1 = document.createElement("td");
        td1.innerText="المواد الكميائية"

        var td2 = document.createElement("td");
        td2.innerText="النسبة / لتر"

        var td3 = document.createElement("td");
        td3.innerText="الدقة / التركيز"

        var td4 = document.createElement("td");
        td4.innerText="الباور"

        var td5 = document.createElement("td");
        td5.innerText="زمن"

        var td6 = document.createElement("td");
        td6.innerText="ملاحظات"

        row.append(td1,td2,td3,td4,td5,td6)
        table.appendChild(row)
        header_div.append(select,add_btn,remove_stage)
        container.appendChild(header_div)
        container.appendChild(table)
        document.getElementById('table-holder').appendChild(container)

        select.addEventListener('change', function () {
        var rows = table.querySelectorAll('tr');
        if (rows.length > 1) {
            this.selectedIndex = this.dataset.prevSelectedIndex || 0;
            alert('عفوآ...لا يمكن تغيير المرحله اذا تم اضافه الرسبي لها');
        } else {
            this.dataset.prevSelectedIndex = this.selectedIndex;
        }
    });

    }




    function add_row(obutton , x=1){

var selects=document.getElementsByClassName('stage_id')

for (let x = 0; x < selects.length; x++) {
    if(selects[x].value==""){
        alert('يجب اختيار مرحلة')
        var check=1
    }
    
}
var row = document.createElement("tr");

var select_value = obutton.parentNode.childNodes[0].value
var td1 = document.createElement("td");
var products = {!! json_encode($products) !!};
var select = document.createElement("select");
select.setAttribute('name','product_id_'+select_value+'[]')
for (let i = 0; i < products.length; i++) {
    option = document.createElement("option");
    option.value=products[i].id
    option.innerText=products[i].name
    select.appendChild(option)
}
td1.appendChild(select)


var td2 = document.createElement("td");
var input2 = document.createElement("input");
input2.setAttribute('type','text')
input2.setAttribute('name','ratio_'+select_value+'[]')
input2.classList.add('form-control')
td2.appendChild(input2)

var td3 = document.createElement("td");
var input3 = document.createElement("input");
input3.setAttribute('type','text')
input3.setAttribute('name','resolution_'+select_value+'[]')
input3.classList.add('form-control')
td3.appendChild(input3)

var td4 = document.createElement("td");
var input4 = document.createElement("input");
input4.setAttribute('type','text')
input4.setAttribute('name','power_'+select_value+'[]')
input4.classList.add('form-control')
td4.appendChild(input4)

var td5 = document.createElement("td");
var input5 = document.createElement("input");
input5.setAttribute('type','text')
input5.setAttribute('name','time_'+select_value+'[]')
input5.classList.add('form-control')
td5.appendChild(input5)

var td6 = document.createElement("td");
var input6 = document.createElement("input");
input6.setAttribute('type','text')
input6.setAttribute('name','note_'+select_value+'[]')
input6.classList.add('form-control')
td6.appendChild(input6)

var td7 = document.createElement("td");
var delete_row = document.createElement("button");
delete_row.classList.add('btn','btn-danger')
var icon = document.createElement("i");
icon.classList.add('fa','fa-trash')
delete_row.appendChild(icon)
delete_row.setAttribute('onclick','remove_row(this)')
delete_row.setAttribute('type','button')
td7.appendChild(delete_row)


row.append(td1,td2,td3,td4,td5,td6,td7)
if(check==1){

}else{
    if(x==2){
        obutton.parentNode.parentNode.childNodes[1].appendChild(row)
    }

obutton.parentNode.childNodes[7].appendChild(row)
}

}

function remove_row(param){
param.parentNode.parentNode.remove()
}


function remove_stage(param2){
    param2.parentNode.remove()
}
</script>