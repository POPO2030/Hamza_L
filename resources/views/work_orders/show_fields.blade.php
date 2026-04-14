<br>
<!-- ======================================= -->
<!-- The Modal -->
<style>
  /* Custom style for the image cards */
  .custom-card {
    width: 90%;
    margin: 0 5%; 
  }

  /* Custom style for the modal dialog */
  .custom-modal-dialog {
    top: -26%;
    transform: translateY(-50%);
  }

  .image-hover {
    cursor: pointer;
    transition: transform 0.3s ease;
  }

  .image-hover:hover {
    transform: scale(1.2); 
  }
  .modal-header{
    background-color: #9c27b0;
    color: antiquewhite;
  }
    /* Responsive styles */
    @media (max-width: 768px) {
    .custom-modal-dialog {
      top: 20%;
    }
    .custom-card {
      width: 100%;
      margin: 0;
    }
  }
</style>
<!-- The Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg custom-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">صورة الموديل</h4>
        <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:#17a2b8;font-size:18px;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(!empty($temp))
          <div class="d-flex justify-content-around">
            @foreach($temp as $image)
              <div class="custom-card" style="text-align: center;">
                <div class="card-container">
                  <img src="{{ URL($image) }}" alt="Image" class="card-image image-hover" style="display: inline-block; margin-bottom: 10px; width: 100%; height: 300px; object-fit: fill;">
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
  <!-- ======================================= -->
  
  <table id="datatable" class="table table-bordered">
    <thead>
      <tr>
        
        <th>رقم الغسلة</th>
        <th>اذن اضافة</th>
        <th>الموديل</th>
        <th>العميل</th>
        <th>الصنف</th>
        <th>عدد</th>
        <th>الوزن</th>
        <th>لون الخيط</th>
        @if (isset($workOrder->get_fabric))
        <th>الخامة</th>
        @endif
        @if (isset($workOrder->get_fabric_source))
        <th>مصدر القماش</th>
        @endif
        <th>المستلم</th>
        <th>الحاله</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <!-- Status with Badge -->
        <td>{{ $workOrder->id }}</td>
        <td>{{ $workOrder->receive_receipt_id }}</td>
        <td>{{ $workOrder->get_ReceiveReceipt->model }}</td>
        <td>{{ $workOrder->get_customer->name }}</td>
        <td>{{ $workOrder->get_products->name . (optional($workOrder->get_ReceiveReceipt)->product_type ? ' (' . optional($workOrder->get_ReceiveReceipt)->product_type . ')' : '') }}</td>
        <td>{{ $workOrder->product_count }}</td>
        <td>{{ $workOrder->product_weight }}</td>
        <td>{{ $workOrder->color_thread }}</td>
  
        @if (isset($workOrder->get_fabric))
        <td>{{ $workOrder->get_fabric->name }}</td>
        @endif
  
        @if (isset($workOrder->get_fabric_source))
        <td>{{ $workOrder->get_fabric_source->name }}</td>
        @endif
  
        <td>{{ $workOrder->get_receivables->name }}</td>
        <td>
          @if($workOrder->status == 'open')
          <span class="badge badge-warning">قيد التنفيذ</span>
          @else
          <span class="badge badge-success">تم التنفيذ</span>
          @endif
        </td>
      </tr>
    </tbody>
  </table>

<br>
<table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
style="text-align: center" >
<thead>
<tr>
<th style="text-align: center;background-color: #00bcd4;color: #ffffff;width: 30%;">    الخدمات </th>
<th style="text-align: center;background-color: #00bcd4;color: #ffffff;width: 70%;">  ملاحظات </th>

</tr>
</thead>
<tbody>
 <tr>
   
   <td style="font-weight: bold;text-align: center">

    @php $names=[] @endphp
    @foreach($work_order_stages as $work_order_stage)
        @foreach($work_order_stage->get_work_order_service as $service)
        @php 
        if(in_array($service->name,$names)){
          continue;
        };
        array_push($names,$service->name) ;
        @endphp
          <p>{{$service->name}}</p>
        @endforeach
      @endforeach

    </td>
   <td style="font-weight: bold;text-align: center">@foreach($notes as $note)
    
      <p style="text-align: center">{{$note->get_user->name}} - {{$note->get_team->name}} - {{$note->created_at}}
        <br>
        {{$note->note}}
        <br>
        -----------
      </p>
    
  @endforeach</td>
 </tr>
</tbody>
</table>

<table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
style="text-align: center">
<thead>
<tr>
<th style="text-align: center;background-color: #00bcd4;color: #ffffff;width: 30%;">    مراحل الانتاج </th>
{{-- <th style="text-align: center;background-color: #404040;color: #ffffff;width: 70%;">   متابعه الانتاج</th> --}}

