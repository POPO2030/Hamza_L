<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    </style>
    
    <!-- Date In Field -->
    @if(!isset($table_body))
    <div class="form-group col-sm-6">
        {!! Form::label('date_out', 'تاريخ الصرف: <span style="color: red">*</span>', [], false) !!}
        <input type="text" value='{{ now()->format("Y/m/d H:i:s") }}' class='form-control' name='date_out' id='date_out' readonly>
        @if ($errors->has('date_out'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('date_out') }}</strong>
         
        </span>
    @endif
        <span id="date_out-error" class="error-message" style="color: red"></span>
    </div>
    
    @else
    
    <div class="form-group col-sm-6">
        {!! Form::label('date_out', 'تاريخ الصرف: <span style="color: red">*</span>', [], false) !!}
        {{-- {!! Form::date('date_out', date('Y-m-d', strtotime($invExportOrder->date_out)), ['class' => 'form-control text-center' . ($errors->has('date_out') ? ' is-invalid' : ''),'id'=>'date_out','onkeyup' => 'replaceChars(this)', 'oninput' => 'removeError(this), replaceChars(this)']) !!} --}}
        <input type="text" value='{{ now()->format("Y/m/d H:i:s") }}' class='form-control' name='date_out' id='date_out' readonly>
        @if ($errors->has('date_out'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('date_out') }}</strong>
         
        </span>
    @endif
        <span id="date_out-error" class="error-message" style="color: red"></span>
    </div>
    @endif
    
    @if(isset($table_body))
    <!-- manual_id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('manual_id', 'رقم المستند:') !!}
        {!! Form::text('manual_id', $invExportOrder->manual_id, ['class' => 'form-control text-center']) !!}
    </div>
    @else
    <!-- manual_id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('manual_id', 'رقم المستند:') !!}
        {!! Form::text('manual_id', null, ['class' => 'form-control text-center']) !!}
    </div>
    @endif
    
    <!-- Customer Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('work_order_id', ' يصرف الى:') !!}
        <div id="work_order_id-container">
            @if(isset($invExportOrder)) 
            @if ($invExportOrder->work_order_id === 'lab')
            <input type="text" class="form-control work_order_id text-center"id="spend_name" value="المعمل" readonly>
            <input type="hidden" class="form-control work_order_id text-center" name="work_order_id" id="work_order_id" value="lab" readonly>
            @elseif ($invExportOrder->work_order_id === 'spare_parts')
            <input type="text" class="form-control work_order_id text-center"id="spend_name" value="قطع غيار" readonly>
            <input type="hidden" class="form-control work_order_id text-center" name="work_order_id" id="work_order_id" value="spare_parts" readonly>
            @else
            <input type="text" class="form-control work_order_id text-center" name="work_order_id" id="work_order_id" value="{{$invExportOrder->work_order_id}}" readonly>
            @endif

            @else
            {{-- {{ Form::select('product_category_id',$cats,null,['placeholder' => 'اختر  نوع الصرف','class'=> 'form-control searchable ','id'=>'product_category_id' ,'data-placeholder'=>"اختر  نوع الصرف", 'style'=>"width: 100%"],['option'=>'cats']) }} --}}
            <select name="work_order_id" class="form-control work_order_id searchable" id="work_order_id">
                <option value="" selected disabled>اختر</option>
                <option value="lab">المعمل</option>
                <option value="spare_parts">قطع غيار</option>
                @foreach($work_orders as $work_order)
                <option value="{{$work_order->id}}">{{$work_order->id}}</option>
                @endforeach
            </select>
            @endif
        
    </div>
        <span id="work_order_id-error" class="error-message" style="color: red"></span>
    </div>

    
        <!-- Comment Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('comment', 'الملاحظات:') !!}
            {!! Form::text('comment', null, ['class' => 'form-control text-center']) !!}
        </div>

    @if(isset($table_body))
        <div class="row" id="adding_product" style="margin:1rem 0;width:100%">
    
            <button onclick="create_tableproducts('<?php echo $invExportOrder->product_category_id; ?>')" type="button" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i>
                اضافة صنف
            </button>    
                    <table id="empTable" class="table table-boreder empTable" style="border:1.5px solid gray;width:100%">
                        <tr style="background-color: #e0e4e7 !important;">
                        <td class="col-4 text-center">اسم الصنف</td>
                        <td class="col-3 text-center">الوحدة</td>
                        <td class="col-2 text-center">المورد</td>
                        <td class="col-1 text-center">العدد</td>
                        <td class="col-2 text-center">المخزن</td>                  
                        <td class="col-2 text-center">حذف</td> 
                        </tr>
                        
                        @foreach($table_body as $row)
                        <tr>
                            <td>

                                <select name="product_id[]" class="form-control item_id">
                                    @foreach($products as $product)
                                    @if ($product->id == $row->product_color->id)
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
                                <select name="unit_id[]" class="form-control unit_id" onchange="product_test_unit(this)">
                                    <option value="{{$row->get_unit->id}}">{{$row->get_unit->name}}</option>
                                </select>
                            
                            </td>
                            <td>
            
                            <select name="supplier_id[]" class="form-control supplier_id" onchange="product_test_unit(this)">
                                    @foreach($row->product_supplier->unique('supplier_id') as $supplier)
                                        <option value="{{ $supplier->supplier_id }}" 
                                            @if($supplier->supplier_id == $row->supplier_id) selected @endif>
                                            {{$supplier->get_supplier->name}}
                                        </option>
                                    @endforeach
                                </select>                 

                            </td> 
                            <td >
                            <input  type="text" value="{{$row->quantity}}" name="quantity[]" class="form-control text-center item_quantity" autocomplete="off">
                            </td>
                            <td>
                            <select name="store_id[]" class="form-control store_id ">
                                @foreach ($sum_qty as $item)
                                    @foreach ($item['stocks'] as $qty)
                                    @if($qty['store_id'] == $row->store_id && $item['unit_id'] == $row->unit_id && $qty['product_id'] == $row->product_id && $item['supplier_id'] == $row->supplier_id)
                                            <option value="{{$row->store_id }}" stock="{{$qty['sum'] + $row->quantity}}" selected> {{$row->get_store->name}}/{{$qty['sum'] + $row->quantity}} </option>
                                            @break
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                            </td>
                    
                            <td>
                           
                            <button onclick="create_tableproducts('<?php echo $invExportOrder->work_order_id; ?>')" type="button" class="btn btn-link p-0 text-primary" style="font-size: 1.0em;"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-link p-0 text-danger" onclick="removeRow(this)" style="font-size: 1.0em;"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach 
                    </table>
            <span id="validationMessage" style="color: red"></span>
        </div>     
        @endif

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}" ></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}



    <script>

       var category_id_value = 0;

      function create_tableproducts() {
              $.ajax({
            type: 'get',
            url: "{!! URL::to('/get_imp_products') !!}",
            success: function(result) {

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
                //  addFabricsButton.setAttribute('onclick', 'create_tableproducts('+ category_id_value +')');
                 addFabricsButton.setAttribute('onclick', 'create_tableproducts()');

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
                    HeaderCell2.classList.add('col-1','text-center');
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
                    // HeaderCell4.style.border = '1px solid #d6d5d5';
                    HeaderCell3.style.padding= "0.75rem";
                    HeaderCell3.style.verticalAlign = 'middle';
                    HeaderCell3.style.textAlign = 'center';
                    var HeaderSpan3 = document.createElement('span');
                    HeaderSpan3.textContent = 'المورد';
                    HeaderCell3.appendChild(HeaderSpan3);
                    tr1.appendChild(HeaderCell3);

                    var HeaderCell4 = document.createElement('td');
                    HeaderCell4.classList.add('col-2','text-center');
                    // HeaderCell3.style.border = '1px solid #d6d5d5';
                    HeaderCell4.style.padding= "0.75rem";
                    HeaderCell4.style.verticalAlign = 'middle';
                    HeaderCell4.style.textAlign = 'center';
                    var HeaderSpan4 = document.createElement('span');
                    HeaderSpan4.textContent = 'العدد';
                    HeaderCell4.appendChild(HeaderSpan4);
                    tr1.appendChild(HeaderCell4);

                    var HeaderCell5 = document.createElement('td');
                    HeaderCell5.classList.add('col-3','text-center');
                    // HeaderCell5.style.border = '1px solid #d6d5d5';
                    HeaderCell5.style.padding= "0.75rem";
                    HeaderCell5.style.verticalAlign = 'middle';
                    HeaderCell5.style.textAlign = 'center';
                    var HeaderSpan5 = document.createElement('span');
                    HeaderSpan5.textContent = 'المخزن';
                    HeaderCell5.appendChild(HeaderSpan5);
                    tr1.appendChild(HeaderCell5);

                    var HeaderCell6 = document.createElement('td');
                    HeaderCell6.classList.add('col-2','text-center');
                    // HeaderCell6.style.border = '1px solid #d6d5d5';
                    HeaderCell6.style.padding= "0.75rem";
                    HeaderCell6.style.verticalAlign = 'middle';
                    HeaderCell6.style.textAlign = 'center';
                    var HeaderSpan6 = document.createElement('span');
                    HeaderSpan6.textContent = 'العمليات';
                    HeaderCell6.appendChild(HeaderSpan6);
                    tr1.appendChild(HeaderCell6);

                 tbody.appendChild(tr1);

                 emp_table.appendChild(tbody);
                 container.append(addFabricsButton,emp_table);
                 var cardBodyDiv = document.querySelector('.card-body');
                 cardBodyDiv.appendChild(container);
                 }
                 addproduct_rows(result);

            }
        });
 }
