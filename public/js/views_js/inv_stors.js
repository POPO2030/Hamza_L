document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var storesName = document.getElementById('stores_name').value;
 
    var isValid = true;

    if (storesName === ''|| storesName.length < 2 || storesName.length > 50) {
      document.getElementById('stores_name-error').innerHTML = 'يجب إدخال اسم المخزن وان لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
      document.getElementById('stores_name').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('stores_name-error').innerHTML = '';
      document.getElementById('stores_name').style.borderColor = '';
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

  // document.getElementById('stores_name').addEventListener('blur', function() {
  //   var storesName = this.value;
  //   if (storesName.length < 1 || storesName.length > 50) {
  //     document.getElementById('stores_name-error').innerHTML = 'يجب إدخال اسم المخزن وان لا يقل عن 2 حرف ولا يزيد عن 50 حرف';
  //     this.style.borderColor = 'red';
  //   } else {
  //     document.getElementById('stores_name-error').innerHTML = '';
  //     this.style.borderColor = '';
  //   }
  // });
  function removeError(element) {
    element.style.borderColor = 'none';
  }
});

