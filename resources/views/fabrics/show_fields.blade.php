<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'اسم القماشة:') !!}
    <p>{{ $fabric->name }}</p>
</div>

{{-- <!-- Fabric Source Id Field -->
<div class="col-sm-12">
    {!! Form::label('fabric_source_id', 'مصدر القماش:') !!}
    <p>{{ $fabric->get_fabric_source->name }}</p>
</div> --}}

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'تم الانشاء:') !!}
    <p>{{ $fabric->created_at }}</p>
</div>

<!-- Created By Field -->
@if(!empty($fabric->get_user->name))
<div class="col-sm-6">
    {!! Form::label('creator_id', 'القائم بالانشاء:') !!}
    <p>{{ $fabric->get_user->name }}</p>
</div>
@endif

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'تم التعديل:') !!}
    <p>{{ $fabric->updated_at }}</p>
</div>

<!-- Updated By Field -->
@if(!empty($fabric->get_user_update->name))
<div class="col-sm-6">
    {!! Form::label('updated_by', 'القائم بالتعديل:') !!}
    <p>{{ $fabric->get_user_update->name }}</p>
</div>
@endif
