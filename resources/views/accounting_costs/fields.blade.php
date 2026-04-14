
<div class="form-group col-sm-6">
    {!! Form::label('work_order_id', 'رقم الغسلة: <span style="color: red">*</span>', [], false) !!}
    <div id="work_order_id-container">
      <select name="work_order_id" class="form-control work_order_id searchable" id="work_order_id">
        <option value="" selected>اختر الغسلة</option>
        @foreach($work_order as $model)
          <option value="{{ $model->id }}">{{$model->id}}</option>
        @endforeach
      </select>
    </div>
    @error('work_order_id')
      <div class="text-danger">{{ $message }}</div>
    @enderror
    <span id="work_order_id-error" class="error-message" style="color: red"></span>
  </div>  
<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('notes', 'ملاحظات:') !!}
    {!! Form::text('notes', null, ['class' => 'form-control','id'=>'notes']) !!}
</div>
<!-- total_contract_quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_contract_quantity', 'كمية الغسلة:<span style="color: red">*</span>', [], false) !!}
    {!! Form::text('total_contract_quantity', null, ['class' => 'form-control' . ($errors->has('total_contract_quantity') ? ' is-invalid' : ''),
    'id'=>'total_contract_quantity','onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)' , 'readonly']) !!}
    @if ($errors->has('total_contract_quantity'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('total_contract_quantity') }}</strong>
    </span>
@endif
<span id="total_contract_quantity-error" class="error-message" style="color: red"></span>
</div>



<div class="form-group col-sm-6">
    {!! Form::label('piece_cost', 'تكلفة القطعة:') !!}
    {!! Form::text('piece_cost', null, ['class' => 'form-control', 'id'=>'piece_cost' , 'readonly']) !!}
</div>
{{-- model_price / total_contract_quantity, --}}



{{-- <div class="row" id="adding" style="max-height: calc(80vh - 150px); overflow-y: auto; width: 100%"> --}}
<div class="row" id="adding" style="width: 100%">
    @if(isset($Cloth_request_details))
  <table id="empTable" class="table table-border" style="border: 1.5px solid gray; width: 100%">
      <tr>
          <td class="col-4 text-center" style="padding: 0.75rem;">البيان</td>
          <td class="col-2 text-center" style="padding: 0.75rem;">الوحده</td>
          <td class="col-2 text-center" style="padding: 0.75rem;">الكميه</td>
          <td class="col-4 text-center" style="padding: 0.75rem;">متوسط سعر التكلفة</td>
          <td class="col-4 text-center" style="padding: 0.75rem;">اجمالى</td>
      </tr>
    
      @foreach($Cloth_request_details as $row)

      <tr>
          <td class="col-2 text-center">
          <select name="product_id[]" class="form-control item_id searchable">
            {{-- @foreach($inv_controlStock_data as $product)
                <option value="{{ $product->id }}" 
                    @if($product->id == $row->product_id) selected @endif>
                    {{ $product->get_product->name }}({{ $product->get_color->invcolor_category->name }}-{{ $product->get_color->name }})
                </option>
        @endforeach --}}

        </select>
          
        </td>

          <td class="col-2 text-center">
          <input type="number" value="{{$row->fabric_height}}" name="fabric_height[]" class="form-control fabric_height" >
          </td>
          <td class="col-2 text-center">
          <input type="number" value="{{$row->quantity}}" name="quantity[]" class="form-control quantity" >
          </td>
          <td class="col-4 text-center">
          <input type="text" value="{{$row->piece_consumption}}" name="piece_consumption[]" class="form-control piece_consumption" >
          </td>
          <td class="col-2 text-center">
            <button class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fa fa-trash"></i></button>
        </td>
      </tr>
      
      @endforeach
   
  </table>
  @endif
  <span id="validationMessage" style="color: red;"></span>
</div>

<div class="form-group col-sm-6" id="div_operating_expenses" style="display: none;">
    {!! Form::label('operating_expenses', 'مصاريف تشغيل:<span style="color: red">*</span>', [], false) !!}
    {!! Form::text('operating_expenses', null, ['class' => 'form-control' . ($errors->has('operating_expenses') ? ' is-invalid' : ''),
    'id'=>'operating_expenses']) !!}
    @if ($errors->has('operating_expenses'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('operating_expenses') }}</strong>
    </span>
