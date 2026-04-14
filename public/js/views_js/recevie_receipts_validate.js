
 document.addEventListener("DOMContentLoaded", function() {
 
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var productid = document.getElementById('product_id').value;
    var initialcount = document.getElementById('initial_count').value;
    var receivables = document.getElementById('receivables').value;
    var product_type = document.getElementById('product_type').value;
    var imgInput = document.getElementById('img');

    var isValidImg = true;
    var isValid = true;

  if (imgInput.files.length === 0) {
    document.getElementById('errorSpan').innerHTML = 'عفوًا... يجب اختيار صورة واحدة على الأقل';
    isValidImg = false;
  } else {
    document.getElementById('errorSpan').innerHTML = '';
  }

    if (productid === '') {
      document.getElementById('product_id-error').innerHTML = 'عفوآ...يجب اختيار الصنف';
      document.getElementById('product_id-container').style.border = '1px solid';
      document.getElementById('product_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('product_id-error').innerHTML = '';
      document.getElementById('product_id-container').style.border = 'none';
      document.getElementById('product_id-container').style.borderColor = 'none';
    }

    if (product_type === '') {
      document.getElementById('product_type-error').innerHTML = 'عفوآ...يجب اختيار نوع الصنف';
      document.getElementById('product_type-container').style.border = '1px solid';
      document.getElementById('product_type-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('product_type-error').innerHTML = '';
      document.getElementById('product_type-container').style.border = '';
      document.getElementById('product_type-container').style.borderColor = '';
    }

    if (initialcount.length < 1 || initialcount.length > 5) {
      document.getElementById('initial_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
      document.getElementById('initial_count').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('initial_count-error').innerHTML = '';
      document.getElementById('initial_count').style.borderColor = '';
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

    if (isValid && isValidImg) {
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


  document.getElementById('img').addEventListener('blur', function() {
    var imgInput = this;
    var isValidImg = true;
    if (imgInput.files.length === 0) {
      document.getElementById('errorSpan').innerHTML = 'عفوًا... يجب اختيار صورة واحدة على الأقل';
      isValidImg = false;
    } else {
      document.getElementById('errorSpan').innerHTML = '';
    }
  });

  document.getElementById('initial_count').addEventListener('blur', function() {
    var initialcount = this.value;
    if (initialcount.length < 1 || initialcount.length > 5) {
      document.getElementById('initial_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('initial_count-error').innerHTML = '';
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
      document.getElementById('product_id-error').innerHTML = 'عفوآ...يجب اختيار الصنف';
      document.getElementById('product_id-container').style.border = '1px solid';
      document.getElementById('product_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('product_id-error').innerHTML = '';
      document.getElementById('product_id-container').style.border = 'none';
      document.getElementById('product_id-container').style.borderColor = 'none';
    }
  }

function handleProductTypeChange() {
    var productSelect = document.getElementById('product_type');
    var productid = productSelect.value;

    if (productid === '') {
      document.getElementById('product_type-error').innerHTML = 'عفوآ...يجب اختيار نوع الصنف';
      document.getElementById('product_type-container').style.border = '1px solid';
      document.getElementById('product_type-container').style.borderColor = 'red';
    } else {
      document.getElementById('product_type-error').innerHTML = '';
      document.getElementById('product_type-container').style.border = 'none';
      document.getElementById('product_type-container').style.borderColor = 'none';
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

  // -----------------------------------------------------------------


