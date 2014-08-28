$(document).ready(function () {

    if ($('.item-component-data').length > 0) {
        $('.item-component-data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url');

            $this.click(function () {
                window.location = url;
            });
        });
    }

    if ($('#search-box-container').length < 1
        && $('.data').length > 0) {
        $('.data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url');

            $this.addClass('special-hover').on('click', function () {
                window.location = url;
            });
        });
    }

});