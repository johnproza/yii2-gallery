$(document).ready(function () {
    var files;




// Get the Cropper.js instance after initialized



    $('input[type=file]').on('change', function (){
        readerOne(this);
    });

    function readerOne(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#gallery').text('');
                var img = $('<img>').attr('src', e.target.result);
                var div = $('<div class="col-lg-2 col-md-3 col-sm-4 imgItem">');
                var bar = $('<div class="imgBar">');
                div.append(img);
                div.append(bar);

                $('#gallery').append(div);
            }

            reader.readAsDataURL(input.files[0]);

            var cropper = img.data('cropper');

            img.cropper({
                aspectRatio: 16 / 9,
                crop: function(event) {
                    console.log(event.detail.x);
                    console.log(event.detail.y);
                    console.log(event.detail.width);
                    console.log(event.detail.height);
                    console.log(event.detail.rotate);
                    console.log(event.detail.scaleX);
                    console.log(event.detail.scaleY);
                }
            });
        }
    }
})