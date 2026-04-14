
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById('create').addEventListener('submit', function (event) {
      event.preventDefault();

      var isValid = true; // Flag to track overall form validity
      var errorMessage = ''; // To accumulate SweetAlert error messages

      var store_out = document.getElementById('store_out').value;
      var store_in = document.getElementById('store_in').value;
      var empTable = document.getElementById('empTable');
      var tableRows = empTable.getElementsByTagName('tr');

      // Validate `store_out`
      if (store_out === '') {
          document.getElementById('store_out-error').innerHTML = 'عفوآ...يجب اختيار المخزن المرسل منه';
          document.getElementById('store_out-container').style.border = '1px solid red';
          isValid = false;
      } else {
          document.getElementById('store_out-error').innerHTML = '';
          document.getElementById('store_out-container').style.border = 'none';
      }

      // Validate `store_in`
      if (store_in === '') {
          document.getElementById('store_in-error').innerHTML = 'عفوآ...يجب اختيار المخزن المرسل اليه';
          document.getElementById('store_in-container').style.border = '1px solid red';
          isValid = false;
      } else {
          document.getElementById('store_in-error').innerHTML = '';
          document.getElementById('store_in-container').style.border = 'none';
      }

      // Validate table rows
      if (tableRows.length <= 1) {
          document.getElementById("validationMessage").innerText = "يجب إضافة صنف على الأقل إلى الجدول قبل الحفظ.";
          isValid = false;
      } else {
          for (var i = 0; i < tableRows.length; i++) {
              var row = tableRows[i];
              var itemQuantity = row.querySelector('.item_quantity');
              var stockQuantity = row.querySelector('.stock_quantity');
              var itemIdSelect = row.querySelector('.item_id');

              if (itemQuantity && stockQuantity && itemIdSelect) {
                  var itemQuantityValue = parseFloat(itemQuantity.value) || 0;
                  var stockQuantityValue = parseFloat(stockQuantity.value) || 0;
                  var selectedItemName = itemIdSelect.options[itemIdSelect.selectedIndex]?.text || "غير محدد";

                  if (itemQuantityValue > stockQuantityValue) {
                      errorMessage += `الكمية المطلوبة أكبر من الكمية المتاحة في المخزن للمنتج: <span style="color: red;">${selectedItemName}</span><br>`;
                      isValid = false;
                  }
              }
          }
      }

      // Validate required fields dynamically (e.g., item_id, unit_id, etc.)
      ['item_id', 'unit_id', 'item_quantity', 'stock_quantity', 'supplier_id'].forEach(function (className) {
          var elements = document.getElementsByClassName(className);
          for (var i = 0; i < elements.length; i++) {
              var element = elements[i];
              if (element.value === "" || element.value === "0") {
                  element.style.borderColor = "red";
                  isValid = false;
                  var error = element.parentNode.querySelector(".error-message");
                  if (!error) {
                      var errorMessageElement = document.createElement("span");
                      errorMessageElement.className = "error-message";
                      errorMessageElement.innerHTML = `يجب إدخال الحقل`;
                      errorMessageElement.style.color = "red";
                      element.parentNode.appendChild(errorMessageElement);
                  }
              } else {
                  element.style.borderColor = "";
                  var existingErrorMessage = element.parentNode.querySelector(".error-message");
                  if (existingErrorMessage) {
                      existingErrorMessage.remove();
                  }
              }
          }
      });

      // Show SweetAlert if there are errors
      if (!isValid && errorMessage !== '') {
          Swal.fire({
              icon: 'error',
              title: 'تحذير',
              html: errorMessage,
          });
      }

      // Submit the form if everything is valid
      if (isValid) {
          var submitButton = this.querySelector('input[type=submit]');
          submitButton.disabled = true;
          this.submit();
      }
  });

  // Enable F2 shortcut for saving
  document.addEventListener('keyup', function (e) {
      if (e.key === 'F2' && document.getElementById('create').checkValidity()) {
          document.querySelector('.save').click();
      }
  });
});

  // -------------------------------------------------------------------
function handleProductChange() {
  var store_outSelect = document.getElementById('store_out');
  var store_out = store_outSelect.value;

  if (store_out === '') {
    document.getElementById('store_out-error').innerHTML = 'عفوآ...يجب اختيار المخزن المرسل منه';
    document.getElementById('store_out-container').style.border = '1px solid';
    document.getElementById('store_out-container').style.borderColor = 'red';
  } else {
    document.getElementById('store_out-error').innerHTML = '';
    document.getElementById('store_out-container').style.border = 'none';
    document.getElementById('store_out-container').style.borderColor = 'none';
  }
}

  function handleProductChange1() {
  var store_inSelect = document.getElementById('store_in');
  var store_in = store_inSelect.value;
  if (store_in === '') {
    document.getElementById('store_in-error').innerHTML = 'عفوآ...يجب اختيار المخزن المرسل اليه';
    document.getElementById('store_in-container').style.border = '1px solid';
    document.getElementById('store_in-container').style.borderColor = 'red';
  } else {
    document.getElementById('store_in-error').innerHTML = '';
    document.getElementById('store_in-container').style.border = '';
    document.getElementById('store_in-container').style.borderColor = '';
  }

}

function addRow() {
  var empTab = document.getElementById('empTable');
  var rowCnt = empTab.rows.length;
  var tr = empTab.insertRow(rowCnt);

  // Rest of your code for adding rows here
}

function removeRow(oButton) {
  var empTab = document.getElementById('empTable');
  empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);
}
