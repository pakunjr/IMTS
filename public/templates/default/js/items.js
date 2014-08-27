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

});