<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    </style>
    <!-- <h1> {{ date("d/m/Y", strtotime(" today")) }}</h1> -->
    <!-- Date In Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('date_in', 'تاريخ الاستلام: <span style="color: red">*</span>', [], false) !!}
        <!-- {!! Form::text('date_in', null, ['class' => 'form-control' . ($errors->has('date_in') ? ' is-invalid' : ''),'id'=>'date_in','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!} -->
    
        <input type="text" value='{{ now()->format("Y/m/d H:i:s") }}' class='form-control' name='date_in' id='date_in' readonly>
        @if ($errors->has('date_in'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('date_in') }}</strong>
         
        </span>
    @endif
        <span id="date_in-error" class="error-message" style="color: red"></span>
    </div>
    
    
    
    <!-- Comment Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('comment', 'الملاحظات:') !!}
        {!! Form::text('comment', null, ['class' => 'form-control']) !!}
    </div>
    
  
    @if(isset($invImportOrder))
    
    <div class="form-group col-sm-6" id="supplier_id_div">
        {!! Form::label('supplier_id', ' ') !!}
        <div id="supplier_id-container">
        {{-- {{ Form::select('supplier_id',$suppliers,null,['placeholder' => 'اختر  المورد','class'=> 'form-control searchable ','id'=>'supplier_id', 'data-placeholder'=>"اختر المورد", 'style'=>"width: 100%", 'onchange' => 'handleProductChange2()'],['option'=>'suppliers']) }} --}}
        {!! Form::hidden('supplier_id', null, ['class' => 'form-control']) !!}
    
    </div>
    @error('supplier_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="supplier_id-error" class="error-message" style="color: red"></span>
    </div>
   
     @else
     <div class="form-group col-sm-6" id="supplier_id_div">
        {!! Form::label('supplier_id', ' المورد:') !!}
        <div id="supplier_id-container">
        {{ Form::select('supplier_id',$suppliers,null,['placeholder' => 'اختر  المورد','class'=> 'form-control searchable ','id'=>'supplier_id', 'data-placeholder'=>"اختر المورد", 'style'=>"width: 100%", 'onchange' => 'handleProductChange2()'],['option'=>'suppliers']) }}
    </div>
    @error('supplier_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="supplier_id-error" class="error-message" style="color: red"></span>
    </div>
    @endif

   <div class="row" id="adding_product" style="margin:0.5rem 0;width:100%">
    @if(isset($invImportOrder))
    
                
                {{-- ====================================حفظ منتجات مختلفه===================================================== --}}
                <button onclick="create_tableproducts('<?php echo $invImportOrder->supplier_id; ?>')" type="button" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i>
                    اضافة صنف
                </button>
                   
                            <table id="empTable" class="table table-boreder" style="border:1.5px solid gray;width:100%">
                                <tr style="background-color: #e0e4e7 !important;">
                                <td class="col-4">اسم الصنف</td>
                                <td class="col-2">الوحدة</td>
                                <td class="col-2">العدد</td>
                                <td class="col-3">المخزن</td>
                                <td class="col-1">العمليات</td> 
                                </tr>
                               @if(isset($table_body))
                                @foreach($table_body as $row)
                                <tr>
                                <td style="padding: 0.75rem;">
                                    <select name="product_id[]" class="form-control item_id searchable" dir="rtl">
                                        @foreach($products as $product)
                                                @if($product->id == $row['product_id'])
                                                    <option value="{{$product->id}}" selected>
                                                        {{$row['product_name']}}
                                                    </option>
                
                                            @endif
                                        @endforeach
                                    </select>
                                    <input  type="hidden" value="{{$row['importorder_details_id']}}" name="importorder_details_id[]" class="form-control">
                                </td>
                                <td style="padding: 0.75rem;">
                                    <select name="unit_id[]" class="form-control unit_id searchable" onchange="product_test_unit(this)">
                                        <option value="{{$row['unit_id']}}">{{$row['unit_name']}}</option>
                                    </select>
                                    
                                </td>
                                <td style="padding: 0.75rem;"><input style="width: 100%" type="text" value="{{$row['quantity']}}" name="quantity[]" class="form-control text-center item_quantity" autocomplete="off"></td>
                                <td style="padding: 0.75rem;">
                                    <select name="store_id[]" class="form-control store_id">
                                        @foreach($stores as $store)
                                        @if($store->id == $row['store_id'])
                                        <option value="{{$store->id}}" selected>{{$store->name}}</option>
                                        @else
                                         
                                         <option value="{{$store->id}}">{{$store->name}}</option>
                                       
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td class ="text-center" style="padding: 0.75rem;">
                                    <button onclick="create_tableproducts('<?php echo $invImportOrder->supplier_id; ?>')" type="button" class="btn btn-link p-1 text-primary" style="font-size: 1.1em;"><i class="fa fa-plus"></i></button>
                                    <button class="btn btn-link p-1 text-danger" onclick="removeRow(this)" style="font-size: 1.0em;"><i class="fa fa-trash"></i></button>

                                </td>
                                </tr>
                                @endforeach
                                @endif
                            </table>
                {{-- ==================================================================================================== --}}
                
                @endif
                <span id="validationMessage" style="color: red;"></span>
    </div> 
    
    <script src="{{URL('js/jquery-3.6.0.min.js')}}" ></script>
    
    <script>
      
        var supplier_id_value = 0;

      function create_tableproducts( supplier_id_value) {
        
              $.ajax({
            type: 'get',
            url: "{!! URL::to('/get_imp_products') !!}",
            data: {  },
            success: function(result) {
                //
               // console.log(result)

            
                // ==================================انشاء الجدول بدون عمود المقاس============================================
                    var container = document.getElementById("adding_product");
                  var tableExists = (container !== null);
                    
                 if (!tableExists) {
                 var container = document.createElement("div");
                 container.setAttribute('id', 'adding_product');
                 container.classList.add('adding_product', 'table-responsive');
                 container.style.width = '-webkit-fill-available';

                 var addFabricsButton = document.createElement('button');
                 addFabricsButton.classList.add('btn', 'btn-info', 'btn-sm','create_tableproducts');
                 addFabricsButton.setAttribute('type', 'button');
                 addFabricsButton.setAttribute('onclick', 'create_tableproducts( ' + supplier_id_value + ')');

                 var plusIcon = document.createElement('i');
                 plusIcon.classList.add('fa', 'fa-plus');
                 addFabricsButton.appendChild(plusIcon);

                 var textNode1 = document.createTextNode('اضافه صنف');
                 var spanElement = document.createElement('span');
                 spanElement.textContent = textNode1.textContent;
                 spanElement.style.paddingRight = "5px";
                 addFabricsButton.appendChild(spanElement);

                 var emp_table = document.createElement("table");
                     emp_table.classList.add('empTable');
                     emp_table.setAttribute('id', 'empTable');
                     emp_table.style.width = "100%";
                     emp_table.style.text_align = "center";
                     emp_table.style.display = "inline-table";
                     emp_table.style.border = '1px solid #d6d5d5';

                    var tbody = document.createElement('tbody');
                     
                    var tr1 = document.createElement('tr');
                    tr1.style.border = '1px solid #d6d5d5';
                    tr1.style.background  = '#e0e4e7';
                    var HeaderCell1 = document.createElement('td');
                    HeaderCell1.classList.add('col-4','text-center');
                    // HeaderCell1.style.border = '1px solid #d6d5d5';
                    HeaderCell1.style.padding= "0.75rem";
                    HeaderCell1.style.verticalAlign = 'middle';
                    HeaderCell1.style.textAlign = 'center';
                    var HeaderSpan1 = document.createElement('span');
                    HeaderSpan1.textContent = 'اسم الصنف';
                    HeaderCell1.appendChild(HeaderSpan1);
                    tr1.appendChild(HeaderCell1);

                    var HeaderCell2 = document.createElement('td');
                    HeaderCell2.classList.add('col-2','text-center');
                    // HeaderCell2.style.border = '1px solid #d6d5d5';
                    HeaderCell2.style.padding= "0.75rem";
                    HeaderCell2.style.verticalAlign = 'middle';
                    HeaderCell2.style.textAlign = 'center';
                    var HeaderSpan2 = document.createElement('span');
                    HeaderSpan2.textContent = 'الوحدة';
                    HeaderCell2.appendChild(HeaderSpan2);
                    tr1.appendChild(HeaderCell2);

                    var HeaderCell3 = document.createElement('td');
                    HeaderCell3.classList.add('col-2','text-center');
                    // HeaderCell3.style.border = '1px solid #d6d5d5';
                    HeaderCell3.style.padding= "0.75rem";
                    HeaderCell3.style.verticalAlign = 'middle';
                    HeaderCell3.style.textAlign = 'center';
                    var HeaderSpan3 = document.createElement('span');
                    HeaderSpan3.textContent = 'العدد';
                    HeaderCell3.appendChild(HeaderSpan3);
                    tr1.appendChild(HeaderCell3);


                    var HeaderCell4 = document.createElement('td');
                    HeaderCell4.classList.add('col-3','text-center');
                    // HeaderCell4.style.border = '1px solid #d6d5d5';
                    HeaderCell4.style.padding= "0.75rem";
                    HeaderCell4.style.verticalAlign = 'middle';
                    HeaderCell4.style.textAlign = 'center';
                    var HeaderSpan4 = document.createElement('span');
                    HeaderSpan4.textContent = 'المخزن';
                    HeaderCell4.appendChild(HeaderSpan4);
                    tr1.appendChild(HeaderCell4);

                    var HeaderCell5 = document.createElement('td');
                    HeaderCell5.classList.add('col-3','text-center');
                    // HeaderCell5.style.border = '1px solid #d6d5d5';
                    HeaderCell5.style.padding= "0.75rem";
                    HeaderCell5.style.verticalAlign = 'middle';
                    HeaderCell5.style.textAlign = 'center';
                    var HeaderSpan5 = document.createElement('span');
                    HeaderSpan5.textContent = 'العمليات';
                    HeaderCell5.appendChild(HeaderSpan5);
                    tr1.appendChild(HeaderCell5);

                 tbody.appendChild(tr1);

                 emp_table.appendChild(tbody);
                 container.append(addFabricsButton,emp_table);
                 var cardBodyDiv = document.querySelector('.card-body');
                 cardBodyDiv.appendChild(container);
                 }
                 addproduct_rows(result,supplier_id_value);

                
            }
        });
         }
        //  ====================================================================================================================
        // Function to add product
        function addproduct_rows(result,supplier_id_value) {
            // console.log(result);
        var supplierSelect = document.getElementById("supplier_id");
      
  
        var isSupplierEmpty = supplierSelect.value === "";
        
        if (isSupplierEmpty) {
            alert("عفوًا... يجب اختيار المورد لاختيار الأصناف");
        } else {
            var empTab = document.getElementById('empTable');
            var rowCnt = empTab.rows.length; // Get the number of rows
            var lastRow = empTab.rows[rowCnt - 1];
    
            // Check if the last row contains data in the "item_quantity," "unit_id," or "item_id" fields
            var itemQuantityInput = lastRow.querySelector('.item_quantity');
            var unitIdSelect = lastRow.querySelector('.unit_id');
            var itemIdSelect = lastRow.querySelector('.item_id');
            var itemstoreSelect = lastRow.querySelector('.store_id');
    
            if (
                (itemQuantityInput && itemQuantityInput.value === '') ||
                (unitIdSelect && unitIdSelect.value === '') ||
                (itemIdSelect && itemIdSelect.value === '') ||
                (itemstoreSelect && itemstoreSelect.value === '') 
    
            ) {
                alert('عفوًا... يجب ادخال جميع بيانات الصف..ليتم اضافه صف جديد.');
                return;
            }
            
            var tr = empTab.insertRow(rowCnt); 
    
            for (var c = 0; c < 5; c++) {
                var td = document.createElement('td'); 
                td = tr.insertCell(c);
                td.style.padding= "0.75rem";
    
                if (c === 4) {
              var removeButton = document.createElement('button');
              var removeIcon = document.createElement('i');
              removeIcon.setAttribute('class', 'fa fa-trash');
              removeButton.setAttribute('type', 'button');
              removeButton.setAttribute('class', 'btn btn-link p-1 text-danger');
              removeButton.setAttribute('onclick', 'removeRow(this)');
              removeButton.appendChild(removeIcon);
              removeButton.style.fontSize= "1.0em";
              removeButton.style.margin= "5px";

              var addButton = document.createElement('button');
              var addIcon = document.createElement('i');
              addIcon.setAttribute('class', 'fa fa-plus');
              addButton.setAttribute('type', 'button');
              addButton.setAttribute('class', 'btn btn-link p-1 text-primary');
              addButton.setAttribute('onclick', 'create_tableproducts( ' + supplier_id_value + ')');
              addButton.appendChild(addIcon);
              addButton.style.fontSize= "1.0em";


              td.appendChild(addButton);
              td.appendChild(removeButton);
              td.classList.add('text-center');
              
                }else if (c === 3) {
                    // Fiveth column
                    var stores = {!! json_encode($stores) !!};
                    var select = document.createElement('select');
                    select.setAttribute('name', 'store_id[]');
                    select.setAttribute('oninvalid', "setCustomValidity('اختر مخزن')");
                    select.setAttribute('onchange', "try{setCustomValidity('')}catch(e){}");
                    select.classList.add('form-control', 'select2', 'store_id');

                    var count_stores = 0;

                    for (var i = 0; i < stores.length; i++) {
                       
                            var option = document.createElement('option');
                            option.value = stores[i].id;
                            option.text = stores[i].name;
                            select.appendChild(option);
                            count_stores++;
                        
                    }

                    if (count_stores > 1) {
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.text = 'اختر المخزن';
                        defaultOption.selected = true;
                        select.insertBefore(defaultOption, select.firstChild);
                    }
                    td.appendChild(select);
 
                } else if (c === 2) {
                    // Third column
                    var ele = document.createElement('input');
                    ele.setAttribute('type', 'text');
                    ele.setAttribute('max', '99999999');
                    ele.setAttribute('min', '1');
                    ele.setAttribute('name', 'quantity[]');
                    ele.setAttribute('value', '');
                    ele.setAttribute('autocomplete', 'off');
                    ele.setAttribute('oninvalid', "setCustomValidity('اختر كمية')");
                    ele.setAttribute('onchange', "try{setCustomValidity('')}catch(e){}");
                    ele.classList.add('form-control','text-center','item_quantity');
                    td.appendChild(ele);
                } else if (c === 1) {
                    // Second column
                    var select = document.createElement('select');
                    select.setAttribute('name', 'unit_id[]');
                    select.setAttribute('oninvalid', "setCustomValidity('اختر وحدة')");
                    select.setAttribute('onchange', "try{setCustomValidity('')}catch(e){}");
                    select.classList.add('form-control', 'searchable', 'unit_id');
                    select.setAttribute('onchange', "product_test_unit(this)");
                    var option = document.createElement('option');
                    option.value = '';
                    option.text = 'اختر وحدة';
                    select.appendChild(option);
                    td.appendChild(select);
                } else if (c === 0) {
    
                 var items = result.products;
                 var select = document.createElement('select');
                 select.setAttribute('name', 'product_id[]');
                 select.setAttribute('dir', 'rtl'); 

                 select.classList.add('form-control', 'searchable', 'item_id');
                 var option = document.createElement('option');
                 option.value = '';
                 option.text = 'اختر صنف';
                 select.appendChild(option);
    
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

        }
        
    
        // Function to delete a row invcolor_category
        function removeRow(oButton) {
            var empTab = document.getElementById('empTable');
            // oButton.parentNode.parentNode.parentNode.remove();
            oButton.parentNode.parentNode.remove();
        }
    
    $(document).ready(function() {
        $(document).on('change', ' #supplier_id', function() {
          var product_category_id = $('#product_category_id').val();
          if(product_category_id =='3'){
            $('#supplier_id').val('4');
            $('#supplier_id_div').hide();
           }else{
            $('#supplier_id_div').show();
           }
          var supplier_id = $('#supplier_id').val();
          $('#adding_product').remove();

        
             
          
              create_tableproducts( supplier_id_value);
        //   } else {
        //       alert('عفوآ...يجب اختيار مجموعه المنتجات والمورد');
        
        });

        // ======================choose product================================================================
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
                    // var selected = '<option selected disabled value="">اختر وحدة</option>';
                    // $(res_ele).prepend(selected); 
                    
                    if (count_uints> 1) {
                        // console.log(count_uints);
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.text = 'اختر وحده';
                        defaultOption.selected = true;
                        $(res_ele).prepend(defaultOption);
                    }else{
                        final_product_test();
                    }

      
                }
            });
        });
    });
    
     function final_product_test(o) {
        var items = document.getElementsByClassName('item_id');
        var units = document.getElementsByClassName('unit_id');
        // var sizes = document.getElementsByClassName('final_product_size_id');
        var selectedValues = [];

          for (var i = 0; i < items.length; i++) {
              var itemValue = items[i].value;
              var unitValue = units[i].value;
            //   var sizeValue = sizes[i].value;
            //   var combinedValue = itemValue + '-' + unitValue +'-' + sizeValue;
              var combinedValue = itemValue + '-' + unitValue;

              if (selectedValues.includes(combinedValue)) {
                  var empTab = document.getElementById('empTable');
                  empTab.deleteRow(empTab.rows.length - 1);
                  alert('عفوآ...اسم الصنف و الوحده تم اختيارهم بالفعل...سوف يتم حذف اخر سطر');
                  return;
              }
              selectedValues.push(combinedValue);
          }
     }


     function product_test_unit(o) {
        var items = document.getElementsByClassName('item_id');
        var units = document.getElementsByClassName('unit_id');
        var selectedValues = [];

          for (var i = 0; i < items.length; i++) {
              var itemValue = items[i].value;
              var unitValue = units[i].value;
              var combinedValue = itemValue + '-' + unitValue;

              if (selectedValues.includes(combinedValue)) {
                  var empTab = document.getElementById('empTable');
                  empTab.deleteRow(empTab.rows.length - 1);
                  alert('عفوآ...اسم الصنف و الوحده تم اختيارهم بالفعل...سوف يتم حذف اخر سطر');
                  return;
              }
      
              selectedValues.push(combinedValue);
          }
     }

    </script>
    
    