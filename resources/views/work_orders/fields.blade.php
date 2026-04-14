@if(isset($redirect))
    <input type="hidden" name="redirect" value={{$redirect}}>
@endif

@if(isset($customer_data))
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('customer_id',$customer_data,null,['class'=> 'form-control','id'=>'customer_id','style'=>"width: 100%;height: 38px;",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customer_data']) }}
</div>
@else
<!-- Customer Id Field -->
{{-- @if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4)
    
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('customer_id',$customers,null,['placeholder' => 'اختر  عميل ...','class'=> 'form-control searchable ','id'=>'customer_id',  'data-placeholder'=>"اختر  عميل", 'style'=>"width: 100%;height: 38px;",'required', 'oninvalid'=>"setCustomValidity('العميل مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'customers']) }}
 @error('customer_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
@else  --}}
@if(isset($workOrder))
<div class="form-group col-sm-6">
{!! Form::label('customer_id', 'اسم العميل: <span style="color: red">*</span>', [], false) !!}
{!! Form::text('customer_name', $workOrder->get_customer->name, ['class' => 'form-control','id'=>'customer_id','step'=>'1','readonly','required','oninvalid'=>"setCustomValidity('اضف عميل')",'onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}
{!! Form::hidden('customer_id', $workOrder->get_customer->id, ['class' => 'form-control','id'=>'customer_id','step'=>'1','required','oninvalid'=>"setCustomValidity('اضف عميل')",'onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}
</div>
{{-- @endif --}}
@endif
@endif


@if(isset($receipt_data))
<div class="form-group col-sm-6">
    {!! Form::label('receive_receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receive_receipt_id',$receipt_data,null,['class'=> 'form-control','id'=>'receipts','style'=>"width: 100%;height: 38px;",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receipt_data']) }}
</div>
@else
<!-- Receive Receipt Id Field -->
{{-- @if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4)

<div class="form-group col-sm-6">
    {!! Form::label('receive_receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('receive_receipt_id',$receipts,null,['placeholder' => 'اختر رقم الاذن ...','class'=> 'form-control searchable ','id'=>'receipts',  'data-placeholder'=>"اختر رقم الاذن", 'style'=>"width: 100%;height: 38px;",'required', 'oninvalid'=>"setCustomValidity('رقم الاذن مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receipts']) }}
    @error('receive_receipt_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
@else --}}
@if(isset($workOrder))
<div class="form-group col-sm-6">
    {!! Form::label('receive_receipt_id', 'رقم اذن اضافة: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('receive_receipt_id',$workOrder->receive_receipt_id,['placeholder' => 'اختر رقم الاذن ...','class'=> 'form-control ','readonly','id'=>'receipts',  'data-placeholder'=>"اختر رقم الاذن", 'style'=>"width: 100%;height: 38px;",'required', 'oninvalid'=>"setCustomValidity('رقم الاذن مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'receipts']) }}
</div>
{{-- @endif --}}
@endif
@endif
<!-- Product Id Field -->

@if(isset($product_data))
<div class="form-group col-sm-4">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('product_id',$product_data,null,['class'=> 'form-control','id'=>'products','style'=>"width: 100%;height: 38px;",'required' ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'product_data']) }}

</div>
<div class="form-group col-sm-2">
    {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_type',$product_type,['class'=> 'form-control','id'=>'product_type','style'=>"width: 100%;",'required','readonly']) }}
</div>
@else
{{-- @if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4)

<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('product_id',$products,null,['placeholder' => 'اختر  الصنف ...','class'=> 'form-control searchable ','id'=>'products',  'data-placeholder'=>"اختر  الصنف", 'style'=>"width: 100%;height: 38px;",'required', 'oninvalid'=>"setCustomValidity(' الصنف مطلوب')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'products']) }}
    @error('product_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
@else --}}
@if(isset($workOrder))
<div class="form-group col-sm-4">
    {!! Form::label('product_id', 'الصنف: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('product_name', $workOrder->get_products->name, ['class' => 'form-control','id'=>'products','step'=>'1','required','readonly','oninvalid'=>"setCustomValidity('اضف منتج')",'onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}
    {!! Form::hidden('product_id', $workOrder->get_products->id, ['class' => 'form-control','id'=>'product_id','step'=>'1','required','oninvalid'=>"setCustomValidity('اضف منتج')",'onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('product_type', 'نوع الصنف: <span style="color: red">*</span>', [], false) !!}
    {{ Form::text('product_type',$product_type->product_type,['class'=> 'form-control','id'=>'product_type','style'=>"width: 100%;",'required','readonly']) }}
</div>
{{-- @endif --}}
@endif
@endif
<!-- color_thread Field -->
<div class="form-group col-sm-6">
    {!! Form::label('color_thread', 'لون الخيط:') !!}
    {!! Form::text('color_thread', null, ['class' => 'form-control','id'=>'colorthread','onchange'=>"try{setCustomValidity('')}catch(e){}",'minlength' => "2",'maxlength'=>"50"]) !!}
    @error('color_thread')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<!-- Fabric Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fabric_id', 'الخامة: <span style="color: red">*</span>', [], false) !!}
    <div id="fabric_id-container">
    {{ Form::select('fabric_id',$fabrics,null,['placeholder' => 'اختر اسم الخامة','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر اسم الخامة", 'style'=>"width: 100%",'id'=>'fabric_id', 'onchange' => 'handleFabricsChange()'],['option'=>'fabrics']) }}
    </div>
    @error('fabric_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="fabric_id-error" class="error-message" style="color: red"></span>
</div>

<!-- Fabric Source Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fabric_source_id', 'مصدر القماش: <span style="color: red">*</span>', [], false) !!}
    <div id="fabric_source_id-container">
    {{ Form::select('fabric_source_id',$fabric_sources,null,['placeholder' => 'اختر مصدر القماش','class'=> 'form-control searchable ', 'data-placeholder'=>"اختر مصدر القماش", 'style'=>"width: 100%",'id'=>'fabric_source_id', 'onchange' => 'handleFabric_sourcesChange()'],['option'=>'fabric_sources']) }}
    </div>
    @error('fabric_source_id')
    <div class="text-danger">{{ $message }}</div>
   @enderror
   <span id="fabric_source_id-error" class="error-message" style="color: red"></span>
</div>


<!-- Initial Product Count Field -->
<div class="form-group col-sm-6">
    {!! Form::label('initial_product_count', ' العدد المبدئى: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('initial_product_count', null, ['class' => 'form-control','min'=>1,'id'=>'initial_product_count','step'=>'1']) !!}
    <span id="initial_product_count-error" class="error-message" style="color: red"></span>
</div>


<!-- Place Id Field -->
@if (Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4 || Auth::user()->team_id == 13 )

@if(isset($workOrder) && $workOrder->get_places)
<div class="form-group col-sm-6 ">
    {!! Form::label('place_id', 'مكان التخزين: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('place_name', $workOrder->get_places->name, ['class' => 'form-control','id'=>'places','step'=>'1','onchange'=>"try{setCustomValidity('')}catch(e){}"]) !!}
    {!! Form::hidden('place_id', $workOrder->get_places->id, ['class' => 'form-control','id' => 'places','step' => '1','onchange' => "try{setCustomValidity('')}catch(e){}"]) !!}
</div>
@else
<div class="form-group col-sm-6 " id="div_place_id">
    {!! Form::label('place_id', 'مكان التخزين: <span style="color: red">*</span>', [], false) !!}
    {!! Form::text('place_id', null, ['class' => 'form-control','id' => 'places','step' => '1', 'oninvalid' => "setCustomValidity('اضف مكان التخزين')",'onchange' => "try{setCustomValidity('')}catch(e){}"]) !!}
</div>
@endif
@else
<div class="form-group col-sm-6">
    {!! Form::label('place_id', 'مكان التخزين: <span style="color: red">*</span>', [], false) !!}
    <div id="place_id-container">
    {{ Form::select('place_id',$places,null,['placeholder' => 'اختر  مكان التخزين ...','class'=> 'form-control searchable ','id'=>'placeid','data-placeholder'=>"اختر  مكان التخزين", 'style'=>"width: 100%;height: 38px;",'onchange' => 'handleProductChange()'],['option'=>'places']) }}
@error('place_id')
<div class="text-danger">{{ $message }}</div>
@enderror
</div>
<span id="place_id-error" class="error-message" style="color: red"></span>
</div>

@endif

    <!-- Product Count Field -->
<div class="form-group col-sm-6 " id="div_product_count">
    {!! Form::label('product_count', 'العدد الفعلى: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('product_count', null , ['class' => 'form-control','id'=>'product_count','step'=>'1']) !!}
    @error('product_count')
    <div class="text-danger">{{ $message }}</div>
@enderror
<span id="product_count-error" class="error-message" style="color: red"></span>
</div>

<!-- Product Weight Field -->
<div class="form-group col-sm-6 " id="div_product_weight">
    {!! Form::label('product_weight', 'الوزن الفعلى: <span style="color: red">*</span>', [], false) !!}
    {!! Form::number('product_weight', null , ['class' => 'form-control','id'=>'product_weight','step'=>'1']) !!}
    @error('product_weight')
    <div class="text-danger">{{ $message }}</div>
@enderror
<span id="product_weight-error" class="error-message" style="color: red"></span>
</div>

<div class="form-group col-sm-6">
</div>
@if(Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4)
<div class="form-group col-sm-6">
    {!! Form::label('old_work_orders', 'غسلة سابقة:') !!}
    {{ Form::select('old_work_orders', $old_work_orders, null, ['placeholder' => 'اختر الغسلة...', 'class' => 'form-control searchable', 'data-placeholder' => 'اختر رقم الغسلة', 'id' => 'old_oreder']) }}
</div>
@endif

<div class="form-group col-sm-6">
    {{ Form::label('service_item_id', 'الخدمات: <span style="color: red">*</span>', [], false) }}

    <div id="service_item_id-container">
        <div class="d-flex">
            @if (isset($selectedservice))
                {{ Form::select(null, $service_items->pluck('name', 'id'), $selectedservice, ['class' => 'form-control searchable' , 'placeholder'=>'', 'id' => 'service_item_id', 'data-placeholder' => 'اختر خدمة', 'style' => 'width: 100%',  'onchange' => 'handleProductChange()']) }}
            @else
                {{ Form::select(null, $service_items->pluck('name', 'id'), null, ['class' => 'form-control searchable', 'placeholder'=>'','id' => 'service_item_id', 'data-placeholder' => 'اختر خدمة', 'style' => 'width: 100%',  'onchange' => 'handleProductChange()']) }}
            @endif

            @error('service_item_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            {{-- @if(Auth::user()->team_id == 1 || Auth::user()->team_id == 2 || Auth::user()->team_id == 4)
                <!--ومدير النظام /خدمه العملاء-->
                <button id="copy-button" type="button" class="btn btn-primary">نسخ</button>
            @endif --}}
        </div>
    </div>
    <span id="service_item_id-error" class="error-message" style="color: red"></span>
</div>

@if(Auth::user()->team_id==3 ||Auth::user()->team_id == 15)
    <div class="form-group col-sm-6">
    {!! Form::label('service_item_id_trail', 'خدمات اضافية :') !!}
        <select name="service_item_id_trail[]" id="service_item_id_trail" class="form-control searchable" data-placeholder="اختر خدمة اضافية">
            <option >اختر خدمة اضافية</option>
                @foreach($service_items as $service_item)
                    @if($service_item->id == 233 || $service_item->id == 246)
                <option value="{{ $service_item->id }}">{{ $service_item->name }}</option>
                    @endif
                @endforeach
        </select>
    </div>
@endif
  

<!-- Receivable Id Field -->

<div class="form-group col-sm-6">
    {!! Form::label('receivable_id', 'جهة التسليم: <span style="color: red">*</span>', [], false) !!}
    <select name="receivable_id" class="form-control searchable">
        <option value="{{ $receivables->get_receivables->id }}">{{ $receivables->get_receivables->name }}</option>
    </select>
</div>
<div class="form-group col-sm-6" id="selected2Options">
    @if (isset($selectedservice))
        @foreach ($selectedservice as $key=>$value)
            <div class="input_holder" draggable="true">
                <input type="hidden" name="service_item_id[]" value="{{$key}}">
                {{$value}}
                <button class="close_btn" onclick="remove_note(this)">x</button>
            </div>
        @endforeach
    @endif

</div>


<!-- color_thread Field -->
@if(isset($workOrder->note))

<div class="form-group col-sm-12">
    {!! Form::label('note', 'ملحوظات:') !!}
    {!! Form::textarea('note', $workOrder->note->note, ['class' => 'form-control','minlength' => 2,'maxlength' => 2255, 'rows' => 3]) !!}
   <input type="hidden" name="note_id" value="{{$workOrder->note->id}}">
</div>
@else

<div class="form-group col-sm-12">
    {!! Form::label('note', 'ملحوظات:') !!}
    {!! Form::textarea('note', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 2255, 'rows' => 3]) !!}
   
</div>


@endif



<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
<script src="{{ asset('js/Sortable.min.js') }}"></script>
<script>
    $( document ).ready(function() {



    function create_selected_service(id = null, name = null) {
        let selectedid, selectedname;

        if (id == null || name == null) {
            selectedid = this.options[this.selectedIndex].value;
            selectedname = this.options[this.selectedIndex].innerText;
        } else {
            selectedid = id;
            selectedname = name;
        }
        
        const container_div = document.getElementById('selected2Options');

       
        const alreadySelected = container_div.querySelector(`input[value="${selectedid}"]`);
        if (alreadySelected) {
            alert("عفوا.... هذه الخدمة مختارة من قبل");
            return; 
        }

        container_div.classList.add('container_div', 'col-12');

        const input = document.createElement('input');
        input.setAttribute('name', 'service_item_id[]');
        input.setAttribute('type', 'hidden');
        input.setAttribute('readonly', 'readonly');
        input.setAttribute('value', selectedid);

        const input_holder = document.createElement('div');
        input_holder.setAttribute('class', 'input_holder');
        input_holder.setAttribute('draggable', 'true');
        input_holder.innerText = selectedname;

        input_holder.appendChild(input);

        const btn = document.createElement('button');
        btn.innerText = 'x';
        btn.setAttribute('type', 'button');
        btn.classList.add('close_btn');

        input_holder.appendChild(btn);
        container_div.appendChild(input_holder);
         
        document.getElementById('note').textContent += selectedname + ' / ';
       
       
    }

   
    
    $(document).on('change', '#service_item_id', create_selected_service);
    $(document).on('change', '#service_item_id_trail', create_selected_service);


    function remove_note(btn){
        let noteField = document.getElementById('note');
        if(document.getElementsByClassName('input_holder').length === 1){
            noteField.value = '';
        } else {
            let removedText = btn.parentNode.innerText.trim();
            let textContent = noteField.value;
            let removeText = removedText.replace('x', '').trim();
            let updatedText = textContent.replace(' / ' + removeText, '').trim();
            noteField.value = updatedText;
        }

        btn.parentNode.remove();
        
    }


   



    const teamId = @json(auth()->user()->team_id);

    const allowedTeams = [1, 2, 13, 4];
    $(document).on('click', '.close_btn', function () {
        if (allowedTeams.includes(teamId)) {
            remove_note(this);
            this.parentNode.remove();
        } else {
            alert("عفوا... ليس لديك صلاحية حذف الخدمة");
            event.preventDefault();
        }
    });




$(document).on('change','#old_oreder',function(){
var order_id=$(this).val();


$.ajax({
   type:'get',
   url:"{!!URL::to('/get_old_order_stages')!!}",
   data:{'order_id':order_id},
   success:function(result){
    document.getElementById('selected2Options').innerHTML='';
    document.getElementById('note').innerText ='' 
    service_item_id
    for (let index = 0; index < result.length; index++) {

        create_selected_service(id=result[index].id,name=result[index].name)

    }


   }
})
})



// ------------  start drag and drop  ------------------------------------------
let draggedElement;

$(document).on('dragstart', '#selected2Options .input_holder', function (e) {
    draggedElement = this;
    $(this).css('opacity', '0.7');
});

$(document).on('dragover', '#selected2Options .input_holder', function (e) {
    e.preventDefault();
});

$(document).on('dragenter', '#selected2Options .input_holder', function () {
    $(this).addClass('drag-over');
});

$(document).on('dragleave', '#selected2Options .input_holder', function () {
    $(this).removeClass('drag-over');
});

$(document).on('drop', '#selected2Options .input_holder', function (e) {
    e.preventDefault();
    $(this).removeClass('drag-over');
    if (draggedElement !== this) {
        // Swap contents
        const draggedHTML = $(draggedElement).html();
        const targetHTML = $(this).html();

        $(draggedElement).html(targetHTML);
        $(this).html(draggedHTML);
    }
});

$(document).on('dragend', '#selected2Options .input_holder', function () {
    $(this).css('opacity', '1');
});
// ------------  end drag and drop  ------------------------------------------


});


</script>




