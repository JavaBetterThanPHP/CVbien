const MODULE_TEXTE = "Texte";
const MODULE_COMPETENCES = "Competences";
const MODULE_LIEN = "Lien";
const MODULE_STACKOVERFLOW = "StackOverflow";
const MODULE_IMAGE = "Image";
const MODULE_CODEPEN = "Codepen";
const MODULE_GITHUB = "Github";
const MODULE_TWITTER = "Twitter";
const MODULE_INSTAGRAM = "Instagram";
const MODULE_REPLIT = "Repl.it";
const MODULE_SOUNDCLOUD = "SoundCloud";
const MODULE_MEDIUM = "Medium";

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
        case MODULE_CODEPEN :
            $("#moduleModal").modal('hide');
            $("#codepenModal").modal();
            break;
        case MODULE_GITHUB:
            $("#moduleModal").modal('hide');
            $("#githubModal").modal();
            break;
        case MODULE_TWITTER:
            $("#moduleModal").modal('hide');
            $("#twitterModuleModal").modal();
            break;
        case MODULE_INSTAGRAM:
            $("#moduleModal").modal('hide');
            $("#instagramModal").modal();
            break;
        case MODULE_REPLIT:
            $("#moduleModal").modal('hide');
            $("#replitModal").modal();
        case MODULE_SOUNDCLOUD:
            $("#moduleModal").modal('hide');
            $("#soundcloudModal").modal();
            break;
        case MODULE_MEDIUM:
            $("#moduleModal").modal('hide');
            $("#mediumModal").modal();
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
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);\">" +
        "<div class=\"card\">\n" +
        "<div class=\"card-header\">&nbsp;" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>" +
        "<div class=\"card-body\">" +
        text +
        "</div>" +
        "</div>" +
        "</div>";
    grid.add(element, {index: -1});
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
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width:30rem;\">\n" +
        "<div class=\"card\" style=\"width: 30rem;\">\n" +
        "<div class=\"card-header\">Compétences" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body\">\n" + body +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: -1});
    $("#competencesModal").modal('hide');
}

function addLienModule(titre, lien, image) {
    var element = document.createElement('div');
    element.className = "item";
    element.style.width = "8rem";
    element.style.height = "8rem";
    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width: 8rem%;height:8rem;\">\n" +
        "<div class=\"card card-disabled\" style=\"width:8rem;height:8em;background-size:8rem 8rem;background-image: url('" + image + "');\" data-value=\"" + lien + "\">\n" +
        "<div class=\"card-header bg-transparent border-bottom-0\">" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    grid.add(element, {index: -1});
    $("#lienModal").modal('hide');
}

$("#updateDashboard").click(function () {
    grid.synchronize();
    $.ajax({
        type: 'POST',
        url: "/dashboard/updateDashboard",
        data: {html: $("#modGrid").html()}
    }).done(function (data) {
        $("#updateModal").modal('hide');
    });
});

