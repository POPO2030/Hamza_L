
 document.addEventListener("DOMContentLoaded", function() {
 
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var productid = document.getElementById('product_id').value;
    var customers = document.getElementById('customer_id').value;
    var count = document.getElementById('count').value;
    var fabric_source_id = document.getElementById('fabric_source_id').value;
    var fabric_id = document.getElementById('fabric_id').value;
  
    var isValid = true;


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
    if (customers === '') {
      document.getElementById('customer_id-error').innerHTML = 'عفوآ...يجب اختيار اسم العميل';
      document.getElementById('customer_id-container').style.border = '1px solid';
      document.getElementById('customer_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('customer_id-error').innerHTML = '';
      document.getElementById('customer_id-container').style.border = 'none';
      document.getElementById('customer_id-container').style.borderColor = 'none';
    }

    if (fabric_source_id === '') {
      document.getElementById('fabric_source_id-error').innerHTML = 'عفوًا... يجب اختيار مصدر القماش';
      document.getElementById('fabric_source_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('fabric_source_id-error').innerHTML = '';
      document.getElementById('fabric_source_id-container').style.border = '';
    }

    if (fabric_id === '') {
      document.getElementById('fabric_id-error').innerHTML = 'عفوًا... يجب اختيار الخامة';
      document.getElementById('fabric_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('fabric_id-error').innerHTML = '';
      document.getElementById('fabric_id-container').style.border = '';
    }

    if (count.length < 1 || count.length > 2) {
      document.getElementById('count-error').innerHTML = 'يجب إدخال عدد القطع وأن لا يقل عن  رقم ولا يزيد عن رقمين';
      document.getElementById('count').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('count-error').innerHTML = '';
      document.getElementById('count').style.borderColor = '';
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

  document.getElementById('count').addEventListener('blur', function() {
    var count = this.value;
    if (count.length < 1 || count.length > 2) {
      document.getElementById('count-error').innerHTML = 'يجب إدخال عدد القطع وأن لا يقل عن  رقم ولا يزيد عن رقمين ';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('count-error').innerHTML = '';
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
  
    function handleCustomerChange() {
    var customersSelect = document.getElementById('customer_id');
    var customers = customersSelect.value;
    if (customers === '') {
      document.getElementById('customer_id-error').innerHTML = 'عفوآ...يجب اختيار اسم العميل';
      document.getElementById('customer_id-container').style.border = '1px solid';
      document.getElementById('customer_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('customer_id-error').innerHTML = '';
      document.getElementById('customer_id-container').style.border = '';
      document.getElementById('customer_id-container').style.borderColor = '';
    }

  }

  function handleFabric_sourcesChange() {
    var fabric_source_idSelect = document.getElementById('fabric_source_id');
    var fabric_source_id = fabric_source_idSelect.value;
  
    if (fabric_source_id === '') {
      document.getElementById('fabric_source_id-error').innerHTML = 'عفوآ...يجب اختيار مصدر القماش';
      document.getElementById('fabric_source_id-container').style.border = '1px solid';
      document.getElementById('fabric_source_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('fabric_source_id-error').innerHTML = '';
      document.getElementById('fabric_source_id-container').style.border = 'none';
      document.getElementById('fabric_source_id-container').style.borderColor = 'none';
    }
  }
  
  function handleFabricsChange() {
    var fabric_idSelect = document.getElementById('fabric_id');
    var fabric_id = fabric_idSelect.value;
  
    if (fabric_id === '') {
      document.getElementById('fabric_id-error').innerHTML = 'عفوآ...يجب اختيار مصدر القماش';
      document.getElementById('fabric_id-container').style.border = '1px solid';
      document.getElementById('fabric_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('fabric_id-error').innerHTML = '';
      document.getElementById('fabric_id-container').style.border = 'none';
      document.getElementById('fabric_id-container').style.borderColor = 'none';
    }
  }

  // -----------------------------------------------------------------


