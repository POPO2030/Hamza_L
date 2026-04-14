{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css"> --}}
<style>@page { size: A5 }</style>
<style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
</style>
    
    <table dir="ltr" style="width:100%;text-align: center" >
      <tr>
        <th>{{ $receiveReceipt->get_product->name }} {{ $receiveReceipt->product_type ? ' (' . $receiveReceipt->product_type . ')' : '' }}</th>
        <th><span lang="en-us">{{ $receiveReceipt->brand }}</span></th> 
        <th><span lang="en-us">{{ $receiveReceipt->model }}</span></th>
      </tr>
      <tr>
        <td rowspan="4">
            {{-- <img src="{{ URL($receiveReceipt->img) }}" alt="jacket" width="300" height="150">
            - 
            <img src="{{ URL($receiveReceipt->img) }}" alt="jacket" width="300" height="150">
         --}}
         
@for($i=0 ; $i<count($temp) ; $i++)
{{$temp[$i]}}
@endfor
        </td>
        <td>{{ $receiveReceipt->initial_weight }} </td>
        <td>وزن مبدئى</td>
      </tr>
      <tr>
        <td>{{ $receiveReceipt->initial_count }} قطعه</td>
        <td>عدد مبدئي</td>
      </tr>
      <tr>
        <td>{{ $receiveReceipt->final_weight }} كيلو</td>
        <td>وزن فعلي</td>
      </tr>
      <tr>
        <td>{{ $receiveReceipt->final_count }} قطعه</td>
        <td>عدد فعلي</td>
      </tr>
    </table>
    <table style="width:100%;text-align: center" height="38">
        <tr>
            <td >تاريخ الانشاء : {{ $receiveReceipt->created_at }}</td>
            <td >تاريخ التحديث : {{ $receiveReceipt->updated_at }}</td>
        </tr>
    </table>