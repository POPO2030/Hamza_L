document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create').addEventListener('submit', function(event) {
        event.preventDefault();

        var fabric_source_name = document.getElementById('fabric_source_name').value;

        var isValid = true;

        if (fabric_source_name.length < 2 || fabric_source_name.length > 50) {
            document.getElementById('name-error').innerHTML = 'يجب إدخال  مصدر القماش وأن لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
            document.getElementById('fabric_source_name').style.borderColor = 'red';
            isValid = false;
        } else {
            document.getElementById('name-error').innerHTML = '';
            document.getElementById('fabric_source_name').style.borderColor = '';
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
    document.getElementById('fabric_source_name').addEventListener('blur', function() {
        var fabric_source_name = this.value;
        if (fabric_source_name.length < 2 || fabric_source_name.length > 50) {
            document.getElementById('name-error').innerHTML = 'يجب إدخال  مصدر القماش وان لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
            this.style.borderColor = 'red';
        } else {
            document.getElementById('name-error').innerHTML = '';
            this.style.borderColor = '';
        }
    });
});

function removeError(element) {
    element.style.borderColor = 'none';
}
