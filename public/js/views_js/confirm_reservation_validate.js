
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('create').addEventListener('submit', function(event) {
      event.preventDefault();
  
      
      var receipts = document.getElementById('receipts').value;
      var initialcount = document.getElementById('initial_product_count').value;
      var service_itemid = document.getElementById('service_item_id').value;
      
      var isValid = true;

      if (receipts === '') {
        document.getElementById('receipts-error').innerHTML = 'عفوآ...يجب اختيار اسم العميل';
        document.getElementById('receipts-container').style.border = '1px solid';
        document.getElementById('receipts-container').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('receipts-error').innerHTML = '';
        document.getElementById('receipts-container').style.border = 'none';
        document.getElementById('receipts-container').style.borderColor = 'none';
      }
  
  
      if (initialcount.length < 1 || initialcount.length > 5) {
        document.getElementById('initial_product_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
        document.getElementById('initial_product_count').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('initial_product_count-error').innerHTML = '';
        document.getElementById('initial_product_count').style.borderColor = '';
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
    
    var receiptsSelect = document.getElementById('receipts');
    var receipts = receiptsSelect.value;

    if (receipts === '') {
      document.getElementById('receipts-error').innerHTML = 'عفوآ...يجب اختيار اسم العميل';
      document.getElementById('receipts-container').style.border = '1px solid';
      document.getElementById('receipts-container').style.borderColor = 'red';
    } else {
      document.getElementById('receipts-error').innerHTML = '';
      document.getElementById('receipts-container').style.border = 'none';
      document.getElementById('receipts-container').style.borderColor = 'none';
    }
  }

    function handleProductChange1() {
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
  