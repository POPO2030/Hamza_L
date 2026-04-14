  
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("description_name").focus();
      document.getElementById('create').addEventListener('submit', function(event) {
        event.preventDefault();
    
        var unitsName = document.getElementById('description_name').value;
    
        var isValid = true;
    
        if (unitsName === '' || unitsName.length < 1 || unitsName.length > 50) {
          document.getElementById('description_name-error').innerHTML = 'يجب إدخال وصف المنتج وأن لا يقل عن 1 حرف ولا يزيد عن 50 حرف';
          document.getElementById('description_name').style.borderColor = 'red';
          isValid = false;
        } else {
          document.getElementById('description_name-error').innerHTML = '';
          document.getElementById('description_name').style.borderColor = '';
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
    
      document.getElementById('description_name').addEventListener('blur', function() {
        var unitsName = this.value;
        if (unitsName.length < 1 || unitsName.length > 50) {
          document.getElementById('description_name-error').innerHTML = 'يجب إدخال وصف المنتج وأن لا يقل عن 1 حرف ولا يزيد عن 50 حرف';
          this.style.borderColor = 'red';
        } else {
          document.getElementById('description_name-error').innerHTML = '';
          this.style.borderColor = '';
        }
      });
    

    });
    
      
      