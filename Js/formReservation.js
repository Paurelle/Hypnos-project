
$(document).ready(function() {

  selectSuiteByEstablishment($("#establishment"))
  
  $("#establishment").change(function() {
    selectSuiteByEstablishment($(this))
  })

  $("#suite").change(function() {
    checkReservation();
  })

  $("#startDate").change(function() {
    checkReservation();
  })

  $("#endDate").change(function() {
    checkReservation();
  })

  function selectSuiteByEstablishment(id_establishment) {
    var establishment = id_establishment.val()
    if (establishment != '') {

      $.ajax({
        type:"POST", 	        
        url:"Controllers/Suites.php",  
        dataType: "json",
        data:{type: 'selectSuite', id_establishment: establishment},
        success:function(data){
          $('#suite').children().remove();
          for (let index = 0; index < data.length; index++) {
            $('#suite').append($('<option>').val(data[index][0]).text(data[index][1]+" / "+(data[index][2]+"€")));
          }
          checkReservation();
        }
      })

    } else {
      $('#suite').children().remove();
      $('#suite').append($('<option>'))
    }
  }

  function checkReservation() {
    let establishment = $('#establishment').val()
    let suite = $('#suite').val()
    let startDate = $('#startDate').val()
    let endDate = $('#endDate').val()

    if (establishment != '') {
      if (suite != '') {
        if (startDate != '' && endDate != '') {
          if (startDate < endDate) {

            $.ajax({
              type:"POST", 	        
              url:"Controllers/Reservations.php",  
              dataType: "json",
              data:{type: 'checkReservation', 
                    id_establishment: establishment, 
                    id_suite: suite, 
                    startDate: startDate, 
                    endDate: endDate
                  },
              success:function(data){
                $('div .form-message').remove();
                if (data) {
                  $('<div class="form-message form-message-green">Réservation possible</div>').insertAfter('h1');
                } else {
                  $('<div class="form-message form-message-red">Réservation impossible</div>').insertAfter('h1');
                }
              }
            })

          } else {
            $('div .form-message').remove();
            $('<div class="form-message form-message-red">Les dates sont invalide</div>').insertAfter('h1');
          }
        }
      }
    }
  }

});  