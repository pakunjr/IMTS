$(document).ready(function () {

    //Alerts
    if ($('form').length > 0) {
        $('form').each(function () {
            var $this = $(this)
                ,$btnSubmit = $this.find('input[type="submit"]');

            if ($this.hasClass('main-form')) {
                $btnSubmit.on('click', function () {
                    myConfirm('Submit this form?<div class="hr"></div><span style="color: #03f;">Note: Please make sure that all information you have entered is correct.</span>', function () {
                        $this.submit();
                    });
                    return false;
                });
            }
        });
    }

});