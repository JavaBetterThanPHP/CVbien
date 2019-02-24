const MODULE_TEXTE = "Texte";


function initCropProfile() {
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

    $('#profilePictureModal').on('shown.bs.modal', function () {
        $('#main-cropper').croppie('bind');
    });

    $("#cropSave").click(function () {
        basic.croppie('result', 'blob'
        ).then(function (result) {
            var fd = new FormData();
            fd.append('data', result, $('#userId').val() + "." + result.type.split("/")[1]);
            $.ajax({
                type: 'POST',
                url: $('#updateProfilePictureLink').val(),
                data: fd,
                processData: false,
                contentType: false
            }).done(function () {
                $('#profilePicture').attr('src', URL.createObjectURL(result));
                $('#profilePictureModal').modal('hide');
            });
        });
    });
}

function initCropBanner() {
    var basic = $('#banner-cropper').croppie({
        viewport: {width: 750, height: 200},
        boundary: {width: 750, height: 200},
        enforceBoundary: true,
        showZoomer: true,
        url: $("#userBanner").css('background-image').replace('url(', '').replace(')', '').replace(/\"/gi, "")
    });

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#banner-cropper').croppie('bind', {
                    url: e.target.result
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#inputBanner').on('change', function () {
        readFile(this);
    });

    $('#bannerModal').on('shown.bs.modal', function () {
        $('#banner-cropper').croppie('bind');
    });

    $("#cropBannerSave").click(function () {
        basic.croppie('result', {
                type: 'blob',
                size: 'original'
            }
        ).then(function (result) {
            var fd = new FormData();
            fd.append('data', result, $('#userId').val() + "." + result.type.split("/")[1]);
            $.ajax({
                type: 'POST',
                url: $('#updateBannerLink').val(),
                data: fd,
                processData: false,
                contentType: false
            }).done(function () {
                $("#userBanner").css('background-image', 'url("' + URL.createObjectURL(result) + '")');
                $('#bannerModal').modal('hide');
            });
        });
    });
}


$('#btnInitCropProfile').click(function () {
    initCropProfile();
});

$('#btnInitCropBanner').click(function () {
    initCropBanner();
});

function selectModule(moduleName){
    switch (moduleName) {
        case MODULE_TEXTE :
            $("#wysiwygModal").modal();
            CKEDITOR.replace( 'editor1');
            break;
        default:
            alert("error");
    }
}

function addTextModule(data){
    var text = data;
    var element = document.createElement('div');
    element.innerHTML =
        "<div class=\"card\" style=\"width: 30rem;\">\n"+
        "<div class=\"card-header\"></div>\n"+
        "<div class=\"card-body\">\n"+
        "<p class=\"card-text\">"+text+"</p>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element);
    grid.layout();
    $("#wysiwygModal").modal('hide');
    $("#moduleModal").modal('hide');

}
