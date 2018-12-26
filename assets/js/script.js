$(document).ready(function () {
    var files;


    $('input[type=file]').on('change', function (){
        readerOne(this);
    });

    // $img= document.querySelector('#galleryList li img')
    // Jcrop.attach($img);

    // var $image = $('#galleryList li img:eq(0)');
    // $image.cropper({
    //     aspectRatio: 16 / 9,
    //     crop: function(event) {
    //         console.log(event.detail.x);
    //         console.log(event.detail.y);
    //         console.log(event.detail.width);
    //         console.log(event.detail.height);
    //         console.log(event.detail.rotate);
    //         console.log(event.detail.scaleX);
    //         console.log(event.detail.scaleY);
    //     }
    // });

    // var cropper = $image.data('cropper');

    function readerOne(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#galleryList').text('');
                var img = $('<img>').attr('src', e.target.result);
                var li = $('<li>');
                li.append(img);
                $('#galleryList').append(li);
                $('#uploadText').text(`Выбрано файлов : ${input.files.length}`);
            }

            reader.readAsDataURL(input.files[0]);
            setTimeout(initCropper, 1000);

        }
    }


    function initCropper(image){

        //console.log(cropper)
        //var image = document.getElementById('blah');
        // var cropper = new Cropper(image, {
        //     aspectRatio: 1 / 1,
        //     crop: function(e) {
        //         console.log(e.detail.x);
        //         console.log(e.detail.y);
        //     }
        // });

        // image.cropper({
        //     aspectRatio: 16 / 9,
        //     crop: function(event) {
        //         console.log(event.detail.x);
        //         console.log(event.detail.y);
        //         console.log(event.detail.width);
        //         console.log(event.detail.height);
        //         console.log(event.detail.rotate);
        //         console.log(event.detail.scaleX);
        //         console.log(event.detail.scaleY);
        //     }
        // });

        // On crop button clicked
        // document.getElementById('crop_button').addEventListener('click', function(){
        //     var imgurl =  cropper.getCroppedCanvas().toDataURL();
        //     var img = document.createElement("img");
        //     img.src = imgurl;
        //     document.getElementById("cropped_result").appendChild(img);
        //
        //     /* ---------------- SEND IMAGE TO THE SERVER-------------------------
        //
        //         cropper.getCroppedCanvas().toBlob(function (blob) {
        //               var formData = new FormData();
        //               formData.append('croppedImage', blob);
        //               // Use `jQuery.ajax` method
        //               $.ajax('/path/to/upload', {
        //                 method: "POST",
        //                 data: formData,
        //                 processData: false,
        //                 contentType: false,
        //                 success: function () {
        //                   console.log('Upload success');
        //                 },
        //                 error: function () {
        //                   console.log('Upload error');
        //                 }
        //               });
        //         });
        //     ----------------------------------------------------*/
        // })
    }
})