/*
$('#modify').click(function() {

    //var idCharacter = $(this).closest('.character-card').attr('id');

    $('.modal-header').children('h3').text('Modify character');
    $('input[name=type]').val('modifyCharacter');
    $('form').children('.submit-btn').html('Modifier');

    $('#myModal').css('display', 'block');
    /*
    $.ajax({
        type:"POST", 	        
        url:"../Controllers/Characters.php",  
        dataType: "json",
        data:{type: 'modify', idCharacter: idCharacter},
        success:function(data){
            
            $('.modal-header').children('h3').text('Modify character');
            $('input[name=type]').val('modifyCharacter');
            $('input[name=idCharacter]').val(idCharacter);

            // modify input 
            $('input[id=name]').val(data.name);
            $('select option[value="'+data.rank+'"]').prop('selected', true);
            $('select option[value="'+data.element+'"]').prop('selected', true);
            $('select option[value="'+data.class+'"]').prop('selected', true);
            var nameImg = data.name_img_profile;

            if (nameImg.length > 20) {
                nameImg = nameImg.substr(0, 20)+'...';
            }
            $('.character-profile-picture').children('span').text(nameImg);
            
            // modify card 
            $('#new-name-character').text(data.name);
            $('#new-img-character').attr('src', '../Img/profile/'+data.name_img_profile);
            $('#new-star-character').attr('src', '../Img/rank/'+data.rank+'-star.png').css('width', '85px');
            $('#new-element-character').attr('src', '../Img/elements/'+data.element+'.png').css('width', '20px');
            $('#new-class-character').attr('src', '../Img/class/'+data.class+'.png').css('width', '20px');

            $('form').children('.submit-btn').html('Modify');
            
            $('#myModal').css('display', 'block');
        }
    })
})*/


/*
// Get the modal
var modal = document.getElementById("modalForm");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var inputH = document.querySelector("input[name='type']");

$('.addBtn').click(function() {
  inputH.setAttribute('value','addManager');
  $('.modal-header').children('h3').text('Ajouter un manager');
  $('form').children('.submit-btn').html('Ajouter');
  modal.style.display = "block";
})

$('.modify').click(function() {
  inputH.setAttribute('value','modifyManager');
  $('.modal-header').children('h3').text('Modifier un manager');
  $('form').children('.submit-btn').html('Modifier');
  modal.style.display = "block";
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


$('.deleteBtn').click(function() {
  var row = $(this).parents('tr');
  var email = row.children('.col3').text();
  console.log(email);
    $.ajax({
      type:"POST", 	        
      url:"Controllers/Users.php",  
      dataType: "json",
      data:{type: 'delete', email: email},
      success:function(){
        row.remove();
      },
      error:function() {
        alert('Vous devez retirer le manager de sont établissement avant de pouvoir le supprimer');
      }
  })

})


*/ 