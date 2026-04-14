@extends('layouts.app')

@section('title')
    {{__('تعديل اذن التغليف')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-truck"></i> تعديل اذن التغليف</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($deliverOrder, ['route' => ['deliverOrders.update', $deliverOrder->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('deliver_orders.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('deliverOrders.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script>
      $(document).ready(function() {
        $('#create').submit(function(event) {
            event.preventDefault();
            var isValid = true;

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
    });
</script>