</tr>
</thead>
<tbody>
  <tr>
    <td >
      {{-- <div class="row"> --}}
        @foreach($work_order_stages as $work_order_stage)
          @if($work_order_stage->status == 'open')
            @foreach($work_order_stage->get_work_order_stage as $stage)
            <span class="badge badge-pill badge-danger">{{$stage->name}}</span> 

            @endforeach
          @else
            @foreach($work_order_stage->get_work_order_stage as $stage)
            <span class="badge badge-pill badge-success">  {{$stage->name}}</span> 
            @endforeach
          @endif
        @endforeach
      {{-- </div> --}}
    </td>
  </tr>
  <th style="text-align: center;background-color: #00bcd4;color: #ffffff;width: 70%;">   متابعه الانتاج</th>
 <tr>


   <td>

    <div class="card card-timeline card-plain">
      <div class="card-body">
        <ul class="timeline" style="margin-top:-3rem !important;">

          @foreach($follows as $follow)
            @if($follow->status == 'open')
              <li >
                <div class="timeline-badge danger">
                  <i class="material-icons">card_travel</i>
                </div>
                <div class="timeline-panel">
                  <div class="timeline-heading">
                    <span class="badge badge-pill badge-danger">{{$follow->get_owner->name}}</span>
                  </div>
                  <div class="timeline-body">
                    قيد التنفيذ بواسطة :
                    &nbsp; &nbsp;({{$follow->get_user->name}} - {{$follow->get_team->name}} ) 

                    @can('delete_activity')
                    @if ($follow->owner_stage_id != 48)
                    <a  href="{{ route('delete_activity', [$follow->id, $follow->owner_stage_id, $follow->work_order_id]) }}" onclick="return confirm('هل ترغب فى حذف المرحلة');"><i class="fas fa-trash-alt fa-lg" style="color:red; float: left; padding-top: 8px;"></i></a>
                    @endif

                    @endcan
                  
                    @can('close_activity')
                    @if ($follow->owner_stage_id != 48)
                    <a  href="{{ route('close_activity', [$follow->id, $follow->owner_stage_id, $follow->work_order_id]) }}" onclick="return confirm('هل ترغب فى اغلاق  الطلب');">  &nbsp;  <i class="fas fa-times-circle fa-lg" style="color: green; float: left; padding-left: 10px; padding-top: 8px;"></i></a>
                    @endif
                    @endcan
                  </div>
                  <h6>
                    <i class="ti-time"></i> {{$follow->created_at}}
                  </h6>
                </div>
              </li>
            @else

          <li class="timeline-inverted">
            <div class="timeline-badge success">
              <i class="material-icons">extension</i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <span class="badge badge-pill badge-success">{{$follow->get_owner->name}}</span>
              </div>
              @if ($follow->get_user_closed && $follow->owner_stage_id == 48 )

                <div class="timeline-body">
                   تم التنفيذ بواسطة :
                    &nbsp; &nbsp; ({{$follow->get_user_closed->name}} - {{$follow->get_team_closed->name}} ) 

                    @can('delete_activity')
                    @if ($follow->owner_stage_id != 48)
                    <a  href="{{ route('delete_activity', [$follow->id, $follow->owner_stage_id, $follow->work_order_id]) }}" onclick="return confirm('هل ترغب فى حذف المرحلة');"><i class="fas fa-trash-alt fa-lg" style="color:red; float: left; padding-top: 8px;"></i></a>
                    
                    @endif
                    @endcan
                </div>
                <h6>
                  <i class="ti-time"></i> {{$follow->created_at}}
                </h6>
                @else
                  <div class="timeline-body">
                    تم التنفيذ بواسطة :
                      &nbsp; &nbsp; ({{$follow->get_user_closed->name}} - {{$follow->get_team_closed->name}} ) 

                      @can('delete_activity')
                      @if ($follow->owner_stage_id != 48)
                      <a  href="{{ route('delete_activity', [$follow->id, $follow->owner_stage_id, $follow->work_order_id]) }}" onclick="return confirm('هل ترغب فى حذف المرحلة');"><i class="fas fa-trash-alt fa-lg" style="color:red; float: left; padding-top: 8px;"></i></a>
                      
                      @endif
                      @endcan
                  </div>
                  <h6>
                    <i class="ti-time"></i> {{$follow->created_at}}
                  </h6>
                @endif   
              
              
            </div>
          </li>
         
          @endif
    @endforeach
        </ul>
      </div>
    </div>
    
    </td>
 </tr>
</tbody>
</table>


<!-- ======================================= -->
<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ارسال الى قسم</h5>
      </div>
      <form action="{{URL('add_activity')}}" method="post">
      <div class="modal-body">
            @csrf
            <input type="hidden" name="work_order_id" class="form-control" value="{{$workOrder->id}}">
            <select name="owner_stage_id" class="form-control searchable" style="width:100%">
            @foreach($stages as $stage)
            @if($stage->id==48 || $stage->id==52 || $stage->id==53)
            <?php continue ?>
            @endif
            <option value="{{$stage->id}}">{{$stage->name}}</option>
            @endforeach
            </select>
      </div>
      <div class="modal-footer" style="direction: ltr;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
      </form>
    </div>
  </div>
  </div>


  <!-- Modal -->
  
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اضافة ملحوظة</h5>
      </div>
      <form action="{{URL('add_not')}}" method="post">
      <div class="modal-body">
      @csrf
            <input type="hidden" name="work_order_id" class="form-control" value="{{$workOrder->id}}">
            <textarea name="note" class="form-control" cols="30" rows="10"></textarea>
        
      </div>
      <div class="modal-footer" style="direction: ltr;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>
      </form>
    </div>
  </div>
  </div>
