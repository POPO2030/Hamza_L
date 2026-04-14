
<style>
    .permission-item {
        transition: transform 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .permission-item:hover {
        transform: scale(1.1);
    }

    .form-check-label,.form-check-input {
        white-space: unset;
        /* overflow: hidden;  */
        text-overflow: ellipsis; 
    }

</style>

<!-- Name Field -->
<div class="row" style="width:100%">
<div class="form-group col-6">
    
   {!! Form::text('name', null, ['class' => 'form-control','autofocus'=>'autofocus','placeholder'=>'اسم الصلاحيات','required','oninvalid'=>"setCustomValidity('الاسم مطلوب')",'onchange'=>"try{setCustomValidity('')}catch(e){}",'maxlength'=>"50"]) !!}
</div>
<div class="form-group col-6">
    <button class="btn btn-primary btn-md" type="button" onClick="toggleCheckboxes()">تحديد الكل</button>
</div>
</div>

<div class="container">
    <h3 class="mb-4">الصلاحيات</h3>

    <div class="row">
        @php
            $permissions = config('global.permissions');

            // Define permissions to exclude if team_id is 11
            $excludedPermissions = [
                'accounting', 
                'accountingCosts.index',
                'accountingCosts.create',
                'accountingCosts.store',
                'accountingCosts.show',
                'accountingCosts.destroy',
             // ------------------------------------
                'invoices',
                'invoices.index',
                'invoices.create',
                'invoices.store',
                'invoices.show',
                'invoices.edit',
                'invoices.update',
                'invoices.destroy',
              // ------------------------------------
                'treasuries.index',
                'treasuries.create',
                'treasuries.store',
                'treasuries.show',
                'treasuries.edit',
                'treasuries.update',
                'treasuries.destroy',
              // ------------------------------------
                'paymentTypes.index',
                'paymentTypes.create',
                'paymentTypes.store',
                'paymentTypes.show',
                'paymentTypes.edit',
                'paymentTypes.update',
                'paymentTypes.destroy',
              // ------------------------------------
                'banks.index',
                'banks.create',
                'banks.store',
                'banks.show',
                'banks.edit',
                'banks.update',
                'banks.destroy',
             // ------------------------------------
                'treasuryDetails.index',
                'treasuryDetails.create',
                'treasuryDetails.store',
                'treasuryDetails.show',
                'treasuryDetails.edit',
                'treasuryDetails.update',
                'treasuryDetails.destroy',
                'treasuryDetails.treasury_journal',
                'treasuryDetails.under_collection',
                'treasuryDetails.check_approved',
                'treasuryDetails.check_reject',
                'treasuryDetails.add_discount_customer',
              // ------------------------------------
                'report1',
                'report1.customer_account_report',
                'report1.supplier_account_report',
                'report1.treasuries_report',
                'report1.customer_invoices_analysis',
                'report1.invoice_report',
                // ----------------------------------------
                'roles.destroy',
                'users.destroy',
                'teams.destroy'
            ];

            // Exclude permissions if team_id is 11
            if (auth()->user()->team_id == 11) {
                $permissions = array_filter($permissions, function($value, $key) use ($excludedPermissions) {
                    return !in_array($key, $excludedPermissions);
                }, ARRAY_FILTER_USE_BOTH);
            }

            // Categorize permissions
            $categorizedPermissions = [];
            foreach ($permissions as $name => $value) {
                $firstWord = explode('.', $name)[0];
                if (!isset($categorizedPermissions[$firstWord])) {
                    $categorizedPermissions[$firstWord] = [];
                }
                $categorizedPermissions[$firstWord][$name] = $value;
            }
        @endphp

        @foreach ($categorizedPermissions as $category => $categoryPermissions)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="permission-item" style="border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 10px;">
                    @php
                        $firstPermission = reset($categoryPermissions);
                        $permissionsCount = count($categoryPermissions);
                    @endphp
                    <h4 style="color:#17a2b8;">
                        <div class="form-check form-check-inline">
                            {!! Form::checkbox('permissions[]', null, null, ['class' => 'form-check-input group-checkbox', 'data-group' => $category, 'style' => 'margin-right: 5px']) !!}
                            <label class="form-check-label" style="margin-right: 5px;">{{ $firstPermission }}</label>
                        </div>
                    </h4>

                    @foreach ($categoryPermissions as $name => $value)
                        <div class="form-check">
                            <label class="form-check-label" for="{{ $name }}" style="margin-right: 15px;">
                                {!! Form::checkbox('permissions[]', $name, isset($role->permissions) ? in_array($name, $role->permissions) : false, ['class' => 'form-check-input', 'id' => $name, 'data-group' => $category, 'style' => 'margin-right: -20px']) !!}
                                {{ $value }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>


<script>
    // تحديد جميع الصلاحيات داخل المجموعه
    document.addEventListener('DOMContentLoaded', function() {
        let groupCheckboxes = document.querySelectorAll('.group-checkbox');
        
        groupCheckboxes.forEach(function(groupCheckbox) {
            groupCheckbox.addEventListener('change', function() {
                let group = this.getAttribute('data-group');
                let checkboxes = document.querySelectorAll('input[data-group="' + group + '"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = groupCheckbox.checked;
                });
            });
        });
    });

   function toggleCheckboxes() {
        var checkboxes = document.getElementsByClassName('form-check-input');
        var isChecked = checkboxes[0].checked;

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = !isChecked;
        }
    }
</script>