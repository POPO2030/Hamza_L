@extends('layouts.app')

@section('title')
    {{__('تعديل الخدمات')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-concierge-bell"></i> تعديل الخدمات</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($service, ['route' => ['services.update', $service->id], 'method' => 'patch','id'=>'create', 'onsubmit' => 'return validateForm(event)']) !!}

            <div class="card-body">
                <div class="row">
                    @include('services.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('services.index') }}" class="btn btn-default">الغاء</a>
            </div>

            <div class="col"></div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

<!--script blongs to hold submit button from multi submit -->

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#create').submit(function(event) {
            event.preventDefault();

            var serviceName = document.getElementById('service_name').value;
            var serviceCategory = document.getElementById('service_category_id').value;
            var isValid = true;

            if (serviceName.length < 2 || serviceName.length > 50) {
                document.getElementById('name-error').innerHTML = 'يجب إدخال اسم الخدمة وأن لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
                document.getElementById('service_name').style.borderColor = 'red';
                isValid = false;
            } else {
                document.getElementById('name-error').innerHTML = '';
                document.getElementById('service_name').style.borderColor = '';
            }

            if (serviceCategory === '') {
                document.getElementById('service-category-error').innerHTML = 'عفوآ...يجب اختيار مجموعه الخدمات';
                document.getElementById('service-category-container').style.border = '1px solid';
                document.getElementById('service-category-container').style.borderColor = 'red';
                isValid = false;
            } else {
                document.getElementById('service-category-error').innerHTML = '';
                document.getElementById('service-category-container').style.border = 'none';
                document.getElementById('service-category-container').style.borderColor = 'none';
            }

            if (isValid) {
                $('input[type=submit]', this).prop('disabled', true);
                this.submit();
            }
        });

        // تفعيل زر F2 إذا تم إدخال الخانات المطلوبة
        $(document).on('keyup', function(e) {
            if (e.key == 'F2' && $('#create')[0].checkValidity()) { 
                $('.save').click();
            }
        });

        // Validation on element blur
        $('#service_name').on('blur', function() {
            var serviceName = this.value;
            if (serviceName.length < 2 || serviceName.length > 50) {
                document.getElementById('name-error').innerHTML = 'يجب إدخال اسم الخدمة وأن لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
                this.style.borderColor = 'red';
            } else {
                document.getElementById('name-error').innerHTML = '';
                this.style.borderColor = '';
            }
        });

        $('#service_category_id').on('change', function() {
            var serviceCategory = this.value;
            if (serviceCategory === '') {
                document.getElementById('service-category-error').innerHTML = 'عفوآ...يجب اختيار مجموعه الخدمات';
                document.getElementById('service-category-container').style.border = '1px solid';
                document.getElementById('service-category-container').style.borderColor = 'red';
            } else {
                document.getElementById('service-category-error').innerHTML = '';
                document.getElementById('service-category-container').style.border = '';
                document.getElementById('service-category-container').style.borderColor = '';
            }
        });
    });

    function removeError(element) {
        element.style.borderColor = 'none';
    }
</script>




