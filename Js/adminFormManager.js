// Get the modal
var modal = document.getElementById("modalForm");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var inputH = document.querySelector("input[name='type']");

$('.addBtn').click(function() {
  modalValue('addManager', 'Ajouter un manager', 'Ajouter');
  modal.style.display = "block";
})
$('.modify').click(function() {
  modalValue('modifyManager', 'Modifier un manager', 'Modifier');
  modal.style.display = "block";
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
}


$('.deleteBtn').click(function() {
  var row = $(this).parents('tr');
  var email = row.children('.col3').text();
    $.ajax({
      type:"POST", 	        
      url:"Controllers/Users.php",  
      dataType: "json",
      data:{type: 'delete', email: email},
      success:function(data){
        if (data) {
          row.remove();
        } else {
          $('<div class="form-message form-message-red">Vous devez retirer le manager de sont √©tablissement avant de pouvoir le supprimer</div>').insertAfter('h2');
        }
      }
      
  })

})
