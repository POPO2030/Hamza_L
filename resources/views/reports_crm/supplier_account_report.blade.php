
@extends('layouts.app')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}

@section('title')
    {{ __('عرض  حساب الموردين') }}
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2>
                            <i class="fas fa-scroll heart-beat"></i>   عرض  حساب الموردين
                        </h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('supplier_account_result') }}">
                            @csrf
                            <div class="form-group">
                                <label for="supplier_id"> اسم المورد:</label>
                                <select name="supplier_id" id="supplier_id" class="form-control searchable" required>
                                    <option value="">اختر اسم المورد</option>
                                    @foreach ($supplier as $suppliers)
                                        <option value="{{ $suppliers->id }}">{{ $suppliers->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block" name="action" value="customer_accoun">عرض  حساب الموردين</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
