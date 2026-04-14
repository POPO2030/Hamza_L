
 document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var productid = document.getElementById('product_id').value;
    var final_count = document.getElementById('final_count').value;
    var receivables = document.getElementById('receivables').value;
    var customerid = document.getElementById('customer_id').value;
    var workOrderid = document.getElementById('workOrder_id').value;

    var isValid = true;

    if (customerid === '') {
      document.getElementById('customer_id-error').innerHTML = 'عفوآ...يجب اختيار اسم العميل';
      document.getElementById('customer_id-container').style.border = '1px solid';
      document.getElementById('customer_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('customer_id-error').innerHTML = '';
      document.getElementById('customer_id-container').style.border = 'none';
      document.getElementById('customer_id-container').style.borderColor = 'none';
    }
    if (productid === '') {
      document.getElementById('product_id-error').innerHTML = 'عفوآ...يجب اختيار نوع الصنف';
      document.getElementById('product_id-container').style.border = '1px solid';
      document.getElementById('product_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('product_id-error').innerHTML = '';
      document.getElementById('product_id-container').style.border = 'none';
      document.getElementById('product_id-container').style.borderColor = 'none';
    }
    if (workOrderid === '') {
      document.getElementById('workOrder_id-error').innerHTML = 'عفوآ...يجب اختيار رقم الغسلة';
      document.getElementById('workOrder_id-container').style.border = '1px solid';
      document.getElementById('workOrder_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('workOrder_id-error').innerHTML = '';
      document.getElementById('workOrder_id-container').style.border = 'none';
      document.getElementById('workOrder_id-container').style.borderColor = 'none';
    }

    if (final_count.length < 1 || final_count.length > 5) {
      document.getElementById('final_count-error').innerHTML = 'يجب إدخال العدد و لا يقل عن  رقم ولا يزيد عن 5 ارقام';
      document.getElementById('final_count').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('final_count-error').innerHTML = '';
      document.getElementById('final_count').style.borderColor = '';
    }

    if (receivables === '') {
      document.getElementById('receivables-error').innerHTML = 'عفوآ...يجب اختيار جهه التسليم';
      document.getElementById('receivables-container').style.border = '1px solid';
      document.getElementById('receivables-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('receivables-error').innerHTML = '';
      document.getElementById('receivables-container').style.border = '';
      document.getElementById('receivables-container').style.borderColor = '';
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



  document.getElementById('final_count').addEventListener('blur', function() {
    var final_count = this.value;
    if (final_count.length < 1 || final_count.length > 5) {
      document.getElementById('final_count-error').innerHTML = 'يجب إدخال العدد و لا يقل عن  رقم ولا يزيد عن 5 ارقام';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('final_count-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });
  function removeError(element) {
    element.style.borderColor = 'none';
  }
});
// -------------------------------------------------------------------
function handleProductChange() {
    var productSelect = document.getElementById('product_id');
    var productid = productSelect.value;

    if (productid === '') {
      document.getElementById('product_id-error').innerHTML = 'عفوآ...يجب اختيار نوع الصنف';
      document.getElementById('product_id-container').style.border = '1px solid';
      document.getElementById('product_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('product_id-error').innerHTML = '';
      document.getElementById('product_id-container').style.border = 'none';
      document.getElementById('product_id-container').style.borderColor = 'none';
    }
  }
  
    function handleProductChange1() {
    var receivablesSelect = document.getElementById('receivables');
    var receivables = receivablesSelect.value;
    if (receivables === '') {
      document.getElementById('receivables-error').innerHTML = 'عفوآ...يجب اختيار جهه التسليم';
      document.getElementById('receivables-container').style.border = '1px solid';
      document.getElementById('receivables-container').style.borderColor = 'red';
    } else {
      document.getElementById('receivables-error').innerHTML = '';
      document.getElementById('receivables-container').style.border = '';
      document.getElementById('receivables-container').style.borderColor = '';
    }

  }
    function handleCustomerChange() {
    var customersSelect = document.getElementById('customer_id');
    var customers = customersSelect.value;
    if (customers === '') {
      document.getElementById('customer_id-error').innerHTML = 'عفوآ...يجب اختيار جهه التسليم';
      document.getElementById('customer_id-container').style.border = '1px solid';
      document.getElementById('customer_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('customer_id-error').innerHTML = '';
      document.getElementById('customer_id-container').style.border = '';
      document.getElementById('customer_id-container').style.borderColor = '';
    }

  }
    function handleWorkOrdersChange() {
    var workOrdersSelect = document.getElementById('workOrder_id');
    var workOrders = workOrdersSelect.value;
    if (workOrders === '') {
      document.getElementById('workOrder_id-error').innerHTML = 'عفوآ...يجب اختيار رقم الغسلة';
      document.getElementById('workOrder_id-container').style.border = '1px solid';
      document.getElementById('workOrder_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('workOrder_id-error').innerHTML = '';
      document.getElementById('workOrder_id-container').style.border = '';
      document.getElementById('workOrder_id-container').style.borderColor = '';
    }

  }

  // -----------------------------------------------------------------
