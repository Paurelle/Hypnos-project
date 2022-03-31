$(document).ready(function() {
    $('.picture input[type="file"]').change(function(e) {
        var name = e.target.files[0].name;

        if (name.length > 15) {
            name = name.substr(0, 15)+'...';
        }
        $(this).siblings('span').text(name);
    });
});

$(document).ready(function() {
    $('.gallery input[type="file"]').change(function(e) {
        var name = e.target.files;
        $(this).siblings('span').text(name.length+' fichiers');
    });
});