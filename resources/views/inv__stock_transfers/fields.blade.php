<style>
    /* Add this CSS to center the text content in the select box */
    #store_out-container .select2-selection__rendered {
        display: flex;
        align-items: center;
        justify-content: right;
        height: 100%;
    }

</style>

<!-- Store Out Field -->
<div class="form-group col-sm-6">
    {!! Form::label('store_out', 'من: <span style="color: red">*</span>', [], false) !!}
    <div id="store_out-container">
    {{ Form::select('store_out',$stores,null,['placeholder' => 'اختر  مخزن ...','class'=> 'form-control searchable ',  'data-placeholder'=>"اختر   مخزن",'id'=>'store_out', 'onchange' => 'handleProductChange()' ],['option'=>'store_out']) }}
</div>
    <span id="store_out-error" class="error-message" style="color: red"></span>
</div>

<!-- Store In Field -->
<div class="form-group col-sm-6">
    {!! Form::label('store_in', 'الى: <span style="color: red">*</span>', [], false) !!}
    <div id="store_in-container">
        @if(isset($invStockTransfer))
        {{ Form::select('store_in',$stores,null,['placeholder' => 'اختر  مخزن ...','class'=> 'form-control searchable ',  'data-placeholder'=>"اختر   مخزن",'id'=>'store_in', 'onchange' => 'handleProductChange1()' ],['option'=>'store_in']) }}
        @else
        {{ Form::select('store_in', [], null, ['placeholder' => 'اختر مخزن ...','class' => 'form-control searchable','data-placeholder' => 'اختر مخزن','id' => 'store_in','onchange' => 'handleProductChange1()']) }}
       @endif
</div>
    <span id="store_in-error" class="error-message" style="color: red"></span>
</div>

<!-- Comment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comment', 'ملاحظات:') !!}
    {!! Form::text('comment', null, ['class' => 'form-control']) !!}
</div>


