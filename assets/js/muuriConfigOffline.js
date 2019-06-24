$(document).ready(function () {
    window.grid = new Muuri('.grid', {dragEnabled: false});
    $( ".card-header .btn" ).remove();
    $( ".card-disabled").css("cursor", "pointer");
    $( ".card-disabled" ).each(function() {
        $( this ).on("click",function (){window.open($( this ).data("value"))});
    });
});