    <div class="header" style="background-color: #ffffff">
        <!-- BEGIN Header Holder -->

        <div class="header-holder header-holder-desktop sticky-header" id="sticky-header-desktop">
            <div class="header-container container-fluid">
                <div class="header-wrap header-wrap-block" style="visibility: hidden;">
                    <!-- BEGIN Input Group -->
                    <div class="input-group-icon input-group-lg widget15-compact">
                        <div class="input-group-prepend">
                            <i class="fa fa-search text-primary"></i>
                        </div>
                        <input type="text" class="form-control" placeholder="Type to search...">
                    </div>
                    <!-- END Input Group -->
                </div>
                <div class="header-wrap">
                    <!-- BEGIN Dropdown -->
                    <div class="dropdown ml-2" style="display: flex;">
                        <button class="btn btn-flat-primary widget13" data-toggle="dropdown">
                            {{-- <div class="widget13-text"> {{__('Hi')}} <strong>{{auth()->user()->username}}</strong> --}}
                            <div class="widget13-text"> {{auth()->user()->username}} <strong></strong>
                            </div>
                         
                        </button>

                           <!-- BEGIN Avatar -->
                           <div class="avatar avatar-info widget13-avatar">
                            <div class="avatar-display">
                                <i class="fa fa-user-alt"></i>
                            </div>
                        </div>
                        <!-- END Avatar -->
                        
                        <div class="dropdown-menu dropdown-menu-wide dropdown-menu-right dropdown-menu-animated overflow-hidden py-0">
                            <!-- BEGIN Portlet -->
                            <div class="portlet border-0">

                                <div class="portlet-body p-0">
                                    <!-- BEGIN Grid Nav -->
                                    {{-- <div class="grid-nav grid-nav-flush grid-nav-action grid-nav-no-rounded"> --}}
                                        <div class="grid-nav-row grid-nav-flush grid-nav-action grid-nav-no-rounded" >
                                           
                                                <a href="{{ route('users.edit', ['id' => auth()->user()->id]) }}" class="grid-nav-item">
                                                <div class="grid-nav-icon">
                                                    <i class="far fa-address-card"></i>
                                                </div>
                                                <span class="grid-nav-content">{{__('الملف الشخصي')}}</span>
                                            </a>

                                        </div>

                                    {{-- </div> --}}
                                    <!-- END Grid Nav -->
                                </div>
                                <div class="portlet-footer portlet-footer-bordered rounded-0">                                    
                                    <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                     تسجيل خروج
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                 </form>

                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
                    </div>
                    <!-- END Dropdown -->
                </div>
            </div>
        </div>
        <!-- END Header Holder -->
        <!-- BEGIN Header Holder -->
{{--        <div class="header-holder header-holder-desktop" style="display: none">--}}
{{--            <div class="header-container container-fluid">--}}

{{--                <i class="header-divider"></i>--}}
{{--                <div class="header-wrap header-wrap-block justify-content-start">--}}
{{--                    <!-- BEGIN Breadcrumb -->--}}
{{--                    <div class="breadcrumb">--}}
{{--                        <a href="{{route('dashboard')}}" class="breadcrumb-item active">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <i data-feather="home"></i>--}}
{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('Dashboard')}}</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{route('categories.index')}}" class="breadcrumb-item">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <i class="fa fa-align-justify"></i>--}}
{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('Categories')}}</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{route('banners.index')}}" class="breadcrumb-item">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <i class="far fa-images"></i>--}}
{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('Banners')}}</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{route('home.settings.edit')}}" class="breadcrumb-item">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <img src="{{asset('images/settings.svg')}}" alt="" height="13" width="13">--}}

{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('Home Settings')}}</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{route('general.settings.edit')}}" class="breadcrumb-item">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <img src="{{asset('images/settings.svg')}}" alt="" height="13" width="13">--}}

{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('General Settings')}}</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{route('checkout.settings.edit')}}" class="breadcrumb-item">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <i class="fas fa-cart-arrow-down"></i>--}}
{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('Checkout Settings')}}</span>--}}
{{--                        </a>--}}
{{--                        <a href="{{route('notifications.create')}}" class="breadcrumb-item">--}}
{{--                            <div class="breadcrumb-icon">--}}
{{--                                <i class="fa fa-bell"></i>--}}
{{--                            </div>--}}
{{--                            <span class="breadcrumb-text">{{__('Notifications')}}</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <!-- END Breadcrumb -->--}}
{{--                </div>--}}
{{--                <div class="header-wrap">--}}
{{--                    <!-- BEGIN Button Group -->--}}
{{--                    <div class="btn-group btn-group-toggle" data-toggle="buttons">--}}