<div class="row" id="adding" style="margin:1rem 0;width:100%">
          
          <button onclick="addRow()" type="button" class="btn btn-info btn-sm buttons-add">اضافة صنف</button>    
            <table id="empTable" class="table table-boreder" style="border:1.5px solid gray;width:100%">
                <tr>
                <td class="col-4 text-center">اسم الصنف</td>
                <td class="col-2 text-center">الوحدة</td>
                <td class="col-3 text-center">المورد</td>
                <td class="text-center">المتاح</td>
                <td class="text-center">العدد</td>
                <td class="text-center">العمليات</td> 
                </tr>
                @if(isset($table_body))
                @foreach($table_body as $row)
                <tr>
                <td>
                    <select name="product_id[]" class="form-control item_id searchable">
                      @foreach($products as $product)
                        @if ($product->id == $row['product_id'])
                         <option value="{{$product->id}}" selected>
                          {{ $product->get_product->manual_code }} - 
                          {{ optional($product->get_product)->name ? $product->get_product->name  : '' }}
                          @if($product->get_color->colorCategory_id !=1 && $product->get_color->color_code_id !=1)
                           ({{ $product->get_color->invcolor_category->name }} - {{ $product->get_color->get_color_code->name }} )
                          @elseif($product->get_color->colorCategory_id !=1 && $product->get_color->color_code_id ==1)
                           ({{ $product->get_color->invcolor_category->name }})
                           @elseif($product->get_color->colorCategory_id ==1 && $product->get_color->color_code_id !=1)
                           ({{ $product->get_color->get_color_code->name }} )
                          @endif
                         </option>
                        @endif
                       @endforeach
                    </select>
                </td>
                <td>
                    <select name="unit_id[]" class="form-control unit_id searchable">
                        @foreach($row['units'] as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
                    
                </td>
                <td>
                  
                    <select name="supplier_id[]" class="form-control supplier_id searchable" onchange="product_test_unit(this)">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                @if($supplier->id == $row['supplier_id']) selected @endif>
                                {{$supplier->name}}
                            </option>
                        @endforeach
                    </select>  
                </td>
                @php
                $unitContent = $row['units'][0]['pivot']['unitcontent'] ?? 1;
                $quantityOut = $row['quantity'] / $unitContent;
                $total_sum = $row['total_sum'] / $unitContent;
               @endphp
                <td>
                    <input type="text" value="{{  $total_sum + $quantityOut}}"  class="form-control text-center stock_quantity" readonly>
                </td>
                <td>
                <input type="text" value="{{ $quantityOut}}" name="quantity[]" class="form-control text-center item_quantity">
                </td>
                <td>
                    <button class="btn btn-link btn-danger btn-just-icon destroy" onclick="removeRow(this)"><i class="fa fa-trash"></i></button>
                </td>
                </tr>
                @endforeach
                @endif
            </table>
            <span id="validationMessage" style="color: red;"></span>
</div>

<script src="{{ asset('datatables_js/jquery-3.6.0.min.js') }}" ></script>
<script>

    // function to add new row.
    function addRow() {

        var storeOutValue = document.getElementById('store_out').value;
        var storeInValue = document.getElementById('store_in').value;

        // Check if store_out and store_in contain the same selected option
        if (!storeOutValue || !storeInValue) {
         alert('عفوآ...يرجى اختيار محول من مخزن ومحول الى مخزن قبل إضافة صف جديد.');
         return; 
        }

         // Validate existing rows
            var empTab = document.getElementById('empTable');
            var rows = empTab.getElementsByTagName('tr');
            for (var i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                var itemQuantity = rows[i].querySelector('.item_quantity');
                var supplierId = rows[i].querySelector('.supplier_id');
                var unitId = rows[i].querySelector('.unit_id');
                var itemId = rows[i].querySelector('.item_id');

                if (
                    !itemQuantity || !itemQuantity.value ||
                    !supplierId || !supplierId.value ||
                    !unitId || !unitId.value ||
                    !itemId || !itemId.value
                ) {
                    alert('عفوآ...يرجى تعبئة جميع الكميات واختيار المورد والوحدة والصنف قبل إضافة صف جديد.');
                    return;
                }
            }

        var rowCnt = empTab.rows.length;    
        var tr = empTab.insertRow(rowCnt); 

        for (var c = 0; c < 6; c++) {
            var td = document.createElement('td');   
            td = tr.insertCell(c);

            if (c == 5) {  
                // add a button control.
                var button = document.createElement('button');
                var icon = document.createElement('i');
                icon.setAttribute('class', 'fa fa-trash');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-link btn-danger btn-just-icon destroy');
                button.setAttribute('onclick', 'removeRow(this)');
                td.appendChild(button).appendChild(icon);
                
            } else if(c == 4){
                var ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('max', '99999999');
                ele.setAttribute('min', '1');
                ele.setAttribute('name', 'quantity[]');
                ele.setAttribute('value', '');
                ele.classList.add('form-control','text-center','item_quantity');
                td.appendChild(ele);
            } else if (c === 3) {
                var ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('max', '99999999');
                ele.setAttribute('min', '1');
                ele.setAttribute('value', '');
                ele.setAttribute('readonly', 'readonly');
                ele.classList.add('form-control','text-center','stock_quantity');
                td.appendChild(ele);
            } else if (c === 2) {
                 // Fourth column
                var select = document.createElement('select');
                select.setAttribute('name', 'supplier_id[]');
                select.classList.add('form-control', 'searchable', 'supplier_id');
                select.setAttribute('onchange', "product_test_unit(this)");
                var option = document.createElement('option');
                option.value = '';
                option.text = 'اختر المورد';
                select.appendChild(option);
                td.appendChild(select);
            }else if(c == 1){

            var select = document.createElement("select");
            select.setAttribute('name','unit_id[]');
            select.classList.add('form-control','searchable','unit_id')
            var option = document.createElement("option");
             option.value =''
             option.text ='اختر وحدة'
             select.appendChild(option);
            td.appendChild(select);

            }else if(c == 0){
            var items = {!! json_encode($products) !!};  
            var select = document.createElement("select");
            select.setAttribute('name','product_id[]');
            select.classList.add('form-control','item_id','searchable');
            var option = document.createElement("option");
                option.value =''
                option.text ='اختر صنف'
                select.appendChild(option);
            var i = 0;
            for (var item of items) {
                    option = document.createElement('option');
                    option.value = item.id;
        
                    let productText = '';

                    // Add manual code if it exists
                    productText += item.get_product?.manual_code ? ' ' + item.get_product.manual_code : '';
                    productText += '-';
                    productText += item.get_product?.name ? ' ' + item.get_product.name : '';
                    productText += item.get_product?.get_product_description?.name ? ' ' + item.get_product.get_product_description.name : '';

                    // Add color details based on the conditions
                    if (item.get_color.colorCategory_id != 1 && item.get_color.color_code_id != 1) {
                        productText += item.get_color?.invcolor_category?.name 
                            ? ` (${item.get_color.invcolor_category.name} - ${item.get_color.get_color_code.name})` 
                            : '';
                    } else if (item.get_color.colorCategory_id != 1 && item.get_color.color_code_id == 1) {
                        productText += item.get_color?.invcolor_category?.name 
                            ? ` (${item.get_color.invcolor_category.name})` 
                            : '';
                    } else if (item.get_color.colorCategory_id == 1 && item.get_color.color_code_id != 1) {
                        productText += item.get_color?.get_color_code?.name 
                            ? ` (${item.get_color.get_color_code.name})` 
                            : '';
                    }

                    option.text = productText;
                    select.appendChild(option);
                }
            td.appendChild(select);
            }

        }
        $('.searchable').select2();
    }

    // function to delete a row.
    function removeRow(oButton) {
        var empTab = document.getElementById('empTable');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex); // buttton -> td -> tr
    }

    $( document ).ready(function() {
        

        $(document).on('change', '#store_out', function() {
            var store_out = $(this).val();

             // REMOVE ALL ROWS EXCEPT HEADER ROW
            var empTab = document.getElementById('empTable');
            var rowCount = empTab.rows.length;
        
            for (var i = rowCount - 1; i > 0; i--) {
                empTab.deleteRow(i);
            }
            
            $.ajax({
                type: 'get',
                url: "{!! URL::to('/get_store_in_data') !!}",
                data: { 'store_out': store_out },
                success: function(result) {
                  var storeInSelect = $('#store_in');

                    // Clear existing options
                    storeInSelect.empty();

                    // Append a default placeholder
                    var placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.text = 'اختر مخزن ...';
                    placeholderOption.disabled = true;
                    placeholderOption.selected = true;
                    storeInSelect.append(placeholderOption);

                    for (var i = 0; i < result.length; i++) {
                        var store = result[i];
                        var option = document.createElement('option');
                        option.value = store.id;
                        option.text = store.name;
                        storeInSelect.append(option);
                    }

                }
            });
        });  

    $(document).on('change', '.item_id', function() {
            var item_id = $(this).val();

            var op = '';
            var res_ele = $(this).closest('td').siblings().find('select')[0];
            $(this).closest('tr').find('.item_quantity').val('');
            var count_uints = 0;
            $.ajax({
                type: 'get',
                url: "{!! URL::to('/findunits') !!}",
                data: { 'id': item_id },
                success: function(result) {
               
                    for (var i = 0; i < result.length; i++) {
                        var row = result[i];
                        var invProducts = row.get_product.get_inv_product_unit;
                        for (var j = 0; j < invProducts.length; j++) {
                            var unit = invProducts[j];
                            op += '<option value="' + unit.get_unit.id + '">' + unit.get_unit.name + '</option>';
                            count_uints++;
                        }
                        
                    }
                    
                    $(res_ele).empty().append(op); 

                    if (count_uints> 1) {
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.text = 'اختر وحده';
                        defaultOption.selected = true;
                        $(res_ele).prepend(defaultOption);
                    }else{
                        final_product_test();
                        $(res_ele).trigger('change');
                    }
      
      
                }
            });
    });

// =========================================================================================================================
$(document).on('change', '.unit_id', function(event) {
        var unit_id = $(this).val();
        var item_id = $(this).closest('tr').find('.item_id').val();
        var store_out = $('#store_out').val();
        var op = '';
        var res_ele = $(this).closest('tr').find('.stock_quantity');
        var target = $(this).closest('tr').find('.supplier_id');
        $(this).closest('tr').find('.item_quantity').val('');

        $.ajax({
            type: 'get',
            url: '{{ url("/find_stockTransfer") }}',
            data: { 'unit_id': unit_id, 'item_id': item_id,'store_out':store_out },
            success: function(result) {
             
                if (result.stocks.length === 0) {
                    alert('عفوآ...لا يجود مخزون من هذا الصنف');
                    event.target.parentNode.parentNode.remove();
                } else {
                   
                    for (var i = 0; i < result.stocks.length; i++) {
                      
                        var row = result.stocks[i];
                        if (row.sum > 0) {   
                       op += '<option value="' + row.get_store.id + '" stock="' + row.sum + '">' + row.get_store.name + ' / (' + row.sum + ')</option>';
                         if (result.suppliers.length === 1) {
                         res_ele.val(row.sum);
                         }
                        }
    
                    }

                    var supplierOptions = '<option value="" disabled selected>اختر المورد</option>';
                    if (result.suppliers.length === 1) {
                    supplierOptions += '<option value="' + result.suppliers[0].supplier_id + '" selected>' + result.suppliers[0].get_supplier.name + '</option>';
                    } else {
                   
                    for (var j = 0; j < result.suppliers.length; j++) {
                    var supplierRow = result.suppliers[j];
                    supplierOptions += '<option value="' + supplierRow.supplier_id + '">' + supplierRow.get_supplier.name + '</option>';
                    }
                    }
                    target.empty().append(supplierOptions);

                    // product_test_unit(event.target.parentNode.parentNode);
    
                }
            }
        });
});
            // ================ get store data && quantity in each store for each supplier_id===========================================================
            $(document).on('change', '.supplier_id', function(event) {
                var supplier_id = $(this).val();
                var item_id = $(this).closest('tr').find('.item_id').val();
                var unit_id = $(this).closest('tr').find('.unit_id').val();
                var item_quantity = $(this).closest('tr').find('.item_quantity');
                var store_out = $('#store_out').val();
                var op = '';
                var res_ele = $(this).closest('tr').find('.stock_quantity');
                item_quantity.val('');
                res_ele.val('');

                $.ajax({
                    type: 'get',
                    url: '{{ url("/get_supplier_stock") }}',
                    data: { 'supplier_id': supplier_id, 'item_id': item_id, 'unit_id': unit_id,'store_out':store_out},
                    success: function(result) {

                        if (result.length === 0) {
                            alert('عفوآ...لا يجود مخزون من هذا الصنف');
                            var empTab = document.getElementById('empTable');
                            empTab.deleteRow(empTab.rows.length - 1);
                        } else {
                            for (var i = 0; i < result.length; i++) {
                                var row = result[i];
                                if (row.sum > 0) {
                                res_ele.val(row.sum);
                                }else{
                                    res_ele.val("0");
                                }
                            }
                            
                        }
                    }
                });
            });

// ===========================================================================================================================
});

