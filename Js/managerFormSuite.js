// Get the modal
var modal = document.getElementById("modalForm");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var inputH = document.querySelector("input[name='type']");

$('.addBtn').click(function() {
  modalValue('addSuite', 'Ajouter une suite', 'Ajouter');
  $('.modifySuite').css("display", "none");
  modal.style.display = "block";
})

$('.modifyBtn').click(function() {
  modalValue('modifySuite', 'Modifier la suite', 'Modifier');
  $('.modifySuite').css("display", "block");
  modal.style.display = "block";
  var id_suite = $(this).parents('.content-card').attr('id');
  $.ajax({
    type:"POST", 	        
    url:"Controllers/Suites.php",  
    dataType: "json",
    data:{type: 'infoSuite', id: id_suite},
    success:function(data){
      $('#id_suite').val(data['id_suite']);
      $('#id_establishment').val(data['id_establishment']);
      $('#name').val(data['title']);
      $('#price').val(data['price']);
      $('#description').val(data['description']);
      $('.picture span').text(data['img_name']);
      $('.gallery span').text(data['img_gallery_name']+' fichiers');
      $('#link').val(data['link']);
    }
  })
})

$('.deleteBtn').click(function() {
  var row = $(this).parents('.content-card');
  var id_suite = $(this).parents('.content-card').attr('id');
  $.ajax({
    type:"POST", 	        
    url:"Controllers/Suites.php",  
    dataType: "json",
    data:{type: 'deleteSuite', id: id_suite},
    success:function(data){
      if (data) {
        row.remove();
      }
    }
  })
})

function modalValue(value, h3, btn) {
  inputH.setAttribute('value', value);
  $('.modal-header').children('h3').text(h3);
  $('form').children('.submit-btn').html(btn);
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  resetValue();
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    resetValue();
  }
}
// Reset modal value
function resetValue() {
  modal.style.display = "none";
  inputH.setAttribute('value','');
  $('.modal-header').children('h3').text('');
  $('form').children('.submit-btn').html('');
  $('#id_suite').val('');
  $('#id_establishment').val('');
  $('#name').val('');
  $('#manager option:nth-child('+$('#manager option').length+')').remove();
  $('#city').val('');
  $('#address').val('');
  $('#description').val('');
  $('.picture input[type="file"]').siblings('span').text('');
  $('.gallery input[type="file"]').siblings('span').text('');
}



