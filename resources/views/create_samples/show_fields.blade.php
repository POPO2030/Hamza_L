
@if ($serviceItemsArray != Null)
  
        <div class="form-group col-sm-6">
        {!! Form::label('service_item_id', 'الخدمات:') !!}
        @foreach ($serviceItemsArray as $service)
        <span class="badge badge-info">{{ $service['name'] }}</span>
        @endforeach
        {{-- {!! Form::text('service_item_id[]', $createSample[0]->get_service_item->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!} --}}
        </div>
 

    <form action="{{ URL('update_service_item/'. $id) }}" method="post" id="form1">
        @csrf
    <div class="form-group col-sm-6">
        {!! Form::label('service_item_id', 'اسم الخدمة:') !!}
        <div id="service_item_id1-container">
            
            <select name="service_item_id[]" id="service_item_id1" class="form-control searchable"  data-placeholder="اختر اسم الخدمة" placeholder="اختر اسم الخدمة" multiple="multiple">
                @foreach ($services as $service)
                    {{-- @if ($createSample[0]['service_item_id'] == $service->id) --}}
                    {{-- <option value="" disabled selected>اختر اسم الخدمة</option> --}}
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                    {{-- @else --}}
                    {{-- <option value="{{ $service->id }}">{{ $service->name }}</option> --}}
                    {{-- @endif --}}
                @endforeach
            </select>
        </div>
        @error('service_item_id1')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <span id="service_item_id1-error" class="error-message" style="color: red"></span>
    </div>
    
    {!! Form::submit('حفظ', ['class' => 'btn btn-primary save1', 'onclick' => "return confirm('هل تريد تغير اسم الخدمة؟')"]) !!}
    </form>

@else

<form action="{{ URL('update_sample/'. $id) }}" method="post" id="create">
    @csrf
<div class="form-group col-sm-6">
        {!! Form::label('service_item_id', ' اسم الخدمة: <span style="color: red">*</span>', [], false) !!}
        {{-- {{ Form::select('service_item_id', $services, null, ['class' => 'form-control searchable','id'=>'service_item_id', 'data-placeholder' => 'اختر  اسم الخدمة', 'style' => 'width: 100%'],['option'=>'services']) }} --}}
        
        <div id="service_item_id-container">
            
            <select name="service_item_id[]" id="service_item_id" class="form-control searchable"  data-placeholder="اختر اسم الخدمة" placeholder="اختر اسم الخدمة" multiple="multiple">
                @foreach ($services as $service)
                {{-- @if ($createSample[0]['service_item_id'] == null) --}}
                    {{-- <option value="" disabled selected>اختر اسم الخدمة</option> --}}
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                {{-- @endif     --}}
                @endforeach
            </select>

        </div>
        @error('service_item_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <span id="service_item_id-error" class="error-message" style="color: red"></span>
       
</div>

{!! Form::submit('حفظ', ['class' => 'btn btn-primary save']) !!}
</form>
 {{-- {!! Form::close() !!} --}}
 @endif
<br>

<?php $unique_stage=[]; $unique_fashion=[]; $unique_wash=[]; $current_stage = null; ?>

<div id="table-holder">
  @foreach ($createSample as $sample)
      @if ($sample['flag'] == 1)
          @if ($current_stage !== $sample['stage_id'])
              @if ($current_stage !== null)
                  </table> <!-- Close the previous table -->
                  </div> <!-- Close the previous div_style -->
              @endif
              <div class="div_style">
                  <div>
                    {!! Form::label('stage_id[]', 'اسم المرحلة:') !!}
  
                          @foreach ($stages as $stage)
                              @if ($sample['stage_id'] == $stage->id)
                              {{ $stage->name }}
                              @endif
                          @endforeach
        
                  </div>
                  @php
                  $current_stage = $sample['stage_id'];
                  @endphp
                  <table class="table table-boder">
                  <tr>
                      <td>المواد الكميائية</td>
                      <td>النسبة / لتر</td>
                      <td>الحرارة / الباور</td>
                      <td>ماء</td>
                      <td>زمن</td>
                      <td>ph</td>
                  </tr>
              @endif
              <tr>
                  <td>
                          @foreach ($products as $product)
                              @if ($sample['product_id'] == $product->id)
                                {{ $product->name }}
                              @endif
                          @endforeach
                  </td>
                  <td>{{ $sample['ratio'] }}</td>
                  <td>{{ $sample['degree'] }}</td>
                  <td>{{ $sample['water'] }}</td>
                  <td>{{ $sample['time'] }}</td>
                  <td>{{ $sample['ph'] }}</td>
              </tr>
              @else

    
              @if ($current_stage !== $sample['stage_id'])
              @if ($current_stage !== null)
                  </table>
                  </div> <!-- Close the previous div_style -->
              @endif
              <div class="div_style">
              <div>
  
                {!! Form::label('stage_id[]', 'اسم المرحلة:') !!}
                  @foreach ($fashion_stages as $stage)
                      @if ($sample['stage_id'] == $stage->id)
                      {{ $stage->name }}
                      @endif
                  @endforeach
              </select>

          </div>
          @php
          $current_stage = $sample['stage_id'];
          @endphp
     
              <table class="table table-boder">
  
              
                  <tr>
                      <td>المواد الكميائية</td>
                      <td>النسبة / لتر</td>
                      <td>الدقة / التركيز</td>
                      <td>الباور</td>
                      <td>زمن	</td>
                      <td>ملاحظات</td>
                    
                  </tr>
                  @endif
             
                  <tr>
                      <td>
                          @foreach ($products as $product)
                              @if ($sample['product_id'] == $product->id)
                              {{ $product->name }}
                              @endif
                          @endforeach
                      </td>
                      <td>{{ $sample['ratio'] }}</td>
                      <td>{{ $sample['resolution'] }}</td>
                      <td>{{ $sample['power'] }}</td>
                      <td>{{ $sample['time'] }}</td>
                      <td>{{ $sample['note'] }}</td>
                      
                  </tr>
          

          @endif
      @endforeach
      </table> <!-- Close the last table -->
  </div> <!-- Close the last div_style -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var storesName = document.getElementById('service_item_id').value;
 
    var isValid = true;

    if (storesName === '') {
      document.getElementById('service_item_id-error').innerHTML = 'يرجى اختيار اسم الخدمة اولا';
      document.getElementById('service_item_id-container').style.border = '1px solid';
      document.getElementById('service_item_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('service_item_id-error').innerHTML = '';
      document.getElementById('service_item_id-container').style.border = 'none';
      document.getElementById('service_item_id-container').style.borderColor = 'none';
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
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('form1').addEventListener('submit', function(event) {
    event.preventDefault();

    var servicename1 = document.getElementById('service_item_id1').value;
 
    var isValid1 = true;

    if (servicename1 === '') {
      document.getElementById('service_item_id1-error').innerHTML = 'يرجى اختيار اسم الخدمة اولا';
      document.getElementById('service_item_id1-container').style.border = '1px solid';
      document.getElementById('service_item_id1-container').style.borderColor = 'red';
      isValid1 = false;
    } else {
      document.getElementById('service_item_id1-error').innerHTML = '';
      document.getElementById('service_item_id1-container').style.border = 'none';
      document.getElementById('service_item_id1-container').style.borderColor = 'none';
    }


    if (isValid1) {
      var submitButton1 = this.querySelector('input[type=submit]');
      submitButton1.disabled = true;
      this.submit();
    }
  });

  document.addEventListener('keyup', function(e) {
    if (e.key === 'F2' && document.getElementById('form1').checkValidity()) {
      document.querySelector('.save1').click();
    }
  });

});


</script>