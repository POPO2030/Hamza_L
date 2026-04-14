
<!-- Customer Id Field -->
<div class="col-sm-6">
    {!! Form::label('customer_id', 'العميل:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $labSample->get_customer->name }}</span>
</div>

<!-- Product Id Field -->
<div class="col-sm-6">
    {!! Form::label('product_id', 'الصنف:') !!}
    {{-- <p>{{ $labSample->product_id }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $labSample->get_products->name }}</span>
</div>

<!-- Serial Field -->
{{-- <div class="col-sm-12">
    {!! Form::label('serial', 'Serial:') !!}
    <p>{{ $labSample->serial }}</p>
</div> --}}

<!-- Count Field -->
<div class="col-sm-6">
    {!! Form::label('count', 'عدد القطع:') !!}
    {{-- <p>{{ $labSample->count }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $labSample->count }}</span>
</div>

<!-- Status Field -->
<div class="col-sm-6">
    {!! Form::label('status', 'الحالة:') !!}
    {{-- <p>{{ $labSample->status }}</p> --}}
    @if ($labSample->status == 'open')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'داخل العينات المستلمة' }}</span>
    @elseif ($labSample->status == 'pre_checked')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'على تأكيد استلام المعمل' }}</span>
    @elseif ($labSample->status == 'checked')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'فى انتظار تشغيل المعمل' }}</span>
    @elseif ($labSample->status == 'progressing')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'فى التشغيل' }}</span>
    @elseif ($labSample->status == 'pre_finish')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'فى انتظار تأكيد استلام خدمة العملاء' }}</span>
    @elseif ($labSample->status == 'finish')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'داخل مخزن العينات' }}</span>
    @elseif ($labSample->status == 'closed')
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ 'تم التسليم الى العميل' }}</span>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الانشاء:') !!}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $labSample->created_at }}</span>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'تاريخ التعديل:') !!}
    {{-- <p>{{ $labSample->updated_at }}</p> --}}
    <span class="border border-lightgray  rounded text-white p-2 d-block text-center" style="width: 100%;background-color: #e0e4e7 !important; color: #504f4f !important;">{{ $labSample->updated_at }}</span>
</div>


<div class="col-sm-12">
    @if(!empty($temp))
    @for($i = 0; $i < count($temp); $i++)
      <img src="{{ URL($temp[$i]) }}" alt="Image" style="display: block; margin-bottom: 10px; width: 80%; height: 80%; object-fit: fill;">
    @endfor
  @endif
</div>