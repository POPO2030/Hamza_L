
<style>@page { size: A5 landscape;}
</style>
<style>
  #table_print, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    font-size: 24px;
    color:#000;
    font-weight: bold;
  }

  @media print {
    .header, .footer, .mb-2 {
      display: none;
    }

    #hide_tr {
      display: none;
    }

    #table_print {
      width: 794px;
      height: 400px;
      font-size: 24px;
    }

    #table_print th,
    #table_print td {
      border: 1px solid #000;
      padding: 5px;
    }

    #noteprint {
      text-align: center;
      justify-content: center;
      word-wrap: normal;
      float: right;
    }
  }
</style>

<table id="table_print" dir="ltr" style="width: 794px; height: 400px; text-align: center; border-collapse: collapse;">

  <tr height="40">
    <th colspan="3" style="border: 1px solid #000; justify-content:space-between; padding: 5px; font-size: 26px;">
      <div style="display: flex; align-items: center; padding: 5px;">
        <div class="col-6 font-weight-bold" style="float: left;">
          العميل: {{ $returnReceipt->get_customer->name }} 
        </div>
        <div class="col-6 font-weight-bold fs-4 mr-3" style="float: right;">
           اذن اضافة مرتجع: {{ $returnReceipt->id }}  
        </div>
      </div> 
    </th>
  </tr>
  <tr height="40">
    <th style="border: 1px solid #000; padding: 5px;">{{ $returnReceipt->get_product->name }}</th> 
    <th colspan="2" style="border: 1px solid #000; padding: 5px;"><span lang="en-us">{{ $returnReceipt->model }} : الموديل</span></th>
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
      <span >{{ $returnReceipt->initial_count }}</span>
      <span > قطعة </span>
    </td>
 
    <td colspan="1" style="border: 1px solid #000; padding: 5px;">
      <span>:الماركه</span>
      <br>
      <span>{{ $returnReceipt->brand }}</span>
      
    </td> 
  </tr>
  
  <tr>
    <td style="border: 1px solid #000; padding: 5px;">تسليم: {{ $returnReceipt->get_receivables->name }}</td>
    <td style="border: 1px solid #000; padding: 5px;">تاريخ الانشاء: {{ $returnReceipt->created_at->format('Y-m-d') }}</td>
  </tr>
  <tr>
    <td colspan="3" style="border: 1px solid #000; padding: 5px;" id="note">
      <div id="noteprint" style="word-wrap: break-word;width:530px; text-align: center; justify-content: left; align-items: center;">
      الملاحظات: {{ $returnReceipt->note }}</td>
      </div>
  </tr>
</table>



<div class="col-sm-8 font-weight-bold" style="font-size: 12px; color: #000; text-underline-offset: 8px;">
  <span>* الكميات الموضحة اعلاه قابله للزيادة والنقصان سيتم التاكيد عليها عند اتمام الغسلة</span>
</div> 
