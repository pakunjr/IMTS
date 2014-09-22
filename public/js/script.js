/**
 * Equivalent of nl2br function in php
 * on javascript / jQuery platform
 */
var nl2br = function (my_string) {
    return (my_string + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+'<br />'+'$2');
};



/**
 * Changes the layout of dates
 * from the format xxxx-xx-xx to
 * words, Month Day, Year (Jan 01, 2014)
 */
var dateToWords = function (my_date) {
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

    /**
     * Set settings for datepicker that will be
     * the default
     */
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

    /**
     * Redirect datas to the URL that were specified
     * in the attribute `data-url` when clicked
     *
     * Also check if the data is not related to any
     * embed search to avoid conflicts and undesirable
     * errors
     */
    if ($('#search-box-container').length < 1
            && $('.data').length > 0) {
        $('.data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url')
                ,$childHyperlinks = $this.children('a');

            if (!$this.hasClass('disabled')) {
                $this.addClass('special-hover').on('click', function () {
                    /**
                     * Check for hovered hyperlinks to avoid
                     * clicking hyperlinks that open in new
                     * window and redirecting the parent or
                     * current window
                     */
                    if ($('a:hover').length < 1
                        && $('.data-more-details:hover').length < 1)
                        window.location = url;
                });
            }
        });
    }



    /**
     * Shows more information / datas regarding
     * the concerned identity upon mouse hover
     */
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
                ,'background-color': 'rgba(0, 0, 0, 0.4)'
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

});