
$(document).ready(function() {

  let searchParams = new URLSearchParams(window.location.search)
  searchParams.has('suite') 
  let suite = searchParams.get('suite')

  

  selectSuiteByEstablishment($("#establishment").val(), true)
  
  $("#establishment").change(function() {
    selectSuiteByEstablishment($(this).val(), false)
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

  function selectSuiteByEstablishment(id_establishment, get) {
    let establishment = id_establishment
    
    if (establishment != '') {

      $.ajax({
        type:"POST", 	        
        url:"Controllers/Suites.php",  
        dataType: "json",
        data:{type: 'selectSuite', id_establishment: establishment},
        success:function(data){
          $('#suite').children().remove();
          for (let index = 0; index < data.length; index++) {
            if (data[index][0] == suite && get) {
              $('#suite').append($('<option selected>').val(data[index][0]).text(data[index][1]+" / "+(data[index][2]+"€")));
            } else {
              $('#suite').append($('<option>').val(data[index][0]).text(data[index][1]+" / "+(data[index][2]+"€")));
            }
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