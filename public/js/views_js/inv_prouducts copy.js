document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("product_name").focus();
    document.getElementById('create').addEventListener('submit', function (event) {
      event.preventDefault();

      var productname = document.getElementById('product_name').value;
      var category_id = document.getElementById('category_id').value;
      var product_request = document.getElementById('product_request').value;
      var final_product_id = document.getElementById('final_product_id').value;

      var empTable = document.getElementById('empTable');
      var tableRows = empTable.getElementsByTagName('tr');

      var empTable_color = document.getElementById('empTable_color');
      var tableRows_color = empTable_color.getElementsByTagName('tr');
     
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

      if (tableRows_color.length <= 1) {
        isValid = false;
        var validationMessage = document.getElementById("validationMessage_color");
        validationMessage.innerText = "يجب إضافة لون على الأقل إلى الجدول قبل الحفظ.";
      }

      if (tableRows.length <= 1) {
        isValid = false;
        var validationMessage = document.getElementById("validationMessage");
        validationMessage.innerText = "يجب إضافة وحده على الأقل إلى الجدول قبل الحفظ.";
      }


// Validate image file inputs with class "img"
var imgInputs = document.querySelectorAll('.img');
var totalSize = 0;

for (var i = 0; i < imgInputs.length; i++) {
    var imgInput = imgInputs[i];
    var fileList = imgInput.files;

    for (var j = 0; j < fileList.length; j++) {
        var file = fileList[j];
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        if (!allowedExtensions.exec(file.name)) {
            var errSpan = imgInput.nextElementSibling; 
            errSpan.innerHTML = 'عفوآ...صور غير صالحة. يجب أن تكون الصور بصيغة jpeg، png، gif، jpg فقط.';
            errSpan.style.color = 'red';
            imgInput.style.borderColor = 'red';
            isValid = false;
            break; 
        } else {
            imgInput.style.borderColor = '';
        }

        totalSize += file.size;
    }
}

if (totalSize > 1024 * 1024) {
    var lastImgInput = imgInputs[imgInputs.length - 1];
    var errSpan = lastImgInput.nextElementSibling; 
    errSpan.innerHTML = 'عفوآ...مجموع حجم الصور تجاوز الحد الأقصى المسموح به (1024 كيلوبايت).';
    errSpan.style.color = 'red';
    lastImgInput.style.borderColor = 'red';
    isValid = false;
} else {
    for (var i = 0; i < imgInputs.length; i++) {
        imgInputs[i].style.borderColor = '';
        var errSpan = imgInputs[i].nextElementSibling;
        errSpan.innerHTML = '';
    }
}




      if (category_id === '3') {
        
        if (final_product_id === '') {
          document.getElementById('final_product_id-error').innerHTML = 'عفوآ...يجب اختيار نوع المنتج';
          document.getElementById('final_product_id-container').style.border = '1px solid';
          document.getElementById('final_product_id-container').style.borderColor = 'red';
          isValid = false;
        } else {
          document.getElementById('final_product_id-error').innerHTML = '';
          document.getElementById('final_product_id-container').style.border = '';
          document.getElementById('final_product_id-container').style.borderColor = '';
        }

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

    document.getElementById('product_name').addEventListener('blur', function () {
      var productname = this.value;
      if (productname.length === '') {
        document.getElementById('product_name-error').innerHTML = 'عفوآ...يجب إدخال اسم المنتج';
        this.style.borderColor = 'red';
      } else {
        document.getElementById('product_name-error').innerHTML = '';
        this.style.borderColor = '';
      }
    });

    document.getElementById('product_request').addEventListener('blur', function () {
      var product_request = this.value;
      if (product_request.length === '') {
        document.getElementById('product_request-error').innerHTML = 'عفوآ...يجب إدخال حد الطلب وأن لا يقل عن  رقم ولا يزيد عن 5 ارقام';
        this.style.borderColor = 'red';
      } else {
        document.getElementById('product_request-error').innerHTML = '';
        this.style.borderColor = '';
      }
    });

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
