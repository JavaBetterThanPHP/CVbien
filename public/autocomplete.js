function initProgLanguageAutoComplete() {
    $("[name='user_prog_language_front[progLanguage]']").autocomplete({
        serviceUrl: '/dashboard/progLanguage/',
        minChars : 3,
        autoSelectFirst : true,
        deferRequestBy : 200,
    });
}

$('.initAuto').click(function () {
    initProgLanguageAutoComplete();
});

