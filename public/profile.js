function initCropProfile () {
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
        basic.croppie('result','blob'
        ).then(function (result) {
            var fd = new FormData();
            fd.append('data', result,$('#userId').val()+"."+result.type.split("/")[1]);
            $.ajax({
                type: 'POST',
                url : $('#updateProfilePictureLink').val(),
                data: fd,
                processData: false,
                contentType: false
            }).done(function(data) {
                $('#profilePicture').attr('src', URL.createObjectURL(result));
                $('#profilePictureModal').modal('hide');
            });
        });
    });

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

    function urltoFile(url, filename, mimeType){
        return (fetch(url)
                .then(function(res){return res.arrayBuffer();})
                .then(function(buf){return new File([buf], filename, {type:mimeType});})
        );
    }

}

function initCropBanner () {
    var basic = $('#banner-cropper').croppie({
        viewport: {width: 750, height: 200},
        boundary: {width: 750, height: 200},
        enforceBoundary: true,
        showZoomer: true,
        url: $("#userBanner").css('background-image').replace('url(','').replace(')','').replace(/\"/gi, "")
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

    $('#bannerModal').on('shown.bs.modal', function() {
        $('#banner-cropper').croppie('bind');
    });

    $( "#cropBannerSave" ).click(function() {
        basic.croppie('result', {
            type: 'blob',
            size: 'original'}
        ).then(function (result) {
            var fd = new FormData();
            fd.append('data', result,$('#userId').val()+"."+result.type.split("/")[1]);
            $.ajax({
                type: 'POST',
                url : $('#updateBannerLink').val(),
                data: fd,
                processData: false,
                contentType: false
            }).done(function(data) {
                $("#userBanner").css('background-image', 'url("'+URL.createObjectURL(result)+'")');
                $('#bannerModal').modal('hide');
            });
        });
    });

    function urltoFile(url, filename, mimeType){
        return (fetch(url)
                .then(function(res){return res.arrayBuffer();})
                .then(function(buf){return new File([buf], filename, {type:mimeType});})
        );
    }

}

