$(document).ready(function () {
    var files;


    $('input[type=file]').on('change', function (){
        readerOne(this);
    });

    function readerOne(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#gallery').text('');
                let img = $('<img>').attr('src', e.target.result);
                let div = $('<div class="col-lg-2 col-md-3 col-sm-4 imgItem">');
                let bar = $('<div class="imgBar">');
                div.append(img);
                div.append(bar);

                $('#gallery').append(div);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
})