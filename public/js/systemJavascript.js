var systemBootstrapJs = function () {
    /**
     * This function should be called by the
     * active theme's bootstrap or $(document)
     * .ready()
     */

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

            $this.css({
                'display': 'block'
                ,'max-width': $('#main-content').width() + 'px'
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

            $parent.mousemove(function (event) {
                $this.css({
                    'top': (event.pageY + 10) + 'px'
                    ,'left': (event.pageX + 10) + 'px'
                });
            }).hover(function () {
                $this.show(0);
                var itemName = $parent
                        .children('td:first-child')
                        .find('b:nth-child(1)')
                        .html()
                    ,urlUpdateItem = null
                    ,urlAddComopnent = null
                    ,urlArchiveItem = null
                    ,urlDeleteItem = null
                    ,urlGenerateProfileCard = null
                    ,urlTraceItem = null
                    ,urlNiboti = null;

                if ($this.find('input[value="Update Item"]').length > 0) {
                    var $e = $this.find('input[value="Update Item"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 1 to update the item</span><br />');
                    $a.remove();
                    urlUpdateItem = url;
                }

                if ($this.find('input[value="Add Component"]').length > 0) {
                    var $e = $this.find('input[value="Add Component"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 2 to add a component</span><br />');
                    $a.remove();
                    urlAddComponent = url;
                }

                if ($this.find('input[value="Archive Item"]').length > 0) {
                    var $e = $this.find('input[value="Archive Item"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 3 to archive the item</span><br />');
                    $a.remove();
                    urlArchiveItem = url;
                }

                if ($this.find('input[value="Delete Item"]').length > 0) {
                    var $e = $this.find('input[value="Delete Item"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 7 to delete the item</span><br />');
                    $a.remove();
                    urlDeleteItem = url;
                }

                if ($this.find('input[value="Generate Profile Card"]').length > 0) {
                    var $e = $this.find('input[value="Generate Profile Card"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 4 to generate profile card</span><br />');
                    $a.remove();
                    urlGenerateProfileCard = url;
                }

                if ($this.find('input[value="Trace Item"]').length > 0) {
                    var $e = $this.find('input[value="Trace Item"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 5 to trace the item</span><br />');
                    $a.remove();
                    urlTraceItem = url;
                }

                if ($this.find('input[value="NIBOTI"]').length > 0) {
                    var $e = $this.find('input[value="NIBOTI"]')
                        ,$a = $e.closest('a')
                        ,url = $a.attr('href');
                    $a.before('<span style="display: inline-block;">Press 6 to add new item based on this item</span><br />');
                    $a.remove();
                    urlNiboti = url;
                }

                $(document).keydown(function (event) {
                    var pressedKey = event.keyCode || event.which;
                    switch (pressedKey) {
                        case '49': case 49:
                            if (urlUpdateItem != null)
                                window.location = urlUpdateItem;
                            break;

                        case '50': case 50:
                            if (urlAddComponent != null)
                                window.location = urlAddComponent;
                            break;

                        case '51': case 51:
                            if (urlArchiveItem != null) {
                                var confirmMsg = 'Do you want to archive this item?'
                                    +'<div class="hr-light"></div>'
                                    +itemName
                                    +'<div class="hr-light"></div>'
                                    +'<span style="color: #f00;">You\'ll need at least a Supervisor account to undo this action.</span>';
                                myConfirm(confirmMsg, function () {
                                    window.location = urlArchiveItem;
                                });
                                $this.hide(0);
                            }
                            break;

                        case '52': case 52:
                            if (urlGenerateProfileCard != null)
                                window.location = urlGenerateProfileCard;
                            break;

                        case '53': case 53:
                            if (urlTraceItem != null)
                                window.location = urlTraceItem;
                            break;

                        case '54': case 54:
                            if (urlNiboti != null)
                                window.location = urlNiboti;
                            break;

                        case '55': case 55:
                            if (urlDeleteItem != null) {
                                var confirmMsg = 'Do you want to Delete this Item?'
                                    +'<div class="hr-light"></div>'
                                    + itemName
                                    +'<div class="hr-light"></div>'
                                    +'<span style="color: #f00;">This action is irreversible, once the item has been deleted in the database, it will no longer be restored.</span>';
                                myConfirm(confirmMsg, function () {
                                    window.location = urlDeleteItem;
                                });
                            }
                            break;

                        default:
                            // alert(pressedKey);
                    }
                });
            }, function () {
                $this.hide(0);
                $(document).unbind('keydown');
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
};

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
                ,'max-height': '350px'
                ,'padding': '3px'
                ,'overflow': 'auto'
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
                    if (!$sbcr.is(':hover'))
                        $sbcr.remove();
                    else {
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
    // Equivalent to PHP function nl2br()
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