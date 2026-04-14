document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var storesName = document.getElementById('total_contract_quantity').value;
    var work_order_id = document.getElementById('work_order_id').value;
 
    var isValid = true;

    if (storesName === ''|| storesName < 1) {
      document.getElementById('total_contract_quantity-error').innerHTML = 'يجب ادخال كمية الأوردر';
      document.getElementById('total_contract_quantity').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('total_contract_quantity-error').innerHTML = '';
      document.getElementById('total_contract_quantity').style.borderColor = '';
    }

    if (work_order_id === '') {
      document.getElementById('work_order_id-error').innerHTML = 'عفوآ...يجب اختيار الأوردر';
      document.getElementById('work_order_id-container').style.border = '1px solid';
      document.getElementById('work_order_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('work_order_id-error').innerHTML = '';
      document.getElementById('work_order_id-container').style.border = '';
      document.getElementById('work_order_id-container').style.borderColor = '';
    }


    if (isValid) {
      var submitButton = this.querySelector('input[type=submit]');
      submitButton.disabled = true;
      this.submit();
    }
  });

  document.addEventListener('keyup', function(e) {
    if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
      document.querySelector('.save').click();
    }
  });

  document.getElementById('total_contract_quantity').addEventListener('blur', function() {
    var storesName = this.value;
    if (storesName === ''|| storesName.length < 1 || storesName.length > 50) {
      document.getElementById('total_contract_quantity-error').innerHTML = 'يجب إدخال اسم المخزن وان لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('total_contract_quantity-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });

});

