@extends('layouts.app')

@section('title')
    {{__('استلام عينات جديدة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fas fa-flask heart-beat"></i>
                      استلام عينات جديدة
                        </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'labSamples.store','id'=>'create' ,'enctype'=>'multipart/form-data']) !!}

            <div class="card-body">

                <div class="row">
                    @include('lab_samples.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary  save']) !!}
                <a href="{{ route('labSamples.index') }}" class="btn btn-default">إلغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection


@push('third_party_scripts')
<!-- choose image -->
<script src="{{ asset('js/views_js/image_lab_samples.js') }}"></script>
{{-- form validate --}}
<script src="{{ asset('js/views_js/lab_samples_validate.js') }}"></script>
{{-- <script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
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
</script> --}}