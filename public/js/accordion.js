$(document).ready(function () {

    if ($('.accordion-title').length > 0) {
        $('.accordion-title').each(function () {
            var $title = $(this);

            if ($title.next('.accordion-content').length > 0) {
                $title.prepend('<span class="accordion-symbol"></span> ')
                .css({
                    'display': 'block'
                    ,'padding': '8px 13px'
                    ,'border': '1px solid #ccc'
                    ,'background': '#d9d9d9'
                    ,'text-shadow': '2px 2px 0px rgba(255, 255, 255, 0.8)'
                    ,'font-size': '1em'
                    ,'cursor': 'pointer'
                });

                var $content = $title.next('.accordion-content')
                    ,$symbol = $title.find('.accordion-symbol');

                $content.css({
                    'padding': '8px 13px'
                    ,'overflow': 'auto'
                    ,'border': '1px solid #ccc'
                });

                if (!$content.hasClass('accordion-content-default')) {
                    $content.stop(true, true).slideUp(150, function () {
                        $symbol.html('+');
                    });
                } else {
                    $title.css('background-color', '#f2f2f2');
                    $symbol.html('-');
                }

                $title.on('click', function () {
                    $content.slideToggle(150, function () {
                        if ($content.is(':visible')) {
                            $title.css('background-color', '#f2f2f2');
                            $symbol.html('-');
                        } else {
                            $title.css('background-color', '#d9d9d9');
                            $symbol.html('+');
                        }
                    });
                });
            }
        });
    }

});