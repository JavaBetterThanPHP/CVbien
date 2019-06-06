const MODULE_TEXTE = "Texte";
const MODULE_COMPETENCES = "Competences";
const MODULE_LIEN = "Lien";

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

function selectModule(moduleName) {
    switch (moduleName) {
        case MODULE_TEXTE :
            $("#wysiwygModal").modal();
            CKEDITOR.replace('editor1');
            break;
        case MODULE_COMPETENCES :
            $("#competencesModal").modal();
            break;
        case MODULE_LIEN :
            $("#lienModal").modal();
            break;
        default:
            alert("error");
    }
}

function addTextModule(data) {
    var text = data;
    var element = document.createElement('div');
    element.className = "item";
    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);\">\n" +
        "<div class=\"card\">\n" +
        "<div class=\"card-header\">" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body\">\n" +
        "<p class=\"card-text\">" + text + "</p>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: 0});
    grid.layout();
    $("#moduleModal").modal('hide');
    $("#wysiwygModal").modal('hide');
}

function deleteModule(element) {
    grid.remove(element.parentElement.parentElement.parentElement.parentElement, {removeElements: true});
}

function addCompetencesModule(style) {
    var json = JSON.parse(document.querySelector(".user-proglanguage").dataset.userproglanguage);
    body = "";
    json.forEach(function (obj) {
        body += "<p class=\"card-text\">";
        body += "<div class=\"progress\">";
        body += "<div class=\"progress-bar progress-bar-striped progress-bar-animated bg-success\" role=\"progressbar\" aria-valuenow=\"" + (obj.level) * 10 + "\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " + (obj.level) * 10 + "%\"><strong>" + obj.progLanguage.name + "</strong></div>\n";
        body += "</div></p>";
    });
    var element = document.createElement('div');
    element.className = "item";
    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width:30rem;\">\n"+
        "<div class=\"card\" style=\"width: 30rem;\">\n"+
        "<div class=\"card-header\">Compétences" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body\">\n" + body +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: 0});
    grid.layout();
    $("#moduleModal").modal('hide');
    $("#competencesModal").modal('hide');
}

function addLienModule(titre, lien, image) {
    var element = document.createElement('div');
    element.style.width = "8rem";
    bgimage = "background-image:url(\""+image+"\")";
    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width: 8rem%;height:8rem;\">\n"+
        "<div class=\"card\" style=\"width:8rem;height:8em;background-size:8rem 8rem;background-image: url('"+image+"');\">\n"+

        "<div class=\"card-header bg-transparent border-bottom-0\">" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<a href=\"" + lien + "\">" +
        "</a>" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: 0});
    grid.layout();
    $("#moduleModal").modal('hide');
    $("#lienModal").modal('hide');
}

$("#updateDashboard").click(function () {
    alert($("#modGrid").html());
    $.ajax({
        type: 'POST',
        url: "/dashboard/updateDashboard",
        data: {html :$("#modGrid").html()}
}).done(function (data) {
        alert(data);
    });
});