{{--                    </div>--}}
{{--                    <!-- END Button Group -->--}}
{{--                    <button class="btn btn-label-info btn-icon ml-2" id="fullscreen-trigger" data-toggle="tooltip" title="Toggle fullscreen" data-placement="left">--}}
{{--                        <i class="fa fa-expand fullscreen-icon-expand"></i>--}}
{{--                        <i class="fa fa-compress fullscreen-icon-compress"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- END Header Holder -->


        <div class="header-holder header-holder-mobile sticky-header" id="sticky-header-mobile">
            <div class="header-container container-fluid">
                <div class="header-wrap">
                    <button class="btn btn-flat-primary btn-icon" data-toggle="aside">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="header-wrap">
                    <select class="selectpicker form-control mr-2 ml-2" data-width="fit" onChange="window.location.href=this.value">
                        <option data-content="<img src='{{asset('images/eg.png')}}'  width='18' height='20'>" value=""
                            {{-- <option data-content="<img src='{{asset('images/eg.png')}}'  width='18' height='20'>" value="{{route('change.language','ar')}}" --}}
                                {{-- @if(LanguageAttributes::lang_code() == 'ar')
                                selected
                            @endif --}}
                        >

                        </option>
                        {{-- <option data-content="<img src='{{asset('images/us.png')}}'  height='18'>" value="{{route('change.language','en')}}" --}}
                            <option data-content="<img src='{{asset('images/us.png')}}'  height='18'>" value=""
                                {{-- @if(LanguageAttributes::lang_code() == 'en')
                                selected
                            @endif --}}
                        >

                        </option>
                    </select>
                    <!-- BEGIN Dropdown -->
                    <div class="dropdown ml-2">
                        <button class="btn btn-flat-primary widget13" data-toggle="dropdown">
                            {{-- <div class="widget13-text"> {{__('Hi')}} <strong>{{auth()->user()->username}}</strong> --}}
                                <div class="widget13-text"> {{__('Hi')}} <strong></strong>
                            </div>
                            <!-- BEGIN Avatar -->
                            <div class="avatar avatar-info widget13-avatar">
                                <div class="avatar-display">
                                    <i class="fa fa-user-alt"></i>
                                </div>
                            </div>
                            <!-- END Avatar -->
                        </button>
                        <div class="dropdown-menu dropdown-menu-wide dropdown-menu-right dropdown-menu-animated overflow-hidden py-0">
                            <!-- BEGIN Portlet -->
                            <div class="portlet border-0">

                                <div class="portlet-body p-0">
                                    <!-- BEGIN Grid Nav -->
                                    <div class="grid-nav grid-nav-flush grid-nav-action grid-nav-no-rounded">
                                        <div class="grid-nav-row">
                                            {{-- <a href="{{route('profile')}}" class="grid-nav-item"> --}}
                                                <a href="" class="grid-nav-item">
                                                <div class="grid-nav-icon">
                                                    <i class="far fa-address-card"></i>
                                                </div>
                                                <span class="grid-nav-content">{{__('Profile')}}</span>
                                            </a>

                                        </div>
{{--                                        <div class="grid-nav-row">--}}
{{--                                            <a href="{{route('notifications.create')}}" class="grid-nav-item">--}}
{{--                                                <div class="grid-nav-icon">--}}
{{--                                                    <i class="far fa-bell"></i>--}}
{{--                                                </div>--}}
{{--                                                <span class="grid-nav-content">{{__('Notifications')}}</span>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
                                    </div>
                                    <!-- END Grid Nav -->
                                </div>
                                <div class="portlet-footer portlet-footer-bordered rounded-0">
                                    {{-- <a href="{{route('logout')}}" class="btn btn-label-danger">{{__('Sign out')}}</a> --}}
                                    <a href="" class="btn btn-label-danger">{{__('Sign out')}}</a>

                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
                    </div>
                    <!-- END Dropdown -->
                </div>
            </div>
        </div>

    </div>


