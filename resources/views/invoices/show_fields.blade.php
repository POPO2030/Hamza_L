
<style>
    table, th, td {
    border: 1px solid;
    weight: 90%
    }
</style>
<div id="printed_area">
    <!-- Header -->
    <div class="header-box">بيان اسعار</div>
    
    <!-- Customer Info - Single Row Layout -->
<div class="info-row">
    <div class="info-item">
        <div class="info-label">العميل:</div>
        <div class="header-box">
            {{ $invoice->get_customer->name }}
        </div>
    </div>
    <div class="info-item">
        <div class="info-label">اذن رقم:</div>
        <div class="header-box">
            {{ $invoice->id }}
        </div>
    </div>
    <div class="info-item">
        <div class="info-label">التاريخ:</div>
        <div class="header-box">
            {{ $invoice->date->format('Y-m-d') }}
        </div>
    </div>
</div>
        @php
        $minus_Increase = $invoice->amount_minus + $invoice->amount_Increase;
        @endphp
        

        <div class="col-sm-12" style="margin-top:10px; ">
        <table id="table_print" style="width: 100%">
            <thead>
                <tr style="background-color: #e0e4e7;text-align: center;font-weight: bold;">
                    <th>م</th>
                    <th>اذن التسليم</th>
                    <th>اذن الاضافة</th>
                    <th>الموديل</th>
                    <th>جهة التسليم</th>

                    <th>نوع الغسيل</th>
                    <th>الوزن/ العدد</th>
                    
                {{-- @if ($minus_Increase == 0 ) اخفاء القيمه عند وجود خصم او زيادهعلي سعر الفاتوره    --}}
                        <th>سعر الغسيل</th>
                        <th>قيمة الغسيل</th>
                {{-- @endif --}}

                    <th>نوع الفاشون</th>
                    <th>عدد القطع</th>

                {{-- @if ($minus_Increase == 0 ) اخفاء القيمه عند وجود خصم او زيادهعلي سعر الفاتوره    --}}
                    <th>سعر الفاشون</th>
                    <th>قيمة الفاشون</th>
                {{-- @endif --}}

                </tr>
            </thead>
            <tbody >
                @php
                    $total_kilos=0;   $total_price_kilos=0;  $total_quantities=0;   $total_price_units=0;  $total_price_piece_price=0;
                @endphp
                @foreach ($invoice_details as $items)
                    @php
                        $total_kilos+=$items->total_kg;
                        $total_quantities+=$items->total_qty;
                    @endphp
                    @php
                        // Filter services by type using the relationship
                        $wash_services = $items->get_invoice_services->where('service_id', 1);
                        $fashion_services = $items->get_invoice_services->where('service_id', 2);

                        $price_wash=0;   $wash_names=[];
                        foreach ($wash_services as $wash){
                            $price_wash+=$wash->service_price;
                            $wash_names[]=$wash->get_service_item->name;
                        }
                    @endphp

                    @php
                        $price_fashion=0;   $fashion_names=[]; 
                        foreach ($fashion_services as $fashion){
                            $price_fashion+=$fashion->service_price;
                            $fashion_names[]=$fashion->get_service_item->name;
                        }
                    @endphp
                    @php
                    $total_price_kilos+=$price_wash * $items->total_kg; 
                    $total_price_units+=$price_fashion * $items->total_qty; 
                    $total_price_piece_price+=$items->piece_price * $items->total_qty;
                    @endphp
                <tr>
                    <td style="text-align: center;"> {{ $loop->iteration }} </td>
                    <td style="text-align: center;"> {{ $items->final_deliver_order_id }}</td>

                    <td style="text-align: center;">{{ $items->get_work_order->receive_receipt_id }}</td>
                    <td style="text-align: center;"> {{ $items->get_work_order->get_products->name }} {{ $items->get_work_order->get_ReceiveReceipt->product_type ? ' (' . $items->get_work_order->get_ReceiveReceipt->product_type . ')' : '' }} {{ $items->get_work_order->get_ReceiveReceipt->model ? ' (' . $items->get_work_order->get_ReceiveReceipt->model . ')' : '' }} </td>
                    <td style="text-align: center;"> {{ $items->get_work_order->get_receivables->name }}  </td>
                    <td style="text-align: center;">
                        @foreach ($wash_names as $names)
                        <span class="badge badge-secondary border border-lightgray"> {{ $names }} </span>
                        @endforeach
                    </td>
                    @if ($invoice->calculation_method == "kilo")
                        <td style="text-align: center;"> {{ $items->total_kg }} </td>
                    @else
                        <td style="text-align: center;"> {{ $items->total_qty }} </td>
                    @endif

                {{-- @if ($minus_Increase == 0 ) اخفاء القيمه عند وجود خصم او زياده علي سعر الفاتوره  --}}

                    @if ($invoice->calculation_method == "kilo")
                        <td style="text-align: center;"> {{ $price_wash }} </td>
                    @else
                        <td style="text-align: center;"> {{ $items->piece_price }} </td>
                    @endif

                    @if ($invoice->calculation_method == "kilo")
                        <td style="text-align: center;"> {{ $price_wash * $items->total_kg }}</td>
                    @else
                        <td style="text-align: center;"> {{ $items->piece_price * $items->total_qty }}</td>
                    @endif

                {{-- @endif --}}



                    <td style="text-align: center;">
                        @foreach ($fashion_names as $name)
                        <span class="badge badge-info border border-info"> {{ $name }} </span>
                        @endforeach
                    </td>

                    <td style="text-align: center;">{{ $items->total_qty }}</td>

                {{-- @if ($minus_Increase == 0 )اخفاء القيمه عند وجود خصم او زياده علي سعر الفاتوره  --}}
                    @if ($invoice->calculation_method == "kilo")
                        <td style="text-align: center;"> {{ $price_fashion }}</td>
                    @else
                        <td style="text-align: center;"> 0 </td>
                    @endif    

                    @if ($invoice->calculation_method == "kilo")
                        <td style="text-align: center;">{{ $price_fashion * $items->total_qty }}</td>
                    @else
                        <td style="text-align: center;"> 0 </td>
                    @endif
                {{-- @endif --}}
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr style="background-color: #e0e4e7;text-align: center;font-weight: bold;">
                    <th colspan="6">الاجمالى</th>

                    @if ($invoice->calculation_method == "kilo")
                        <th>{{ $total_kilos }}</th>
                    @else
                        <th>{{ $total_quantities }}</th>   
                    @endif
                
                <th>--</th>
                    
            {{-- @if ($minus_Increase == 0 ) اخفاء القيمه عند وجود خصم او زياده علي سعر الفاتوره  --}}
                    @if ($invoice->calculation_method == "kilo")
                        <th>{{ $total_price_kilos }}</th>
                    @else
                        <th>{{ $total_price_piece_price }}</th>
                    @endif
                <th>--</th>
                {{-- @endif --}}
                    
                    <th>{{ $total_quantities }}</th>

            {{-- @if ($minus_Increase == 0 ) اخفاء القيمه عند وجود خصم او زياده علي سعر الفاتوره  --}}
                    <th>--</th>
            {{-- @endif --}}

            {{-- @if ($minus_Increase == 0 ) اخفاء القيمه عند وجود خصم او زياده علي سعر الفاتوره  --}}

                    @if ($invoice->calculation_method == "kilo")
                        <th>{{ $total_price_units }}</th>
                    @else
                    <th>0</th>
                    @endif
            {{-- @endif --}}

                </tr>
            </thead>
        </table>
        </div> 

    <!-- Amounts Section -->
    <div style="margin-top: 10px;">
        <div class="info-row">
            
            <div class="info-item2">
                @if ($invoice->amount_minus > 0 || $invoice->tax > 0 || $invoice->discount_notice > 0)
                <div class="info-label">اجمالى الفاتورة:</div>
                <div class="header-box">
                    {{ $invoice->amount_original }} جنية
                </div>
                   @endif
            </div>
         
         
            <div class="info-item2">
                   @if ($invoice->amount_minus > 0)
               <div class="info-label">مبلغ الخصم:</div>    
                <div class="header-box">
                    {{ $invoice->amount_minus }} جنية
                </div>
                 @endif
            </div>
           
           
            <div class="info-item2">
                 @if ($invoice->tax > 0)
                <div class="info-label">الضريبة 14%:</div>
                <div class="header-box">
                    {{ $invoice->tax }} جنية
                </div>
                    @endif
            </div>
        
            
            <div class="info-item2">
                @if ($invoice->discount_notice > 0)
                <div class="info-label">اشعار 3%:</div>
                <div class="header-box">
                    {{ $invoice->discount_notice }} جنية
                </div>
                @endif
            </div>
            
            <div class="info-item2">
                <div class="info-label">الاجمالى:</div>
                <div class="header-box">
                    {{ $invoice->amount_net }} جنية
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Note -->
    <div class="header-box" style="margin-top: 10px; font-size: 9pt;font-weight: bold;">
        فى حال وجود اى ملاحظات  على البيان اعلاه برجاء ابلاغنا خلال يومين على الاكثر
    </div>

    <!-- Signature -->
    <div style="text-align: left; margin-top: 15px; ">
        <div style="display: inline-block;text-align: center;font-weight: bold; margin-left: 22px;">
            توقيع المستلم
        </div>
        <div class="signature" style="text-align: left; margin-top: 5px;">
            <p  style="color: #504f4f !important;font-weight: bold; text-align:center !important;float: left; margin-left: 22px;">
                -------------
            </p>
        </div>
    </div>
   
</div>

