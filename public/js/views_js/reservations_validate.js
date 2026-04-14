
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('create').addEventListener('submit', function(event) {
      event.preventDefault();
  
      
      var customerid = document.getElementById('customer_id').value;
      var productid = document.getElementById('product_id').value;
      var initialcount = document.getElementById('initial_product_count').value;
      var receivables = document.getElementById('receivables').value;
      var service_itemid = document.getElementById('service_item_id').value;
      
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
  
      if (initialcount.length < 1 || initialcount.length > 5) {
        document.getElementById('initial_product_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
        document.getElementById('initial_product_count').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('initial_product_count-error').innerHTML = '';
        document.getElementById('initial_product_count').style.borderColor = '';
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

      if (service_itemid === '') {
        document.getElementById('service_item_id-error').innerHTML = 'عفوًا... يجب اختيار خدمة واحدة على الأقل';
        document.getElementById('service_item_id-container').style.border = '1px solid red';
        isValid = false;
      } else {
        document.getElementById('service_item_id-error').innerHTML = '';
        document.getElementById('service_item_id-container').style.border = '';
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
  
  
  
    document.getElementById('initial_product_count').addEventListener('blur', function() {
      var initialcount = this.value;
      if (initialcount.length < 1 || initialcount.length > 5) {
        document.getElementById('initial_product_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
        this.style.borderColor = 'red';
      } else {
        document.getElementById('initial_product_count-error').innerHTML = '';
        this.style.borderColor = '';
      }
    });

    
    function removeError(element) {
      element.style.borderColor = 'none';
    }
  });
  // -------------------------------------------------------------------
  function handleProductChange() {
    
    var customeridSelect = document.getElementById('customer_id');
    var customerid = customeridSelect.value;

    if (customerid === '') {
      document.getElementById('customer_id-error').innerHTML = 'عفوآ...يجب اختيار اسم العميل';
      document.getElementById('customer_id-container').style.border = '1px solid';
      document.getElementById('customer_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('customer_id-error').innerHTML = '';
      document.getElementById('customer_id-container').style.border = 'none';
      document.getElementById('customer_id-container').style.borderColor = 'none';
    }
  }

  function handleProductChange1() {
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

    function handleProductChange2() {
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

    function handleProductChange3() {
      var service_item_idSelect = document.getElementById('service_item_id');
      var service_itemid = service_item_idSelect.value;
  
      if (service_itemid === '') {
        document.getElementById('service_item_id-error').innerHTML = 'عفوآ...يجب اختيار اختيار خدمه واحده على الاقل';
        document.getElementById('service_item_id-container').style.border = '1px solid';
        document.getElementById('service_item_id-container').style.borderColor = 'red';
      } else {
        document.getElementById('service_item_id-error').innerHTML = '';
        document.getElementById('service_item_id-container').style.border = 'none';
        document.getElementById('service_item_id-container').style.borderColor = 'none';
      }

    }
  
    // -----------------------------------------------------------------
  