@endif
<span id="operating_expenses-error" class="error-message" style="color: red"></span>
</div>

<div class="form-group col-sm-6" id="div_model_price" style="display: none;">
    {!! Form::label('model_price', ' اجمالي تكلفة الغسلة:<span style="color: red">*</span>', [], false) !!}
    {!! Form::text('model_price', null, ['class' => 'form-control' . ($errors->has('model_price') ? ' is-invalid' : ''),
    'id'=>'model_price','onkeyup' => 'replaceChars(this)','oninput' => 'replaceChars(this)' , 'readonly']) !!}
    @if ($errors->has('model_price'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('model_price') }}</strong>
    </span>
@endif
<span id="model_price-error" class="error-message" style="color: red"></span>
</div>
{{-- <script src="{{ asset('js/fields_config.js') }}"></script> --}}

<script>
$(document).ready(function() {
    $(document).on('change', '#work_order_id', function() {
        var work_order_id = $('#work_order_id').val();
        $('#div_operating_expenses').show();
        $('#div_model_price').show();

        $('#empTable').empty();
        $.ajax({
            type: 'get',
            url: "{!!URL::to('/get_costs_model_quantity')!!}",
            data: { 'work_order_id': work_order_id },
            success: function(result) {
                console.log(result)
                document.getElementById("total_contract_quantity").value = result.total_contract_quantity;

                // if (result.model_name) {
                //     document.getElementById("total_contract_quantity").value = result.model_name.customer_id;
                //     document.getElementById("customer_name").value = result.model_name.get_customer.name;
                // }

                if (!document.getElementById("empTable")) {
                    create_Table();
                }
                addRow(result.inv_controlStock_data);

                calculateAmounts()
                // updatebaftaIds(result.model_bafta);
            }
        });
    });

    // ===================================================================    بداية حساب تجميع اسعار المنتجات      =============================================================================   
$(document).on('keyup', '#operating_expenses', function(event) {


    calculateAmounts();

});

});

function create_Table() {
    var existingTable = document.getElementById('empTable');

    if (!existingTable) {
        var empTable = document.createElement('table');
        empTable.classList.add('empTable', 'table', 'table-border');
        empTable.setAttribute('style', 'margin-top: 10px; display: inline-table;');
        empTable.setAttribute('id', 'empTable');

        var tr1 = document.createElement('tr');

        var tr1_td1 = document.createElement('td');
        tr1_td1.setAttribute('style', 'padding: 0.75rem;');
        tr1_td1.innerText = 'البيان';
        tr1_td1.classList.add('col-4', 'text-center');
        tr1.appendChild(tr1_td1);

        var tr1_td2 = document.createElement('td');
        tr1_td2.setAttribute('style', 'padding: 0.75rem;');
        tr1_td2.innerText = 'الوحده';
        tr1_td2.classList.add('col-2', 'text-center');
        tr1.appendChild(tr1_td2);

        var tr1_td3 = document.createElement('td');
        tr1_td3.setAttribute('style', 'padding: 0.75rem;');
        tr1_td3.innerText = 'الكميه';
        tr1_td3.classList.add('col-2', 'text-center');
        tr1.appendChild(tr1_td3);

        var tr1_td4 = document.createElement('td');
        tr1_td4.setAttribute('style', 'padding: 0.75rem;');
        tr1_td4.innerText = 'متوسط سعر التكلفة';
        tr1_td4.classList.add('col-2', 'text-center');
        tr1.appendChild(tr1_td4);

        var tr1_td5 = document.createElement('td');
        tr1_td5.setAttribute('style', 'padding: 0.75rem;');
        tr1_td5.innerText = 'اجمالي';
        tr1_td5.classList.add('col-2', 'text-center');
        tr1.appendChild(tr1_td5);


        empTable.appendChild(tr1);

        var addingDiv = document.getElementById('adding');
        addingDiv.appendChild(empTable);
    }
}

