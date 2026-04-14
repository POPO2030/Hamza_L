document.addEventListener("DOMContentLoaded", function() {

  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var date_in = document.getElementById('date_in').value;

    var supplier_id = document.getElementById('supplier_id').value;
    var empTable = document.getElementById('empTable');
    if (empTable) {
    var tableRows = empTable.getElementsByTagName('tr');
    }
    var isValid = true;

    if (date_in === '') {
      document.getElementById('date_in-error').innerHTML = 'عفوآ...يجب إدخال تاريخ الاستلام';
      document.getElementById('date_in').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('date_in-error').innerHTML = '';
      document.getElementById('date_in').style.borderColor = '';
    }

   

    if (supplier_id === '') {
      document.getElementById('supplier_id-error').innerHTML = 'عفوآ...يجب اختيار المورد';
      document.getElementById('supplier_id-container').style.border = '1px solid';
      document.getElementById('supplier_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('supplier_id-error').innerHTML = '';
      document.getElementById('supplier_id-container').style.border = '';
      document.getElementById('supplier_id-container').style.borderColor = '';
    }

  


    if (empTable) {
    if (tableRows.length <= 1) {
      isValid = false;
      var validationMessage = document.getElementById("validationMessage");
          validationMessage.innerText = "عفوآ...يجب إضافة صنف على الاقل الى الجدول قبل الحفظ";
    }
  }

  // Check each element with class "item_id" for emptiness
  var itemIdElements = document.getElementsByClassName("item_id");
  for (var i = 0; i < itemIdElements.length; i++) {
    var itemIdElement = itemIdElements[i];
    if (itemIdElement.value === "") {
      itemIdElement.style.borderColor = "red";
      isValid = false;
      var errorMessage = document.createElement("span");
      errorMessage.className = "error-message";
      errorMessage.innerHTML = "عفوآ...يجب اختيار الصنف";
      errorMessage.style.color = "red";
      var existingErrorMessage = itemIdElement.parentNode.querySelector(
        ".error-message"
      );
      if (!existingErrorMessage) {
        itemIdElement.parentNode.appendChild(errorMessage);
      }
    } else {
      itemIdElement.style.borderColor = "";
      var existingErrorMessage = itemIdElement.parentNode.querySelector(
        ".error-message"
      );
      if (existingErrorMessage) {
        itemIdElement.parentNode.removeChild(existingErrorMessage);
      }
    }
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
      errorMessage.innerHTML = "عفوآ...هذا الحقل مطلوب";
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
  

  // Check each element with class "item_quantity" for emptiness
  var itemQuantityElements = document.getElementsByClassName("item_quantity");
        var isValid = true;

        for (var j = 0; j < itemQuantityElements.length; j++) {
            var itemQuantityElement = itemQuantityElements[j];
            if (itemQuantityElement.value === "" || itemQuantityElement.value === "0") {
                itemQuantityElement.style.borderColor = "red";
                isValid = false;

                var existingErrorMessage = itemQuantityElement.parentNode.querySelector(".error-message");
                if (!existingErrorMessage) {
                    var errorMessage = document.createElement("span");
                    errorMessage.className = "error-message";
                    errorMessage.innerHTML = "عفوآ...يجب ادخال العدد";
                    errorMessage.style.color = "red";
                    itemQuantityElement.parentNode.appendChild(errorMessage);
                }
            } else {
                itemQuantityElement.style.borderColor = "";

                var existingErrorMessage = itemQuantityElement.parentNode.querySelector(".error-message");
                if (existingErrorMessage) {
                    itemQuantityElement.parentNode.removeChild(existingErrorMessage);
                }
            }
        }

      // Check each element with class "store_id" for emptiness
  var store_IdElements = document.getElementsByClassName("store_id");
  for (var i = 0; i < store_IdElements.length; i++) {
    var unitIdElement = store_IdElements[i];
    if (unitIdElement.value === "") {
      unitIdElement.style.borderColor = "red";
      isValid = false;
      var errorMessage = document.createElement("span");
      errorMessage.className = "error-message";
      errorMessage.innerHTML = "عفوآ...يجب اختيار المخزن";
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

  document.getElementById('date_in').addEventListener('blur', function() {
    var date_in = this.value;
    if (date_in === '') {
      document.getElementById('date_in-error').innerHTML = 'عفوآ...يجب إدخال تاريخ الاستلام';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('date_in-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });
  
  function removeError(element) {
    element.style.borderColor = 'none';
  }
});


function handleProductChange2() {
  var supplier_idSelect = document.getElementById('supplier_id').value;
  if (supplier_idSelect === '') {
    document.getElementById('supplier_id-error').innerHTML = 'عفوآ...يجب اختيار المورد';
    document.getElementById('supplier_id-container').style.border = '1px solid';
    document.getElementById('supplier_id-container').style.borderColor = 'red';
  } else {
    document.getElementById('supplier_id-error').innerHTML = '';
    document.getElementById('supplier_id-container').style.border = '';
    document.getElementById('supplier_id-container').style.borderColor = '';
  }
}






  