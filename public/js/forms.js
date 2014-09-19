var embedSearchFx = function ($user_options) {
    var options = $.extend({
        'url': null
        ,'o_label': null
        ,'o_id': null
    }, $user_options);

    if ( options['url'] == null
        && options['o_label'] == null
        && options['o_id'] == null )
        return false;

    var url = options['url']
        ,$o_label = options['o_label']
        ,$o_id = options['o_id']
        ,containerHTML = '<div id="search-box-container">'
            +'<div id="search-box-content">'
            +'</div>'
            +'</div>';

    $o_label.addClass('search-elements');
    $o_id.addClass('search-elements');

    if ($o_id.val() != '0' && $o_id.val() != '') {
        $o_label.addClass('searchbox-readonly');
    }

    $o_label.on('focusin keyup', function () {
        if ($o_label.val() == 'None') $o_label.val('');

        if ($o_id.val() == '0' || $o_id.val() == '') {
            $o_label
            .prop('readonly', false)
            .removeClass('searchbox-readonly')
            .on('keyup', function (e) {
                var code = e.keyCode || e.which;
                if (code == '27' || code == 27)
                    $o_label.val('');
            });

            if ($('#search-box-container').length > 0)
                $('#search-box-container').remove();

            $('body').append(containerHTML);

            var $sbcr = $('#search-box-container')
                ,$sbct = $('#search-box-content')
                ,xCoord = $o_label.offset().left
                ,yCoord = $o_label.offset().top
                ,query = $o_label.val();

            $sbcr.css({
                'display': 'block'
                ,'padding': '3px'
                ,'position': 'absolute'
                ,'top': (yCoord + $o_label.height() + 12) + 'px'
                ,'left': xCoord + 'px'
                ,'border-radius': '3px'
                ,'border': '1px solid #aaa'
                ,'background': '#fff'
            });
            $(window).on('resize', function () {
                var xCoord = $o_label.offset().left
                    ,yCoord = $o_label.offset().top;
                $sbcr.css({
                    'top': (yCoord + $o_label.height() + 12) + 'px'
                    ,'left': xCoord + 'px'
                });
            });

            $sbct.css({
                'display': 'block'
                ,'padding': '10px 15px'
                ,'border-radius': '3px'
                ,'border': '1px solid #aaa'
                ,'font-size': '0.95em'
                ,'text-align': 'left'
            });

            $sbct.load(url+query+'/', function () {
                $('.data').each(function () {
                    var $this = $(this)
                        ,dataId = $this.attr('data-id')
                        ,dataLabel = $this.attr('data-label');

                    $this.addClass('special-hover')
                    .css('cursor', 'pointer')
                    .on('click', function () {
                        $sbcr.remove();
                        $o_id.val(dataId);
                        $o_label.prop('readonly', true).addClass('searchbox-readonly').val(dataLabel);
                    });
                });

                $o_label.on('focusout', function () {
                    if (!$sbcr.is(':hover')) {
                        $sbcr.remove();
                    } else {
                        $sbcr.on('mouseout', function () {
                            if (!$o_label.is(':focus'))
                                $sbcr.remove();
                        });
                    }
                });
            });
        } else {
            $o_label.prop('readonly', true);

            if (!$o_label.hasClass('searchbox-readonly'))
                $o_label.addClass('searchbox-readonly');

            $o_label.on('keyup', function (e) {
                var code = e.keyCode || e.which;
                if (code == '27' || code == 27) {
                    $o_id.val('0');
                    $o_label.prop('readonly', false).removeClass('searchbox-readonly').val('');
                }
            });
        }
    });
};



$(document).ready(function () {

    /**
     * A reader that shows up to shows the users the html output
     * or the complete content of the form element they're inputting
     * or hovering over
     */
    if ($('input[type="text"], textarea, select').length > 0) {
        $('input[type="text"], textarea, select').each(function () {
            var $this = $(this)
                ,$body = $('body');

            var readerHTML = '<div id="form-elements-reader-container">'
                +'<div id="form-elements-reader-content">'
                +'</div>'
                +'</div>';

            $this.on('mouseover focusin', function () {
                var yCoord = $this.offset().top
                    ,xCoord = $this.offset().left;

                if ($('#form-elements-reader-container').length > 0)
                    $('#form-elements-reader-container').remove();

                $body.after(readerHTML);

                if ($this.is('select'))
                    var thisVal = $this.find('option:selected').html();
                else if ($this.hasClass('datepicker'))
                    var thisVal = dateToWords($this.val());
                else
                    var thisVal = $this.val();
                thisVal = nl2br(thisVal);

                var $ferContainer = $('#form-elements-reader-container')
                    ,$ferContent = $('#form-elements-reader-content')
                    ,$fcnr = $ferContainer
                    ,$fcnt = $ferContent;

                $fcnr.css({
                    'display': 'inline-block'
                    ,'max-width': '250px'
                    ,'padding': '2px'
                    ,'position': 'absolute'
                    ,'top': yCoord + $this.height() + 12 + 'px'
                    ,'left': xCoord + 'px'
                    ,'overflow': 'hidden'
                    ,'border-radius': '4px'
                    ,'border': '1px solid #ccc'
                    ,'background': '#fff'
                    ,'box-shadow': '2px 2px 3px rgba(0, 0, 0, 0.15)'
                    ,'text-align': 'left'
                    ,'word-wrap': 'break-word'
                });

                $fcnt.html(thisVal).css({
                    'display': 'block'
                    ,'padding': '10px 15px'
                    ,'border-radius': '4px'
                    ,'border': '1px solid #ccc'
                    ,'font-size': '0.85em'
                });

                $this.on('keyup change', function () {
                    if ($this.is('select'))
                        thisVal = $this.find('option:selected').html();
                    else if ($this.hasClass('datepicker'))
                        thisVal = dateToWords($this.val());
                    else
                        thisVal = $this.val();
                    thisVal = nl2br(thisVal);

                    $fcnt.html(thisVal);
                });
            }).on('mouseout', function () {
                if ($('#form-elements-reader-container').length > 0)
                    $('#form-elements-reader-container').remove();
            });
        });
    }



    /**
     * Enable users to remove the text instantly
     * in a form element by pressing the `Esc` key
     */
    if ($('input[type="text"], input[type="password"], textarea').length > 0) {
        $('input[type="text"], input[type="password"], textarea')
        .on('keyup', function (e) {
            var $this = $(this)
                ,code = e.keyCode || e.which;

            if (!$this.hasClass('datepicker')
                    && !$this.hasClass('search-elements')) {
                if (code == '27' || code == 27)
                    $this.val('');
            }
        });
    }



    /**
     * Replace or remove <br /> tags on textareas
     * that were generated by nl2br if there are
     * any
     */
    if ($('textarea').length > 0) {
        $('textarea').each(function () {
            var $this = $(this)
                ,value = $this.val();

            $this.val(value.replace(/<br \/>/g, ''));
        });
    }

});