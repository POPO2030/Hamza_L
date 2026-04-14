@extends('layouts.app')

@section('title')
    {{__('انشاء رسبى عينات')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>انشاء رسبى عينات</h1>
                </div>
                {{-- <div class="col-sm-6">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    +
  </button>
                </div> --}}
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                @include('create_samples.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">اختر رقم العينة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ Route('createSamples.create') }}" method="Post">
        <div class="modal-body">
        
            @csrf
            <div class="form-group col-sm-12">
                {!! Form::label('sample_id', ' العينة: <span style="color: red">*</span>', [], false) !!}
                {{-- {{ Form::select('sample_id',$sample_id,['class'=> 'form-control searchable','data-placeholder' => 'اختر جهة التسليم','id'=>'sample_id','style'=>"width: 100%;height: 38px;",'required' ],['option'=>'sample_id']) }} --}}
                {{ Form::select('sample_id', $sample_id, null, ['class' => 'form-control searchable','id'=>'sample_id', 'data-placeholder' => 'اختر رقم العينة', 'style' => 'width: 100%'],['option'=>'sample_id']) }}

            </div>
      
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">حفظ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection

