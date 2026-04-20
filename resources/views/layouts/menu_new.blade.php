<?php function cuurentroute($route, $action)
{
    if (\Request::route()->getName() == $route) echo $action;
} ?>
<style>
  li {
    direction: rtl;
}
</style>
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="{{asset('assets/img/sidebar-1.jpg') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">

        <a href="{{ route('home') }}" class="simple-text logo-normal">
          <img src="{{asset('assets/img/faces/lundry.png') }}" style="width: 120px;">
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="{{asset('assets/img/faces/avatar-person.jpg') }}">
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <b class="caret"></b>
              <span>
                {{auth()->user()->name}}
                
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">

                <li class="nav-item">
                  {{-- <a href="{{ route('users.edit', ['id' => auth()->user()->id]) }}" class="dropdown-item">
                    <span class="grid-nav-content">{{__('الملف الشخصي')}}</span>
                  </a> --}}
                  <a class="nav-link" href="{{ route('users.edit', ['id' => auth()->user()->id]) }}">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> الملف الشخصى </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" href="{{ route('home') }}">
              <i class="material-icons">dashboard</i>
              <p> الرئيسه </p>
            </a>
          </li>
        @canany(['teams.index', 'users.index','roles.index'])
          {{-- start مدير النظام --}}
          <li class="nav-item " >
            <a class="nav-link " data-toggle="collapse" href="#pagesExamples1" aria-expanded="true">
              <i class="material-icons">settings</i>
              <p> مدير النظام
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{cuurentroute('admins.index','show')}} {{cuurentroute('teams.index','show')}} 
                    {{cuurentroute('users.index','show')}} {{cuurentroute('roles.index','show')}}
                        {{cuurentroute('permissions.index','show')}}" id="pagesExamples1">
              <ul class="nav">

              @can('roles.index')
                <li class="nav-item {{cuurentroute('roles.index','active')}}" >
                  <a href="{{ route('roles.index') }}"
                  class="nav-link {{ Request::is('roles*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                      <span class="menu-item-text">الصلاحيات</span>
                  </a>
                </li>
              @endcan

              @can('users.index')
                <li class="nav-item {{cuurentroute('users.index','active')}}">
                  <a href="{{ route('users.index') }}"
                  class="nav-link {{ Request::is('users*') ? 'active' : '' }}  ">
                  <i class="fas fa-user-friends"></i>
                      <span class="menu-item-text">المستخدمين</span>
                  </a>
                </li>
              @endcan
               @can('teams.index')
                <li class="nav-item {{cuurentroute('teams.index','active')}}">
                   <a href="{{ route('teams.index') }}"
                  class="nav-link {{ Request::is('teams*') ? 'active' : '' }}  ">
                  <i class="fas fa-user-friends"></i>
                      <span class="menu-item-text">الاقسام</span>
                  </a>
                </li>
                 @endcan
              </ul>
            </div>
          </li>
          {{-- End مدير النظام --}}
        @endcan

    @canany(['customers.index', 'suppliers.index','productCategories.index','products.index','serviceCategories.index','services.index','stages.index','serviceItems.index',
    'receiveReceipts.index','returnReceipts.index','workOrders.index','places.index','receivables.index','final_deliver_orders.index','deliverOrders.index',
    'reservations.index','security_deliver','permissions.index'])
          <li class="nav-item " >
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples2" aria-expanded="true">
              <i class="material-icons">tune</i>
              <p> الانتاج<b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{cuurentroute('customers.index','show')}} {{cuurentroute('suppliers.index','show')}} {{cuurentroute('fabricSources.index','show')}}
              {{cuurentroute('fabrics.index','show')}} {{cuurentroute('productCategories.index','show')}} 
              {{cuurentroute('products.index','show')}} {{cuurentroute('serviceCategories.index','show')}} {{cuurentroute('services.index','show')}} {{cuurentroute('stages.index','show')}}
              {{cuurentroute('satgeCategories.index','show')}} {{cuurentroute('serviceItems.index','show')}} {{cuurentroute('receiveReceipts.index','show')}}
              {{cuurentroute('returnReceipts.index','show')}} {{cuurentroute('workOrders.index','show')}}
              {{cuurentroute('places.index','show')}} {{cuurentroute('receivables.index','show')}} {{cuurentroute('final_deliver_orders','show')}} 
              {{cuurentroute('deliverOrders.index','show')}} {{cuurentroute('reservations.index','show')}}  {{cuurentroute('dyeingReceiveWebs.index','show')}}
              {{cuurentroute('security_deliver','show')}}  {{cuurentroute('permissions.index','show')}}" id="pagesExamples2">
              <ul class="nav">


                <li class="nav-item {{cuurentroute('customers.index','active')}}">
                  @can('customers.index')
                  <a href="{{ route('customers.index') }}"
                  class="nav-link {{ Request::is('customers*') ? 'active' : '' }} ">
                  <i class="fas fa-users" ></i>
                      <span class="menu-item-text"> العملاء</span>
                  </a>
                  @endcan
                </li>
                
                <li class="nav-item {{cuurentroute('suppliers.index','active')}}">
                  @can('suppliers.index')
                  <a href="{{ route('suppliers.index') }}"
                  class="nav-link {{ Request::is('suppliers*') ? 'active' : '' }} ">
                  <i class="fas fa-users"></i>
                      <span class="menu-item-text"> الموردين</span>
                  </a>
                  @endcan
                </li>


                <li class="nav-item {{cuurentroute('fabricSources.index','active')}}">
                  @can('fabricSources.index')
                  <a href="{{ route('fabricSources.index') }}"
                  class="nav-link {{ Request::is('fabricSources*') ? 'active' : '' }} ">
                  <i class="fas fa-stamp"></i>
                      <span class="menu-item-text"> مصدر القماش</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item  {{cuurentroute('fabrics.index','active')}}">
                @can('fabrics.index')
                <a href="{{ route('fabrics.index') }}"
                class="nav-link {{ Request::is('fabrics*') ? 'active' : '' }}">
                <i class="fas fa-tape"></i>
                    <span class="menu-item-text"> القماش</span>
                </a>
                @endcan
                </li>

                <li class="nav-item {{cuurentroute('productCategories.index','active')}}">
                  @can('productCategories.index')

                  <a href="{{ route('productCategories.index') }}"
                     class="nav-link {{ Request::is('productCategories*') ? 'active' : '' }} ">
                     <i class="fas fa-sitemap"></i>
                      <span class="menu-item-text"> مجموعه الاصناف</span>
                  </a>
                  @endcan
                </li>





                <li class="nav-item {{cuurentroute('products.index','active')}}">
                  @can('products')

                  <a href="{{ route('products.index') }}"
                     class="nav-link {{ Request::is('products*') ? 'active' : '' }} ">
                     <i class="fas fa-vest"></i>
                      <span class="menu-item-text">  الاصناف</span>
                  </a>
                  @endcan
                </li>


                <li class="nav-item {{cuurentroute('serviceCategories.index','active')}}">
                  @can('serviceCategories.index')
                  <a href="{{ route('serviceCategories.index') }}"
                   class="nav-link {{ Request::is('serviceCategories*') ? 'active' : '' }} ">
                   <i class="fas fa-concierge-bell"></i>
                  <span class="menu-item-text"> مجموعات الخدمات</span>
                  </a>
                  @endcan
                </li>


                <li class="nav-item  {{cuurentroute('services.index','active')}}">
                  @can('services.index')
                  <a href="{{ route('services.index') }}"
                   class="nav-link {{ Request::is('services*') ? 'active' : '' }}">
                   <i class="fas fa-concierge-bell"></i>
                  <span class="menu-item-text"> الخدمات</span>
                  </a>
                  @endcan
                </li>


                <li class="nav-item {{cuurentroute('serviceItems.index','active')}}">
                  @can('serviceItems.index')
                  <a href="{{ route('serviceItems.index') }}"
                     class="nav-link {{ Request::is('serviceItems*') ? 'active' : '' }} ">
            <i class="fas fa-eye-dropper"></i>
                  <span class="menu-item-text"> عناصر الخدمات </span>
                  </a>
                  @endcan
                </li>


                <li class="nav-item {{cuurentroute('satgeCategories.index','active')}}">
                  @can('satgeCategories.index')
                  <a href="{{ route('satgeCategories.index') }}"
                  class="nav-link {{ Request::is('satgeCategories*') ? 'active' : '' }} ">
            <i class="fas fa-eye-dropper"></i>
                  <span class="menu-item-text">مجموعات مراحل الانتاج</span>
                  </a>
              @endcan
                </li>

                <li class="nav-item {{cuurentroute('stages.index','active')}}">
                  @can('stages.index')
                  <a href="{{ route('stages.index') }}"
                  class="nav-link {{ Request::is('stages*') ? 'active' : '' }} ">
            <i class="fas fa-eye-dropper"></i>
                  <span class="menu-item-text">  مراحل الانتاج</span>
                  </a>
                  @endcan
                </li>
                  <li class="nav-item {{cuurentroute('receiveReceipts.index','active')}}">
                    @can('receiveReceipts.index')
                    <a href="{{ route('receiveReceipts.index') }}"
                    class="nav-link {{ Request::is('receiveReceipts*') ? 'active' : '' }} ">
                    <i class="fas fa-receipt"></i>
                    <span class="menu-item-text">  اذن اضافة </span>
                    </a>
                    @endcan
                </li>                
                {{-- <li class="nav-item {{cuurentroute('returnReceipts.index','active')}}">
                  @can('returnReceipts.index')
                  <a href="{{ route('returnReceipts.index') }}"
                  class="nav-link {{ Request::is('returnReceipts*') ? 'active' : '' }} ">
                  <i class="fas fa-receipt"></i>
                  <span class="menu-item-text">  اذن اضافة مرتجع </span>
                  </a>
                  @endcan
                </li>                 --}}
                <li class="nav-item {{cuurentroute('workOrders.index','active')}}">
                  @can('workOrders.index')
                  <a href="{{ route('workOrders.index') }}"
                  class="nav-link {{ Request::is('workOrders*') ? 'active' : '' }} {{cuurentroute('workOrders.index','active')}}">
                  <i class="fab fa-first-order"></i>
                  <span class="menu-item-text">   الغسلة </span>
                  </a>
                  @endcan
                </li>                
                <li class="nav-item {{cuurentroute('places.index','active')}}">
                  @can('places.index')
                  <a href="{{ route('places.index') }}"
                  class="nav-link {{ Request::is('places*') ? 'active' : '' }} ">
                  <i class="fas fa-map"></i>
                  <span class="menu-item-text">اماكن التخزين </span>
                  </a>
                  @endcan
                </li>                
                <li class="nav-item {{cuurentroute('receivables.index','active')}}">
                  @can('receivables.index')
                  <a href="{{ route('receivables.index') }}"
                  class="nav-link {{ Request::is('receivables*') ? 'active' : '' }} ">
                  <i class="fas fa-people-carry"></i>
                  <span class="menu-item-text"> المستلمون </span>
                  </a>
                  @endcan
                </li>                
                <li class="nav-item {{cuurentroute('final_deliver_orders','active')}}">
                  @can('final_deliver_orders')
                  <a href="{{ route('final_deliver_orders') }}"
                  class="nav-link {{ Request::is('final_deliver_orders*') ? 'active' : '' }}  ">
                  <i class="fas fa-truck"></i>
                  <span class="menu-item-text"> اذن التسليم </span>
                  </a>
                  @endcan
                </li>                
                <li class="nav-item {{cuurentroute('deliverOrders.index','active')}}">
                  @can('deliverOrders.index')
                  <a href="{{ route('deliverOrders.index') }}"
                  class="nav-link {{ Request::is('deliverOrders*') ? 'active' : '' }}  ">
                  <i class="fas fa-truck"></i>
                  <span class="menu-item-text"> اذن التغليف </span>
                  </a>
                  @endcan
                </li>                
                <li class="nav-item {cuurentroute('security_deliver','active')}}">
                  @can('security_deliver')
                  <a href="{{ route('security_deliver') }}"
                  class="nav-link {{ Request::is('security_deliver*') ? 'active' : '' }}  {">
                  <i class="fas fa-truck"></i>
                  <span class="menu-item-text">الامن</span>
                  </a>
                  @endcan
                </li>                
                <li class="nav-item {{cuurentroute('reservations.index','active')}}">
                  @can('reservations.index')
                  <a href="{{ route('reservations.index') }}"
                  class="nav-link {{ Request::is('reservations*') ? 'active' : '' }} ">
                  <i class="fas fa-check-circle"></i>
                  <span class="menu-item-text"> الغسلات المسبقة </span>
                  </a>
                  @endcan
                </li>
               
              </ul>
            </div>
          </li>
      @endcan
      @canany(['labSamples.index', 'labSamples_lab_view','labReadySampleView','tab_index','createSamples.index'])
          {{-- المعمل Start--}}
          <li class="nav-item " >
            <a class="nav-link " data-toggle="collapse" href="#pagesExamples4" aria-expanded="true">
              <i class="material-icons">sort</i>
              <p> المعمل
                <b class="caret"></b>
              </p>
            </a>
            
            <div class="collapse {{cuurentroute('labSamples.index','show')}} {{cuurentroute('labSamples_lab_view','show')}} {{cuurentroute('labReadySample_view','show')}}
              {{cuurentroute('tab_index','show')}} {{cuurentroute('createSamples.index','show')}}" id="pagesExamples4">
              <ul class="nav">


                <li class="nav-item {{cuurentroute('labSamples.index','active')}}">
                  @can('labSamples.index')
                  <a href="{{ route('labSamples.index') }}"
                  class="nav-link {{ Request::is('labSamples*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                      <span class="menu-item-text">العينات</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('labSamples_lab_view','active')}}">
                  @can('labSamples_lab_view')
                  <a href="{{ route('labSamples_lab_view') }}"
                  class="nav-link {{ Request::is('labSamples_lab_view*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                      <span class="menu-item-text">عينات المعمل</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('labReadySample_view','active')}}">
                  @can('labReadySample_view')
                  <a href="{{ route('labReadySample_view') }}"
                  class="nav-link {{ Request::is('labReadySample_view*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                      <span class="menu-item-text">عينات جاهزة للتسليم</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('tab_index','active')}}">
                  @can('tab_index')
                  <a href="{{ route('tab_index') }}"
                  class="nav-link {{ Request::is('tab_index*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                      <span class="menu-item-text">حركة العينات</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('createSamples.index','active')}}">
                  @can('createSamples.index')
                  <a href="{{ route('createSamples.index') }}"
                  class="nav-link {{ Request::is('createSamples*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                      <span class="menu-item-text">انشاء رسبى عينات</span>
                  </a>
                  @endcan
                </li>


              </ul>
            </div>
          </li>
          @endcan
          {{-- المعمل End--}}
        @canany(['invStores.index', 'invUnits.index','invCategories.index','invProducts.index','invStockIns.index','invStockOuts.index'])
          {{-- مخازن start--}}
          <li class="nav-item " >
            <a class="nav-link " data-toggle="collapse" href="#pagesExamples3" aria-expanded="true">
              <i class="material-icons">store</i>
              <p> ادارة المخازن
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{cuurentroute('invStores.index','show')}} {{cuurentroute('invUnits.index','show')}}{{cuurentroute('invCategories.index','show')}}
                        {{cuurentroute('invProducts.index','show')}} {{cuurentroute('invImportOrders.index','show')}} {{cuurentroute('invExportOrders.index','show')}}
                        {{cuurentroute('invStockTransfers.index','show')}}{{cuurentroute('colorCategories.index','show')}}{{cuurentroute('colorCodes.index','show')}}
                        {{cuurentroute('colors.index','show')}}"
                        id="pagesExamples3">
              <ul class="nav">
                <li class="nav-item {{cuurentroute('invStores.index','active')}}">
                  @can('invStores.index')
                  <a href="{{ route('invStores.index') }}"
                  class="nav-link {{ Request::is('invStores*') ? 'active' : '' }}" >
                  <i class="fas fa-warehouse"></i>
                      <span class="menu-item-text">المخازن</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('invUnits.index','active')}}">
                  @can('invUnits.index')
                  <a href="{{ route('invUnits.index') }}" class="nav-link {{ Request::is('invUnits*') ? 'active' : '' }}" >
                  <i class="fas fa-ruler-horizontal"></i>
                      <span class="menu-item-text">الوحدات</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('invCategories.index','active')}}">
                  @can('invCategories.index')
                  <a href="{{ route('invCategories.index') }}"
                  class="nav-link {{ Request::is('invCategories*') ? 'active' : '' }}" >
                  <i class="fas fa-list-alt"></i>
                  <span class="menu-item-text">المجموعات</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('invProducts.index','active')}}">
                  @can('invProducts.index')
                  <a href="{{ route('invProducts.index') }}"
                  class="nav-link {{ Request::is('invProducts*') ? 'active' : '' }}" >
                  <i class="fas fa-cube"></i>
                      <span class="menu-item-text">المنتجات</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('invImportOrders.index','active')}}">
                  @can('invImportOrders.index')
                  <a href="{{ route('invImportOrders.index') }}"
                  class="nav-link {{ Request::is('invImportOrders*') ? 'active' : '' }}" >
                  <i class="fas fa-clipboard-list"></i>
                  <span class="menu-item-text">اذن استلام بضاعة</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('invExportOrders.index','active')}}">
                  @can('invExportOrders.index')
                  <a href="{{ route('invExportOrders.index') }}"
                  class="nav-link {{ Request::is('invExportOrders*') ? 'active' : '' }}" >
                  <i class="fas fa-dolly"></i>
                  <span class="menu-item-text">اذن صرف بضاعة</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('invStockTransfers.index','active')}}">
                  @can('invStockTransfers.index')
                  <a href="{{ route('invStockTransfers.index') }}"
                  class="nav-link {{ Request::is('invStockTransfers*') ? 'active' : '' }}" >
                  <i class="fas fa-unlock-alt"></i>
                  <span class="menu-item-text">اذن تحويل بضاعة</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('colorCategories.index','active')}}">
                  @can('colorCategories.index')
                  <a href="{{ route('colorCategories.index') }}"
                  class="nav-link {{ Request::is('colorCategories*') ? 'active' : '' }}" >
                  <i class="fas fa-layer-group"></i>
                      <span class="menu-item-text">مجموعة الالوان</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('colorCodes.index','active')}}">
                  @can('colorCodes.index')
                  <a href="{{ route('colorCodes.index') }}"
                  class="nav-link {{ Request::is('colorCodes*') ? 'active' : '' }}" >
                  <i class="fas fa-link"></i>
                      <span class="menu-item-text">اكواد الالوان</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('colors.index','active')}}">
                  @can('colors.index')
                  <a href="{{ route('colors.index') }}"
                  class="nav-link {{ Request::is('colors*') ? 'active' : '' }}" >
                  <i class="fas fa-link"></i>
                      <span class="menu-item-text"> الالوان</span>
                  </a>
                  @endcan
                </li>

              </ul>
            </div>
          </li>
        @endcan
      {{-- ============================مخازن End=======================  --}}
      {{-- =======================حسابات start=========================== --}}
      @canany(['accounting','treasuries.index','paymentTypes.index','treasury_journal.index','accountingCosts.index','banks.index','invoices.index'])
          <li class="nav-item " >
            <a class="nav-link " data-toggle="collapse" href="#pagesExamples6" aria-expanded="true">
              <i class="material-icons">account_balance</i>
              <p> الحسابات
                <b class="caret"></b>
              </p>
            </a>
            
            <div class="collapse {{cuurentroute('treasuries.index','show')}} {{cuurentroute('paymentTypes.index','show')}}{{cuurentroute('treasury_journal','show')}}
                {{cuurentroute('accountingCosts.index','show')}} {{cuurentroute('banks.index','show')}} {{cuurentroute('invoices.index','show')}}" id="pagesExamples6">
              <ul class="nav">
                <li class="nav-item {{cuurentroute('treasuries.index','active')}}">
                  @can('treasuries.index')
                  <a href="{{ route('treasuries.index') }}"
                  class="nav-link {{ Request::is('treasuries*') ? 'active' : '' }}" >
                  <i class="fas fa-warehouse"></i>
                  <span class="menu-item-text">خزينه</span>
                  </a>
                  @endcan
                </li>
              {{-- 
                <li class="nav-item {{cuurentroute('paymentTypes.index','active')}}">
                  @can('paymentTypes.index')
                  <a href="{{ route('paymentTypes.index') }}"
                  class="nav-link {{ Request::is('paymentTypes*') ? 'active' : '' }}" >
                  <i class="fas fa-credit-card"></i>
                  <span class="menu-item-text">نوع الدفع</span>
                  </a>
                  @endcan
                </li> --}}


                <li class="nav-item {{cuurentroute('treasury_journal','active')}}">
                  @can('treasuryDetails.treasury_journal')
                  <a href="{{ route('treasury_journal') }}"
                  class="nav-link {{ Request::is('treasury_journal*') ? 'active' : '' }}" >
                  <i class="fas fa-sync-alt"></i>
                  <span class="menu-item-text">يوميه الخزينة </span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('accountingCosts.index','active')}}">
                  @can('accountingCosts.index')
                  <a href="{{ route('accountingCosts.index') }}"
                  class="nav-link {{ Request::is('accountingCosts*') ? 'active' : '' }}" >
                  <i class="fas fa-file-invoice-dollar"></i>
                  <span class="menu-item-text">التكاليف </span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('banks.index','active')}}">
                  @can('banks.index')
                  <a href="{{ route('banks.index') }}"
                  class="nav-link {{ Request::is('banks*') ? 'active' : '' }}" >
                  <i class="fas fa-university"></i>
                  <span class="menu-item-text">البنوك </span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('invoices.index','active')}}">
                  @can('invoices.index')
                  <a href="{{ route('invoices.index') }}"
                  class="nav-link {{ Request::is('invoices*') ? 'active' : '' }}" >
                  <i class="fas fa-university"></i>
                  <span class="menu-item-text">الفواتير </span>
                  </a>
                  @endcan
                </li>




              </ul>
            </div>
          </li>
          @endcan
      {{-- ============================حسابات End=======================  --}}


      {{-- ===========================تقارير انتاج Stsrt================= --}}
      @canany(['reports.index', 'accreports.index','readyreports.index','reports_stages','receive_receipt_open','models_report','residual','activity_logs'])
          <li class="nav-item " >
            <a class="nav-link " data-toggle="collapse" href="#pagesExamples5" aria-expanded="true">
              <i class="material-icons">report</i>
              <p> تقارير انتاج
                <b class="caret"></b>
              </p>
            </a>
            
            <div class="collapse {{cuurentroute('reports','show')}} {{cuurentroute('accreports','show')}}
                              {{cuurentroute('readyreports','show')}} {{cuurentroute('reports_stages','show')}} {{cuurentroute('receive_receipt_open','show')}}
                              {{cuurentroute('models_report','show')}} {{cuurentroute('residual','show')}} {{cuurentroute('activity_logs','show')}}
                              {{cuurentroute('final_delivers_report','show')}}" id="pagesExamples5">
              <ul class="nav">


                <li class="nav-item {{cuurentroute('reports','active')}}">
                  @can('reports.index')
                  <a href="{{ route('reports') }}"
                  class="nav-link {{ Request::is('reports*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                      <span class="menu-item-text">تقرير متابعه الانتاج</span>
                  </a>
                  @endcan
                </li>

                {{-- <li class="nav-item {{cuurentroute('accreports','active')}}">
                  @can('accreports.index')
                  <a href="{{ route('accreports') }}"
                  class="nav-link {{ Request::is('accreports*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                      <span class="menu-item-text">تقرير الحسابات</span>
                  </a>
                  @endcan
                </li> --}}

                <li class="nav-item {{cuurentroute('readyreports','active')}}">
                  @can('readyreports.index')
                  <a href="{{ route('readyreports') }}"
                  class="nav-link {{ Request::is('readyreports*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                      <span class="menu-item-text">تقرير مخزن الجاهز</span>
                  </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('residual','active')}}">
                  @can('residual')
                  <a href="{{ route('residual') }}"
                  class="nav-link {{ Request::is('residual*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                      <span class="menu-item-text">تقرير البواقى</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('reports_stages','active')}}">
                  @can('reports_stages')
                  <a href="{{ route('reports_stages') }}"
                  class="nav-link {{ Request::is('reports_stages*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                      <span class="menu-item-text">تقرير المراحل</span>
                  </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('receive_receipt_open','active')}}">
                  @can('receive_receipt_open')
                  <a href="{{ route('receive_receipt_open') }}"
                  class="nav-link {{ Request::is('receive_receipt_open*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                  <span class="menu-item-text">   تقرير اذون الاضافة الفتوحة </span>
                </a>
                  @endcan
                </li>
                <li class="nav-item {{cuurentroute('models_report','active')}}">
                  @can('models_report')
                  <a href="{{ route('models_report') }}"
                  class="nav-link {{ Request::is('models_report*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                  <span class="menu-item-text">   تقرير الموديلات </span>
                </a>
                  @endcan
                </li>
                {{-- <li class="nav-item {{cuurentroute('dashboard_report','active')}}">
                  @can('dashboard_report')
                  <a href="{{ route('dashboard_report') }}"
                  class="nav-link {{ Request::is('dashboard_report*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                  <span class="menu-item-text">   تقرير تحليل الاداء </span>
                </a>
                  @endcan
                </li> --}}

                <li class="nav-item {{cuurentroute('activity_logs','active')}}">
                  @can('activity_logs')
                  <a href="{{ route('activity_logs') }}"
                  class="nav-link {{ Request::is('activity_logs*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                  <span class="menu-item-text">   تقرير سجل النشاطات </span>
                </a>
                  @endcan
                </li>

                <li class="nav-item {{cuurentroute('final_delivers_report','active')}}">
                  @can('final_delivers_report')
                  <a href="{{ route('final_delivers_report') }}"
                  class="nav-link {{ Request::is('final_delivers_report*') ? 'active' : '' }}" >
                  <i class="fas fa-search"></i>
                  <span class="menu-item-text">   تقرير اذون التسليم </span>
                </a>
                  @endcan
                </li>

               
         

              </ul>
            </div>
          </li>
          @endcan
          {{--   ==============تقارير انتاج====================== End --}}


                {{-- ===========================تقارير مخازن و حسابات Stsrt================= --}}
              @canany(['report2.product_report','report2.total_Products_report','report1.treasuries_report','report1.customer_account_report','report1.supplier_account_report'])                 
                <li class="nav-item " >
                  <a class="nav-link " data-toggle="collapse" href="#pagesExamples7" aria-expanded="true">
                    <i class="material-icons">report</i>
                    <p> تقارير مخازن و حسابات
                      <b class="caret"></b>
                    </p>
                  </a>
                 

                  <div class="collapse {{cuurentroute('product_report','show')}} {{cuurentroute('total_Products_report','show')}} {{cuurentroute('treasuries_report','show')}}{{cuurentroute('customer_account_report','show')}}
                  {{cuurentroute('supplier_account_report','show')}} {{cuurentroute('supplier_account_report','show')}} {{cuurentroute('invoice_report','show')}} {{cuurentroute('service_prices_report','show')}}" id="pagesExamples7">
                    <ul class="nav">
      
                      
                      <li class="nav-item {{cuurentroute('product_report','active')}}">
                    @can('report2.product_report')
                        <a href="{{ route('product_report') }}"
                        class="nav-link {{ Request::is('product_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير كارته صنف المنتج</span>
                        </a>
                    @endcan
                      </li>

                      <li class="nav-item {{cuurentroute('total_Products_report','active')}}">
                    @can('report2.total_Products_report')
                        <a href="{{ route('total_Products_report') }}"
                        class="nav-link {{ Request::is('total_Products_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير رصيد المنتجات</span>
                        </a>
                    @endcan
                      </li>
                      <li class="nav-item {{cuurentroute('wash_chemical_report','active')}}">
                    @can('report2.wash_chemical_report')
                        <a href="{{ route('wash_chemical_report') }}"
                        class="nav-link {{ Request::is('wash_chemical_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير كيماويات الغسله</span>
                        </a>
                    @endcan
                      </li>
                      <li class="nav-item {{cuurentroute('treasuries_report','active')}}">
                    @can('report1.treasuries_report')
                        <a href="{{ route('treasuries_report') }}"
                        class="nav-link {{ Request::is('treasuries_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير  يوميه خزينة</span>
                        </a>
                    @endcan
                      </li>
                      
                      <li class="nav-item {{cuurentroute('customer_account_report','active')}}">
                    @can('report1.customer_account_report')
                        <a href="{{ route('customer_account_report') }}"
                        class="nav-link {{ Request::is('customer_account_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير  حساب العملاء</span>
                        </a>
                    @endcan
                      </li>
                    <li class="nav-item {{cuurentroute('supplier_account_report','active')}}">
                    @can('report1.supplier_account_report')
                        <a href="{{ route('supplier_account_report') }}"
                        class="nav-link {{ Request::is('supplier_account_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير  حساب الموردين</span>
                        </a>
                    @endcan
                      </li>
                    <li class="nav-item {{cuurentroute('invoice_report','active')}}">
                    @can('report1.invoice_report')
                        <a href="{{ route('invoice_report') }}"
                        class="nav-link {{ Request::is('invoice_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير  المبيعات</span>
                        </a>
                    @endcan
                      </li>
                    <li class="nav-item {{cuurentroute('service_prices_report','active')}}">
                    @can('report1.service_prices_report')
                        <a href="{{ route('service_prices_report') }}"
                        class="nav-link {{ Request::is('service_prices_report*') ? 'active' : '' }}" >
                        <i class="fas fa-search"></i>
                        <span class="menu-item-text">تقرير الخدمات المباعة</span>
                        </a>
                    @endcan
                      </li>
    
                    </ul>
                  </div>
                </li>
              @endcan
                {{--   ==============تقارير مخازن و حسابات====================== End --}}

        </ul>
      </div>
    </div>
      <!-- Navbar -->




      <!-- End Navbar -->
