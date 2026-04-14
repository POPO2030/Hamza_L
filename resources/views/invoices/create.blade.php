@extends('layouts.app')

@section('title')
    {{__('انشاء فاتورة')}}
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>انشاء فاتورة</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'invoices.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('invoices.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('حفظ', ['class' => 'btn btn-primary','id' => 'submit-button',]) !!}
                <a href="{{ route('invoices.index') }}" class="btn btn-default">الغاء</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}"></script>

<script>
    $(document).ready(function () {
    // Track the last used calculation method and customer ID
    let lastCalculationMethod = $('#calculation_method').val();
    let lastCustomerId = $('#customer_id').val();
    
    // Function to trigger AJAX call
    function fetchDeliverOrders() {
        const customerId = $('#customer_id').val();
        const calculationMethod = $('#calculation_method').val();
        
        if (!customerId) {
            $('#deliver-orders-table').empty();
            $('#amount_original').val('0.00');
            $('#amount_net').val('0.00');
            // $('#amount_original_db').val('0.00');
            return;
        }

        // Only proceed if we have both values and at least one has changed
        if (customerId === lastCustomerId && calculationMethod === lastCalculationMethod) {
            return;
        }
        
        lastCustomerId = customerId;
        lastCalculationMethod = calculationMethod;

        $.ajax({
            url: "{{ route('getDeliverOrders') }}",
            type: "GET",
            data: { customer_id: customerId },
            success: function (response) {
                if (calculationMethod === "kilo") {
                    renderKiloTable(response);
                } else if (calculationMethod === "piece") {
                    renderPieceTable(response);
                }
            },
            error: function () {
                alert('Failed to fetch deliver orders. Please try again.');
            }
        });
    }

    // Event handlers for both dropdowns
    $('#customer_id, #calculation_method').on('change', function() {
        // Toggle piece price field visibility
        const calculationMethod = $('#calculation_method').val();
        $('#piece_price').closest('.form-group').toggle(calculationMethod === "piece");
        
        fetchDeliverOrders();
    });

    function renderKiloTable(response) {
        $('#deliver-orders-table').empty();

        if (response.length === 0) {
            $('#deliver-orders-table').append(`
                <tr>
                    <td colspan="8" style="text-align: center; color: #ff4d4d;">
                        لا يوجد اذون تسليم لهذا العميل
                    </td>
                </tr>
            `);
            return;
        }

        let processedIds = {};
        let rowColors = ['#f8f9fa', '#e9ecef'];
        let colorIndex = 0;

        response.forEach(function (item) {
            let finalDeliverOrderId = item.final_deliver_order_id;

            if (!processedIds[finalDeliverOrderId]) {
                processedIds[finalDeliverOrderId] = {
                    color: rowColors[colorIndex],
                    rows: []
                };
                colorIndex = (colorIndex + 1) % rowColors.length;
            }

            let workOrderId = item.get_deliver_order?.work_order_id || "N/A";
            let productName = (item.get_deliver_order?.get_products?.name + '(' + item.get_deliver_order?.product_type + ')') || "N/A";
            let receivableName = item.get_deliver_order?.get_receivable?.name || "N/A";

            let serviceIds = [];
            let serviceMoney = [];
            let serviceCategoryIds = [];
            let servicesHtml = "N/A";

            if (item.get_deliver_order?.get_count_product?.get_work_order_stage) {
                let serviceNames = [];
                item.get_deliver_order.get_count_product.get_work_order_stage.forEach(function (stage) {
                    let serviceItem = stage.get_service_item;
                    if (serviceItem && !serviceNames.includes(serviceItem.name)) {
                        serviceNames.push(serviceItem.name);
                        serviceIds.push(serviceItem.id);
                        serviceMoney.push(serviceItem.money);
                        let categoryId = serviceItem.get_category.service_category_id;
                        serviceCategoryIds.push(categoryId);
                    }
                });

                if (serviceNames.length > 0) {
                    servicesHtml = serviceNames.map(name => `<span class="badge badge-info">${name}</span>`).join(" ");
                }
              
            }

            let weight = item.weight_sum ? `${item.weight_sum.toFixed(2)}` : "0";
            let totalQty = item.total_sum ? `${item.total_sum}` : "0";
            let createdDate = item.created_at ? new Date(item.created_at).toLocaleDateString() : "N/A";
            let totalAmountWorkOrder = item.total_amount_work_order ? `${item.total_amount_work_order.toFixed(2)}` : "0";

            processedIds[finalDeliverOrderId].rows.push(`
                <tr>
                    <td style="text-align: center;">
                        <input type="text" name="work_order_id[${finalDeliverOrderId}][]" value="${workOrderId}" class="work-orderid read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        <input type="text" name="get_products[${finalDeliverOrderId}][]" value="${productName}" class="get-products read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        ${servicesHtml}
                        ${serviceIds.map((id, index) => `
                            <input type="hidden" name="service_item_ids[${finalDeliverOrderId}][${workOrderId}][]" class="service-item-id" value="${id}" disabled>
                            <input type="hidden" name="service_item_moneys[${finalDeliverOrderId}][${workOrderId}][]" class="service-item-money" value="${serviceMoney[index]}" disabled>
                            <input type="hidden" name="service_category_ids[${finalDeliverOrderId}][${workOrderId}][]" class="service-category-ids" value="${serviceCategoryIds[index]}" disabled>
                        `).join('')}
                    </td>
                    <td style="text-align: center;">${createdDate}</td>
                    <td style="text-align: center;">${receivableName}</td>
                    <td style="text-align: center;">
                        <input type="text" name="total_kg[${finalDeliverOrderId}][]" value="${weight}" class="total-kg read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        <input type="text" name="total_qty[${finalDeliverOrderId}][]" value="${totalQty}" class="total-qty read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        <input type="text" name="total_amount[${finalDeliverOrderId}][]" value="${totalAmountWorkOrder}" class="total-amount read-text" style="width: 90%" readonly disabled>
                    </td>
                </tr>
            `);
        });

        // Update table header for kilo mode
        $('#tab thead').html(`
            <tr style="background-color: rgb(0 0 0 / 75%);color: #fff; font-weight: bold;">
                <th>رقم الغسله</th>
                <th>الصنف</th>
                <th>البيان</th>
                <th>تاريخ اذن التسليم</th>
                <th>جهة التسليم</th>
                <th>الوزن</th>
                <th>الكمية</th>
                <th>اجمالي</th>
            </tr>
        `);

        for (let id in processedIds) {
            let group = processedIds[id];
            $('#deliver-orders-table').append(`
                <tr style="background-color: rgb(218, 216, 216); color: white;">
                    <td colspan="8" style="text-align: center; font-weight: bold;">
                        <input type="checkbox" class="group-checkbox" name="final_deliver_order_id[]" value="${id}" data-id="${id}">
                        <label>اذن التسليم رقم: ${id}</label>
                    </td>
                </tr>
                ${group.rows.join("")}
            `);
        }

        $('.group-checkbox').on('change', function () {
            let id = $(this).data('id');
            let rows = $(this).closest('tr').nextUntil('tr:has(.group-checkbox)');

            if ($(this).is(':checked')) {
                rows.find('input').prop('disabled', false);
                rows.css('background-color', '#007bff');
            } else {
                rows.find('input').prop('disabled', true);
                rows.css('background-color', '');
            }

            updateAmountOriginal();
        });

        updateAmountOriginal();
    }

    function renderPieceTable(response) {
        $('#deliver-orders-table').empty();

        if (response.length === 0) {
            $('#deliver-orders-table').append(`
                <tr>
                    <td colspan="9" style="text-align: center; color: #ff4d4d;">
                        لا يوجد اذون تسليم لهذا العميل
                    </td>
                </tr>
            `);
            return;
        }

        let processedIds = {};
        let rowColors = ['#f8f9fa', '#e9ecef'];
        let colorIndex = 0;

        response.forEach(function (item) {
            let finalDeliverOrderId = item.final_deliver_order_id;

            if (!processedIds[finalDeliverOrderId]) {
                processedIds[finalDeliverOrderId] = {
                    color: rowColors[colorIndex],
                    rows: []
                };
                colorIndex = (colorIndex + 1) % rowColors.length;
            }

            let workOrderId = item.get_deliver_order?.work_order_id || "N/A";
            let productName = (item.get_deliver_order?.get_products?.name + '(' + item.get_deliver_order?.product_type + ')') || "N/A";
            let receivableName = item.get_deliver_order?.get_receivable?.name || "N/A";
            let totalQty = item.total_sum ? parseInt(item.total_sum) : 0;

            let serviceIds = [];
            let serviceMoney = [];
            let serviceCategoryIds = [];
            let servicesHtml = "N/A";

            if (item.get_deliver_order?.get_count_product?.get_work_order_stage) {
                let serviceNames = [];
                item.get_deliver_order.get_count_product.get_work_order_stage.forEach(function (stage) {
                    let serviceItem = stage.get_service_item;
                    if (serviceItem && !serviceNames.includes(serviceItem.name)) {
                        serviceNames.push(serviceItem.name);
                        serviceIds.push(serviceItem.id);
                        serviceMoney.push(serviceItem.money);
                        let categoryId = serviceItem.get_category.service_category_id;
                        serviceCategoryIds.push(categoryId);
                    }
                });

                if (serviceNames.length > 0) {
                    servicesHtml = serviceNames.map(name => `<span class="badge badge-info">${name}</span>`).join(" ");
                }
               
            }

            let createdDate = item.created_at ? new Date(item.created_at).toLocaleDateString() : "N/A";

            processedIds[finalDeliverOrderId].rows.push(`
                <tr>
                    <td style="text-align: center;">
                        <input type="text" name="work_order_id[${finalDeliverOrderId}][]" value="${workOrderId}" class="work-orderid read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        <input type="text" name="get_products[${finalDeliverOrderId}][]" value="${productName}" class="get-products read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        ${servicesHtml}
                        ${serviceIds.map((id, index) => `
                            <input type="hidden" name="service_item_ids[${finalDeliverOrderId}][${workOrderId}][]" class="service-item-id" value="${id}" disabled>
                            <input type="hidden" name="service_item_moneys[${finalDeliverOrderId}][${workOrderId}][]" class="service-item-money" value="${serviceMoney[index]}" disabled>
                            <input type="hidden" name="service_category_ids[${finalDeliverOrderId}][${workOrderId}][]" class="service-category-ids" value="${serviceCategoryIds[index]}" disabled>
                        `).join('')}
                    </td>
                    <td style="text-align: center;">${createdDate}</td>
                    <td style="text-align: center;">${receivableName}</td>
                    <td style="text-align: center;">
                        <input type="text" name="total_kg[${finalDeliverOrderId}][]" value="0" class="total-kg read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        <input type="text" name="total_qty[${finalDeliverOrderId}][]" value="${totalQty}" class="total-qty read-text" style="width: 90%" readonly disabled>
                    </td>
                    <td style="text-align: center;">
                        <input type="number" name="piece_price[${finalDeliverOrderId}][]" class="piece-price form-control" style="width: 90%" min="1" max="3" step="0.01" required>
                    </td>
                    <td style="text-align: center;">
                        <input type="text" name="total_amount[${finalDeliverOrderId}][]" class="total-amount read-text" style="width: 90%" readonly>
                    </td>
                </tr>
            `);
        });

        // Update table header for piece mode
        $('#tab thead').html(`
            <tr style="background-color: rgb(0 0 0 / 75%);color: #fff; font-weight: bold;">
                <th>رقم الغسله</th>
                <th>الصنف</th>
                <th>البيان</th>
                <th>تاريخ اذن التسليم</th>
                <th>جهة التسليم</th>
                <th>الوزن</th>
                <th>الكمية</th>
                <th>سعر القطعة</th>
                <th>اجمالي</th>
            </tr>
        `);

        for (let id in processedIds) {
            let group = processedIds[id];
            $('#deliver-orders-table').append(`
                <tr style="background-color: rgb(218, 216, 216); color: white;">
                    <td colspan="9" style="text-align: center; font-weight: bold;">
                        <input type="checkbox" class="group-checkbox" name="final_deliver_order_id[]" value="${id}" data-id="${id}">
                        <label>اذن التسليم رقم: ${id}</label>
                    </td>
                </tr>
                ${group.rows.join("")}
            `);
        }

        // Calculate amount when piece price changes
        $(document).on('input', '.piece-price', function() {
            let row = $(this).closest('tr');
            let price = parseFloat($(this).val()) || 0;
            let qty = parseFloat(row.find('.total-qty').val()) || 0;
            let amount = price * qty;
            row.find('.total-amount').val(amount.toFixed(2));
            updateAmountOriginal();
        });

        $('.group-checkbox').on('change', function () {
            let id = $(this).data('id');
            let rows = $(this).closest('tr').nextUntil('tr:has(.group-checkbox)');

            if ($(this).is(':checked')) {
                rows.find('input').prop('disabled', false);
                rows.css('background-color', '#007bff');
            } else {
                rows.find('input').prop('disabled', true);
                rows.css('background-color', '');
            }

            updateAmountOriginal();
        });

        updateAmountOriginal();
    }

    function updateAmountOriginal() {
        let totalAmount = 0;
        $('.group-checkbox:checked').each(function () {
            let rows = $(this).closest('tr').nextUntil('tr:has(.group-checkbox)');
            rows.each(function () {
                let amount = parseFloat($(this).find('.total-amount').val()) || 0;
                totalAmount += amount;
            });
        });
        $('#amount_original').val(totalAmount.toFixed(2));
        updateAmountNet();
    }

    function updateAmountNet() {
        
        let amountOriginal = parseFloat($('#amount_original').val()) || 0;
        let amountEdit = parseFloat($('#amount_edit').val()) || 0;
        let discount = parseFloat($('#discount').val()) || 0;

        let amountNet = (amountOriginal + amountEdit) - discount;
        $('#amount_net').val(amountNet.toFixed(2));
        $('#amount_original').val(amountNet.toFixed(2));
    }

    // Validation before submit
    $('#submit-button').on('click', function (event) {
        const calculationMethod = $('#calculation_method').val();
        
        if (calculationMethod === "piece") {
            let missingPrices = false;
            $('.group-checkbox:checked').each(function() {
                $(this).closest('tr').nextUntil('tr:has(.group-checkbox)').each(function() {
                    if (!$(this).find('.piece-price').val()) {
                        missingPrices = true;
                        return false;
                    }
                });
                if (missingPrices) return false;
            });
            
            if (missingPrices) {
                event.preventDefault();
                alert('يجب إدخال سعر القطعة لكل صنف عند اختيار طريقة الحساب بالقطعة');
                return;
            }
        }
        
        if ($('.group-checkbox:checked').length === 0) {
            event.preventDefault();
            alert('يجب اختيار اذن واحد علي الاقل لإنشاء فاتورة.');
        } else {
            $(this).prop('disabled', true);
            $(this).closest('form').submit();
        }
    });



});
</script>