function addStackOverflowModule(userId) {
    $.ajax({
        type: 'GET',
        url: "https://api.stackexchange.com/2.2/users/" + userId + "?site=stackoverflow",
    }).done(function (data) {
        $.ajax({
            type: 'GET',
            url: "https://api.stackexchange.com/2.2/users/" + userId + "/tags?pagesize=3&order=desc&sort=popular&site=stackoverflow",
        }).done(function (topTags) {
            var element = document.createElement('div');
            element.className = "item";
            element.style.width = "15rem";
            element.innerHTML =
                "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width:15rem;\">\n" +
                "<div class=\"card\" style=\"width: 15rem;\">\n" +
                "<div class=\"card-header\">StackOverflow" +
                "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
                "</div>\n" +
                "<div class=\"card-body text-center\">\n" +
                "<a href=\"" + data.items[0].link + "\" target='_blank'>" +
                "<img width='100%' src=\"" + data.items[0].profile_image + "\" class=\"rounded\">" +
                "</a>" +
                "<h2 class=\"card-title mt-3\">" + data.items[0].display_name + "</h2>" +
                "<h2 class=\"card-title\">" + data.items[0].reputation + "</h2>" +
                "<p class=\"card-text text-secondary\">Reputation</p>" +
                "<p class=\"card-text\"></p><span class=\"badge badge-light mx-1\">" + ((topTags.items[0]) ? topTags.items[0].name : "") + "</span><span class=\"badge badge-light mx-1\">" + ((topTags.items[1]) ? topTags.items[1].name : "") + "</span><span class=\"badge badge-light mx-1\">" + ((topTags.items[2]) ? topTags.items[2].name : "") + "</span></p>" +
                "<div class=\"card-footer bg-white text-center\">\n" +
                "<span class=\"goldBadge badge\"><span class=\"goldDot\"> • </span>" + data.items[0].badge_counts.gold + "</span>" +
                "<span class=\"silverBadge badge\"><span class=\"silverDot\"> • </span>" + data.items[0].badge_counts.silver + "</span>" +
                "<span class=\"bronzeBadge badge\"><span class=\"bronzeDot\"> • </span>" + data.items[0].badge_counts.bronze + "</span>" +
                "</div>" +
                "</div>\n" +
                "</div>\n" +
                "</div>\n";
            grid.add(element, {index: -1});
            $("#lienModal").modal('hide');
        });
    });
}

function addGithubModule(e, userId) {
    e.preventDefault();
    $.ajax({
        type: 'GET',
        url: "https://api.github.com/users/" + userId,
    }).done(function (data) {
        var element = document.createElement('div');
        element.className = "item";
        element.style.width = "15rem";
        element.innerHTML =
            "<div class='item-content'>" +
            "<div class='card'>" +
            "<div class='card-header'>Github" +
            "<button class='btn btn-link float-right' onclick='deleteModule(this)'><i class='far fa-trash-alt'></i></button>" +
            "</div>" +
            "<div class='card-body'>" +
            "<a href='" + data.html_url + "' target='_blank'>" +
            "<img class='rounded' width='100%' src='" + data.avatar_url + "' class='mt-2'>" +
            "</a>" +
            "<h2 class='card-title mt-3'>" + data.name + "</h2>" +
            "<p class='card-text'>" + data.login + "</p>" +
            "<span class='card-text'>" + data.bio + "</span><br/>" +
            "<span class='card-text'>" + "Followers : " + data.followers + "</span><br/>" +
            "<span class='card-text'>" + "Repositories : " + data.public_repos + "</span>" +
            "</div>" +
            "</div>" +
            "</div>";
        grid.add(element, {index: -1});
        $("#lienModal").modal('hide');
    }).fail(function (err) {
        console.error("user " + err.responseJSON.message);
    });
}

function addImageModule(imageUrl, width, height) {
    var element = document.createElement('div');
    element.innerHTML =
        "<div class=\"item-content\" style=\"opacity: 1; transform: scale(1);width:" + width + "px;height:" + height + "px;\">\n" +
        "<div class=\"card\" style=\"width:" + width + "px;height:" + height + "px;background-size:" + width + "px " + height + "px;background-image: url('" + imageUrl + "');\">\n" +
        "<div class=\"card-header bg-transparent border-bottom-0\">" +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    element.className = "item";
    element.style.width = width;
    element.style.height = height;
    grid.add(element, {index: -1});
    $("#addImageModule").modal('hide');
}

function addCodepenModule(penUrl) {
    $.ajaxSetup({'cache':true});
    $.ajax({
        type: 'GET',
        dataType: "jsonp",
        url: "http://codepen.io/api/oembed/?url="+penUrl+"&format=js&callback=dataCallBack",
    }).done(function (data) {
        var element = document.createElement('div');
        element.innerHTML =
            "<div class=\"item-content\">\n"+
            "<div class=\"card\">\n"+
            "<div class=\"card-header\">"+
            "Codepen : "+ data.title+
            "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
            "</div>\n" +
            "<div class=\"card-body text-center\">\n"+
            data.html+
            "</div>\n" +
            "</div>\n" +
            "</div>\n";
        element.className = "item";
        grid.add(element, {index: -1});
        $("#codepenModal").modal('hide');
    });
}

