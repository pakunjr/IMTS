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
                    if ($('a:hover').length < 1)
                        window.location = url;
                });
            }
        });
    }

});