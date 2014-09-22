var myPopup = function (type, message, myAction) {
    if ($('#mypopup-container').length > 0)
        $('#mypopup-container').remove();

    var popupTitle = '';
    switch (type) {
        case 'confirm':
            popupTitle = 'Confirm';
            break;

        case 'prompt':
            popupTitle = 'Prompt';
            break;

        default:
            popupTitle = 'Information';
    }

    var $body = $('body')
        ,htmlCode = '<div id="mypopup-container">'
            +'<span id="mypopup-body">'
                +'<span id="mypopup-title">'+popupTitle+'</span>'
                +'<span id="mypopup-content">'+message+'</span>'
                +'<span id="mypopup-buttons"></span>'
            +'</span>'
            +'</div>';
    $body.append(htmlCode);

    var $popupContainer = $('#mypopup-container')
        ,$popupBody = $('#mypopup-body')
        ,$popupTitle = $('#mypopup-title')
        ,$popupContent = $('#mypopup-content')
        ,$popupBtns = $('#mypopup-buttons');

    switch (type) {
        case 'confirm':
            $popupBtns.html('<input id="mypopup-button-yes" class="btn-green" type="button" value="Yes" />'
                +'<input id="mypopup-button-no" class="btn-red" type="button" value="No" />');
            break;

        case 'prompt':
            break;

        default:
            $popupBtns.html('<input id="mypopup-button-ok" type="button" value="Ok" />');
    }

    $popupContainer.css({
        'display': 'block'
        ,'width': $(window).width() + 'px'
        ,'height': $(window).height() + 'px'
        ,'position': 'fixed'
        ,'top': '0px'
        ,'left': '0px'
        ,'z-index': '1000'
        ,'background': 'rgba(89, 111, 128, 0.75)'
        ,'text-align': 'center'
    });

    $popupBody.css({
        'display': 'inline-block'
        ,'max-width': '350px'
        ,'margin-top': (($(window).height() / 2)
            - ($popupBody.height() / 2)
            - 40)
            + 'px'
        ,'padding': '10px 15px'
        ,'border-radius': '3px'
        ,'border': '1px solid #333'
        ,'background': '#f7f7f7'
        ,'box-shadow': '3px 3px 3px rgba(0, 0, 0, 0.2)'
        ,'text-align': 'center'
    });

    $popupTitle.css({
        'display': 'block'
        ,'padding': '5px 0px'
        ,'font-family': 'Georgia'
        ,'font-size': '1.1em'
        ,'text-align': 'left'
        ,'text-transform': 'capitalize'
    });

    $popupContent.css({
        'display': 'block'
        ,'margin': '0px 0px 5px 0px'
        ,'padding': '10px 13px'
        ,'border-radius': '3px'
        ,'border': '1px solid #ccc'
        ,'background': '#fff'
        ,'font-size': '0.9em'
        ,'text-align': 'left'
    });

    $popupBtns.css({
        'display': 'block'
        ,'text-align': 'center'
    });

    $(window).on('resize', function () {
        $popupContainer.css({
            'width': $(window).width() + 'px'
            ,'height': $(window).height() + 'px'
        });

        $popupBody.css({
            'margin-top': (($(window).height() / 2)
                - ($popupBody.height() / 2)
                - 40)
                + 'px'
        });
    });

    $popupContainer.fadeIn(50, function () {
        $popupBody.css({
            'margin-top': (($(window).height() / 2)
                - ($popupBody.height() / 2)
                - 40)
                + 'px'
        });

        myAction();
    });
};



var myAlert = function (message, myAction) {
    myPopup('alert', message, function () {
        var $popupContainer = $('#mypopup-container')
            ,$popupBtnOk = $('#mypopup-button-ok');

        $popupBtnOk.on('click', function () {
            $popupContainer.remove();
            myAction();
        });
    });
};



var myConfirm = function (message, myAction) {
    myPopup('confirm', message, function () {
        var $popupContainer = $('#mypopup-container')
            ,$popupBtnYes = $('#mypopup-button-yes')
            ,$popupBtnNo = $('#mypopup-button-no');

        $popupBtnYes.on('click', function () {
            $popupContainer.remove();
            myAction();
        });

        $popupBtnNo.on('click', function () {
            $popupContainer.remove();
        });
    });
};



var myPrompt = function (message, myAction) {
    myPopup('prompt', message, function () {
        var $popupBtns = $('#mypopup-buttons');
        $popupBtns.html();
    });
};