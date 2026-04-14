@extends('layouts.app')

@section('title')
    {{__('انشاء مرحلة انتاج جديده')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 ><i class="fas fa-eye-dropper"></i> انشاء مرحله انتاج جديده</h1>

                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::open(['route' => 'stages.store','id'=>'create']) !!}

            <div class="card-body">

                <div class="row">
                    @include('stages.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
                <a href="{{ route('stages.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('js')
<script>
    // $(document).ready(function () {
function validate(input){
    if(/^\s/.test(input.value))
      input.value = '';
  }
  
  // -*----------------------------------------------------------------------------
  $(":Form::text").keyup(function(){
      var inp = this;
      var ink = this;
      var int = this;
    setTimeout(function() {
      inp.value = inp.value.replace(/آ|أ|إ/g, 'ا');  //   // replace (أ-آ-إ) with (ا).
      ink.value = inp.value.replace(/ة/g, 'ه'); //    // Trying to replace (ة) with (ه).
      int.value = inp.value.replace(/ى/g, 'ي'); //    // Trying to replace (ى) with (ي).
    }, 0);
  });
  // =============================================================================
  // stop paste in input text (fabricName)
  $(":Form::text").on("paste", function (e) {
      e.preventDefault();
  });
  // ===================================================================================
  
  
//   });
  
      </script>
  @endpush
<!--script blongs to hold submit button from multi submit -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>
<script>
    $( document ).ready(function() {
    $('#create').submit(function() {
                $('input[type=submit]', this).prop("disabled", true);
    });
    // ================================================
    $(document).on('keyup', function(e) {
        // f2
  if (e.key == "F2") $('.save').click();
});
});
    </script>