
document.addEventListener("DOMContentLoaded", function() {
  // Image preview
  document.getElementById("img").addEventListener("change", function() {
      var files = Array.from(this.files);
      var allowedExtensions = [".jpg",".jpeg", ".png"];
      var errorSpan = document.getElementById("errorSpan");
      var previewContainer = document.querySelector('.preview');

      // Clear and hide the error message
      errorSpan.textContent = "";

      // Clear previously displayed images
      previewContainer.innerHTML = "";

      // Check each selected file
      for (var i = 0; i < files.length; i++) {
          var fileExtension = files[i].name.split(".").pop().toLowerCase();
          if (!allowedExtensions.includes("." + fileExtension)) {
              errorSpan.textContent = "عفوًا... يجب اختيار صور بامتداد jpg , jpeg , png فقط";
              // Clear the selected files if the extension is not allowed
              this.value = null;
              return;
          } else {
              // Create FileReader object
              var reader = new FileReader();

              // Read the file and generate preview
              reader.onload = function(e) {
                  var html = '<div class="col-sm-4"><img class="img-thumbnail" src="' + e.target.result + '" alt="preview" style="height: 200px;"></div>';
                  previewContainer.insertAdjacentHTML('beforeend', html);
              };

              reader.readAsDataURL(files[i]);
          }
      }
  });

  // Add CSS to make the image display as flex
  var previewElements = document.querySelectorAll('.preview');
  previewElements.forEach(function(element) {
      element.style.display = 'flex';
  });
});