// =====================================================================================================
        // داله اضافه الصفوف فى حالى اذا كانت مجموعه المنتجات اقمش او خيوط..الخ
        function addproduct_rows(result){

            $('.searchable').select2();
  
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
        alert('عفوًا... لا يمكن إضافة صف جديد إذا كانت الكمية أو الوحدة أو الصنف فارغة أو المخزن فارغة.');
        return;
    }
            var tr = empTab.insertRow(rowCnt); // Table row
            for (var c = 0; c < 6; c++) {
                var td = document.createElement('td'); // Table cell
                td = tr.insertCell(c);
                td.style.padding= "0.75rem";
                     
                if (c === 5) {
                    // Add a button control
                    var removeButton = document.createElement('button');
                      var removeIcon = document.createElement('i');
                      removeIcon.setAttribute('class', 'fa fa-trash');
                      removeButton.setAttribute('type', 'button');
                      removeButton.setAttribute('class', 'btn btn-link p-0 text-danger');
                      removeButton.setAttribute('onclick', 'removeRow(this)');
                      removeButton.appendChild(removeIcon);
                      removeButton.style.fontSize= "1.0em";
                      removeButton.style.margin= "5px";

                      var addButton = document.createElement('button');
                      var addIcon = document.createElement('i');
                      addIcon.setAttribute('class', 'fa fa-plus');
                      addButton.setAttribute('type', 'button');
                      addButton.setAttribute('class', 'btn btn-link p-0 text-primary');
                      addButton.setAttribute('onclick', 'create_tableproducts(' + category_id_value +')');
                      addButton.appendChild(addIcon);
                      addButton.style.fontSize= "1.0em";

                      td.appendChild(addButton);
                      td.appendChild(removeButton);

                      td.classList.add('text-center');

                    } else if (c === 4) {
                    // fiveth column
                    var select = document.createElement('select');
                    select.setAttribute('name', 'store_id[]');
                    select.classList.add('form-control', 'select2', 'store_id');
                    var option = document.createElement('option');
                    option.setAttribute('stock', 'false');
                    option.innerText = 'اختر مخزن';
                    select.appendChild(option);
                    td.appendChild(select);
                } else if (c === 3) {
                        // Second column
                        var ele = document.createElement('input');
                    ele.setAttribute('type', 'double number');
                    ele.setAttribute('max', '99999999');
                    ele.setAttribute('min', '1');
                    ele.setAttribute('name', 'quantity[]');
                    ele.setAttribute('value', '');
                    ele.setAttribute('autocomplete', 'off');
                    //ele.setAttribute('readonly', 'readonly');
                    ele.classList.add('form-control','text-center' ,'item_quantity');
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
                } else if (c === 1) {
                    // Second column
                    var select = document.createElement('select');
                    select.setAttribute('name', 'unit_id[]');
                    select.classList.add('form-control', 'searchable', 'unit_id');
                    // select.setAttribute('onchange', "product_test_unit(this)");
                    var option = document.createElement('option');
                    option.value = '';
                    option.text = 'اختر وحدة';
                    select.appendChild(option);
                    td.appendChild(select);
    
                } else if (c === 0) {
                    // // First column
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
        // =====================================================================================================

            // Function to delete a row invcolor_category
            function removeRow(oButton) {
            var empTab = document.getElementById('empTable');
            oButton.parentNode.parentNode.remove();
        }
    
        $(document).ready(function() {

        // ================ celear quantity if store changed ===============================
        $(document).on('change', '.store_id', function(event) {
            var store_id = $(this).val();
            var item_quantity = $(this).closest('tr').find('.item_quantity');
            item_quantity.val('');
        });

        //=====================================يصرف الى===================================================
            $(document).on('change', '#work_order_id', function() {
              var work_order_id = $('#work_order_id').val();
               productCategory = $('#work_order_id').val();

                $('#adding_product').remove();

                    if (work_order_id.trim()) {
                        work_order_id = work_order_id;
                
                    create_tableproducts(category_id_value);
                    }
            });
              // ================get product request id===========================================================
            $(document).on('change', '#final_product_request_id', function() {
             var final_product_request_id = $('#final_product_request_id').val();

                // ============================================================================================
                var existingTable = document.getElementById("adding_product");
                if (existingTable) {
                    existingTable.remove();
                }

                var container = document.getElementById("adding_product");
                if (!container) {
                    container = document.createElement("div");
                    container.setAttribute('id', 'adding_product');
                    container.classList.add('adding_product', 'table-responsive');
                    container.style.width = '-webkit-fill-available';

                    var emp_table = document.createElement("table");
                    emp_table.classList.add('empTable');
                    emp_table.setAttribute('id', 'empTable');
                    emp_table.style.width = "100%";
                    emp_table.style.textAlign = "center";
                    emp_table.style.display = "inline-table";
                    emp_table.style.border = '1px solid #d6d5d5';

                    var tbody = document.createElement('tbody');

                    var tr1 = document.createElement('tr');
                    tr1.style.border = '1px solid #d6d5d5';
                    tr1.style.background = '#e0e4e7';

                    var HeaderCell1 = document.createElement('td');
                    HeaderCell1.classList.add('col-4', 'text-center');
                    HeaderCell1.style.padding = "0.75rem";
                    HeaderCell1.style.verticalAlign = 'middle';
                    HeaderCell1.style.textAlign = 'center';
                    var HeaderSpan1 = document.createElement('span');
                    HeaderSpan1.textContent = 'اسم الصنف';
                    HeaderCell1.appendChild(HeaderSpan1);
                    tr1.appendChild(HeaderCell1);

                    var HeaderCell2 = document.createElement('td');
                    HeaderCell2.classList.add('col-2', 'text-center');
                    HeaderCell2.style.padding = "0.75rem";
                    HeaderCell2.style.verticalAlign = 'middle';
                    HeaderCell2.style.textAlign = 'center';
                    var HeaderSpan2 = document.createElement('span');
                    HeaderSpan2.textContent = 'الوحدة';
                    HeaderCell2.appendChild(HeaderSpan2);
                    tr1.appendChild(HeaderCell2);

                    var HeaderCell3 = document.createElement('td');
                    HeaderCell3.classList.add('col-2', 'text-center');
                    HeaderCell3.style.padding = "0.75rem";
                    HeaderCell3.style.verticalAlign = 'middle';
                    HeaderCell3.style.textAlign = 'center';
                    var HeaderSpan3 = document.createElement('span');
                    HeaderSpan3.textContent = 'الكميه المطلوبه';
                    HeaderCell3.appendChild(HeaderSpan3);
                    tr1.appendChild(HeaderCell3);

                    var HeaderCell4 = document.createElement('td');
                    HeaderCell4.classList.add('col-2', 'text-center');
                    HeaderCell4.style.padding = "0.75rem";
                    HeaderCell4.style.verticalAlign = 'middle';
                    HeaderCell4.style.textAlign = 'center';
                    var HeaderSpan4 = document.createElement('span');
                    HeaderSpan4.textContent = 'العدد';
                    HeaderCell4.appendChild(HeaderSpan4);
                    tr1.appendChild(HeaderCell4);

                    var HeaderCell5 = document.createElement('td');
                    HeaderCell5.classList.add('col-3', 'text-center');
                    HeaderCell5.style.padding = "0.75rem";
                    HeaderCell5.style.verticalAlign = 'middle';
                    HeaderCell5.style.textAlign = 'center';
                    var HeaderSpan5 = document.createElement('span');
                    HeaderSpan5.textContent = 'المخزن';
                    HeaderCell5.appendChild(HeaderSpan5);
                    tr1.appendChild(HeaderCell5);

                    var HeaderCell6 = document.createElement('td');
                    HeaderCell6.classList.add('col-3', 'text-center');
                    HeaderCell6.style.padding = "0.75rem";
                    HeaderCell6.style.verticalAlign = 'middle';
                    HeaderCell6.style.textAlign = 'center';
                    var HeaderSpan6 = document.createElement('span');
                    HeaderSpan6.textContent = 'العمليات';
                    HeaderCell6.appendChild(HeaderSpan6);
                    tr1.appendChild(HeaderCell6);

                    tbody.appendChild(tr1);
                    emp_table.appendChild(tbody);
                    container.append(emp_table);

                    var cardBodyDiv = document.querySelector('.card-body');
                    cardBodyDiv.appendChild(container);
                }
                //==================================================================================================
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('/final_product_requset') !!}',
                    data: { 'final_product_request_id': final_product_request_id },
                    success: function(result) {

                        addfinal_product(result);
                    }
                });
           });


              // ================get product unit===========================================================
            $(document).on('change', '.item_id', function() {
                var item_id = $(this).val();
                var op = '';
                var res_ele = $(this).closest('td').siblings().find('select')[0];
                $(this).closest('tr').find('.item_quantity').val('');

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('/findunits1') !!}',
                    data: { 'id': item_id },
                    success: function(result) {
                    for (var i = 0; i < result.length; i++) {
                        var row = result[i];
                        for (var x = 0; x < row.get_product.get_inv_product_unit.length; x++) {
                            var unit = row.get_product.get_inv_product_unit[x];
                            op += '<option value="' + unit.get_unit.id + '">' + unit.get_unit.name + '</option>';
                            
                        }
                    }
    
                    $(res_ele).empty().append(op); 
                    var selected = '<option selected disabled value="">اختر وحدة</option>';
                    $(res_ele).prepend(selected); 
                    }
                });
        
            });
            // ================ get store data && quantity in each store ===========================================================
    $(document).on('change', '.unit_id', function(event) {
        var unit_id = $(this).val();
        var row = $(this).closest('tr'); // الصف الحالي
        var item_id = row.find('.item_id').val();
        var product_category_id = $('#product_category_id').val();
        var op = '';

        // select الخاص بالمخزن في نفس الصف
        var res_ele = row.find('.store_id'); 

        var target = row.find('.supplier_id');
        row.find('.item_quantity').val('');
    
        $.ajax({
            type: 'get',
            url: '{{ url("/find_stock") }}',
            data: { 
                'unit_id': unit_id, 
                'item_id': item_id, 
                'product_category_id': product_category_id 
            },
            success: function(result) {
        
                if (!result.stocks || result.stocks.length === 0) {
                    alert('عفوآ...لا يجود مخزون من هذا الصنف');
                    row.remove();
                } else {
                    for (var i = 0; i < result.stocks.length; i++) {
                        var rowStock = result.stocks[i];
                        if (rowStock.sum > 0) {   
                            op += '<option value="' + rowStock.get_store.id + '" stock="' + rowStock.sum + '">' + rowStock.get_store.name + ' / (' + rowStock.sum + ')</option>';
                        }
                    }

                    res_ele.empty().append('<option selected disabled value="">اختر مخزن</option>' + op);

                    var supplierOptions = '<option value="" disabled selected>اختر المورد</option>';

                    if (result.suppliers.length === 1) {
                        supplierOptions += '<option value="' + result.suppliers[0].supplier_id + '" selected>' + result.suppliers[0].get_supplier.name + '</option>';
                        target.empty().append(supplierOptions);
                        target.trigger('change'); 
                    } else {
                        for (var j = 0; j < result.suppliers.length; j++) {
                            var supplierRow = result.suppliers[j];
                            supplierOptions += '<option value="' + supplierRow.supplier_id + '">' + supplierRow.get_supplier.name + '</option>';
                        }
                        target.empty().append(supplierOptions);
                    }

                    product_test_unit(row[0]); 
                }
            }
        });
    }); 

            // ================ get store data && quantity in each store for each supplier_id===========================================================
    $(document).on('change', '.supplier_id', function() {
        var supplier_id = $(this).val();
        var item_id = $(this).closest('tr').find('.item_id').val();
        var unit_id = $(this).closest('tr').find('.unit_id').val();
        var item_quantity = $(this).closest('tr').find('.item_quantity');
        var op = '';
        var res_ele = $(this).closest('tr').find('.store_id');

        item_quantity.removeAttr('readonly');
        item_quantity.val('');
       
        $.ajax({
            type: 'get',
            url: '{{ url("/find_supplier_stock") }}',
            data: { 'supplier_id': supplier_id, 'item_id': item_id, 'unit_id': unit_id},
            success: function(result) {
                console.log(result);
                if (result.length === 0) {
                    alert('عفوآ...لا يجود مخزون من هذا الصنف');
                    var empTab = document.getElementById('empTable');
                    empTab.deleteRow(empTab.rows.length - 1);
                } else {
                    for (var i = 0; i < result.length; i++) {
                        var row = result[i];
                        if (row.sum > 0) {
                       op += '<option value="' + row.get_store.id + '" stock="' + row.sum + '">' + row.get_store.name + ' / (' + row.sum + ')</option>';
                       }
                    }
                    $(res_ele).empty().append(op);
                    
                }
            }
        });
    });
    
     document.addEventListener('change', function(event) {
        if (event.target.classList.contains('item_quantity')) {
            var quantity = event.target.value;
            // var select = event.target.parentNode.parentNode.parentNode.childNodes[4].childNodes[0];
            // استخدام closest للعثور على الصف بدلاً من parentNode المتعددة
            var row = event.target.closest('tr');
            var select = row.querySelector('select.store_id');
            var stock = select.options[select.selectedIndex].getAttribute('stock');

            if (stock === 'false') {
                alert('يجب اختيار الوحدة');
                event.target.value = 0;
            }
            if(select.value==""){
                alert('عفوآ...يجب اختيار المخزن اولآ');
                event.target.value = '';
                event.preventDefault();
            }else{
                if (Number(quantity) > Number(stock)) {
                    alert('الكمية المتاحة في المخزن لا تكفي');
                    event.target.value = '';
                    event.preventDefault();
                }
            }    

        }
     });
    
       $(document).on('change', '#model_id', function() {
            var finalProductId = $(this).find(':selected').data('final-product-id');
            $('#final_product_id').val(finalProductId);
        });

});
    
    
        function final_product_test(o) {
    var items = document.getElementsByClassName('item_id');
        var units = document.getElementsByClassName('unit_id');
        var storeId = document.getElementsByClassName('store_id');
        var selectedValues = [];

          for (var i = 0; i < items.length; i++) {
              var itemValue = items[i].value;
              var unitValue = units[i].value;
              var storeIdValue = storeId[i].value;
              var combinedValue = itemValue + '-' + unitValue+ '-' + storeIdValue;

              if (selectedValues.includes(combinedValue)) {
                  var empTab = document.getElementById('empTable');
                  empTab.deleteRow(empTab.rows.length - 1);
                  alert('عفوآ...اسم الصنف و الوحده و المخزن تم اختيارهم بالفعل...سوف يتم حذف اخر سطر');
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
    