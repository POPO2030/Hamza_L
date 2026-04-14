@extends('layouts.app')

@section('title')
    {{__('انشاء عميل جديد')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-users"></i> انشاء عميل جديد</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'customers.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('customers.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('customers.index') }}" class="btn btn-default">إلغاء</a>
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

            var customerName = document.getElementById('customer_name').value;
            var phone = document.getElementById('phone').value;
            var isValid = true;

            if (customerName.length < 2 || customerName.length > 50) {
                document.getElementById('name-error').innerHTML = 'يجب إدخال اسم العميل وأن لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
                document.getElementById('customer_name').style.borderColor = 'red';
                isValid = false;
            } else {
                document.getElementById('name-error').innerHTML = '';
                document.getElementById('customer_name').style.borderColor = '';
            }


            if (phone.length < 8 || phone.length > 12) {
                document.getElementById('phone-error').innerHTML = 'يجب إدخال التليفون وأن لا يقل عن 8 ارقام ولا يزيد عن 11 رقم';
                document.getElementById('phone').style.borderColor = 'red';
                isValid = false;
            } else {
                document.getElementById('phone-error').innerHTML = '';
                document.getElementById('phone').style.borderColor = '';
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
        $('#customer_name').on('blur', function() {
            var customerName = this.value;
            if (customerName.length < 2 || customerName.length > 50) {
                document.getElementById('name-error').innerHTML = 'يجب إدخال اسم العميل وأن لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
                this.style.borderColor = 'red';
            } else {
                document.getElementById('name-error').innerHTML = '';
                this.style.borderColor = '';
            }
        });

        $('#phone').on('blur', function() {
            var phone = this.value;
            if (phone.length < 8 || phone.length > 12) {
                document.getElementById('phone-error').innerHTML = 'يجب إدخال التليفون وأن لا يقل عن 8 ارقام ولا يزيد عن 11 رقم';
                this.style.borderColor = 'red';
            } else {
                document.getElementById('phone-error').innerHTML = '';
                this.style.borderColor = '';
            }
        });


    });

    function removeError(element) {
        element.style.borderColor = 'none';
    }
</script>



