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