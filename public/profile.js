const MODULE_TEXTE = "Texte";
const MODULE_COMPETENCES = "Competences";
const MODULE_LIEN = "Lien";
const MODULE_STACKOVERFLOW = "StackOverflow";
const MODULE_IMAGE = "Image";


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
            $("#moduleModal").modal('hide');
            $("#wysiwygModal").modal();
            CKEDITOR.replace('editor1');
            break;
        case MODULE_COMPETENCES :
            $("#moduleModal").modal('hide');
            $("#competencesModal").modal();
            break;
        case MODULE_LIEN :
            $("#moduleModal").modal('hide');
            $("#lienModal").modal();
            break;
        case MODULE_STACKOVERFLOW :
            $("#moduleModal").modal('hide');
            $("#stackOverflowModal").modal();
            break;
        case MODULE_IMAGE :
            $("#moduleModal").modal('hide');
            $("#imageModuleModal").modal();
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
        "<div class=\"card-header\">&nbsp;"+
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body\">\n" +
        "<p class=\"card-text\">" + text + "</p>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: 0});
    grid.layout();
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
    $("#competencesModal").modal('hide');
}

function addLienModule(titre, lien, image) {
    var element = document.createElement('div');
    element.className = "item";
    element.style.width = "8rem";
    element.style.height = "8rem";
    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width: 8rem%;height:8rem;\">\n"+
        "<div class=\"card card-disabled\" style=\"width:8rem;height:8em;background-size:8rem 8rem;background-image: url('"+image+"');\" data-value=\"" + lien + "\">\n"+
        "<div class=\"card-header bg-transparent border-bottom-0\">" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: 0});
    grid.layout();
    $("#lienModal").modal('hide');
}

$("#updateDashboard").click(function () {
    grid.synchronize();
    $.ajax({
        type: 'POST',
        url: "/dashboard/updateDashboard",
        data: {html :$("#modGrid").html()}
}).done(function (data) {
        $("#updateModal").modal('hide');
    });
});

function addStackOverflowModule(userId) {
    $.ajax({
        type: 'GET',
        url: "https://api.stackexchange.com/2.2/users/"+userId+"?site=stackoverflow",
    }).done(function (data) {
        $.ajax({
            type: 'GET',
            url: "https://api.stackexchange.com/2.2/users/"+userId+"/tags?pagesize=3&order=desc&sort=popular&site=stackoverflow",
        }).done(function (topTags) {
            var element = document.createElement('div');
            element.className = "item";
            element.style.width = "15rem";
            element.innerHTML =
                "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width:15rem;\">\n"+
                "<div class=\"card\" style=\"width: 15rem;\">\n"+
                "<div class=\"card-header\">StackOverflow" +
                "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
                "</div>\n" +
                "<div class=\"card-body text-center\">\n"+
                "<p class=\"card-text bg-white text-center\">" +
                "<a href=\""+data.items[0].link+"\">"+
                "<img src=\""+data.items[0].profile_image+"\">"+
                "</a>"+
                "</p>\n" +
                "<h2 class=\"card-title\">"+data.items[0].reputation+"</h2>"+
                "<p class=\"card-text text-light\">Reputation</p>"+
                "<p class=\"card-text\"></p><span class=\"badge badge-light mx-1\">"+topTags.items[0].name+"</span><span class=\"badge badge-light mx-1\">"+topTags.items[1].name+"</span><span class=\"badge badge-light mx-1\">"+topTags.items[2].name+"</span></p>"+
                "<p class=\"card-text bg-white text-center\">\n" +
                "<span class=\"goldBadge badge sobadge\"><span class=\"goldDot\"> • </span>"+data.items[0].badge_counts.gold+"</span>"+
                "<span class=\"silverBadge badge sobadge\"><span class=\"silverDot\"> • </span>"+data.items[0].badge_counts.silver+"</span>"+
                "<span class=\"bronzeBadge badge sobadge\"><span class=\"bronzeDot\"> • </span>"+data.items[0].badge_counts.bronze+"</span>"+
                "</p>"+
                "</div>\n" +
                "</div>\n" +
                "</div>\n";
            grid.add(element, {index: 0});
            $("#lienModal").modal('hide');
        });
    });
}

function addImageModule(imageUrl,width,height) {
    var element = document.createElement('div');

    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width:"+width+"px;height:"+height+"px;\">\n"+
        "<div class=\"card\" style=\"width:"+width+"px;height:"+height+"px;background-size:"+width+"px "+height+"px;background-image: url('"+imageUrl+"');\">\n"+
        "<div class=\"card-header bg-transparent border-bottom-0\">"+
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    element.className = "item";
    element.style.width = width;
    element.style.height = height;
    grid.add(element, {index: 0});
    grid.layout();
    $("#addImageModule").modal('hide');
}