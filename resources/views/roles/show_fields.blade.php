<style>
    .permission-group {
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'الاسم:') !!}
    <p>{{ $role->name }}</p>
</div>

<!-- Permissions Field -->

<div class="col-sm-12">
    {!! Form::label('permissions', 'الصلاحيات:') !!}
    @if (isset($role->permissions))
        @php
            $permissions = config('global.permissions');
            $categorizedPermissions = [];

            foreach ($permissions as $name => $value) {
                $firstWord = explode('.', $name)[0];
                if (!isset($categorizedPermissions[$firstWord])) {
                    $categorizedPermissions[$firstWord] = [];
                }
                $categorizedPermissions[$firstWord][$name] = $value;
            }
        @endphp

        @foreach ($categorizedPermissions as $category => $categoryPermissions)
            <div class="permission-group">
                <h5 style="color: #17a2b8;">{{ reset($categoryPermissions) }}</h5>
                <div class="row">
                    @foreach ($categoryPermissions as $name => $value)
                        <div class="col-sm-3">
                            <span id="{{ $name }}" class="{{ in_array($name, $role->permissions) ? 'text-success' : 'text-danger' }}">
                                {{ $value }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-6" style="margin-top:1rem">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <p>{{ $role->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    <p>{{ $role->updated_at }}</p>
</div>

