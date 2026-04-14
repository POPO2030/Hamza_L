document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var credit_text = document.getElementById('credit').value;
    var debit_text = document.getElementById('debit').value;
 
    var isValid = true;

    if ( credit_text < 1 && debit_text < 1 ) {

      document.getElementById('credit-error').innerHTML = 'يجب ادخال مبلغ';
      document.getElementById('credit').style.borderColor = 'red';
      document.getElementById('debit-error').innerHTML = 'يجب ادخال مبلغ';
      document.getElementById('debit').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('credit-error').innerHTML = '';
      document.getElementById('credit').style.borderColor = '';
      document.getElementById('debit-error').innerHTML = '';
      document.getElementById('debit').style.borderColor = '';
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

 

});

