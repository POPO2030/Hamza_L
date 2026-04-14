<!-- BEGIN Scroll To Top -->
<div class="scrolltop">
    <button class="btn btn-primary btn-icon btn-lg">
        <i class="fa fa-angle-up"></i>
    </button>
</div>
<!-- END Scroll To Top -->
@php
$locale = \Illuminate\Support\Facades\App::isLocale('en')?'ar':'en';
@endphp
<!-- BEGIN Float Button -->
<div class="float-btn float-btn-{{$locale == 'ar'?'right':'left'}} side-min-icons">
    @can('scan-barcode')
    <a href="{{route('scan.barcode')}}" class="btn btn-flat-primary  btn-icon btn-sm "  data-toggle="tooltip" data-placement="{{$locale == 'ar'?'right':'left'}}" title="{{__('Scan Barcode')}}">
        <i class="fas fa-barcode"></i>
    </a>
    @endcan
    @can('scan-order')
    <a href="{{route('scan.qrcode.index')}}" class="btn btn-flat-secondary mt-3 btn-icon btn-sm"  data-toggle="tooltip" data-placement="{{$locale == 'ar'?'right':'left'}}" title="{{__('Scan Qrcode')}}">
        <i class="fas fa-qrcode"></i>
    </a>
        @endcan
</div>

<!-- END Float Button -->
