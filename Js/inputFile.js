$(document).ready(function() {
    $('input[type="file"]').change(function(e) {
        var name = e.target.files[0].name;

        if (name.length > 15) {
            name = name.substr(0, 15)+'...';
        }
        $('.establishment-picture').children('span').text(name);
    });
});
