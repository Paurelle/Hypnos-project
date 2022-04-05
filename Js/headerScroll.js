
$(document).ready(function(){
  $('.navigation>input[type="checkbox"]').click(function(){
    if($(this).prop("checked") == true){
      document.documentElement.style.overflow = 'hidden';
    }
    else if($(this).prop("checked") == false){
      document.documentElement.style.overflow = 'visible';
  }
  });
});