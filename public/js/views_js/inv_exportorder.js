document.addEventListener("DOMContentLoaded", function() {

  document.getElementById('create').addEventListener('submit', function(event) {
    event.preventDefault();

    var dateOut = document.getElementById('date_out').value;
    var work_order_id = document.getElementById('work_order_id').value;
    var empTable = document.getElementById('empTable');
    
    if (empTable) {
    var tableRows = empTable.getElementsByTagName('tr');
    }

    var isValid = true;

    if (dateOut === '') {
      document.getElementById('date_out-error').innerHTML = 'عفوآ...يجب إدخال تاريخ الصرف';
      document.getElementById('date_out').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('date_out-error').innerHTML = '';
      document.getElementById('date_out').style.borderColor = '';
    }

    if (work_order_id === '') {
      document.getElementById('work_order_id-error').innerHTML = 'عفوآ...يجب الاختيار من يصرف الى';
      document.getElementById('work_order_id-container').style.border = '1px solid';
      document.getElementById('work_order_id-container').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('work_order_id-error').innerHTML = '';
      document.getElementById('work_order_id-container').style.border = '';
      document.getElementById('work_order_id-container').style.borderColor = '';
    }
  

  if (empTable) {
// if (tableRows.length <= 1) {
  if (tableRows.length < 2) {
    isValid = false;
  
    var existingErrorMessage = empTable.parentNode.querySelector(".error-message");
    if (existingErrorMessage) {
      empTable.parentNode.removeChild(existingErrorMessage);
    }
  
    var errorMessage = document.createElement('span');
    errorMessage.className = "error-message";
    errorMessage.innerText = "عفوآ...يجب إضافة صنف على الاقل الى الجدول قبل الحفظ";
    errorMessage.style.color = "red";
  
    empTable.parentNode.insertBefore(errorMessage, empTable.nextSibling);
  }else{

          // Check each element with class "unit_id" for emptiness
    var item_IdElements = document.getElementsByClassName("item_id");
    for (var i = 0; i < item_IdElements.length; i++) {
      var itemIdElement = item_IdElements[i];
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
    for (var z = 0; z < unitIdElements.length; z++) {
      var unitIdElement = unitIdElements[z];
      if (unitIdElement.value === "") {
        unitIdElement.style.borderColor = "red";
        isValid = false;
        var errorMessage = document.createElement("span");
        errorMessage.className = "error-message";
        errorMessage.innerHTML = "عفوآ...يجب ادخال الوحده";
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

            // Check each element with class "supplier_id" for emptiness
        var supplier_idElements = document.getElementsByClassName("supplier_id");
        for (var x = 0; x < supplier_idElements.length; x++) {
        var supplierIdElement = supplier_idElements[x];
        if (supplierIdElement.value === "") {
          supplierIdElement.style.borderColor = "red";
          isValid = false;
          var errorMessage = document.createElement("span");
          errorMessage.className = "error-message";
          errorMessage.innerHTML = "عفوآ...يجب اختيار المورد";
          errorMessage.style.color = "red";
          var existingErrorMessage = supplierIdElement.parentNode.querySelector(
          ".error-message"
          );
          if (!existingErrorMessage) {
          supplierIdElement.parentNode.appendChild(errorMessage);
          }
        } else {
          supplierIdElement.style.borderColor = "";
          var existingErrorMessage = supplierIdElement.parentNode.querySelector(
          ".error-message"
          );
          if (existingErrorMessage) {
            supplierIdElement.parentNode.removeChild(existingErrorMessage);
          }
        }
    
        }


                  // Check each element with class "store_id" for emptiness
    var store_idElements = document.getElementsByClassName("store_id");
    for (var i = 0; i < store_idElements.length; i++) {
      var store_idElement = store_idElements[i];
      if (store_idElement.value === "") {
        store_idElement.style.borderColor = "red";
        isValid = false;
        var errorMessage = document.createElement("span");
        errorMessage.className = "error-message";
        errorMessage.innerHTML = "عفوآ...يجب اختيار المخزن";
        errorMessage.style.color = "red";
        var existingErrorMessage = store_idElement.parentNode.querySelector(
          ".error-message"
        );
        if (!existingErrorMessage) {
          store_idElement.parentNode.appendChild(errorMessage);
        }
      } else {
        store_idElement.style.borderColor = "";
        var existingErrorMessage = store_idElement.parentNode.querySelector(
          ".error-message"
        );
        if (existingErrorMessage) {
          store_idElement.parentNode.removeChild(existingErrorMessage);
        }
      }
    }


  }
  }


    if (isValid) {
      var submitButton = this.querySelector('input[type=submit]');
      console.error(this);
      submitButton.disabled = true;
      this.submit();
    }
  });

  document.addEventListener('keyup', function(e) {
    if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
      document.querySelector('.save').click();
    }
  });

  document.getElementById('date_out').addEventListener('blur', function() {
    var dateOut = this.value;
    if (dateOut === '') {
      document.getElementById('date_out-error').innerHTML = 'عفوآ...يجب إدخال تاريخ الصرف';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('date_out-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });
  
});

function handleProductChange1() {
  var work_order_idSelect = document.getElementById('work_order_id').value;
  if (work_order_idSelect === '') {
    document.getElementById('work_order_id-error').innerHTML = 'عفوآ...يجب اختيار مجموعه المنتجات';
    document.getElementById('work_order_id-container').style.border = '1px solid';
    document.getElementById('work_order_id-container').style.borderColor = 'red';
  } else {
    document.getElementById('work_order_id-error').innerHTML = '';
    document.getElementById('work_order_id-container').style.border = '';
    document.getElementById('work_order_id-container').style.borderColor = '';
  }
}








