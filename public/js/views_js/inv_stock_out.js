document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('create').addEventListener('submit', function(event) {
      event.preventDefault();
  
      var dateOut = document.getElementById('date_out').value;
      var empTable = document.getElementById('empTable');
      var tableRows = empTable.getElementsByTagName('tr');
   
      var isValid = true;
  
      if (dateOut === '') {
        document.getElementById('date_out-error').innerHTML = 'عفوآ...يجب إدخال تاريخ الصرف';
        document.getElementById('date_out').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('date_out-error').innerHTML = '';
        document.getElementById('date_out').style.borderColor = '';
      }
  
      if (tableRows.length <= 1) {
        isValid = false;
        var validationMessage = document.getElementById("validationMessage");
            validationMessage.innerText = "عفوآ...يجب إضافة صنف على الاقل الى الجدول قبل الحفظ";
      }


                // Check each element with class "unit_id" for emptiness
                var unitIdElements = document.getElementsByClassName("unit_id");
                for (var i = 0; i < unitIdElements.length; i++) {
                var unitIdElement = unitIdElements[i];
               if (unitIdElement.value === "") {
                unitIdElement.style.borderColor = "red";
                isValid = false;
                var errorMessage = document.createElement("span");
                errorMessage.className = "error-message";
                errorMessage.innerHTML = "عفوآ...يجب اختيار الوحده";
                errorMessage.style.color = "red";
                var existingErrorMessage = unitIdElement.parentNode.querySelector(
                 ".error-message"
               );
               if (!existingErrorMessage) {
                 unitIdElement.parentNode.appendChild(errorMessage);
               }
              } else {
               unitIdElement.style.borderColor = "";
               var existingErrorMessage = unitIdElement.parentNode.querySelector(
                 ".error-message"
               );
               if (existingErrorMessage) {
                 unitIdElement.parentNode.removeChild(existingErrorMessage);
               }
             }
           }
             
           var itemQuantityElements = document.getElementsByClassName("item_quantity");
           for (var j = 0; j < itemQuantityElements.length; j++) {
             var itemQuantityElement = itemQuantityElements[j];
           
             // Clear any existing error messages
             var existingErrorMessage = itemQuantityElement.parentNode.querySelector(
               ".error-message"
             );
             if (existingErrorMessage) {
               itemQuantityElement.parentNode.removeChild(existingErrorMessage);
             }
           
             if (itemQuantityElement.value === "") {
               itemQuantityElement.style.borderColor = "red";
               isValid = false;
               var errorMessage = document.createElement("span");
               errorMessage.className = "error-message";
               errorMessage.innerHTML = "عفوآ...يجب ادخال العدد";
               errorMessage.style.color = "red";
               itemQuantityElement.parentNode.appendChild(errorMessage);
             } else if(itemQuantityElement.value > "99999999" || itemQuantityElement.value < "0"){
                 itemQuantityElement.style.borderColor = "red";
                 isValid = false;
                 var errorMessage = document.createElement("span");
                 errorMessage.className = "error-message";
                 errorMessage.innerHTML = "عفوآ...يجب ادخال قيمه صحيحه";
                 errorMessage.style.color = "red";
                 itemQuantityElement.parentNode.appendChild(errorMessage);
           }else {
               itemQuantityElement.style.borderColor = "";
             }
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
  
    // document.getElementById('date_out').addEventListener('blur', function() {
    //   var dateOut = this.value;
    //   if (dateOut === '') {
    //     document.getElementById('date_out-error').innerHTML = 'عفوآ...يجب إدخال تاريخ الصرف';
    //     this.style.borderColor = 'red';
    //   } else {
    //     document.getElementById('date_out-error').innerHTML = '';
    //     this.style.borderColor = '';
    //   }
    // });
    
    function removeError(element) {
      element.style.borderColor = 'none';
    }
  });
  






  