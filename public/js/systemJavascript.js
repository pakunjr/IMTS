var systemPopup = function (type, message, myAction) {
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
    systemPopup('alert', message, function () {
        var $popupContainer = $('#mypopup-container')
            ,$popupBtnOk = $('#mypopup-button-ok');

        $popupBtnOk.on('click', function () {
            $popupContainer.remove();
            myAction();
        });
    });
};

var myConfirm = function (message, myAction) {
    systemPopup('confirm', message, function () {
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
    systemPopup('prompt', message, function () {
        var $popupBtns = $('#mypopup-buttons');
        $popupBtns.html();
    });
};



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



var pagination = function (userOptions) {
    // This function is underconstruction
    // or is still in planning stage as
    // there is no complete idea of its
    // implementation

    var options = $.extend({
        'table' : null
        ,'itemsPerPage': '20'
        ,'currentPage': '1'
        ,'pageCount': ''
        ,'itemCount': ''
    }, userOptions);

    var $table = options['table'];

    if ($table == null)
        return false;
};



var nl2br = function (my_string) {
    // This is the equivalent of nl2br function
    // in PHP
    return (my_string + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+'<br />'+'$2');
};



var dateToWords = function (my_date) {
    // Converts layout of numerical date
    // into worded layout
    if (my_date == '0000-00-00')
        return 'N/A';

    var months = new Array(
        'January'
        ,'February'
        ,'March'
        ,'April'
        ,'May'
        ,'June'
        ,'July'
        ,'August'
        ,'September'
        ,'October'
        ,'November'
        ,'December');

    var dateSplit = my_date.split('-')
        ,date_year = dateSplit[0]
        ,date_month = dateSplit[1]
        ,date_day = dateSplit[2];

    return months[parseInt(date_month) - 1] + ' '
        + date_day + ', '
        + date_year;
};



$(document).ready(function () {

    // Set default settings for datepickers
    if ($('.datepicker').length > 0) {
        $('.datepicker').each(function () {
            var $this = $(this);

            if ($this.val().length == 0)
                $this.val('0000-00-00');

            $this.css({
                'cursor': 'pointer'
            }).prop('readonly', true).datepicker({
                showOtherMonths: true
                ,selectOtherMonths: false
                ,changeMonth: true
                ,changeYear: true
                ,'showAnim': 'slideDown'
                ,'dateFormat': 'yy-mm-dd'
            }).on('keyup', function (e) {
                var code = e.keyCode || e.which;
                if ( code == '27' || code == 27 ) {
                    $this.val('0000-00-00');
                    $this.blur();
                }
            });
        });
    }

    // Treat each data as a view button, detect if
    // the data is being used in an embedded search
    // to avoid undesirable result and errors
    if ($('#search-box-container').length < 1
            && $('.data').length > 0) {
        $('.data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url')
                ,$childHyperlinks = $this.children('a');

            if (!$this.hasClass('disabled')) {
                $this.addClass('special-hover').on('click', function () {
                    // Stop redirect if the mouse is hovered
                    // over a link or other specified elements
                    // in this condition
                    if ($('a:hover').length < 1
                        && $('.data-more-details:hover').length < 1)
                        window.location = url;
                });
            }
        });
    }

    // Shows hidden information related to
    // the data that is hovered into
    if ($('.data-more-details').length > 0) {
        $('.data-more-details').each(function () {
            var $this = $(this)
                ,$parent = $this.closest('tr');

            $this.prepend('<span class="btn-close">x</span>');
            $this.after('<div class="blacksheet"></div>');
            var $btnClose = $this.find('.btn-close')
                ,$blackSheet = $this.next('.blacksheet');

            $this.css({
                'display': 'block'
                ,'max-width': '350px'
                ,'min-width': '200px'
                ,'margin': '3px 0px 0px -18px'
                ,'padding': '13px 18px'
                ,'position': 'absolute'
                ,'z-index': '2'
                ,'border': '1px solid #ccc'
                ,'border-radius': '4px'
                ,'background': '#fff'
                ,'box-shadow': '2px 2px 3px rgba(0, 0, 0, 0.3)'
            }).hide(0);

            $blackSheet.css({
                'display': 'block'
                ,'width': $(window).width() + 'px'
                ,'height': $(window).height() + 'px'
                ,'position': 'fixed'
                ,'top': '0px'
                ,'left': '0px'
                ,'z-index': '1'
                ,'background-color': 'rgba(20, 58, 102, 0.3)'
            }).hide(0);

            $btnClose.css({
                'display': 'inline-block'
                ,'width': '15px'
                ,'height': '15px'
                ,'padding': '5px'
                ,'float': 'right'
                ,'border': '1px solid #b3b3b3'
                ,'border-radius': '20px'
                ,'background-color': '#ccc'
                ,'text-align': 'center'
                ,'cursor': 'pointer'
            });

            $btnClose.hover(function () {
                $btnClose.css({'background-color': '#f98e1b'});
            }, function () {
                $btnClose.css({'background-color': '#ccc'});
            });

            $parent.hover(function () {
                $this.show(0, function () {
                    $btnClose.click(function () {
                        $this.hide(0);
                    });

                    $this.hover(function () {
                        $blackSheet.show(0);
                    }, function () {
                        $blackSheet.hide(0);
                    });
                });
            }, function () {
                $this.hide(0);
            });

            $(window).on('resize', function () {
                $blackSheet.css({
                    'width': $(window).width() + 'px'
                    ,'height': $(window).height() + 'px'
                });
            });
        });
    }

    // Accordions
    if ($('.accordion-title').length > 0) {
        $('.accordion-title').each(function () {
            var $title = $(this);

            if ($title.next('.accordion-content').length > 0) {
                $title.prepend('<span class="accordion-symbol"></span> ')
                .css({
                    'display': 'block'
                    ,'padding': '8px 13px'
                    ,'border': '1px solid #143a66'
                    ,'background': '#265080'
                    ,'text-shadow': '2px 2px 0px rgba(0, 0, 0, 0.3)'
                    ,'font-size': '1em'
                    ,'color': '#fff'
                    ,'cursor': 'pointer'
                });

                var $content = $title.next('.accordion-content')
                    ,$symbol = $title.find('.accordion-symbol');

                $content.css({
                    'padding': '8px 13px'
                    ,'overflow': 'auto'
                    ,'border': '1px solid #143a66'
                });

                if (!$content.hasClass('accordion-content-default')) {
                    $content.stop(true, true).slideUp(0, function () {
                        $symbol.html('+');
                    });
                } else {
                    $title.css('background-color', '#5983b3');
                    $symbol.html('-');
                }

                $title.on('click', function () {
                    $content.slideToggle(0, function () {
                        if ($content.is(':visible')) {
                            $title.css('background-color', '#5983b3');
                            $symbol.html('-');
                        } else {
                            $title.css('background-color', '#265080');
                            $symbol.html('+');
                        }
                    });
                });
            }
        });
    }

    // Map of the input texts to be able to view
    // the whole content of input elements that
    // have limited view
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

    // By pressing the `Esc` key, contents of input
    // text is instantly erased
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

    // Removes generated <br /> tag by the
    // nl2br function on textareas
    if ($('textarea').length > 0) {
        $('textarea').each(function () {
            var $this = $(this)
                ,value = $this.val();

            $this.val(value.replace(/<br \/>/g, ''));
        });
    }

    // Set special features of the multiple
    // items input form, the form will not
    // work properly without these scripts
    if ($('#form-multiple-items').length > 0) {
        var $form = $('#form-multiple-items');
        $form.find('.item-type').each(function () {
            var $this = $(this)
                ,dataType = $this.attr('data-type');
            $this.hover(function () {
                $this.css({
                    'background': '#d9efff'
                    ,'text-shadow': '2px 2px 3px rgba(0, 0, 0, 0.2)'
                });
            }, function () {
                $this.css({
                    'background': 'transparent'
                    ,'text-shadow': '0px 0px 0px transparent'
                });
            }).css({
                'cursor': 'pointer'
            }).on('click', function () {
                // Duplicate the row related
                // to this type
                var rowspan = parseInt($this.attr('rowspan'))
                    ,htmlContents = ''
                    ,colFirst = $this.parent('tr').children('td:nth-child(2)').html()
                    ,colSecond = $this.parent('tr').children('td:nth-child(3)').html();

                rowspan++;
                $this.parent('tr').find('input, textarea, select').each(function () {
                    var $element = $(this)
                        ,dataCount = $element.attr('data-count')
                        ,dataType = $element.attr('data-type')
                        ,dataCategory = $element.attr('data-category')
                        ,currentId = dataCategory+'-'+dataType+'-'+dataCount
                        ,newId = dataCategory+'-'+dataType+'-'+rowspan
                        ,regFirst = new RegExp(currentId, 'g')
                        ,regSecond = new RegExp(currentId, 'g');

                    colFirst = colFirst.replace(regFirst, newId);
                    colSecond = colSecond.replace(regSecond, newId);
                });

                htmlContents = '<tr>'
                    +'<td>'+colFirst+'</td>'
                    +'<td>'+colSecond+'</td>'
                    +'</tr>';
                $this.parent('tr').after(htmlContents);
                $this.find('input, textarea, select').attr('data-count', rowspan);
                $this.prop('rowspan', rowspan);
            });
        });
    }

});