function final_product_test(o) {
        var items = document.getElementsByClassName('item_id');
        var units = document.getElementsByClassName('unit_id');
        var supplier_id = document.getElementsByClassName('supplier_id');
        var selectedValues = [];

          for (var i = 0; i < items.length; i++) {
              var itemValue = items[i].value;
              var unitValue = units[i].value;
              var supplier_idValue = supplier_id[i].value;
  
            var combinedValue = itemValue + '-' + unitValue+ '-' + supplier_idValue;

              if (selectedValues.includes(combinedValue)) {
                  var empTab = document.getElementById('empTable');
                  empTab.deleteRow(empTab.rows.length - 1);
                  alert('عفوآ...اسم الصنف و الوحده و المورد تم اختيارهم بالفعل...سوف يتم حذف اخر سطر');
                  return;
              }
              selectedValues.push(combinedValue);
          }
     }

     function product_test_unit(o) {
        var items = document.getElementsByClassName('item_id');
        var units = document.getElementsByClassName('unit_id');
        var supplier_id = document.getElementsByClassName('supplier_id');

        var selectedValues = [];

          for (var i = 0; i < items.length; i++) {
              var itemValue = items[i].value;
              var unitValue = units[i].value;
              var supplier_idValue = supplier_id[i].value;
  
              var combinedValue = itemValue + '-' + unitValue+ '-' + supplier_idValue;
          
              if (selectedValues.includes(combinedValue)) {
                  var empTab = document.getElementById('empTable');
                  empTab.deleteRow(empTab.rows.length - 1);
                  alert('عفوآ...اسم الصنف و الوحده و المورد تم اختيارهم بالفعل...سوف يتم حذف اخر سطر');
                  return;
              }
      
              selectedValues.push(combinedValue);
          }
     }
</script>
