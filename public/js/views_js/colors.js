  
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("color_name").focus();
    document.getElementById('create').addEventListener('submit', function(event) {
      event.preventDefault();
  
      var unitsName = document.getElementById('color_name').value;
      var colorCategory_id = document.getElementById('colorCategory_id').value;
  
      var isValid = true;
  
      if (unitsName === '' || unitsName.length < 1 || unitsName.length > 50) {
        document.getElementById('color_name-error').innerHTML = 'يجب إدخال اسم اللون وأن لا يقل عن 1 حرف ولا يزيد عن 50 حرف';
        document.getElementById('color_name').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('color_name-error').innerHTML = '';
        document.getElementById('color_name').style.borderColor = '';
      }
  
      if (colorCategory_id === '') {
        document.getElementById('colorCategory_id-error').innerHTML = 'عفوآ...يجب اختيار مجموعه الالوان';
        document.getElementById('colorCategory_id-container').style.border = '1px solid';
        document.getElementById('colorCategory_id-container').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('colorCategory_id-error').innerHTML = '';
        document.getElementById('colorCategory_id-container').style.border = '';
        document.getElementById('colorCategory_id-container').style.borderColor = '';
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
  
    document.getElementById('color_name').addEventListener('blur', function() {
      var unitsName = this.value;
      if (unitsName.length < 1 || unitsName.length > 50) {
        document.getElementById('color_name-error').innerHTML = 'يجب إدخال اسم اللون وأن لا يقل عن 1 حرف ولا يزيد عن 50 حرف';
        this.style.borderColor = 'red';
      } else {
        document.getElementById('color_name-error').innerHTML = '';
        this.style.borderColor = '';
      }
    });
  
    function removeError(element) {
      element.style.borderColor = 'initial';
    }
  });
  function handleProductChange1() {
    var categoryidSelect = document.getElementById('colorCategory_id').value;
    if (categoryidSelect === '') {
      document.getElementById('colorCategory_id-error').innerHTML = 'عفوآ...يجب اختيار مجموعه الالوان';
      document.getElementById('colorCategory_id-container').style.border = '1px solid';
      document.getElementById('colorCategory_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('colorCategory_id-error').innerHTML = '';
      document.getElementById('colorCategory_id-container').style.border = '';
      document.getElementById('colorCategory_id-container').style.borderColor = '';
    }
  }
    
    