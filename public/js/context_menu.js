$(function(){
    $('#custom-cm').hide();

        $('body').on("contextmenu","table tr", function(e) {
        $('#custom-cm').show();
        // $("#custom-cm").offset({left:e.pageX, 
        //     top:e.pageY});
        var windowHeight = $(window).height()/2;
var windowWidth = $(window).width()/2;
if(e.clientY > windowHeight && e.clientX <= windowWidth) {
  $("#custom-cm").css("left", e.clientX);
  $("#custom-cm").css("bottom", $(window).height()-e.clientY);
  $("#custom-cm").css("right", "auto");
  $("#custom-cm").css("top", "auto");
} else if(e.clientY > windowHeight && e.clientX > windowWidth) {
  $("#custom-cm").css("right", $(window).width()-e.clientX);
  $("#custom-cm").css("bottom", $(window).height()-e.clientY);
  $("#custom-cm").css("left", "auto");
  $("#custom-cm").css("top", "auto");
} else if(e.clientY <= windowHeight && e.clientX <= windowWidth) {
  $("#custom-cm").css("left", e.clientX);
  $("#custom-cm").css("top", e.clientY);
  $("#custom-cm").css("right", "auto");
  $("#custom-cm").css("bottom", "auto");
} else {
  $("#custom-cm").css("right", $(window).width()-e.clientX);
  $("#custom-cm").css("top", e.clientY);
  $("#custom-cm").css("left", "auto");
  $("#custom-cm").css("bottom", "auto");
}
        e.preventDefault();
    });

    $('body').on("click", function(e) {
        
        $('#custom-cm').hide();
    });

});
// ===============================================
// close contextmenu by escape key
$('body').keyup(function(e) {
     if (e.keyCode == 27) { // escape key maps to keycode `27`
        $('#custom-cm').hide();
    }
});
// ===============================================
// stop Default contextmenu
window.addEventListener('contextmenu', (event) => {
    event.preventDefault()
})
// =================================================================
// set span to input search
$(function() {
  $('#filter input:text').focus(function(){
    $('.note').show();
  });

  $('#filter input:text').focusout(function(){
    $('.note').hide();
  });
});

