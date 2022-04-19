// Get the modal
var modal = document.getElementById("modalForm");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var inputH = document.querySelector("input[name='type']");

$('.addBtn').click(function() {
  modalValue('addEstablishment', 'Ajouter un établissement', 'Ajouter');
  modal.style.display = "block";
})

$('.modifyBtn').click(function() {
  modalValue('modifyEstablishment', 'Modifier l\'établissement', 'Modifier');
  modal.style.display = "block";
  var id_establishment = $(this).parents('.content-card').attr('id');
  $.ajax({
    type:"POST", 	        
    url:"Controllers/Establishments.php",  
    dataType: "json",
    data:{type: 'infoEstablishment', id: id_establishment},
    success:function(data){
      console.log(data);
      $('#id').val(data['id'])
      $('#name').val(data['name']);
      $('#manager').append('<option value="'+data['id_user']+'">'+data['user_name']+'</option>');
      $('#manager option[value="'+data['id_user']+'"]').prop('selected', true);
      $('#city').val(decodeEntities(data['city']));
      $('#address').val(decodeEntities(data['address']));
      $('#description').val(decodeEntities(data['description']));
      $('.picture span').text(data['img_name']);
    }
  })
})

$('.deleteBtn').click(function() {
  var row = $(this).parents('.content-card');
  var id_establishment = $(this).parents('.content-card').attr('id');
  $.ajax({
    type:"POST", 	        
    url:"Controllers/Establishments.php",  
    dataType: "json",
    data:{type: 'deleteEstablishment', id: id_establishment},
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
  $('#id').val('')
  $('#name').val('');
  $('#manager option:nth-child('+$('#manager option').length+')').remove();
  $('#city').val('');
  $('#address').val('');
  $('#description').val('');
}



function decodeEntities(encodedString) {
  var textArea = document.createElement('textarea');
  textArea.innerHTML = encodedString;
  return textArea.value;
}