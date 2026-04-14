document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('create').addEventListener('submit', function (event) {
      event.preventDefault();

      var fabric_name = document.getElementById('fabric_name').value;
      // var fabric_source_id = document.getElementById('fabric_source_id').value;


      var isValid = true;


      if (fabric_name.length < 2 || fabric_name.length > 50) {
        document.getElementById('name-error').innerHTML = 'يجب إدخال  اسم القماشة وأن لا تقل عن 2 حرف ولا تزيد عن 50 حرف';
        document.getElementById('fabric_name').style.borderColor = 'red';
        isValid = false;
      } else {
          document.getElementById('name-error').innerHTML = '';
          document.getElementById('fabric_name').style.borderColor = '';
      }

      // if (fabric_source_id === '') {
      //   document.getElementById('fabric_source_id-error').innerHTML = 'عفوآ...يجب اختيار مصدر القماش';
      //   document.getElementById('fabric_source_id-container').style.border = '1px solid';
      //   document.getElementById('fabric_source_id-container').style.borderColor = 'red';
      //   isValid = false;
      // } else {
      //   document.getElementById('fabric_source_id-error').innerHTML = '';
      //   document.getElementById('fabric_source_id-container').style.border = '';
      //   document.getElementById('fabric_source_id-container').style.borderColor = '';
      // }

      
  

      if (isValid) {
        var submitButton = this.querySelector('input[type=submit]');
        submitButton.disabled = true;
        this.submit();
      }
    });

    document.addEventListener('keyup', function (e) {
      if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
        document.querySelector('.save').click();
      }
    });

    // Validation on element blur
    document.getElementById('fabric_name').addEventListener('blur', function() {
      var fabric_name = this.value;
      if (fabric_name.length < 2 || fabric_name.length > 50) {
          document.getElementById('name-error').innerHTML = 'يجب إدخال  اسم القماشة وأن لا تقل عن 2 حرف ولا تزيد عن 50 حرف';
          this.style.borderColor = 'red';
      } else {
          document.getElementById('name-error').innerHTML = '';
          this.style.borderColor = '';
      }
    });
});

  function removeError(element) {
    element.style.borderColor = 'none';
  }

  
  // function handleFabric_sourcesChange() {
  //   var fabric_source_id = document.getElementById('fabric_source_id').value;
  //   if (fabric_source_id === '') {
  //     document.getElementById('fabric_source_id-error').innerHTML = 'عفوآ...يجب اختيار مصدر القماش';
  //     document.getElementById('fabric_source_id-container').style.border = '1px solid';
  //     document.getElementById('fabric_source_id-container').style.borderColor = 'red';
  //   } else {
  //     document.getElementById('fabric_source_id-error').innerHTML = '';
  //     document.getElementById('fabric_source_id-container').style.border = '';
  //     document.getElementById('fabric_source_id-container').style.borderColor = '';
  //   }
  // }
