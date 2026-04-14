@extends('layouts.app')

@section('title')
    {{__('اضافة اذن تغليف')}}
@endsection

<style>
    .alert-container {
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    /* Style the alert content */
    .alert-content {
      display: flex;
      align-items: center;
      gap: 8px; /* Space between icon and text */
      color: red; /* Red color for icon and text */
      padding: 8px 16px;
      background-color: rgba(255, 0, 0, 0.1); /* Light red background */
      border-radius: 4px;
      animation: fadeInOut 3s infinite; /* Fade in and out animation */
    }

</style>
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1><i class="fas fa-truck"></i> اضافة اذن تغليف</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
    
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif


        <div class="card">

            {!! Form::open(['route' => 'deliverOrders.store','id'=>'create']) !!}

            <div class="card-body">

        @if (($data - $remaining) > 0)
            <div class="alert-container">
            <div class="alert-content">
                <i class="material-icons">notification_important</i>
                <span style="font-weight: bold;">{{ 'تحذير تم تغليف كمية على هذة الغسلة من قبل!' }}</span>
            </div>
            </div>

            <br>
            <br>
        @endif

                <div class="row">
                    @include('deliver_orders.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
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