// ==========================================اضافه المحتوي للجدول===================================================
function addRow(data) {
    // console.log(data);
    data.forEach(function(item) {
        var row = empTable.insertRow(-1); // Append a new row to the end of the table

        var tr1_td1 = row.insertCell(0);
        var tr1_td2 = row.insertCell(1);
        var tr1_td3 = row.insertCell(2);
        var tr1_td4 = row.insertCell(3);
        var tr1_td5 = row.insertCell(4);

        tr1_td1.setAttribute('style', 'padding: 0.75rem;');
        tr1_td1.classList.add('text-center');
        tr1_td1.innerText = item.get_product_color.get_product.name;
        input1 = document.createElement('input');
        input1.setAttribute('type', 'hidden');
        input1.setAttribute('name', 'product_id[]');
        input1.value = item.product_id;
        tr1_td1.appendChild(input1);

        tr1_td2.setAttribute('style', 'padding: 0.75rem;');
        tr1_td2.classList.add('text-center');
        tr1_td2.innerText = item.get_unit.name;
        input2 = document.createElement('input');
        input2.setAttribute('type', 'hidden');
        input2.setAttribute('name', 'unit_id[]');
        input2.value = item.unit_id;
        tr1_td2.appendChild(input2);

        tr1_td3.setAttribute('style', 'padding: 0.75rem;');
        tr1_td3.classList.add('text-center');
        input3 = document.createElement('input');
        input3.setAttribute('type', 'text');
        input3.setAttribute('name', 'product_quantity[]');
        input3.setAttribute('readonly', 'readonly');
        input3.classList.add('form-control','product_quantity','text-center');
        input3.value = item.quantity_out;
        tr1_td3.appendChild(input3);

        tr1_td4.setAttribute('style', 'padding: 0.75rem;');
        tr1_td4.classList.add('text-center');
        input4 = document.createElement('input');
        input4.setAttribute('type', 'text');
        input4.setAttribute('name', 'average_cost[]');
        input4.setAttribute('readonly', 'readonly');
        input4.classList.add('form-control','average_cost','text-center');
        input4.value = item.average_cost.toFixed(2);
        tr1_td4.appendChild(input4);

 // Calculate total cost
        var total_cost = parseFloat(item.quantity_out) * parseFloat(item.average_cost);
        tr1_td5.setAttribute('style', 'padding: 0.75rem;');
        tr1_td5.classList.add('text-center');

        var totalInput = document.createElement('input');
        totalInput.setAttribute('type', 'text');
        totalInput.setAttribute('readonly', 'readonly');
        totalInput.setAttribute('name', 'total_cost[]');
        totalInput.classList.add('form-control', 'text-center', 'total_cost');
        totalInput.value = total_cost.toFixed(2);

        tr1_td5.appendChild(totalInput);
    });  
}

function removeRow(oButton) {
    var empTable = document.getElementById('empTable');
    empTable.deleteRow(oButton.parentNode.parentNode.rowIndex); 
}


function calculateAmounts() {
    // Retrieve necessary elements
    var total_cost = document.getElementsByClassName("total_cost");
    var operating_expenses = parseFloat(document.getElementById('operating_expenses').value) || 0; // Default to 0 if invalid
    var total_contract_quantity = parseFloat(document.getElementById('total_contract_quantity').value) || 0;
    var model_price = 0;

    // Calculate total cost
    for (let index = 0; index < total_cost.length; index++) {
        let cost = parseFloat(total_cost[index].value) || 0; // Default to 0 if invalid
        model_price += cost;
    }

    // Add operating expenses
    var grandtotal = model_price + operating_expenses;

    // Update model_price input
    if (!isNaN(grandtotal)) {
        $("#model_price").val(grandtotal.toFixed(2)); // Format to 2 decimal places
    } else {
        $("#model_price").val('');
    }

    // Calculate piece cost
    var piece_cost = 0;
    if (total_contract_quantity > 0) {
        piece_cost = grandtotal / total_contract_quantity;
    }

    // Update piece_cost input
    if (!isNaN(piece_cost)) {
        $("#piece_cost").val(piece_cost.toFixed(2)); // Format to 2 decimal places
    } else {
        $("#piece_cost").val('');
    }
}

// Event listener for `operating_expenses`
$(document).on('keyup', '#operating_expenses', function(event) {
    calculateAmounts();
});
</script>