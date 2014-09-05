$(document).ready(function () {

    //Alerts
    if ($('form').length > 0) {
        $('form').each(function () {
            var $this = $(this)
                ,$btnSubmit = $this.find('input[type="submit"]');

            if ($this.hasClass('main-form')) {
                $btnSubmit.on('click', function () {
                    myConfirm('Do you want to save / update the information into / from the system?', function () {
                        $this.submit();
                    });
                    return false;
                });
            }
        });
    }

});