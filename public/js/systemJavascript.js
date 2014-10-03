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
        'width': $(window).width() + 'px'
        ,'height': $(window).height() + 'px'
    });

    $popupBody.css({
        'margin-top': (($(window).height() / 2)
            - ($popupBody.height() / 2)
            - 40)
            + 'px'
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



var formFx = function () {
    // Set default settings for datepickers
    if ($('.datepicker').length > 0) {
        $('.datepicker').each(function () {
            var $this = $(this);

            if ($this.val().length == 0)
                $this.val('0000-00-00');

            $this.css({
                'text-align': 'center'
                ,'cursor': 'pointer'
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

                var thisVal = '';
                
                if ($this.is('select'))
                    thisVal = $this.find('option:selected').html();
                else if ($this.hasClass('datepicker'))
                    thisVal = dateToWords($this.val());
                else
                    thisVal = $this.val();
                
                thisVal = nl2br(thisVal);

                var $fcnr = $('#form-elements-reader-container')
                    ,$fcnt = $('#form-elements-reader-content');

                $fcnr.css({
                    'top': yCoord + $this.height() + 12 + 'px'
                    ,'left': xCoord + 'px'
                });

                $fcnt.html(thisVal);

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



var accordionFx = function () {
    if ($('.accordion-title').length > 0) {
        $('.accordion-title').each(function () {
            var $title = $(this);

            if ($title.next('.accordion-content').length > 0) {
                $title.prepend('<span class="accordion-symbol"></span> ');

                var $content = $title.next('.accordion-content')
                    ,$symbol = $title.find('.accordion-symbol');

                if (!$content.hasClass('accordion-content-default')) {
                    $content.stop(true, true).slideUp(0, function () {
                        $symbol.html('+');
                    });
                } else {
                    $title.addClass('accordion-title-open');
                    $symbol.html('-');
                }

                $title
                    .addClass('unhighlightable')
                    .on('click', function () {
                    $content.slideToggle(150, function () {
                        if ($content.is(':visible')) {
                            $title.addClass('accordion-title-open');
                            $symbol.html('-');
                        } else {
                            $title.removeClass('accordion-title-open');
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

            // special-hover class is only used
            // by tables, tr specifically
            if (!$this.hasClass('disabled')) {
                $this.addClass('special-hover').on('click', function () {
                    // Stop redirect if the mouse is hovered
                    // over a link or other specified elements
                    // in this condition
                    if ($('a:hover').length < 1
                        && $('.data-more-details:hover').length < 1) {
                        window.location = url;
                    }
                });
            }
        });
    }

    // Shows hidden data upon right click
    if ($('.data-more-details').length > 0) {
        $('.data-more-details').each(function () {
            var $this = $(this)
                ,$parent = $this.closest('tr');

            var closeButton = '<span class="data-more-details-btn-close">x</span>';

            $this.addClass('unhighlightable').css({
                'max-width': (parseInt($('#main-content').width())
                        - parseInt($this.offset().left))
                    + 'px'
            }).hide(0, function () {
                if ($this.find('.data-more-details-btn-close').length < 1)
                    $this.prepend(closeButton);

                var $closeBtn = $this.children('.data-more-details-btn-close');
                $closeBtn.click(function () {
                    $this.hide(0);
                });
            });

            $parent.contextmenu(function () {
                // Disable the context menu, the menu
                // that shows up when mouse right button
                // is clicked
                return false;
            }).mousedown(function (event) {
                var clickedButton = event.which;
                if (clickedButton == 3 || clickedButton == '3') {
                    if ($('.data-more-details:visible').length > 0) {
                        $('.data-more-details:visible').hide(0);
                    }
                    $this.css({
                        'top': 'auto'
                        ,'left': 'auto'
                    }).show(0, function () {
                        // Hide the box when `Esc` key is pressed
                        $(document).keydown(function (event) {
                            var pressedKey = event.which;
                            if (pressedKey == '27' || pressedKey == 27) {
                                $this.hide(0, function () {
                                    $(document).unbind('keydown');
                                });
                            }
                        });

                        // Make the box draggable
                        draggable($this);
                    });
                    return false;
                }
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
            .on('keyup', function (event) {
                var pressedKey = event.which;
                if (pressedKey == '27' || pressedKey == 27)
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
                'top': (yCoord + $o_label.height() + 12) + 'px'
                ,'left': xCoord + 'px'
            });
            $(window).on('resize', function () {
                var xCoord = $o_label.offset().left
                    ,yCoord = $o_label.offset().top;
                $sbcr.css({
                    'top': (yCoord + $o_label.height() + 12) + 'px'
                    ,'left': xCoord + 'px'
                });
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



var tablePagination = function (userOptions) {
    var options = $.extend({
        'itemsPerPage': '10'
        ,'buttonRange': '3'
    }, userOptions);

    if ($('table.paged').length > 0) {
        $('table.paged').each(function () {
            var $table = $(this)
                ,$tableBody = $table.children('tbody')
                ,itemsPerPage = $table.attr('data-pagination-items-per-page')
                ,buttonRange = $table.attr('data-pagination-button-range')
                ,totalItems = 0
                ,totalPages = 0
                ,paginationButtons = ''
                ,pages = []
                ,currentPage = 1
                ,targetPage = 1;

            if (typeof itemsPerPage == 'undefined')
                itemsPerPage = options['itemsPerPage'];
            if (typeof buttonRange == 'undefined')
                buttonRange = options['buttonRange'];

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
                    paginationButtons = paginationButtons + '<span class="unhighlightable pagination-navigation-buttons hidden paged-button" data-page="'+ i +'">'+ i +'</span>';

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
                    +'<span class="unhighlightable pagination-navigation-buttons ellipsis-button" data-page="ellipsis-prev">...</span>'
                    + paginationButtons
                    +'<span class="unhighlightable pagination-navigation-buttons ellipsis-button" data-page="ellipsis-next">...</span>'
                    +'<span class="unhighlightable pagination-navigation-buttons" data-page="next">Next</span>'
                    +'<span class="unhighlightable pagination-navigation-buttons" data-page="'+ totalPages +'">Last</span>'
                    +'</div>'

                var paginationStatistics = '<div class="pagination-statistics">'
                    +'Total no. of data: '+ totalItems +'<br />'
                    +'Total no. of pages: '+ totalPages +'<br />'
                    +'Items per page: '+ itemsPerPage
                    +'</div>';

                $table
                    .before(paginationStatistics + paginationButtons)
                    .after(paginationButtons);

                var $navigationTop = $table.prev('.pagination-navigation')
                    ,$navigationBottom = $table.next('.pagination-navigation')
                    ,$navigation = $navigationTop.add($navigationBottom);
                $navigation.children('.pagination-navigation-buttons').each(function () {
                    var $button = $(this)
                        ,pageNo = $button.html();

                    // Render the paginated table
                    // upon first load
                    $tableBody
                        .html(pages[currentPage])
                        .prepend(pages[0]);
                    $navigation
                        .children('span[data-page="1"]')
                        .addClass('currentPage').removeClass('hidden');
                    $navigation
                        .children('span[data-page="prev"]')
                        .addClass('disabled');
                    $navigation
                        .children('.ellipsis-button[data-page="ellipsis-prev"]:visible')
                        .addClass('hidden');
                    if ($navigation.children('.paged-button[data-page="'+ totalPages +'"]:visible').length > 0) {
                        $navigation.children('.ellipsis-button[data-page="ellipsis-next"]:visible').addClass('hidden');
                    }

                    // Show buttons to the right
                    // for initial load
                    for (var c = currentPage; c <= parseInt(currentPage) + parseInt(buttonRange); c++) {
                        if (c <= totalPages) {
                            $navigation.children('.paged-button[data-page="'+ c +'"]').removeClass('hidden');
                        }
                    }

                    // Do these actions when a
                    // button in the navigation
                    // is clicked
                    $button.click(function () {
                        if (!$(this).hasClass('disabled')
                                && !$(this).hasClass('currentPage')) {
                            switch (pageNo) {
                                case '...':
                                    var ellipsisType = $button.attr('data-page')
                                        ,ellipsisTargetPage = 1;

                                    if (ellipsisType == 'ellipsis-prev') {
                                        ellipsisTargetPage = parseInt(parseInt(currentPage) - parseInt(buttonRange)) - parseInt(buttonRange);
                                        ellipsisTargetPage--;
                                        
                                        if (ellipsisTargetPage < 1) {
                                            ellipsisTargetPage = 1;
                                        }
                                    } else if (ellipsisType == 'ellipsis-next') {
                                        ellipsisTargetPage = parseInt(parseInt(currentPage) + parseInt(buttonRange)) + parseInt(buttonRange);
                                        ellipsisTargetPage++;
                                        
                                        if (ellipsisTargetPage > totalPages) {
                                            ellipsisTargetPage = totalPages;
                                        }
                                    }
                                    targetPage = ellipsisTargetPage;
                                    break;

                                case 'First':
                                    targetPage = 1;
                                    break;

                                case 'Prev':
                                    targetPage = parseInt(currentPage) - 1;
                                    if (targetPage < 1)
                                        targetPage = 1;
                                    break;

                                case 'Next':
                                    targetPage = parseInt(currentPage) + 1;
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
                                .children('.currentPage')
                                .removeClass('currentPage');
                            $navigation
                                .children('span[data-page="'+ currentPage +'"]')
                                .addClass('currentPage');

                            if (currentPage == 1)
                                $navigation
                                    .children('span[data-page="prev"]')
                                    .addClass('disabled');
                            else
                                $navigation
                                    .children('span[data-page="prev"]')
                                    .removeClass('disabled');

                            if (currentPage == totalPages)
                                $navigation
                                    .children('span[data-page="next"]')
                                    .addClass('disabled');
                            else
                                $navigation
                                    .children('span[data-page="next"]')
                                    .removeClass('disabled');

                            // Hide and show the other
                            // buttons that are near
                            // the current page's button
                            $navigation.children('.paged-button:visible').addClass('hidden');
                            $navigation.children('.paged-button[data-page="'+currentPage+'"]').removeClass('hidden');

                            // Show buttons to the left
                            for (var c = currentPage; c >= parseInt(currentPage) - parseInt(buttonRange); c--) {
                                if (c > 0) {
                                    $navigation.children('.paged-button[data-page="'+ c +'"]').removeClass('hidden');
                                }
                            }

                            // Show buttons to the right
                            for (var c = currentPage; c <= parseInt(currentPage) + parseInt(buttonRange); c++) {
                                if (c <= totalPages) {
                                    $navigation.children('.paged-button[data-page="'+ c +'"]').removeClass('hidden');
                                }
                            }

                            // Hide the right ellipsis
                            // if conditions are met
                            if ($navigation.children('.paged-button[data-page="'+ totalPages +'"]:visible').length > 0) {
                                $navigation.children('.ellipsis-button[data-page="ellipsis-next"]:visible').addClass('hidden');
                            } else {
                                $navigation.children('.ellipsis-button[data-page="ellipsis-next"]').removeClass('hidden');
                            }

                            // Hide the left ellipsis
                            // if conditions are met
                            if ($navigation.children('.paged-button[data-page="1"]:visible').length > 0) {
                                $navigation.children('.ellipsis-button[data-page="ellipsis-prev"]').addClass('hidden');
                            } else {
                                $navigation.children('.ellipsis-button[data-page="ellipsis-prev"]').removeClass('hidden');
                            }

                            dataFx();
                        }
                    });
                });
            }

            // Paged table are hidden by default
            // in the CSS, this will show the paged
            // table on load of the document
            $table.delay(500).slideDown(150);
        });
        
    }
};



var nl2br = function (my_string) {
    // Equivalent to PHP function nl2br()
    return (my_string + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+'<br />'+'$2');
};



var debug = function (debugContents) {
    if ($('#system-debug-js').length < 1) {
        var debugHtml = '<div id="system-debug-js">'
            +'This is for debugging javascript values'
            +'<span id="system-debug-js-btn-close">x</span>'
            +'<div class="hr-light"></div>'
            +'<div id="system-debug-js-contents"></div>'
            +'</div>';
        $('body').append(debugHtml);

        var $debugContainer = $('#system-debug-js')
            ,$debugCloseBtn = $('#system-debug-js-btn-close')
            ,$debugContents = $('#system-debug-js-contents');

        $debugContainer.css({
            'display': 'inline-block'
            ,'padding': '13px 18px'
            ,'position': 'fixed'
            ,'top': '2px'
            ,'left': '2px'
            ,'z-index': '999999'
            ,'border': '1px solid #ccc'
            ,'background': '#fff'
            ,'box-shadow': '2px 2px 2px rgba(0, 0, 0, 0.25)'
            ,'text-align': 'left'
        });

        $debugContents.css({
            'display': 'inline-block'
            ,'padding': '3px 5px'
        });

        $debugCloseBtn.css({
            'display': 'inline-block'
            ,'width': '15px'
            ,'height': '15px'
            ,'margin': '0px 0px 5px 5px'
            ,'padding': '8px'
            ,'float': 'right'
            ,'border': '1px solid rgba(0, 0, 0, 0.5)'
            ,'background': 'rgba(0, 0, 0, 0.35)'
            ,'cursor': 'pointer'
            ,'color': '#fff'
            ,'text-align': 'center'
        }).click(function () {
            $debugContainer.remove();
        });

        $debugContents.html(debugContents);
    } else {
        var $debugContents = $('#system-debug-js-contents');
        $debugContents.html(debugContents);
    }
};



var draggable = function ($this) {
    $this.mousedown(function (event) {
        var clickedButton = event.which;
        if (parseInt(clickedButton) == 1) {
            var differenceX =
                    parseInt(event.pageX)
                    - parseInt($this.offset().left)
                ,differenceY =
                    parseInt(event.pageY)
                    - parseInt($this.offset().top);

            $(document).mousemove(function (eventt) {
                var cursorX = parseInt(eventt.pageX)
                    ,cursorY = parseInt(eventt.pageY)
                    ,valueTop = cursorY - differenceY
                    ,valueLeft = cursorX - differenceX;

                $this.css({
                    'position': 'absolute'
                    ,'top': valueTop + 'px'
                    ,'left': valueLeft + 'px'
                });
            });

            $this.mouseup(function () {
                $(document).unbind('mousemove');
            });
        }
    });
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