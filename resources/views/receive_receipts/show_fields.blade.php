
<table id="table_print" dir="ltr" style="width: 794px; height: 400px; text-align: center; border-collapse: collapse;">

  <tr height="40">
    <th colspan="3" style="border: 1px solid #000; justify-content:space-between; padding: 5px; font-size: 26px;">
      <div style="display: flex; align-items: center; padding: 5px;">
        <div class="col-4 font-weight-bold" style="float: left;">
          تسليم: {{ $receiveReceipt->get_receivables->name }}
        </div>
        <div class="col-4 font-weight-bold" style="float: left;">
          العميل: {{ $receiveReceipt->get_customer->name }} 
        </div>
        <div class="col-4 font-weight-bold fs-4 mr-3" style="float: right;">
          اذن اضافة: {{ $receiveReceipt->id }}  
        </div>
      </div> 
    </th>
  </tr>
  <tr height="40">
    <th style="border: 1px solid #000; padding: 5px;">{{ $receiveReceipt->get_product->name }} {{ $receiveReceipt->product_type ? ' (' . $receiveReceipt->product_type . ')' : '' }}</th> 
    <th colspan="2" style="border: 1px solid #000; padding: 5px;"><span lang="en-us">{{ $receiveReceipt->model }} : الموديل</span></th>
  </tr>
  <tr id="hide_tr">
    <td rowspan="4" height="250" width="600" style="border: 1px solid #000; padding: 5px; text-align: right;">
      @if(!empty($temp))
        @for($i = 0; $i < count($temp); $i++)
          <img src="{{ URL($temp[$i]) }}" alt="Image" style="display: block; margin-bottom: 10px; width: 100%; height: 100%; object-fit: fill;">
        @endfor
      @endif
    </td>
  </tr>
  <tr>
    <td colspan="1" style="border: 1px solid #000; padding: 5px;"> 
      <span>عدد مبدئي</span>
      <span >{{ $receiveReceipt->initial_count }}</span>
      <span > قطعة </span>
    </td>
 
    <td colspan="1" style="border: 1px solid #000; padding: 5px;">
      <span>:الماركه</span>
      <br>
      <span>{{ $receiveReceipt->brand }}</span>
      
    </td> 
  </tr>
  <tr>
    <td colspan="5" style="border: 1px solid #000; padding: 5px;" id="note">
      <div id="noteprint" style="word-wrap: break-word;width:530px; text-align: center; justify-content: left; align-items: center;">
       @if(!empty($receiveReceipt->note))
        الملاحظات: {{ $receiveReceipt->note }}
       @endif
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="3" style="border: 1px solid #000; padding: 5px;">تاريخ الانشاء: {{ $receiveReceipt->created_at->format('Y-m-d') }}</td>
  </tr>
</table>



<div class="col-sm-8 font-weight-bold text-center" style="font-size: 12px; color: #000; text-underline-offset: 8px;">
  {{-- <span>* الكمية المذكوره بالاذن قابله للزيادة والنقصان سيتم التاكيد عليها عند تفعيل الغسلة</span> --}}
</div> 
