$(document).ready(function () {

    if ($('#main-navigation .sub-menu').length > 0) {
        $('#main-navigation').find('.sub-menu').each(function () {
            var $this = $(this)
                ,$trig = $this.parent('li');

            $this.css({
                'top': ($trig.offset().top + $trig.height() - 1) + 'px'
            }).stop(true, true).slideUp(0);

            $(window).on('resize', function () {
                $this.css('top', ($trig.offset().top + $trig.height() - 1) + 'px');
            });

            $trig.hover(function () {
                $this.show(0);
                // $this.stop(true, true).slideDown(250);
            }, function () {
                $this.hide(0);
                /*
                if (!$this.is(':hover'))
                    $this.stop(true, true).slideUp(150);
                else
                    $this.stop(true, true).slideUp(150);
                */
            });
        });
    }

});