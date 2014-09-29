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



var accordionFx = function () {
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
};



var dataFx = function () {
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

            var closeButton = '<span class="data-more-details-btn-close">x</span>';

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
            }).hide(0, function () {
                if ($this.find('.data-more-details-btn-close').length < 1)
                    $this.prepend(closeButton);

                var $closeBtn = $this.children('.data-more-details-btn-close');
                $closeBtn.css({
                    'display': 'inline-block'
                    ,'width': '15px'
                    ,'height': '18px'
                    ,'padding': '5px 8px'
                    ,'border': '1px solid #ccc'
                    ,'background': '#fff'
                    ,'float': 'right'
                    ,'font-size': '12pt'
                    ,'text-align': 'center'
                    ,'color': '#333'
                    ,'cursor': 'pointer'
                }).hover(function () {
                    $closeBtn.css({
                        'background': '#ccc'
                        ,'text-shadow': '0px 0px 0px transparent'
                        ,'color': '#fff'
                    });
                }, function () {
                    $closeBtn.css({
                        'background': '#fff'
                        ,'color': '#333'
                    });
                }).click(function () {
                    $this.hide(0);
                });
            });

            $parent.mousemove(function (event) {
                // Have the fox follow the cursor
                // when the cursor go out of bounds
                // of the left and right border of
                // the box except if the mouse have
                // hovered out
                var mouseY = event.pageY
                    ,mouseX = event.pageX
                    ,boxWidth = $this.width()
                    ,boxLeft = $this.offset().left
                    ,boxRight = boxLeft + boxWidth;

                if (mouseX > (boxRight + 15)) {
                    $this.css({
                        'left': (mouseX - boxWidth) + 'px'
                    });
                } else if (mouseX < (boxLeft + 15)) {
                    $this.css({
                        'left': mouseX + 'px'
                    });
                }
            }).hover(function () {
                if ($('.data-more-details:visible').length > 0) {
                    $('.data-more-details:visible').hide(0);
                }
                $this.show(0);
            }, function () {
                $this.hide(0);
            });
        });
    }
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



var systemPagination = function (userOptions) {
    var options = $.extend({
        'itemsPerPage': '10'
    }, userOptions);

    if ($('table.paged').length > 0) {
        $('table.paged').each(function () {
            var $table = $(this)
                ,$tableBody = $table.children('tbody')
                ,itemsPerPage = options['itemsPerPage']
                ,totalItems = 0
                ,totalPages = 0
                ,paginationButtons = ''
                ,pages = []
                ,currentPage = 1
                ,targetPage = 1;

            if ($table.children('tr').length == 0)
                totalItems = $tableBody.children('tr').length;
            else
                totalItems = $table.children('tr').length;

            totalItems--;

            if (totalItems > itemsPerPage) {
                totalPages = totalItems / itemsPerPage;
                totalPages = Math.ceil(totalPages);

                // Get the table headers
                var $tmpTableHeaders = $tableBody.children('tr:nth-child(1)');
                $tmpTableHeaders.wrap('<p></p>');
                pages[0] = $tmpTableHeaders.parent('p').html();
                $tmpTableHeaders.parent('p').remove();

                for (var i = 1; i <= totalPages; i++) {
                    // Create the buttons
                    // for navigation
                    paginationButtons = paginationButtons + '<span class="unhighlightable pagination-navigation-buttons" data-page="'+ i +'">'+ i +'</span>';

                    // Create the the contents of
                    // each pages
                    var pageContent = '';
                    for (var j = 1; j <= itemsPerPage; j++) {
                        var $data = $tableBody.children('tr:nth-child(1)');
                        $data.wrap('<p></p>');
                        pageContent = pageContent + $data.parent('p').html();
                        $data.parent('p').remove();
                    }
                    pages[i] = pageContent;
                }
                paginationButtons = '<div class="pagination-navigation">'
                    +'<span class="unhighlightable pagination-navigation-buttons" data-page="1">First</span>'
                    +'<span class="unhighlightable pagination-navigation-buttons" data-page="prev">Prev</span>'
                    + paginationButtons
                    +'<span class="unhighlightable pagination-navigation-buttons" data-page="next">Next</span>'
                    +'<span class="unhighlightable pagination-navigation-buttons" data-page="'+ totalPages +'">Last</span>'
                    +'</div>'

                $table
                    .before(paginationButtons)
                    .after(paginationButtons);

                var $navigationTop = $table.prev('.pagination-navigation')
                    ,$navigationBottom = $table.next('.pagination-navigation')
                    ,$navigation = $navigationTop.add($navigationBottom);
                $navigation.children('.pagination-navigation-buttons').each(function () {
                    var $button = $(this)
                        ,pageNo = $button.html();

                    // Render first load
                    // contents of the page
                    // highlight of the button
                    $tableBody
                        .html(pages[currentPage])
                        .prepend(pages[0]);
                    $navigation
                        .find('span[data-page="1"]')
                        .addClass('currentPage');
                    $navigation
                        .find('span[data-page="prev"]')
                        .addClass('disabled');

                    $button.click(function () {
                        if (!$(this).hasClass('disabled')) {
                            switch (pageNo) {
                                case 'First':
                                    targetPage = 1;
                                    break;

                                case 'Prev':
                                    targetPage = currentPage - 1;
                                    if (targetPage < 1)
                                        targetPage = 1;
                                    break;

                                case 'Next':
                                    targetPage = currentPage + 1;
                                    if (targetPage > totalPages)
                                        targetPage = totalPages;
                                    break;

                                case 'Last':
                                    targetPage = totalPages;
                                    break;

                                default:
                                    targetPage = pageNo;
                            }

                            // pages[0] holds the
                            // content for table
                            // headers
                            $tableBody
                                .html(pages[targetPage])
                                .prepend(pages[0]);
                            currentPage = targetPage;

                            $navigation
                                .find('.currentPage')
                                .removeClass('currentPage');
                            $navigation
                                .find('span[data-page="'+ currentPage +'"]')
                                .addClass('currentPage');

                            if (currentPage == 1)
                                $navigation
                                    .find('span[data-page="prev"]')
                                    .addClass('disabled');
                            else
                                $navigation
                                    .find('span[data-page="prev"]')
                                    .removeClass('disabled');

                            if (currentPage == totalPages)
                                $navigation
                                    .find('span[data-page="next"]')
                                    .addClass('disabled');
                            else
                                $navigation
                                    .find('span[data-page="next"]')
                                    .removeClass('disabled');

                            dataFx();
                        }
                    });
                });
            }

            // Paged table are hidden by default
            // in the CSS, this will show the paged
            // table on load of the document
            $table.slideDown(150);
        });
        
    }
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