<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name',  'الاسم كامل:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Username Field -->
<div class="col-sm-6">
    {!! Form::label('username', 'اسم المستخدم:') !!}
    <p>{{ $user->username }}</p>
</div>

<!-- Team Id Field -->
<div class="col-sm-6">
    {!! Form::label('team_id', 'القسم:') !!}
    <p>{{ $user->teams->name }}</p>
</div>

<!-- Role Id Field -->
<div class="col-sm-6">
    {!! Form::label('role_id', 'الصلاحيات:') !!}
    <p>{{ $user->role->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $user->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $user->updated_at }}</p>
</div>

