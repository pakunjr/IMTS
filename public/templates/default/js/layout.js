$(document).ready(function () {

    /**
     * Resize content base on the width of the window,
     * thus, creating a fluid layout
     */
    if ($('#main-content').length > 0) {
        var $mc = $('#main-content');

        if ($(window).width() > 400)
            $mc.css('width', ($(window).width() - 150) + 'px');
        else
            $mc.css('width', (400 - 150) + 'px');

        $(window).on('resize', function () {
            if ($(window).width() > 400)
                $mc.css('width', ($(window).width() - 150) + 'px');
            else
                $mc.css('width', (400 - 150) + 'px')
        });
    }

});