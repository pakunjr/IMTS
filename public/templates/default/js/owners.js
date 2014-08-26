$(document).ready(function () {

    if ($('.owner-data').length > 0) {
        $('.owner-data').each(function () {
            var $this = $(this)
                ,url = $this.attr('data-url');

            $this.on('click', function () {
                window.location = url;
            });
        });
    }

});