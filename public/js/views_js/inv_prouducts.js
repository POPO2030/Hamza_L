document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('create').addEventListener('submit', function (event) {
      event.preventDefault();

      var productname = document.getElementById('product_name').value;
      var category_id = document.getElementById('category_id').value;
      var product_request = document.getElementById('product_request').value;
      var manual_code = document.getElementById('manual_code').value;
      var unit_id = document.getElementById('unit_id').value;
      var color_id = document.getElementById('color_id').value;




      var isValid = true;

      if (productname === '') {
        document.getElementById('product_name-error').innerHTML = 'عفوآ...يجب إدخال اسم المنتج';
        document.getElementById('product_name').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('product_name-error').innerHTML = '';
        document.getElementById('product_name').style.borderColor = '';
      }

      if (category_id === '') {
        document.getElementById('category_id-error').innerHTML = 'عفوآ...يجب اختيار مجموعه المنتج';
        document.getElementById('category_id-container').style.border = '1px solid';
        document.getElementById('category_id-container').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('category_id-error').innerHTML = '';
        document.getElementById('category_id-container').style.border = '';
        document.getElementById('category_id-container').style.borderColor = '';
      }

      if (product_request === '' || product_request.length < 1 || product_request.length > 5) {
        document.getElementById('product_request-error').innerHTML = 'عفوآ...يجب إدخال حد الطلب وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
        document.getElementById('product_request').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('product_request-error').innerHTML = '';
        document.getElementById('product_request').style.borderColor = '';
      }

      if (manual_code === '') {
        document.getElementById('manual_code-error').innerHTML = 'عفوآ...يجب إدخال كود المنتج';
        document.getElementById('manual_code').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('manual_code-error').innerHTML = '';
        document.getElementById('manual_code').style.borderColor = '';
      }

      if (unit_id === '') {
        document.getElementById('unit_id-error').innerHTML = 'عفوآ...يجب اختيار الوحدة ';
        document.getElementById('unit_id-container').style.border = '1px solid';
        document.getElementById('unit_id-container').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('unit_id-error').innerHTML = '';
        document.getElementById('unit_id-container').style.border = '';
        document.getElementById('unit_id-container').style.borderColor = '';
      }

      if (color_id === '') {
        document.getElementById('color_id-error').innerHTML = 'عفوآ...يجب اختيار اللون ';
        document.getElementById('color_id-container').style.border = '1px solid';
        document.getElementById('color_id-container').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('color_id-error').innerHTML = '';
        document.getElementById('color_id-container').style.border = '';
        document.getElementById('color_id-container').style.borderColor = '';
      }


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

    // document.getElementById('product_name').addEventListener('blur', function () {
    //   var productname = this.value;
    //   if (productname.length === '') {
    //     document.getElementById('product_name-error').innerHTML = 'عفوآ...يجب إدخال اسم المنتج';
    //     this.style.borderColor = 'red';
    //   } else {
    //     document.getElementById('product_name-error').innerHTML = '';
    //     this.style.borderColor = '';
    //   }
    // });

    // document.getElementById('product_request').addEventListener('blur', function () {
    //   var product_request = this.value;
    //   if (product_request.length === '') {
    //     document.getElementById('product_request-error').innerHTML = 'عفوآ...يجب إدخال حد الطلب وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
    //     this.style.borderColor = 'red';
    //   } else {
    //     document.getElementById('product_request-error').innerHTML = '';
    //     this.style.borderColor = '';
    //   }
    // });

    function removeError(element) {
      element.style.borderColor = 'none';
    }
  });

  function handleProductChange1() {
    var categoryidSelect = document.getElementById('category_id').value;
    if (categoryidSelect === '') {
      document.getElementById('category_id-error').innerHTML = 'عفوآ...يجب اختيار مجموعه المنتج';
      document.getElementById('category_id-container').style.border = '1px solid';
      document.getElementById('category_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('category_id-error').innerHTML = '';
      document.getElementById('category_id-container').style.border = '';
      document.getElementById('category_id-container').style.borderColor = '';
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