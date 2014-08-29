$(document).ready(function () {

    if ($('#search-box-container').length < 1
        && $('.data').length > 0) {
        $('.data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url');

            if (!$this.hasClass('disabled')) {
                $this.addClass('special-hover').on('click', function () {
                    window.location = url;
                });
            }
        });
    }

});