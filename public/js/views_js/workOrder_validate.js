
document.addEventListener("DOMContentLoaded", function() {
  var createForm = document.getElementById('create');
  var saveButton = document.getElementById('save_print');
  var onlySaveButton = document.getElementById('onlysave');


    // Disable both buttons when either is clicked
    function disableButtons() {
      saveButton.disabled = true;
      onlySaveButton.disabled = true;
    }

  saveButton.addEventListener('click', function(event) {
    event.preventDefault();

    var teamId = auth.team_id;
    var service_itemid = document.getElementById('service_item_id').value;
    var initial_product_count = document.getElementById('initial_product_count').value;
    var fabric_source_id = document.getElementById('fabric_source_id').value;
    var fabric_id = document.getElementById('fabric_id').value;

    var isValid = true;

    if (document.getElementsByClassName('input_holder').length < 1) {
      document.getElementById('service_item_id-error').innerHTML = 'عفوًا... يجب اختيار خدمة واحدة على الأقل';
      document.getElementById('service_item_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('service_item_id-error').innerHTML = '';
      document.getElementById('service_item_id-container').style.border = '';
    }

    if (fabric_source_id === '') {
      document.getElementById('fabric_source_id-error').innerHTML = 'عفوًا... يجب اختيار مصدر القماش';
      document.getElementById('fabric_source_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('fabric_source_id-error').innerHTML = '';
      document.getElementById('fabric_source_id-container').style.border = '';
    }

    if (fabric_id === '') {
      document.getElementById('fabric_id-error').innerHTML = 'عفوًا... يجب اختيار الخامة';
      document.getElementById('fabric_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('fabric_id-error').innerHTML = '';
      document.getElementById('fabric_id-container').style.border = '';
    }

    if (initial_product_count.length < 1 || initial_product_count.length > 5) {
      document.getElementById('initial_product_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
      document.getElementById('initial_product_count').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('initial_product_count-error').innerHTML = '';
      document.getElementById('initial_product_count').style.borderColor = '';
    }

    if (teamId === 3) {
      var places = document.getElementById('placeid').value;
      var product_count = document.getElementById('product_count').value;
      var product_weight = document.getElementById('product_weight').value;

      if (places === '') {
        document.getElementById('place_id-error').innerHTML = 'عفوًا... يجب اختيار مكان التخزين';
        document.getElementById('place_id-container').style.border = '1px solid red';
        isValid = false;
      } else {
        document.getElementById('place_id-error').innerHTML = '';
        document.getElementById('place_id-container').style.border = '';
      }

      if (product_count === '0' || product_count.length < 1 || product_count.length > 5) {
        document.getElementById('product_count-error').innerHTML = 'يجب إدخال العدد الفعلي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
        document.getElementById('product_count').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('product_count-error').innerHTML = '';
        document.getElementById('product_count').style.borderColor = '';
      }

      if (product_weight === '' || product_weight.length < 1 || product_weight.length > 5) {
        document.getElementById('product_weight-error').innerHTML = 'يجب إدخال الوزن الفعلي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
        document.getElementById('product_weight').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('product_weight-error').innerHTML = '';
        document.getElementById('product_weight').style.borderColor = '';
      }
    }

    if (isValid) {

      // Disable both buttons
      disableButtons();

      // Create a hidden input element
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'save_print');
      hiddenInput.setAttribute('value', 'go_print');

      // Append the hidden input to the form
      createForm.appendChild(hiddenInput);

      // Submit the form
      createForm.submit();
    }
  });

  onlySaveButton.addEventListener('click', function(event) {
    event.preventDefault();

    var teamId = auth.team_id;
    var service_itemid = document.getElementById('service_item_id').value;
    var initial_product_count = document.getElementById('initial_product_count').value;
    var fabric_source_id = document.getElementById('fabric_source_id').value;
    var fabric_id = document.getElementById('fabric_id').value;


    var isValid = true;

    if (document.getElementsByClassName('input_holder').length < 1) {
      document.getElementById('service_item_id-error').innerHTML = 'عفوًا... يجب اختيار خدمة واحدة على الأقل';
      document.getElementById('service_item_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('service_item_id-error').innerHTML = '';
      document.getElementById('service_item_id-container').style.border = '';
    }

    if (initial_product_count.length < 1 || initial_product_count.length > 5) {
      document.getElementById('initial_product_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
      document.getElementById('initial_product_count').style.borderColor = 'red';
      isValid = false;
    } else {
      document.getElementById('initial_product_count-error').innerHTML = '';
      document.getElementById('initial_product_count').style.borderColor = '';
    }

    if (fabric_source_id === '') {
      document.getElementById('fabric_source_id-error').innerHTML = 'عفوًا... يجب اختيار مصدر القماش';
      document.getElementById('fabric_source_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('fabric_source_id-error').innerHTML = '';
      document.getElementById('fabric_source_id-container').style.border = '';
    }

    if (fabric_id === '') {
      document.getElementById('fabric_id-error').innerHTML = 'عفوًا... يجب اختيار الخامة';
      document.getElementById('fabric_id-container').style.border = '1px solid red';
      isValid = false;
    } else {
      document.getElementById('fabric_id-error').innerHTML = '';
      document.getElementById('fabric_id-container').style.border = '';
    }

    if (teamId === 3) {
      var places = document.getElementById('placeid').value;
      var product_count = document.getElementById('product_count').value;
      var product_weight = document.getElementById('product_weight').value;

      if (places === '') {
        document.getElementById('place_id-error').innerHTML = 'عفوًا... يجب اختيار مكان التخزين';
        document.getElementById('place_id-container').style.border = '1px solid red';
        isValid = false;
      } else {
        document.getElementById('place_id-error').innerHTML = '';
        document.getElementById('place_id-container').style.border = '';
      }

      if (product_count === '0' || product_count.length < 1 || product_count.length > 5) {
        document.getElementById('product_count-error').innerHTML = 'يجب إدخال العدد الفعلي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
        document.getElementById('product_count').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('product_count-error').innerHTML = '';
        document.getElementById('product_count').style.borderColor = '';
      }

      if (product_weight === '0' || product_weight.length < 1 || product_weight.length > 5) {
        document.getElementById('product_weight-error').innerHTML = 'يجب إدخال الوزن الفعلي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
        document.getElementById('product_weight').style.borderColor = 'red';
        isValid = false;
      } else {
        document.getElementById('product_weight-error').innerHTML = '';
        document.getElementById('product_weight').style.borderColor = '';
      }
    }

    if (isValid) {
      // Disable both buttons
      disableButtons();
      // Submit the form without adding the hidden input
      createForm.submit();
    }
  });

  document.addEventListener('keyup', function(e) {
    if (e.key === 'F2' && createForm.checkValidity()) {
      saveButton.click();
    }
  });

  document.getElementById('initial_product_count').addEventListener('blur', function() {
    var initial_product_count = this.value;
    if (initial_product_count.length < 1 || initial_product_count.length > 5) {
      document.getElementById('initial_product_count-error').innerHTML = 'يجب إدخال العدد المبدئي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('initial_product_count-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });

  document.getElementById('product_count').addEventListener('blur', function() {
    var product_count = this.value;
    if (product_count === '0' || product_count.length < 1 || product_count.length > 5) {
      document.getElementById('product_count-error').innerHTML = 'يجب إدخال العدد الفعلي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('product_count-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });

  document.getElementById('product_weight').addEventListener('blur', function() {
    var product_weight = this.value;
    if (product_weight === '' || product_weight.length < 1 || product_weight.length > 5) {
      document.getElementById('product_weight-error').innerHTML = 'يجب إدخال الوزن الفعلي وأن لا يقل عن رقم ولا يزيد عن 5 أرقام';
      this.style.borderColor = 'red';
    } else {
      document.getElementById('product_weight-error').innerHTML = '';
      this.style.borderColor = '';
    }
  });

  document.getElementById('service_item_id').addEventListener('change', handleProductChange);
  if (teamId === 3) {
    document.getElementById('placeid').addEventListener('change', handleProductChange);
  }
});

function handleProductChange() {
  var teamId = auth.team_id;
  var service_item_idSelect = document.getElementById('service_item_id');
  var service_itemid = service_item_idSelect.value;

  if (service_itemid === '') {
    document.getElementById('service_item_id-error').innerHTML = 'عفوآ...يجب اختيار اختيار خدمه واحده على الاقل';
    document.getElementById('service_item_id-container').style.border = '1px solid';
    document.getElementById('service_item_id-container').style.borderColor = 'red';
  } else {
    document.getElementById('service_item_id-error').innerHTML = '';
    document.getElementById('service_item_id-container').style.border = 'none';
    document.getElementById('service_item_id-container').style.borderColor = 'none';
  }

  if (teamId === 3) {
    var place_idSelect = document.getElementById('placeid');
    var placeid = place_idSelect.value;
    if (placeid === '') {
      document.getElementById('place_id-error').innerHTML = 'عفوآ...يجب اختيار مكان التخزين';
      document.getElementById('place_id-container').style.border = '1px solid';
      document.getElementById('place_id-container').style.borderColor = 'red';
    } else {
      document.getElementById('place_id-error').innerHTML = '';
      document.getElementById('place_id-container').style.border = '';
      document.getElementById('place_id-container').style.borderColor = '';
    }
  }
}

function handleFabric_sourcesChange() {
  var fabric_source_idSelect = document.getElementById('fabric_source_id');
  var fabric_source_id = fabric_source_idSelect.value;

  if (fabric_source_id === '') {
    document.getElementById('fabric_source_id-error').innerHTML = 'عفوآ...يجب اختيار مصدر القماش';
    document.getElementById('fabric_source_id-container').style.border = '1px solid';
    document.getElementById('fabric_source_id-container').style.borderColor = 'red';
  } else {
    document.getElementById('fabric_source_id-error').innerHTML = '';
    document.getElementById('fabric_source_id-container').style.border = 'none';
    document.getElementById('fabric_source_id-container').style.borderColor = 'none';
  }
}

function handleFabricsChange() {
  var fabric_idSelect = document.getElementById('fabric_id');
  var fabric_id = fabric_idSelect.value;

  if (fabric_id === '') {
    document.getElementById('fabric_id-error').innerHTML = 'عفوآ...يجب اختيار مصدر القماش';
    document.getElementById('fabric_id-container').style.border = '1px solid';
    document.getElementById('fabric_id-container').style.borderColor = 'red';
  } else {
    document.getElementById('fabric_id-error').innerHTML = '';
    document.getElementById('fabric_id-container').style.border = 'none';
    document.getElementById('fabric_id-container').style.borderColor = 'none';
  }
}



