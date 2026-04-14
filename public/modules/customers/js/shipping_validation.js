$('[name^="shipping"]').filter('input[name$="[first_name]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping first name is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[last_name]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping last name is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[email]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping email is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[phone]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping phone is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[city]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping city is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[country]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping country is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[area]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping area is required')}}"}
    });
});
$('[name^="shipping"]').filter('input[name$="[zip_code]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping zipcode is required')}}"}
    });
});

$('[name^="shipping"]').filter('input[name$="[address]"]').each(function() {
    $(this).rules("add", {required: true, messages: {required: "{{__('shipping address is required')}}"}
    });
});
