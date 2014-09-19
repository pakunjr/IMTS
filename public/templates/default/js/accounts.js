$(document).ready(function () {

    /**
     * Place confirm alert popups on selected
     * buttons under the account module
     */
    if ($('input[value="Deactivate Account"]').length > 0) {
        $('input[value="Deactivate Account"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to Deactivate this account?', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

    if ($('input[value="Activate Account"]').length > 0) {
        $('input[value="Activate Account"]').each(function () {
            var $this = $(this)
                ,url = $this.parent('a').attr('href');
            $this.on('click', function () {
                myConfirm('Do you want to Activate this account?', function () {
                    window.location = url;
                });
                return false;
            });
        });
    }

});