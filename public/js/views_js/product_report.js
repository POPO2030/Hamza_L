
// document.addEventListener("DOMContentLoaded", function() {
//     document.getElementById('create').addEventListener('submit', function(event) {
//       event.preventDefault();
  

//       var product_id = document.getElementById('product_id').value;

//       var isValid = true;

//       if (product_id === '') {
//         document.getElementById('product_id-error').innerHTML = 'عفوآ...يجب اختيار العميل';
//         document.getElementById('product_id-container').style.border = '1px solid';
//         document.getElementById('product_id-container').style.borderColor = 'red';
//         isValid = false;
//       } else {
//         document.getElementById('product_id-error').innerHTML = '';
//         document.getElementById('product_id-container').style.border = '';
//         document.getElementById('product_id-container').style.borderColor = '';
//       }
  
  
//       if (isValid) {
//         var submitButton = this.querySelector('input[type=submit]');
//         submitButton.disabled = true;
//         this.submit();
//       }
//     });
  
//     document.addEventListener('keyup', function(e) {
//       if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
//         document.querySelector('.save').click();
//       }
//     });
  

//   });

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('create').addEventListener('submit', function(event) {
      event.preventDefault();
  
      var product_id = document.getElementById('product_id').value;
      var isValid = true;
  
      if (product_id === '') {
        document.getElementById('product_id-error').innerHTML = 'عفوآ...يجب اختيار العميل';
        document.getElementById('product_id-container').style.border = '1px solid red';
        isValid = false;
      } else {
        document.getElementById('product_id-error').innerHTML = '';
        document.getElementById('product_id-container').style.border = '';
      }
  
      if (isValid) {
        var submitButton = document.getElementsByClassName('save'); // Find the submit button by its ID
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
  
  
  
  
  
  
  
  
    