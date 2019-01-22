function initCrop () {
    var basic = $('#main-cropper').croppie({
        viewport: {width: 300, height: 300},
        boundary: {width: 300, height: 300},
        enforceBoundary: true,
        showZoomer: true,
        url: $("#profilePicture").attr('src')
    });

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#main-cropper').croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#inputPicture').on('change', function () {
        readFile(this);
    });

    $('#profilePictureModal').on('shown.bs.modal', function() {
        $('#main-cropper').croppie('bind');
    });


    $( "#cropSave" ).click(function() {
        alert("click !");
        basic.croppie('result','canvas'
        ).then(function (result) {
            $('#profilePicture').attr('src', result);
            $.ajax({
                type : "POST",
                data : {
                    'image':result,
                    'userId':$('#userId').val()
                },
                url : 'updateProfilePicture',
                success : function(response) {
                    $('#profilePicture').attr('src', result);
                    alert("success !")

                },
                error : function (response) {
                    alert("error !")
                }
            });
        });
    });
}

