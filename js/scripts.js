$(document).ready(function() {
    $('#summernote').summernote({
      height:100
    });
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(500).fadeOut(500, function(){
      $(this).remove();
    });
  
    $('.menu-item a').click(function(){
      $(this).addClass('active_link').siblings().removeClass('active_link');
      });
  });
