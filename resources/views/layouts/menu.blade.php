


        <!-- Add the new menu item here -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-crm"></i>
                <p>
                  الانتاج
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can('teams.index')
                <li class="nav-item">
                    <a href="{{ route('teams.index') }}"
                       class="nav-link {{ Request::is('teams*') ? 'active' : '' }}">
                        <p>الاقسام</p>
                    </a>
                </li>
                @endcan
                {{-- ----------------------------------- --}}
                @can('customers.index')
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}"
                    class="nav-link {{ Request::is('customers*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"> </i>
                    <p>العملاء</p>
                </a>
                </li>
                @endcan
               {{-- --------------------------------------- --}}
               @can('productCategories.index')
               <li class="nav-item">
                <a href="{{ route('productCategories.index') }}"
                   class="nav-link {{ Request::is('productCategories*') ? 'active' : '' }}">
                    <p>مجموعات الاصناف</p>
                </a>
            </li>
            @endcan
            @can('products')
            <li class="nav-item">
                <a href="{{ route('products.index') }}"
                   class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
                    <p>الاصناف</p>
                </a>
            </li>
            @endcan
            @can('serviceCategories.index')
            <li class="nav-item">
                <a href="{{ route('serviceCategories.index') }}"
                   class="nav-link {{ Request::is('serviceCategories*') ? 'active' : '' }}">
                    <p>مجموعات الخدمات</p>
                </a>
            </li>
            @endcan
            @can('services.index')
            <li class="nav-item">
                <a href="{{ route('services.index') }}"
                   class="nav-link {{ Request::is('services*') ? 'active' : '' }}">
                    <p>الخدمات</p>
                </a>
            </li>
            @endcan
            @can('stages.index')
            <li class="nav-item">
                <a href="{{ route('stages.index') }}"
                   class="nav-link {{ Request::is('stages*') ? 'active' : '' }}">
                    <p>مراحل الانتاج</p>
                </a>
            </li>
            @endcan
            @can('serviceItems.index')
            <li class="nav-item">
                <a href="{{ route('serviceItems.index') }}"
                   class="nav-link {{ Request::is('serviceItems*') ? 'active' : '' }}">
                    <p>عناصر الخدمات</p>
                </a>
            </li>
            @endcan
            @can('receiveReceipts.index')
            <li class="nav-item">
                <a href="{{ route('receiveReceipts.index') }}"
                   class="nav-link {{ Request::is('receiveReceipts*') ? 'active' : '' }}">
                    <p>اذن اضافة</p>
                </a>
            </li>
            @endcan
            @can('workOrders.index')
            <li class="nav-item">
                <a href="{{ route('workOrders.index') }}"
                   class="nav-link {{ Request::is('workOrders*') ? 'active' : '' }}">
                    <p>الغسلات</p>
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('reports') }}"
                   class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
                    <p>متابعة الانتاج</p>
                </a>
            </li>


            {{-- <li class="nav-item">
                <a href="{{ route('accreports') }}"
                   class="nav-link {{ Request::is('accreports*') ? 'active' : '' }}">
                    <p>تقرير الحسابات</p>
                </a>
            </li> --}}

            @can('places.index')
            <li class="nav-item">
                <a href="{{ route('places.index') }}"
                   class="nav-link {{ Request::is('places*') ? 'active' : '' }}">
                    <p>اماكن التخزين</p>
                </a>
            </li>
            @endcan
            @can('receivables.index')
            <li class="nav-item">
                <a href="{{ route('receivables.index') }}"
                   class="nav-link {{ Request::is('receivables*') ? 'active' : '' }}">
                    <p>المستلمون</p>
                </a>
            </li>
            @endcan
            </ul>
        </li>










<li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-crm"></i>
                <p>
                  المخازن
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
    <a href="{{ route('invUnits.index') }}"
       class="nav-link {{ Request::is('invUnits*') ? 'active' : '' }}">
        <p>الوحدات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('invCategories.index') }}"
       class="nav-link {{ Request::is('invCategories*') ? 'active' : '' }}">
        <p>المجموعات</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('invProducts.index') }}"
       class="nav-link {{ Request::is('invProducts*') ? 'active' : '' }}">
        <p>المنتجات</p>
    </a>
</li>
            </ul>
</li>





<li class="nav-item">
    <a href="{{ route('roles.index') }}"
       class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
       <i class="fa fa-lock" aria-hidden="true"></i>

        <p> الصلاحيات</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
       <i class="fa fa-user-plus" aria-hidden="true"></i>

        <p> المستخدمين</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('reservations.index') }}"
       class="nav-link {{ Request::is('reservations*') ? 'active' : '' }}">
        <p>Reservations</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('invStores.index') }}"
       class="nav-link {{ Request::is('invStores*') ? 'active' : '' }}">
        <p>Inv Stores</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('invStockIns.index') }}"
       class="nav-link {{ Request::is('invStockIns*') ? 'active' : '' }}">
        <p>Inv  Stock Ins</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('invStockOuts.index') }}"
       class="nav-link {{ Request::is('invStockOuts*') ? 'active' : '' }}">
        <p>اذن صرف</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('invStockTransfers.index') }}"
       class="nav-link {{ Request::is('invStockTransfers*') ? 'active' : '' }}">
        <p>Inv  Stock Transfers</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('returnReceipts.index') }}"
       class="nav-link {{ Request::is('returnReceipts*') ? 'active' : '' }}">
        <p>Return Receipts</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('satgeCategories.index') }}"
       class="nav-link {{ Request::is('satgeCategories*') ? 'active' : '' }}">
        <p>Satge Categories</p>
    </a>
</li>




<li class="nav-item">
    <a href="{{ route('labSamples.index') }}"
       class="nav-link {{ Request::is('labSamples*') ? 'active' : '' }}">
        <p>Lab Samples</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('createSamples.index') }}"
       class="nav-link {{ Request::is('createSamples*') ? 'active' : '' }}">
        <p>Create Samples</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('dyeingReceiveWebs.index') }}"
       class="nav-link {{ Request::is('dyeingReceiveWebs*') ? 'active' : '' }}">
        <p>Dyeing Receive Webs</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('fabricSources.index') }}"
       class="nav-link {{ Request::is('fabricSources*') ? 'active' : '' }}">
        <p>Fabric Sources</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('fabrics.index') }}"
       class="nav-link {{ Request::is('fabrics*') ? 'active' : '' }}">
        <p>Fabrics</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('banks.index') }}"
       class="nav-link {{ Request::is('banks*') ? 'active' : '' }}">
        <p>Banks</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('invoices.index') }}"
       class="nav-link {{ Request::is('invoices*') ? 'active' : '' }}">
        <p>Invoices</p>
    </a>
</li>