function addTwitterModule(twitterUsername, width, height) {
    var element = document.createElement('div');
    element.innerHTML =
        "<div class=\"item-content\">\n"+
        "<div class=\"card\">\n"+
        "<div class=\"card-header bg-transparent border-bottom-0\">"+
        "Twitter"+
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body text-center\">\n"+
        "<a class=\"twitter-timeline\" data-width=\""+width+"\" data-height=\""+height+"\" data-theme=\"dark\" href=\"https://twitter.com/"+twitterUsername+"\">" +
        "</a>"+
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    element.className = "item";
    grid.add(element, {index: -1});
    twttr.widgets.load(
        document.getElementsByClassName("twitter-timeline")
    );
    $("#twitterModuleModal").modal('hide');
}

function addInstagramModule(instagramPostUrl) {
    $.ajaxSetup({'cache':true});
    $.ajax({
        type: 'GET',
        url: "https://api.instagram.com/oembed?url="+instagramPostUrl,
    }).done(function (data) {
        var element = document.createElement('div');
        element.innerHTML =
            "<div class=\"item-content\">\n"+
            "<div class=\"card\">\n"+
            "<div class=\"card-header\">&nbsp;" +
            "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
            "</div>\n" +
            "<div class=\"card-body text-center\">\n"+
            data.html+
            "</div>\n" +
            "</div>\n" +
            "</div>\n";
        element.className = "item";
        grid.add(element, {index: -1});
        instgrm.Embeds.process();
        $("#instagramModal").modal('hide');
    });
}

function addReplitModule(title,replitUrl,width,height,hideCode) {
    var element = document.createElement('div');
    var outputonly = hideCode ? "&outputonly=true" : "";
    element.innerHTML =
        "<div class=\"item-content\">\n"+
        "<div class=\"card\">\n"+
        "<div class=\"card-header\">" + title +
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body text-center\">\n"+
        "<iframe frameborder=\"0\" width=\""+width+"\" height=\""+height+"\" src=\""+replitUrl+"?lite=true"+outputonly+"\"></iframe>"+
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    element.className = "item";
    grid.add(element, {index: -1});
    $("#replitModal").modal('hide');
}

function addSoundcloudModule(soundCloudUrl) {
    $.ajax({
        type: 'GET',
        url: "https://soundcloud.com/oembed?format=json&url="+soundCloudUrl,
    }).done(function (data) {
        var element = document.createElement('div');
        element.innerHTML =
            "<div class=\"item-content\">\n"+
            "<div class=\"card\">\n"+
            "<div class=\"card-header bg-transparent border-bottom-0\">"+
            "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
            "</div>\n" +
            "<div class=\"card-body text-center\">\n"+
            data.html+
            "</div>\n" +
            "</div>\n" +
            "</div>\n";
        element.className = "item";
        grid.add(element, {index: -1});
        $("#soundcloudModal").modal('hide');
    });
}

function addMediumModule(mediumUrl) {
    var element = document.createElement('div');
    element.innerHTML =
        "<div class=\"item-content\">\n"+
        "<div class=\"card\">\n"+
        "<div class=\"card-header\">Medium"+
        "<button class=\"btn btn-link float-right\" onclick=\"deleteModule(this)\"><i class=\"far fa-trash-alt\"></i></button>\n" +
        "</div>\n" +
        "<div class=\"card-body text-center\">\n"+
        "<div id=\"retainable-rss-embed\"\n" +
        "data-rss=\""+mediumUrl+"\"\n" +
        "data-maxcols=\"3\"\n" +
        "data-layout=\"slider\"\n" +
        "data-poststyle=\"modal\"\n" +
        "data-readmore=\"Read\"\n" +
        "data-buttonclass=\"btn btn-primary\"\n" +
        "data-offset=\"-100\"></div>"+
        "</div>\n" +
        "</div>\n" +
        "</div>\n";
    element.className = "item";
    grid.add(element, {index: -1});
    $("#soundcloudModal").modal('hide');
}




