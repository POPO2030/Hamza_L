@extends('layouts.app')

@push('page_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/views_css/header_heartbeat.css') }}"> --}}
@endpush

@section('title')
    {{__('تعديل اذن مرتجع بضاعه')}}
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>
            <i class="fas fa-pallet"></i>
             تعديل اذن مرتجع بضاعه
        </h1>
    </div>
  </div>
</div>
</section>

    <div class="content px-3">

        {{-- @include('adminlte-templates::common.errors') --}}

        <div class="card">

            {!! Form::model($invImportOrder_return, ['route' => ['invImportOrdersReturns.update', $invImportOrder_return->id], 'method' => 'patch','id'=>'create']) !!}

            <div class="card-body">
                <div class="row">
                    @include('inv_import_orders_returns.fields')
                </div>
            </div>

            <div class="card-footer">
              {!! Form::submit('حفظ', ['class' => 'btn btn-success btn-sm save']) !!}
                <a href="{{ route('invImportOrders_Returns.index') }}" class="btn btn-secondary btn-sm">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('create').addEventListener('submit', function(event) {
                event.preventDefault();

                var isValid = true;
                var quantityElements = document.getElementsByClassName("quantity");
                var totalElements = document.getElementsByClassName("total");
                var return_detailElements = document.getElementsByClassName("return_details");

                // Check if at least one quantity element contains data
                var hasData = false;
                for (var i = 0; i < quantityElements.length; i++) {
                    if (quantityElements[i].value.trim() !== '') {
                        hasData = true;
                        break;
                    }
                }

                if (!hasData) {
  
                    for (var i = 0; i < quantityElements.length; i++) {
                        if (quantityElements[i].value.trim() === '') {
                           quantityElements[i].style.borderColor = "red";
                            var existingErrorMessage = quantityElements[i].parentNode.querySelector(".error-message");
                            if (existingErrorMessage) {
                              quantityElements[i].parentNode.removeChild(existingErrorMessage);
                            }
                            var errorMessage = document.createElement('span');
                            errorMessage.textContent = 'عفوآ...يجب ادخال كمية المرتجع';
                            errorMessage.className = "error-message";
                            errorMessage.style.color = 'red';
                            quantityElements[i].parentNode.appendChild(errorMessage);
                        }
                    }
                    isValid = false;
                }else{
                     
                    function showErrorMessage(element, message) {
                        element.style.borderColor = "red";
                        var existingErrorMessage = element.parentNode.querySelector(".error-message");
                        if (existingErrorMessage) {
                            element.parentNode.removeChild(existingErrorMessage);
                        }
                        var errorMessage = document.createElement('span');
                        errorMessage.textContent = message;
                        errorMessage.className = "error-message";
                        errorMessage.style.color = 'red';
                        element.parentNode.appendChild(errorMessage);
                    }

                    // Function to remove any existing error message
                    function clearErrorMessage(element) {
                        element.style.borderColor = "";
                        var existingErrorMessage = element.parentNode.querySelector(".error-message");
                        if (existingErrorMessage) {
                            element.parentNode.removeChild(existingErrorMessage);
                        }
                    }

                    for (var i = 0; i < quantityElements.length; i++) {
                        var quantity = parseFloat(quantityElements[i].value);
                        var total = parseFloat(totalElements[i].textContent);
                        var returnDetail = parseFloat(return_detailElements[i].textContent);

                        if (quantity > total) {
                            showErrorMessage(quantityElements[i], 'عفوآ...كمية المرتجع أكبر من كميه الفاتورة');
                            isValid = false;
                        } else if (quantity + returnDetail > total) {
                            showErrorMessage(quantityElements[i], 'عفوآ...كمية المرتجع أكبر من العدد المتاح');
                            isValid = false;
                        } else {
                            clearErrorMessage(quantityElements[i]);
                        }
                    }
                  

                }

                if (isValid) {
                    var submitButton = this.querySelector('input[type=submit]');
                    submitButton.disabled = true;
                    this.submit();
                }
            });

            document.addEventListener('keyup', function(e) {
                if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
                    document.querySelector('.save').click();
                }
            });
        });
    </script>
@endpush
