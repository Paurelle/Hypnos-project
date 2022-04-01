
$('.deleteBtn').click(function() {
    let row = $(this).parents('tr');
    let id_reservation = row.attr('id');
      $.ajax({
        type:"POST", 	        
        url:"Controllers/Reservations.php",  
        dataType: "json",
        data:{type: 'delete', id_reservation: id_reservation},
        success:function(data){
            $('div .form-message').remove();

            if (data == "limite") {
                $('<div class="form-message form-message-red">La suppression doit se faire 3 jours avant la date réserver</div>').insertAfter('h2');
            } else if (data) {
                $('<div class="form-message form-message-green">La suppression de votre réserver a etait valider</div>').insertAfter('h2');
                row.remove();
            } else {
                $('<div class="form-message form-message-red">Impossible de supprimer la réservation</div>').insertAfter('h2');
            }
        }
        
    })
  
  })