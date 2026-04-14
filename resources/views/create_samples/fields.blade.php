@include('flash::message')
<style>
    .div_style{
        box-shadow: 2px 5px #888888;
        margin: 3rem 0;
    }
</style>
<div class="form-group col-sm-4">
    {!! Form::label('sample_id', ' العينة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('sample_id', $sample_id, null, ['class' => 'form-control searchable','id'=>'sample_id', 'data-placeholder' => 'اختر رقم العينة', 'style' => 'width: 100%'],['option'=>'sample_id']) }}
</div>
<div class="parent" style="min-height:300px;border:1px solid gray;padding:2rem;border-radius: 15px;margin-bottom:2rem">
<div>
    <button type="button" class="btn btn-primary" onclick="add_satge()">اضافة مرحلة غسيل</button>
    <button type="button" class="btn btn-primary" onclick="add_fashion_satge()">اضافة مرحلة فاشون</button>
</div>

<div id="table-holder"></div>
</div>

{{-- ==========================fashion====================== --}}

{{-- <div class="parent" style="min-height:300px;border:1px solid gray;padding:2rem;border-radius: 15px;">
    <div>
        <button type="button" class="btn btn-primary" onclick="add_fashion_satge()">اضافة مرحلة فاشون</button>
        </div>
        
        <div id="table-container"></div>
        
</div> --}}



<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>

<script>
        function add_satge(){
        var stages = {!! json_encode($stages) !!};
        var container = document.createElement("div");
        var header_div = document.createElement("div");
        container.classList.add('div_style')
        var select = document.createElement("select");
        select.setAttribute('name','stage_id[]')
        select.classList.add('stage_id','form-control','searchable', 'col-sm-4')
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
// ===========================
index_array=document.getElementsByClassName('rec_index')
        if(index_array.length<1){
        var rec_index = document.createElement("input");
        rec_index.setAttribute("type", "hidden");
        rec_index.setAttribute("name", "wash_rec_index[]");
        rec_index.setAttribute("value",1);
        rec_index.setAttribute("class", "rec_index");
        }else{
            var rec_index = document.createElement("input");
            rec_index.setAttribute("type", "hidden");
            rec_index.setAttribute("name", "wash_rec_index[]");
            rec_index.setAttribute("value",Number(index_array[index_array.length-1].value)+1);
            rec_index.setAttribute("class", "rec_index");
        }
// ==============================


        var add_btn = document.createElement("button");
        add_btn.innerText="اضافة"
        add_btn.classList.add('btn' , 'btn-primary');
        add_btn.setAttribute("type", "button");
        add_btn.setAttribute("onclick", "add_row(this)");

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
        td2.innerText="النسبة / لتر أو كجم"

        var td3 = document.createElement("td");
        td3.innerText="الحرارة / الباور"

        var td4 = document.createElement("td");
        td4.innerText="ماء"

        var td5 = document.createElement("td");
        td5.innerText="زمن"

        var td6 = document.createElement("td");
        td6.innerText="ph"

        row.append(td1,td2,td3,td4,td5,td6)
        table.appendChild(row)
        header_div.append(select,add_btn,remove_stage,rec_index)
        container.appendChild(header_div)
        container.appendChild(table)
        document.getElementById('table-holder').appendChild(container)
        $('.searchable').select2();

    }
    
   

    function add_row(obutton){

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
        select.classList.add('product_id','form-control','searchable')
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
        input3.setAttribute('name','degree_'+select_value+'[]')
        input3.classList.add('form-control')
        td3.appendChild(input3)

        var td4 = document.createElement("td");
        var input4 = document.createElement("input");
        input4.setAttribute('type','text')
        input4.setAttribute('name','water_'+select_value+'[]')
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
        input6.setAttribute('name','ph_'+select_value+'[]')
        input6.classList.add('form-control')
        td6.appendChild(input6)

        var td7 = document.createElement("td");
        var delete_row = document.createElement("button");
        // delete_row.classList.add('btn','btn-danger')
        delete_row.classList.add('btn', 'btn-link', 'btn-danger', 'btn-just-icon');
        var icon = document.createElement("i");
        icon.classList.add('fa','fa-trash')
        delete_row.appendChild(icon)
        delete_row.setAttribute('onclick','remove_row(this)')
        delete_row.setAttribute('type','button')
        td7.appendChild(delete_row)


        row.append(td1,td2,td3,td4,td5,td6,td7)
        if(check==1){

        }else{
        obutton.parentNode.parentNode.childNodes[1].appendChild(row)
        }
        $('.searchable').select2();
    }

    function remove_row(param){
        param.parentNode.parentNode.remove()
}


// ============================fashion============
function add_fashion_satge(){
        var stages = {!! json_encode($fashion_stages) !!};
        var container = document.createElement("div");
        var header_div = document.createElement("div");
        container.classList.add('div_style')
        var select = document.createElement("select");
        select.setAttribute('name','stage_fashion_id[]')
        select.classList.add('stage_id','form-control','searchable', 'col-sm-4')
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

// ===========================
index_array=document.getElementsByClassName('rec_index')
        if(index_array.length<1){
        var rec_index = document.createElement("input");
        rec_index.setAttribute("type", "hidden");
        rec_index.setAttribute("name", "fashion_rec_index[]");
        rec_index.setAttribute("value", 1);
        rec_index.setAttribute("class", "rec_index");
        }else{
            var rec_index = document.createElement("input");
            rec_index.setAttribute("type", "hidden");
            rec_index.setAttribute("name", "fashion_rec_index[]");
            rec_index.setAttribute("value",Number(index_array[index_array.length-1].value)+1);
            rec_index.setAttribute("class", "rec_index");
        }
// ==============================

        var add_btn = document.createElement("button");
        add_btn.innerText="اضافة"
        add_btn.classList.add('btn' , 'btn-primary');
        add_btn.setAttribute("type", "button");
        add_btn.setAttribute("onclick", "add_fashion_row(this)");

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
        td2.innerText="النسبة / لتر أو كجم"

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
        header_div.append(select,add_btn,remove_stage,rec_index)
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
    $('.searchable').select2();
    }
    
   

    function add_fashion_row(obutton){

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
        var products = {!! json_encode($fashion_products) !!};
        var select = document.createElement("select");
        select.setAttribute('name','product_fashion_id_'+select_value+'[]')
        select.classList.add('product_fashion_id','form-control','searchable')
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
        input2.setAttribute('name','ratio_fashion_'+select_value+'[]')
        input2.classList.add('form-control')
        td2.appendChild(input2)

        var td3 = document.createElement("td");
        var input3 = document.createElement("input");
        input3.setAttribute('type','text')
        input3.setAttribute('name','resolution_fashion_'+select_value+'[]')
        input3.classList.add('form-control')
        td3.appendChild(input3)

        var td4 = document.createElement("td");
        var input4 = document.createElement("input");
        input4.setAttribute('type','text')
        input4.setAttribute('name','power_fashion_'+select_value+'[]')
        input4.classList.add('form-control')
        td4.appendChild(input4)

        var td5 = document.createElement("td");
        var input5 = document.createElement("input");
        input5.setAttribute('type','text')
        input5.setAttribute('name','time_fashion_'+select_value+'[]')
        input5.classList.add('form-control')
        td5.appendChild(input5)

        var td6 = document.createElement("td");
        var input6 = document.createElement("input");
        input6.setAttribute('type','text')
        input6.setAttribute('name','note_fashion_'+select_value+'[]')
        input6.classList.add('form-control')
        td6.appendChild(input6)

        var td7 = document.createElement("td");
        var delete_row = document.createElement("button");
        // delete_row.classList.add('btn','btn-danger')
        delete_row.classList.add('btn', 'btn-link', 'btn-danger', 'btn-just-icon');
        var icon = document.createElement("i");
        icon.classList.add('fa','fa-trash')
        delete_row.appendChild(icon)
        delete_row.setAttribute('onclick','remove_fashion_row(this)')
        delete_row.setAttribute('type','button')
        td7.appendChild(delete_row)


        row.append(td1,td2,td3,td4,td5,td6,td7)
        if(check==1){

        }else{
        obutton.parentNode.parentNode.childNodes[1].appendChild(row)
        }
        $('.searchable').select2();
    }

    function remove_fashion_row(param){
        param.parentNode.parentNode.remove()
}

        
        </script>