<script>
    $(document).ready(function () {
    
        function updateAmountNetFromInputs() {
            let baseNet = parseFloat($('#amount_original').val()) || 0;
            let minus = parseFloat($('#amount_minus').val()) || 0;
    
            // حساب الضريبة
            let tax = 0;
            if ($('#tax').is(':checked')) {
                tax = baseNet * 0.14;
            }
    
            // حساب الخصم
            let discount = 0;
            if ($('#discount_notice').is(':checked')) {
                discount = baseNet * 0.03;
            }
    
            // النتيجة النهائية: الأصل - الخصم اليدوي + الضريبة - خصم الإشعار
            let result = baseNet - minus + tax - discount;
    
            $('#amount_net').val(result.toFixed(2));
        }
    
        function updateTaxAndDiscount() {
            let baseAmount = parseFloat($('#amount_original').val()) || 0;
    
            if ($('#tax').is(':checked')) {
                let taxValue = baseAmount * 0.14;
                $('#tax_output').val(taxValue.toFixed(2));
            } else {
                $('#tax_output').val('0.00');
            }
    
            if ($('#discount_notice').is(':checked')) {
                let discountValue = baseAmount * 0.03;
                $('#discount_notice_output').val(discountValue.toFixed(2));
            } else {
                $('#discount_notice_output').val('0.00');
            }
    
            // بعد تحديث الحقول، نقوم بتحديث النتيجة النهائية
            updateAmountNetFromInputs();
        }
    
        $('#amount_minus').on('input', function () {
            updateAmountNetFromInputs();
        });
    
        $('#tax, #discount_notice').on('change', function () {
            updateTaxAndDiscount();
        });
    
        $(document).on('change', '.group-checkbox', function () {
            $('#amount_minus').val('0.00').prop('disabled', false);
            $('#tax').prop('checked', false);
            $('#discount_notice').prop('checked', false);
    
            updateTaxAndDiscount();
            updateAmountNetFromInputs();
        });
    
    });
    </script>

<script>
    $(document).ready(function () {        
        function checkDateAndCustomer() {
            let date = $('#date').val();
            let customer_id = $('#customer_id').val();

            if (date && customer_id) {
                $.ajax({
                    url: '/check_date_available',
                    type: 'GET',
                    data: {
                        date: date,
                        customer_id: customer_id
                    },
                    success: function (response) {
                        if (!response.valid) {
                            alert(response.message);
                            $('#date').val(''); 
                        }
                    },
                   
                });
            }
        }

        // Trigger when either date or customer is changed
        $('#date, #customer_id').on('change', checkDateAndCustomer);
    });
</script>