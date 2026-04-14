@if (Auth::user()->team_id == 1 || Auth::user()->team_id == 11 || Auth::user()->team_id == 13)
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم كامل:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','id'=>'name','minlength' => 2,'maxlength' => 50]) !!}
    @error('name')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'اسم المستخدم:') !!}
    {!! Form::text('username', null, ['class' => 'form-control','id'=>'username','minlength' => 2,'maxlength' => 50]) !!}
    @error('username')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
@else
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم كامل:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','id'=>'name','readonly','minlength' => 2,'maxlength' => 50]) !!}
    @error('name')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'اسم المستخدم:') !!}
    {!! Form::text('username', null, ['class' => 'form-control','id'=>'username','readonly','minlength' => 2,'maxlength' => 50]) !!}
    @error('username')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
@endif
<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'كلمه المرور:') !!}
    {!! Form::password('password', ['class' => 'form-control','style'=>'height: 38px;']) !!}
    @error('password')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

@if (Auth::user()->team_id == 1 || Auth::user()->team_id == 11 || Auth::user()->team_id == 13)
<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', 'القسم:') !!}
    {{ Form::select('team_id',$teams,null,['placeholder' => 'team','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('اختر مجموعة')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'teams']) }}
    @error('team_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

<!-- Role Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role_id', 'الصلاحيات:') !!}
    {{ Form::select('role_id',$roles,null,['placeholder' => 'role','class'=> 'form-control searchable ', 'data-placeholder'=>"...", 'style'=>"width: 100%",'required', 'oninvalid'=>"setCustomValidity('اختر الصلاحيات')" ,'onchange'=>"try{setCustomValidity('')}catch(e){}"],['option'=>'roles']) }}
    @error('role_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
@else
<!-- Team Id Field -->
<div class="form-group col-sm-6">
    <input type="hidden" value="{{$user->team_id}}" name="team_id">
    @error('team_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>

<!-- Role Id Field -->
<div class="form-group col-sm-6">
    <input type="hidden" value="{{$user->role_id}}" name="role_id">
    @error('role_id')
    <div class="text-danger">{{ $message }}</div>
@enderror
</div>
@endif