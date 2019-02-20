function initProgLanguageAutoComplete() {
    $("[name='user_prog_language_front[progLanguage]']").autocomplete({
        serviceUrl: '/dashboard/progLanguage/',
        minChars : 3,
        autoSelectFirst : true,
        deferRequestBy : 150,
        showNoSuggestionNotice:true,
        noSuggestionNotice: '<div class="alert alert-danger" role="alert">This is a danger alert—check it out! </div>'
    });
}

$('.initAuto').click(function () {
    initProgLanguageAutoComplete();
});

