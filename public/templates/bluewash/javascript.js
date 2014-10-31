var fnPageLayout = function () {
    if (
        $('#system-body').length > 0
        && $('#system-header').length > 0
        && $('#system-footer').length > 0
    ) {
        var $systemBody = $('#system-body'),
            $systemHeader = $('#system-header'),
            $systemFooter = $('#system-footer'),
            windowHeight = parseInt($(window).height()),
            headerHeight = parseInt($systemHeader.height()) +
                (parseInt($systemHeader.css('margin-top')) * 2) +
                (parseInt($systemHeader.css('padding-top')) * 2) +
                (parseInt($systemHeader.css('border-top-width')) * 2),
            footerHeight = parseInt($systemFooter.height()) +
                (parseInt($systemFooter.css('padding-top')) * 2) +
                (parseInt($systemFooter.css('margin-top')) * 2) +
                (parseInt($systemFooter.css('border-top-width')) * 2),
            desiredHeight = windowHeight - (headerHeight + footerHeight + 50);
        $systemBody.css({
            'height': desiredHeight +'px'
        });
    }
};



var fnUserProfileOptions = function () {
    if ($('#user-information-settings-options').length > 0) {
        if ($('#user-information-settings').length > 0) {
            var $uiSettings = $('#user-information-settings'),
                $uiSettingsOptions = $('#user-information-settings-options'),
                hoverTimeout = null;
            $uiSettingsOptions.css({
                'margin-left': - (
                        parseInt($uiSettingsOptions.width()) -
                        (
                                (parseInt($uiSettingsOptions.css('margin-left')) * 2) +
                                (parseInt($uiSettingsOptions.css('padding-left')) * 2) +
                                (parseInt($uiSettingsOptions.css('border-left-width')) * 2) +
                                (parseInt($uiSettings.find('img').width()))
                            )
                    ) +'px'
            });
            $uiSettings.hover(function () {
                    clearTimeout(hoverTimeout);
                    $uiSettingsOptions.stop(true, true).slideDown(150);
                }, function () {
                    hoverTimeout = setTimeout(function () {
                        $uiSettingsOptions.stop(true, true).slideUp(150);
                    }, 600);
            });
        }
    }
};



var fnFormSubmit = function () {
    if ($('form').length > 0) {
        $('form').each(function () {
            var $this = $(this);
            $this.find('input[type="submit"]').on('click', function () {
                if (confirm('Do you want to process the form?')) {
                    $this.submit();
                }
                return false;
            });
        });
    }
};



$(document).ready(function () {
    fnPageLayout();
    fnUserProfileOptions();
    fnFormSubmit();

    $(window).resize(function () {
        fnPageLayout();
    });
});