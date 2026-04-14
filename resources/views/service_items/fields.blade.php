<style>
    .form-check-input{
        position:static !important;
        margin-left:0
    }
</style>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم: <span style="color: red">*</span>', [], false) !!}
    {{-- {!! Form::text('name', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50,'onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!} --}}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),'required','oninvalid'=>"setCustomValidity('يجب ادخال عنصر الخدمه وان لا تقل عن 2 حرف ولا تزيد عن 50 حرف')",'onchange'=>"try{setCustomValidity('')}catch(e){}",'minlength' => "2",'maxlength'=>"50",'onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)']) !!}
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'عدد الفاشون:') !!}
    {!! Form::number('price', null, ['class' => 'form-control', 'step' => '0.01']) !!}
    {{-- @error('price')
        <div class="text-danger">{{ $message }}</div>
    @enderror --}}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money', 'السعر:') !!}
    {!! Form::number('money', null, ['class' => 'form-control', 'step' => '0.01']) !!}
    {{-- @error('money')
        <div class="text-danger">{{ $message }}</div>
    @enderror --}}
</div>

<!-- Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_id', ' الخدمات: <span style="color: red">*</span>', [], false) !!}
    {{ Form::select('service_id',$services,null,['placeholder' => 'اختر  مجموعة ...','class'=> 'form-control searchable ','id'=>'customer_id',  'data-placeholder'=>"اختر  مجموعة", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('يجب..اختيار الخدمه')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'cats']) }}

</div>



<div class="form-group col-sm-6">

    {!! Form::label('stage_id', ' مراحل الانتاج: <span style="color: red">*</span>', [], false) !!}
    @if(isset($selectedStages))
    
    {{ Form::select('', $stages->pluck('name', 'id'), $selectedStages, [
        'class' => 'form-control searchable',
        'id' => 'stage_id',
        'placeholder'=>'',
        'data-placeholder' => 'اختر مراحل الانتاج',
        'style' => 'width: 100%',
        'oninvalid' => "setCustomValidity('يجب...اختيار مراحل الانتاج')",
        'onchange' => "try{setCustomValidity('')}catch(e){}",
        // 'multiple' => 'multiple',
        ])
    }}
    
    @else
    {{ Form::select('', $stages->pluck('name', 'id'), null, [
        'class' => 'form-control searchable',
        'id' => 'stage_id',
        'placeholder'=>'',
        'data-placeholder' => 'اختر مراحل الانتاج',
        'style' => 'width: 100%',
        'oninvalid' => "setCustomValidity('يجب...اختيار مراحل الانتاج')",
        'onchange' => "try{setCustomValidity('')}catch(e){}",
        // 'multiple' => 'multiple',
        ])
    }}
    
    @endif
    @error('stage_id')
<div class="text-danger">{{ $message }}</div>
@enderror
</div>

<div class="form-group col-sm-6">
</div>

<div id="selected2Options">
    @if (isset($selectedStages))
        @foreach ($selectedStages as $key=>$value)
            <div class="input_holder" draggable="true">
                <input type="hidden" name="stage_id[]" value="{{$key}}">
                {{$value}}
                <button class="close_btn">x</button>
            </div>
        @endforeach
    @endif

</div>



<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
<script src="{{ asset('js/Sortable.min.js') }}"></script>


<script>

$( document ).ready(function() {

    function create_selected_service(id=null,name=null){
    
        if(id==null || name==null){
            selectedid=this.options[ this.selectedIndex].value;
            selectedname=this.options[ this.selectedIndex].innerText;
        }else{
            selectedid=id
            selectedname=name
        }
       

        container_div=document.getElementById('selected2Options');
        container_div.classList.add('container_div');
        container_div.classList.add('col-12');
        input=document.createElement('input');
        input.setAttribute('name','stage_id[]');
        input.setAttribute('type','hidden');
        input.setAttribute('readonly','readonly');
        input.setAttribute('value',selectedid);
        input_holder=document.createElement('div');
        input_holder.setAttribute('class','input_holder')
        input_holder.setAttribute('draggable','true')
        input_holder.innerText=selectedname
        input_holder.appendChild(input)
        btn=document.createElement('button');
        btn.innerText='x';
        btn.setAttribute('type','button');
        btn.classList.add('close_btn');
        input_holder.appendChild(btn);
        container_div.appendChild(input_holder)
    }
    
    $(document).on('change', '#stage_id', create_selected_service);




    $(document).on('click','.close_btn',function(){
        this.parentNode.remove();
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