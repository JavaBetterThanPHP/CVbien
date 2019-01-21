function initProfilePicture() {
    var canvas = $("#canvas"),
        context = canvas.get(0).getContext("2d"),
        $result = $('#result');
        $("#canvas").hide();
    $('#fileInput').change(function () {
        $("#canvas").show();
        var reader = new FileReader();
        reader.onload = function (evt) {
            var img = new Image();
            img.onload = function () {
                context.canvas.height = img.height;
                context.canvas.width  = img.width;
                context.drawImage(img, 0, 0);
                var cropper = canvas.cropper({
                    viewMode: 1,
                    aspectRatio: 1/1,
                    zoomable : false
                });
            };
            img.src = evt.target.result;
        };
        reader.readAsDataURL(this.files[0]);
        $('#fileInput').hide();
    });
}