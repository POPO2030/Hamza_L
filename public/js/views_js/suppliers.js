document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create').addEventListener('submit', function(event) {
        event.preventDefault();

        var customerName = document.getElementById('suppliers_name').value;
        var phone = document.getElementById('phone').value;
        var isValid = true;

        if (customerName.length < 2 || customerName.length > 50) {
            document.getElementById('name-error').innerHTML = 'يجب إدخال اسم المورد وأن لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
            document.getElementById('suppliers_name').style.borderColor = 'red';
            isValid = false;
        } else {
            document.getElementById('name-error').innerHTML = '';
            document.getElementById('suppliers_name').style.borderColor = '';
        }

        if (isValid) {
            document.querySelector('input[type=submit]').disabled = true;
            this.submit();
        }
    });

    // تفعيل زر F2 إذا تم إدخال الخانات المطلوبة
    document.addEventListener('keyup', function(e) {
        if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
            document.querySelector('.save').click();
        }
    });

    // Validation on element blur
    // document.getElementById('suppliers_name').addEventListener('blur', function() {
    //     var customerName = this.value;
    //     if (customerName.length < 2 || customerName.length > 50) {
    //         document.getElementById('name-error').innerHTML = 'يجب إدخال اسم المورد وان لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
    //         this.style.borderColor = 'red';
    //     } else {
    //         document.getElementById('name-error').innerHTML = '';
    //         this.style.borderColor = '';
    //     }
    // });
});

function removeError(element) {
    element.style.borderColor = 'none';
}
