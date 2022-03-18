// Get the modal
var modal = document.getElementById("modalForm");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var inputH = document.querySelector("input[name='type']");

$('#add').click(function() {
  inputH.setAttribute('value','addEstablishment');
  $('.modal-header').children('h3').text('Ajouter un établissement');
  $('form').children('.submit-btn').html('Ajouter');
  modal.style.display = "block";
})

$('#modify').click(function() {
  inputH.setAttribute('value','modifyEstablishment');
  $('.modal-header').children('h3').text('Modifier l\'établissement');
  $('form').children('.submit-btn').html('Modifier');
  modal.style.display = "block";
})

$('#delete').click(function() {
  alert("supprimer");
})

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  inputH.setAttribute('value','');
  $('.modal-header').children('h3').text('');
  $('form').children('.submit-btn').html('');
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    inputH.setAttribute('value','');
    $('.modal-header').children('h3').text('');
    $('form').children('.submit-btn').html('');
  }
}

